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
 * $Id: user_dao.php 393 2008-01-18 18:09:49Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 393 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/dao/user_dao.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 */


class UserDao extends ModuleDao{
	
	private $_helper = false;
	
	public $table_lu = false;
	public $table_lm = false;
	public $table_um = false;
	public function __construct($params = false){
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('user');
		$this->table_lu = $this->db->get_table('listuser');
		$this->table_lm = $this->db->get_table('listmessage');
		$this->table_um = $this->db->get_table('usermessage');
		$this->_params = $params;
		
		$this->_helper = $APP->get_helper("user", $this->_params);//IMPORTANT.
	}
	//GET model::user_controller->edit
	public function get($id){
		return $this->db->fetch_query("SELECT * FROM {$this->table} where id = $id");
	}
	//GET model::user_controller->listall
	public function get_page_users(){
		$pg = $this->_params['pg'];
		$lists = $nummsg = array(); 
		$sql = $this->_helper->prepare_sql_page_users();
		//$result = $this->db->sql_query_page($sql,$pg);
		//echo $sql;die;
		$result = $this->db->get_select_page($sql,$pg);
		
		$count = $this->db->count();
		return array('total' => $count, 'data' => $result);
	}
	//GET - exception
	public function confirm($id){
		return $this->db->execute("update {$this->table} set confirmed = 1,blacklisted = 0 where id = ".$id);
	}
	//POST
	
	public function delete($id){
	  	//delegate models ?
	  	$this->db->execute(sprintf('delete from %s where userid = %d',$this->db->get_table("listuser"),$id));
		$this->db->execute(sprintf('delete from %s where userid = %d',$this->db->get_table("user_attribute"),$id));
		$this->db->execute(sprintf('delete from %s where userid = %d',$this->db->get_table("usermessage"),$id));
		$this->db->execute(sprintf('delete from %s where user = %d',$this->db->get_table("user_message_bounce"),$id));
  		$this->db->execute(sprintf('delete from %s where userid = %d',$this->db->get_table("user_history"),$id));
  		$this->db->execute(sprintf('delete from %s where userid = %d',$this->db->get_table("user_rss"),$id));
  		
  		return $this->db->execute(sprintf('delete from %s where id = %d',$this->table,$id));
	}
	//POST
	public function insert($params = false){
		if($params)
			$this->_params = $params;//important EXTERNAL CONTEXT
		
		//STEP 1 update e insert
		$sql = sprintf('insert into %s set email = "%s",entered = now(),modified = now(),password = "",
									passwordchanged = now(),disabled = 0,uniqid = "%s",htmlemail = 1',
									$this->table,
									$params['user']['email'],
									$this->_get_uniqid());
		//insert into user db
		return $this->db->insert($sql);
	}
	//POST
	public function update($id, $params = false){
		if($params)
			$this->_params = $params;//important EXTERNAL CONTEXT
		$updated = $this->_update($id,$this->_params['user']);
		return $updated;
	}
	//POST - unsubscribe
	public function blacklist($email){
		return $this->db->execute(sprintf('update %s set blacklisted = 1 where email = "%s"',
						$this->table,stripslashes($email)));
	}
	//POST confirm
	public function un_blacklist($email){
		return $this->db->execute(sprintf('update %s set blacklisted = 0 where email = "%s"',
						$this->table,stripslashes($email)));
	}
	//HELP OTHER
	//help attribute_dao::fix_users
	public function get_array_id_users(){
		return $this->db->query("SELECT id FROM {$this->table}");
	}
	//help model::members_controller->new
	public function insert_member($params){
		//STEP 1 update e insert
		$sql = sprintf('insert into %s set email = "%s",' .
					   'entered = now(),' .
					   'modified = now(),' .
					   'password = "",' .
					   'passwordchanged = now(),' .
					   'disabled = 0,' .
					   'uniqid = "%s",' .
					   'htmlemail = %d,'.
					   'confirmed = %d ',
					    //'disabled = %d, '.
					    //'blacklisted = %d, '.
					    $this->table,
						$params['email'],
						$this->_get_uniqid(),
						$params['htmlemail'],
					    $params['confirmed']//TODO:
					      //$params['disabled'],
					      //$params['blacklisted'],
					   );
		//echo $sql;die;
		return $this->db->insert($sql);
	}
	
	//help model::member_controller->set_html
	public function set_html($userid){
		return $this->db->execute(sprintf('update %s set htmlemail = 1 where id = %d', 
						$this->table, $userid));
	}
	//help model::processbouncebatch_helper
	public function increase_bouncecount($userid){
		return $this->db->execute(sprintf('update %s set bouncecount = bouncecount + 1 where id = %d', 
						$this->table, $userid));
	}
	//help model::processbouncebatch_helper
	public function set_unconfirmed($id){
		return $this->db->execute(sprintf('update %s set confirmed = 0 where id = "%s"',
						$this->table,$id));
	}
	//help model::processqueue_model->_get_users
	public function get_users_tosend($messageid, $userconfirmed, $exclusion, $user_attribute_query, $num_to_send = false){
		$query = sprintf('select 
					distinct user.id from
				    %s as listuser,
				    %s as user,
				    %s as listmessage
				    where
				    listmessage.messageid = %d and
				    listmessage.listid = listuser.listid and
				    user.id = listuser.userid %s %s %s', 
				    $this->table_lu, 
				    $this->table, 
				    $this->table_lm, 
				    $messageid, 
				    $userconfirmed, 
				    $exclusion, 
				    $user_attribute_query);
		
		//if($num_per_batch)
			//$query .= sprintf(' limit 0,%d',$num_per_batch);#disabled in phplist?
				
		//echo $query;
		$this->_log($query);
		
		//no limit
		//per ogni utente riempio fino a max_batch lo user se e solo se um è vuoto.
		$ret = array();
		$users = $this->db->query($query);
		
		foreach($users as $user){
			if($num_to_send && sizeof($ret) == $num_to_send)
				return $ret;
			
			//usermessage_dao->get		
			$um = $this->db->fetch_query("select entered from {$this->table_um} where userid = {$user['id']} and messageid = $messageid");
			
			if(!$um)
				$ret[]['id'] = $user['id'];
				 
		}
		//print_r($ret);die;
		return $ret;
	}
	//help model::processbouncebatch_helper
	public function get_id_by_email($email){
	    $rs = $this->db->fetch_query(sprintf('select id ' .
	    									'from %s where email = "%s"',$this->table,$email));
	    return isset($rs[0]) ? $rs[0] : false;
	}
	//help model::message_controller->send_test
	public function get_by_email($email){
	    return $this->db->fetch_query(sprintf('select id,email,uniqid,htmlemail,rssfrequency,confirmed ' .
	    									'from %s where email = "%s"',$this->table,$email));
	}
	//help bounce_model->get_page_bounces
	public function get_email($userid){
		$res = $this->db->fetch_query("select email from  ". $this->table."  where id = '$userid'");
		return isset($res['email']) ? $res['email'] : false;
	}
	//help model::CONF helper
	public function get_uniqid_by_id($id){
		$result = $this->db->fetch_query("SELECT uniqid FROM {$this->table} where id = '$id'");
		return isset($result[0]) ? $result[0] : die("<!-- get_uniqid_by_id -->");
	}
	//help model::subscribe_controller->confirm
	public function get_id_by_uniqid($id){
		$result = $this->db->fetch_query("SELECT id FROM {$this->table} where uniqid = '$id'");
		return isset($result[0]) ? $result[0] : die("<!-- get_id_by_uniqid -->");
	}
	//VALIDATE
	public function email_not_exist($email) {
		$aff = $this->db->fetch_query("select count(*) from ".$this->table." where email = '".$email."'");
		return isset($aff[0]) && $aff[0] == 0 ? true : false; 
	}
	//PRIVATE
	//help insert
	private function _get_uniqid($table = "") {
		do{
			$id = md5(uniqid(mt_rand()));
		}while($this->_verify_uniqid($id));
		
		return $id;
	}
	//help insert->_get_uniqid
	private function _verify_uniqid($id){
		$res = $this->db->query("select id from {$this->table} where uniqid = \"$id\"");
		isset($res[0]) ? false : true;
	}
	//UPDATE private
	private function _update($id,$params){
		//i parametri me li aspetto completi: attenzione al recupero delle checkbox
		//TODO : subselect
		//$subselect = '';//sprintf(' and %s.owner = %d',$tables["list"],$_SESSION[VERSION]["logindetails"]["id"]);
		//$subselect_where = '';//sprintf(' where %s.owner = %d',$tables["list"],$_SESSION[VERSION]["logindetails"]["id"]);
		$query = sprintf( 'update %s  set  '.
					      'email = "%s", '.
					      'htmlemail = %d, '.
					      'confirmed = %d, '.
					      //'disabled = %d, '.
					      //'blacklisted = %d, '.
					      'modified = "%s" '.
					      'where id  =  %d',
					      $this->table,
					      $params['email'],
					      $params['htmlemail'],
					      $params['confirmed'],//TODO:
					      //$params['disabled'],
					      //$params['blacklisted'],
					      date("Y-m-d H:i:s"),
					      $id);
		//echo $query;die;
		$aff = $this->db->execute($query);
		
		return $aff;
	}
}
