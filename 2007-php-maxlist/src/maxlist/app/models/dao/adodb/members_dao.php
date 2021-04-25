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
 * $Id: members_dao.php 358 2007-12-24 18:16:42Z maxbnet $
 * $LastChangedDate: 2007-12-24 19:16:42 +0100 (lun, 24 dic 2007) $
 * $LastChangedRevision: 358 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: https://maxlist.svn.sourceforge.net/svnroot/maxlist/trunk/maxlist/app/models/dao/members_dao.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-24 19:16:42 +0100 (lun, 24 dic 2007) $
 */


class MembersDao extends ModuleDao{
	
	public $table = false;
	public $db = false;
	
	private $_join_userstat_dao = false;
	public function __construct($params = false){
		global $APP;
		$this->db = $APP->ADODB_LITE;
		$this->table = $this->db->get_table('listuser');
		$this->_params = $params; 
		
		$this->_join_userstat_dao = $APP->get_dao('userstat');
	}
	//POST
	//model::model_user->update-> STEP subscribe
	public function subscribe($id,$params,$context = false){
		// qui deve arrivare sempre
		//$this->_params['subscribe'] è un array
		$this->_params = $params;
		
		# submitting page now saves everything, so check is not necessary
		$subselect = "";//TODO
		$subselect_where ="";//TODO
		if ($subselect == "") {
			$this->db->execute("delete from {$this->table} where userid = $id");
		} else {
		    # only unsubscribe from the lists of this admin
			$res = $this->db->sql_query("select id from {$this->db->get_table("list")} $subselect_where");
			foreach ($res as $row) {
				$this->db->execute("delete from {$this->table} where userid = $id and listid = $row[0]");
			}
		}
		$aff = false;
		if(count($this->_params['subscribe'])>0){
			foreach ($this->_params['subscribe'] as $ind => $lst) {
			   	$this->db->execute("replace into {$this->db->get_table("listuser")} (userid,listid) values($id,$lst)");
			   	is_numeric($aff) ? $aff++ : $aff = 1;
				
				if($context == 'fo')
			   		$this->_join_userstat_dao->add_subscriber_statistics('subscribe',1,$lst);
			}
		}
		return $aff;
	}
	public function unsubscribe($id){
		return $this->db->execute("delete from {$this->table} where userid = \"$id\"");
	}
	//help 
	//help model::unsubscribe_all
	public function get_members($id){
		$sql =  sprintf('SELECT userid FROM %s where listid = %d' ,$this->table,$id);
		return $this->db->sql_query($sql);
	}
	//help model::unsubscribe_checked, model::unsubscribe_all, model::move_all, model::move_checked 
	public function unsubscribe_list($userid , $listid){
		$sql = sprintf('delete from %s where userid = %d and listid = %d', $this->table, $userid , $listid);
		return $this->db->execute($sql);
	}
	//help model::copy_all, model::copy_checked,model::move_all, model::move_checked 
	public function subscribe_list($userid , $listid){
		$sql = sprintf('replace into %s (userid,listid) values(%d, %d)', $this->table, $userid , $listid);
		$aff = $this->db->execute($sql);
		if($aff == 2)
			$aff = 0;//replace
		return $aff;
	}
	public function get_page_members($id){
		$pg = $this->_params['pg'];
		
		$sql =  "SELECT {$this->db->get_table("user")}.id,email,confirmed,htmlemail FROM " .
		  		"{$this->table}," .
		  		"{$this->db->get_table("user")} " .
		  		"where " .
		  		"{$this->table}.listid = $id and " .
		  		"{$this->table}.userid = {$this->db->get_table("user")}.id " .
		    	"order by confirmed desc,email";
		
		$result = $this->db->sql_query_page($sql,$pg);
		$count = $this->db->count();
		$member = array();
		foreach($result as $row){
			//print_r($row);die;
			$member[$row['id']] = $this->_get_messagecount($row['id'], $id);
		}
		
		//TODO
	    /**if (sizeof($columns)) {
			  # let's not do this when not required, adds rather many db requests
			  //TODO: $attributes = getUserAttributeValues('',$user['id']);
			  
			#      foreach ($attributes as $key => $val) {
			#          $ls->addColumn($user["email"],$key,$val);
			#      }
			  /*TODO  
			  foreach ($columns as $column) {
			    if (isset($attributes[$column]) && $attributes[$column]) {
			      $ls->addColumn($user["email"],$column,$attributes[$column]);
			    }
			  }
	    }*/
		
		return array('total' => $count, 'data' => $result, 'members' => $member);
	}
	
	public function get_listuser_count($id){
		$count = $this->db->sql_fetch_row_query("select count(*) from {$this->table} where listid = {$id} ");
		return isset($count[0]) ? $count[0] : 0;
	}
	//help model::users_model->get_page_users ------------->user/edit, _prepare_history_entry + confirm + call by fo
	public function get_array_memberships($id){ //used by update & insert user. - 
		return $this->db->sql_query("select listid, name from {$this->table},{$this->db->get_table("list")} where listid = {$this->db->get_table("list")}.id and userid = $id");
	}
	//help model::get_html_lists,get_txt_lists, sendmail_model->sendemail
	public function get_userlists($userid){
		$sql = sprintf('select list.name from %s as list,%s as listuser where list.id = listuser.listid and ' .
									'listuser.userid = %d', 
									$this->db->get_table("list"), 
									$this->table, 
									$userid);
		
		return $this->db->sql_query($sql);
		
	}
	//help sendmail_model->sendemail
	public function get_txt_lists(){
			$lists = "";
			$listsarr = array ();
			while ($row = Sql_Fetch_Row($req)) {
				array_push($listsarr, $row[0]);
			}
			$lists_html = join('<br/>', $listsarr);
			$lists_text = join("\n", $listsarr);
	
	}
	//HELP
	//help list_dao -> call by get_lists
	public function fix_listuser(){
		//pulizia utenti senza lista
		$sql = "select * from {$this->table} left join {$this->db->get_table('user')} on userid = id where isnull(id)";
		$res = $this->db->sql_query($sql);
		foreach($res as $row){
			$sqldel = "delete from {$this->table} where userid = '$row[userid]' and listid = '$row[listid]'";
			$this->db->execute($sqldel);//ho capito perchè!
			$this->_log("il sistema ha eseguito una sql correttiva: ". $sqldel);	
		}
	}
	//PRIVATE
	//help get_page_members
	private function _get_messagecount($userid,$id){
		 $res = $this->db->sql_fetch_row_query("select count(*) from " .
		  	  			 "{$this->db->get_table("listmessage")}," .
		  	  			 "{$this->db->get_table("usermessage")} where " .
		  	  			 "{$this->db->get_table("listmessage")}.listid = $id and " .
		  	  			 "{$this->db->get_table("listmessage")}.messageid = {$this->db->get_table("usermessage")}.messageid and " .
		  	  			 "{$this->db->get_table("usermessage")}.userid = {$userid}");
		 return isset($res[0]) ? $res[0] : 0;   
	}
}