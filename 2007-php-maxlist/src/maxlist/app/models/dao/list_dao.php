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
 * $Id: list_dao.php 393 2008-01-18 18:09:49Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 393 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/dao/list_dao.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 */


class ListDao extends ModuleDao{
	
	public $table = false;
	public $db = false;
	
	private $_join_listuser = false;
	private $_join_listmessage = false;
	
	public function __construct($params = false){
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('list');
		$this->_params = $params; 
		
		//join 
		$this->_join_listuser = $APP->get_dao('members');//table listuser
		$this->_join_listmessage = $APP->get_dao('listmessage');//table listmessage
	}
	//list
	public function get($id){
		$count = $this->_join_listuser->get_listuser_count($id);
		$list = $this->db->fetch_query("SELECT * FROM {$this->table} where id = {$id}");
		$count = isset($count[0]) ? $count[0] : 0;
		return array ('data' => $list , 'countmsg' => $count );
	}
	public function get_lists(){//TODO: method in user_model. delete?
		$lists = array();
		$this->_join_listuser->fix_listuser();
	 	return $this->db->query("SELECT * FROM {$this->table} order by listorder");
	}
	//POST list
	public function set_order($operatore, $ordine_originale){
		//print_r($ordine_originale);die;
		$operatore_inverso = $operatore == " - " ? " + " : " - ";
		$sql = sprintf('update %s set listorder = (listorder %s 1) where listorder = (%d %s 1)', $this->table,$operatore_inverso,$ordine_originale[1],$operatore);
		$aff = $this->db->execute($sql);
		$sql = sprintf('update %s set listorder = (listorder %s 1) where id = %d', $this->table,$operatore,$ordine_originale[0]);
		$aff2 = $this->db->execute($sql);
		return $aff && $aff2;
	}
	public function set_active($active,$key){
		//if(isSuperUser() || isRoleAdmin()){
		return $this->db->execute(sprintf('update %s set active = %d where id = %d',$this->table,$active,$key));
	}
	//call by listmodel 
	public function get_order($key){
		$sql = sprintf('select id, listorder from %s where id = %d', $this->table,$key);
		$rec = $this->db->fetch_query($sql);
		return isset($rec[1])? $rec : false;
	}
	//call by listmodel 
	public function is_owner($key){
		$owner = $this->db->fetch_query(sprintf('select owner from %s where id = %d',$this->table,$key));
		return isset($owner[0]) ? $owner[0] : false; 
	}
	
	public function insert(){
		$params = $this->_params['list'];
		$num_cat = $this->db->fetch_query("select listorder from ".$this->table." order by listorder desc");
		
		$query = sprintf('insert into %s
						  (name,description,entered,owner,listorder,prefix,rssfeed,active)
						  values("%s","%s",now(),%d,%d,"%s","%s",%d)',
							$this->table,
							$params["name"],
							$params["description"],
							$params["owner"],
							(@$num_cat[0]+1),
							'',//$params["prefix"],
							'',
							isset($params["active"]) ? 1 : 0
							);
		//echo $query;die;
		return $this->db->insert($query);
	}
	public function update($id){
		if ($id > 0) {
			$params = $this->_params['list'];
			$query = sprintf('update %s set name="%s",description="%s",active=%d,prefix = "%s", owner = %d, rssfeed = "%s" where id=%d',
							$this->table,
							$params["name"],
						    $params["description"],
						    isset($params["active"]) ? 1 : 0,
						    '',//$params["prefix"],
						    $params["owner"],
						    '',//$params["rssfeed"],
						    $id);
		    return $this->db->execute($query);
		} 
	}
	public function delete($id){
		$list = $this->db->fetch_query("SELECT name FROM $this->table where id = '".$id."'");
		if($this->_check_owner($id) && $this->_check_users($id)){
			# delete the index in delete
			$aff = $this->db->execute("delete from $this->table where id = $id");
			$aff2 = $this->db->execute("delete from {$this->db->get_table("listuser")} where listid = $id");
			$aff3 = $this->db->execute("delete from {$this->db->get_table("listmessage")} where listid = $id");
			return $aff;
		}
		return false;	
	}
	
	public function is_writable($owner){
		return true;//TODO
	}
	
	/////////////////////HELP OTHER///////////////////
	//help model::subscribe_controller->subscribe preferences
	public function get_lists_active(){//TODO: method in user_model. delete?
		$lists = array();
		return $this->db->query("SELECT * FROM {$this->table} where active = 1 order by listorder");
	}
	//model :: members
	public function get_other_lists($id){
		$subselect = "";
		return $this->db->query("select id,name from {$this->table} $subselect");
		
	}
	//members
	public function get_list_name($id){
		$req = $this->db->fetch_query(sprintf('select name from %s where id = %d',$this->table,$id));
		return $req[0] ? stripslashes($req[0]) : die("<!-- method get_list_name-->");
	} 
	/////////////////////HELP///////////////////
	//call by delete
	private function _check_owner($id){
		global $APP;
		$list = $this->db->fetch_query("SELECT owner,name FROM $this->table where id = '".$id."'");
		if(isset($list['owner']) && $this->is_writable($list['owner'])){
			return true;
		}else{
			$this->_log(LOG_MAIL_LEVEL, $this->_('list_security_error'));
			$this->_redirect('list');//TODO: right? 
		}
	}
	//call by delete
	private function _check_users($id){
		$count = $this->_join_listuser->get_listuser_count($id);
	 	if(isset($count[0]) && $count[0]>0){
			$this->_flash(0,$this->_('list_no_empty'));
			$this->_redirect('list');
		}else{
			return true;
		}
	}
}