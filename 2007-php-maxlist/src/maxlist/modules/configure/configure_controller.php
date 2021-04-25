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
 * $Id: configure_controller.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/configure/configure_controller.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class ConfigureController extends ModuleController implements IModuleController{
	
	public function __construct(){
		
		//TODO : check_role -  
		//$this->_check_role_view('admin');
		
		//params
		$params = array(
					'do'=> array('in' => 'update', 'm' => 'post'),//TODO : options in
					'confirm'=>array('m' => 'post'),
					'id'=>array('m' => 'post'),
					'values'=>array('m' => 'post', 'd' => array()),
		);
		
		
		$this->_check_params($params);
		
		$this->_model = new ConfigureModel($this->_params);
		
		$this->_do();
		
		$this->_routing();
		
	}
	//GET
	protected function _listall(){
		//carica il model
		$data = $this->_model->get_configurations();
		$this->tpl = 'configure';
		new ConfigureView($this->_params, $data);
	}
	//POST
	protected function _update(){
		$id = $this->_params['id'];
		if($this->_check_errors() && $this->_check_edit() && $update = $this->_model->update($id)){
			$this->_flash(LOG_MAIL_LEVEL, $this->_('config_saved'));
		}	
		$this->_redirect('configure','show',$id); 
	}
}

