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
 * $Id: usecase_dao.php 323 2007-11-26 18:23:10Z maxbnet $
 * $LastChangedDate: 2007-11-26 18:23:10 +0000 (Mon, 26 Nov 2007) $
 * $LastChangedRevision: 323 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/dao/old/usecase_dao.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-11-26 18:23:10 +0000 (Mon, 26 Nov 2007) $
 */


class UsecaseDao extends ModuleDao{
	
	public $table = false;
	public $db = false;
	
	public function __construct($params = false){
		global $APP;
		$this->table = $APP->DB->get_table('group_usecases');
		$this->db = $APP->DB;
		$this->_params = $params; 
	}
	public function get($group_id, $usecase){
	  	$ret = $this->db->sql_fetch_array_query(sprintf('select value from %s where group_id = %d and usecase = "%s"',$this->table,$group_id,$usecase));
		return isset($ret[0]) ? $ret[0] : $this->_fix($group_id, $usecase);
	}
	private function _fix($group_id, $usecase){
		$sql = sprintf('replace into %s (group_id,usecase, value) values (%d,"%s",%d)',$this->table,$group_id,strtoupper($usecase),0);
		$this->db->sql_query($sql);
		return 0;
	}
	public function update($group, $usecases){
		//azzero
		$this->db->sql_query($sql = sprintf('update %s  set value = 0 where group_id = %d',$this->table,$group));
		$aff = 0;
		foreach($usecases as $key => $value){
			$sql = sprintf('update %s  set value = %d where group_id = %d and usecase = "%s" ',$this->table,$value,$group,strtoupper($key));
			$this->db->sql_query($sql);
			$aff++;
		}
		return $aff;
	}
}