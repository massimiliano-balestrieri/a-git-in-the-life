<?php
/***
$Id: config.php.dist 109 2007-11-03 10:37:50Z maxbnet $
$LastChangedDate: 2007-11-03 11:37:50 +0100 (sab, 03 nov 2007) $
$LastChangedRevision: 109 $
$LastChangedBy: maxbnet $
$HeadURL: https://maxlist.svn.sourceforge.net/svnroot/maxlist/branches/0.4/maxauth/config/config.php.dist $

$Author: maxbnet $
$Date: 2007-11-03 11:37:50 +0100 (sab, 03 nov 2007) $
*/

/* ambiente */
$ambiente = 1;
switch($ambiente){
	case 1:	## SVILUPPO
		define("VERSION", "0.5");
		define("SERVER_ROOT", "/web/html/maxlist/");
		define("DB_HOST","db");
		define("DB_NAME","maxlist");
		define("DB_USER","maxlist");
		define("DB_PWD","maxlist");
		define("SMARTY_DIR", SERVER_ROOT . "/libraries/smarty/");
		define("SMARTY_CACHE", "/web/html/public/repository/smarty/cache");
		define("SMARTY_TPL", "/web/html/public/repository/smarty/templates_c");
		define("TESTATA_ISTANZA",	"http://localhost/public/include/html/headerPortal.html");
		define("HEAD_ISTANZA",		"http://localhost/public/include/html/istances/default/head.html");
		define("FOOT_ISTANZA",		"http://localhost/public/include/html/footerPortal.html");
		define("MAXLIST_URL",		"http://localhost/maxlist/maxlist/");
	break;
}
