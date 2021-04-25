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
 * $Id:list_model.php 314 2007-11-25 08:09:32Z maxbnet $
 * $LastChangedDate:2007-11-25 09:09:32 +0100 (dom, 25 nov 2007) $
 * $LastChangedRevision:314 $
 * $LastChangedBy:maxbnet $
 * $HeadURL:https://maxlist.svn.sourceforge.net/svnroot/maxlist/trunk/maxlist/app/models/old/list_model.php $
 * 
 * $Author:maxbnet $
 * $Date:2007-11-25 09:09:32 +0100 (dom, 25 nov 2007) $
 */


class ListModel extends ModuleModel{
	
	
	public function __construct($params = false){
		$this->_name = 'list';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
	}
	//GET list
	public function get_lists(){//TODO: method in user_model. delete?
		global $APP;
		$ret = $this->_dao->get_lists();
		$x = 1;$lists = array();
		$members = $APP->get_model2("members");
		foreach($ret as $row){
			$count = $members->get_listuser_count($row["id"]);
		  	$lists[] = array(
		  						'id' 		=> $row["id"],
		  						'name' 		=> $row['name'],
		  						'members'	=> $count,
		    					'listorder'	=> $row['listorder'],
							    'active'	=> $row['active'],
							    'owner'		=> true,//adminName($row['owner']), TODO adminName()
							    'description'=> stripslashes($row['description']),
							    'isWritable'=> true,//isListWritable($row['owner']),TODO isListWritable()
							    'cnt'		=> $x++
		  	);
		}
		//print_r($lists);
		return $lists;
		
	}
	public function get($id){
		$data = $this->_dao->get($id);
		return array(
				'name' => htmlspecialchars($data['data']['name']),
				'listorder'=>$data['data']['listorder'],
				'visowner' => true,
				'owner'=> $data['data']['owner'],
				'description'=>htmlspecialchars($data['data']['description']),
				'count'=> $data['countmsg']
		);
	}
	//POST list
	public function insert(){
		return $this->_dao->insert();
	}
	public function update($id){
		return $this->_dao->update($id);
	}
	public function delete($id){
		return $this->_dao->delete($id);
	}
	public function is_writable($owner){
		return $this->_dao->is_writable($owner);
	}
	public function set_order(){
		//if(isSuperUser() || isRoleAdmin() || isRoleMaster()){ //TODO: roles
		$operatore = isset($this->_params['increase']) && is_array($this->_params['increase']) ? " + " : " - ";
		$soggetto = isset($this->_params['increase']) && is_array($this->_params['increase']) ? $this->_params['increase'] : $this->_params['decrease'];
		while (list($key,$val) = each ($soggetto)){
			$ordine_originale = $this->_dao->get_order($key);
			if($ordine_originale[1] <= 1 && $operatore == "-")return;
		}
		return $this->_dao->set_order($operatore, $ordine_originale);
	}
	public function set_active(){
		$some = 0;	
		//print_r($this->_params);die;
		if (isset($this->_params['list']) && is_array($this->_params['list'])){
			  while (list($key,$val) = each ($this->_params['list'])){
				  isset($this->_params['active'][$key]) ? $active = 1 : $active = 0;
				  $owner = $this->_dao->is_owner($key);
				  //TODO:if($owner && $this->is_writable($owner[0])){
				  	  $this->_dao->set_active($active,$key);
				  	  $some++;
				  //}else{
				  //	$this->_log(LOG_MAIL_LEVEL, $this->_('list_security_error_active'));
		  		  //}
			  }
		}
		return $some;
	}
	//HELP OTHER
	
	//help subscribe_controller->subscribe preferences
	public function get_lists_active(){//TODO: method in user_model. delete?
		return $this->_dao->get_lists_active();
	}
	//members
	public function get_array_other_lists($id){
		$res = $this->_dao->get_other_lists($id);
		$lists_list = array();
		foreach ($res as $row){// = $this->db->sql_fetch_array($res)) {
		  if ($row["id"] != $id)
		    $lists_list[$row["id"]] = $row["name"];
		}
		return $lists_list;
	}
	//help model_listmessage->get_array_lists_resend
	public function get_array_lists(){
		$res = $this->_dao->get_lists();
		$lists_list = array();
		foreach ($res as $row){// = $this->db->sql_fetch_array($res)) {
		    $lists_list[$row["id"]] = $row["name"];
		}
		return $lists_list;
	}
	//members
	public function get_list_name($id){
		return $this->_dao->get_list_name($id);
	} 
}