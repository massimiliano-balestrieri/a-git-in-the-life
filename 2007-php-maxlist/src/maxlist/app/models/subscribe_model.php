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
 * $Id: subscribe_model.php 364 2008-01-04 14:00:24Z maxbnet $
 * $LastChangedDate: 2008-01-04 14:00:24 +0000 (Fri, 04 Jan 2008) $
 * $LastChangedRevision: 364 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/subscribe_model.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-04 14:00:24 +0000 (Fri, 04 Jan 2008) $
 */


class SubscribeModel extends ModuleModel{
	
	private $_join_user = false;
	
	public function __construct($params = false){
		$params['user']['confirmed'] = $this->_fix_param_confirm($params['do']);
		
		$this->_name = 'user';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
		
		global $APP;		
		//join 
		require_once (APP_ROOT . '/app/models/user_model.php');
		$this->_join_user = new UserModel($params, 'fo');
	}
	
	public function subscribe(){
		return $this->_join_user->insert($this->_params);
	}
	public function get_user_attributes($id){
		return $this->_join_user->get_user_attributes($id);
	}
	public function preferences($id){
		
		return $this->_join_user->update($id, $this->_params);
	}
	public function unsubscribe($id){
		return $this->_join_user->unsubscribe($id, $this->_params);
	}
	public function confirm($id){
		return $this->_join_user->confirm($id);
	}
	//VALIDATE
	public function is_email_valid($email){
		return $this->_join_user->is_email_valid($email);
	}
	public function email_not_exist($email){
		return $this->_join_user->email_not_exist($email);
	}
	public function validate_attributes(){
		$this->_join_user->validate_attributes();
		$this->merge_errors($this->_join_user->errors);
	}
	public function is_terms_accepted($terms){
		return $terms;
	}
	
	private function _fix_param_confirm($do){
		if($do == 'update')
			return 1;
	}
}
