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
 * $Id: bounce_controller.php 258 2007-11-14 17:10:53Z maxbnet $
 * $LastChangedDate: 2007-11-14 17:10:53 +0000 (Wed, 14 Nov 2007) $
 * $LastChangedRevision: 258 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/bounce/bounce_controller.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-11-14 17:10:53 +0000 (Wed, 14 Nov 2007) $
 */

class BounceController extends ModuleController implements IModuleController{
	
	public function __construct(){
		
		//TODO : check_role -  
		//$this->_check_role_view('admin');
		
		$params = array(
					'pg' 	=> array('t' => 'int', 'd' => 1),
					'block' => array('t' => 'int', 'd' => 1),
					'do'=> array('in' => '', 'm' => 'post'),//TODO : options in
					'confirm'=>array('m' => 'post')
		);
		
		
		$this->_check_params($params);
		
		$this->_model = new BounceModel($this->_params);  
		
		$this->_do();
		
		$this->_routing();
		
	}
	//GET
	protected function _listall(){
		$data = $this->_model->get_page_bounces();
		$this->tpl = 'bounces';
		new BounceView($this->_params, $data);	
	}
	protected function _view(){
		$data = $this->_model->get($this->_id());
		$this->tpl = 'bounce';
		new BounceView($this->_params, $data);	
	}

}


?>