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
 * $Id: template.php 383 2008-01-08 18:56:42Z maxbnet $
 * $LastChangedDate: 2008-01-08 18:56:42 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 383 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/inc/template.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 18:56:42 +0000 (Tue, 08 Jan 2008) $
 */
 
class MaxlistTemplate{
	
	public function __construct(){
		
		global $APP;
		$APP->DEV->check_dev_settings();//qui?
		
		//smarty
		require_once (DIR_SMARTY .  '/Smarty.class.php');
		$APP->TPL = new Smarty();
		$APP->TPL->caching = 0;
		$APP->TPL->cache_dir  	= 	DIR_SMARTY_CACHE;
		$APP->TPL->compile_dir 	= 	DIR_SMARTY_TPL;
		
		$APP->TPL->assign('PATH', APP_ROOT);
		$APP->TPL->assign('PATH_TPL', DIR_TPL);
		$APP->TPL->assign('PATH_TPL_MOD', DIR_TPL_MOD);
		
		//risorse esterne
		$APP->TPL->assign('HEAD_ISTANZA',HEAD_ISTANZA);
		$APP->TPL->assign('FOOT_ISTANZA',FOOT_ISTANZA);
		$APP->TPL->assign('TESTATA_ISTANZA',TESTATA_ISTANZA);
		
		//versione e app
		$APP->TPL->assign('VERSION',VERSION);
		$APP->TPL->assign('NAME',NAME);
		
		
		
		//menu
		$APP->TPL->assign('MENU', $APP->MENU->get_html_items());
		
		
		
		$APP->TPL->assign('AUTH', $APP->SESSION->get_session_auth());
		
		$APP->TPL->assign('DEBUG',DEBUG);
		
		$APP->TPL->assign('ERROR_MESSAGE', sprintf($APP->I18N->_('errorform %s'), URL_IMG_ERROR));
		
		//$APP->TPL->assign('TARGET',false);//TODO: target
		
		
		
		
		//DEV
		if (LANG_SWITCH) {
		    $APP->TPL->assign('LANG_SWITCH',$APP->DEV->get_lang_switcher());
		}
		if($APP->ROLE->is_super_user()){
			if (ROLE_SWITCH) {
			    $APP->TPL->assign('ROLE_SWITCH',$APP->DEV->get_role_switcher());//TODO: ancora con questi ruoli?
			}
			if (USER_SWITCH) {
			    $APP->TPL->assign('USER_SWITCH',$APP->DEV->get_user_switcher());
			}
			if (AJAX_SWITCH) {
			    $APP->TPL->assign('AJAX_SWITCH',$APP->DEV->get_ajax_switcher());
			}
			if (DEBUG_SWITCH) {
			    $APP->TPL->assign('DEBUG_SWITCH',$APP->DEV->get_debug_switcher());
			}
		}
		
		
		/*
		if (isset($_SESSION[VERSION]["logindetails"]["id"])) {
			$template->assign('username',adminName($_SESSION[VERSION]["logindetails"]["id"]));
		}else{
			$template->assign('username',$GLOBALS['I18N']->get('guest'));
		}
		
		if ($view != "logout") {
		    $template->assign('logout',pageLink("logout",$GLOBALS['I18N']->get('logout')));
		}
		
		$view_title = TITLE_ISTANZA . $view_title;
		$template->assign('page_title',$view_title);
		
		
		//info
		$template->assign('tpl_info',@$info);
		
		$app_template = DIRTPLAPP . "/" . $view . ".tpl";
		
		
		
		
		$template->assign('page_title', $page_title);
		$template->assign('AJAX',isAjax());
		
		*/
		
	}
}