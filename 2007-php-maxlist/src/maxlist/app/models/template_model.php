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

class TemplateModel extends ModuleModel{
	
	public function __construct($params = false){
		$this->_name = 'template';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
	}
	
	//GET list all
	public function get_templates(){
		return $this->_dao->get_templates();
	}
	//GET edit
	public function get($id){
		$res = $this->_dao->get($id);
		$arr_template = array (
			'title' => htmlspecialchars($res["title"]), 
			'content' => htmlspecialchars($res["template"]), 
			'baseurl' => '',//TODO:htmlspecialchars($baseurl),
		);
		return $arr_template;
	}
	function get_array_templates(){
		$arr_templates = array();
		$res = $this->_dao->get_templates();
		foreach ($res as $row) 
			$arr_templates[$row['id']] = $row['title']; 
			
		return $arr_templates;
	}
	//POST
	public function insert(){
		return $this->_dao->insert();
	}
	public function update($id){
		return $this->_dao->update($id);
	}
	public function delete($id){
		return $this->_dao->delete($id);
	}
	public function set_default(){
		return $this->_dao->set_default();
	}
	//VALIDATE
	public function check_placeholder($content){
		return (ereg("\[CONTENT\]",$content));
	}
	public function check_unique_title($title){
		//only in edit context
		$id = $this->_id();
		if($id)
		return $this->_dao->check_unique_title($title, $id);
	}
}