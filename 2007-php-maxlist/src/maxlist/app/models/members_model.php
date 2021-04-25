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
 * $Id: members_model.php 392 2008-01-17 19:09:43Z maxbnet $
 * $LastChangedDate: 2008-01-17 19:09:43 +0000 (Thu, 17 Jan 2008) $
 * $LastChangedRevision: 392 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/members_model.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-17 19:09:43 +0000 (Thu, 17 Jan 2008) $
 */


class MembersModel extends ModuleModel{
	
	
	public function __construct($params = false){
		$this->_name = 'members';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
	}
	//GET members
	public function get_page_members($id){//TODO: method in user_model. delete?
		return $this->_dao->get_page_members($id);
	}
	//POST
	//help member_controller
	public function subscribe_list($userid, $list){
		return $this->_dao->subscribe_list($userid, $list);
	}
	//help member_controller
	public function html_checked($list){
		global $APP;
		$model = $APP->get_model2('user');
		$users = $this->_params['user'];
		$aff = 0;
		if(is_array($users))
			foreach($users as $key => $value){
				$res = $model->set_html($key);
				$aff += $res;
			}	        
		return $aff;
	}
	//help member_controller
	public function html_all($list){
		global $APP;
		$model = $APP->get_model2('user');
	    $users = $this->_dao->get_members($list);
		//print_r($users);die;
		$aff = 0;
		if(is_array($users))
			foreach($users as $user){
				$res = $model->set_html($user['userid']);
				$aff += $res;
			}	        
		return $aff;
	}
	//help member_controller
	public function unsubscribe_checked($list){
		//print_r($this->_params);die;
		$users = $this->_params['user'];
		$aff = 0;
		if(is_array($users))
			foreach($users as $key => $value){
				$res = $this->_dao->unsubscribe_list($key, $list);
				$aff += $res;
			}	        
		return $aff;
	}
	//help member_controller
	public function unsubscribe_all($list){
	    $users = $this->_dao->get_members($list);
		//print_r($users);die;
		$aff = 0;
		if(is_array($users))
			foreach($users as $user){
				$res = $this->_dao->unsubscribe_list($user['userid'], $list);
				$aff += $res;
			}	        
		return $aff;
	}
	//help member_controller
	public function copy_checked($list, $destination){
		$users = $this->_params['user'];
		//print_r($users);die;
		$aff = 0;
		if(is_array($users))
			foreach($users as $key => $value){
				$res = $this->_dao->subscribe_list($key, $destination);
				$aff += $res;
			}	        
		return $aff;
	}
	//help member_controller
	public function copy_all($list, $destination){
		$users = $this->_dao->get_members($list);
		//print_r($users);die;
		$aff = 0;
		if(is_array($users))
			foreach($users as $user){
				$res = $this->_dao->subscribe_list($user['userid'], $destination);
				$aff += $res;
			}	        
		return $aff;
	}
	//help member_controller
	public function move_checked($list, $destination){
		$users = $this->_params['user'];
		//print_r($users);die;
		$aff = 0;
		if(is_array($users))
			foreach($users as $key => $value){
				$res = $this->_dao->subscribe_list($key, $destination);
				if($res)
					$rem = $this->_dao->unsubscribe_list($key, $list);
				$aff += $res;
			}	        
		return $aff;
	}
	//help member_controller
	public function move_all($list, $destination){
		$users = $this->_dao->get_members($list);
		//print_r($users);die;
		$aff = 0;
		if(is_array($users))
			foreach($users as $user){
				$res = $this->_dao->subscribe_list($user['userid'], $destination);
				if($res)
					$rem = $this->_dao->unsubscribe_list($user['userid'], $list);
					
				$aff += $res;
			}	        
		return $aff;
	}
	//POST
	//help user_model->update STEP subscribe external context
	public function subscribe($id,$params,$context = false){
		return $this->_dao->subscribe($id,$params,$context);
	}
	//help user_model->unsubscribe
	public function unsubscribe($id){
		return $this->_dao->unsubscribe($id);
	}
	//help user_model->get_page_users
	public function get_csv_memberships($id_user){
		return implode(",", $this->get_array_memberships($id_user));
	}
	//HELP user (controller)
	public function get_array_memberships($id){//TODO: method in user_model. delete?
		$res = $this->_dao->get_array_memberships($id);
		$ret = array();
		foreach($res as $row){
			$ret[$row[0]] = $row[1];
		}
		return $ret;
	}
	//HELP list_model
	public function get_listuser_count($id){
		return $this->_dao->get_listuser_count($id);
	}
	
	//help sendmail_model->sendemail
	public function get_html_lists($userid){
		$res = $this->_dao->get_userlists($userid);
		$listsarr = array ();
		if(is_array($res)){
			foreach ($res as $row) {
				array_push($listsarr, $row[0]);
			}
			return join('<br/>',$listsarr);
		}
	}
	//help sendmail_model->sendemail
	public function get_txt_lists($userid){
		$res = $this->_dao->get_userlists($userid);
		$listsarr = array ();
		//print_r($res);die;
		if(is_array($res)){
			foreach ($res as $row) {
				array_push($listsarr, $row[0]);
			}
			return join("\n",$listsarr);
		}
	}
	
}