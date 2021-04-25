<?php

/***
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

//system dao. very important

class ConfigureDao extends ModuleDao {

	public $configurations = array ();
	public $table = false;
	public $db = false;

	public function __construct($params = false) {
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('config');
		$this->_params = $params;
	}
	public function save($item, $value, $editable = 1, $ignore_errors = 0, $role = 1) {
		return $this->db->execute(sprintf('replace into %s (item,value,editable,role) values("%s","%s",%d,%d)', $this->table, $item, addslashes($value), $editable, $role));
	}
	public function get($item){
		//return $this->db->sql_fetch_array_query("select value from {$this->table} where item = \"$item\"");
		return $this->db->fetch_query("select value from {$this->table} where item = \"$item\"");
	}
}