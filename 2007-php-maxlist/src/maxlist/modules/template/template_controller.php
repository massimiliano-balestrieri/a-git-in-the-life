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
 * $Id: template_controller.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/template/template_controller.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class TemplateController extends ModuleController implements IModuleController{
	
	public function __construct(){
		
		//TODO : check_role -  
		//$this->_check_role_view('admin');
		
		$this->_info($this->_('work_in_progress'));
		
		//TODO: actions,ajax, roles
		//params
		$params = array(
					'template'=>array('m' => 'post','d' => array()),//TODO:'content' => '[CONTENT]'
					'delete'=>array('m' => 'post'),
					'do'=> array('in' => 'default,new,update,delete', 'm' => 'post'),//TODO : options in
					'confirm'=>array('m' => 'post'),
		);
		
		
		$this->_check_params($params);
		
		//istance model
		$this->_model = new TemplateModel($this->_params);  
		
		$this->_do();
		
		$this->_routing();
		
	}
	protected function _listall(){
		global $APP;
		$data['templates'] = $this->_model->get_templates();
		$data['default'] = $APP->CONF->get('default_message_template');
		
		if(sizeof($data['templates']) == 0)
			$this->_info($this->_('No template have been defined'));		
		
		$this->tpl = 'templates';
		new TemplateView($this->_params, $data);	
	}
	protected function _edit(){
		$this->_check_uri('edit', $this->_param_in('template', 'id'));
		$data['template'] = $this->_model->get($this->_id());
		$this->_form($data);
	}
	protected function _delete(){
		$this->_check_uri('delete', $this->_param_in('template', 'id'));
		$this->_listall();
	}
	//POST
	protected function _new(){
		if($id = $this->_model->insert()){
			### create template and redirect like message. 
			$this->_redirect('template','edit',$id); 
		}
		die("template new");	
	}
	protected function _update(){
		$this->_validate();
		$id = $this->_id();
		if($this->_check_errors() && $this->_check_edit() && $this->_model->update($id)){
			$this->_flash(LOG_LEVEL,$this->_("Template saved"));
			$this->_redirect(); 
		}
	}
	protected function _remove(){
		$delete = $this->_params['delete'];
		if($this->_check_confirm() && $this->_model->delete($delete)){
	  		$this->_flash(LOG_LEVEL,$this->_('template_deleted'));
			$this->_redirect(); 
		}
	}
	protected function _default(){
		global $APP;
		$this->_model->validates_presence_of('template',array('id' => 'No such template'));
		if($this->_check_errors() && $this->_model->set_default()){
	  		$this->_flash(LOG_LEVEL,$this->_('template_set_default'));
			$this->_redirect();  
		}
	}
	//PRIVATE
	private function _form($data){
		$this->tpl = 'template';
		new TemplateView($this->_params, $data, $this->_model->errors);
	}
	private function _validate(){
		$this->_model->validates_presence_of('template',array('title' => 'No Title', 'content' => 'Template does not contain the [CONTENT] placeholder'));
		$this->_model->validate('template',array('content' => 'Template does not contain the [CONTENT] placeholder'),'check_placeholder');
		$this->_model->validate('template',array('title' => 'unique_title'),'check_unique_title');
	}
	
}