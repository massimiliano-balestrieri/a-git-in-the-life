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
 * $Id: export_controller.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/export/export_controller.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class ExportController extends ModuleController implements IModuleController{
	
	public function __construct(){
		
		//TODO : check_role -  
		//$this->_check_role_view('admin');
		
		global $APP;
		$APP->ROUTING->set_default_action('export');
		
		//TODO: actions,ajax, roles
		//params
		$params = array(
			'toval' => array('d' => date('d/m/Y')),
			'fromval' => array('d' =>  date('d/m/Y')),
			'do'=> array('m' => 'post', 'in' => 'export'),
		);
		
		$this->_check_params($params);
		
		//TODO:$this->_model = new ExportModel($this->_params);  
		
		$this->_do();
		
		$this->_routing();
		
	}
	protected function _export(){
		global $APP;
		$list = $APP->get_model2("list");
		$attribute = $APP->get_model2("attribute");
		$user = $APP->get_model2("user");
		$data['lists'] = $list->get_lists();
		//TODO:$data['attributes'] = $attribute->get_user_attributes_array();
		//TODO:$data['cols'] = $user->get_user_cols();
		$this->tpl = 'export';
		new ExportView($this->_params, $data);	
	}
}
