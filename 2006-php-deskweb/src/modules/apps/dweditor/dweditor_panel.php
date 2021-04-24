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

		$this->panel($id_sezione);

		global $request,$session;
		if (!($session->getUserAgent() == 'ie' && !$session->getJavascript())) {
			require_once (dirname(__FILE__)."/dweditor_menu.php");
			$barra_menu = new DwEditorMenu($id_sezione);
			$this->open_element .= $barra_menu->open_element;
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