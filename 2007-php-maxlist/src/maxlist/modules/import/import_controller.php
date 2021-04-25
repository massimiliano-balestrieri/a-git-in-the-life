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
 * $Id: import_controller.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/import/import_controller.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class ImportController extends ModuleController implements IModuleController{
	
	public function __construct(){
		
		//TODO : check_role -  TODO : ALLOW_IMPORT
		//$this->_check_role_view('admin');
		
		global $APP;
		$APP->ROUTING->set_default_action('user');
		
		//params
		$params = array(
					'column'=>array('m' => 'post'),
					
					'import_file'=>array('m' => 'post'),
					'notify'=>array('m' => 'post'),
					'import_field_delimiter'=>array('m' => 'post'),
					'import_record_delimiter'=>array('m' => 'post'),
					
					'show_warnings'=>array('m' => 'post','d' => 0),
					'omit_invalid'=>array('m' => 'post','d' => 0),
					'assign_invalid'=>array('m' => 'post','d' => 0),
					'overwrite'=>array('m' => 'post','d' => 0),
					'retainold'=>array('m' => 'post','d' => 0),
					'listname'=>array('m' => 'post','d' => 0),
					'lists'=>array('m' => 'post','d' => 0),
					
					'do'=> array('in' => 'userimport', 'm' => 'post'),//TODO : options in
					'confirm'=>array('m' => 'post')
		);
		
		
		$this->_check_params($params);
		
		//TODO:$this->_model = new ImportModel($this->_params);  
		
		$this->_do();
		
		$this->_routing();
		
	}
	protected function _user(){
		$this->tpl = 'import';
		new ImportView($this->_params, array());	
	}
	protected function _userimport(){
		$this->_model->userimport();
	}
}