<?php
/**
 * Project:     deskweb - the dekstop manager for web <br />
 * File:        tasti_server.php <br />
 * Description: Il file si connette al db<br /> 
 * istanzia sessione, request e modello<br /> 
 * istanzia l'oggetto tastiPanelNav e lo manda ad output<br /> 
 *
 * You may contact the authors of Deskweb by emial at: <br />
 * io@maxb.net <br />
 *
 * Or, write to: <br />
 * Massimiliano Balestrieri <br />
 * Via Casalis 9 <br />
 * 10143 Torino <br />
 * Italy <br />
 *
 * The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package Ajax
 */
 
require_once($_SERVER['DOCUMENT_ROOT']. "/project/deskweb-0.3/config/config.php");
require_once($_SERVER['DOCUMENT_ROOT']. "/applications/deskweb-0.3/config/config.php");
require_once($_SERVER['DOCUMENT_ROOT']. "/applications/deskweb-0.3/include_components.php");
require_once($_SERVER['DOCUMENT_ROOT']. "/applications/deskweb-0.3/include_widgets.php");
require_once($_SERVER['DOCUMENT_ROOT']. "/applications/deskweb-0.3/include_dm.php");
require_once($_SERVER['DOCUMENT_ROOT']. "/applications/deskweb-0.3/include_wm.php");

$link_db = mysql_pconnect(SERVER_DB,DB_USER,DB_PW) or die ("Impossibile connettersi al server database");
$conn = mysql_select_db(DB_DB,$link_db) or die ("impossibile connettersi al database");

$session = new SessionDeskWeb();
$request = new RequestDeskWeb();
$model = new ModelDeskWeb();
$body = new tastiPanelNav(false);
$body->output();
mysql_close();

?>