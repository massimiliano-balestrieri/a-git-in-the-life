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
 * $Id: processqueuebatch_helper.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/processqueuebatch_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class ProcessqueuebatchHelper extends ProcessqueuebaseHelper{

	private $_one_step = false;
	private $_in_batch = false;
	
	private $_processed = -1;//if failed 
	
	//5 _check_num_per_batch # if num_per_batch = -1 | step _end (help 3)
	//4 _start_message_subprocess # we know a user
	//2 _load_messages # we know the messages to process
	//1 _start_batch # we are active 
	private $_script_stage = 0;
	
	
	public function __construct(){
		$this->_init();
	}
	protected function _step(){
		$this->_one_step = true;
		$this->_batch();
	}
	public function queue($reload = false) {
		$this->_in_batch = true;
		$this->_batch();
	}
	public function nothingtodo(){
		$this->_pq->_helper_polling->reset_polling();
		$this->_script_stage = 6; # we are done
		$this->_logger('Script stage : 6 DONE - nothing to do',  P_LEV_HIGH);
		die();//finish batch
	}
	public function limit_reached(){
		$this->_script_stage = 5;
		$this->_logger('Script stage (limit reached): 5',  P_LEV_HIGH);
		//TODO: delay? $this->_wait = $this->_batch_period;
		die();//finish batch
	}
	//////////////SHUTDOWN/////////////////////////
	protected function _finish(){
		
		//no polling
		if($this->_in_batch || $this->_one_step){
			$this->_pq->_helper_lock->release_lock();
			$this->_help_shutdown_batch_and_step();
		}
		//in batch ? finish
		
		$this->_logger('Exit', P_LEV_INTER);
		exit;
	}
	private function _help_shutdown_batch_and_step(){
		$totaltime = $this->_pq->_processqueue_timer->elapsed(1);
		
		$nothingtodo = false;
		if (!$this->_processed) {
			$this->_logger('Finished, Nothing to do',  P_LEV_HIGH);
			$nothingtodo = 1;
		}
		
		#if (!$GLOBALS["commandline"]) {
		## blocco barra_js
  		#print '<script language="Javascript" type="text/javascript"> finish(); </script>';
  		
		//_help_shutdown_batch_and_step
		
		$subject = "Maxlist Processing info";
  		if (!$nothingtodo)
    		$this->_logger('Finished this run',  P_LEV_HIGH);
  		if (!TEST && !$nothingtodo)
    		;//TODO:sendReport($subject,$this->_report);
    		
    	//polling
		$this->_logger('---------- Shutdown ------------', P_LEV_INTER);
		#output( "Script status: ".connection_status(),0); # with PHP 4.2.1 buggy. http://bugs.php.net/bug.php?id=17774
		$this->_logger('Script stage: '.$this->_script_stage,  P_LEV_INTER);
		//global $report,$send_process_id,$tables,$nothingtodo,$invalid,$processed,$failed_sent,$notsent,$sent,$unconfirmed,$num_per_batch,$batch_period;
		
		//stat batch
		$this->_pq->_helper_stat->log_stat($totaltime);
			
		if ($this->_script_stage < 5 && !$nothingtodo) {
			$this->_logger('Warning: script never reached stage 5. This may be caused by a too slow or too busy server ' .$totaltime,  P_LEV_LOW);
		}
		elseif ($this->_script_stage == 5 && (!$nothingtodo || $this->_wait)) {
			# if the script timed out in stage 5, reload the page to continue with the rest
			$this->_reload++;
			$this->_pq->_helper_stat->log_shutdown_stage_5();
			#print '<script language="Javascript" type="text/javascript">alert(document.location)</script>';
		}
		elseif ($this->_script_stage == 6) {
			$this->_logger('Finished, All done',  P_LEV_HIGH);
		} else {
			$this->_logger($this->_('Script finished, but not all messages have been sent yet.'),  P_LEV_LOW);
		}
				
  		
		
		
	}
	//batch
	private function _batch() {
		global $APP;
		
		//shortcut
		$msg = $this->_pq->_helper_msg;
		$user = $this->_pq->_helper_user;
		
		//polling
		$this->_pq->_helper_polling->set_polling();
		
		//stat
		$this->_pq->_helper_polling->stat_lastpoll();

		//lock
		$this->_pq->_helper_lock->init_lock();//TODO:
		
		//config
		$this->_pq->_helper_conf->init_conf();
		$this->_script_stage = 1; # we are active
		$this->_logger('Script stage : 1 OK',  P_LEV_INTER);
		
		//messages
		$msg->load();
		$messages = $msg->messages;
		$num_messages = $msg->num_messages;
		$this->_script_stage = 2; # we know the messages to process
		$this->_logger('Script stage : 2 OK',  P_LEV_INTER);
		
		
		$x = 1;
		
		//users total
		$user->set_totalusers_per_messages($messages);
		
		foreach ($messages as $message) {
			$last = ($x == $num_messages);
			
			$this->_pq->_helper_mailer->notify();
			
			$this->_pq->_helper_throttle->reset_counter();
			
			$msg->reset_message();
			$msg->set_message($message);
			
			$user->load($message, $last);
			$userids = $user->userids;
			$num_users = $user->num_users;
			if(is_array($userids))
				foreach ($userids as $userid) {
					$msg->process_message($userid);
					
					$check = $msg->check_user_message();	
					$this->_script_stage = 4; # we know a user
					$this->_logger('Script stage : 4 OK',  P_LEV_INTER);	
					
					if($check){
						
						//qui stabilisco se posso inviare
						$this->_pq->_helper_throttle->check_domain_throttle($msg->get_email_inprocess());
						if (!$msg->can_send()) {
							$msg->cannotsend();
						} else {
							$msg->send_message();
							$this->_script_stage = 5; # we have actually sent one user
							$this->_logger('Script stage : 5 OK',  P_LEV_INTER);	
							
							$this->_pq->_helper_throttle->delay();
							$msg->end_send_message();
						}
						
					
					}
				}
			
			$this->_pq->_helper_stat->log_statpoll($num_users);
			$msg->end_process_message();	
			$x++;
		}
		
	}
	

}


	