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
 * $Id:home_view.php 148 2007-11-03 20:06:49Z maxbnet $
 * $LastChangedDate:2007-11-03 21:06:49 +0100 (sab, 03 nov 2007) $
 * $LastChangedRevision:148 $
 * $LastChangedBy:maxbnet $
 * $HeadURL:https://maxlist.svn.sourceforge.net/svnroot/maxlist/trunk/maxlist/modules/home/home_view.php $
 * 
 * $Author:maxbnet $
 * $Date:2007-11-03 21:06:49 +0100 (sab, 03 nov 2007) $
 */

class HomeView {

	public function __construct() {

		global $APP;

		//check
		$APP->TPL->assign('tpl_eventlog', true);
		//$label = 'profilo';
		$label = $APP->I18N->_('admin');
		$APP->TPL->assign('tpl_admin', true);
		$APP->TPL->assign('tpl_configure', true);
		$APP->TPL->assign('tpl_users', true);
		$APP->TPL->assign('tpl_attributes', true);
		$APP->TPL->assign('tpl_adminattributes', true);
		$APP->TPL->assign('tpl_admins', true);
		$APP->TPL->assign('tpl_import', true);
		$APP->TPL->assign('tpl_export', true);
		$APP->TPL->assign('tpl_templates', true);
		$APP->TPL->assign('tpl_send', true);
		$APP->TPL->assign('tpl_messages', true);
		$APP->TPL->assign('tpl_processqueue', true);
		$APP->TPL->assign('tpl_bounces', true);
		$APP->TPL->assign('tpl_processbounces', true);
		$APP->TPL->assign('tpl_statistics', true);
		//check 2
		$APP->TPL->assign('tpl_system_functions', true);
		$APP->TPL->assign('tpl_config_functions', true);
		$APP->TPL->assign('tpl_listsusers_functions', true);
		$APP->TPL->assign('tpl_admins_functions', true);
		$APP->TPL->assign('tpl_msg_functions', true);

	}

}