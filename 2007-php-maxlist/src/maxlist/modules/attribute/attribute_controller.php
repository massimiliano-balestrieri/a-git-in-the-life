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
 * $Id: attribute_controller.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/attribute/attribute_controller.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class AttributeController extends ModuleController implements IModuleController{
	
	private $_controller = 'attribute';
	
	public function __construct(){
		
		//TODO : check_role -  
		//$this->_check_role_view('admin');
		global $APP;
		$this->_controller = $APP->ROUTING->route ? $APP->ROUTING->route : $APP->ROUTING->controller;
		
		//params
		$params = array(
					'action'=> array('m' => 'post'),
					'do'=> array('in' => '', 'm' => 'post'),//TODO : options in
					'delete'=>array('m' => 'post'),
					'deleteitem'=>array('m' => 'post'),
					'listorder'=>array('m' => 'post'),
					'confirm'=>array('m' => 'post'),
					'attribute'=>array('m' => 'post'),
					'itemlist'=>array('m' => 'post'),
		);
		
		
		$this->_check_params($params);
		
		$this->_model = new AttributeModel($this->_params,$this->_controller);  
		
		$this->_do();
		
		$this->_routing();
		
	}
	//GET
	protected function _listall(){
		$data['attributes'] = $this->_model->get_attributes();
		$data['types'] = $this->_model->get_types();
		
		$this->tpl = 'attributes';
		new AttributeView($this->_params, $data, $this->_model->errors);	
	}
	protected function _items(){
		$id = $this->_id();
		$data['attribute'] = $this->_model->get_attribute($id);
		$data['items'] = $this->_model->get_items($id, $data['attribute']);
		//print_r($data);die;
		$this->tpl = 'items';
		new AttributeView($this->_params, $data, $this->_model->errors);
	}
	protected function _edit(){
		$id = $this->_id();
		$data['attribute'] = $this->_model->get_attribute($id);
		$data['types'] = $this->_model->get_types();
		//print_r($data);die;
		$this->tpl = 'edit';
		new AttributeView($this->_params, $data, $this->_model->errors);
	}
	protected function _create(){
		$data['attribute'] = array();
		$data['types'] = $this->_model->get_types();
		$this->tpl = 'add';
		new AttributeView($this->_params, $data, $this->_model->errors);
	}
	//POST
	protected function _delete_item(){
		$delete = $this->_params['deleteitem'];
		$id = $this->_id();
		if($this->_check_confirm()){
			if($this->_model->have_dependencies($id, $delete)){
				$this->_flash(LOG_LEVEL, $this->_('cannotdelete_dependencies'));	
				$this->_redirect($this->_controller, 'edit', $id);
			}
			if($this->_model->delete_item($id, $delete)){
				$this->_flash(LOG_LEVEL, $this->_('item_deleted'));	
				$this->_redirect($this->_controller, 'items', $id);
			}
		}
	}
	protected function _delete_all_items(){
		$id = $this->_id();
		if($this->_check_confirm() && $this->_model->delete_all_items($id)){
			$this->_flash(LOG_LEVEL, $this->_('all_items_deleted'));	
			$this->_redirect($this->_controller, 'items', $id);
		}
	}
	protected function _change_order(){
		$id = $this->_id();
		if($this->_model->not_valid_order()){
			$this->_flash(LOG_LEVEL, $this->_('order_not_correct'));	
			//return;
			$this->_redirect($this->_controller, 'items', $id);
		}	
		if($this->_model->change_order($id)){
			$this->_flash(LOG_LEVEL, $this->_('order_changed'));	
			$this->_redirect($this->_controller, 'items', $id);
		}
	}
	protected function _add_items(){
		$id = $this->_id();
		if($this->_model->add_items($id)){
			$this->_flash(LOG_LEVEL,$this->_('attribute_values_added'));
		  	$this->_redirect($this->_controller, 'items', $id); 
		}
	}
	protected function _delete_attribute(){
		$delete = $this->_params['delete'];
		if($this->_check_confirm() && $this->_model->delete($delete)){
			$this->_flash(LOG_LEVEL, $this->_('attribute_deleted'));	
		}
	    $this->_redirect($this->_controller); 
	}
	protected function _new(){
		$this->_validate();
		if($this->_check_errors() && $this->_check_create() && $id = $this->_model->insert()){
			$this->_flash(LOG_LEVEL,$this->_('attribute_created'));
		  	$this->_redirect($this->_controller); 
		}
	}
	protected function _update(){
		$id = $this->_id();
		$this->_validate_edit($id);
		if($this->_check_errors() && $this->_check_edit() && $this->_model->update()){
			$this->_flash(LOG_LEVEL,$this->_('attribute_updated'));
		  	$this->_redirect('attribute'); 
		}
	}
	private function _check_delete_attribute(){
		return ($this->_params['confirm'] == $this->_('delete_attribute'));
	}
	//VALIDATE
	private function _validate(){
		$this->_model->validates_presence_of('attribute',array('name' => 'name_required'));
		$this->_model->validate('attribute',array('type' => 'type_not_valid'), 'is_type_valid');
		$this->_validate_type($this->_params['attribute']['type']);
	}
	private function _validate_edit($id){
		$this->_model->validates_presence_of('attribute',array('name' => 'name_required'));
		$this->_validate_type($this->_model->get_type($id));
	}
	private function _validate_type($type){
		if($this->_model->is_type_valid($type)){
			$method = '_validate_' . $type; 
			if(method_exists($this,$method))#//
				$this->$method();
		}
	}
	private function _validate_hidden(){
		$this->_model->validates_presence_of('attribute',array('default' => 'default_required'));		
	}
}