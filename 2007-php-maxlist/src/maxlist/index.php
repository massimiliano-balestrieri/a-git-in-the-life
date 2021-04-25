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
 * $Id: index.php 341 2007-12-03 23:10:20Z maxbnet $
 * $LastChangedDate: 2007-12-03 23:10:20 +0000 (Mon, 03 Dec 2007) $
 * $LastChangedRevision: 341 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/index.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-03 23:10:20 +0000 (Mon, 03 Dec 2007) $
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//MAIN
#ob_start();
date_default_timezone_set('Europe/Rome');
define('DEBUG',1);

//CONFIG
require_once (dirname(__FILE__) . "/config/defaultconfig.php");
require_once (dirname(__FILE__) . "/config/config.php");
require_once (dirname(__FILE__) . "/config/environment.php");
require_once (dirname(__FILE__) . "/config/usecases.php");
require_once (dirname(__FILE__) . "/config/test.php");

//APP
require_once (dirname(__FILE__) . "/app/maxlist.php");
$APP = new MaxList();

//ROUTING
$APP->init_routing();
//CONTROLLER
$APP->init_controller();

//$APP->debug_session();


//TEXTS
//require_once (dirname(__FILE__) . "/i18n/texts/english.inc");
//require_once (dirname(__FILE__) . "/i18n/texts/".LAN_TEXTS);

//FUNCTIONS & OBJECTS
//require_once (dirname(__FILE__) . "/components/functions/main_functions.php");
//require_once (dirname(__FILE__) . "/libraries/phpmailer/class.phpmailer.php");
//require_once (dirname(__FILE__) . "/libraries/phplist/class.phplistmailer.php");
//require_once (dirname(__FILE__) . "/components/objects/paging.php");
//require_once (dirname(__FILE__) . "/components/objects/user_form.php");
//require_once (dirname(__FILE__) . "/components/objects/attributes_form.php");
//REQUEST
//require_once (dirname(__FILE__) . "/components/request/main_request.php");

//ISTANCES
$APP->init_istance();

//I18N - priorità di avvio alta. gli helper usano DB e MSG
$APP->init_i18n();

//CONFIG
$APP->init_conf();

//DATABASE
//require_once (dirname(__FILE__) . "/components/functions/db_functions.php");
//require_once (dirname(__FILE__) . "/app/controllers/db_controller.php");

//INIT ?
//require_once (dirname(__FILE__) . "/components/controllers/init_controller.php");

//AUTHENTICATION
//require_once (dirname(__FILE__) . "/components/functions/role_functions.php");
$APP->init_auth();




//TITLES
//require_once DIRLAN . "/" . $_SESSION[VERSION]['adminlanguage']['iso'] . "/pagetitles.php";
//CHECK
//require_once (dirname(__FILE__) . "/components/controllers/check_controller.php");
//DEV
//require_once (dirname(__FILE__) . "/components/controllers/dev_controller.php");

//MENU
//require_once (dirname(__FILE__) . "/components/functions/menu_functions.php");
//require_once (dirname(__FILE__) . "/components/controllers/menu_controller.php");
$APP->init_menu();

//TEMPLATE
$APP->init_template();

//MODULE
$APP->init_module();

//OUTPUT
$APP->init_output();

//STATS
$APP->init_stats();