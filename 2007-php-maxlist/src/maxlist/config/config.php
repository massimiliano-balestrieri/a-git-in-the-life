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
 * $Id: config.php.dist 381 2008-01-08 17:53:32Z maxbnet $
 * $LastChangedDate: 2008-01-08 17:53:32 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 381 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/config/config.php.dist $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 17:53:32 +0000 (Tue, 08 Jan 2008) $
*/

$ambiente = 0;
switch ($ambiente){
	case 0: #local php5
	define('TEST', 1);
	define('TEST_PROCESS', 1);
	
	define("SERVER_ROOT" ,  "/web/html/");
	
	define("APP_ROOT" ,  "/web/html/maxlist/");
	define("PUBLIC_ROOT" , "/web/html/public/");
	define("REPOSITORY_ROOT" , "/web/html/public/repository/");
	
	define("URL" ,  	 "http://localhost/"); //with slash IMPORTANT
	define("URL_RIS" ,   "http://localhost/public/include/");
	define("URL_AUTH" ,	 "http://localhost/maxauth/index.php");

	define("DB_HOST" ,  "db");
	define("DB_NAME" ,  "maxlist01");
	define("DB_USER" ,  "root");
	define("DB_PWD" ,  "maxlist");

	define("LAN_TEXTS" ,  "italian.inc");
	define("MAILER_HOST","");
	define("MESSAGE_ENVELOPE" , "");
	
	define('ZEND_PATH' , '/temp/zend/ZendFramework-1.0.3/library/');
	break;
}
?>