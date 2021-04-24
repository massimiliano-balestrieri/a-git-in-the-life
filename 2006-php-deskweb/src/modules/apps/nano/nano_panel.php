<?php


/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package NanoDeskweb
 */

/**
 * class NanoPanelDeskWeb
 */

class NanoPanelDeskWeb extends WidgetDeskWeb {

	/**
	* class constructor
	* la classe panel di ogni singola applicazione esegue le seguenti provvisorie operazioni
	* istanzia 
	* 
	* menu
	* contenuto (in forma di view o di form)
	*/

	function NanoPanelDeskWeb($id_array, $id_sezione, & $contenuto) {

		$this->panel($id_sezione);

		global $request, $session;

		if (!($session->getUserAgent() == 'ie' && !$session->getJavascript())) {
			require_once ("nano_menu.php");
			$barra_menu_nano = new NanoMenu($id_sezione);
			$this->text_apertura .= $barra_menu_nano->text_apertura;
		}
		$barra_titolo = new IconDeskWeb();
		$barra_titolo->set_classname("img_nano_barra_titolo");
		$barra_titolo->set_alt("barra titolo nano");
		$barra_titolo->set_src_mime("barra_titolo_nano.gif", "1");
		$barra_titolo->crea_tag();
		$barra_titolo->appendContainer("div", "nano_barra_titolo");

		$init_form = "<form class='nano_form' method='post' action='?id=".$id_sezione."'>\n";
		$close_form = "</form>\n";
		require_once (dirname(__FILE__)."/nano_toolbar.php");
		$toolbar = new NanoToolbar($id_sezione);
		$this->open_element .= $init_form.$toolbar->open_element.$toolbar->close_element;

		if ($request->w == ACTION_EDIT_NANO || @ $request->form['w'] == ACTION_EDIT_NANO) {
			require_once (dirname(__FILE__)."/nano_form.php");
			$contenuto_nano = new NanoFormDeskWeb($id_sezione, $contenuto);
		} else {

			require_once ("nano_contenuto.php");
			$contenuto_nano = new NanoContentDeskWeb($contenuto);
		}

		$this->add_element($barra_titolo);
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