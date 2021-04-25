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
 *
 * Maxlist is a fork of PhpList, a newsletter manager. 
 * The code was deeply changed so there are features of the original phpList and new ones. 
 * It uses smarty, generates XHTML strict, uses an AJAX layer, italian language ,
 * multi-istance, and use case based.
 *
 * 
 * $Id: admin_dao.php 323 2007-11-26 18:23:10Z maxbnet $
 * $LastChangedDate: 2007-11-26 18:23:10 +0000 (Mon, 26 Nov 2007) $
 * $LastChangedRevision: 323 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/dao/old/admin_dao.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-11-26 18:23:10 +0000 (Mon, 26 Nov 2007) $
 */

class AdminDao extends ModuleDao{
	
	public $table = false;
	public $db = false;
	
	//temp 
	private $where = '';
	
			
	public function __construct(){
		global $APP;
		$this->table = $APP->DB->get_table('admin');
		$this->db = $APP->DB;
	}
	//GET admin
	public function get_page_admins(){
		global $APP;
		
		$params = $this->_params;
		$this->_set_where();
		
		if ($find = $params['filter']) 
		    $result = $this->db->sql_query("SELECT count(*) FROM ".$this->table." where 1=1 $this->where");
		else
		    $result = $this->db->sql_query("SELECT count(*) FROM ".$this->table." where loginname like \"%$find%\" or email like \"%$find%\" $this->where");
		
		$totalres =  $this->db->sql_fetch_row($result);
		$total = $totalres[0];
		
		$listing = '';
		$dolist = 1;
		
		$mysql_pg = $params['pg'] - 1;
		$limit_block = MAX_USER_PP * $mysql_pg;
		
		if ($total > MAX_USER_PP) {
		  if ($params['pg']) {
		    $limit = " limit $limit_block,".MAX_USER_PP;
		  } else {
			$limit = " limit 0,".MAX_USER_PP;
		  }
		  if ($find)
		    $sql = "SELECT id,loginname,email FROM ".$this->table." where loginname like \"%$find%\" or email like \"%$find%\" $this->where order by loginname $limit";
		  else
		    $sql = "SELECT id,loginname,email FROM ".$this->table." where 1=1 $this->where order by loginname $limit";
		} else {
		  if ($find)
		    $sql = "select id,loginname,email from ".$this->table." where loginname like \"%$find%\" or email like \"%$find%\" $this->where order by loginname";
		  else
		    $sql = "select id,loginname,email from ".$this->table." where 1=1 $this->where order by loginname";
		}
		
		$result =  $this->db->sql_query($sql);
		$admins = array();
		while ($admin =  $this->db->sql_fetch_array($result)) {
		  
		  $admins[] = array(
		  						'id' => $admin["id"],
		  						'loginname' => $admin["loginname"]
		  );
		}
		
		if(sizeof($admins)==0 && !isset($_REQUEST['search'])){
			$APP->MSG->info("Non sono presenti amministratori");
		}
		
		return array('admins' => $admins,'total' => $total);
	}
	public function update($id){
		global $APP;
		if ($id>0) {
		  	$schema = $APP->SCHEMA->get("admin");
		    while (list ($key,$val) = each ($schema)) {
			  if(strpos($val[1],":")>0){
					list($a,$b) = explode(":",$val[1]);
			  }else{
			    	$a = $val[1];	
			  }
			  if($value = $APP->REQUEST->post($key)){
				  $value == "on" ? $value = 1: $value = $value;
		      	  if (!ereg("sys",$a) && $val[1]) {
					if ($key == "password" && ENCRYPTPASSWORD) {
					   		if (strlen($value)>0 ){
					       		$this->db->sql_query("update {$this->table} set $key = \"".md5($value)."\" where id = $id");
					   		}
					   } else {
					   		$this->db->sql_query("update {$this->table} set $key = \"".addslashes($value)."\" where id = $id");
					   }
				  }
			  }elseif ($key == "modified"){
			   	$this->db->sql_query("update {$this->table} set $key = \"".date("Y-m-d H:i:s")."\" where id = $id");
			      }
			  }
		 }
		return $id;
		//TODO : admin attributes
		/*
		if (is_array(@$_POST["attribute"]))
	      while (list($key,$val) = each ($_POST["attribute"])) {
	      	$this->db->sql_query(sprintf('replace into %s (adminid,adminattributeid,value)
	          values(%d,%d,"%s")',$tables["admin_attribute"],$id,$key,addslashes($val)));
	      }
	    $this->db->sql_query(sprintf('update %s set modifiedby = "%s" where id = %d',$tables["admin"],adminName($_SESSION[VERSION]["logindetails"]["id"]),$id));
		
		$attribute = @$_POST['attribute'];
		$cbattribute = @$_POST['cbattribute'];
	  	if (is_array($cbattribute)) {
		    while (list($key,$val) = each ($cbattribute)) {
			  if (@$attribute[$key] == "on")
		        $this->db->sql_query(sprintf('replace into %s (adminid,adminattributeid,value)
		          		values(%d,%d,"on")',$tables["admin_attribute"],$id,$key));
		      else
		        $this->db->sql_query(sprintf('replace into %s (adminid,adminattributeid,value)
		     		    values(%d,%d,"")',$tables["admin_attribute"],$id,$key));
		    }
	  	}
		
		$cbgroup = @$_POST['cbgroup'];
	    if (is_array($cbgroup)) {
		    while (list($key,$val) = each ($cbgroup)) {
		      $field = "cbgroup".$val;
		      
		      if (is_array(@$_POST[$field])) {
		        $newval = array();
		        foreach ($_POST[$field] as $fieldval) {
		          array_push($newval,sprintf('%0'.$checkboxgroup_storesize.'d',$fieldval));
		         }
		        $value = join(",",$newval);
		      }
		      else
		        $value = "";
		        
		        
		      $sql = sprintf('replace into %s (adminid,adminattributeid,value)
		        values(%d,%d,"%s")',$tables["admin_attribute"],$id,$val,$value);
		      $this->db->sql_query($sql);
		    }
	  	}
	    addPublicSessionInfo("I dati dell'amministratore sono stati salvati.");
	  	logEvent("I dati dell'amministratore ".strtolower(normalize($_POST["loginname"]))." sono stati salvati da ".adminName());
	    if(!isSuperUser() && !isRoleAdmin()){
	    	myRedirect("view=admin");
	    }else{
	    	myRedirect("view=admins");
	    }
		*/
	}
	public function check_username($username){
		$req = $this->db->sql_fetch_row_query(sprintf('select id from %s where loginname = \'%s\'',$this->table,$username));
  		return $req[0] ? false : true;
	}
	public function insert($loginname){
		global $APP;
		$this->db->sql_query(sprintf('insert into %s (namelc,created) values("%s",now())',$this->table,$loginname));
		$id = $this->db->sql_insert_id();
		return $this->update($id);    
	}
	public function delete($id){
		# delete the index in delete
		$this->db->sql_query(sprintf('delete from %s where id = %d',$this->table,$id));
		$aff = $this->db->sql_affected_rows();
		if($aff){
			$this->db->sql_query(sprintf('delete from %s where adminid = %d',$this->db->get_table("admin_attribute"),$id));
			return $aff;
		}
		return false;			
	}
	public function get_username($id){
		$req = $this->db->sql_fetch_row_query(sprintf('select loginname from %s where id = %d',$this->table,$id));
  		return $req[0] ? $req[0] : die("<!-- get_username() -->");
	}
	
	public function get_role($id){
		//TODO: remove role
		$req = $this->db->sql_fetch_row_query(sprintf('select role from %s where id = %d',$this->table,$id));
  		return $req[0] ? $req[0] : die("<!-- get_username() -->");
	}
	public function get_admins(){
		$data = $this->db->sql_query(sprintf('select * from %s ',$this->table));
		$ret = array();
		while($row = $this->db->sql_fetch_array($data))
		   	$ret[] = $row;
		
		return $ret;
	}
	public function get($id){
		
		global $APP;
		$role = $APP->SESSION->get_role();		
		if(!($is_root = $APP->ROLE->is_super_user()) && !($admin = $APP->ROLE->is_super_user())){
			$id = $APP->SESSION->get_auth_id();
		}	
		
		
		if ($id) {
		  $result = $APP->DB->sql_query("SELECT * FROM {$this->table} where id = $id");
		  $data = $APP->DB->sql_fetch_array($result);
		  //verifico se non sia di un ruolo superiore
		  if($data['role']<$role){
		  	return false;
		  }
		} else {
		  $data = array();
		}
		
		return $data;
		
	}
	
	private function _set_where(){
		
		global $APP;
		$role = $APP->SESSION->get_role();
		
		switch ($role){
			case 2://admin
			$id = $APP->SESSION->get_auth_id();
			$this->where = " and(id='". $id ."' or role >= '".$role."')";
			break;
		}
		
	}
} 
