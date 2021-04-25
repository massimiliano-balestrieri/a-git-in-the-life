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
 * $Id: default.php.dist 190 2007-11-09 09:17:08Z maxbnet $
 * $LastChangedDate: 2007-11-09 09:17:08 +0000 (Fri, 09 Nov 2007) $
 * $LastChangedRevision: 190 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/config/default.php.dist $
 * 
 * $Author: maxbnet $
 * $Date: 2007-11-09 09:17:08 +0000 (Fri, 09 Nov 2007) $
 */

$ambiente = 0;
switch ($ambiente){
	case 0: #local php5
	define('TITLE_ISTANZA' , 'default');
	define('TESTATA_ISTANZA','http://localhost/include/html/headerPortal.html');
	define('HEAD_ISTANZA',	'http://localhost/include/html/newsletter/default/head.html');
	define('FOOT_ISTANZA','http://localhost/include/html/footerPortal.html');  
	define('VIEW_APP_UTENTE',1);
	
	define('BOUNCE_MAILBOX_HOST','');
	define('BOUNCE_MAILBOX_USER','');
	define('BOUNCE_MAILBOX_PWD','');	
	define('BOUNCE_MAILBOX','/var/spool/mail/listbounces');
	define('BOUNCE_PROTOCOL','pop');
	define('BOUNCE_MAILBOX_PORT','110/pop3/notls');
		
	break;
	case 1: #PRODUCTION
	define('TITLE_ISTANZA' , 'default');
	define('TESTATA_ISTANZA','');
	define('HEAD_ISTANZA',	 '');
	define('FOOT_ISTANZA',	 '');
	define('VIEW_APP_UTENTE',1);
	
	define('BOUNCE_MAILBOX_HOST',	'');
	define('BOUNCE_MAILBOX_USER',	'');
	define('BOUNCE_MAILBOX_PWD', 	'');	
	define('BOUNCE_MAILBOX',	'');
	define('BOUNCE_PROTOCOL',	'pop');
	define('BOUNCE_MAILBOX_PORT',	'110/pop3/notls');
	break;
}


define('ATTACHMENTS_REPOSITORY' , REPOSITORY_ROOT . '/attachments/' . TITLE_ISTANZA);
define('TMP_REPOSITORY' ,  REPOSITORY_ROOT . '/tmp/' .  TITLE_ISTANZA);

define('TABLE_PREFIX', 'default_');     
define('TABLE_PREFIX_USR' ,'default_user_'); 
?>