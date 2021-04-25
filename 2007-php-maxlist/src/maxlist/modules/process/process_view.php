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
 * $Id: process_view.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/process/process_view.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */
 
class ProcessView extends ModuleView implements IModuleView{
	
	public function __construct($params, $data, $errors = false){
		$this->_init($params, $data, $errors);
		$this->_routing();
	}
	protected function _listall(){
		global $APP;
		//require_once DIROBJECTS .'/viewprocess.php';
		//require_once DIRMODELS .'/processqueue_model.php';
		//paging
		$paging = new TablePaging(LIMIT_PAGE, $this->_data['total'], $this->_params['pg'], $this->_params['block']);
		$paging->setTarget('container_messages');
		$APP->TPL->assign('tpl_tbl_title',$APP->I18N->_('Messages'));

		//head
		$APP->TPL->assign('tpl_paging_total',$this->_data['total']);
		$APP->TPL->assign('tpl_paging_npages',ceil($this->_data['total']/LIMIT_PAGE));
		$APP->TPL->assign('tpl_paging_link', $paging->output());
		$APP->TPL->assign('tpl_list_messages', $this->_data['messages']);
		
		//js
		//$APP->TPL->assign('tpl_viewprocess_files',$viewProcess->getFiles());
	}
	protected function _bounces(){
	}
}
