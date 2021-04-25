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
 * $Id: list_controller.php 383 2008-01-08 18:56:42Z maxbnet $
 * $LastChangedDate: 2008-01-08 18:56:42 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 383 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/list/list_controller.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 18:56:42 +0000 (Tue, 08 Jan 2008) $
 */

class ListController extends ModuleController implements IModuleController{
	
	public function __construct(){
		
		//TODO : check_role -  
		//$this->_check_role_view('admin');
		
		$params = array(
					'increase'=> array('m' => 'post', 'd' => false),
					'decrease'=> array('m' => 'post', 'd' => false),
					'active'=> array('m' => 'post', 'd' => false),
					'delete'=> array('m' => 'post'),
					'list' => array('d'=> array()),
					'do'=> array('in' => 'remove,new,update,set_active', 'm' => 'post'),//TODO : options in
					'confirm'=>array('m' => 'post')
		);
		
		$this->_check_params($params);
		
		$this->_model = new ListModel($this->_params);  
		
		//print_r($this->_params);die;
		$this->_do();
		$this->_special_do('increase');
		$this->_special_do('decrease');
			
		$this->_routing();
		
	}
	//GET
	protected function _listall(){
		$data = $this->_model->get_lists();
		$this->tpl = 'lists';
		new ListView($this->_params, $data);	
	}
	protected function _edit(){
		$id = $this->_id();
		$data['list'] = $this->_model->get($this->_id());
		$this->_form($data);
	}
	protected function _create(){
		$data['list'] = array();
		$this->_form($data);
	}
	protected function _delete(){
		$this->_listall();
	}
	//POST
	protected function _new(){
		$this->_model->validates_presence_of('list',array('name' => $this->_('list_name_required'), 
											 'description' => $this->_('list_description_required')));
		if($this->_check_errors() && $this->_check_create() && $this->_model->insert()){
			$this->_flash(LOG_MAIL_LEVEL, $this->_('list_created'));
			$this->_redirect();
		}
	}
	protected function _update(){
		$this->_model->validates_presence_of('list',array('name' => $this->_('list_name_required'), 
														  'description' => $this->_('list_description_required')));
		$id = $this->_id();
		if($this->_check_errors() && $this->_check_edit() && $this->_model->update($id)){
		  	$this->_flash(LOG_MAIL_LEVEL,$this->_('list_updated'));
		    $this->_redirect(); 
		}
	}
	protected function _remove(){
	  	$delete = $this->_params['delete'];
		if($this->_check_confirm() && $this->_model->delete($delete)){
			$this->_flash(LOG_MAIL_LEVEL, $this->_('list_deleted'));	
		}
	    $this->_redirect(); 
	}
	protected function _increase(){
		$this->_set_order();
	}
	protected function _decrease(){
		$this->_set_order();
	}
	
	protected function _set_active(){
		if($this->_check_active() && $this->_model->set_active()){
	  		$this->_flash(LOG_MAIL_LEVEL, $this->_('list_status_updated'));	
			$this->_redirect(); 
		}
	}
	//PRIVATE
	private function _form($data){
		$data['admins'] = array('root');//TODO: list other roles
		$this->tpl = 'list';//print_r($this->_model->errors);
		new ListView($this->_params, $data, $this->_model->errors);
	}
	private function _set_order(){
	  	if($this->_model->set_order()){
			$this->_flash(LOG_LEVEL, $this->_('list_ordered'));	
		}
		$this->_redirect('list'); 
	}
	private function _check_active(){
		return ($this->_params['confirm'] == $this->_('update'));
	}
	
}