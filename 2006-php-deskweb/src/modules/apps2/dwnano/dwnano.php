<?php


/**
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
 * @package DWNanoDeskweb
 */

/**
 * class DWNanoDeskWeb
 */

class DWNanoDeskWeb extends WindowDeskWeb {
	/**
	 * costruttore vuoto
	 */
	function DWNanoDeskWeb() {
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
		require_once (dirname(__FILE__)."/dwnano_config.php");
		$sql = "select content from ".PREFIX_DB."node where id_node = '".$id_sezione."'";
		$contenuto = MySqlDao :: getDati($sql);
		require_once (dirname(__FILE__)."/dwnano_panel.php");
		$panel_nano = new DWNanoPanelDeskWeb($id_array, $id_sezione, $contenuto[0]['content']);
		return $panel_nano;

	}
}
?>