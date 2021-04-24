<?php


/**
 * Project:     deskweb - the desktop manager for web <br />
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * You may contact the authors of Deskweb by emial at: <br />
 * io@maxb.net <br />
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
 * @package NautilusDeskweb
 */

/**
 * Class DWNautilusDeskWebPanel
 */
class DWNautilusDeskWebPanel extends DWNautilusDeskWeb {
	
	var $id_applicazione = null;
	/**
	 * class constructor
	 * la classe panel di ogni singola applicazione esegue le seguenti provvisorie operazioni
	 * istanzia 
	 * 
	 * menu
	 * contenuto (in forma di view o di form)
	 */

	function DWNautilusDeskWebPanel($id_array, $id_sezione) {
		$this->panel($id_sezione);
		$this->id_applicazione = "applicazione_".$id_sezione;		
		
		global $session;
		// senza javascript ie non supporta il suckerfish dropdown. non lo carico
		if (!($session->getUserAgent() == 'ie' && !$session->getJavascript())) {
			require_once (dirname(__FILE__)."/dwnautilus_menu.php");
			$barra_menu = new DWNautilusMenu($id_sezione);
			$this->open_element .= $barra_menu->open_element;
		}
		$init_form = "<form class='nautilus_form' method='post' action='?id=".$id_sezione."'>\n";
		$close_form = "</form>\n";
		require_once (dirname(__FILE__)."/dwnautilus_toolbar.php");
		$toolbar = new DWNautilusToolbar($id_sezione);
		$this->open_element .= $init_form.$toolbar->open_element.$toolbar->close_element;

		if ($session->getView() == VIEW_ICON)
			$this->getContentsIcons($id_array, $id_sezione);
		if ($session->getView() == VIEW_DETAILED)
			$this->getContentsDetailed($id_array, $id_sezione);
			

		$this->open_element .= "<div class='nautilus_panel'>\n";
		$this->close_element = "</div>\n".$close_form;

	}
	/**
	* funzione per le finestre di dialogo
	*/
	function panel($id_sezione) {
		global $request;
		//
		if (isset ($request->form['n']))
			$n = $request->form['n'];
		else
			$n = $request->n;

		if ($n != null) {
			if ($id_sezione == $request->id) {
				
				switch ($n) {
					case ACTION_NEW_DIR : //nuova cartella
						$dialog = new DialogDeskWeb($id_sezione, "Crea Directory", "id=".$request->id."&amp;n=".$request->n);
						$dialog->creaInput("Nome Directory", "nome_file", 1);
						$dialog->creaInput("Nome Icona", "icona", 1);
						$dialog->creaInputHidden("type", "dir");
						$dialog->creaInputHidden("n", $n);
						$dialog->creaGroupCheck("Permessi", "permessi", 1, array ("R" => 'r', "W" => 'w', "X" => 'x'));
						$this->open_element .= $dialog->open_element.$dialog->close_element;
						break;
					case ACTION_NEW_XHTML : //nuova presentazione
						$dialog = new DialogDeskWeb($id_sezione, "Crea Presentazione", "id=".$request->id."&amp;n=".$request->n);
						$dialog->creaInput("Nome Presentazione", "nome_file", 1);
						$dialog->creaInput("Icona", "icona", 1);
						$dialog->creaInputHidden("type", "html");
						$dialog->creaInputHidden("n", $n);
						$dialog->creaGroupCheck("Permessi", "permessi", 1, array ("R" => 'r', "W" => 'w', "X" => 'x'));
						$this->open_element .= $dialog->open_element.$dialog->close_element;
						break;
					case ACTION_NEW_NEWS : //nuova news
						$dialog = new DialogDeskWeb($id_sezione, "Crea News", "id=".$request->id."&amp;n=".$request->n);
						$dialog->creaInput("Titolo News", "nome_file", 1);
						$dialog->creaInputHidden("type", "news");
						$dialog->creaInputHidden("n", $n);
						$dialog->creaGroupCheck("Permessi", "permessi", 1, array ("R" => 'r', "W" => 'w', "X" => 'x'));
						$this->open_element .= $dialog->open_element.$dialog->close_element;
						break;
					case ACTION_NEW_TXT : //nuovo txt
						$dialog = new DialogDeskWeb($id_sezione, "Crea Txt", "id=".$request->id."&amp;n=".$request->n);
						$dialog->creaInput("Titolo Txt", "nome_file", 1);
						$dialog->creaInput("Icona", "icona", 1);
						$dialog->creaInputHidden("type", "txt");
						$dialog->creaInputHidden("n", $n);
						$dialog->creaGroupCheck("Permessi", "permessi", 1, array ("R" => 'r', "W" => 'w', "X" => 'x'));
						$this->open_element .= $dialog->open_element.$dialog->close_element;
						break;
					case ACTION_NEW_MODULE : //nuova modulo
						$dialog = new DialogDeskWeb($id_sezione, "Crea Modulo", "id=".$request->id."&amp;n=".$request->n);
						$dialog->creaInput("Titolo Modulo", "nome_file", 1);
						$dialog->creaInput("Icona", "icona", 1);
						$dialog->creaInputHidden("type", "form");
						$dialog->creaInputHidden("n", $n);
						$dialog->creaGroupCheck("Permessi", "permessi", 1, array ("R" => 'r', "W" => 'w', "X" => 'x'));
						$this->open_element .= $dialog->open_element.$dialog->close_element;
						break;
					case ACTION_NEW_LINK : //nuovo link
						$dialog = new DialogDeskWeb($id_sezione, "Crea Link", "id=".$request->id."&amp;n=".$request->n);
						$dialog->creaInput("Titolo Link", "nome_file", 1);
						$dialog->creaInput("Link", "link", 1);
						$dialog->creaInput("Icona", "icona", 1);
						$dialog->creaInputHidden("type", "link");
						$dialog->creaInputHidden("n", $n);
						$dialog->creaGroupCheck("Permessi", "permessi", 1, array ("R" => 'r', "W" => 'w', "X" => 'x'));
						$this->open_element .= $dialog->open_element.$dialog->close_element;
						break;
					case ACTION_NEW_NOTE : //nuovo nota
						$dialog = new DialogDeskWeb($id_sezione, "Crea Nota", "id=".$request->id."&amp;n=".$request->n);
						$dialog->creaInput("Titolo Nota", "nome_file", 1);
						$dialog->creaInputHidden("type", "note");
						$dialog->creaInputHidden("n", $n);
						$dialog->creaGroupCheck("Permessi", "permessi", 1, array ("R" => 'r', "W" => 'w', "X" => 'x'));
						$this->open_element .= $dialog->open_element.$dialog->close_element;
						break;
					case ACTION_NEW : //nuovo generale (toolbar)
						$dialog = new DialogDeskWeb($id_sezione, "Crea Nota", "id=".$request->id."&amp;n=".$request->n);
						$dialog->creaInput("Nome file", "nome_file", 1);
						$dialog->creaInputHidden("n", $n);
						$dialog->creaSelectElenco("Tipo", "type", array ("dir", "html", "news", "txt", "form", "link", "note"));
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
	* questo metodo è infatti identico in cvs/nautilus/bookmarks
	*/
	function getContentsIcons($id_array, $id_sezione) {
		global $model, $request, $sniffer, $session;
		$array = array ();
		if (isset ($model->arr_contents[$id_array]['sons'])) {
			$array = $model->arr_contents[$id_array]['sons'];
			for ($x = 0; $x <= count($array) - 1; $x ++) {
				$icone[$x] = new IconDeskWeb();
				//$icone[$x]->set_container("div","icona_nautilus_panel");
				$icone[$x]->set_dim("48x48");
				$icone[$x]->set_classname("icona_nautilus");
				$icone[$x]->set_src_mime($array[$x]['icon'], $array[$x]['type']);
				if ($array[$x]['type'] == "link") {
					if (strpos($array[$x]['node'], "#") > 0) {
						$array[$x]['link'] = substr($array[$x]['node'], strpos($array[$x]['node'], "#") + 1);
						$array[$x]['node'] = substr($array[$x]['node'], 0, strpos($array[$x]['node'], "#"));
						$icone[$x]->set_label($array[$x]['node'], "text_icona_nautilus");
						if (substr($array[$x]['link'], 0, 6) == "action")
							$icone[$x]->set_href_action(substr($array[$x]['link'], 7));
						else
							$icone[$x]->set_href_external($array[$x]['link']);

					}
				} else {
					$icone[$x]->set_label($array[$x]['node'], "text_icona_nautilus");
					if ($session->getAjax())
					$icone[$x]->set_onclick("WindowAjax",$array[$x]['id_node']);
					else
					$icone[$x]->set_href($array[$x]['id_node']);
				}
				$icone[$x]->set_alt($array[$x]['node']);
				$icone[$x]->crea_tag();

				//if (!$session->getJavascript())
					$icone[$x]->appendCheck($array[$x]['id_node']);

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
	/**
	* funzione per il popolamento in icone del panel
	* todo:
	* astrarre questa funzione in una sottoclasse widget
	* questo metodo è infatti identico in cvs/nautilus/bookmarks
	*/
	function getContentsDetailed($id_array, $id_sezione) {
		require_once(dirname(__FILE__)."/dwnautilus_table.php");
		$tbl_dati = new DWNautilusTableDeskWeb();
		$intestazioni = array("node"=>"Nome","username"=>"Utente","groupname"=>"Gruppo","permissions"=>"Permessi","last_date"=>"Data");
		$tbl_dati->setClassname("tblnautilus");
		$tbl_dati->setIntestazioni($intestazioni);
		
		global $model, $request, $sniffer, $session;
		$array = array ();
		
		if (isset ($model->arr_contents[$id_array]['sons'])) {
			$array = $model->arr_contents[$id_array]['sons'];
			for ($x = 0; $x <= count($array) - 1; $x ++) {
				
				if($x%2)
				$tbl_dati->openRow("nautilus_row_on");
				else
				$tbl_dati->openRow("nautilus_row_off");
				
				$icone[$x] = new IconDeskWeb();
				//if (!$session->getJavascript())
					$icone[$x]->appendCheck($array[$x]['id_node']);
					
				//$icone[$x]->set_container("div","icona_nautilus_panel");
				$icone[$x]->set_dim("22x22");
				$icone[$x]->set_classname("icona_nautilus_detailed");
				$icone[$x]->set_src_mime($array[$x]['icon'], $array[$x]['type']);
				if ($array[$x]['type'] == "link") {
					if (strpos($array[$x]['node'], "#") > 0) {
						$array[$x]['link'] = substr($array[$x]['node'], strpos($array[$x]['node'], "#") + 1);
						$array[$x]['node'] = substr($array[$x]['node'], 0, strpos($array[$x]['node'], "#"));
						$icone[$x]->set_label($array[$x]['node'], "text_icona_nautilus_detailed");
						if (substr($array[$x]['link'], 0, 6) == "action")
							$icone[$x]->set_href_action(substr($array[$x]['link'], 7));
						else
							$icone[$x]->set_href_external($array[$x]['link']);

					}
				} else {
					$icone[$x]->set_label($array[$x]['node'], "text_icona_nautilus_detailed");
					if ($session->getAjax())
					$icone[$x]->set_onclick("WindowAjax",$array[$x]['id_node']);
					else
					$icone[$x]->set_href($array[$x]['id_node']);
				}
				$icone[$x]->set_alt($array[$x]['node']);
				$icone[$x]->crea_tag();
				$icone[$x]->appendLabel();
				
				$tbl_dati->addCell($icone[$x]->open_element);
				
				$tbl_dati->addCell($array[$x]['username']);
				$tbl_dati->addCell($array[$x]['groupname']);
				$tbl_dati->addCell($array[$x]['permissions']);
				$tbl_dati->addCell(date("d/m/y",strtotime($array[$x]['last_date'])));
				
				$tbl_dati->closeRow();
			}
		}
		
		$tbl_dati->createTable();
		$this->add_element($tbl_dati);
	}

}
?>