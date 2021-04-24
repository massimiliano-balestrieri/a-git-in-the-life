<?php

define("MAIN",$_SERVER['SCRIPT_NAME']);
define("DEBUG",1);//0 NO DEBUG
define("DEFAULT_DM","GNOME");
define("PREFIX_DB","deskweb033_");
define("DIR_DESKWEB","applications/deskweb-0.5");


define("DIR_GUI","/repository/images/gui");
define("DIR_MASK","/repository/images/mask");
define("DIR_THUMB","/repository/images/thumb");
define("DIR_APPS","/modules/apps2");
define("DIR_WEBLETS","/modules/weblets");

define("JS_URL","/extra/js/functions.js");
define("JS_WIN_URL","/extra/js/windows.js");
define("CSS_URL","/extra/css/deskweb.css");

define("NUM_DESKTOP",4);

define('VIEW_ICON',0);
define('VIEW_DETAILED',1);
define('VIEW_FULLSCREEN',0);

define('DEFAULT_SAVE_POSITION', 4);

define('ACTION_LOGOUT','?logout=1');
define('ACTION_DESKTOP1','?desktop=1');
define('ACTION_DESKTOP2','?desktop=2');
define('ACTION_DESKTOP3','?desktop=3');
define('ACTION_DESKTOP4','?desktop=4');

define('ACTION_CHANGE_DESKTOP','desktop');

//action
define('ACTION_ANNULLA',0);
define('ACTION_CLOSE_CONTENTS',1);
define('ACTION_CLOSE_CONTENT',2);
define('ACTION_CLOSE_OTHER_CONTENT',3);
define('ACTION_MOSTRA_DESKTOP',4);
define('ACTION_FORMAT',5);
define('ACTION_INSTALL',6);

//nautilus
define('ACTION_NEW_DIR',1);
define('ACTION_NEW_XHTML',2);
define('ACTION_NEW_NEWS',3);
define('ACTION_NEW_TXT',4);
define('ACTION_NEW_MODULE',5);
define('ACTION_NEW_LINK',6);
define('ACTION_NEW_NOTE',7);
define('ACTION_NEW',8);

define('ACTION_PROPERTIES',9);
define('ACTION_LEFT',10);
define('ACTION_RIGHT',11);
define('ACTION_UP',12);
define('ACTION_RELOAD',13);
define('ACTION_GO_HOME',14);
define('ACTION_GO_PUBLIC',15);
define('ACTION_CUT',16);
define('ACTION_COPY',17);
define('ACTION_PASTE',18);
define('ACTION_DELETE',19);
define('ACTION_VIEW_DETAILED',20);
define('ACTION_VIEW_ICON',21);
define('ACTION_VIEW_FULLSCREEN',22);
define('ACTION_GO_HELP',23);

define('ACTION_DELETE_CONTENT',24);

define('ACTION_TEXT_LOGIN','Login');
define('ACTION_TEXT_ANNULLA','Annulla');
define('ACTION_TEXT_REGISTER','Register');
?>