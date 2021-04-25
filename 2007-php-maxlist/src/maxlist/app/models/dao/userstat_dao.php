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
 * $Id: userstat_dao.php 393 2008-01-18 18:09:49Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 393 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/dao/userstat_dao.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 */

class UserstatDao extends ModuleDao {

	public $table = false;
	public $db = false;

	public function __construct($params = false) {
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('userstats');
		$this->_params = $params;

	}
	//help members_dao->subscribe, unsubscribe, in fo context (NO MODEL?)
	//help model::user_model->insert (fo context) TODO:test
	//help model::user_model->confirm
	
	public function add_subscriber_statistics($item = '',$amount,$list = 0) {
		if(!$this->_update_stats_interval($item,$amount,$list)){
			return $this->db->insert(sprintf('insert into %s set value = %d,unixdate = %d,item = "%s",listid = %d',
											$this->table,$amount,$this->_get_interval(),$item,$list));
		}
	}
	private function _update_stats_interval($item = '',$amount,$list = 0){
		$sql = sprintf('update %s set value = value + %d where unixdate = %d and item = "%s" and listid = %d',
										$this->table,$amount,$this->_get_interval(),$item,$list);
		//echo $sql;die;
		return $this->db->execute($sql);
	}
	private function _get_interval(){
		switch (STATS_INTERVAL) {
			case 'monthly':
				# mark everything as the first day of the month
				$time = mktime(0,0,0,date('m'),1,date('Y'));
			break;
			case 'weekly':
				# mark everything for the first sunday of the week
				$time = mktime(0,0,0,date('m'),date('d') - date('w'),date('Y'));
			break;
			case 'daily':
				$time = mktime(0,0,0,date('m'),date('d'),date('Y'));
			break;
		}
		return $time;
	}	
}