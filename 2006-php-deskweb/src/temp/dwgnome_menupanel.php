<?php
require_once ($_SERVER['DOCUMENT_ROOT']."/project/deskweb-0.5/config/config.php");
require_once ($_SERVER['DOCUMENT_ROOT']."/applications/deskweb-0.5/config/config.php");
require_once ($_SERVER['DOCUMENT_ROOT']."/applications/deskweb-0.5/include_widgets.php");
require_once ($_SERVER['DOCUMENT_ROOT']."/applications/deskweb-0.5/include_components.php");
require_once ($_SERVER['DOCUMENT_ROOT']."/applications/deskweb-0.5/include_objects.php");

$link_db = mysql_pconnect(SERVER_DB, DB_USER, DB_PW) or die("Impossibile connettersi al server database");
$conn = mysql_select_db(DB_DB, $link_db) or die("impossibile connettersi al database");

$request = new RequestDeskWeb();
$session = new SessionDeskWeb();
$sniffer = new phpSniff();
$session->setUserAgentFeatures();
$model = new ModelDeskWeb(true);


$header = new HeaderDeskWeb();
//$header->addScript("/extra/js/functions.js");
$header->output();

require_once($_SERVER['DOCUMENT_ROOT']."/applications/deskweb-0.5/objects/dm/dwgnome/include_dwgnome.php");
$panel_menu = new DWgnomePanelMenu();
?>
<body>
<div id="desktop">
<?
$panel_menu->output();
?>
</div>
</body>
</html>
<?
mysql_close();
?>
