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
 * $Id: process_dao.php 393 2008-01-18 18:09:49Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 393 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/dao/process_dao.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 */


class ProcessDao extends ModuleDao {

	public $table = false;
	public $db = false;

	public function __construct($params = false) {
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('sendprocess');//TODO: change in process 
		$this->_params = $params;
	}
	
	public function get_running($process){
		//$process = 'queue';//TODO:
		if(!$process) die('fix process dao');
		$res = $this->db->fetch_query("select now() - modified as t,id from " . $this->table . " where page = \"$process\" " .
				"and alive order by started desc");
		if(!isset($res['id'])) 
			$res['id'] = false;   
		
		return $res;
	}
	public function get_lock($process){
		//$process = 'queue';//TODO:
		if(!$process) die('fix process dao');
		$res = $this->db->fetch_query("select id from " . $this->table . " where page = \"$process\" " .
				"and alive order by started desc");
		return isset($res['id']) ? $res['id'] : false;   
	}
	public function check_lock($id){
		if(!$id) return false;
	  	$res = $this->db->fetch_query("select alive from {$this->table} where id = $id");
  		return isset($res[0])?$res[0]:false;
	}
	public function update($id){
		return $this->db->execute("update {$this->table} set alive = 0 where id = $id");
	}
	public function insert($process){
		//$process = 'queue';//TODO:
		if(!$process) die('fix process dao');
		return $this->db->insert('insert into ' . $this->table . ' (started,page,alive,ipaddress) values(now(),"' . 
									$process . '",1,"' . getenv("REMOTE_ADDR") . '")');
	}
	public function keep_lock($id){
		return $this->db->execute("update ".$this->table." set alive = alive + 1 where id = $id");
	}
	public function delete($id){
		if (!$id) return;
  		return $this->db->execute("delete from {$this->table} where id = $id");
		
	}
}