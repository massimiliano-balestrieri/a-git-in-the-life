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
 * Maxlist is a fork of PhpList, a newsletter manager. 
 * The code was deeply changed so there are features of the original phpList and new ones. 
 * It uses smarty, generates XHTML strict, uses an AJAX layer, italian language ,
 * multi-istance, and use case based.
 *
 * 
 * $Id: eventlog_view.php 313 2007-11-24 18:57:21Z maxbnet $
 * $LastChangedDate: 2007-11-24 18:57:21 +0000 (Sat, 24 Nov 2007) $
 * $LastChangedRevision: 313 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/eventlog/eventlog_view.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-11-24 18:57:21 +0000 (Sat, 24 Nov 2007) $
 */
 
class EventlogView extends ModuleView implements IModuleView{
	public function __construct($params, $data){
		$this->_init($params, $data);
		$this->_routing();
	}
	protected function _listall(){
		global $APP;
		
		
		//paging
		$pag = new TablePaging(LIMIT_PAGE, $this->_data['total'], $this->_params['pg'], $this->_params['block']);

		//paging
		$APP->TPL->assign('tpl_paging_total',$this->_data['total']);
		$APP->TPL->assign('tpl_paging_npages',ceil($this->_data['total']/LIMIT_PAGE));
		$APP->TPL->assign('tpl_paging_link', $pag->output());
		$APP->TPL->assign('tpl_list_events', $this->_data['data']);
	}
}