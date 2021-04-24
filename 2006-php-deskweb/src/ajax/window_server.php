<?php

/**
 * Project:     deskweb - the dekstop manager for web <br />
 * File:        window_server.php <br />
 * Description: Il file si connette al db<br /> 
 * istanzia sniffer, sessione, request e modello<br /> 
 * istanzia l'oggetto ContentDeskWeb e lo manda ad output<br /> 
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
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

require_once ($_SERVER['DOCUMENT_ROOT']."/project/deskweb-0.5/config/config.php");
require_once ($_SERVER['DOCUMENT_ROOT']."/applications/deskweb-0.5/config/config.php");
require_once ($_SERVER['DOCUMENT_ROOT']."/applications/deskweb-0.5/include_widgets.php");
require_once ($_SERVER['DOCUMENT_ROOT']."/applications/deskweb-0.5/include_components.php");
require_once ($_SERVER['DOCUMENT_ROOT']."/applications/deskweb-0.5/include_objects.php");
//require_once($_SERVER['DOCUMENT_ROOT']. "/applications/deskweb-0.5/widgets/wm/include_wm.php");

$link_db = mysql_pconnect(SERVER_DB, DB_USER, DB_PW) or die("Impossibile connettersi al server database");
$conn = mysql_select_db(DB_DB, $link_db) or die("impossibile connettersi al database");

$request = new RequestDeskWeb();
$session = new SessionDeskWeb();
$model = new ModelDeskWeb(true);
$body = new ContentDeskWeb(true);

//css

$file = $_SERVER['DOCUMENT_ROOT']."/".DIR_APPS."/".$model->arr_contents[0]['application']."/css/style.css";
if (is_file($file)) {
	$css = DIR_APPS."/".$model->arr_contents[0]['application']."/css/style.css";
	HeaderDeskWeb :: insertStyle($css);
}
$body->output();
mysql_close();
?>

