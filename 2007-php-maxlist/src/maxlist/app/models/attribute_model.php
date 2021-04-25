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
 * $Id: attribute_model.php 365 2008-01-05 18:32:37Z maxbnet $
 * $LastChangedDate: 2008-01-05 18:32:37 +0000 (Sat, 05 Jan 2008) $
 * $LastChangedRevision: 365 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/attribute_model.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-05 18:32:37 +0000 (Sat, 05 Jan 2008) $
 */


class AttributeModel extends ModuleModel{
	
	private $_types =  array('textline','hidden','checkbox','textarea','select','checkboxgroup','radio');
	private $_types_with_tables = array('select','checkboxgroup','radio');
	private $_types_no_required = array('checkbox','hidden');
	private $_entity = 'user';
	
	private $_helper_html = false;
	
	public function __construct($params = false , $entity = 'user'){
		$this->_name = 'attribute';
		require_once(dirname(__FILE__) . '/dao/attribute_dao.php');
		$this->_dao = new AttributeDao($params,$entity);
		$this->_params = $params;
		$this->_entity = $entity;
		
		global $APP;
		$this->_helper_html = $APP->get_helper('attributeform', $this->_types);
	}
	//PUBLIC
	//GET
	public function get_types(){
		return $this->_types;
	}
	public function get_attributes(){
		$attributes = $this->_dao->get_attributes();
		return $attributes;
	}
	public function get_attribute($id){
		return $this->_dao->get_attribute($id);
	}
	public function get_items($id, $data){
		if(!in_array($data['type'], $this->_types_with_tables))
	    	die('This datatype does not have editable values');
		
		$table = $this->_get_tablename($id);
		return $this->_dao->get_items($table);
	}
	public function get_fields($id){
		$attributes = $this->_dao->get_attributes();
		$values = $this->_dao->get_values($attributes, $id);
		
		$items = $this->_get_attributes_items($attributes);
		//print_r($items);die;
		$fields = $this->_helper_html->get_form_fields($attributes, $values, $items, $this->errors);
		return $fields;
	}
	public function get_user_attributes_values($id){
		$attributes = $this->_dao->get_attributes();
		$values = $this->_dao->get_db_values($attributes, $id);
		
		foreach($attributes as $attr)
			$ret[$attr['name']] = $values[$attr['id']];
		
		return $ret;
	}
	public function get_type($id){
		return $this->_dao->get_type($id);
	}
	//POST
	public function save_attributes($userid){
		$aff = $this->_parse_and_update_value($userid,'attribute');
		$aff2 = $this->_parse_and_update_checkbox_value($userid,'cbattribute', 'attribute');
		$aff3 = $this->_parse_and_update_options_group_value($userid,'cbgroup', 'cbgattribute');
		return $aff || $aff2 || $aff3;	
    }
    public function delete($delete){
    	return $this->_dao->delete($delete);
    }
    public function update(){
		//disabilitato il cambio di tipo: troppo pericoloso!
		$attribute = $this->_params['attribute'];
		$attribute['required'] = isset($attribute['required']) ? 1 : 0;
	    //print_r($attribute);die;
		$aff = $this->_dao->update($attribute);
		
		
		$this->_fix_required($this->_dao->get_type($attribute['id']), $attribute['id']);
		
		return $aff;
    }
    public function insert(){
		$attribute = $this->_params['attribute'];
		$attribute['lc_name'] = $this->_get_new_tablename($attribute['name']);
		$attribute['required'] = isset($attribute['required']) ? 1 : 0;
		
		if ($attribute['lc_name'] == 'email') 
			die("<!-- email attribute not valid");
		
		
		$insert_id = $this->_dao->insert($attribute);		
		
		if($insert_id){
			if(in_array($attribute['type'], $this->_types_with_tables)){
				$this->_dao->create_table($attribute['lc_name']);
			}
			$this->_fix_required($attribute['type'], $insert_id);
			if($this->_entity == 'user')
				$this->_dao->fix_users($insert_id);
		}
		return $insert_id;
    }
    private function _fix_required($type,$id){
		if(in_array($type, $this->_types_no_required)){
			$this->_dao->fix_required($id);
		}
    }
    //ITEMS
	public function delete_item($id,$delete){
		$table = $this->_get_tablename($id);
		return $this->_dao->delete_item($table, $id, $delete);
    }
    public function delete_all_items($id){
		$table = $this->_get_tablename($id);
		$count = 0;
		$errcount = 0;
		$res = $this->_dao->get_all_items($table);
		foreach($res as $row){
			if (!$this->have_dependencies($id, $row[0]) && $this->_dao->delete_item($table, $id, $row[0])){
				$count++;
			} else {
				$errcount++;
				if ($errcount > 10)
					die('<!-- delete_all_items : TooManyErrors -->');
			}
		}
     	return $count;
    }
	public function change_order($id){
		$table = $this->_get_tablename($id);
		$aff = false;
		foreach ($this->_params['listorder'] as $key => $order) {
	   		$aff = $this->_dao->set_item_order($table, $key, $order);
	   		is_numeric($aff) ? $aff++ : $aff = 1;
	  	}
	  	return $aff;
	}
	
    public function add_items($id){
    	$items = explode("\n", $this->_params['itemlist']);
    	$items = array_unique($items);
		$table = $this->_get_tablename($id);
		$lastorder = $this->_dao->get_lastorder($table);
		$aff = false;
		while (list($key,$val) = each($items)) {
			$val = $this->_clean($val);
			if ($val != "") {
				$aff = $this->_dao->insert_item($table,$val,$lastorder++);
				is_numeric($aff) ? $aff++ : $aff = 1;
			}
		}
		return $aff;
    }
    //VALIDATE
	public function is_type_valid($type){
		return in_array($type, $this->_types);
	}
	public function have_dependencies($id, $delete){
		$dependencies = $this->_dao->get_dependencies($id, $delete);
		return sizeof($dependencies) > 0;
	}
	public function not_valid_order(){
		//var_dump();die;
		return sizeof(array_unique($this->_params['listorder'])) != sizeof($this->_params['listorder']);
	}
	public function validate_attributes(){
		$attributes = $this->_dao->get_attributes();
		foreach($attributes as $attr){
			if($attr['required'] && ($attr['type'] == 'checkboxgroup' || $attr['type'] == 'radio')){
				$this->_validate_options_group($attr['id']);
			}elseif($attr['required'] ){
				$this->_validate_attribute($attr['id']);
			}
		}
		//fix checkboxgroup
		//print_r($this->_params);
		//print_r($this->errors);die;
	}
	//PRIVATE
	//help validate_attributes
	private function _validate_attribute($id){
		if(!$this->_isset_attr($id)){
			$this->add_error('attribute_' . $id);
		}
	}
	//help validate_attributes
	private function _validate_options_group($id){
		if(!$this->_isset_cbgroup($id)){
			$this->add_error('attribute_' . $id);
		}
	}
	//help get
	private function _get_attributes_items($attributes){
		$items = array();
		foreach($attributes as $attr){
			//precedenza post/db/default
			if(in_array($attr['type'], $this->_types_with_tables)){
				$table = $this->_get_tablename($attr['id']);
				$items[$attr['id']] = $this->_dao->get_items($table);
			}
		}
		//print_r($values);die;
		return $items;
	}
	//help add_values
	private function _get_tablename($id){
    	$tablename = $this->_dao->get_tablename($id);
		return $tablename;
    }
  	//help insert
	private function _get_new_tablename($name){
		$lc_name = substr(preg_replace("/\W/","", strtolower($name)),0,10);
		if ($lc_name == "") die("<!--Name cannot be empty: $lc_name -->");
		#if (!$lc_name) $lc_name = "attribute";
		
		$tables = $this->_dao->check_tablename($lc_name);
		#if (Sql_Affected_Rows()) Fatal_Error("Name is not unique enough");
		$lc_name = $this->_check_tablename($lc_name,$tables);
		//echo "<hr>$lc_name<hr>";die;
		return $lc_name;
    }
	//help _get_new_tablename (recursive)
	private function _check_tablename($lc_name, $tables, $rec = 1){
    	$basename = $lc_name;
		if($rec < 100){
			foreach($tables as $table){
				$lc_name = $basename . $rec;
				$tables = $this->_dao->check_tablename($lc_name);
				if(sizeof($tables)>0){
					$rec++;
					return $this->_check_tablename($basename, $tables, $rec);
				}else{
					return $lc_name;			
				}
			}
		}else{
			die("<!--Name is not unique enough-->");
		}
		return $lc_name;//no tables
    }
	//help insert_value
	private function _clean($value){
	    $value = trim($value);
		$value = ereg_replace("\r","",$value);
		$value = ereg_replace("\n","",$value);
		$value = ereg_replace('"',"&quot;",$value);
		$value = ereg_replace("'","&rsquo;",$value);
		$value = ereg_replace("`","&lsquo;",$value);
		$value = stripslashes($value);
		return $value;
    }
    private function _isset_attr($key){
    	return isset($this->_params['attribute'][$key]) && (is_array($this->_params['attribute'][$key]) || strlen($this->_params['attribute'][$key]) > 0);
    }
    private function _isset_cbgroup($key){
    	//print_r($this->_params['cbgroup']);die;
    	return (isset($this->_params['cbgroup'][$key]) && (is_array($this->_params['cbgroup'][$key]) && sizeof($this->_params['cbgroup'][$key]) > 0));
    }
    //parse post
    private function _parse_and_update_value($userid,$key){
		$attribute = $this->_params[$key];
		
		$aff = false;
		if (is_array($attribute))
			while (list($key,$val) = each ($attribute)) {
				//echo "$key : $val<br>";
				$upd = $this->_dao->update_value($userid, $key, $val);
				is_numeric($aff) ? $aff++ : $aff = 1;
			}
		
		return $aff;
	}
	private function _parse_and_update_checkbox_value($userid,$key,$check){
		$cbattribute = $this->_params[$key];
		$attribute = $this->_params[$check];
		//print_r($cbattribute);
		//print_r($attribute);
		$aff = false;
		if (is_array($cbattribute))
			while (list($key,$val) = each ($cbattribute)) {
				if(isset($attribute[$key]) && $attribute[$key])
					$upd = $this->_dao->update_value($userid, $key, 'on');
				else
					$upd = $this->_dao->update_value($userid, $key, '');
					
				is_numeric($aff) ? $aff++ : $aff = 1;
			}
		
		return $aff;
	}
	private function _parse_and_update_options_group_value($userid,$key, $check){
		$attribute = $this->_params[$check];
		$cbgroup = $this->_params[$key];
		//print_r($cbgroup);//die;
		//print_r($attribute);
		$aff = false;
		if (is_array($attribute)){
			foreach($attribute as $attr => $value){
				$value = "";
				foreach($cbgroup as $key => $items){
					if (is_array($items))
						$value = implode(",",$items);
				}
				//echo "$attr : $value";die;
				$upd = $this->_dao->update_value($userid, $attr, $value);
				is_numeric($aff) ? $aff++ : $aff = 1;
			}
		}
		return $aff;
	}
}
