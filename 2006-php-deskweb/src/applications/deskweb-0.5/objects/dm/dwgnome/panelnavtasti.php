<?php
/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package DesktopManager
 */

/**
 * TastiPanelNav Widget
 */
class TastiPanelNav extends WidgetDeskWeb {

	/**
	 * Class constructor
	 * Istanzia:
	 * i tasti della barra
	 */
	function TastiPanelNav($container = true) {
		global $model, $request, $msgstack;
		
		for ($x = 0; $x <= count($model->arr_contents) - 1; $x ++) {
			$tasto_panel_nav[$x] = new TastoPanelNav($model->arr_contents[$x]['id_node'], count($model->arr_contents),  $model->arr_contents[$x]['node'], $model->arr_contents[$x]['icon']);
			$this->add_element($tasto_panel_nav[$x]);
		}

		if ($container) {
			$this->open_element = "<div id='tasti_panel_nav'>\n";
			$this->close_element = "</div>\n";
		}
	}

}
?>