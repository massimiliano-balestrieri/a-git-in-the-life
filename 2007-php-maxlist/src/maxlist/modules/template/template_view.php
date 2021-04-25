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
 * $Id: template_view.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/template/template_view.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */
class TemplateView extends ModuleView implements IModuleView{
	
	public function __construct($params, $data, $errors = false){
		$this->_init($params, $data, $errors);
		$this->_routing();
	}
	protected function _listall(){
		global $APP;
		$APP->TPL->assign('tpl_config',array('URL_IMG_NO'=>URL_IMG_NO, 'URL_IMG_YES' => URL_IMG_YES));
		//form
		$APP->TPL->assign('tpl_templates',$this->_data['templates']);
		$APP->TPL->assign('tpl_default',$this->_data['default']);
	}
	
	protected function _create(){
		$this->_assign();
	}
	protected function _edit(){
		$this->_assign();
	}
	private function _assign(){
		global $APP;
		$this->_push_post('template');
		$APP->TPL->assign('tpl_template',$this->_data['template']);
	}
	private function _get_lbl_messages(){
		/***
		return array(
								'template'=>$APP->I18N->_('Edit Template'),
								'title'=>$APP->I18N->_('Title of this template'),
								'content'=>$APP->I18N->_('Content of the template.'),
								'warn1'=>$APP->I18N->_('The content should at least have <b>[CONTENT]</b> somewhere.'),
								'warn2'=>$APP->I18N->_('You can upload a template file or paste the text in the box below'),
								'file'=>$APP->I18N->_('Template file.'),
								'base'=>$APP->I18N->_('Make sure all images<br/>start with this URL (optional)'),
								'links'=>$APP->I18N->_('Check that all links have a full URL'),
								'image'=>$APP->I18N->_('Check that all images have a full URL'),
								'exist'=>$APP->I18N->_('Check that all external images exist'),
		);
		 * 
		 */
	
	}
	private function _get_checked(){
		/***
		return array(
								'checkfulllinks'=>isset($_POST['checkfulllinks'])?' checked="checked"':'',
								'checkfullimages'=>isset($_POST['checkfullimages'])?' checked="checked"':'',
								'checkimagesexist'=>isset($_POST['checkimagesexist'])?' checked="checked"':'',
		);
		*/
	}
}
