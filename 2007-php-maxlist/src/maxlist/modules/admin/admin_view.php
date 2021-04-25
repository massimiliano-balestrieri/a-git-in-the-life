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
 * $Id: admin_view.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/admin/admin_view.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */
 
class AdminView extends ModuleView implements IModuleView{
	
	public function __construct($params, $data){
		$this->_init($params, $data);
		$this->_routing();
	}
	protected function _listall(){
		global $APP;
		//action
		//paging
		$paging = new TablePaging(MAX_USER_PP, $this->_data['total'], $this->_params['pg'], $this->_params['block']);
		//paging
		$APP->TPL->assign('tpl_tbl_title',$APP->I18N->_('Administrators'));
		$APP->TPL->assign('tpl_paging_total',$this->_data['total']);
		$APP->TPL->assign('tpl_paging_npages',ceil($this->_data['total']/MAX_USER_PP));
		$APP->TPL->assign('tpl_paging_link', $paging->output());
		$APP->TPL->assign('tpl_list_admins', $this->_data['admins']);
	}
	protected function _edit(){
		global $APP;
		//$schema = $APP->SCHEMA->get("admin");
		
		//require_once DIR_INC . '/html.php';
		//$form = new UserForm($APP->I18N->_('Admin Details'),
		//					$schema,
		//					$this->_data,
		//					array("loginname","password","passwordchanged","role","email","superuser","disabled","created","modified","modifiedby"),//campi visibili
		//					array("loginname")
		//					);
		//$form->setSubmit("change");
		//$form->buildForm();
		
		//$form_attrs = new AttributesForm("Attributi", $this->params['id'], $APP->DB->get_table,"admin");
		//$form_attrs->setSubmit("change");
		//$form_attrs->buildForm();
		// fine form
		
		##if(@$_REQUEST['change']){
		##	if($form->errors || $form_attrs->errors){
		##	 	$formerror = errorMessages();
		##	}else{
		##		include_once(DIRACTIONS . "/admin_action.php");
		##	}
		##}
		$this->_push_post('admin');
		$this->_push_post('admingroups');
		$APP->TPL->assign('admin', $this->_data['admin']);
		$APP->TPL->assign('groups',$this->_data['groups']);
		$APP->TPL->assign('admingroups',$this->_data['admingroups']);
		
	}
	protected function _create(){
		
		global $APP;
		$this->_push_post('admin');
		$this->_push_post('admingroups');
		$APP->TPL->assign('admin', $this->_data['admin']);
		$APP->TPL->assign('groups',$this->_data['groups']);
		$APP->TPL->assign('admingroups',$this->_data['admingroups']);
		
		return;
		// inizio form
		//require_once DIR_CONF . '/structure.php';
		//$struct = $GLOBALS['DBstruct']["admin"];//TODO : remove globals
		$schema = $APP->SCHEMA->get("admin");
		
		require_once DIR_INC . '/html.php';
		$form = new UserForm($APP->I18N->_('Admin Details'),
							$schema,
							$this->_data,
							array("loginname","password","passwordchanged","role","email","superuser","disabled","created","modified","modifiedby"),//campi visibili
							array("loginname")
							);
		$form->setSubmit("change");
		$form->buildForm();
		
		//$form_attrs = new AttributesForm("Attributi", $this->params['id'], $APP->DB->get_table,"admin");
		//$form_attrs->setSubmit("change");
		//$form_attrs->buildForm();
		// fine form
		
		##if(@$_REQUEST['change']){
		##	if($form->errors || $form_attrs->errors){
		##	 	$formerror = errorMessages();
		##	}else{
		##		include_once(DIRACTIONS . "/admin_action.php");
		##	}
		##}
		//action
		$lbl_action = array(
							'save'		=>		$APP->I18N->_('Save Changes'),
		);
		$label = $APP->ROLE->is_role_master() || $APP->ROLE->is_role_simple() ? "Modifica il tuo profilo" : "Modifica dati amministratore"; //TODO I18N
		
		###########################################
		###template
		###########################################
		
		//form
		//$APP->TPL->assign('tpl_formerror',@$formerror);
		$APP->TPL->assign('tpl_adminForm',$form->getHtml());
		//$APP->TPL->assign('tpl_adminAttrsForm',$form_attrs->getHtml());
		$APP->TPL->assign('tpl_title',$label);
		//action
		$APP->TPL->assign('tpl_lbl_action',$lbl_action);
	}
	
}
