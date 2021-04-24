<?php
/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package Window Manager
 */

/**
 * WindowStatusBarDeskWeb Widget
 */

class WindowStatusBarDeskWeb extends WidgetDeskWeb {

	/**
	 * Constructor class
	 * La classe costruttore disegna la barra di stato di una generica finestra
	 * Istanzia:
	 * La barra di navigazione
	 * La barra delle statistiche
	 * Le barra con l'ancora di ridimensionamento
	 */
	function WindowStatusBarDeskWeb($id_finestra, $nome_finestra, $coordinate, $isTrackable = true) {

		$barra_stato_nav = new WindowStatusBarNavDeskWeb($nome_finestra);
		$barra_stato_stat = new WindowStatusBarStatDeskWeb();
		$barra_stato_resize = new WindowStatusBarResizeDeskWeb($id_finestra, $coordinate, $isTrackable);

		$this->add_element($barra_stato_nav);
		$this->add_element($barra_stato_stat);
		$this->add_element($barra_stato_resize);

		$this->open_element = "<div class='window_barra_stato'>\n";
		$this->close_element = "</div>\n";
	}

}
?>