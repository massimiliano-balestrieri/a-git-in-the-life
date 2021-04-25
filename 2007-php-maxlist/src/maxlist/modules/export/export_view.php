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
 * $Id: export_view.php 242 2007-11-12 15:47:03Z maxbnet $
 * $LastChangedDate: 2007-11-12 15:47:03 +0000 (Mon, 12 Nov 2007) $
 * $LastChangedRevision: 242 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/export/export_view.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-11-12 15:47:03 +0000 (Mon, 12 Nov 2007) $
 */
 
class ExportView extends ModuleView implements IModuleView{
	
	public function __construct($params, $data, $errors = false){
		$this->_init($params, $data, $errors);
		$this->_routing();
	}
	
	protected function _export(){
		global $APP;
		//calendar
		require_once(DIR_JSCALENDAR."/calendar.php");
		$cal_from = new DHTML_Calendar(URL_JSCALENDAR. "/",'it','calendar-blue');
		$cal_to = new DHTML_Calendar(URL_JSCALENDAR. "/",'it','calendar-blue');
		$cal_from->set_option('ifFormat','%d/%m/%Y');
		$cal_to->set_option('ifFormat','%d/%m/%Y');
		$html_cal_from = $cal_from->return_input_field(array(),array('name' => 'datefrom','value' => $this->_params['fromval']));
		$html_cal_to = $cal_to->return_input_field(array(),array('name' => 'dateto','value' => $this->_params['toval']));
		
		//TODO:while($cell = each($checkbox_attributes)){
		//	$checked[$cell['key']] = !isset($_POST['process']) || in_array($cell['key'] ,$_POST['attrs']) ? ' checked="checked"': '';
		//}
		//while($cell = each($checkbox_cols)){
		//	$checked[$cell['key']] = !isset($_POST['process']) || in_array($cell['key'] ,$_POST['cols']) ? ' checked="checked"': '';
		//}

		//form
		$APP->TPL->assign('tpl_checked',$this->_get_checked());
		$APP->TPL->assign('tpl_select_lists',$this->_data['lists']);
		$APP->TPL->assign('tpl_checkbox_attributes',$this->_data['attributes']);
		$APP->TPL->assign('tpl_checkbox_cols',$this->_data['cols']);
		//jscalendar
		$APP->TPL->assign('tpl_jscalendar_files',$cal_from->return_files());
		$APP->TPL->assign('tpl_form_calfrom',$html_cal_from);
		$APP->TPL->assign('tpl_form_calto',$html_cal_to);
	}
	private function _get_checked(){
		return array(
						'column_entered' => !isset($_POST['column']) || @$_POST['column'] == 'entered' ?' checked="checked"':'',
						'column_modified' => @$_POST['column'] == 'modified' ?' checked="checked"':'',
						'column_listentered' => @$_POST['column'] == 'listentered'?' checked="checked"':'',
		);
	}
}