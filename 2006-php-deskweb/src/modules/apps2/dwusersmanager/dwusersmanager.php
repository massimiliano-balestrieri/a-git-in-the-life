<?php


/**
 * Project:     deskweb - the dekstop manager for web <br />
 *
 *
 * The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package DWUsersmanagerDeskWeb
 */

/**
 * class DWUsersmanagerDeskWeb
 */
class DWUsersmanagerDeskWeb extends WindowDeskWeb {
	/**
	* costruttore setta l'id
	*/
	function DWUsersmanagerDeskWeb($id) {
		$this->setId($id);
	}
	/**
	 * metodo lanciato dalla classe "astratta" window nel momento in cui vede 
	 * che il contenuto della sezione richiede questa applicazione
	 * il metodo init
	 * 
	 * carica tramite dao il contenuto dell'applicazione
	 * istanzia il giusto panel
	 * e lo restituisce
	 */
	function init($id_array, $id_sezione) {
		
		require_once (dirname(__FILE__). "/dwusersmanager_model.php");
		$model = new DWUsersmanagerModelDeskWeb();
		require_once (dirname(__FILE__). "/dwusersmanager_panel.php");
		$panel = new DWUsersmanagerPanelDeskWeb($id_array, $id_sezione, $model);
		return $panel;
	}
}
?>