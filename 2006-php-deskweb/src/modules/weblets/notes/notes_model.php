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
 * @package Weblets
 */

/**
 * classe NotesModel
 */
class NotesModel {

	/**
	 * array dati weblets
	 */
	var $arr_notes = array ();
	/**
	 * costruttore
	 * prende da metodo statico di dao i dati che servono all'applicazione
	 */
	function NotesModel() {

		$sql = "select id_node, node, content, last_date from ".PREFIX_DB."node where type = 'note' order by last_date desc limit 0,1 ";
		$this->arr_notes = MySqlDao :: getDati($sql);
	}
}
?>