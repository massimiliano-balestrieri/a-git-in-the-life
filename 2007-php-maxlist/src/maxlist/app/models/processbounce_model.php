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
 * $Id: processbounce_model.php 395 2008-01-18 18:55:07Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:55:07 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 395 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/processbounce_model.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:55:07 +0000 (Fri, 18 Jan 2008) $
 */

define('PROCESS_BOUNCE_VERBOSITY', 4);//tutti i log
define('PROCESS_BOUNCE_LOGEVENT_LEVEL', 4);

define('TEST_ONLY_BATCH',0);

class ProcessbounceModel extends ModuleModel {
	
	//helper (protected access helpers)
	protected $_helper_base = false;
	protected $_helper_lock = false;
	protected $_helper_batch = false;
	
	//join
	protected $_join_userhistory = false;
	protected $_join_user = false;
	protected $_join_bounce = false;
	protected $_join_message = false;
	protected $_join_usermessagebounce = false;
	
	public function __construct($params = false) {
		//$this->_name = 'scaffold';
		//$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
		
		//error_reporting NO_STRICT
		
		global $APP;
		//link to APP
		$APP->MODEL = $this;
		
		$this->_init_helpers();

		$this->_init_join();
	}
	//STATIC
	public static function shutdown () {
  		global $APP;
		$APP->MODEL->finish();
	}
	//PUBLIC
	public function process() {
		//register_shutdown_function("my_shutdown");
		//$process_id = getPageLock();
		if(!IMAP_EXT)
			$this->_require_zend_mail();//$this->_require_pop3_lib();
				
		$this->_helper_batch->_process();
		
	}
	//TEST_PROCESS methods 
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
		if($verb_level <= PROCESS_BOUNCE_VERBOSITY)
			print "$msg <br/><br/>";
		$this->_helper_log->_arrlog[] = $msg;
		
		if($verb_level <= PROCESS_BOUNCE_LOGEVENT_LEVEL)//TODO: test
			$APP->MSG->watchdog(LOG_LEVEL, $msg);
	}
	//PRIVATE
	//private composite helpers
	private function _init_helpers(){
		global $APP;
		$this->_helper_base = $APP->get_helper('processbouncebase');
	
		$this->_helper_lock = $APP->get_helper('processlock', 'processbounce');
		$this->_helper_lock->configure(PROCESS_BOUNCE_VERBOSITY, PROCESS_BOUNCE_LOGEVENT_LEVEL);
	
		$this->_helper_batch = $APP->get_helper('processbouncebatch');
	}
	private function _init_join(){
		global $APP;
		$this->_join_usermessagebounce = $APP->get_model2('usermessagebounce');
		$this->_join_message = $APP->get_model2('message');
		$this->_join_user = $APP->get_model2('user');
		$this->_join_userhistory = $APP->get_model2('userhistory');
		$this->_join_bounce = $APP->get_model2('bounce');
	}
	private function _require_zend_mail(){
		require_once DIR_ZEND . 'Zend/Mail.php';
		require_once DIR_ZEND . 'Zend/Mail/Storage/Pop3.php';
		
	}
	//@@deprecated
	private function _require_pop3_lib(){
		if(TEST_PROCESS)
			error_reporting(E_ALL);
		else
			error_reporting(E_ERROR);
		
		@require_once DIR_POP3 . '/pop3.php';//imap?
	}
}
register_shutdown_function(array("ProcessbounceModel","shutdown"));