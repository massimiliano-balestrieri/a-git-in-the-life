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
 * $Id: userblacklist_model.php 352 2007-12-20 19:11:32Z maxbnet $
 * $LastChangedDate: 2007-12-20 19:11:32 +0000 (Thu, 20 Dec 2007) $
 * $LastChangedRevision: 352 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/userblacklist_model.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-20 19:11:32 +0000 (Thu, 20 Dec 2007) $
 */


class UserblacklistModel extends ModuleModel{
	
	public function __construct($params = false){
		$this->_name = 'userblacklist';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
	}
	//help userhistory_controller->get
	public function get_user_blacklist_info($email){
		$blacklist_info = $blacklist_data = null;
		$list_bl = array();
		if ($blflag = $this->is_email_blacklisted($email)) {
		  $blacklist_info = $this->_dao->get_user_blacklist_info($email);
		  $blacklist_data = $this->_dao->get_user_blacklist_data($email);
		}
		return array(
					'flag' => $blflag,
					'lists' => $blacklist_data,
					'info' => $blacklist_info
					);
	}
	//help get_user_blacklist_info (userhistory_controller->get)
	//help MAILER helper is_email_blacklisted
	//help user_model->confirm
	public function is_email_blacklisted($email){
		return $this->_dao->is_email_blacklisted($email);
	}
	//help  user_model->unsubsubscribe
	public function add_blacklist($email,$reason){
		return $this->_dao->add_blacklist($email,$reason);
	}
	//help  user_model->confirm
	public function delete_blacklist($email){
		return $this->_dao->delete_blacklist($email);
	}
}
