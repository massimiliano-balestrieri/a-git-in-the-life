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
 * $Id: admin_controller.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/admin/admin_controller.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class AdminController extends ModuleController implements IModuleController{
	
	public function __construct(){
		
		//TODO : check_role -  
		//$this->_check_role_view('admin');
		
		//params
		$params = array(
					'pg' 	=> array('t' => 'int', 'd' => 1),
					'block' => array('t' => 'int', 'd' => 1),
					'delete'=> array('m' => 'post'),
					'filter'=> array(),
					'do'=> array('in' => 'delete,create,edit', 'm' => 'post'),//TODO : options in
					'confirm'=>array('m' => 'post'),
					
					'admin'=>array('m' => 'post','d'=> array()),
					'admingroups'=>array('m' => 'post','d'=> array()),
		);
		
		
		$this->_check_params($params);
		
		//TODO:$this->_model = new AdminModel($this->_params);  
		
		$this->_do();
		
		$this->_routing();
			
	}

	//GET
	protected function _listall(){
		//carica il model
		//TODO:$data = $this->_model->get_page_admins();
		$this->tpl = 'admins';
		//carica la vista
		new AdminView($this->_params, $data);
	}
	
	
	protected function _create(){
		$data = $this->_prepare_data_create($this->_id());
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
		if($this->_check_create()){
			if($is_root = $APP->ROLE->is_super_user() || $is_admin = $APP->ROLE->is_role_admin()){
				//print_r($_POST);die;
			    if(!$APP->REQUEST->post('password')){
			    	$APP->MSG->info($APP->I18N->_('admin_password_required'));
			    	return;
			    }
			    if(!$this->_model->check_username($APP->REQUEST->post('loginname'))){
			    	$APP->MSG->info($APP->I18N->_('admin_username_exist'));
			    	return;
			    }
			    $loginname = strtolower($APP->normalize($APP->REQUEST->post('loginname')));
			    if($this->_model->insert($loginname)){
					$this->_flash(LOG_MAIL_LEVEL, $APP->I18N->_('admin_created'));
			    }
			}else{
		    	$this->_flash(LOG_MAIL_LEVEL, $APP->I18N->_('admin_problem'));
			}
			$this->_redirect(); 
		}
	}
	protected function _update(){
		global $APP;
		if($this->_check_edit()){
			$id = $APP->ROUTING->id;
			if ($id > 0) {
				//verifico nel caso di utente non root o admin che l'id sia il proprio id
			  	if(!$is_root = $APP->ROLE->is_super_user() || !$is_admin = $APP->ROLE->is_role_admin()){
					if($id != $APP->SESSION->get_auth_id()){
				    	$this->_flash(LOG_MAIL_LEVEL,  $APP->I18N->_('admin_problem2'));
			  		}
			  	}
			  	if($this->_model->update($id)){
					$this->_flash(LOG_MAIL_LEVEL,  $APP->I18N->_('admin_updated'));
			    }
			} else {
			    $this->_flash(LOG_MAIL_LEVEL,  $APP->I18N->_('error_msg2'));
		 	}
			$this->_redirect(); 
		}
	}
	protected function _remove(){
		global $APP;
		if($this->_check_confirm()){
			if($is_root = $APP->ROLE->is_super_user() || $is_admin = $APP->ROLE->is_role_admin()){
				//print_r($APP->AUTH);die;
				# delete the index in delete
			  	$delete = sprintf('%d',$this->_params['delete']);
			    $role = $this->_model->get_role($delete);
			  	if($role > $APP->SESSION->get_role() || ($is_root && $role != 0)){
					if($this->_model->delete($delete)){
			  			$this->_flash(LOG_MAIL_LEVEL,$APP->I18N->_('admin_deleted'));
					}
			  	}else{
			  		$this->_flash(LOG_MAIL_LEVEL,$APP->I18N->_('admin_del_error_level'));
			  	}
			    $this->_redirect(); 
			}
		}
	}
	private function _form($data){
		$this->tpl = 'form';
		//print_r($data);die;
		new AdminView($this->_params, $data, $this->_model->errors);
	}
	private function _prepare_data_edit($id){
		global $APP;
		$data['admin'] = $this->_model->get($id);
		$data['admingroups'] = $APP->get_model2("admingroup")->get_admingroups($id);//vuole un array
		$data['groups'] = $APP->get_model2("group")->get_groups($id);//vuole un array
		return $data;
		//admin_not_exist
	}
	private function _prepare_data_create($id){
		global $APP;
		$data['admin'] = array();
		$data['admingroups'] = array();//vuole un array
		$data['groups'] = $APP->get_model2("group")->get_groups($id);//vuole un array
		return $data;
		//admin_not_exist
	}
	private function _validate_insert(){
		$this->_model->validates_presence_of('admin',array('password' => 'admin_password_required'));
	}
	private function _validate(){
		$this->_model->validates_presence_of('admin',array('loginname' => 'username_required','email' => 'email_required'));
		$this->_model->validate('admin',array('loginname' => 'admin_username_exist'), 'check_username');
		$this->_model->validate('admin',array('email' => 'email_not_valid'), 'is_email_valid');
		$this->_model->validates_presence_of(false,array('usergroups' => 'selectgroups'));
	}
}
