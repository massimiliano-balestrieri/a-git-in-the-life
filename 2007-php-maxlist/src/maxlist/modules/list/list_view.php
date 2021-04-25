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
 * $Id: list_view.php 299 2007-11-23 20:37:31Z maxbnet $
 * $LastChangedDate: 2007-11-23 20:37:31 +0000 (Fri, 23 Nov 2007) $
 * $LastChangedRevision: 299 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/list/list_view.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-11-23 20:37:31 +0000 (Fri, 23 Nov 2007) $
 */
 
class ListView extends ModuleView implements IModuleView{
	
	public function __construct($params, $data, $errors = false){
		$this->_init($params, $data, $errors);
		$this->_routing();
	}
	protected function _listall(){
		global $APP;
		$APP->TPL->assign('tpl_lists', $this->_data);
	}
	protected function _create(){
		$this->_assign();
	}
	protected function _edit(){
		$this->_assign();
	}
	private function _assign(){
		global $APP;
		$this->_push_post('list');
		$APP->TPL->assign('tpl_list',$this->_data['list']);
		$APP->TPL->assign('tpl_admins',$this->_data['admins']);
		$APP->TPL->assign('checked',$this->_get_checked());
	}
	private function _get_checked(){
		return array(
			'active' => isset($this->_params['list']['active']) ?' checked="checked"':'',
		);			
	}
}