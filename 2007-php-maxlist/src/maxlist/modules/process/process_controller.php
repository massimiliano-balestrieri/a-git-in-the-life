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
 *
 * Maxlist is a fork of PhpList, a newsletter manager. 
 * The code was deeply changed so there are features of the original phpList and new ones. 
 * It uses smarty, generates XHTML strict, uses an AJAX layer, italian language ,
 * multi-istance, and use case based.
 *
 * 
 * $Id: process_controller.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/process/process_controller.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class ProcessController extends ModuleController implements IModuleController{
	
	public function __construct(){
		
		//TODO : check_role -  
		//$this->_check_role_view('admin');
		
		//TODO: actions,ajax, roles
		//params
		$params = array(
					'pg' 	=> array('t' => 'int', 'd' => 1),
					'block' => array('t' => 'int', 'd' => 1),
					'do'=> array('in' => '', 'm' => 'post'),//TODO : options in
					'confirm'=>array('m' => 'post')
		);
		
		
		$this->_check_params($params);

		//istance model
		//$this->_model = new ProcessModel();  
		
		$this->_do();
		
		$this->_routing();
		
		if(TEST)
			$this->_info($this->_('Running in testmode, no emails will be sent. Check your config file.'));

		
	}
	//POST
	###test
	protected function _polling(){
		global $APP;
		$APP->get_model2('processqueue')->polling();
		exit();
	}
	protected function _reset_polling(){
		global $APP;
		$APP->get_model2('processqueue')->reset_polling();
		exit();
	}
	protected function _unlock(){
		global $APP;
		$APP->get_model2('processqueue')->unlock();
		exit();
	}
	protected function _locka(){
		global $APP;
		$APP->get_model2('processqueue')->lock();
		exit();
	}
	protected function _unlock2(){
		global $APP;
		$APP->get_model2('processbounce')->unlock();
		exit();
	}
	protected function _locka2(){
		global $APP;
		$APP->get_model2('processbounce')->lock();
		exit();
	}
	protected function _reset(){
		global $APP;
		if(DEV_EMAIL){
			$data = $APP->get_model2('processqueue')->reset_messages();
		}
		exit();
	}
	protected function _truncate(){
		global $APP;
		if(DEV_EMAIL){
			$data = $APP->get_model2('processqueue')->reset_data();
		}
		exit();
	}
	###fine test
	
	//batch
	protected function _step(){
		global $APP;
		$data = $APP->get_model2('processqueue')->step();
		die;
	}
	protected function _batch(){
		global $APP;
		//$data = $APP->get_model2('processqueue')->queue();
		die;
	}
	protected function _process_bounces(){
		global $APP;
		$data = $APP->get_model2('processbounce')->process();
		die;
	}
	//fake get ajax. do post
	protected function _ajaxbatch(){
		exit();
	}
	//GET
	protected function _queue(){
		global $APP;
		$data = $APP->get_model2('message')->get_messages_tosend();
		$this->tpl = 'processqueue';
		new ProcessView($this->_params, $data);	
	}
	protected function _bounces(){
		global $APP;
		//$data = $APP->get_model2('message')->get_messages_tosend();
		$this->tpl = 'bounces';
		new ProcessView($this->_params, array());	
	}
	private function _temp(){//TODO:
		# once and for all get rid of those questions why they do not receive any emails :-)
		if (TEST_PROCESS) {
			addPublicInfo('Running in test process mode, no emails will be sent. Check your config file.');
			addPublicInfo('Running in test process mode, not deleting messages from mailbox');
		}
		
	}
	private function _check_commandline_queue(){//TODO:
		return true;
		if (!MANUALLY_PROCESS_QUEUE) {
			print "This page can only be called from the commandline";
			return;
		}else{
			@ ob_end_clean();
			print ClineSignature();
			ob_start();			
		}
	}
	private function _check_commandline_bounces(){//TODO:
		return true;
		if (!$GLOBALS["commandline"]) {
		  @ob_end_flush();
		  if (!MANUALLY_PROCESS_BOUNCES) {
		    print $APP->I18N->_("This page can only be called from the commandline");
		    return;
		  }
		} else {
		  @ob_end_clean();
		  print ClineSignature();
		  @ob_start();
		}
	}
	
	private function validate_processbounce(){
	}
	private function validate_pop(){
		if (!BOUNCE_MAILBOX && (!BOUNCE_MAILBOX_HOST || !BOUNCE_MAILBOX_USER || !BOUNCE_MAILBOX_PWD)) {
		  print('Bounce mechanism not properly configured');
		  exit;
		}
	}
	private function validate_imap(){
		if (!function_exists('imap_open') && !USE_PEAR_NO_IMAP_EXT) {
		  print('IMAP is not included in your PHP installation, cannot continue <a href="http://www.php.net/manual/en/ref.imap.php">http://www.php.net/manual/en/ref.imap.php</a>');
		  exit;
		}
	}
}
