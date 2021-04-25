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
 * $Id: sendcache_helper.php 352 2007-12-20 19:11:32Z maxbnet $
 * $LastChangedDate: 2007-12-20 19:11:32 +0000 (Thu, 20 Dec 2007) $
 * $LastChangedRevision: 352 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/sendcache_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-20 19:11:32 +0000 (Thu, 20 Dec 2007) $
 */

class SendcacheHelper{
	
	public $cached = false;
	
	
	
	public function do_cache($messageid, $message, $template){
		
		global $APP;
		
		$domain = $APP->CONF->get("domain");
		$cached[$messageid] = array ();

		//fromfield
		if (ereg("([^ ]+@[^ ]+)", $message["fromfield"], $regs)) {
			# if there is an email in the from, rewrite it as "name <email>"
			$message["fromfield"] = ereg_replace($regs[0], "", $message["fromfield"]);
			$cached[$messageid]["fromemail"] = $regs[0];
			# if the email has < and > take them out here
			$cached[$messageid]["fromemail"] = ereg_replace("<", "", $cached[$messageid]["fromemail"]);
			$cached[$messageid]["fromemail"] = ereg_replace(">", "", $cached[$messageid]["fromemail"]);
			# make sure there are no quotes around the name
			$cached[$messageid]["fromname"] = ereg_replace('"', "", ltrim(rtrim($message["fromfield"])));
		}
		elseif (ereg(" ", $message["fromfield"], $regs)) {
			# if there is a space, we need to add the email
			$cached[$messageid]["fromname"] = $message["fromfield"];
			$cached[$messageid]["fromemail"] = "listmaster@$domain";
		} else {
			$cached[$messageid]["fromemail"] = $message["fromfield"] . "@$domain";
			$cached[$messageid]["fromname"] = $message["fromfield"] . "@$domain";
		}

		//fromname
		# erase double spacing
		while (ereg("  ", $cached[$messageid]["fromname"]))
			$cached[$messageid]["fromname"] = eregi_replace("  ", " ", $cached[$messageid]["fromname"]);

		//cache
		$cached[$messageid]["fromname"] = eregi_replace("@", "", $cached[$messageid]["fromname"]);
		$cached[$messageid]["fromname"] = trim($cached[$messageid]["fromname"]);
		$cached[$messageid]["to"] = $message["tofield"];
		$cached[$messageid]["subject"] = $message["subject"];
		$cached[$messageid]["replyto"] = $message["replyto"];
		$cached[$messageid]["content"] = $message["message"];
		$cached[$messageid]["textcontent"] = $message["textmessage"];
		$cached[$messageid]["footer"] = $message["footer"];
		$cached[$messageid]["htmlformatted"] = $message["htmlformatted"];
		$cached[$messageid]["sendformat"] = $message["sendformat"];

		//cache template
		if ($message["template"] && isset($template['content'])) { //TODO: test this
			$cached[$messageid]["template"] = stripslashes($template['content']);
			$cached[$messageid]["templateid"] = $message["template"];
			#   dbg("TEMPLATE: ".$req[0]);
		} else {
			$cached[$messageid]["template"] = '';
			$cached[$messageid]["templateid"] = 0;
		}

		//cache
		## @@ put this here, so it can become editable per email sent out at a later stage
		$cached[$messageid]["html_charset"] = $APP->CONF->get("html_charset");
		## @@ need to check on validity of charset
		if (!$cached[$messageid]["html_charset"])
			$cached[$messageid]["html_charset"] = 'iso-8859-1';
		$cached[$messageid]["text_charset"] = $APP->CONF->get("text_charset");
		if (!$cached[$messageid]["text_charset"])
			$cached[$messageid]["text_charset"] = 'iso-8859-1';
			
		$this->cached[$messageid] = $cached[$messageid];
		
	}
	
}