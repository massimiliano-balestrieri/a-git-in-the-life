<?php


/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package SkeletonDeskWeb
 */

/**
 * class SkeletonDeskWeb
 */
class DWSkeletonDeskWeb extends WindowDeskWeb {
	/**
	* costruttore setta l'id
	*/
	function DWSkeletonDeskWeb($id) {
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
		$contenuto = "";
		require_once (dirname(__FILE__)."/dwskeleton_panel.php");
		$panel = new DWSkeletonPanelDeskWeb($id_array, $id_sezione, $contenuto);
		return $panel;
	}
}
?>