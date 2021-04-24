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
 * @package BookmarksDeskweb
 */

/**
 * class BookmarksPanelDeskWeb
 */

class BookmarksPanelDeskWeb extends WidgetDeskWeb {
	/**
	* class constructor
	* la classe panel di ogni singola applicazione esegue le seguenti provvisorie operazioni
	* istanzia 
	* 
	* menu
	* contenuto (in forma di view o di form)
	*/
	function BookmarksPanelDeskWeb($id_array, $id_sezione) {
		$this->panel($id_sezione);

		global $request;
		require_once (dirname(__FILE__)."/bookmarks_menu.php");
		$barra_menu = new BookmarksMenu($id_sezione);
		$this->open_element .= $barra_menu->open_element;

		$this->popola_fromDB($id_array, $id_sezione);

		$this->open_element .= "<div class='panel_nautilus'>\n";
		$this->close_element = "</div>\n";

	}
	/**
	 * funzione per le finestre di dialogo
	 */
	function panel($id_sezione) {
		global $request;
		if ($request->n != null) {
			if ($id_sezione == $request->id) {

				switch ($request->n) {
					case 11 : //nuovo link
						$dialog = new DialogDeskWeb($id_sezione, "Crea Link", "id=".$request->id."&amp;n=".$request->n);
						$dialog->creaInput("Titolo Link", "titolo", 1);
						$dialog->creaInput("Link", "link", 1);
						$dialog->creaInput("Icona", "icona", 1);
						$dialog->creaGroupCheck("Permessi", "permessi", 1, array ("R" => 'r', "W" => 'w', "X" => 'x'));
						$this->open_element .= $dialog->open_element.$dialog->close_element;
						break;
				}
			}
		}
	}
	/**
	 * funzione per il popolamento in icone del panel
	 * todo:
	 * astrarre questa funzione in una sottoclasse widget
	 * questo metodo � infatti identico in cvs/nautilus/bookmarks
	 */
	function popola_fromDB($id_array, $id_sezione) {
		global $model, $request, $sniffer;
		$array = array ();
		if (isset ($model->arr_contents[$id_array]['sons'])) {

			$array = $model->arr_contents[$id_array]['sons'];
			for ($x = 0; $x <= count($array) - 1; $x ++) {
				$icone[$x] = new IconDeskWeb();
				//$icone[$x]->set_container("div","icona_nautilus_panel");
				$icone[$x]->set_dim("48x48");
				$icone[$x]->set_classname("icona_nautilus");
				$icone[$x]->set_src_mime($array[$x]['icon'], $array[$x]['type']);
				if ($array[$x]['type'] == 'link') //link
					{
					if (strpos($array[$x]['node'], "#") > 0) {
						$array[$x]['link'] = str_replace("http://","",substr($array[$x]['node'], strpos($array[$x]['node'], "#") + 1));
						$array[$x]['node'] = substr($array[$x]['node'], 0, strpos($array[$x]['node'], "#"));
						$icone[$x]->set_label($array[$x]['node'], "text_icona_nautilus");
						$icone[$x]->set_href_external($array[$x]['link']);
					}
				} else {
					$icone[$x]->set_label($array[$x]['node'], "text_icona_nautilus");
					//if($sniffer->get_property("browser")=="mz")
					//$icone[$x]->set_onclick("WindowAjax",$array[$x]['id_sezione']);
					//else
					$icone[$x]->set_href($array[$x]['id_node']);
				}
				$icone[$x]->set_alt($array[$x]['node']);
				$icone[$x]->crea_tag();
				$icone[$x]->appendLabel();
				$icone[$x]->appendContainer("div", "icona_nautilus_panel");
			}
			if (isset ($icone) && is_array($icone)) {
				while ($array_cell = each($icone)) {
					$this->add_element($array_cell['value']);
				}
			}
		}

	}
}
?>