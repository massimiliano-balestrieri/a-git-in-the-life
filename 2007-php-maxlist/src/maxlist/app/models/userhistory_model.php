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
 * $Id: userhistory_model.php 328 2007-11-26 20:02:49Z maxbnet $
 * $LastChangedDate: 2007-11-26 20:02:49 +0000 (Mon, 26 Nov 2007) $
 * $LastChangedRevision: 328 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/userhistory_model.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-11-26 20:02:49 +0000 (Mon, 26 Nov 2007) $
 */


class UserhistoryModel extends ModuleModel{
	
	public function __construct($params = false){
		$this->_name = 'userhistory';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);	
	}
	//GET
	public function get_userhistory($id){
		return $this->_dao->get_userhistory($id);
	}
	//POST
	//help user_model->update
	public function add_user_history($userid, $history_subject, $history_entry){
		global $APP;
		if(!$history_subject)
			$history_subject = "Update by " . $APP->SESSION->get_username();
			
		$sysinfo = "";
		$sysarrays = array_merge($_ENV,$_SERVER);
		$userhistory_systeminfo = split(",",USERHISTORY_INFO);
		//print_r($userhistory_systeminfo);die;
		if (is_array($userhistory_systeminfo)) {
			foreach ($userhistory_systeminfo as $key) {
				if (isset($sysarrays[$key])) {
					$sysinfo .= "\n$key = $sysarrays[$key]";
				}
			}
		} //del other if. 
		if (isset($_SERVER["REMOTE_ADDR"])) {
			$ip = $_SERVER["REMOTE_ADDR"];
		} else {
			$ip = '';
		}
		return $this->_dao->add_user_history($userid, $history_subject, $history_entry, $ip, $sysinfo);
		
	}
}
