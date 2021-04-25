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
 * $Id: usermessage_dao.php 393 2008-01-18 18:09:49Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 393 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/dao/usermessage_dao.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 */

class UsermessageDao extends ModuleDao {

	public $table = false;
	public $db = false;

	public function __construct($params = false) {
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('usermessage');
		$this->_params = $params;

	}
	//help model::processqueue_model->_success_send_email
	//help model::processqueue_model->_unconfirmed_email
	//help model::processqueue_model->_invalid_email
	public function set_status($messageid ,$userid, $msg){
		return $this->db->execute("replace into {$this->table} (entered,userid,messageid,status) values(now()," .
						"$userid,$messageid,\"$msg\")");
	}
	//help model::processqueue_model->_check_lastbatch (substep)
	public function get_recently_sended($batch_period){
		$sql = sprintf('select count(*) from %s where date_add(entered,interval %d second) > now() and ' .
												  'status = "sent"', $this->table, $batch_period);
		$res = $this->db->fetch_query($sql);
		return isset($res[0]) ? $res[0] : 0;
	}
	//help model::processqueue_model->_send_message (STEP 4)
	public function get($messageid ,$userid){
		//echo "select entered from {$this->table} where userid = $userid and messageid = $messageid";die;
		return $this->db->fetch_query("select entered from {$this->table} where userid = $userid and messageid = $messageid");
	}
	//help model :: statistics_model
	public function get_viewed($id){
		$uniqueviews = $this->db->fetch_query("select count(userid) from " .
													"{$this->table} where " .
													"viewed is not null and " .
													"messageid = ".$id);
		return isset($uniqueviews[0]) ? $uniqueviews[0] : 0;     
	}
	//help model::user_model->get_page_users
	public function get_user_number_messages($userid){
		 $msgs = $this->db->fetch_query("SELECT count(*) FROM ".$this->db->get_table("usermessage")." where userid = ".$userid);
		 return isset($msgs[0]) ? $msgs[0] : 0;
	}
	//help model::userhistory_controller->get
	public function get_user_messages_data($id){
		$msgs = $this->db->query(sprintf('select messageid,entered,viewed,(viewed = 0 or viewed is null) as notviewed,
		  abs(unix_timestamp(entered) - unix_timestamp(viewed)) as responsetime from %s where userid = %d and status = "sent"',
		  $this->table,$id));
		$num_msg = $this->db->count();
		return array('total'=>$num_msg,'data' => $msgs);
	}
}