<?php


/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package DWNanoDeskweb
 */

/**
 * class DWNanoPanelDeskWeb
 */

class DWNanoPanelDeskWeb extends WidgetDeskWeb {

	/**
	* class constructor
	* la classe panel di ogni singola applicazione esegue le seguenti provvisorie operazioni
	* istanzia 
	* 
	* menu
	* contenuto (in forma di view o di form)
	*/

	function DWNanoPanelDeskWeb($id_array, $id_sezione, & $contenuto) {
		
		require_once ($_SERVER['DOCUMENT_ROOT']."/".DIR_DESKWEB."/widgets/fm/include_fm.php");
		
		$this->panel($id_sezione);

		global $request, $session;

		if (!($session->getUserAgent() == 'ie' && !$session->getJavascript())) {
			require_once ("dwnano_menu.php");
			$barra_menu_nano = new DWNanoMenu($id_sezione);
			$this->open_element .= $barra_menu_nano->open_element;
		}
		$init_form = "<form class='nano_form' method='post' action='?id=".$id_sezione."'>\n";
		$close_form = "</form>\n";
		require_once (dirname(__FILE__)."/dwnano_toolbar.php");
		$toolbar = new DWNanoToolbar($id_sezione);
		$this->open_element .= $init_form.$toolbar->open_element.$toolbar->close_element;

		if ($request->w == ACTION_EDIT_NANO || @ $request->form['w'] == ACTION_EDIT_NANO) {
			require_once (dirname(__FILE__)."/dwnano_form.php");
			$contenuto_nano = new DWNanoFormDeskWeb($id_sezione, $contenuto);
		} else {

			require_once (dirname(__FILE__)."/dwnano_contenuto.php");
			$contenuto_nano = new DWNanoContentDeskWeb($contenuto);
		}

		$this->add_element($contenuto_nano);

		$this->open_element .= "<div class='nano_panel'>\n";
		$this->close_element = "</div>\n".$close_form;

	}
	function panel($id_sezione) {
		global $request;
		//

		if (isset ($request->form['w']))
			$w = $request->form['w'];
		else
			$w = $request->w;

		if ($w != null) {
			if ($id_sezione == $request->id) {

				switch ($w) {
					case ACTION_NEW_NANO : //nuovo txt
						$dialog = new DialogDeskWeb($id_sezione, "Crea Txt", "id=".$request->id."&amp;n=".$request->n);
						$dialog->creaInput("Titolo Txt", "nome_file", 1);
						$dialog->creaInput("Icona", "icona", 1);
						$dialog->creaInputHidden("applicazione", "nano");
						$dialog->creaInputHidden("type", "txt");
						$dialog->creaInputHidden("w", $w);
						$dialog->creaGroupCheck("Permessi", "permessi", 1, array ("R" => 'r', "W" => 'w', "X" => 'x'));
						$this->open_element .= $dialog->open_element.$dialog->close_element;
						break;
				}
			}
		}
	}
}
?>