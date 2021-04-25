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
 * $Id: user_helper.php 393 2008-01-18 18:09:49Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 393 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/user_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 */

class UserHelper{
	
	private $_params = false;
	public $db = false;
	
	public $context = false;
	
	private $_old_user = false;
	private $_old_subscribe = false;
	
	private $_new_user = false;
	private $_new_subscribe = false;	
	private $_str_new_lists = false;
	private $_str_userdata_changed = false;
	
	private $_is_new = false;
	private $_email_changed = false;
	
	public function __construct($params, $context = false){
		global $APP;
		//want context of model.
		$this->_params = $params;
		//important ->get_table
		$this->db = $APP->DB;
		
		$this->context = $context;
	}
	//help user_model->update 
	public function get_history($id){
		//STEP  after subscribe
		if($this->_is_new)
			$history_subject = 'Subscription';
		else
		  	$history_subject = 'Change';
	  		
	  	$history_entry = '';//URL_FO. "?" .getToString()."\n\n";
		//is_array($this->_new_subscribe) ? implode("\n* ", $this->_new_subscribe) : '';
		
		//print_r($this->_old_user);
		//echo "<hr>";
		//print_r($this->_new_user);
		
		foreach ($this->_new_user as $key => $val) {
			if (!is_numeric($key))
				if ($this->_old_user[$key] != $val && $key != "modified") {
					if($key == "email")
						$this->_email_changed = true;
					$history_entry .= "$key = $val\nchanged from {$this->_old_user[$key]}\n";
				}
			}
			if (strlen($history_entry) == 0) {
				$history_entry = "\n No userdata changed";
			}
			$this->_str_userdata_changed = $history_entry;
			# check lists
			# i'll do this once I can test it on a 4.3 server
			#if (function_exists("array_diff_assoc")) {
			if (0) {
				# it requires 4.3
				$subscribed_to = array_diff_assoc($this->_new_subscribe, $this->_old_subscribe);
				$unsubscribed_from = array_diff_assoc($this->_old_subscribe,$this->_new_subscribe);
				foreach ($subscribed_to as $key => $desc) {
					$history_entry .= "Subscribed to $desc\n";
				}
				foreach ($unsubscribed_from as $key => $desc) {
					$history_entry .= "Unsubscribed from $desc\n";
				}
		 
			} else {
		 
				$history_entry .= "\n List subscriptions:\n";
				if(is_array($this->_old_subscribe))
					foreach ($this->_old_subscribe as $key => $val) {
					$history_entry .= "Was subscribed to: $val\n";
				}
				if(is_array($this->_new_subscribe))
					foreach ($this->_new_subscribe as $key => $val) {
					$history_entry .= "Is now subscribed to: $val\n";
				}
				if (!sizeof($this->_new_subscribe)) {
					$history_entry .= "Not subscribed to any lists\n";
				}
			 
		}
		$history_entry;
		//TODO:
		//print_r($history_entry);die;
		return array('history_subject' => $history_subject,  
					 'history_entry' => $history_entry); 
	}
	//help user_model->insert 
	public function is_new(){
		$this->_is_new = true;//solo nel FO?
	}
	//help user_model->unsubscribe
	public function send_unsubscribe($id, $user, $reason){
		global $APP;
		$unsubscribesubject = $this->_parse_istance($APP->CONF->get("unsubscribesubject"));
		$unsubscribemessage = $this->_parse_istance($APP->CONF->get_user_config("unsubscribemessage",$id));
		$unsubscribemessage = $this->_parse_lists_message($unsubscribemessage);
		$email = $this->_send_mail($user['email'], 
						 stripslashes($unsubscribesubject), 
						 stripslashes($unsubscribemessage),
						 1 //skipblacklistedcheck
						 );
		$reason = strlen($reason)>0 ? "Motivo:\n".stripslashes($reason):"Nessun motivo specificato.";
		//sendAdminCopy("List unsubscription",$email . " has unsubscribed\n$reason");
		return $email;
	}
	//help user_model->confirm
	public function send_confirm($id, $user, $blacklisted){
		global $APP;
		$confirmationsubject = $this->_parse_istance($APP->CONF->get("confirmationsubject"));
		$confirmationmessage = $this->_parse_istance($APP->CONF->get_user_config("confirmationmessage",$id));
		$confirmationmessage = $this->_parse_lists_message($confirmationmessage);
			
		$email = $this->_send_mail($user["email"], stripslashes($confirmationsubject), stripslashes($confirmationmessage));

		$adminmessage = $user["email"] . " has confirmed their subscription";
		if ($blacklisted) {
			$adminmessage .= "\nUser has been removed from blacklist";
		}
		
		//TODO: sendAdminCopy("List confirmation",$adminmessage);
		return $email;
	}
	//help user_model->update 
	public function send_emails($id){
		global $APP;
		
		if($this->_is_new){
			//subscribemessage
			$subscribesubject = $this->_parse_istance($APP->CONF->get("subscribesubject"));
			$subscribemessage = $this->_parse_istance($APP->CONF->get_user_config("subscribemessage",$id));
			  
			$subscribemessage = $this->_parse_lists_message($subscribemessage);
			//mail in copia
			$this->_send_mail($this->_new_user['email'], 
							  stripslashes($subscribesubject), 
							  stripslashes($subscribemessage),
							  1 //skipblacklistedcheck
							  );
			//sendAdminCopy("Lists subscription","\n".$email . " has subscribed\n\n$history_entry");
			
		}else{
			$updatesubject = $this->_parse_istance($APP->CONF->get("updatesubject"));
			$updatemessage = $this->_parse_istance($APP->CONF->get_user_config("updatemessage",$id));
			$updatemessage = $this->_parse_lists_message($updatemessage);
			$updatemessage = $this->_parse_userdata_message($this->_str_userdata_changed, $updatemessage);
			
			if($this->_email_changed){
				$newaddressmessage = ereg_replace('\[CONFIRMATIONINFO\]', $this->_get_user_config("emailchanged_text",$id), $updatemessage);
				$oldaddressmessage = ereg_replace('\[CONFIRMATIONINFO\]', $this->_get_user_config("emailchanged_text_oldaddress",$id), $updatemessage);
			} else {
			   	$updatemessage = ereg_replace('\[CONFIRMATIONINFO\]', "", $updatemessage);
			}
			//print($oldaddressmessage);die;	
			
			if($this->_email_changed){
				$this->_send_mail($this->_new_user['email'],
								stripslashes($updatesubject), 
								$newaddressmessage 
								);
				$this->_send_mail($this->_old_user['email'],
								stripslashes($updatesubject), 
								$oldaddressmessage
								);
				//$this->_send_admin_copy(
				//				"Lists information changed","\n".$this->_new_user['email'] . 
				//				" has changed their information.\n\nThe email has changed to {$this->_new_user['email']}.\n\n{$this->_history_entry}"
				//				); 
			}else{
				$this->_send_mail($this->_new_user['email'], 
								stripslashes($updatesubject), 
								stripslashes($updatemessage) 
								);
				//$this->_send_admin_copy("Lists information changed","\n".$this->_new_user['email'] . 
				//						" has changed their information\n\{$this->_history_entry}");
			}	
		}
	}
	//UTILS
	private function _send_mail($to, $subject, $message, $skipblacklistcheck = 0){
		global $APP;
		return $APP->MAILER->send_mail($to, $subject, $message, $skipblacklistcheck);
	}
	//help user_model->update 
	public function cache_old_user($old_user, $old_attributes){
		# read the current values to compare changes
		$this->_old_user = array_merge($old_user,$old_attributes);
	}
	//help user_model->update 
	public function cache_old_subscribe($old_subscribe){
		# and membership of lists
		$this->_old_subscribe = $old_subscribe; 
	}
	//help user_model->update 
	public function cache_new_user($new_user, $new_attributes){
		# read the current values to compare changes
		$this->_new_user = array_merge($new_user,$new_attributes);
	}
	//help user_model->update 
	public function cache_new_subscribe($new_subscribe){
		# and membership of lists
		$this->_new_subscribe = $new_subscribe;
	}
	public function cache_str_new_lists($str){
		# and membership of lists
		$this->_str_new_lists = $str;// 
	}
			
		
	//help user_dao->get_page_users
	public function prepare_sql_page_users(){
		
		$findby = $this->_param('findby');
		$find = $this->_param('find');
		$sortby = $this->_param('sortby');
		$unconfirmed = $this->_param('unconfirmed');
		$blacklisted = $this->_param('blacklisted');
		$sortorder = $this->_param('sortorder');
		$columns = array("messages","lists","bounces","rss","blacklist");
		
		$system_findby = array("email","foreignkey");
		if ($findby && $find && !in_array($findby,$system_findby) ) {
		  $find_url = '&find='.urlencode($find)."&findby=".urlencode($findby);
		  
		} else {
		  $findtables = '';
		  $findbyselect = sprintf(' %s like "%%%s%%"',$findby,$find);;
		  $findfield = $this->db->get_table("user").".bouncecount,".$this->db->get_table("user").".rssfrequency,".$this->db->get_table("user").".foreignkey";
		  $findfieldname = "Email";
		}
		
		$find_url = false;
		
		$table_list = $this->db->get_table("user").$findtables;
		if ($find) {
		    $listquery = "select {$this->db->get_table("user")}.email,{$this->db->get_table("user")}.id,$findfield,{$this->db->get_table("user")}.confirmed from ".$table_list." where $findbyselect";
		    if ($unconfirmed)
		      $listquery .= ' and !confirmed ';
		    if ($blacklisted)
		      $listquery .= ' and blacklisted ';
		} else {
		    $listquery = "select {$this->db->get_table("user")}.email,{$this->db->get_table("user")}.id,$findfield,{$this->db->get_table("user")}.confirmed from ".$table_list;
		
		    if ($unconfirmed || $blacklisted) {
		      $listquery .= ' where ';
		      if ($unconfirmed && $blacklisted) {
		        $listquery .= ' !confirmed and blacklisted ';
		      } elseif ($unconfirmed) {
		        $listquery .= ' !confirmed ';
		      } else {
		        $listquery .= ' blacklisted';
		      }
		    } else {
		      $searchdone = 0;
		    }
		}
		
		$url = getenv("REQUEST_URI");
		
		###order
		$order = '';
		if ($sortby) {
		  $order = ' order by ' . $sortby;
		  if ($sortorder == 'desc') {
		    $order .= ' desc';
		  } else {
		    $order .= ' asc';
		  }
		}else{
			$order = ' order by email';
		}
		
		$find_url .= "&amp;sortby=$sortby&amp;sortorder=$sortorder&amp;unconfirmed=$unconfirmed&amp;blacklisted=$blacklisted";
		$find_url .= "&unconfirmed=".$unconfirmed;
		return $listquery . $order ;
	}
	protected function _param($key){
		return isset($this->_params[$key]) ? $this->_params[$key] : false;
	}
	
	//UTILS 
	//help $this->send_emails
	private function _parse_istance($str){
		return ereg_replace('\[ISTANCE\]', TITLE_ISTANZA, $str);
	}
	//help $this->send_emails
	private function _parse_newemail_message($id,$message){
		global $APP;
		return ereg_replace('\[CONFIRMATIONINFO\]', $APP->CONF->get("emailchanged_text",$id), $message);
	}
	//help $this->send_emails
	private function _parse_oldemail_message($id,$message){
		global $APP;
		return ereg_replace('\[CONFIRMATIONINFO\]', $APP->CONF->get("emailchanged_text_oldaddress",$id), $message);
	}
	//help $this->send_emails
	private function _parse_lists_message($msg){
		return ereg_replace('\[LISTS\]', $this->_str_new_lists, $msg);
	}
	//help $this->send_emails
	private function _parse_userdata_message($datachange,$message){
		return ereg_replace('\[USERDATA\]', $datachange, $message);
	}

	
}