<?php
/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package ProfilemanagerDeskweb
 */

/**
 * class ProfilemanagerPanelDeskWeb
 */

class ProfilemanagerPanelDeskWeb extends WidgetDeskWeb {
	
	var $id_applicazione = null;
	var $applicazione = null;
	/**
	* class constructor
	* la classe panel di ogni singola applicazione esegue le seguenti provvisorie operazioni
	* istanzia 
	* 
	* menu
	* contenuto (in forma di view o di form)
	*/
	function ProfilemanagerPanelDeskWeb($id_array, $id_sezione, $model) {
		
		$this->id_applicazione = "applicazione_".$id_sezione;		
		$this->applicazione = "profilemanager";		
		$this->panel($id_sezione);
		
		global $request,$session;
		require_once (dirname(__FILE__). "/profilemanager_menu.php");
		$barra_menu = new ProfilemanagerMenu($id_sezione);
		$this->open_element .= $barra_menu->open_element;

		$visible = true;
		$form = new FormDeskWeb($id_sezione);
		$form->setDati(PREFIX_DB."users","id_user",$session->getCurrentUser());
		$form->addMultiInputHidden(array ("id_user" => 0));
		$form->addMultiInputText(array ("username" => 1, "pass" => 2, "mail" => 3));
		$form->createForm("Modifica Profilo", "modifica",$this->applicazione,  $visible);
		
		$this->add_element($form);

		$this->open_element .= "<div id='".$this->id_applicazione."' class='generic_panel'>\n";
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

				}
			}
		}
	}
}
?>