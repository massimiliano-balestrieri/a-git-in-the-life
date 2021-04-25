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
 * $Id: dev.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/helpers/dev.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class MaxDevHelper {

	//gli helper non possono avere un costruttore	
	public function check_dev_settings() {
		global $APP;

		if (ini_get("safe_mode")) {
			$APP->MSG->warn($APP->I18N->_('Running in testmode, no emails will be sent. Check your config file.'));
		}
		if (ereg("dev", VERSION)) { // && !TEST) {
			if (DEV_EMAIL) {
				$APP->MSG->warn("Running CVS version. All emails will be sent to " . DEV_EMAIL);
			} else {
				$APP->MSG->warn("Running CVS version, but developer email is not set");
			}
		}
		if (ini_get("safe_mode") && WARN_ABOUT_PHP_SETTINGS)
			$APP->MSG->warn($APP->I18N->_('safemodewarning'));
		
		if (!ini_get("allow_url_fopen") && WARN_ABOUT_PHP_SETTINGS)
			$APP->MSG->warn($APP->I18N->_('cannot check, "allow_url_fopen" disabled in PHP settings'));

		if (!ini_get("magic_quotes_gpc") && WARN_ABOUT_PHP_SETTINGS)
			$APP->MSG->warn($APP->I18N->_('magicquoteswarning'));

		if (ini_get("magic_quotes_runtime") && WARN_ABOUT_PHP_SETTINGS)
			$APP->MSG->warn($APP->I18N->_('magicruntimewarning'));

		if (ALLOW_ATTACHMENTS && WARN_ABOUT_PHP_SETTINGS && (!is_dir(ATTACHMENTS_REPOSITORY) || !is_writable(ATTACHMENTS_REPOSITORY))) {
			if (ini_get("open_basedir")) {
				$APP->MSG->warn($APP->I18N->_('warnopenbasedir'));
			}
			$APP->MSG->warn($APP->I18N->_('warnattachmentrepository'));
		}

		if (TEST) {
			$APP->MSG->warn($APP->I18N->_('Running in testmode, no emails will be sent. Check your config file.'));
		}
		if (TEST_PROCESS) {
			$APP->MSG->warn($APP->I18N->_('Running in test process mode, no emails will be sent. Check your config file.'));
		}
		if ($APP->ROLE->is_super_user()) {
			if (ROLE_SWITCH && $role = $APP->REQUEST->post('switch_role')) {
				$APP->SESSION->set_role($role);
				$APP->REQUEST->redirect();
			}
			if (ROLE_SWITCH && $ajax = $APP->REQUEST->post('switch_ajax')) {
				$APP->SESSION->set_ajax($ajax);
				$APP->REQUEST->redirect();
			}
			if (ROLE_SWITCH && $id = $APP->REQUEST->post('switch_user')) {
				$admin = $APP->load_model("admin");
				$role = $admin->get_role($id); //TODO: remove role
				$username = $admin->get_username($id);

				$APP->SESSION->set_role($id, $role, $username);
				$APP->REQUEST->redirect();
			}
			if (ROLE_SWITCH && $debug = $APP->REQUEST->post('switch_debug')) {
				$APP->SESSION->set_debug($debug);
				$APP->REQUEST->redirect();
			}
			
			
		}
		
		
	}
	public function get_debug_switcher() {
		//TODO ? 
		return;
		if (DEBUG_SWITCH) {
			global $APP;
			$APP->MSG->warn("Disabilitare la scelta debug in produzione");
			$ds = '';$debugcount = 0;
			$curr_set = $APP->SESSION->get_auth_id();
			$opts = array (
				0 => 'Off',
				1 => 'On'
			);
			foreach ($opts as $opt => $rec) {
				$ds .= sprintf('<option value="%s" %s>%s</option>', $opt,$curr_set == $opt ? ' selected="selected"' : '', $rec);
				$debugcount++;
			}
			return $ds;

		}
	}

	public function get_user_switcher() {
		//TODO ? 
		return;
		if (USER_SWITCH) {
			//todo: 
			return;
			global $APP;
			$APP->MSG->warn("Disabilitare il cambio utente in produzione");
			
			$curr_user = $APP->SESSION->get_auth_id();
			$usercount = 0;$us = '';
			
			$admin = $APP->get_model("admin");
			$data = $admin->get_admins();
			for($x=0;$x<sizeof($data);$x++){
				$us .= sprintf('<option value="%d" %s>%s</option>', $data[$x]["id"], $curr_user == $data[$x]["id"] ? ' selected="selected"' : '', $data[$x]["loginname"]);
				$usercount++;
			}
			return $us;
		}
	}

	public function get_ajax_switcher() {
		//TODO ? 
		return;
		if (AJAX_SWITCH) {
			global $APP;
			$APP->MSG->warn("Disabilitare la scelta ajax in produzione");
			$as = '';$ajaxcount = 0;
			$curr_set = $APP->SESSION->get_ajax_setting();
			$opts = array (
				0 => 'Off',
				1 => 'On'
			);
			foreach ($opts as $opt => $rec) {
				$as .= sprintf('<option value="%s" %s>%s</option>', $opt, $curr_set == $opt ? ' selected="selected"' : '', $rec);
				$ajaxcount++;
			}
			return $as;
		}
	}

	public function get_role_switcher() {
		//TODO ? 
		return;
		if (ROLE_SWITCH) {
			global $APP;
			$APP->MSG->warn("Disabilitare il cambio di ruolo in produzione");
			$curr_role = $APP->SESSION->get_role();
			
			$rolecount = 0; $rs = '';//TODO fix roles
			foreach ($GLOBALS['ROLES'] as $role => $rec) {
				$rs .= sprintf('<option value="%s" %s>%s</option>', $role, $curr_role == $role ? ' selected="selected"' : '', $rec);
				$rolecount++;
			}
			return $rs;
		}
	}

	public function get_lang_switcher() {
		if(LANG_SWITCH){
			global $APP;
			$curr_lang = $APP->SESSION->get_iso_language();
			$lancount = 0;$ls = '';
			foreach ($APP->I18N->languages as $iso => $rec) {
				$ls .= sprintf('<option value="%s" %s>%s</option>', $iso, $curr_lang == $iso ? ' selected="selected"' : '', $rec[0]);
				$lancount++;
			}
			return $ls;
		}
	}
}