<?php

/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package Weblets
 */

/**
 * classe WebletNotesPanel
 */
class WebletNotesPanel extends WidgetDeskWeb {
	/**
	 * class constructor
	 * istanzia il contenuto dell'applicazione
	 * 
	 * todo:
	 * il panel non � un elemento inutile?
	 */
	function WebletNotesPanel($contenuto) {
		require_once ("notes_contenuto.php");
		$contenuto = new WebletNotesContent($contenuto);
		$this->add_element($contenuto);

		$this->open_element = "<div id='notes_panel'>\n";
		$this->close_element = "</div>\n";

	}

}
?>