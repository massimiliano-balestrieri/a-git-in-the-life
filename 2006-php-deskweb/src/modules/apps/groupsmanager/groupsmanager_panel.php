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
 * @package GroupsmanagerDeskweb
 */

/**
 * class GroupsmanagerPanelDeskWeb
 */

class GroupsmanagerPanelDeskWeb extends WidgetDeskWeb {
	
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
	function GroupsmanagerPanelDeskWeb($id_array, $id_sezione, $model) {
		
		$this->id_applicazione = "applicazione_".$id_sezione;		
		$this->applicazione = "groupsmanager";		
		$this->panel($id_sezione);
		
		global $request;
		require_once (dirname(__FILE__). "/groupsmanager_menu.php");
		$barra_menu = new GroupsmanagerMenu($id_sezione);
		$this->open_element .= $barra_menu->open_element;

		$visible = true;
		if (isset ($request->form['action']) && strlen($request->form['action']))
			$visible = false;
		
		$tbl_dati = new TableDeskWeb($id_array, $id_sezione,$this->id_applicazione, array ("id_group", "name_group"), "id_group", true);
		$tbl_dati->setPaging($model->num_record,$model->paging);
		$tbl_dati->set_classname("tblwidget");
		$tbl_dati->setDati($model->arr_groupsmanager);
		$tbl_dati->createTable("Elenco Gruppi",$visible);

		
		$visible = false;
		if (isset ($request->form['invia']))
			$visible = true;
		$form = new FormDeskWeb($id_sezione);
		$form->addMultiInputText(array ("name_group" => 1));
		$form->createForm("Inserisci Gruppo", "inserisci", $this->applicazione, $visible);

		$visible = false;
		if (isset ($request->form['action']) && isset ($request->form['dettaglio'])) {
			switch ($request->form['action']) {
				case "modifica" :
					$visible = true;
					$form = new FormDeskWeb($id_sezione);
					$form->setDati(PREFIX_DB."groups","id_group",$request->form['dettaglio']);
					$form->addMultiInputHidden(array ("id_group" => 0));
					$form->addMultiInputText(array ("name_group" => 1));
					$form->createForm("Modifica Gruppo", "modifica", $this->applicazione, $visible);
					break;
				case "elimina" :
					$visible = true;
					$form = new FormDeskWeb($id_sezione);
					$form->setDati(PREFIX_DB."groups","id_group",$request->form['dettaglio']);
					$form->addMultiInputHidden(array ("id_group" => 0));
					$form->addMultiInputText(array ("name_group" => 1));
					$form->createForm("Elimina Gruppo", "elimina", $this->applicazione, $visible);
					break;
			}
		}

		$this->add_element($form);
		$this->add_element($tbl_dati);
		
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