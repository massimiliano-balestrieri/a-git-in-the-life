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
 * @package DwEditorDeskweb
 */

/**
 * class DwEditorPanelDeskWeb
 */

class DwEditorPanelDeskWeb extends WidgetDeskWeb {

	/**
	 * class constructor
	 * la classe panel di ogni singola applicazione esegue le seguenti provvisorie operazioni
	 * istanzia 
	 * 
	 * menu
	 * contenuto (in forma di view o di form)
	 */
	function DwEditorPanelDeskWeb($id_array, $id_sezione, $contenuto) {

		require_once ($_SERVER['DOCUMENT_ROOT']."/".DIR_DESKWEB."/widgets/fm/include_fm.php");

		$this->panel($id_sezione);

		global $request, $session;
		if ($request->p != ACTION_EDIT_DWEDITOR && @ $request->form['p'] != ACTION_EDIT_DWEDITOR) {
			if (!($session->getUserAgent() == 'ie' && !$session->getJavascript())) {
				require_once (dirname(__FILE__)."/dweditor_menu.php");
				$barra_menu = new DwEditorMenu($id_sezione);
				$this->open_element .= $barra_menu->open_element;
			}
		}
		$init_form = "<form class='dweditor_form' method='post' action='?id=".$id_sezione."'>\n";
		$close_form = "</form>\n";
		require_once (dirname(__FILE__)."/dweditor_toolbar.php");
		$toolbar = new DwEditorToolbar($id_sezione);
		$this->open_element .= $init_form.$toolbar->open_element.$toolbar->close_element;

		if ($request->p == ACTION_EDIT_DWEDITOR || @ $request->form['p'] == ACTION_EDIT_DWEDITOR) {
			require_once (dirname(__FILE__)."/dweditor_form.php");
			$contenuto = new DwEditorFormDeskWeb($id_sezione, $contenuto);
		} else {
			require_once (dirname(__FILE__)."/dweditor_contenuto.php");
			$contenuto = new DwEditorContentDeskWeb($contenuto);
		}
		$this->add_element($contenuto);

		$this->open_element .= "<div class='generic_panel' style='text-align:left;'>\n";
		$this->close_element = "</div>\n".$close_form;

	}
	function panel($id_sezione) {
		global $request;
		//

		if (isset ($request->form['p']))
			$p = $request->form['p'];
		else
			$p = $request->p;

		if ($p != null) {
			if ($id_sezione == $request->id) {

				switch ($p) {
					case ACTION_NEW_DWEDITOR : //nuovo txt
						$dialog = new DialogDeskWeb($id_sezione, "Crea Html", "id=".$request->id."&amp;n=".$request->n);
						$dialog->creaInput("Titolo Html", "nome_file", 1);
						$dialog->creaInput("Icona", "icona", 1);
						$dialog->creaInputHidden("applicazione", "dweditor");
						$dialog->creaInputHidden("type", "html");
						$dialog->creaInputHidden("p", $p);
						$dialog->creaGroupCheck("Permessi", "permessi", 1, array ("R" => 'r', "W" => 'w', "X" => 'x'));
						$this->open_element .= $dialog->open_element.$dialog->close_element;
						break;
				}
			}
		}
	}

}
?>