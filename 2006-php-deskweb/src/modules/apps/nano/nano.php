<?php


/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package NanoDeskweb
 */

/**
 * class NanoDeskWeb
 */

class NanoDeskWeb extends WindowDeskWeb {
	/**
	 * costruttore vuoto
	 */
	function NanoDeskWeb() {
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
		require_once (dirname(__FILE__)."/nano_config.php");
		$sql = "select content from ".PREFIX_DB."node where id_node = '".$id_sezione."'";
		$contenuto = MySqlDao :: getDati($sql);
		require_once (dirname(__FILE__)."/nano_panel.php");
		$panel_nano = new NanoPanelDeskWeb($id_array, $id_sezione, $contenuto[0]['content']);
		return $panel_nano;

	}
}
?>