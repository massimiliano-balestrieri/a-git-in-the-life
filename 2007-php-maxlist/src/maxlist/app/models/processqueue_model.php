<?php


/***
 * Project: Maxlist <br />
 * Copyright (C) 2007 Massimiliano Balestrieri
 * 
 * Software based on : 
 * PHPlist, Mailinglist system using PHP and Mysql
 * Copyright (C) 2000,2001,2002,2003,2004,2005 Michiel Dethmers, tincan ltd
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Maxlist is a fork of PhpList, a newsletter manager. 
 * The code was deeply changed so there are features of the original phpList and new ones. 
 * It uses smarty, generates XHTML strict, uses an AJAX layer, italian language ,
 * multi-istance, and use case based.
 *
 * Maxlist is a fork of PhpList, a newsletter manager. 
 * The code was deeply changed so there are features of the original phpList and new ones. 
 * It uses smarty, generates XHTML strict, uses an AJAX layer, italian language ,
 * multi-istance, and use case based.
 *
 * 
 * $Id: processqueue_model.php 393 2008-01-18 18:09:49Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 393 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/processqueue_model.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 */

define('PROCESS_QUEUE_VERBOSITY', 1);//tutti i log
define('PROCESS_QUEUE_LOGEVENT_LEVEL', 1);


 
class ProcessqueueModel extends ModuleModel {

	//helper (protected access helpers)
	protected $_helper_base = false;
	protected $_helper_session = false;
	protected $_helper_lock = false;
	protected $_helper_batch = false;
	protected $_helper_log = false;
	protected $_helper_stat = false;
	protected $_helper_polling = false;
	protected $_helper_conf = false;
	protected $_helper_msg = false;
	protected $_helper_throttle = false;
	protected $_helper_user = false;
	protected $_helper_mailer = false;
	
	//join (protected access helpers)
	protected $_join_usermessage = false;
	protected $_join_message = false;
	protected $_join_user = false;
	protected $_join_messagedata = false;
	protected $_join_sendmail = false;
	
	
	//timer
	protected $_processqueue_timer = false;
	
	
	public function __construct($params = false) {
		//timer
		$this->_processqueue_timer = new MaxTimerHelper();
		
		$this->_name = 'processqueue';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
		
		global $APP;
		//link to APP
		$APP->MODEL = $this;
		
		$this->_init_join();
		
		$this->_init_helpers();
	}
	//STATIC
	public static function shutdown () {
  		#$this->_logger( "Script status: ".connection_status(),0); # with PHP 4.2.1 buggy. http://bugs.php.net/bug.php?id=17774
		//( $this->_('Script stage').': '.$script_stage,0);
		global $APP;
		//print_r($APP->MODULE->model);	die;
		$APP->MODEL->finish();
	}
	//PUBLIC
	public function step($reload = false) {
		$this->_helper_batch->_step();
	}
	
	//TEST_PROCESS methods 
	public function reset_data(){
		if(!TEST_PROCESS) return;	
		global $APP;
		$APP->DB->execute('TRUNCATE `default_user_user_attribute`');
		$APP->DB->execute('TRUNCATE `default_user_attribute`');
		$APP->DB->execute('TRUNCATE `default_adminattribute`');
		$APP->DB->execute('TRUNCATE `default_admin_attribute`');
		
		$APP->DB->execute('TRUNCATE `default_attachment`');
		$APP->DB->execute('TRUNCATE `default_bounce`');
		$APP->DB->execute('TRUNCATE `default_eventlog`');
		$APP->DB->execute('TRUNCATE `default_listmessage`');
		$APP->DB->execute('TRUNCATE `default_message`');
		$APP->DB->execute('TRUNCATE `default_messagedata`');
		$APP->DB->execute('TRUNCATE `default_message_attachment`');
		$APP->DB->execute('TRUNCATE `default_usermessage`');
		$APP->DB->execute('TRUNCATE `default_userstats`');
		$APP->DB->execute('TRUNCATE `default_user_user`');
		$APP->DB->execute('TRUNCATE `default_user_user_history`');
		$APP->DB->execute('TRUNCATE `default_user_message_bounce');
		$APP->DB->execute('TRUNCATE `default_listuser`');
		$APP->DB->execute('TRUNCATE `default_user_blacklist`');
		$APP->DB->execute('TRUNCATE `default_user_blacklist_data`');
		$APP->DB->execute('TRUNCATE `default_sendprocess');
		$this->_logger('Reset usermessage and set status submitterd',  P_LEV_LOW);
	}
	public function reset_messages(){
		if(!TEST_PROCESS) return;	
		global $APP;
		$APP->DB->execute('update default_message set status = "submitted"');
		$APP->DB->execute('TRUNCATE `default_usermessage`');
		$this->_logger('Reset usermessage and set status submitterd',  P_LEV_LOW);
	}
	public function lock(){
		if(!TEST_PROCESS) return;	
		# check for other processes running
		$this->_helper_lock->init_lock();
	}
	public function unlock(){
		if(!TEST_PROCESS) return;	
		//$this->_process_id = $this->_get_lock();
		$this->_helper_lock->release_lock();
	}
	public function polling(){
		if(!TEST_PROCESS) return;	
		$this->_helper_polling->set_polling();
	}
	public function reset_polling(){
		if(!TEST_PROCESS) return;	
		$this->_helper_polling->reset_polling();
	}
	
	//////////////SHUTDOWN/////////////////////////
	public function finish(){
		//delegate helper batch
		$this->_helper_batch->_finish();
	}
	//INHERITED METHODS
	//log
	protected function _logger($msg, $verb_level) {
		global $APP;
		//$infostring = "[". date("D j M Y H:i",time()) . "] [" . $_SERVER["REMOTE_ADDR"] ."]";
		if($verb_level <= PROCESS_QUEUE_VERBOSITY)
			print "$msg <br/><br/>";
		$this->_helper_log->_arrlog[] = $msg;
		
		if($verb_level <= PROCESS_QUEUE_LOGEVENT_LEVEL)//TODO: test
			$APP->MSG->watchdog(LOG_LEVEL, $msg);
	}
	
	//PRIVATE
	//private composite helpers
	private function _init_helpers(){
		global $APP;
		$this->_helper_base = $APP->get_helper('processqueuebase');
		$this->_helper_session = $APP->get_helper('processqueuesession');
		
		$this->_helper_lock = $APP->get_helper('processlock','processqueue');
		$this->_helper_lock->configure(PROCESS_QUEUE_VERBOSITY, PROCESS_QUEUE_LOGEVENT_LEVEL);
		
		$this->_helper_log = $APP->get_helper('processqueuelog');
		$this->_helper_polling = $APP->get_helper('processqueuepolling');
		$this->_helper_stat = $APP->get_helper('processqueuestat');
		$this->_helper_conf = $APP->get_helper('processqueueconf');
		$this->_helper_msg = $APP->get_helper('processqueuemsg');
		$this->_helper_throttle = $APP->get_helper('processqueuethrottle');
		$this->_helper_user = $APP->get_helper('processqueueuser');
		$this->_helper_mailer = $APP->get_helper('processqueuemailer');
		
		$this->_helper_batch = $APP->get_helper('processqueuebatch');
	}
	private function _init_join(){
		global $APP;
		$this->_join_usermessage = $APP->get_model2('usermessage');
		$this->_join_message = $APP->get_model2('message');
		$this->_join_user = $APP->get_model2('user');
		$this->_join_messagedata = $APP->get_model2('messagedata');
		$this->_join_sendmail = $APP->get_model2('sendmail');
	}
}
//register_shutdown_function(array("ProcessqueueModel","shutdown"));