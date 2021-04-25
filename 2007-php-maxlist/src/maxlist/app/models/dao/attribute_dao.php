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
 * $Id: attribute_dao.php 393 2008-01-18 18:09:49Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 393 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/dao/attribute_dao.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 */

class AttributeDao extends ModuleDao {

	public $table = false;
	public $attribute_table = false;
	public $attribute_table_attribute_fk = false;
	public $attribute_table_user_fk = false;
	public $attribute_table_items_prefix = false;
	public $db = false;

	public function __construct($params = false, $entity = 'user') {
		global $APP;
		$this->db = $APP->DB;
		$this->_set_tables($entity);
		$this->_params = $params;
	}
	//GET
	public function get_attributes() {
		return $this->db->query("select * from {$this->table} order by listorder");
	}
	public function get_values($attributes, $id){
		$values = array();
		foreach($attributes as $attr){
			//precedenza post/db/default
			$values[$attr['id']] = $this->get_value($id,$attr['id'],$attr['default_value'],$attr['type']);
		}
		//print_r($values);die;
		return $values;
	}
	public function get_db_values($attributes, $id){
		foreach($attributes as $attr){
			//precedenza post/db/default
			$values[$attr['id']] = $this->get_db_value($id,$attr['id']);
		}
		//print_r($values);die;
		return $values;
	}
	public function get_db_value($userid, $attrid){
		$sql = "select value from {$this->attribute_table} where " .
				   "{$this->attribute_table_user_fk} = {$userid} and " .
				   "{$this->attribute_table_attribute_fk} = {$attrid}";
		$res = $this->db->fetch_query($sql);
		return isset($res['value']) ? $res['value'] : false;
	}
	public function get_value($userid, $attrid, $default, $type){
		//TODO:$field_request = @$_REQUEST["cbgroup".$row["id"]];
		//$params = ($type == 'checkbox') ? $this->_params['cbattribute'] : $this->_params['attribute'];
		if(isset($params[$attrid])){
			return $params[$attrid];
		}elseif($userid > 0){
			return $this->get_db_value($userid, $attrid);
		}else{
			//TODO:if(!($row["type"] == "checkbox" && $this->submit && isset($_REQUEST[$this->submit]))){	
			return $default;	
		}
	}
	public function get_attribute($id){
		return $this->db->fetch_query("select * from {$this->table} where id = $id");
 		//echo "select * from {$this->table} where id = $id";print_r($data);die;
	}

	//VALUES
	public function update_value($userid,$key,$val){
		$sql = sprintf('replace into %s (userid,attributeid,value) values(%d,%d,"%s")',
											$this->attribute_table,$userid,$key,$val);
		//echo $sql . "<br>";
		return $this->db->execute($sql);
	}
	//FIELDS
	public function insert($att) {
		$sql = sprintf('insert into %s (name,type,listorder,default_value,required,tablename) values("%s","%s",%d,"%s",%d,"%s")',
						$this->table,
						$att['name'],
						$att['type'],
						$att['listorder'],
						$att['default'],
						$att['required'],
						$att['lc_name']);
		return $this->db->insert($sql);
	}
	public function update($att){
		$query = sprintf('update %s set name = "%s" ,listorder = %d,default_value = "%s" ,required = %d where id = %d',
	        			$this->table,
	        			$att['name'],
	        			$att['listorder'],
	        			$att['default'],
	        			$att['required'],
	        			$att['id']);
	    //echo $query;die;
		return $this->db->execute($query);
	}
	public function get_tablename($id){
		$res = $this->db->fetch_query("select tablename from $this->table where id = $id");
		return isset($res['tablename']) ? $res['tablename'] : die("<!--Errore di sistema. Non &egrave; stata trovata la tabella dell'attributo.-->");  
	}
	public function check_tablename($lc_name){
		return $this->db->query("select * from $this->table where tablename = \"$lc_name\"");		
	}
	public function fix_required($id){
		# with a checkbox we know the values
		#$this->db->sql_query'insert into '.$table_prefix.'listattr_'.$lc_name.' (name) values("Checked")');
		#$this->db->sql_query'insert into '.$table_prefix.'listattr_'.$lc_name.' (name) values("Unchecked")');
		# we cannot "require" checkboxes, that does not make sense
		
		# idem for hidden (MAX)
		$this->db->execute("update {$this->table} set required = 0 where id = $id");
	}
	public function get_type($id){
		$data = $this->db->fetch_query("select type from {$this->table} where id = $id");
 		//echo "select * from {$this->table} where id = $id";print_r($data);die;
 		return isset($data["type"]) ? $data["type"] : false;
	}
	public function fix_users($insertid){
		# fix all existing users to have a record for this attribute, even with empty data
		global $APP;
		$users = $APP->get_model2('user')->get_array_id_users();
		foreach($users as $user){
			$this->db->insert(sprintf('insert ignore into %s (%s,%s) values(%d,%d)',
							  $this->attribute_table,
							  $this->attribute_table_attribute_fk,
							  $this->attribute_table_user_fk,
							  $insertid,
							  $user));
		}
	}
	public function delete($delete) {
		# check for dependencies
		//$req = $this->db->sql_query("select * from formfield where attribute = $id");
		$this->_drop_tablename($delete);
		$aff = $this->db->execute("delete from {$this->table} where id = $delete");

		# delete all user attributes as well
		$this->db->execute("delete from {$this->attribute_table} where {$this->attribute_table_attribute_fk} = $delete");
		
		return $aff;
	}
	public function get_dependencies($id, $delete){
		# check dependencies
		$dependencies = array();
		$result = $this->db->query("select distinct {$this->attribute_table_user_fk} from {$this->attribute_table} where " .
				 					   "{$this->attribute_table_attribute_fk} = $id and value = $delete");
		foreach($result as $row){
			array_push($dependencies,$row[$this->attribute_table_user_fk]);
		}
		//print_r($dependencies);die;
		return $dependencies;
	}
	//ITEMS
	public function get_items($table){
		$table = $this->_tablename($table);
		return $this->db->query("SELECT * FROM $table order by listorder,name");
	}
	public function create_table($lc_name){
		# text boxes and hidden fields do not have their own table
		$table_name = $this->db->get_prefix() . $this->attribute_table_items_prefix . $lc_name; 
		//echo $table_name ;die;
		$query = "create table ".$table_name.
				 "(id integer not null primary key auto_increment, name varchar(255) unique,listorder integer default 0)";
		$this->db->execute($query);
	}
	public function get_lastorder($table){
		$table = $this->_tablename($table);
		$list = $this->db->fetch_query("select listorder from $table order by listorder desc");
		$lastorder = @$list[0] + 1;
		return $lastorder;
	}
	public function insert_item($table, $val, $order){
		$table = $this->_tablename($table);
		$query = sprintf('INSERT ignore into %s (name,listorder) values("%s","%d")',$table,$val,$order);
		return $this->db->insert($query);
	}
	public function delete_item($table, $id, $delete) {
		$table = $this->_tablename($table);
		# delete the index in delete
		//$valreq = $this->db->sql_fetch_array_query("select name from $table where id = $delete");
		//$val = $valreq[0];
		return $this->db->execute("delete from $table where id = $delete");
	}
	public function set_item_order($table, $id, $order) {
		$table = $this->_tablename($table);
		return $this->db->execute("update $table set listorder = $order where id = $id");
	}
	public function get_all_items($table){
		$table = $this->_tablename($table);
		return $this->db->query("select id from $table");
	}
	//PRIVATE ITEMS
	private function _drop_tablename($id){
		$row = $this->db->fetch_query("select tablename,type from {$this->table} where id = $id");
		if(isset($row[0])){
			$table = $this->_tablename($row[0]);
			$sql = "drop table if exists " . $table;
			$this->db->execute($sql);
		}
	}
	//PRIVATE
	private function _set_tables($entity){
		switch($entity){
			case 'adminattribute':
				$this->table = $this->db->get_table('adminattribute');
				$this->attribute_table = $this->db->get_table('admin_attribute');
				$this->attribute_table_attribute_fk = 'adminattributeid';
				$this->attribute_table_user_fk = 'adminid';
				$this->attribute_table_items_prefix = 'z_adminattr_';
			break;
			default:
				$this->table = $this->db->get_table('attribute');
				$this->attribute_table = $this->db->get_table('user_attribute');
				$this->attribute_table_attribute_fk = 'attributeid';
				$this->attribute_table_user_fk = 'userid';
				$this->attribute_table_items_prefix = 'z_listattr_';
			break;
		}
	}
	private function _tablename($table_noprefix){
		return $this->db->get_prefix() . $this->attribute_table_items_prefix . $table_noprefix;
	}
}