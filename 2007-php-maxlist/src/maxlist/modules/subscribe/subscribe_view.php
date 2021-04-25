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
 * $Id:scaffold_view.php 211 2007-11-10 11:45:22Z maxbnet $
 * $LastChangedDate:2007-11-10 12:45:22 +0100 (sab, 10 nov 2007) $
 * $LastChangedRevision:211 $
 * $LastChangedBy:maxbnet $
 * $HeadURL:https://maxlist.svn.sourceforge.net/svnroot/maxlist/trunk/maxlist/modules/_scaffold/scaffold_view.php $
 * 
 * $Author:maxbnet $
 * $Date:2007-11-10 12:45:22 +0100 (sab, 10 nov 2007) $
 */
 
class SubscribeView extends ModuleView implements IModuleView{
	
	public function __construct($params, $data, $errors = false){
		$this->_init($params, $data , $errors);
		$this->_routing();
	}
	protected function _confirm(){
		global $APP;
		$APP->TPL->assign('list_confirm',$this->_data['str_lists']);
	}
	protected function _unsubscribe(){
		global $APP;
		$APP->TPL->assign('user',$this->_data['user']);
	}
	//copy of user_view->_update
	protected function _preferences(){
		$this->_assign_form();
	}
	//copy of user_view->_create 
	protected function _subscribe(){
		$this->_assign_form();
	}
	//copy of user_view->_assign_form 
	private function _assign_form(){
		global $APP;
		
		$this->_push_post('user');
		$this->_push_post('subscribe');
		//print_r($this->_data['subscribe']);die;
		
		$APP->TPL->assign('checked',$this->_get_checked_edit());
		$APP->TPL->assign('user',$this->_data['user']);
		$APP->TPL->assign('user_attributes', $this->_data['user_attributes']); 
		$APP->TPL->assign('lists',$this->_data['lists']);
		$APP->TPL->assign('subscribe',$this->_data['subscribe']);
	}
	//copy of user_view->_get_checked_edit 
	private function _get_checked_edit(){
		//mi aspetto che i params siano tutti settati a 0 o a 1
		return array(
				//TODO: method for views _data_in()?
				'htmlemail'=>	$this->_params['user']['htmlemail'] || $this->_data['user']['htmlemail'] ? ' checked="checked"' : '',
				'confirmed'=> 	$this->_params['user']['confirmed'] || $this->_data['user']['confirmed'] ? ' checked="checked"' : '',
				'disabled'=> 	$this->_params['user']['disabled'] || $this->_data['user']['disabled'] ? ' checked="checked"' : '',
				'blacklisted'=> $this->_params['user']['blacklisted'] || $this->_data['user']['blacklisted'] ? ' checked="checked"' : '',
		);
	}
}
