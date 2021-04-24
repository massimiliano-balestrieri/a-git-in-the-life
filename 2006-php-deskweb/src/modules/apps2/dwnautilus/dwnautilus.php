<?php

/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package DWNautilusDeskweb
 */

/**
 * class DWNautilusDeskWeb
 */
class DWNautilusDeskWeb extends WindowDeskWeb {
	/**
	 * class constructor
	 */
	function DWNautilusDeskWeb($id) {
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
		require_once (dirname(__FILE__)."/dwnautilus_panel.php");
		$panel = new DWNautilusDeskWebPanel($id_array, $id_sezione);
		return $panel;
	}
}
?>