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
 * classe ModelNewsProject
 */
class ModelNewsProject {

	/**
	 * array dati weblets
	 */
	var $arr_news = array ();
	/**
	 * costruttore
	 * prende da metodo statico di dao i dati che servono all'applicazione
	 */
	function ModelNewsProject() {

		$sql = "select id_node, node, last_date from ".PREFIX_DB."node where type = 'news' order by last_date desc";
		$this->arr_news = MySqlDao :: getDati($sql);
	}
}
?>