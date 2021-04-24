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
 * PanelQuickStart Widget
 */
class PanelQuickStart extends WidgetDeskWeb {

	var $icone = array ();
	/**
	 * Pannello avvio veloce
	 * Istanzia il menu con id 3 prendendo da modello e da array statico(temp) le sezioni assegnate a questo menu
	 */
	function PanelQuickStart() {

		global $model,$session;
		if (is_array($model->arr_menu)) {
			reset($model->arr_menu);
			while ($array_cell = each($model->arr_menu)) {
				if ($array_cell['value']['fk_menu'] == 3) {
					$icone[$array_cell['key']] = new IconDeskWeb();
					$icone[$array_cell['key']]->set_dim("22x22");
					$icone[$array_cell['key']]->set_src_mime($array_cell['value']['icon'], $array_cell['value']['type']);
					$icone[$array_cell['key']]->set_alt($array_cell['value']['node']);
					
					if ($array_cell['value']['type'] == "link") {
						if (strpos($array_cell['value']['node'], "#") > 0) {
							$array_cell['value']['link'] = substr($array_cell['value']['node'], strpos($array_cell['value']['node'], "#") + 1);
							$array_cell['value']['node'] = substr($array_cell['value']['node'], 0, strpos($array_cell['value']['node'], "#"));
							if (substr($array_cell['value']['link'], 0, 6) == "action")
								$icone[$array_cell['key']]->set_href_action(substr($array_cell['value']['link'], 7));
							else
								$icone[$array_cell['key']]->set_href_external($array_cell['value']['link']);

						}
					} else {
							if ($session->getAjax())
								$icone[$array_cell['key']]->set_onclick("WindowAjax",$array_cell['value']['id_node']);
							else
								$icone[$array_cell['key']]->set_href($array_cell['value']['id_node']);
					}
					$icone[$array_cell['key']]->crea_tag();
				}
			}
			if (isset ($icone) && is_array($icone)) {
				while ($array_cell = each($icone)) {
					$this->add_element($array_cell['value']);
				}
			}
		}

		$this->open_element = "<div id='avvio_veloce'>\n";
		$this->close_element = "</div>\n";
	}

}
?>