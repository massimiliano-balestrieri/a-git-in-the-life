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
 * $Id: attribute_view.php 365 2008-01-05 18:32:37Z maxbnet $
 * $LastChangedDate: 2008-01-05 18:32:37 +0000 (Sat, 05 Jan 2008) $
 * $LastChangedRevision: 365 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/attribute/attribute_view.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-05 18:32:37 +0000 (Sat, 05 Jan 2008) $
 */
 
class AttributeView extends ModuleView implements IModuleView{
	
	private $_controller = 'attribute';
	
	public function __construct($params, $data, $errors = false){
		
		global $APP;
		$this->_controller = $APP->ROUTING->route ? $APP->ROUTING->route : $APP->ROUTING->controller;
		
		$this->_init($params, $data, $errors);
		$this->_routing();
	}
	protected function _listall(){
		global $APP;
		$APP->TPL->assign('tpl_config',array('URL_IMG_NO'=>URL_IMG_NO, 'URL_IMG_YES' => URL_IMG_YES));
		$APP->TPL->assign('tpl_lists_attributes',$this->_data['attributes']);
		$APP->TPL->assign('ENTITY',$this->_controller);
	}
	protected function _create(){
		$this->_assign();
	}
	protected function _edit(){
		$this->_assign();
	}
	protected function _items(){
		global $APP;
		$APP->TPL->assign('tpl_data',$this->_data['attribute']);
		$APP->TPL->assign('tpl_items',$this->_data['items']);
		$APP->TPL->assign('ENTITY',$this->_controller);
	}
	private function _assign(){
		global $APP;
		
		$this->_push_post('attribute');
		
		$APP->TPL->assign('attr',$this->_data['attribute']);
		$APP->TPL->assign('tpl_lists_types',$this->_data['types']);
		$APP->TPL->assign('ENTITY',$this->_controller);
	}

		
}