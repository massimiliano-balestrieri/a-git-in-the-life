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
 * $Id:admin_model.php 314 2007-11-25 08:09:32Z maxbnet $
 * $LastChangedDate:2007-11-25 09:09:32 +0100 (dom, 25 nov 2007) $
 * $LastChangedRevision:314 $
 * $LastChangedBy:maxbnet $
 * $HeadURL:https://maxlist.svn.sourceforge.net/svnroot/maxlist/trunk/maxlist/app/models/old/admin_model.php $
 * 
 * $Author:maxbnet $
 * $Date:2007-11-25 09:09:32 +0100 (dom, 25 nov 2007) $
 */

class AdminModel extends ModuleModel{
	
	public function __construct($params = false){
		$this->_name = 'admin';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
	}
	public function update($id){
		return $this->_dao->update($id);
	}
	public function check_username($username){
		return $this->_dao->check_username($username);
	}
	public function insert($loginname){
		return $this->_dao->insert($loginname);
	}
	public function delete($id){
		return $this->_dao->delete($id);
	}
	public function get_username($id){
		return $this->_dao->get_username($id);
	}
	public function get_role($id){
		return $this->_dao->get_role($id);
	}
	public function get_admins(){
		return $this->_dao->get_admins();
	}
	public function get($id){
		return $this->_dao->get($id);
	}
	public function get_page_admins(){
		return $this->_dao->get_page_admins();
	}
} 
