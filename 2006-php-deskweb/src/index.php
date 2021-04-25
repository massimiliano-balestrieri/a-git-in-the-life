<?php
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
// install
require_once ($_SERVER['DOCUMENT_ROOT']."/project/deskweb-0.5/config/config.php");

$_link_db = mysql_pconnect(SERVER_DB,DB_USER,DB_PW) or die ("Impossibile connettersi al server database");
$_conn = mysql_select_db(DB_DB,$_link_db) or die ("impossibile connettersi al database");

$_sql = file_get_contents($_SERVER['DOCUMENT_ROOT']."/project/deskweb-0.5/config/deskweb035.sql");

print_r($_conn);

mysql_query($_sql, $_link_db);

print_r(mysql_error());

mysql_close();

//require_once("./deskweb5.php");

