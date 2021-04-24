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
 * @package Window Manager
 */

/**
 * WindowStatusBarNavDeskWeb Widget
 */

class WindowStatusBarNavDeskWeb extends WidgetDeskWeb {
	
	/**
	* Constructor class
	* La classe costruttore disegna la barra di navigazione della finestra
	* Istanzia:
	* la label con il titolo della finestra corrente
	* Todo:
	* la dropdownlist con l'elenco dei contenuti raggiungibili
	*/
	function WindowStatusBarNavDeskWeb($nome_finestra) {
		//(&$request,$nome_finestra){

		$nav = new TextDeskWeb();
		$nav->set_text($nome_finestra);
		$nav->crea_tag();
		$this->add_element($nav);

		$this->open_element = "<div class='window_barra_stato_nav'>\n";
		$this->close_element = "</div>\n";

	}

}
?>