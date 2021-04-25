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
 * $Id: group_dao.php 393 2008-01-18 18:09:49Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 393 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/dao/group_dao.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 */

class GroupDao extends ModuleDao {

	public $table = false;
	public $db = false;

	public function __construct($params = false) {
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('group');
		$this->_params = $params;

	}
	//list
	public function get($id) {
		global $APP;
		$group = $this->db->fetch_query("SELECT * FROM {$this->table} where id = {$id}");
		return $group;
	}
	public function get_groups() { //TODO: method in user_model. delete?
		return $this->db->query("SELECT * FROM {$this->table}");
	}

	//POST
	public function insert() {
		$params = $this->_params['group'];
		$query = sprintf('insert into %s
								  (name)
								  values("%s")', $this->table, $params["name"]);
		//echo $query;die;
		return $this->db->insert($query);
	}
	public function update($id) {
		$params = $this->_params['group'];
		$query = sprintf('update %s set name="%s" where id=%d', $this->table, $params["name"], $id);
		return $this->db->execute($query);
	}
	public function delete($id) {
		return $this->db->execute("delete from $this->table where id = $id");
	}
	//VALIDATE
	public function check_unique_name_update($name, $id) {
		$res = $this->db->fetch_query("SELECT count(*) FROM {$this->table} where name = '{$name}' and id <> $id");
		return $res[0] == 0 ? true : false;
	}
	public function check_unique_name_insert($name) {
		$res = $this->db->fetch_query("SELECT count(*) FROM {$this->table} where name = '{$name}'");
		return $res[0] == 0 ? true : false;
	}
}