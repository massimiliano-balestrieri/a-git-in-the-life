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
 * @package DesktopManager
 */

/**
 * PanelIconeSx Widget
 */

class PanelIconeSx extends WidgetDeskWeb {
	
	/**
	 * icone del menu
	 */
	var $icone = array ();
	/**
	 * Constructor class
	 * Pannello icone dx sul desktop
	 * 
	 * recupera dal modello le sezioni posizionate sul menu con id = 1
	 * (temp)recupera da un array statico eventuali costanti
	 * 
	 * todo:
	 * gestione di questo menu 
	 */
	function PanelIconeSx() {
		global $model, $request, $session;

		if (is_array($model->arr_menu)) {
			reset($model->arr_menu);
			while ($array_cell = each($model->arr_menu)) {
				if ($array_cell['value']['fk_menu'] == 1) {
					$icone[$array_cell['key']] = new IconDeskWeb();
					$icone[$array_cell['key']]->set_classname("icone");
					$icone[$array_cell['key']]->set_alt($array_cell['value']['node']);
					$icone[$array_cell['key']]->set_dim("48x48");
					$icone[$array_cell['key']]->set_src_mime($array_cell['value']['icon'], $array_cell['value']['type']);
					if ($session->getAjax())
						$icone[$array_cell['key']]->set_onclick("WindowAjax", $array_cell['value']['id_node']);
					else
						$icone[$array_cell['key']]->set_href($array_cell['value']['id_node']);

					$icone[$array_cell['key']]->set_label($array_cell['value']['node'], "text_icone");
					$icone[$array_cell['key']]->crea_tag();
					$icone[$array_cell['key']]->appendLabel();
				}
			}
			if (isset ($icone) && is_array($icone)) {
				while ($array_cell = each($icone)) {
					$this->add_element($array_cell['value']);
				}
			}
		}

		

		$this->open_element = "<div id='icone_sinistra'>\n";
		$this->close_element = "</div>\n";
	}

}
?>