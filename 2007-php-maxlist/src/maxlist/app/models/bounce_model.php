<?php
/**
 * Project: maxlist <br />
 * Copyright (C) 2006 Massimiliano Balestrieri
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
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 1.0
 * @copyright 2006 Massimiliano Balestrieri.
 * @package Models
 */

class BounceModel extends ModuleModel{
	
	public function __construct($params = false){
		$this->_name = 'bounce';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
	}
	//call by processbounce::processbouncebatch_helper
	public function insert($msg_date, $header, $body){
		return $this->_dao->insert($msg_date, $header, $body);
	}
	public function bounced_list_message($msgid, $userid,$bounceid){
		return $this->_dao->bounced_list_message($msgid, $userid,$bounceid);
	}
	public function bounced_system_message($userid,$bounceid){
		return $this->_dao->bounced_system_message($userid,$bounceid);
	}
	public function bounced_unidentified_message($userid,$bounceid){
		return $this->_dao->bounced_unidentified_message($userid,$bounceid);
	}
	public function unidentified_bounce($bounceid){
		return $this->_dao->unidentified_bounce($bounceid);
	}
	public function get_page_bounces(){
		global $APP;
		$result = $this->_dao->get_page_bounces();
		$list_bounces = array();
		
		$user = $APP->get_model2("user");
		$message = $APP->get_model2("message");
		
		foreach ($result['data'] as $bounce){//($bounce = $this->db->sql_fetch_array($result)) {
		  #@@@ not sure about these ones - bounced list message
		  
		  if (preg_match("#bounced list message ([\d]+)#",$bounce["status"],$regs)) {
		    $messageid = $regs[1];
		  } elseif ($bounce["status"] == "bounced system message") {
		    $messageid = 'sys';
		  } else {
		    $messageid = 'unk';
		  }
		  
		  if (preg_match("#([\d]+) bouncecount increased#",$bounce["comment"],$regs) ||
		  	  preg_match("#([\d]+) marked unconfirmed#",$bounce["comment"],$regs)) {
		    $userid = $regs[1];
		  } else {
		    $userid = 'unk';
		  }
		  
		  $email = $user->get_email($userid);
		  $messagesubject = $message->get_subject($messageid);
		  
		  $list_bounces[] = array(
		  							'messageid' => $messageid,
		  							'messagesubject' => $messagesubject,
		  							'userid'=> $userid,
		  							'username'=> $email,
		  							'id'=>$bounce["id"],
		  							'date'=>$bounce["date"],
		  );
		  
		}
		return array('total' => $result['total'], 'data' => $list_bounces);
	}
	
	public function get($id){
		global $APP;
		$bounce = $this->_dao->get($id);
		$user = $APP->get_model2("user");
		if (preg_match("#([\d]+) bouncecount increased#", $bounce["comment"], $regs)) {
			$guessedid = $regs[1];
			$guessedemail = $user->get_email($guessedid);
		}

		return array (
			'id' => $id,
			'date' => $bounce["date"],
			'status' => $bounce["status"],
			'comment' => $bounce["comment"],
			'header' => nl2br(htmlspecialchars($bounce["header"])), 
			'data' => nl2br(htmlspecialchars($bounce["data"])), 
			'guessedemail' => $guessedemail
		);
	}
	//help userhistory_controller->get
	public function get_user_bounces($id){//TODO : spostare in bounce_model
		return $this->_dao->get_user_bounces($id);
	}
}