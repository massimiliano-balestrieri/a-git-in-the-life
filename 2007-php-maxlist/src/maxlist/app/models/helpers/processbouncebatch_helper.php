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
 * $Id: processbouncebatch_helper.php 396 2008-01-23 22:14:43Z maxbnet $
 * $LastChangedDate: 2008-01-23 22:14:43 +0000 (Wed, 23 Jan 2008) $
 * $LastChangedRevision: 396 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/processbouncebatch_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-23 22:14:43 +0000 (Wed, 23 Jan 2008) $
 */

class ProcessbouncebatchHelper extends ProcessbouncebaseHelper{

	private $_port = '110/pop3/notls';
	private $_in_batch = false;
	
	private $_num = 0;
	private $_link = false;
	
	//model
	private $_header = false;
	private $_headerinfo = false;
	private $_msg_date = false;
	private $_body = false;
	
	public function __construct(){
		$this->_init();
	}
	protected function _process(){
		if(!TEST_ONLY_BATCH){
			
			switch (BOUNCE_PROTOCOL) {
				case "pop" :
					$this->_process_pop(BOUNCE_MAILBOX_HOST, BOUNCE_MAILBOX_USER, BOUNCE_MAILBOX_PWD);
					break;
				case "mbox" :
					$this->_process_mbox(BOUNCE_MAILBOX);
					break;
				default :
					die('bounce_protocol not supported');
			}
		}else{
			$this->_set_fake_bounce();
		}
		
		if($this->_link)
			$this->_process_messages(100000);
		
		
	}
	private function _process_mbox($file) {
		@set_time_limit(6000);
		if (!TEST_PROCESS) {
			$this->_link = imap_open($file, "", "", CL_EXPUNGE);
		} else {
			$this->_link = imap_open($file, "", "");
		}
		if (!$this->_link) {
			die("Cannot open mailbox file" . " " . imap_last_error());
		}
	}
	private function _process_pop($server, $user, $password) {
		$this->_in_batch = true;
		
		//lock
		$this->_pb->_helper_lock->init_lock();//TODO:
		
		$this->_config_process_pop();
		if (IMAP_EXT) {
			$this->_process_pop3_imap($server, $user, $password);
		}else{
			$this->_process_pop3_zendmail($server, $user, $password);
		}
	}
	private function _set_fake_bounce(){
		$this->_link = true;
		$this->_num = 1;
		$this->_header = '';
		$this->_headerinfo = '';
		$this->_msg_date = '';
		$this->_body = '';
	}
	private function _set_header($x){
		if(TEST_ONLY_BATCH) return;
		if (!IMAP_EXT) {
			//$this->_header = $this->_link->getRawHeaders($x);
			$this->_header = $this->_link->getRawHeader($x);
		} else {
			//print_r(imap_fetchheader($this->_link, $x));die;
			$this->_header = imap_fetchheader($this->_link, $x);
		}
	}
	private function _disconnect(){
		if(TEST_ONLY_BATCH) return;
		if (!IMAP_EXT) {
			$this->_link->disconnect();
		} else {
			@imap_close($this->_link);
		}
		$this->_logger('Closing mailbox', P_LEV_HIGH);
	}
	private function _delete_message($x){
		$this->_logger('Deleting message' . " $x", P_LEV_HIGH);
		if (!IMAP_EXT) {
			$this->_link->deleteMsg($x);
		} else {
			imap_delete($this->_link, $x);
		}
	}
	private function _parse_message($x){
		if(TEST_ONLY_BATCH) return;
		if (!IMAP_EXT) {
			//print_r($this->_link);die;
			foreach ($this->_link as $messageNum => $message) {
				print_r($message);die("TODO: processbouncebatch_helper->_parse_message");//Zend_Mail_Message
				//TODO: for in foreach
			}
			//TODO : ?$this->_headerinfo = $this->_link->getRawContent($x,'info');
			$this->_msg_date = $this->_link->getRawContent($x,'Date');
			print_r($this->_msg_date);die;
			
			$this->_body = $this->_link->getBody($x);
		} else {
			$this->_headerinfo = imap_headerinfo($this->_link, $x);
			$this->_msg_date = $this->_headerinfo->Date;
			$this->_body = imap_body($this->_link, $x);
		}
	}
	private function _retrieve_msgid(){
		$msgid = 0;
		preg_match("/X-MessageId: (.*)/i", $this->_body, $match);
		if (is_array($match) && isset ($match[1]))
			$msgid = trim($match[1]);
		
		if (!$msgid) {
		# older versions use X-Message
			preg_match("/X-Message: (.*)/i", $this->_body, $match);
			if (is_array($match) && isset ($match[1]))
				$msgid = trim($match[1]);
		}
		
		return $msgid;
	}
	private function _retrieve_userid(){
		$user = 0;
		preg_match("/X-ListMember: (.*)/i", $this->_body, $match);
		if (is_array($match) && isset ($match[1]))
			$user = trim($match[1]);
		if (!$user) {
			# older version use X-User
			preg_match("/X-User: (.*)/i", $this->_body, $match);
			if (is_array($match) && isset ($match[1]))
				$user = trim($match[1]);
		}
		# some versions used the email to identify the users, some the userid and others the uniqid
		# use backward compatible way to find user
		if (preg_match("/.*@.*/i", $user, $match)) {
			$userid_req = $this->_pb->_join_user->get_id_by_email($user);
			//$userid_req = Sql_Fetch_Row_Query("select id from {$tables["user"]} where email = \"$user\"");
			$userid = $userid_req[0];
		}
		elseif (preg_match("/^\d$/", $user)) {
			$userid = $user;
		}
		elseif ($user) {
			$userid_req = $this->_pb->_join_user->get_id_by_uniqid($user);
			//$userid_req = Sql_Fetch_Row_Query("select id from {$tables["user"]} where uniqid = \"$user\"");
			$userid = $userid_req[0];
		} else {
			$userid = '';
		}
		return $userid;
	}
	private function _get_userhistory_desc($id){
		$str = 'Bounced system message <br/> User marked unconfirmed <br/>';
		$str .= '<a href="'.URL_BASE.'bounce/view/'.$id. '">View Bounce</a>';//TODO:
		return $str;
	}
	private function _process_bounce($x){
		
		$this->_parse_message($x);
		
		
		$msgid = $this->_retrieve_msgid();
		$userid = $this->_retrieve_userid();
		//print_r($msgid);die;
		
		$this->_logger('UID ' . $userid . ' MSGID ' . $msgid , P_LEV_LOW);
		
		$bounceid = $this->_pb->_join_bounce->insert($this->_msg_date, $this->_header, $this->_body);
		$this->_logger('New Bounce ' . $bounceid, P_LEV_HIGH);
		//nizar 'set status', 'comment' etc.?? +50 lignes ci-dessous
		
		//$msgid = false;
		//$userid = false;
		
		if ($msgid == 'systemmessage' && $userid) {
			//$this->_pb->_join_bounce->update($userid, $bounceid);
			$this->_pb->_join_bounce->bounced_system_message($userid, $bounceid);
			$this->_logger("$userid " . 'system message bounced, user marked unconfirmed', P_LEV_LOW);
			$this->_pb->_join_userhistory->add_user_history($userid, 
															$this->_pb->_i18n('Bounced system message'), 
															$this->_get_userhistory_desc($bounceid));
			$this->_pb->_join_user->set_unconfirmed($userid);
		}
		elseif ($msgid && $userid) {
			$this->_pb->_join_bounce->bounced_list_message($msgid,$userid, $bounceid);
			$this->_pb->_join_message->increase_bouncecount($msgid);
			$this->_pb->_join_user->increase_bouncecount($userid);
			$this->_pb->_join_usermessagebounce->insert($userid, $msgid, $bounceid);
		}
		elseif ($userid) {
			$this->_pb->_join_bounce->bounced_unidentified_message($userid, $bounceid);
			$this->_pb->_join_user->increase_bouncecount($userid);
		} else {
			$this->_pb->_join_bounce->unidentified_bounce($bounceid);
			return false;
		}
		return true;
	}
	private function _reset_cache(){
		$this->_headerinfo = false;
		$this->_msg_date = false;
		$this->_body = false;
	}
	private function _log_init_process($max){
		#output($GLOBALS['I18N']->get("Please do not interrupt this process")."<br/>");
		$this->_logger($this->_num . " " . 'bounces to process', P_LEV_HIGH);
		if ($this->_num > $max) {
			$this->_logger('Processing first ' . $max .' bounces ', P_LEV_HIGH);
			$this->_num = $max;
		}
		if(!TEST_PROCESS)
			$this->_logger('Processed messages will be deleted from mailbox', P_LEV_HIGH);
	}
	private function _process_messages($max = 3000){
	
		#error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	
		$this->_log_init_process($max);
		$nberror = 0;
		#  for ($x=1;$x<150;$x++) {
	
		for ($x = 1; $x <= $this->_num; $x++) {
			$this->_logger('Processing bounce ' . $x, P_LEV_HIGH);
			$this->_reset_cache($x);
			@ set_time_limit(60);
			
			$this->_set_header($x);
			
			if ($x % 25 == 0)
				$this->_logger($x . ' done', P_LEV_HIGH);
			
			$processed = $this->_process_bounce($x);
			if ($processed) {
				###boh
				if (!TEST_PROCESS && BOUNCE_MAILBOX_PURGE)
					$this->_delete_message($x);
			} else {
				if (!TEST_PROCESS && BOUNCE_MAILBOX_UNPROCESSED)
					$this->_delete_message($x);
			}
			$this->_logger('Processed ' . $x, P_LEV_HIGH);
		}
		
		@set_time_limit(60 * $this->_num);
		$this->_disconnect();
	}
	private function _process_pop3_zendmail($server, $user, $password){
		try{
			$mail = new Zend_Mail_Storage_Pop3(array('host'     => $server,
		    	                                     'user'     => $user,
		        	                                 'password' => $password));
		}catch(Zend_Mail_Protocol_Exception $e){
			$this->_logger($e->getMessage() . ' - ' . $user . ','. $password.') for ' . " $server:{$this->_port} " , P_LEV_LOW);
			die;
		}catch(Zend_Exception $e){
			die;			
		}
        $this->_link = $mail;
        $this->_num = $this->_link->countMessages();
        $this->_logger($this->_num . ' bounces to fetch from the mailbox', P_LEV_HIGH);

	}
	private function _process_pop3_lib($server, $user, $password){
		// Setup pear Net_POP3 connection
		$link = new Net_POP3();
		//$link->setDebug();
		if (PEAR :: isError($ret = $link->connect($server, $this->_port))) {
			$this->_logger('Cannot create POP3 connection to' . " $server:{$this->_port} " . $ret->getMessage(), P_LEV_LOW);
			die;
		}
		if (PEAR :: isError($ret = $link->login($user, $password, 'USER'))) {
			$this->_logger('Wrong username or password(' . $user . ','. $password.') for ' . " $server:{$this->_port} " . $ret->getMessage(), P_LEV_LOW);
			die;
		}
		$this->_link = $link;
		$this->_num = $this->_link->numMsg();
		$this->_logger($this->_num . ' bounces to fetch from the mailbox', P_LEV_HIGH);
	}
	private function _process_pop3_imap($server, $user, $password){
		
		if (!TEST) {
			$this->_link = imap_open("{" . $server . ":" . $this->_port . "}INBOX", $user, $password, CL_EXPUNGE . OP_SILENT );
		} else {
			$this->_link = imap_open("{" . $server . ":" . $this->_port . "}INBOX", $user, $password);
			die;
		}
		if (!$this->_link) {
			$this->_logger('Cannot create POP3 connection to' . " $server: " . imap_last_error(), P_LEV_LOW);
			die;
		}else{
			$this->_logger('Link pop (IMAP):' . print_r($this->_link,true), P_LEV_INTER);
		}

		$this->_num = imap_num_msg($this->_link);
		$this->_logger($this->_num . ' bounces to fetch from the mailbox', P_LEV_HIGH);
	}
	private function _config_process_pop(){
		if (BOUNCE_MAILBOX_PORT) {
			$this->_port = BOUNCE_MAILBOX_PORT;
		}
		set_time_limit(6000);
		ignore_user_abort(1);
	}
	//////////////SHUTDOWN/////////////////////////
	protected function _finish(){
		//no polling
		if($this->_in_batch){
			$this->_pb->_helper_lock->release_lock();
			$this->_help_shutdown();
		}
		//in batch ? finish
		$this->_logger('Exit', P_LEV_INTER);
		exit;
	}
	private function _help_shutdown(){
		global $report;
		# $report .= "Connection status:".connection_status();
		$flag  = 'info';
		
		if ($flag == "error") {
			$subject = 'Bounce processing error';
		}
		elseif ($flag == "info") {
			$subject = 'Bounce Processing info';
		}
		//TODO:
		//if (!TEST && $message)
		//	sendReport($subject, $message);
	}
	
}


	