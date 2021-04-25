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
 * $Id:eventlog_dao.php 314 2007-11-25 08:09:32Z maxbnet $
 * $LastChangedDate:2007-11-25 09:09:32 +0100 (dom, 25 nov 2007) $
 * $LastChangedRevision:314 $
 * $LastChangedBy:maxbnet $
 * $HeadURL:https://maxlist.svn.sourceforge.net/svnroot/maxlist/trunk/maxlist/app/models/dao/old/eventlog_dao.php $
 * 
 * $Author:maxbnet $
 * $Date:2007-11-25 09:09:32 +0100 (dom, 25 nov 2007) $
 */
 
class EventlogDao extends ModuleDao{
	
	public $table = false;
	public $db = false;
	
		
	public function __construct($params = false){
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('eventlog');
		$this->_params = $params;
	}
	public function get_page_events($params){
		$where = '';
		$pg =  $params['pg'];
		if ($params['filter']) {
		  $where = ' admin like "%'.$params['filter'].'%" or page like "%'.$params['filter'].'%" or entry like "%'.$params['filter'].'%"';
		}
		$result = $this->db->get_page($this->table, $pg, $where, 'entered desc');//tentativo
		$count = $this->db->count();
		return array('total' => $count, 'data' => $result);
	}
	public function get_events(){
		return $this->db->query(sprintf('select * from %s ',$this->table));		
	}
	public function get_events_old(){
		return $this->db->query(sprintf('select * from %s where date_add(entered,interval 2 month) < now()',$this->table));
	}
	public function delete($delete){
		return $this->db->delete($this->table,"id = $delete");
	}
	public function delete_all(){
		return $this->db->delete($this->table, false);
	}
	public function delete_old(){
		return $this->db->delete($this->table,'date_add(entered,interval 2 month) < now()');  
	}
	
}