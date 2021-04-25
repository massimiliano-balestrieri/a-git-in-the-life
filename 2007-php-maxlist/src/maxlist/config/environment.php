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
 * $Id: environment.php 395 2008-01-18 18:55:07Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:55:07 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 395 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/config/environment.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:55:07 +0000 (Fri, 18 Jan 2008) $
 */

//VERSION 0.5
define('NAME', 'maxlist');
define('VERSION', '0.5');

//rewrite engine ? sviluppare in ambedue i modi? NO
define('REWRITE', 1);

//in test non invia mail
define('WARN_ABOUT_PHP_SETTINGS', 1);//lasciare - devHelper

//se c'è dev nella versione invia solo qui
define('WEBMASTER_EMAIL', 'massimiliano.balestrieri@gmail.com');


//disabilitare in produzione - eccetto la lingua
define('USER_SWITCH', 1);
define('ROLE_SWITCH', 1);
define('AJAX_SWITCH', 1);
define('DEBUG_SWITCH', 1);

define('LANG_SWITCH', 1);


//set ajax config
define('AJAX', 0);
//set default lang
define('LANG', 'it');


//DIRS
define('DIR_SMARTY', SERVER_ROOT . '/libraries/smarty');
define('DIR_ADODBLITE', SERVER_ROOT . '/libraries/adodb_lite-1.42/');
define('DIR_PEAR_NET', SERVER_ROOT . '/libraries/net');
define('DIR_POP3', SERVER_ROOT . '/libraries/pop3');

define('DIR_I18N', SERVER_ROOT . '/i18n');
define('DIR_ZEND', ZEND_PATH . '/');

define('DIR_INC', APP_ROOT . '/app/inc');
define('DIR_CONF', APP_ROOT . '/config');
define('DIR_SMARTY_CACHE', REPOSITORY_ROOT . '/smarty/cache');
define('DIR_SMARTY_TPL', REPOSITORY_ROOT . '/smarty/templates_c');
define('DIR_TPL', APP_ROOT . '/app/templates');
define('DIR_TPL_MOD', APP_ROOT . '/modules');


define('DIR_MODULES', APP_ROOT . '/modules/');
define('DIR_LAN', APP_ROOT . '/i18n/lan');
define('DIR_LAN_INFO', APP_ROOT . '/i18n/info');

define('DIR_JSCALENDAR', SERVER_ROOT . '/libraries/jscalendar-1.0');

//URLS
define('URL_BASE' ,  URL . 'maxlist/'); //with slash IMPORTANT
define('URL_INCLUDE' ,  URL. '/public/include');
define('URL_JSCALENDAR', URL . 'libraries/jscalendar-1.0');	
	
define('URL_BO_SCRIPT', URL_BASE . '/admin.php');

define('URL_IMG_ERROR', URL_INCLUDE . '/css/img/error.gif');
define('URL_IMG_NO', URL_INCLUDE . '/css/img/no.gif');
define('URL_IMG_YES', URL_INCLUDE . '/css/img/yes.gif');

define('URL_LOGO', '');
define('LOGO_IMG', 'powermaxlist.png');

define('URL_TINYMCE', URL . 'libraries/tinymce/jscripts/tiny_mce');
define('URL_TINYONLOAD', URL_BASE . '/js/tinymce_onload.js');

//CSS
define('CSS_INPUT_ERROR', ' ml_input_error');//whitespace IMPORTANT

//PAGING
define('LIMIT_PAGE', 10);

//ADMINS MODEL
define('ENCRYPTPASSWORD', 1);

//MAIL
define('BLACKLIST_GRACETIME',1);//min 1

//SMTP - set false if not use
define('SMTP_USERNAME', false);
define('SMTP_PWD',      false);

//MAILER - advanced options
define('ENVELOPE', '-f ' . MESSAGE_ENVELOPE);//se MESSAGE_ENVELOPE
define('HTMLEMAIL_ENCODING', 'quoted-printable');
define('TEXTEMAIL_ENCODING', '7bit');

//SETTINGS
define('ALLOW_ATTACHMENTS', 1);
define('NUM_ATTACHMENTS', 1);
define('USE_TINYMCE', 1);

//LOG LEVEL
define('LOG_LEVEL',1);//disabled 0
define('LOG_MAIL_LEVEL',2);//disabled 0, log + mail 2
define('LOG_SEND',0);

//SUBSCRIBE - USER
define('USERHISTORY_INFO', 'HTTP_USER_AGENT,HTTP_REFERER,REMOTE_ADDR');
define('STATS_INTERVAL', 'monthly');
define('ALLOW_NO_SUBSCRIBE',0);

//SENDMAIL
define('PHPMAILER', 1);//1 is only value valid
define('VERBOSE', 1);//log sendingmessage... write in logtable many records
define('ENABLE_RSS', 0);//see ROADMAP. not implemented
define('CLICKTRACK', 0);//see ROADMAP. not implemented

//PROCESSQUEUE
define('MAILQUEUE_BATCH_SIZE', 10000);//
define('MAILQUEUE_BATCH_PERIOD', 10000);//? es: 1 mail (BATCH_SIZE) x 10 sec (BATCH_PERIOD). ad ogni poll... lui aspetta 10sec

define('DOMAIN_BATCH_SIZE', 5);//ogni 20 mail
define('DOMAIN_BATCH_PERIOD', 25);//5 sectra due mail ad un dominio e l'altro

define('MAILQUEUE_AUTOTHROTTLE', 1);//delay
define('USE_DOMAIN_THROTTLE', 0);

define('MAILQUEUE_THROTTLE', 0);//secondi di pausa tra una mail e l'altra.
define('DOMAIN_AUTO_THROTTLE', 1); //?
//carico per usare il throttle. 
//minore sono questi params maggiore sarà il numero di mail inviate.
//100 mail sullo stesso dominio. significa che introduco una pausa di 5 sec tra una mail e l'altra
define('DOMAIN_AUTO_THROTTLE_ATTEMPTED',2);
define('DOMAIN_AUTO_THROTTLE_MSGS',5);
define('DOMAIN_AUTO_THROTTLE_USERS',1000);
		
define('TEST_SLEEP_PER_MAIL',5);//10 secondi x mail

//commandline 0
define('MANUALLY_PROCESS_QUEUE', 1);
define('MANUALLY_PROCESS_BOUNCES', 1);

//new
define('PROCESS_SLEEP_TIME',20);//20
define('PROCESS_SLEEP_TIME_MAX', 10);//10

define('P_LEV_INTER',4);
define('P_LEV_HIGH',3);
define('P_LEV_MEDIUM',2);
define('P_LEV_LOW',1); 

define('CHECK_FOR_HOST', 0);//TODO: bug

define('IMAP_EXT', 0);//or zend?
define('BOUNCE_MAILBOX_PURGE', 1);
define('BOUNCE_MAILBOX_UNPROCESSED', 1);

//////VERSION 0.3 CHECK
//urls
// del : define('URL_FO', URL_BASE . '/index.php');
// del : define('URL_UT', URL_BASE . '/ut.php');
// del : define('URL_DL', URL_BASE . '/dl.php');

//dev

define('TEST_AUTOLOGIN', 0);

define('DISABLE_LOGIN', 0);
define('REQUIRE_LOGIN', 1);

define('­AUTH_MODULE', 'MySqlAuth');
define('CHECK_SESSIONIP', 1);



define('USE_REPETITION', 0);
define('NUMCRITERIAS', 0);
define('STACKED_ATTRIBUTE_SELECTION', 0);
define('USE_LIST_EXCLUDE', 0);


define('USE_PDF', 0);
define('EXPORT_EXCEL', 0);


define('ALLOW_IMPORT', 1);






define('USE_ADVANCED_BOUNCEHANDLING', 0);

define('MEMBERS_ADDUSER', 1);





//advanced







define('DIRLAN', SERVER_ROOT . '/i18n/lan');
define('DIRINFO', SERVER_ROOT . '/i18n/info');
define('DIRMODELS', SERVER_ROOT . '/components/models');
define('DIRACTIONS', SERVER_ROOT . '/components/actions');
define('DIRTEMP', SERVER_ROOT . '/components/temp');
define('DIRCLI', SERVER_ROOT . '/components/cli');
define('DIRFUNCTIONS', SERVER_ROOT . '/components/functions');
define('DIROBJECTS', SERVER_ROOT . '/components/objects');





$view_title = NAME;

//dev
$GLOBALS['webmaster_email'] = 'massimiliano.balestrieri@gmail.com';
$GLOBALS['developer_email'] = 'massimiliano.balestrieri@gmail.com';
$GLOBALS['stats_email'] = 'massimiliano.balestrieri@gmail.com';
//stats e timer
$now = gettimeofday();
$GLOBALS['pagestats'] = array ();
$GLOBALS['pagestats']['time_start'] = $now['sec'] * 1000000 + $now['usec'];
$GLOBALS['pagestats']['number_of_queries'] = 0;



//attributes
$GLOBALS['checkboxgroup_storesize'] = 1;
//commandline disabled temp
$GLOBALS['commandline'] = 0;
//has_pear_http_request
$GLOBALS['has_pear_http_request'] = class_exists('HTTP_Request');

//immagini
$GLOBALS['img_tick'] = '<img src="' . URLCSSIMG . '/tick.gif" alt="Yes" />';
$GLOBALS['img_cross'] = '<img src="' . URLCSSIMG . '/cross.gif" alt="No" />';

//export
$export_mimetype = 'application/csv';
?>