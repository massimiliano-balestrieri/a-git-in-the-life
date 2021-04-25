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

class GroupController extends ModuleController implements IModuleController{
	
	public function __construct(){
		
		//TODO : check_role -  
		//$this->_check_role_view('admin');
		
		//params
		$params = array(
					'do'=> array('in' => 'remove,new,update', 'm' => 'post'),//TODO : options in
					'confirm'=>array('m' => 'post'),
					'delete'=> array('m' => 'post'),
					'group' => array('d'=> array()),
		);
		
		
		$this->_check_params($params);
		
		
		$this->_model = new GroupModel($this->_params);  
		
		$this->_do();
		
		$this->_routing();
		
	}
	//GET
	protected function _listall(){
		$data = $this->_model->get_groups();
		$this->tpl = 'groups';
		new GroupView($this->_params, $data);	
	}
	
	protected function _edit(){
		$id = $this->_id();
		$data['group'] = $this->_model->get($this->_id());
		$this->_form($data);
	}
	protected function _create(){
		$data['group'] = array();
		$this->_form($data);
	}
	protected function _delete(){
		$this->_listall();
	}
	//POST
	protected function _new(){
		$this->_validate();
		if($this->_check_errors() && $this->_check_create() && $this->_model->insert()){
			$this->_flash(LOG_MAIL_LEVEL, $this->_('group_created'));
			$this->_redirect();
		}
	}
	protected function _update(){
		$this->_validate();
		$id = $this->_id();
		if($this->_check_errors() && $this->_check_edit() && $this->_model->update($id)){
		  	$this->_flash(LOG_MAIL_LEVEL,$this->_('group_updated'));
		    $this->_redirect(); 
		}
	}
	protected function _remove(){
	  	$delete = $this->_params['delete'];
		if($this->_check_confirm() && $this->_model->delete($delete)){
			$this->_flash(LOG_MAIL_LEVEL, $this->_('group_deleted'));	
		}
	    $this->_redirect(); 
	}
	//PRIVATE
	private function _form($data){
		$this->tpl = 'group';//print_r($this->_model->errors);
		new GroupView($this->_params, $data, $this->_model->errors);
	}
	private function _validate(){
		$this->_model->validates_presence_of('group',array('name' => 'group_name_required'));
		$this->_model->validate('group',array('name' => 'groupname_exist'), 'check_unique_name');
	}
}
