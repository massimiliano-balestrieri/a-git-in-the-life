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
 * $Id: output.php 394 2008-01-18 18:12:54Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:12:54 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 394 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/inc/output.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:12:54 +0000 (Fri, 18 Jan 2008) $
 */

class MaxlistOutput {

	public function __construct() {
		//if (isset ($_SESSION[VERSION]['logindetails']['role']))
		//	cleanPublicInfo(@ $_SESSION[VERSION]['logindetails']['role']);
		//if (isset ($_SESSION[VERSION]['logindetails']['role']))
		//	cleanPublicSessionInfo(@ $_SESSION[VERSION]['logindetails']['role']);
		//mergePublicInfo();
		//$template->assign('PUBLIC_INFO', $GLOBALS['PUBLIC_INFO']);
		
		global $APP;
		
		//MVC
		$APP->TPL->assign('CONTROLLER', $controller = $APP->ROUTING->controller);
		$APP->TPL->assign('ACTION', $action = $APP->ROUTING->action);
		$APP->TPL->assign('ID',$APP->ROUTING->id);
		$APP->TPL->assign('DO',$APP->ROUTING->action_to_do());
		
		$APP->TPL->assign('QS',$APP->ROUTING->qs);
		$APP->TPL->assign('BO', URL_BASE . $APP->SESSION->get_istance() .'/');
		
		//REQ
		$APP->TPL->assign('GET',$_GET);
		$APP->TPL->assign('POST',$_POST);
		$APP->TPL->assign('POST_PARSED',print_r($APP->REQUEST->post,true));
		$APP->TPL->assign('REQUEST',$_REQUEST);
		//$APP->TPL->assign('QS',$_SERVER['QUERY_STRING']);
		
		
		//INFO
		$APP->TPL->assign('NQUERY', MaxDbHelper::$n);
		$APP->TPL->assign('INFO',$APP->MSG->get_info());
		$APP->TPL->assign('WARN', $APP->MSG->get_warnings());
		$APP->TPL->assign('ERROR', $APP->MSG->get_errors());
		$APP->TPL->assign('QUERY', $APP->MSG->get_query());
		$APP->TPL->assign('QUERY_SLOW', $APP->MSG->get_query_slow());
		$APP->TPL->assign('QUERY_ERROR', $APP->MSG->get_query_error());
		//$APP->TPL->assign('MSGS', $APP->MSG->get_user_msg());
		//$APP->TPL->assign('FORM_MSG', $APP->MSG->get_form_msg());
		
		//I18N
		$APP->TPL->assign('I18N', $APP->I18N->labels);
		if(strlen($APP->I18N->info))
			$APP->TPL->assign('HELP', $APP->I18N->info);
		
		//templates
		$head_template = DIR_TPL . '/inc/header.tpl';
		$foot_template = DIR_TPL . '/inc/footer.tpl';
		$menu_template = DIR_TPL . '/inc/menu.tpl';
		//print_r($APP->MODULE);die;
		$view_template = DIR_TPL_MOD . '/' . $controller . '/tpl/' . $APP->MODULE->tpl .'.tpl';
		
		//if ($output) {
			//if (!$ajax)
				$APP->TPL->display($head_template);
			if (is_file($view_template)) {
				$APP->TPL->display($view_template);
			}
			//if (!$ajax)
				$APP->TPL->display($menu_template);
			//if (!$ajax)
				$APP->TPL->display($foot_template);
		//}
		
	}
}