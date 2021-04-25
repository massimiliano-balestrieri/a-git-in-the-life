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
 
class MembersView extends ModuleView implements IModuleView{
	
	public function __construct($params, $data, $errors = false){
		$this->_init($params, $data , $errors);
		$this->_routing();
	}
	protected function _listall(){
		global $APP;
		//head
		$checked = array(
						'asc'		  => $this->_params['sortorder'] == 'asc' ?' checked="checked"':'',
		);
		
		$this->_push_post('user');
		//print_r($this->_data['user']);die;
		//paging
		$paging = new TablePaging(LIMIT_PAGE, $this->_data['members']['total'], $this->_params['pg'], $this->_params['block']);
		$paging->setTarget('container_members');
		
		//messages
		$APP->TPL->assign('tpl_config',array('MEMBERS_ADDUSER'=>MEMBERS_ADDUSER, 'URL_IMG_NO'=>URL_IMG_NO, 'URL_IMG_YES' => URL_IMG_YES));
		
		$APP->TPL->assign('tpl_paging_total',$this->_data['members']['total']);
		$APP->TPL->assign('tpl_paging_npages',ceil($this->_data['members']['total']/LIMIT_PAGE));
		$APP->TPL->assign('tpl_paging_link', $paging->output());
		$APP->TPL->assign('tpl_list_users', $this->_data['members']['data']);
		$APP->TPL->assign('members', $this->_data['members']['members']);
		$APP->TPL->assign('tpl_list_lists', $this->_data['lists']);
		$APP->TPL->assign('list_name', $this->_data['list_name']);	

		$APP->TPL->assign('user',$this->_data['user']);
		
		//print_r($this->_errors);die;
		if(isset($this->_data['user_attributes']))
			$APP->TPL->assign('user_attributes', $this->_data['user_attributes']); 
		
	}
}
