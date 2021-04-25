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
 * Maxlist is a fork of PhpList, a newsletter manager. 
 * The code was deeply changed so there are features of the original phpList and new ones. 
 * It uses smarty, generates XHTML strict, uses an AJAX layer, italian language ,
 * multi-istance, and use case based.
 *
 * 
 * $Id: conf.php 388 2008-01-15 06:53:36Z maxbnet $
 * $LastChangedDate: 2008-01-15 06:53:36 +0000 (Tue, 15 Jan 2008) $
 * $LastChangedRevision: 388 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/inc/conf.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-15 06:53:36 +0000 (Tue, 15 Jan 2008) $
 */

//USE MODEL/DAO config

class MaxlistConf {

	public $defaults = false; //ex $default_config
	public $xormask = false;
	public $domain = false;
	public $website = false;

	public function __construct() {

		global $APP;
		$APP->CONF = $this;
		$this->defaults = $GLOBALS['default_config']; //TODO: remove globals

		$this->domain = $this->get('domain');
		$this->website = $this->get('website');
		$this->xormask = $this->get('xormask');

	}

	public function get($item) {

		//global $domain, $website,$tables,$default_config;
		global $APP;

		//$req = $APP->GETDB2->sql_query("select value from {$APP->DB->get_table("config")} where item = \"$item\"");
		$req = $APP->get_model2("configure")->get($item);
		//print_r($req);die;
		//if (!$APP->DB->sql_affected_rows()) {
		if (!$req) {
			if (isset ($this->defaults[$item])) {
				$value = $this->defaults[$item][0];
				$role = isset ($this->defaults[$item][3]) ? $this->defaults[$item][3] : 1;
			} else {
				$value = false;
			}
		} else {
			//$row = $APP->DB->sql_fetch_row($req);
			$value = $req[0];
		}

		$value = preg_replace('/\[DOMAIN\]/i', $this->domain, $value);
		$value = preg_replace('/\[WEBSITE\]/i', $this->website, $value);
		$value = preg_replace('/<\?=VERSION\?>/i', VERSION, $value);
		if ($value != 0 && !$value)
			die("<!-- miss config : $item -->"); //TODO : bug default_message_template = 0 not false?
		return $value;
	}

	public function get_field_configuration($id) {
		$field = false;
		//if($id){
		global $default_config, $website;
		$val = $default_config[$id];
		$dbval = $this->get($id);

		if (isset ($dbval))
			$value = $dbval;
		else
			$value = $val[0];

		if ($id != "website" && $id != "domain") {
			$value = preg_replace('/' . $this->domain . '/i', '[DOMAIN]', $value);
			$value = preg_replace('/' . $this->website . '/i', '[WEBSITE]', $value);
		}
		if ($val[2] == "textarea") {
			$field = '<textarea name="values[' . $id . ']" rows=25 cols=55>' . htmlspecialchars(stripslashes($value)) . '</textarea>';
		}
		elseif ($val[2] == "text") {
			$field = '<input type="text" name="values[' . $id . ']" size="70" value="' . htmlspecialchars(stripslashes($value)) . '" />';
		}
		elseif ($val[2] == "boolean") {
			$field = '<input type="text" name="values[' . $id . ']" size="10" value="' . htmlspecialchars(stripslashes($value)) . '" />';
		}
		return $field;
		//}
	}
	//depends user model
	//help $this->send_emails
	public function get_user_config($item, $id) {
		global $APP;
		$istance = $APP->ROUTING->istance;
		$url_base = URL_BASE . $istance . '/';
		$value = $APP->CONF->get($item);
		if (is_numeric($id)) {
			$user_req = $APP->get_model2("user")->get_uniqid_by_id($id);
			//$user_req = $this->db->sql_fetch_row_query("select uniqid from {$this->table} where id = $id");
			$uniqid = $user_req;
			$id = $uniqid;
		} else {
			$id = $this->_id();
		}
		# parse for placeholders
		# do some backwards compatibility:
		# hmm, reverted back to old system
		$subscribeurl = $url_base . $APP->CONF->get("subscribeurl");
		$unsubscribeurl = $url_base . $APP->CONF->get("unsubscribeurl") . $id;
		$confirmationurl = $url_base . $APP->CONF->get("confirmationurl") . $id;
		$preferencesurl = $url_base . $APP->CONF->get("preferencesurl") . $id;

		$value = eregi_replace('\[UNSUBSCRIBEURL\]', $unsubscribeurl, $value);
		$value = eregi_replace('\[CONFIRMATIONURL\]', $confirmationurl, $value);
		$value = eregi_replace('\[PREFERENCESURL\]', $preferencesurl, $value);

		$value = eregi_replace('\[SUBSCRIBEURL\]', $subscribeurl, $value);
		if ($value == "0") {
			$value = "false";
		}
		elseif ($value == "1") {
			$value = "true";
		}
		return $value;
	}
}