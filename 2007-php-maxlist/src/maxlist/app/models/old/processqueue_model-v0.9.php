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
 * $Id: processqueue_model-v0.9.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/old/processqueue_model-v0.9.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

define('INTERACTIVE',1);
define('PROCESS_QUEUE_VERBOSITY', 1);//tutti i log
define('PROCESS_QUEUE_LOGEVENT_LEVEL', 1);

define('P_LEV_HIGH',3);
define('P_LEV_MEDIUM',2);
define('P_LEV_LOW',1);


class ProcessqueueModel extends ModuleModel {
	
	//5 _check_num_per_batch # if num_per_batch = -1 | step _end (help 3)
	//4 _start_message_subprocess # we know a user
	//2 _load_messages # we know the messages to process
	//1 _start_batch # we are active 
	private $_script_stage = 0;
	
	//log
	private $_arrlog = array ();
	
	//helper
	private $_helper_session = false;
	//join
	private $_join_sendprocess = false;
	private $_join_usermessage = false;
	private $_join_message = false;
	private $_join_user = false;
	private $_join_messagedata = false;
	private $_join_sendmail = false;
	
	//process
	private $_process_id = false;
	
	//counter
	private $_sent = 0;
	private $_notsent = 0;
	private $_invalid = 0;
	private $_unconfirmed = 0;
	private $_cannotsend = 0;
	private $_failed_sent = 0;
	private $_throttlecount = 0;
	
	//batch
	private $_reload = false;
	private $_one_step = false;
	private $_in_batch = false;
	//private $_lastsent = 0;
	//private $_lastskipped = 0;
	
	//var batch
	private $_original_num_per_batch = 0;
	private $_num_per_batch = 0;
	private $_maxbatch = -1;//why -1
	private $_batch_period = 0;
	private $_minbatchperiod = -1;
	private $_recently_sent = 0;
	private $_safemode = false;
	private $_batch_total = 0;//num_users
	private $_someusers = false;
	 
	//domain throttle
	private $_domainthrottle = array();
	private $_dt_interval = false;
	private $_running_throttle_delay = false;
	private $_throttled = false;//flag
	
	
	//model
	private $_messageid = false;
	private $_message = false;
	private $_num_messages = false;
	private $_messages = false;
	
	private $_userids = false;
	private $_num_users = 0;
	
	private $_rssitems = false;
	
	private $_userid = false;
	private $_user_email = false;
	private $_user_uniqid = false;
	private $_user_htmlemail = false;
	private $_user_confirmed = 0;
	private $_user_blacklisted = 0;
	
	//user query
	private $_sub_userconfirmed = false;
	private $_sub_exclusion = false;
	private $_sub_user_attribute_query = false;
	
	//esiti
	private $_processed = -1;//if failed 
	private $_wait = false;
	
	//flag
	private $_flag_cansend = false;
	
	
	//timer
	private $_processqueue_timer = false;
	
	public function __construct($params = false) {
		$this->_name = 'processqueue';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
		
		global $APP;
		$this->_join_sendprocess = $APP->get_model2('sendprocess');
		$this->_join_usermessage = $APP->get_model2('usermessage');
		$this->_join_message = $APP->get_model2('message');
		$this->_join_user = $APP->get_model2('user');
		$this->_join_messagedata = $APP->get_model2('messagedata');
		$this->_join_sendmail = $APP->get_model2('sendmail');
		
		$this->_helper_session = $APP->get_helper('processqueuesession');
		
		//link to APP
		$APP->MODULE->model = $this;
		//timer
		$this->_processqueue_timer = new MaxTimerHelper();
	}
	//debug
	public function reset_messages(){
		if(!TEST_PROCESS) return;	
		global $APP;
		$APP->ADODB_LITE->execute('update default_message set status = "submitted"');
		$APP->ADODB_LITE->execute('TRUNCATE `default_usermessage`');
		$this->_logger('Reset usermessage and set status submitterd',  P_LEV_LOW);
	}
	public function reset_data(){
		if(!TEST_PROCESS) return;	
		global $APP;
		$APP->ADODB_LITE->execute('TRUNCATE `default_attachment`');
		$APP->ADODB_LITE->execute('TRUNCATE `default_bounce`');
		$APP->ADODB_LITE->execute('TRUNCATE `default_eventlog`');
		$APP->ADODB_LITE->execute('TRUNCATE `default_listmessage`');
		$APP->ADODB_LITE->execute('TRUNCATE `default_message`');
		$APP->ADODB_LITE->execute('TRUNCATE `default_messagedata`');
		$APP->ADODB_LITE->execute('TRUNCATE `default_message_attachment`');
		$APP->ADODB_LITE->execute('TRUNCATE `default_usermessage`');
		$APP->ADODB_LITE->execute('TRUNCATE `default_userstats`');
		$APP->ADODB_LITE->execute('TRUNCATE `default_user_blacklist`');
		$APP->ADODB_LITE->execute('TRUNCATE `default_user_blacklist_data`');
		$APP->ADODB_LITE->execute('TRUNCATE `default_sendprocess');
		$this->_helper_session->reset_polling();
		$this->_logger('Reset usermessage and set status submitterd',  P_LEV_LOW);
	}
	public function lock(){
		if(!TEST_PROCESS) return;	
		# check for other processes running
		$this->_process_id = $this->_lock();//TODO:
	}
	public function unlock(){
		if(!TEST_PROCESS) return;	
		$this->_process_id = $this->_get_lock();
		$this->_release_lock();
	}
	public function polling(){
		if(!TEST_PROCESS) return;	
		$this->_set_polling();
	}
	public function reset_polling(){
		if(!TEST_PROCESS) return;	
		$this->_helper_session->reset_polling();
		$this->_logger('Reset polling',  P_LEV_LOW);
	}
	public function step($reload = false) {
		$this->_one_step = true;
		$this->_batch();
	}
	public function queue($reload = false) {
		$this->_in_batch = true;
		$this->_batch();
	}
	//batch
	private function _batch() {
		
		//polling
		$this->_set_polling();
		
		//stat
		$this->_stat();

		//lock
		$this->_process_id = $this->_lock();//TODO:
		
		//step0
		$this->_step_1_start_batch();
		
		$this->_step_2_load_messages();
		
		$x = 1;
		
		foreach ($this->_messages as $message) {
			
			$last = ($x == $this->_num_messages);
			
			$this->_throttlecount = 0;
			
			$this->_step_3_set_users($message, $last);
		
			if(is_array($this->_userids))
				foreach ($this->_userids as $userid) {
					$this->_step_4_process_message($userid);
					
					$check = $this->_step_5_check_user_message();	
					
					if($check){

						$this->_step_6_can_send();
						//$throttled = 0;
						$this->_step_7_use_domain_throttle();

						if (!$this->_flag_cansend) {
							$this->_step_8_cannot_send();
						} else {
							$this->_step_9_send_message();
							
							$this->_step_10_end_send_message();
						}
						
					
					}
				}
			
			$this->_step_11_end_process_message();	
			$x++;
		}
		
	}
	//STEP 11
	private function _step_11_end_process_message() {
		//$this->_failed_sent++;$this->_num_users++;//test
		$this->_processed = $this->_notsent + $this->_sent + $this->_invalid + $this->_unconfirmed + $this->_cannotsend + $this->_failed_sent;
		$this->_logger('End - Processed ' . $this->_processed . ' out of ' . $this->_num_users . ' users', P_LEV_LOW);
		# this message is done
		//	$this->_repeat_message(); ? 
		
		if(0)//se il messaggio è stato inviato a tutti gli utenti	
		$this->_join_message->set_sent($this->_messageid);
		
		if(0)//se il messaggio è stato inviato a tutti gli utenti	
		$this->_step_11_1_notify_end();
		
		if(0){//se il messaggio è stato inviato a tutti gli utenti	
			$timetaken = $this->_join_message->get_timetaken($this->_messageid);
			$this->_logger('It took ' . $this->_helper_statistic->time_diff($timetaken[0], $timetaken[1]) . ' to send this message', P_LEV_LOW);
		}
		if(0)//se il messaggio è stato inviato a tutti gli utenti	
		$this->_step_11_2_send_message_stats($this->_messageid);
	}
	//step 11 subprocess
	private function _step_11_2_send_message_stats(){
	//TODO	
//		if (defined("NOSTATSCOLLECTION") && NOSTATSCOLLECTION) {
//		return;
//		 }
//		$stats_email = $GLOBALS["stats_email"];
//		
//		$data = Sql_Fetch_Array_Query(sprintf('select * from %s where id = %d',
//		$tables["message"],$msgid));
//		$msg = "CSIlist version ".VERSION . "\n";
//		$diff = timeDiff($data["sendstart"],$data["sent"]);
//		
//		if ($data["id"] && $data["processed"] > 10 && $diff != "very little time") {
//		$msg .= "\n".'Time taken: '.$diff;
//		foreach (array('entered','processed',
//		'sendstart','sent','htmlformatted','sendformat','template','astext',
//		'ashtml','astextandhtml','aspdf','astextandpdf') as $item) {
//		$msg .= "\n".$item.' => '.$data[$item];
//		}
//		if ($data["processed"] > 500) {
//		mail("info@maxlist.net",NAME ." stats",$msg);
//		} else {
//		mail($stats_email,NAME ." stats",$msg);
//		}
//		}
	}
	private function _step_11_1_notify_end(){
		//if (@ $msgdata['notify_end'] && !isset ($msgdata['end_notified'])) {
		//	$notifications = explode(',', $msgdata['notify_end']);
		//	foreach ($notifications as $notification) {
		//		sendMail($notification, $this->_('Message Sending has finished'), sprintf($this->_('phplist has finished sending the message with subject %s'), $message['subject']));
		//	}
		//	Sql_Query(sprintf('insert ignore into %s (name,id,data) values("end_notified",%d,now())', $GLOBALS['tables']['messagedata'], $messageid));
		//}
	}
	//STEP 10
	private function _step_10_end_send_message(){
		//TODO:
		$reload = $affrows = 0;
		
		$this->_join_message->update_processed($this->_messageid);
		$this->_processed = $this->_notsent + $this->_sent + $this->_invalid + $this->_unconfirmed + $this->_cannotsend + $this->_failed_sent;
		if ($this->_processed % 10 == 0) {
		#if (0) {
			$this->_logger(	'AR?' . $affrows . 
							' NUSERS ' . $this->_num_users . 
							' PROCESSED' . $this->_processed . 
						   	' SENT ' . $this->_sent . 
							' N' . $this->_notsent . 
							' INVALID' . $this->_invalid . 
							' UNCONF' . $this->_unconfirmed . 
						   	' CANNOT' . $this->_cannotsend . 
							' FAILED' . $this->_failed_sent,  P_LEV_HIGH);
			$rn = $reload * $this->_num_per_batch;
			$this->_logger(' PROCESSED ' . $this->_processed . 
						   ' NUSERS' . $this->_num_users . 
						   ' NUM_PER_BATCH' . $this->_num_per_batch . 
						   ' BATCH_TOTAL' . $this->_batch_total . 
						   ' RELOAD' . $reload . 
						   ' RELOAD_X_MAX' . $rn,  P_LEV_HIGH);
		}
		$totaltime = $this->_processqueue_timer->elapsed(1);
		$msgperhour = (3600 / $totaltime) * $this->_sent;
		@ $secpermsg = $totaltime / $this->_sent;
		$timeleft = ($this->_num_users - $this->_sent) * $secpermsg;
		$eta = date('D j M H:i', time() + $timeleft);
		$this->_join_messagedata->set_messagedata($this->_messageid, 'ETA', $eta);
		$this->_join_messagedata->set_messagedata($this->_messageid, 'msg/hr', $msgperhour);
		$this->_join_messagedata->set_messagedata($this->_messageid, 'to process', $this->_num_users - $this->_sent);
	}
	//STEP 9
	private function _step_9_send_message(){
		$success = 0;
		if (!TEST) {
			if (!$this->_throttled) {
				$this->_logger('Sending message ' . $this->_messageid . ' to ' . $this->_user_email,  P_LEV_LOW);
				$timer = new MaxTimerHelper();
				//TODO: $this->_rssitems
				
				//per mandare un messaggio ho bisogno
				//1) messaggio
				$msg = $this->_join_message->get($this->_messageid);
				
				//2) questo dovrebbe +/- fare da cache TODO:fix
				$this->_join_sendmail->set($this->_user_uniqid, $msg);
				
				//3) invia la mail
	      		$success = $this->_join_sendmail->send_email($this->_messageid, $this->_user_email, $this->_user_uniqid, $this->_user_htmlemail);
	      		
				$this->_logger('It took ' . $timer->elapsed(1) . ' seconds to send',  P_LEV_MEDIUM);
			} else {
				$this->_throttlecount++;
			}
		} else {
			//TODO: $success = sendEmailTest($messageid, $useremail);
		}
		
		//ESITO:
		if ($success) {
			$this->_step_9_0_update_domain_throttle();
			$this->_step_9_1_success_send_email();//STEP 8 : sended
		} else {
			$this->_step_9_2_failed_send_email();
		}

		if ($this->_script_stage < 5) {
			$this->_script_stage = 5; # we have actually sent one user
			$this->_logger('Script stage : 5 OK',  P_LEV_HIGH);	
		}
		$this->_step_9_3_delay();
	
		# update possible other users matching this email as well,
		# to avoid duplicate sending when people have subscribed multiple times
		# bit of legacy code after making email unique in the database
		#        $emails = Sql_query("select * from {$tables['user']} where email =\"$useremail\"");
		#        while ($email = Sql_fetch_row($emails))
		#          Sql_query("replace into {$tables['usermessage']} (userid,messageid) values($email[0],$messageid)");
	} 
	//step 9 subprocess
	private function _step_9_3_delay(){
		if ($this->_running_throttle_delay) {
			//TODO: test
			$this->_logger('waited for (running_throttle_delay)' . $this->_running_throttle_delay . 'sec', P_LEV_HIGH);
			sleep($this->_running_throttle_delay);
			if ($this->_sent % 5 == 0) {
				# retry running faster after some more messages, to see if that helps
				//?unset ($running_throttle_delay);
			}
		}elseif (MAILQUEUE_THROTTLE) {
			$this->_logger('waited for (MAILQUEUE_THROTTLE)' . MAILQUEUE_THROTTLE . 'sec', P_LEV_HIGH);
			sleep(MAILQUEUE_THROTTLE);
		}elseif (MAILQUEUE_BATCH_SIZE && MAILQUEUE_AUTOTHROTTLE && $this->_sent > 10) {//sent 10
		
			$totaltime = $this->_processqueue_timer->elapsed(1);
			$msgperhour = (3600 / $totaltime) * $this->_sent;
			$msgpersec = $msgperhour / 3600;
			$secpermsg = $totaltime / $this->_sent;
			$target = MAILQUEUE_BATCH_SIZE / MAILQUEUE_BATCH_PERIOD;
			$actual = $this->_sent / $totaltime;
			$delay = $actual - $target;
			$this->_logger("Sent: {$this->_sent} mph $msgperhour mps $msgpersec secpm $secpermsg target $target actual $actual d $delay",P_LEV_LOW);
			if ($delay > 0) {
				$expected = MAILQUEUE_BATCH_PERIOD / $secpermsg;
				$delay = MAILQUEUE_BATCH_SIZE / $expected;
				$this->_logger('waiting for ' . $delay . ' seconds to make sure we don\'t exceed our limit of ' . MAILQUEUE_BATCH_SIZE . 
							   ' messages in ' . MAILQUEUE_BATCH_PERIOD . ' seconds', P_LEV_HIGH);
				$delay = $delay * 1000000;
				usleep($delay);
			}
		}
		
	}
	private function _step_9_2_failed_send_email(){
		$this->_failed_sent++;
		$this->_logger('Failed sending to' . $this->_user_email . ' messageid:' . $this->_messageid,  P_LEV_HIGH);
		# make sure it's not because it's an invalid email
		# unconfirm this user, so they're not included next time
		//TODO:
		//if (!validateEmail($useremail)) {
		//	logEvent("invalid email $useremail user marked unconfirmed");
		//	Sql_Query(sprintf('update %s set confirmed = 0 where email = "%s"', $GLOBALS['tables']['user'], $useremail));
		//}
	}
	private function _step_9_1_success_send_email(){
		$this->_sent++;
		$um = $this->_join_usermessage->set_status($this->_messageid,$this->_userid,'sent');
		//_process_rss();
		$this->_logger('Sent to '. $this->_user_email,  P_LEV_MEDIUM);
	}
	private function _step_9_0_update_domain_throttle(){
		if (USE_DOMAIN_THROTTLE) {
			list ($mailbox, $domainname) = explode('@', $this->_user_email);
			if ($this->_domainthrottle[$domainname]['interval'] != $this->_dt_interval) {
				$this->_domainthrottle[$domainname]['interval'] = $this->_dt_interval;
				$this->_domainthrottle[$domainname]['sent'] = 0;
			} else {
				$this->_domainthrottle[$domainname]['sent']++;
			}
		}
	}
	//STEP 8
	private function _step_8_cannot_send(){
		$this->_cannotsend++;
		# mark it as sent anyway, because otherwise the process will never finish
		$this->_join_usermessage->set_status($this->_messageid, $this->_userid, 'not sent');
		$this->_logger('Not sending to '. $this->_user_email,  P_LEV_MEDIUM);
	}
	//STEP 7
	private function _step_7_use_domain_throttle(){
		if ($this->_flag_cansend && USE_DOMAIN_THROTTLE) {
			//qui ho già gli utenti filtrati. ho solo il batch
			list ($mailbox, $domainname) = explode('@', $this->_user_email);
			$now = time();
			$this->_dt_interval = $now - ($now % DOMAIN_BATCH_PERIOD);
			if (!isset($this->_domainthrottle[$domainname])) {
				$this->_domainthrottle[$domainname] = array ();
				$this->_domainthrottle[$domainname]['interval'] = $this->_dt_interval;//?
				$this->_domainthrottle[$domainname]['sent'] = 0;//?
				$this->_domainthrottle[$domainname]['attempted'] = 0;//?
			}elseif (isset($this->_domainthrottle[$domainname]['interval']) && $this->_domainthrottle[$domainname]['interval'] == $this->_dt_interval) {
				$this->_throttled = $this->_domainthrottle[$domainname]['sent'] >= DOMAIN_BATCH_SIZE;
				if ($this->_throttled) {
					$this->_domainthrottle[$domainname]['attempted']++;
					if (DOMAIN_AUTO_THROTTLE && $this->_domainthrottle[$domainname]['attempted'] > 25 # skip a few before auto throttling
					&& $this->_num_messages <= 1 # only do this when there's only one message to process otherwise the other ones don't get a change
					&& $this->_num_users < 1000 # and also when there's not too many left, because then it's likely they're all being throttled
					) {
						//TODO: test this : 25 tentativi 1 messaggio e utenti < 1000 and test delay in this case
						$this->_domainthrottle[$domainname]['attempted'] = 0;
						$this->_logger(sprintf('There have been more than 10 attempts to send to %s that have been blocked for domain throttling.', $domainname), P_LEV_LOW);
						$this->_logger('Introducing extra delay to decrease throttle failures', P_LEV_LOW);
						
						if (!$this->_running_throttle_delay) {
							$this->_running_throttle_delay = (int) (MAILQUEUE_THROTTLE + (DOMAIN_BATCH_PERIOD / (DOMAIN_BATCH_SIZE * 4)));
						} else {
							$this->_running_throttle_delay += (int) (DOMAIN_BATCH_PERIOD / (DOMAIN_BATCH_SIZE * 4));
						}
						$this->_logger("Running throttle delay: ".$this->_running_throttle_delay, P_LEV_LOW);
					}else{
						$this->_logger(sprintf('%s is currently over throttle limit of %d per %d seconds (' . 
										$this->_domainthrottle[$domainname]['sent'] . ')', 
										$domainname, DOMAIN_BATCH_SIZE, DOMAIN_BATCH_PERIOD), P_LEV_LOW);
					}
				}
			}
		}
	}
	//STEP 6
	private function _step_6_can_send(){
		//TODO:
		//if (ENABLE_RSS && $processrss) {
		//	if ($rssfrequency == $message["rsstemplate"]) {
		//		# $this->_logger("User matches message frequency");
		//		$rssitems = rssUserHasContent($userid, $messageid, $rssfrequency);
		//		$cansend = sizeof($rssitems) && (sizeof($rssitems) > $rss_content_treshold);
		//		#            if (!$cansend)
		//		#              $this->_logger("No content to send for this user ".sizeof($rssitems));
		//	} else {
		//		$cansend = 0;
		//	}
		//} else {
		$this->_flag_cansend = !$this->_user_blacklisted;
		$this->_logger('Can Send? '. print_r($this->_flag_cansend, true),  P_LEV_HIGH); 
		//}
	}
	//STEP 5
	private function _step_5_check_user_message() {
		# check whether the user has already received the message
		$um = $this->_join_usermessage->get($this->_messageid,$this->_userid);
		if ($um) {
			$this->_step_5_1_already_received($um);//substep 1
			return false;
		} else {
			if ($this->_script_stage < 4)
				$this->_script_stage = 4; # we know a user
			
			$this->_logger('Script stage : 4 OK',  P_LEV_HIGH);	
			$this->_someusers = 1;
			//id,email,uniqid,htmlemail,rssfrequency,confirmed,blacklisted
			$user = $this->_join_user->get($this->_userid);
			//TODO : reset ad the end of the loop
			$this->_user_email = $user['email'];
			$this->_user_htmlemail = $user['htmlemail'];
			$this->_user_uniqid	  = $user['uniqid'];
			$this->_user_confirmed = $user['confirmed'];
			//$this->_user_rssfrequency = $user['confirmed'];
			$this->_user_blacklisted = $user['blacklisted'];
			
			//print_r($user);die;	
			if (!($user['confirmed'] && $this->_join_user->is_email_valid($user['email']))) {
				!$user['confirmed'] ? $this->_step_5_2_unconfirmed_email() : $this->_step_5_3_invalid_email();
				return false;
			} else {
				return true;
			}

		}
	}
	//step 5 subprocess
	private function _step_5_3_invalid_email(){
		# some "invalid emails" are entirely empty, ah, that is because they are unconfirmed
		## this is quite old as well, with the preselection that avoids unconfirmed users
		# it is unlikely this is every processed.
		# mark it as sent anyway
		if ($this->_userid)
			$this->_join_usermessage->set_status($this->_messageid,$this->_userid,'invalid email');
			
		$this->_logger('Invalid email ' . ": {$this->_user_email}, {$this->_userid}",  P_LEV_LOW);
		$this->_invalid++;
	}
	private function _step_5_2_unconfirmed_email(){
		# some "invalid emails" are entirely empty, ah, that is because they are unconfirmed
		## this is quite old as well, with the preselection that avoids unconfirmed users
		# it is unlikely this is every processed.
		$this->_join_usermessage->set_status($this->_messageid,$this->_userid,'user unconfirmed');
		$this->_logger('Unconfirmed user: ' . "{$this->_user_email}, {$this->_userid}",  P_LEV_LOW);
		$this->_unconfirmed++;
		# when running from commandline we mark it as sent, otherwise we might get
		# stuck when using batch processing
		# if ($GLOBALS["commandline"]) {
		# }
	}
	private function _step_5_1_already_received($um){
		## and this is quite historical, and also unlikely to be every called
		# because we now exclude users who have received the message from the
		# query to find users to send to
		// remove this? 
		$this->_notsent++;
		$this->_logger('Not sending to ' . $um[0] . ', already sent ' . $um[0],  P_LEV_LOW);
	}
	
	//STEP 4
	private function _step_4_process_message($userid) {
		$this->_step_4_1_reset_userdata();
		$this->_userid = $userid['id'];
		
		$this->_step_4_2_keep_lock();
		
		$this->_step_4_3_check_status();
	    
		
	}
	//step 4 subprocess
	private function _step_4_1_reset_userdata() {
		//model
		$this->_rssitems = false;//?
		
		$this->_userid = false;
		$this->_user_email = false;
		$this->_user_uniqid = false;
		$this->_user_htmlemail = false;
		$this->_user_confirmed = false;
	}
	private function _step_4_2_keep_lock() {
		set_time_limit(120);
    	# check if we have been "killed"
		$alive = $this->_join_sendprocess->check_lock($this->_process_id);
		if ($alive){
		   	$this->_join_sendprocess->keep_lock($this->_process_id);
		}else {
		   	die('Process Killed by other process');
		}
	}
	private function _step_4_3_check_status() {
		# check if the message we are working on is still there and in process
		$status = $this->_join_message->get_message_status($this->_messageid);
		//echo "qui :";print_r($status);die;
		if (!$status['id']) {
			die('Message I was working on has disappeared');//TODO ?
		} elseif ($status['status'] != 'inprocess') {
    		die('Sending of this message has been suspended');//TODO -> _set_sendstart
  		}
	}
	//STEP 3
	private function _step_3_set_users($message, $lastmessage = false) {
		$this->_step_3_0_reset_message();
		$this->_messageid = $message['id'];
		$this->_message = $message;
		$this->_logger('Processing message ' . $this->_messageid,  P_LEV_MEDIUM);
		//print_r($this->_messageid);die;

		//TODO: $userselection = $message["userselection"];
		//TODO: $rssmessage = $message["rsstemplate"];

		$this->_step_3_1_notify();
		
		$this->_step_3_2_process_rss();
		
		$this->_step_3_3_sendstart();
		
		$this->_step_3_4_get_users($lastmessage);
		
		$this->_step_3_5_get_users_per_batch();
	
		$this->_step_3_6_check_batch_limit_reached();
	}
	//step 3 subprocess
	private function _step_3_6_check_batch_limit_reached(){
		if ($this->_num_per_batch && $this->_sent >= $this->_num_per_batch) {
	      $this->_logger($this->_('batch limit reached').": {$this->_sent} ($this->_num_per_batch)",  P_LEV_HIGH);
	      $this->_wait = $this->_batch_period;
	      die('Batch limit reached<br/><br/>');
	    }
	}
	private function _step_3_5_get_users_per_batch(){
		//$this->_num_per_batch = -1;
		if ($this->_num_per_batch) {
			# send in batches of $num_per_batch users
			$this->_batch_total = $this->_num_users;
			$num_to_send = $this->_num_per_batch - $this->_sent;
			if ($num_to_send > 0) {
				$this->_logger('To send: '. $num_to_send,  P_LEV_HIGH); 
				$this->_userids = $this->_join_user->get_users_tosend($this->_messageid, 
																	  $this->_sub_userconfirmed, 
																	  $this->_sub_exclusion, 
																	  $this->_sub_user_attribute_query, 
																	  $num_to_send);
				$this->_logger('Processing users: ' . print_r($this->_userids,true),  P_LEV_HIGH);//die;
			} else {
				$this->_logger('No users to process for this message',  P_LEV_MEDIUM);
				//$userids = Sql_Query(sprintf('select * from %s where id = 0', $tables["user"]));
			}
		}
	}
	private function _step_3_4_get_users($lastmessage = false){
		$this->_logger('Looking for users',  P_LEV_HIGH);
		
		//TODO:$this->_user_attribute();//2 - STEP 3
		//TODO:$this->_logger($this->_('looking for users who can be excluded from this mailing'));
		
		$this->_userids = $this->_join_user->get_users_tosend($this->_messageid, $this->_sub_userconfirmed, $this->_sub_exclusion, $this->_sub_user_attribute_query);
		//print_r($userids);die;
		# now we have all our users to send the message to
		$this->_num_users = count($this->_userids);
		$this->_logger('Message '.$this->_messageid.'. Found them: ' . $this->_num_users . ' to process',  P_LEV_LOW);
		$this->_join_messagedata->set_messagedata($this->_messageid, 'to process', $this->_num_users);
		
		if($this->_num_users == 0){
			$this->_logger('No users to process for this message: ' . $this->_messageid,  P_LEV_LOW);
			
			if($lastmessage)
				$this->_nothingtodo();
		}
	}
	private function _step_3_3_sendstart(){
		//TODO : keepLock($send_process_id);
		$this->_join_message->set_message_status($this->_messageid,'inprocess');
		$this->_join_message->set_sendstart($this->_messageid);
		$this->_logger('Set message inprocess '.$this->_messageid,  P_LEV_HIGH);
	}
	private function _step_3_2_process_rss(){
		//TODO
		#if (ENABLE_RSS && $message["rsstemplate"]) {
		#  $processrss = 1;
		#  $this->_logger($this->_('Message').' '. $messageid.' '.$this->_('is an RSS feed for').' '. $this->_($rssmessage));
		#} else {
		//$processrss = 0;//TODO?
		#}
	}
	private function _step_3_1_notify(){
		//TODO
		//$msgdata = loadMessageData($messageid);
		//
		//$failed_sent = 0;
		//$throttlecount = 0;

		//$msgdata = loadMessageData($messageid);
		//if (!empty ($msgdata['notify_start']) && !isset ($msgdata['start_notified'])) {
		//	$notifications = explode(',', $msgdata['notify_start']);
		//	foreach ($notifications as $notification) {
		//		sendMail($notification, $this->_('Message Sending has started'), sprintf($this->_('phplist has started sending the message with subject %s'), $message['subject'] .
		//		"\n" .
		//		sprintf($this->_('to view the progress of this message, go to %s'), URL_BO . '?view=viewprocess')));
		//	}
		//	Sql_Query(sprintf('insert ignore into %s (name,id,data) values("start_notified",%d,now())', $GLOBALS['tables']['messagedata'], $messageid));
		//}
	}
	private function _step_3_0_reset_message(){
		$this->_message = false;
		$this->_messageid = false;
	}
	//STEP 2
	private function _step_2_load_messages() {
		
		$data = $this->_join_message->get_messages_tosend();
		$this->_num_messages = $data['total'];
		$this->_messages = $data['messages'];
		
		# shutdown will take care of reporting
		if (!$this->_num_messages){
			$this->_nothingtodo();
		}
		$this->_step_2_1_log_init_batch();
		$this->_script_stage = 2; # we know the messages to process
		$this->_logger('Script stage : 2 OK',  P_LEV_HIGH);
	}
	//step 2 subprocess
	private function _step_2_1_log_init_batch(){
		global $APP;
		if ($this->_num_messages) {
			$this->_logger('Processing has started, ' . $this->_num_messages . ' message(s) to process.',  P_LEV_MEDIUM);
			if (1==1){//TODO:!$GLOBALS["commandline"]) {
				if (!$this->_safemode) {
					if (!$this->_num_per_batch) {
						$this->_logger('It is safe to click your stop button now.Reports will be sent by email to' . 
														$APP->CONF->get('report_address'),  P_LEV_LOW);//TODO : when?
					} else {
						$this->_logger('Please leave this window open. You have batch processing enabled, so it will reload several times to send the messages. Reports will be sent by email to'. 
														$APP->CONF->get('report_address'),  P_LEV_HIGH);
					}
				} else {
					$this->_logger('Your webserver is running in safe_mode. Please keep this window open. It may reload several times to make sure all messages are sent. Reports will be sent by email to' .  
								  						$APP->CONF->get('report_address'),  P_LEV_LOW);
				}
			}
		}
	}
	//STEP 1
	private function _step_1_start_batch(){
		global $APP;
		$this->_logger('Started',  P_LEV_HIGH);
		
		$this->_step1_0_check_localconf();//TODO
		$this->_step1_1_set_num_per_batch();
		$this->_step1_2_set_batch_period(); 
		$this->_step1_3_check_safemode(); 
		$this->_step1_4_check_lastbatch();
		$this->_step1_5_time_limit();
		$this->_step1_6_isp_restrictions();
		$this->_step1_7_isp_lockfile();
		$this->_step1_8_check_num_per_batch();//direi che non entra da alcuna parte.... MAILQUEUE_BATCH_SIZE = 0		
		$this->_step1_9_set_bigtables();//direi che non entra da alcuna parte.... MAILQUEUE_BATCH_SIZE = 0		
		$this->_step1_10_min_num_per_batch();
		
		$this->_script_stage = 1; # we are active
		$this->_logger('Script stage : 1 OK',  P_LEV_HIGH);
		//TODO : $rss_content_treshold = sprintf('%d', getConfig("rssthreshold"));
	}
	//step 1 subprocess
	private function _step1_0_check_localconf(){
		//TODO:
	}
	private function _step1_1_set_num_per_batch(){
		if (MAILQUEUE_BATCH_SIZE) {
			if ($this->_maxbatch > 0) {//set by localconf
				$this->_num_per_batch = min(MAILQUEUE_BATCH_SIZE, $this->_maxbatch);
			} else {
				$this->_num_per_batch = sprintf('%d', MAILQUEUE_BATCH_SIZE);
			}
		} else {
			if ($this->_maxbatch > 0) {
				$this->_num_per_batch = $this->_maxbatch;
			}
		}
		
		$this->_logger('num_per_batch (MAILQUEUE_BATCH_SIZE): ' . $this->_num_per_batch,  P_LEV_MEDIUM);
		$this->_logger('maxbatch : ' . $this->_maxbatch,  P_LEV_HIGH);
		
	}
	private function _step1_2_set_batch_period(){
		if (MAILQUEUE_BATCH_PERIOD) {
			if ($this->_minbatchperiod > 0) {//set by localconf
				$this->_batch_period = max(MAILQUEUE_BATCH_PERIOD, $this->_minbatchperiod);
			} else {
				$this->_batch_period = MAILQUEUE_BATCH_PERIOD;
			}
		}
		$this->_logger('batch_period (MAILQUEUE_BATCH_PERIOD): ' . $this->_batch_period .'s',  P_LEV_MEDIUM);//TODO: test
		$this->_logger('minbatchperiod : ' . $this->_minbatchperiod,  P_LEV_HIGH);
	}
	private function _step1_3_check_safemode(){
		$safemode = 0;
		if ($safemode = ini_get("safe_mode")) {
			# keep an eye on timeouts
			$this->_safemode = 1;
			$this->_num_per_batch = min(100, $this->_num_per_batch);
			#  Fatal_Error("Process queue will not work in safe mode");
			$this->_logger('num_per_batch min(100): ' . $this->_num_per_batch,  P_LEV_MEDIUM);
			$this->_logger($this->_('In safe mode, batches are set to a maximum of 100'),  P_LEV_LOW);
		}
		$this->_logger('safemode : ' .$safemode,  P_LEV_HIGH);
	}
	private function _step1_4_check_lastbatch(){
		if ($this->_num_per_batch && $this->_batch_period) {
			# check how many were sent in the last batch period and take off that
			# amount from this batch
			$this->_original_num_per_batch = $this->_num_per_batch;
			//TODO:
			$recently_sent = $this->_join_usermessage->get_recently_sended($this->_batch_period);
			$this->_recently_sent =  $recently_sent;//
			$this->_num_per_batch -= $recently_sent;
			//TODO: why? che logica c'è qui?   
			//1) num_per_batch diventa recently sent?
			//$this->_num_per_batch = 2;//TEST
			
			# if this ends up being 0 or less, don't send anything at all
			if ($this->_num_per_batch == 0) {
				$this->_num_per_batch = -1;
				$this->_logger('num_per_batch : FALSE',  P_LEV_MEDIUM);//?
			}
			$this->_logger('recently_sent : ' .$this->_recently_sent,  P_LEV_MEDIUM);
			
		}
	}
	private function _step1_5_time_limit(){
		//init pqueue
		# we don not want to timeout or abort
		ignore_user_abort(1);//$abort = ?
		$flag = @set_time_limit(600);
		$this->_logger('ignore_user_abort = 1',  P_LEV_HIGH);
		if($flag)
			$this->_logger('set_time_limit : 600',  P_LEV_HIGH);
	}
	private function _step1_6_isp_restrictions(){
		//TODO:
		//if ($this->_isp_restrictions != "") {
		//	$this->_logger($this->_isp_restrictions);
		//}
		
	}
	private function _step1_7_isp_lockfile(){
		//TODO:
		//if (is_file($this->_isp_lockfile)) {
			//TODO: ProcessError($this->_('Processing has been suspended by your ISP, please try again later'), 1);
		//}
	}
	private function _step1_8_check_num_per_batch(){
		//$this->_num_per_batch = -1;//TEST TODO
		//$this->_original_num_per_batch = $this->_num_per_batch+1;//TEST 2
		if ($this->_num_per_batch > 0) {
			if ($this->_original_num_per_batch != $this->_num_per_batch) {
				$diff = $this->_original_num_per_batch - $this->_num_per_batch;
				$this->_logger('This batch will be ' . $this->_num_per_batch . 
							   ' emails, because in the last ' . $this->_batch_period .  
							   ' seconds ' . $diff . ' emails were sent',  P_LEV_LOW);
			} else {
				$this->_logger('Sending in batches of ' . $this->_num_per_batch . ' emails',  P_LEV_HIGH);
			}
		}
		elseif ($this->_num_per_batch < 0) {
			$this->_logger('In the last ' . $this->_batch_period . 
						   ' seconds more emails were sent' . " ({$this->_recently_sent}) " . 
						   ' than is currently allowed per batch' . " ({$this->_original_num_per_batch}).",  P_LEV_LOW);
			$this->_processed = -1;
			$this->_script_stage = 5;
			$this->_wait = $this->_batch_period;
			exit();
		}
	}
	private function _step1_9_set_bigtables(){
		$this->_dao->set_sql_big_tables();
		$this->_logger('set big tables',  P_LEV_HIGH);
	}
	private function _step1_10_min_num_per_batch(){
		if (!$this->_num_per_batch) {
			$this->_num_per_batch = 1000000;
			$this->_logger('num_per_batch : 1000000',  P_LEV_MEDIUM);//TODO : when?
		}
	}
	//////////////HELP BATCH///////////////////////
	//log
	private function _logger($msg, $verb_level) {
		global $APP;
		//$infostring = "[". date("D j M Y H:i",time()) . "] [" . $_SERVER["REMOTE_ADDR"] ."]";
		if(INTERACTIVE && $verb_level <= PROCESS_QUEUE_VERBOSITY)
			print "$msg <br/><br/>";
		$this->_arrlog[] = $msg;
		
		if($verb_level <= PROCESS_QUEUE_LOGEVENT_LEVEL)//TODO: test
			$APP->MSG->watchdog(LOG_LEVEL, $msg);
	}
	private function _nothingtodo(){
		$this->_helper_session->reset_polling();
		$this->_logger('Reset polling',  P_LEV_HIGH);
		$this->_logger('No Messages',  P_LEV_MEDIUM);
		$this->_script_stage = 6; # we are done
		$this->_logger('Script stage : 6 DONE',  P_LEV_HIGH);
		die();//finish batch
	}
	//get/set lock
	private function _lock(){
		//TODO: 
		$running = $this->_get_running();
		$waited = 0;
		//print_r($running);die;
		while ($running['id']) { # a process is already running
			//TODO:test
			if ($running['t'] > 600) { # some sql queries can take quite a while
				# process has been inactive for too long, kill it
				$this->_join_sendprocess->update($running['id']);
			} else {
				
				//if ($GLOBALS["commandline"])
				//	die("Running commandline, quitting. We'll find out what to do in the next run.");
				
				$this->_logger('A process for this page is already running and it was still alive ' .$running['id'] .': '. $running['t'] . ' seconds ago',  P_LEV_HIGH);
					
				if(TEST_PROCESS){
					$this->_logger('Not Sleeping for 20 seconds, aborting will quit. TEST_PROCESS',  P_LEV_HIGH);
				}else{
					sleep(1); # to log the messages in the correct order
					$this->_logger('Sleeping for 20 seconds, aborting will quit',  P_LEV_HIGH);
					ignore_user_abort(0);
					sleep(PROCESSQUEUE_SLEEP_TIME);	
				}
				
			}
			$waited++;
			if ($waited > PROCESSQUEUE_SLEEP_TIME_MAX) {
				//TODO:test
				# we have waited 10 cycles, abort and quit script
				$this->_logger('We have been waiting too long, I guess the other process is still going ok',  P_LEV_HIGH);
				exit;
			}
			$running = $this->_get_running();
		}
		$process_id = $this->_set_lock();
		return $process_id;
	}
	private function _release_lock(){
		$aff = $this->_join_sendprocess->release_lock($this->_process_id);
		$this->_logger('Release Lock: ' .  print_r($this->_process_id,true), P_LEV_HIGH);
		return $aff;
	}
	private function _set_lock(){
		ignore_user_abort(1);
		$process_id = $this->_join_sendprocess->insert('processqueue');
		$this->_logger('Set Lock: ' .  print_r($process_id,true),  P_LEV_HIGH);
		return $process_id;
	}
	private function _get_lock(){
		$process_id = $this->_join_sendprocess->get_lock('processqueue');
		$this->_logger('Get Lock: ' . $process_id , P_LEV_HIGH);
		return $process_id;
	}
	private function _get_running(){
		return $this->_join_sendprocess->get_running('processqueue');
	}

	//session
	private function _set_polling(){
		$this->_helper_session->set_polling();
		$this->_polling = $this->_helper_session->get_polling();
		$this->_logger('Polling: ' .  $this->_polling,  P_LEV_LOW);
	}
	private function _stat(){
		###debug
		//@ $this->_lastsent = sprintf('%d', $_GET['lastsent']);//TODO : 
		//@ $this->_lastskipped = sprintf('%d', $_GET['lastskipped']);//TODO 
		$this->_logger('Lastsent: ' .  $this->_helper_session->get_lastsent(),  P_LEV_MEDIUM);
		$this->_logger('Lastskipped: ' .  $this->_helper_session->get_lastskipped(),  P_LEV_HIGH);
		//TODO : reload?
		//if ($this->_reload) {
			//$this->_logger("Reload count: $this->_reload");
			//$this->_logger("Total processed: ".$this->_reload * $this->_num_per_batch);
			//$this->_logger($this->_('Sent in last run') . ':'. $this->_lastsent);
			//$this->_logger($this->_('Skipped in last run') .':'.$this->_lastskipped);
		//}
	}
	//////////////SHUTDOWN/////////////////////////
	public function finish(){
		
		//no polling
		if($this->_one_step){
			$this->_release_lock($this->_process_id);
			$this->_help_shutdown_batch_and_step();
			exit(); 
		}
		//no polling no step : exit
		if(!$this->_in_batch)
			exit(); 
			
		
		$this->_join_sendprocess->release_lock($this->_send_process_id);
		
  		#if (!$GLOBALS["commandline"]) {
		## blocco barra_js
  		#print '<script language="Javascript" type="text/javascript"> finish(); </script>';
  		$subject = "Maillist Processing info";
  		
		//_help_shutdown_batch_and_step
		
		
		// include_once "footer.inc";
		exit;
	}
	private function _help_shutdown_batch_and_step(){
		$totaltime = $this->_processqueue_timer->elapsed(1);
		$nothingtodo = false;
		if (!$this->_processed) {
			$this->_logger('Finished, Nothing to do',  P_LEV_HIGH);
			$nothingtodo = 1;
		}
		
		if (!$nothingtodo)
    		$this->_logger('Finished this run',  P_LEV_HIGH);
  		if (!TEST && !$nothingtodo)
    		;//TODO:sendReport($subject,$this->_report);
    		
    	//polling
		$this->_logger('---------- Shutdown ------------', P_LEV_HIGH);
		#output( "Script status: ".connection_status(),0); # with PHP 4.2.1 buggy. http://bugs.php.net/bug.php?id=17774
		$this->_logger('Script stage: '.$this->_script_stage,  P_LEV_LOW);
		//global $report,$send_process_id,$tables,$nothingtodo,$invalid,$processed,$failed_sent,$notsent,$sent,$unconfirmed,$num_per_batch,$batch_period;
		
		//stat batch
		$msgperhour = (3600 / $totaltime) * $this->_sent;
		if ($this->_sent){
		    $this->_logger($this->_sent . ' messages sent in '. $totaltime. ' s '. (int)$msgperhour. ' msgs/hr.',  P_LEV_LOW);
			$this->_helper_session->set_lastsent($this->_sent);
			$this->_logger('Set lastsent:' . $this->_sent, P_LEV_HIGH);
		}
		if ($this->_invalid)
			$this->_logger(sprintf('%d %s', $this->_invalid, 'invalid emails'),  P_LEV_LOW);
		if ($this->_failed_sent)
			$this->_logger(sprintf('%d %s', $this->_failed_sent, 'emails failed (will retry later)'),  P_LEV_LOW);
		if ($this->_unconfirmed)
			$this->_logger(sprintf('%d %s', $this->_unconfirmed, 'emails unconfirmed (not sent)'),  P_LEV_LOW);
		
		$lastskipped = $this->_invalid + $this->_failed_sent + $this->_unconfirmed;  
    	$this->_helper_session->set_lastskipped($lastskipped);
		$this->_logger('Set lastskipped:' . $lastskipped, P_LEV_HIGH);
    		
		if ($this->_script_stage < 5 && !$nothingtodo) {
			$this->_logger('Warning: script never reached stage 5. This may be caused by a too slow or too busy server ' .$totaltime,  P_LEV_LOW);
		}
		elseif ($this->_script_stage == 5 && (!$nothingtodo || $this->_wait)) {
			# if the script timed out in stage 5, reload the page to continue with the rest
			$this->_reload++;
			if ($this->_num_per_batch && $this->_batch_period) {//!$GLOBALS["commandline"] && 
				if ($this->_sent + 10 < $this->_original_num_per_batch && !$this->_wait) {
					$this->_logger('Less than batch size were sent, so reloading imminently',  P_LEV_LOW);
					$delaytime = 10000;
				} else {
					$this->_logger(sprintf('Waiting for %d seconds before reloading', $this->_batch_period),  P_LEV_LOW);
					$delaytime = $this->_batch_period * 1000;
				}
				//se è batch attivo il polling?
				
				//$this->_logger("Do not reload this page yourself, because the next batch would fail");
				/*printf('<script language="Javascript" type="text/javascript">
				function reload() {
				var query = window.location.search;
				query = query.replace(/&reload=\d+/,"");
				query = query.replace(/&lastsent=\d+/,"");
				query = query.replace(/&lastskipped=\d+/,"");
				//document.location = document.location.pathname + query + "&reload=%d&lastsent=%d&lastskipped=%d";
				}
				setTimeout("reload()",%d);
				</script>', $this->_reload, $this->_sent, $this->_notsent, $delaytime);*/
			} else {
				/*printf('<script language="Javascript" type="text/javascript">
				var query = window.location.search;
				query = query.replace(/&reload=\d+/,"");
				query = query.replace(/&lastsent=\d+/,"");
				query = query.replace(/&lastskipped=\d+/,"");
				//document.location = document.location.pathname + query + "&reload=%d&lastsent=%d&lastskipped=%d";
				</script>', $this->_reload, $this->_sent, $this->_notsent);*/
				$this->_logger('Reload required',  P_LEV_LOW);
			}
			#print '<script language="Javascript" type="text/javascript">alert(document.location)</script>';
		}
		elseif ($this->_script_stage == 6) {
			$this->_logger('Finished, All done',  P_LEV_LOW);
		} else {
			$this->_logger($this->_('Script finished, but not all messages have been sent yet.'),  P_LEV_LOW);
		}
	}
	public static function shutdown () {
  		
		#$this->_logger( "Script status: ".connection_status(),0); # with PHP 4.2.1 buggy. http://bugs.php.net/bug.php?id=17774
		//( $this->_('Script stage').': '.$script_stage,0);
		global $APP;
		//print_r($APP->MODULE->model);	die;
		$APP->MODULE->model->finish();
	}
	
}
register_shutdown_function(array("ProcessqueueModel","shutdown"));