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
 * $Id: user_controller.php 386 2008-01-08 22:41:31Z maxbnet $
 * $LastChangedDate: 2008-01-08 22:41:31 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 386 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/user/user_controller.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 22:41:31 +0000 (Tue, 08 Jan 2008) $
 */

class UserController extends ModuleController implements IModuleController{
	

	public function __construct(){
		
		global $APP;
		//TODO : check_role -  
		//$this->_check_role_view('admin');
		
		$params = array(
					'find','findby','sortby','unconfirmed','blacklisted','sortorder',
					'pg' 	=> array('t' => 'int', 'd' => 1),
					'block' => array('t' => 'int', 'd' => 1),
					'delete'=> array('m' => 'post'),
					'filter'=> array(),
					'do'=> array('in' => 'delete,create,edit', 'm' => 'post'),//TODO : options in
					'confirm'=>array('m' => 'post'),
					
					'user'=>array('m' => 'post', 'd' => array()),
					'subscribe'=>array('m' => 'post', 'd' => array()),
					
					//required
					'attribute'=>array('m' => 'post', 'd' => array()),
					'cbgattribute'=>array('m' => 'post', 'd' => array()),	
					'cbattribute'=>array('m' => 'post', 'd' => array()),	
					'cbgroup'=>array('m' => 'post', 'd' => array()),	
		);
		
		$this->_check_params($params);
		$this->_set_param_default_value('htmlemail',0,'user');
		$this->_set_param_default_value('confirmed',0,'user');
		$this->_set_param_default_value('disabled',0,'user');
		$this->_set_param_default_value('blacklisted',0,'user');
		
		//echo "<hr>";
		//print_r($this->_params);die;
		
		$this->_model = new UserModel($this->_params);  
		
		
		$this->_do();
		
		$this->_routing();
		
	}
	//GET
	protected function _listall(){
		global $APP;
		$data = $this->_model->get_page_users();
		
		if(sizeof($data['data'])==0 && !$APP->REQUEST->request('search'))
			$this->_info($this->_('no_users'));
		if(sizeof($data['data'])==0 && $APP->REQUEST->request('search'))
			$this->_info($this->_('no_users_search'));
		
		$this->tpl = 'users';
		new UserView($this->_params, $data);	
	}
	protected function _create(){
		$data = $this->_prepare_data_create();
		$this->_form($data);
	}
	protected function _edit(){
		$data = $this->_prepare_data_edit($this->_id());
		$this->_form($data);
	}
	protected function _delete(){
		$this->_listall();
	}
	//POST
	protected function _new(){
		$this->_validate();
		$this->_validate_new();
		$this->_validate_attributes();
		if($this->_check_errors() && $this->_check_create() && $this->_model->insert()){
	   		$this->_flash(LOG_LEVEL,$this->_('user_created'));
	  		$this->_redirect();
		}	
	}
	protected function _update(){
		$this->_validate();
		$this->_validate_attributes();
		$id = $this->_id();
		if($this->_check_errors() && $this->_check_edit() && $this->_model->update($id)){
			$this->_flash(LOG_LEVEL,$this->_('user_updated'));
		  	$this->_redirect(); 
		}	
	}
	protected function _remove(){
		$delete = $this->_params['delete'];
		if($this->_check_confirm() && $this->_model->delete($delete)){
			$this->_flash(LOG_MAIL_LEVEL, $this->_('user_deleted'));	
		}
	    $this->_redirect(); 	
	}
	//PRIVATE
	private function _form($data){
		$this->tpl = 'form';
		//print_r($data);die;
		new UserView($this->_params, $data, $this->_model->errors);
	}
	private function _prepare_data_create(){
		global $APP;
		//print_r($data['user_attributes']);die;
		$data['user'] = array();
		$data['user_attributes'] = $this->_prepare_attributes();
		$data['lists'] = $APP->get_model2("list")->get_lists();
		$data['subscribe'] = array();
		return $data;
	}
	private function _prepare_data_edit($id){
		global $APP;
		$data['user'] = $this->_model->get($id);
		$data['user_attributes'] = $this->_prepare_attributes();
		$data['subscribe'] = $APP->get_model2("members")->get_array_memberships($id);//vuole un array
		$data['lists'] = $APP->get_model2("list")->get_lists($id);//vuole un array
		return $data;
	}
	private function _prepare_attributes(){
		$id = $this->_id();
		return $this->_model->get_user_attributes($id);
	}
	//VALIDATE
	//see member_controller
	private function _validate(){
		$this->_model->validates_presence_of('user',array('email' => $this->_('email_required')));
		$this->_model->validate('user',array('email' => $this->_('email_not_valid')), 'is_email_valid');
		
	}
	private function _validate_new(){
		$this->_model->validate('user',array('email' => $this->_('email_exist')), 'email_not_exist');
	}
	private function _validate_attributes(){
		$this->_model->validate_attributes();
	}
}
