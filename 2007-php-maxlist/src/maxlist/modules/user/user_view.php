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
 * $Id: user_view.php 384 2008-01-08 19:25:09Z maxbnet $
 * $LastChangedDate: 2008-01-08 19:25:09 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 384 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/user/user_view.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 19:25:09 +0000 (Tue, 08 Jan 2008) $
 */
 
class UserView extends ModuleView implements IModuleView{
	
	public function __construct($params, $data, $errors = false){
		$this->_init($params, $data , $errors);
		$this->_routing();
	}
	protected function _create(){
		$this->_assign_form();
	}
	protected function _edit(){
		$this->_assign_form();
	}
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
	protected function _listall(){
		global $APP;

		
		$checked = array(
						'unconfirmed' => $this->_param('unconfirmed')?' checked="checked"':'',
						'blacklisted' => $this->_param('blacklisted')?' checked="checked"':'',
						'asc'		  => $this->_param('sortorder') == 'asc' ? ' checked="checked"': '',
						'desc'		  => $this->_param('sortorder') == 'desc' ?' checked="checked"':''
		);

		//messages
		$APP->TPL->assign('tpl_config',array('URL_IMG_NO'=>URL_IMG_NO, 'URL_IMG_YES' => URL_IMG_YES));
		
		//paging
		$paging = new TablePaging(LIMIT_PAGE, $this->_data['total'], $this->_params['pg'], $this->_params['block']);
		$paging->setTarget('container_users');
		//form
		$APP->TPL->assign('tpl_checked',$checked);
		$APP->TPL->assign('tpl_select_sortby',array('email'=>$this->_('email'),
													'bouncecount'=>$this->_('bouncecount'),
													'entered'=>$this->_('entered'),
													'modified'=>$this->_('modified2')));
		$APP->TPL->assign('tpl_select_findby',array('email'=>$this->_('email')));

		//paging
		$APP->TPL->assign('tpl_tbl_title',$APP->I18N->_('users'));
		$APP->TPL->assign('tpl_paging_total',$this->_data['total']);
		$APP->TPL->assign('tpl_paging_npages',ceil($this->_data['total']/LIMIT_PAGE));
		$APP->TPL->assign('tpl_paging_link', $paging->output());
		$APP->TPL->assign('tpl_list_users', $this->_data['data']);
		$APP->TPL->assign('lists', $this->_data['lists']);
		$APP->TPL->assign('nummsg', $this->_data['nummsg']);
		
	}
	protected function _members(){
			
	}
	
	

}
