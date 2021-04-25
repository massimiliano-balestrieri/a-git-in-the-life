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
 * $Id: import_view.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/import/import_view.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */
 
class ImportView extends ModuleView implements IModuleView{
	
	public function __construct($params, $data, $errors = false){
		$this->_init($params, $data, $errors);
		$this->_routing();
	}

	protected function _user(){
		$this->_assign();				
	}
	private function _assign(){
		global $APP;
		$lbl_action =  $this->_get_lbl_actions();
		$lbl_messages =  $this->_get_lbl_messages();
		$checked = $this->_get_checked();
		
		$APP->TPL->assign('tpl_template',$this->_data);
		//$APP->TPL->assign('tpl_lists',$this->_data);//TODO
		
		//TODO:$APP->TPL->assign('tpl_test_import',@$_SESSION["import"]["test_import"]);
		//TODO:$APP->TPL->assign('tpl_result_import',@$_SESSION["result_import"]);
		//TODO:$APP->TPL->assign('tpl_test_html',@$test_html);
		//TODO:$APP->TPL->assign('tpl_result_html',@$result_html);
		//test
		//TODO:$APP->TPL->assign('tpl_test',@$html_test);
		
		$APP->TPL->assign('tpl_checked',$checked);
		$APP->TPL->assign('tpl_lbl_action',$lbl_action);
		$APP->TPL->assign('tpl_lbl_messages',$lbl_messages);	
	}
	
	private function _get_lbl_actions(){
		global $APP;
		return array(
					'import'	=> 		$APP->I18N->_('Import'),
					'reset'		=> 		$APP->I18N->_('Reset Import session'),
					'confirm'	=>		$APP->I18N->_('Confirm Import'),
		);
	}
	private function _get_lbl_messages(){
		global $APP;
		return array(
					'importintro'	=> $APP->I18N->_('importintro'),
					'infoupload'	=> sprintf($APP->I18N->_('uploadlimits'),ini_get("post_max_size"),ini_get("upload_max_filesize")),
					'file'			=> $APP->I18N->_('File containing emails'),
					'fieldlimit'	=> $APP->I18N->_('Field Delimiter'),
					'recordlimit'	=> $APP->I18N->_('Record Delimiter'),
					'testoutput'	=> $APP->I18N->_('Test output'),
					'testoutput_blurb'	=> $APP->I18N->_('testoutput_blurb'),
					'deflinebreak'	=> $APP->I18N->_('default is line break'),
					'deftab'		=> $APP->I18N->_('default is TAB'),
					'warnings_blurb'=> $APP->I18N->_('warnings_blurb'),
					'ShowWarnings'	=> $APP->I18N->_('Show Warnings'),
					'omitinvalid_blurb'=> $APP->I18N->_('omitinvalid_blurb'),
					'OmitInvalid'	=> $APP->I18N->_('Omit Invalid'),
					'assigninvalid_blurb'=> $APP->I18N->_('assigninvalid_blurb'),
					'AssignInvalid'	=> $APP->I18N->_('Assign Invalid'),
					'overwriteexisting_blurb'=> $APP->I18N->_('overwriteexisting_blurb'),
					'OverwriteExisting'	=> $APP->I18N->_('Overwrite Existing'),
					'retainold_blurb'=> $APP->I18N->_('retainold_blurb'),
					'RetainOldUserEmail'	=> $APP->I18N->_('Retain Old User Email'),
					'sendnotification_blurb'=> $APP->I18N->_('sendnotification_blurb'),
					'SendNotificationemail'	=> $APP->I18N->_('Send&nbsp;Notification&nbsp;email'),
					'Makeconfirmedimmediately'	=> $APP->I18N->_('Make confirmed immediately'),
					'selectlist'	=> $APP->I18N->_('Select the lists to add the emails to'),
					'testimport'	=> $APP->I18N->_('Test Output'),
					'reading'		=> $APP->I18N->_('Reading emails from file ... '),
					'lines_read'	=>	sprintf($APP->I18N->_('ok, %d lines'),sizeof(@$email_list)),
					'lines_will'	=> sprintf($APP->I18N->_('%d lines will be imported'),@$total_lines),
					'esito'			=> @$esito
		);
	}
	private function _get_checked(){
		return array(
						'import_test' => (sizeof(@$_POST)==0 || @$_POST['import_test'] == 'yes') ?' checked="checked"':'',
						'show_warnings' => @$_POST['show_warnings'] == 'yes' ?' checked="checked"':'',
						'omit_invalid' => @$_POST['omit_invalid'] == 'yes' ?' checked="checked"':'',
						'assign_invalid' => @$_POST['assign_invalid'] == 'yes' ?' checked="checked"':'',
						'overwrite' => @$_POST['overwrite'] == 'yes' ?' checked="checked"':'',
						'retainold' => @$_POST['retainold'] == 'yes' ?' checked="checked"':'',
						'notify_yes' => (!isset($_POST['notify']) || @$_POST['notify'] == 'yes') ?' checked="checked"':'',
						'notify_no' => @$_POST['notify'] == 'no' ?' checked="checked"':'',
		);
	}
}
