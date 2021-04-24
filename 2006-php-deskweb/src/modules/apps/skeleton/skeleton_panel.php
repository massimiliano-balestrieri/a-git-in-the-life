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
 * @package SkeletonDeskweb
 */

/**
 * class SkeletonPanelDeskWeb
 */

class SkeletonPanelDeskWeb extends WidgetDeskWeb {

	/**
	* class constructor
	* la classe panel di ogni singola applicazione esegue le seguenti provvisorie operazioni
	* istanzia 
	* 
	* menu
	* contenuto (in forma di view o di form)
	*/
	function SkeletonPanelDeskWeb($id_array, $id_sezione, $contenuto) {
		$this->panel($id_sezione);

		global $request, $session;
		if (!($session->getUserAgent() == 'ie' && !$session->getJavascript())) {
			require_once (dirname(__FILE__)."/skeleton_menu.php");
			$barra_menu = new SkeletonMenu($id_sezione);
			$this->open_element .= $barra_menu->open_element;
		}

		$init_form = "<form class='nautilus_form' method='post' action='?id=".$id_sezione."'>\n";
		$close_form = "</form>\n";
		require_once (dirname(__FILE__)."/skeleton_toolbar.php");
		$toolbar = new SkeletonToolbar($id_sezione);
		$this->open_element .= $init_form.$toolbar->open_element.$toolbar->close_element;

		$action = "action";

		if ($request-> $action == 2) {
			require_once (dirname(__FILE__)."/skeleton_form.php");
			$contenuto = new SkeletonFormDeskWeb($contenuto);
		} else {
			require_once (dirname(__FILE__)."/skeleton_contenuto.php");
			$contenuto = new SkeletonContentDeskWeb($contenuto);
		}

		$this->add_element($contenuto);

		$this->open_element .= "<div class='panel_generic'>\n";
		$this->close_element = "</div>\n".$close_form;

	}
	/**
	 * funzione per le finestre di dialogo
	 */
	function panel($id_sezione) {
		global $request;
		$action = "action";
		if ($request-> $action != null) {
			if ($id_sezione == $request->id) {

				switch ($request-> $action) {

				}
			}
		}
	}
}
?>