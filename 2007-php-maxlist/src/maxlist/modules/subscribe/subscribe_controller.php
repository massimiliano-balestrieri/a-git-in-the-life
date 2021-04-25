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
 * $Id:scaffold_controller.php 264 2007-11-16 19:25:56Z maxbnet $
 * $LastChangedDate:2007-11-16 20:25:56 +0100 (ven, 16 nov 2007) $
 * $LastChangedRevision:264 $
 * $LastChangedBy:maxbnet $
 * $HeadURL:https://maxlist.svn.sourceforge.net/svnroot/maxlist/trunk/maxlist/modules/_scaffold/scaffold_controller.php $
 * 
 * $Author:maxbnet $
 * $Date:2007-11-16 20:25:56 +0100 (ven, 16 nov 2007) $
 */

class SubscribeController extends ModuleController implements IModuleController{
	
	
	public function __construct(){
		
		global $APP;
		//TODO : check_role -  
		//$this->_check_role_view('admin');
		
		global $APP;
		$APP->ROUTING->set_default_action('subscribe');
		//$APP->ROUTING->action = 'subscribe';
		
		//params
		$params = array(
					'do'=> array('in' => '', 'm' => 'post'),//TODO : options in
					'confirm'=>array('m' => 'post'),
		
					'user'=>array('m' => 'post', 'd' => array()),
					'subscribe'=>array('m' => 'post', 'd' => array()),
					'unsubscribe'=>array('m' => 'post', 'd' => array()),

					//required
					'attribute'=>array('m' => 'post', 'd' => array()),
					'cbgattribute'=>array('m' => 'post', 'd' => array()),	
					'cbattribute'=>array('m' => 'post', 'd' => array()),	
					'cbgroup'=>array('m' => 'post', 'd' => array()),	
		);
		
		$this->_check_params($params);
		$this->_set_param_default_value('confirmed',0,'user');
		$this->_set_param_default_value('htmlemail',0,'user');
		$this->_set_param_default_value('disabled',0,'user');
		$this->_set_param_default_value('blacklisted',0,'user');
		
		
		$this->_model = new SubscribeModel($this->_params);  
		
		$this->_do();
		
		$this->_routing();
		
	}
	//GET
	//copy of user_controller->_insert
	protected function _subscribe(){
		$data = $this->_prepare_data_create();
		$this->_form($data);
	}
	//GET
	//copy of user_controller->_update
	protected function _preferences(){
		$data = $this->_prepare_data_edit();
		$this->_form($data);
	}
	//GET
	protected function _unsubscribe(){
		global $APP;
		$uniq = $this->_id();
		$id = $this->_get_id($uniq); 
		$data['user'] = $APP->get_model2("user")->get($id);
		$this->tpl = 'unsubscribe';
		new SubscribeView($this->_params, $data, $this->_model->errors);
	}
	//GET - exception
	protected function _confirm(){
		//TODO:confirm
		global $APP;
		$uniq = $this->_id();
		$id = $this->_get_id($uniq); 
		if($id && $confirm = $this->_model->confirm($id)){
			$this->_info($this->_('str_confirm_info'));
			$data['str_lists'] = $APP->get_model2("members")->get_array_memberships($id);//$this->_model->get_subscribe_listname($id);
			$this->tpl = 'confirm';
			new SubscribeView($this->_params, $data, $this->_model->errors);
		}else{
			die("<!-- confirm failed-->");
		}
	}
	//POST
	protected function _new(){
		$this->_validate();
		$this->_validate_new();
		$this->_validate_attributes();
		if($this->_check_errors() && $this->_check_create() && $this->_model->subscribe()){
			$this->_flash(LOG_LEVEL,$this->_('user_subscribed'));
		  	$this->_redirect(); 
		}	
	}
	//POST
	protected function _update(){
		$this->_validate();
		$this->_validate_attributes();
		$uniq = $this->_id();
		$id = $this->_get_id($uniq); 
		if($this->_check_errors() && $this->_check_edit() && $this->_model->preferences($id)){
			$this->_flash(LOG_LEVEL,$this->_('user_preferences_updated'));
		  	$this->_redirect('subscribe', 'preferences', $uniq); 
		}	
	}
	//POST
	protected function _blacklist(){
		$uniq = $this->_id();
		$id = $this->_get_id($uniq); 
		if($blacklisted = $this->_model->unsubscribe($id)){
			$this->_flash(LOG_LEVEL,$this->_('user_unsubscribed'));
		  	$this->_redirect(); 
		}
	}
	
	//PRIVATE
	//copy of user_controller->_form
	private function _form($data){
		$this->tpl = 'form';
		//print_r($data);die;
		new SubscribeView($this->_params, $data, $this->_model->errors);
	}
	//copy of user_controller->_prepare_data_create
	private function _prepare_data_create(){
		global $APP;
		$data['user'] = array();
		$data['user_attributes'] = $this->_prepare_attributes();
		$data['lists'] = $APP->get_model2("list")->get_lists_active();
		$data['subscribe'] = array();
		return $data;
	}
	//copy of user_controller->_prepare_data_edit
	private function _prepare_data_edit(){
		global $APP;
		$uniq = $this->_id();//no in user_controller
		$id = $this->_get_id($uniq);//no in user_controller 
		
		$data['user'] = $APP->get_model2("user")->get($id);
		$data['user_attributes'] = $this->_prepare_attributes($id);
		$data['subscribe'] = $APP->get_model2("members")->get_array_memberships($id);//vuole un array
		$data['lists'] = $APP->get_model2("list")->get_lists_active($id);//vuole un array
		return $data;
	}
	private function _prepare_attributes($id = false){
		return $this->_model->get_user_attributes($id);
	}
	private function _validate_new(){
		$this->_model->validates_presence_of('user',array('terms' => 'terms_error'));
		$this->_model->validate('user',array('terms' => 'terms_error'), 'is_terms_accepted');
		$this->_model->validate('user',array('email' => 'email_exist'), 'email_not_exist');
	}
	private function _validate(){
		$this->_model->validates_presence_of('user',array('email' => 'email_required'));
		$this->_model->validate('user',array('email' => 'email_not_valid'), 'is_email_valid');
		if(!ALLOW_NO_SUBSCRIBE)
		$this->_model->validates_presence_of(false,array('subscribe' => 'selectlist'));
	}
	private function _validate_attributes(){
		$this->_model->validate_attributes();
	}
	//help id -> uniqid
	private function _get_id($uniqid){
		global $APP;
		return $APP->get_model2("user")->get_id_by_uniqid($uniqid);
	}
	
}
