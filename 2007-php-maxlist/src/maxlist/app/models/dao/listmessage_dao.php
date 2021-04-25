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
 * $Id:listmessage_dao.php 314 2007-11-25 08:09:32Z maxbnet $
 * $LastChangedDate:2007-11-25 09:09:32 +0100 (dom, 25 nov 2007) $
 * $LastChangedRevision:314 $
 * $LastChangedBy:maxbnet $
 * $HeadURL:https://maxlist.svn.sourceforge.net/svnroot/maxlist/trunk/maxlist/app/models/dao/old/listmessage_dao.php $
 * 
 * $Author:maxbnet $
 * $Date:2007-11-25 09:09:32 +0100 (dom, 25 nov 2007) $
 */


class ListmessageDao extends ModuleDao{
	
	public $table = false;
	public $db = false;
	
	public function __construct($params = false){
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('listmessage');
		$this->_params = $params; 
	}
	public function get($msgid, $listid){
	  	$res = $this->db->query('select * from %s where messageid = %d and listid = %d',$this->table,$msgid,$listid);
		return $this->db->count();
	}
	//help model
	public function get_lists_done($id){ //used by update & insert user. - 
		return $this->db->query("select {$this->db->get_table("list")}.name," .
											"{$this->db->get_table("list")}.id " .
											"from {$this->table}," .
											"{$this->db->get_table("list")} where " .
											"messageid = $id and " .
											"listid = {$this->db->get_table("list")}.id");
	}
	//update -> STEP 2
	public function set_targetlist($messageid, $params){
		//external context
		$this->_params = $params;
		//print_r($this->_params);die;
		$affected = false;
		// More  "Insert  only"  stuff  here (no need  to change  it on  an edit!)
		if (isset($this->_params["targetlist"]) && is_array($this->_params["targetlist"]))  {
			$this->db->execute("delete from {$this->table} where messageid = $messageid");
			if (isset($this->_params["targetlist"]["all"])) {
				$res = $this->db->query("select * from  {$this->db->get_table("list")}");
				foreach($res as $row)  {
					if ($row["active"])  {
						$affected  =  $this->db->execute("insert ignore into {$this->table}  " .
											  "(messageid,listid,entered) values($messageid,{$row["id"]},now())");
					}
				}
			} else {
				foreach($this->_params["targetlist"] as $listid => $val) {
					$affected = $this->db->execute("insert ignore into {$this->table}  " .
												"(messageid,listid,entered) values($messageid,$listid,now())");
				}
			}
		} else {
			#  mark this  message  as listmessage for list  0
			#$result  =  Sql_query("insert ignore into $tables[listmessage]  (messageid,listid,entered) values($messageid,0,now())");
			# why?
		}
		return $affected;
	}
}