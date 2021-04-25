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
 * $Id: processqueuemsg_helper.php 355 2007-12-23 17:46:42Z maxbnet $
 * $LastChangedDate: 2007-12-23 17:46:42 +0000 (Sun, 23 Dec 2007) $
 * $LastChangedRevision: 355 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/processqueuemsg_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-23 17:46:42 +0000 (Sun, 23 Dec 2007) $
 */

class ProcessqueuemsgHelper extends ProcessqueuebaseHelper{
	
	//model
	public $messageid = false;
	public $message = false;
	public $num_messages = false;
	public $messages = false;
	
	private $_userid = false;
	private $_user_email = false;
	private $_user_uniqid = false;
	private $_user_htmlemail = false;
	private $_user_confirmed = 0;
	private $_user_blacklisted = 0;
	private $_rssitems = false;//?
	
	private $_flag_cansend = false;
	
	public function __construct(){
		$this->_init();	
	}
		
	public function get_email_inprocess(){
		return $this->_user_email;
	}
	public function load(){
		$data = $this->_pq->_join_message->get_messages_tosend();
		$this->num_messages = $data['total'];
		$this->messages = $data['messages'];
		
		# shutdown will take care of reporting
		//$this->num_messages = false;
		if (!$this->num_messages){
			$this->_pq->_helper_batch->nothingtodo();
		}else{
			$this->_log_init_batch();
		}
		
	}
	public function set_message($message){
		$this->message = $message;
		$this->messageid = $message['id'];
		$this->_logger('Processing message ' . $this->_messageid,  P_LEV_INTER);
		$this->set_sendstart();
		//print_r($this->_messageid);die;
	}
	
	public function reset_message(){
		$this->_message = false;
		$this->_messageid = false;
	}
	public function check_user_message() {
		# check whether the user has already received the message
		$um = $this->_pq->_join_usermessage->get($this->messageid,$this->_userid);
		//$um = true;
		if ($um) {
			$this->_already_received($um);//substep 1
			return false;
		} else {
			$this->_pq->_helper_stat->someusers();
			
			//id,email,uniqid,htmlemail,rssfrequency,confirmed,blacklisted
			$user = $this->_pq->_join_user->get($this->_userid);
			//TODO : reset ad the end of the loop
			$this->_user_email = $user['email'];
			$this->_user_htmlemail = $user['htmlemail'];
			$this->_user_uniqid	  = $user['uniqid'];
			$this->_user_confirmed = $user['confirmed'];
			//$this->_user_rssfrequency = $user['confirmed'];
			$this->_user_blacklisted = $user['blacklisted'];
			
			//print_r($user);die;	
			if (!($this->_user_confirmed && $this->_pq->_join_user->is_email_valid($this->_user_email))) {
				!$this->_user_confirmed ? $this->_unconfirmed_email() : $this->_invalid_email();
				return false;
			} else {
				$this->_can_send();
				return true;
			}

		}
	}
	public function cannotsend(){
		$this->_pq->_helper_stat->increase_cannot_sent();
		# mark it as sent anyway, because otherwise the process will never finish
		//mmmhh? 
		//$this->_pq->_join_usermessage->set_status($this->messageid, $this->_userid, 'not sent');
		$this->_logger('Not sending to '. $this->_user_email,  P_LEV_HIGH);
	}
	public function set_cannotsend(){
		$this->_flag_cansend = false;
	}
	public function set_cansend(){
		$this->_flag_cansend = true;
	}
	public function can_send(){
		return $this->_flag_cansend;
	}
	public function send_message(){
		$success = 0;
		$throttle = $this->_pq->_helper_throttle;
		if (!TEST) {
			if (!$throttle->get_throttled()) {
				$this->_logger('Sending message ' . $this->messageid . ' to ' . $this->_user_email,  P_LEV_LOW);
				$timer = new MaxTimerHelper();
				//TODO: $this->_rssitems
				
				//per mandare un messaggio ho bisogno
				//1) messaggio
				$msg = $this->_pq->_join_message->get($this->messageid);
				
				//2) questo dovrebbe +/- fare da cache TODO:fix
				$this->_pq->_join_sendmail->set($this->_user_uniqid, $msg);
				
				//3) invia la mail
	      		if(!TEST_PROCESS){
	      			$success = $this->_pq->_join_sendmail->send_email($this->messageid, $this->_user_email, $this->_user_uniqid, $this->_user_htmlemail);
					$this->_logger('It took ' . $timer->elapsed(1) . ' seconds to send',  P_LEV_MEDIUM);
				}else{
	      			$success = true;
					$this->_logger('It took ' . $timer->elapsed(1) . ' seconds. TEST_PROCESS',  P_LEV_MEDIUM);
				}
			} else {
				$throttle->increase_throttle();
			}
		} else {
			//TODO: $success = sendEmailTest($messageid, $useremail);
		}
		
		//ESITO:
		if ($success) {
			$throttle->update_success_domain_throttle($this->_user_email);
			$this->_success_send_email();//STEP 8 : sended
		} else {
			$throttle->update_failed_domain_throttle($this->_user_email);
			$this->_failed_send_email();
		}
		# update possible other users matching this email as well,
		# to avoid duplicate sending when people have subscribed multiple times
		# bit of legacy code after making email unique in the database
		#        $emails = Sql_query("select * from {$tables['user']} where email =\"$useremail\"");
		#        while ($email = Sql_fetch_row($emails))
		#          Sql_query("replace into {$tables['usermessage']} (userid,messageid) values($email[0],$messageid)");
	} 

	public function set_toprocess($num_users){
		$this->_pq->_join_messagedata->set_messagedata($this->_messageid, 'to process', $num_users);
	}
	public function set_sendstart(){
		//TODO : keepLock($send_process_id);
		$this->_pq->_join_message->set_message_status($this->messageid,'inprocess');
		$this->_pq->_join_message->set_sendstart($this->messageid);
		$this->_logger('Set message inprocess :'.$this->messageid,  P_LEV_INTER);
	}
	
	public function process_message($userid) {
		$this->_reset_userdata();
		$this->_userid = $userid['id'];
		
		$this->_pq->_helper_lock->keep_lock();
		
		$this->_check_status();
	}
	public function end_process_message($messageid = false) {
		if($messageid)
			$this->messageid = $messageid;
		
		$this->_set_sent($this->messageid);
	}
	public function end_send_message() {
		$stat = $this->_pq->_helper_stat;
		$user = $this->_pq->_helper_user;
		
		$this->_pq->_join_message->update_processed($this->messageid);
		
		$stat->log_end_send_message();
		$sent = $stat->get_sent();
		$num_users = $user->get_users_per_message($this->messageid);
		 
		$totaltime = $this->_pq->_processqueue_timer->elapsed(1);
		$msgperhour = (3600 / $totaltime) * $sent;
		@ $secpermsg = $totaltime / $sent;
		$timeleft = ($num_users - $sent) * $secpermsg;
		$eta = date('D j M H:i', time() + $timeleft);
		$this->_pq->_join_messagedata->set_messagedata($this->messageid, 'ETA', $eta);
		$this->_pq->_join_messagedata->set_messagedata($this->messageid, 'msg/hr', $msgperhour);
		$this->_pq->_join_messagedata->set_messagedata($this->messageid, 'to process', $num_users - $sent);
		
		$this->_logger('MessageData : ETA '.$eta , P_LEV_HIGH);
		$this->_logger('MessageData : msg/hr '.$msgperhour , P_LEV_HIGH);
		$this->_logger('MessageData : to process '.($num_users - $sent) , P_LEV_HIGH);
		
	}
	private function _reset_userdata() {
		//model
		$this->_rssitems = false;//?
		
		$this->_userid = false;
		$this->_user_email = false;
		$this->_user_uniqid = false;
		$this->_user_htmlemail = false;
		$this->_user_confirmed = false;
	}
	private function _check_status() {
		# check if the message we are working on is still there and in process
		$status = $this->_pq->_join_message->get_message_status($this->messageid);
		//echo "qui :";print_r($status);die;
		if (!$status['id']) {
			die('Message I was working on has disappeared');//TODO ?
		} elseif ($status['status'] != 'inprocess') {
    		die('Sending of this message has been suspended');//TODO -> _set_sendstart
  		}
	}
	private function _already_received($um){
		## and this is quite historical, and also unlikely to be every called
		# because we now exclude users who have received the message from the
		# query to find users to send to
		// remove this? 
		$this->_pq->_helper_stat->increase_notsent();
		$this->_logger('Not sending to ' . $um[0] . ', already sent ' . $um[0],  P_LEV_LOW);
	}
	private function _invalid_email(){
		# some "invalid emails" are entirely empty, ah, that is because they are unconfirmed
		## this is quite old as well, with the preselection that avoids unconfirmed users
		# it is unlikely this is every processed.
		# mark it as sent anyway
		if ($this->_userid)
			$this->_pq->_join_usermessage->set_status($this->messageid,$this->_userid,'invalid email');
			
		$this->_logger('Invalid email ' . ": {$this->_user_email}, {$this->_userid}",  P_LEV_LOW);
		$this->_pq->_helper_stat->increase_invalid();
	}
	private function _unconfirmed_email(){
		# some "invalid emails" are entirely empty, ah, that is because they are unconfirmed
		## this is quite old as well, with the preselection that avoids unconfirmed users
		# it is unlikely this is every processed.
		$this->_pq->_join_usermessage->set_status($this->messageid,$this->_userid,'user unconfirmed');
		$this->_logger('Unconfirmed user: ' . "{$this->_user_email}, {$this->_userid}",  P_LEV_LOW);
		$this->_pq->_helper_stat->increase_unconfirmed();
		# when running from commandline we mark it as sent, otherwise we might get
		# stuck when using batch processing
		# if ($GLOBALS["commandline"]) {
		# }
	}
	private function _can_send(){
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
		$this->_logger('Can Send (no blacklist): '. print_r($this->_flag_cansend, true),  P_LEV_HIGH); 
		//}
	}
	private function _failed_send_email(){
		$this->_pq->_helper_stat->increase_failed_sent();
		$this->_logger('Failed sending to ' . $this->_user_email . ' messageid:' . $this->messageid,  P_LEV_HIGH);
		# make sure it's not because it's an invalid email
		# unconfirm this user, so they're not included next time
		//TODO:
		//if (!validateEmail($useremail)) {
		//	logEvent("invalid email $useremail user marked unconfirmed");
		//	Sql_Query(sprintf('update %s set confirmed = 0 where email = "%s"', $GLOBALS['tables']['user'], $useremail));
		//}
	}
	private function _success_send_email(){
		$this->_pq->_helper_stat->increase_sent();
		$um = $this->_pq->_join_usermessage->set_status($this->messageid,$this->_userid,'sent');
		//_process_rss();
		$this->_logger('Sent to '. $this->_user_email,  P_LEV_MEDIUM);
	}
	private function _log_init_batch(){
		if ($this->num_messages) {
			$this->_logger('Processing has started, ' . $this->num_messages . ' message(s) to process.',  P_LEV_MEDIUM);
			if (1==1){//TODO:!$GLOBALS["commandline"]) {
				$this->_pq->_helper_conf->log_conf();
			}
		}
	}
	private function _set_sent($messageid){
		global $APP;
		$user = $this->_pq->_helper_user;
		$stat = $APP->get_helper("statistic");
		//$this->_failed_sent++;$this->_num_users++;//test
		# this message is done
		//	$this->_repeat_message(); ? 
		//var_dump($user->get_users_per_message($messageid));die;
		//if(0)//se il messaggio è stato inviato a tutti gli utenti	//TODO:
		if(!$user->get_users_per_message($messageid)){
			$this->_pq->_join_message->set_sent($messageid);
			$this->_logger('Message sent:' . $messageid, P_LEV_HIGH);
			//se il messaggio è stato inviato a tutti gli utenti	//TODO:
			//TODO:$this->_step_11_1_notify_end();
			$timetaken = $this->_pq->_join_message->get_timetaken($messageid);
			$this->_logger('It took ' . $stat->time_diff($timetaken[0], $timetaken[1]) . ' to send this message', P_LEV_LOW);
			//TODO:$this->_step_11_2_send_message_stats($this->_messageid);
		}
	}
	
}