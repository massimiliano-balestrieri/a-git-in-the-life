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
 * $Id: processqueueuser_helper.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/processqueueuser_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class ProcessqueueuserHelper extends ProcessqueuebaseHelper{
	
	public $userids = false;
	public $num_users = false;
	
	private $_total_mail_to_send = false;
	private $_users_per_messages = array();  
	//user query
	private $_sub_userconfirmed = false;
	private $_sub_exclusion = false;
	private $_sub_user_attribute_query = false;
	
	
	
	public function __construct(){
		$this->_init();	
	}

	public function load($message, $lastmessage = false) {
		
		//TODO: $userselection = $message["userselection"];
		//TODO: $rssmessage = $message["rsstemplate"];

		
		//$this->_step_3_2_process_rss();
		
		//$this->_get_users($message['id'], $lastmessage);
		
		$this->_get_users_per_batch($message['id']);
	
		$this->_pq->_helper_stat->check_batch_limit_reached();
	}
	public function set_totalusers_per_messages($messages){
		$total = 0;
		foreach ($messages as $message) {
			$this->_users_per_messages[$message['id']] = $this->_get_users_message($message['id']);
			$this->_logger('Total to send for message '. $message['id'] . ' : ' .  $this->_users_per_messages[$message['id']],  P_LEV_MEDIUM);
			$total += $this->_users_per_messages[$message['id']];
		
			if(!$this->_users_per_messages[$message['id']])
				$this->_pq->_helper_msg->end_process_message($message['id']);
		
		}
		$this->_logger('Total emails to send '. $total,  P_LEV_INTER);
		$this->_total_mail_to_send = $total;
		
		if(!$this->_total_mail_to_send){
			$this->_pq->_helper_batch->nothingtodo();
		}
	}
	public function get_total_mail_to_send(){
		return $this->_total_mail_to_send;
	}
	public function get_users_per_message($id){
		return isset($this->_users_per_messages[$id]) ? $this->_users_per_messages[$id] : false;
	}
	private function _get_users_per_batch($messageid){
		$this->_logger('Looking for users',  P_LEV_INTER);
		//$this->_num_per_batch = -1;
		$conf = $this->_pq->_helper_conf;
		$stat = $this->_pq->_helper_stat;
		
		if ($num_per_batch = $conf->get_num_per_batch()) {
			# send in batches of $num_per_batch users
			$stat->set_batch_total($this->num_users);
			
			$num_to_send = $num_per_batch - $stat->get_sent();
			if ($num_to_send > 0) {
				$this->_logger('Max to send: '. $num_to_send,  P_LEV_INTER); 
				$this->userids = $this->_pq->_join_user->get_users_tosend($messageid, 
																	  $this->_sub_userconfirmed, 
																	  $this->_sub_exclusion, 
																	  $this->_sub_user_attribute_query, 
																	  $num_to_send);
				$this->_logger('Processing users: ' . print_r($this->userids,true),  P_LEV_INTER);//die;
			} else {
				$this->_logger('No users to process for this message',  P_LEV_MEDIUM);
				//$userids = Sql_Query(sprintf('select * from %s where id = 0', $tables["user"]));
			}
		}
	}
	/*private function _get_users($messageid, $lastmessage = false){
		$this->_logger('Looking for users',  P_LEV_HIGH);
		
		//TODO:$this->_user_attribute();//2 - STEP 3
		//TODO:$this->_logger($this->_('looking for users who can be excluded from this mailing'));
		
		$this->userids = $this->_pq->_join_user->get_users_tosend($messageid, $this->_sub_userconfirmed, $this->_sub_exclusion, $this->_sub_user_attribute_query);
		//print_r($userids);die;
		# now we have all our users to send the message to
		$this->num_users = count($this->userids);
		$this->_logger('Message '.$messageid.'. Found them: ' . $this->num_users . ' to process',  P_LEV_LOW);
		
		$this->_pq->_helper_msg->set_toprocess($this->num_users);
		
		if($this->num_users == 0){
			$this->_logger('No users to process for this message: ' . $messageid,  P_LEV_LOW);
			
			if($lastmessage)//TODO: Test
				$this->_pq->_helper_batch->nothingtodo();
		}
	}*/
	private function _get_users_message($messageid){
		$userids = $this->_pq->_join_user->get_users_tosend($messageid, $this->_sub_userconfirmed, $this->_sub_exclusion, $this->_sub_user_attribute_query);
		//print_r($userids);die;
		# now we have all our users to send the message to
		return count($userids);
	}
}