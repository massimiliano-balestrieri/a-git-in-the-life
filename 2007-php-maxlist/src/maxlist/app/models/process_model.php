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
 * $Id: process_model.php 355 2007-12-23 17:46:42Z maxbnet $
 * $LastChangedDate: 2007-12-23 17:46:42 +0000 (Sun, 23 Dec 2007) $
 * $LastChangedRevision: 355 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/process_model.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-23 17:46:42 +0000 (Sun, 23 Dec 2007) $
 */


class ProcessModel extends ModuleModel{
	
	public function __construct($params = false){
		$this->_name = 'process';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
	}
	
	public function get_running($process){
		return $this->_dao->get_running($process);
	}
	public function get_lock($process){
		return $this->_dao->get_lock($process);
	}
	public function insert($process){
		return $this->_dao->insert($process);
	}
	public function update($id){
		return $this->_dao->update($id);
	}
	public function release_lock($id){
		return $this->_dao->delete($id);
	}
	public function check_lock($id){
		return $this->_dao->check_lock($id);
	}
	public function keep_lock($id){
		return $this->_dao->keep_lock($id);
	}
}
