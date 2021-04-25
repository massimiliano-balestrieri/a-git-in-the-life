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
 * $Id: listmessage_model.php 337 2007-12-02 16:21:10Z maxbnet $
 * $LastChangedDate: 2007-12-02 16:21:10 +0000 (Sun, 02 Dec 2007) $
 * $LastChangedRevision: 337 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/listmessage_model.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-02 16:21:10 +0000 (Sun, 02 Dec 2007) $
 */


class ListmessageModel extends ModuleModel{
	
	private $_join_list;
	
	public function __construct($params = false){
		$this->_name = 'listmessage';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
		
		global $APP;
		$this->_join_list = $APP->get_model2("list");
	}
	//help statistic_model->get_statistics
	//help message_model->get_messages
	public function get_csv_listdone($id){
		return @implode(",", $this->get_array_lists_done($id));
	}
	//help message_controller->view
	public function get_array_lists_done($id){
		$ret = array();//important diff
		$lists = $this->_dao->get_lists_done($id);
		foreach ($lists as $list)
			    $ret[$list["id"]] = $list["name"];
		return $ret;
	}
	//help message_controller->view
	public function get_array_lists_resend($id){
		$lists_done = $this->get_array_lists_done($id);
		$lists = $this->_join_list->get_array_lists();
		return array_diff($lists, $lists_done);
	}
	//help message_controller->edit
	public function get_targetlist($msgid){
		return $this->get_array_lists_done($msgid);
	}
	
	//POST
	//help message_model->update
	public function set_targetlist($msgid, $params){
		return $this->_dao->set_targetlist($msgid, $params);
	}
	
}
