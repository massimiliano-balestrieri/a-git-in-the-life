<?php


/**
 * Project:     deskweb - the dekstop manager for web <br />
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
 * @package SystemDeskweb
 */

/**
 * class SystemPanelDeskWeb
 */

class SystemPanelDeskWeb extends WidgetDeskWeb {

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
	function SystemPanelDeskWeb($id_array, $id_sezione, $model) {

		$this->id_applicazione = "applicazione_".$id_sezione;
		$this->applicazione = "system";
		$this->panel($id_sezione);

		global $request, $session;
		if (!($session->getUserAgent() == 'ie' && !$session->getJavascript())) {
			require_once (dirname(__FILE__)."/system_menu.php");
			$barra_menu = new SystemMenu($id_sezione);
			$this->open_element .= $barra_menu->open_element;
		}

		$visible = false;

		$tbl_dati = new TableDeskWeb($id_array, $id_sezione, $this->id_applicazione, array ("id_node", "node", "type", "application", "fk_parent", "fk_menu"), "id_node", true);
		$tbl_dati->addButtonPanel($id_sezione, "Elenco Nodi", true);
		//print_r($request->form);
		if ((!isset ($request->form['action']) && !isset ($request->form['dettaglio'])) || @ $request->form['action'] == "Elenco Nodi") {

			$visible = true;
			$tbl_dati->InitTable();
			$tbl_dati->setPaging($model->num_record, $model->paging);

			$tbl_dati->set_classname("tblwidget");
			$tbl_dati->setDati($model->arr_system);
			$tbl_dati->addStateFullParam("filter");
			$tbl_dati->addStateFullParam("filterwhere");
			$tbl_dati->addStateFullParam("firstletter");
			$tbl_dati->addStateFullParam("firstletterwhere");
			$tbl_dati->createTable("Elenco Nodi", $visible);

			$visible = false;
			if (isset ($request->form['firstletter']))
				$visible = true;
			$filtroaz = new LetterFilterFormDeskWeb($id_array, $id_sezione, $this->id_applicazione, array ("node", "type", "application"), "node");
			$filtroaz->addStateFullParam("orderby");
			$filtroaz->createForm("Filtro per lettera", $visible);

			$visible = false;
			if (isset ($request->form['filter']))
				$visible = true;
			$filtro = new FilterFormDeskWeb($id_array, $id_sezione, $this->id_applicazione, array ("node", "type", "application"), "node");
			$filtro->createForm("Ricerca", $visible);
		}

		$form = new FormDeskWeb($id_sezione);
		$form->addButtonPanel($id_sezione, "Dettaglio Nodo", true);

		$visible = false;
		if (isset ($request->form['dettaglio']) || @ $request->form['action'] == "Dettaglio Nodo" || @ $request->form['action'] == "Dettaglio Nodo" || @ $request->form['action'] == "modifica") {

			if (!isset ($request->form['dettaglio']))
				$request->form['dettaglio'] = "last";
				
			if(isset($request->form['formpage']))
				$request->form['lastpage'] = $request->form['formpage'];
			elseif(isset($request->form['lastpage']))
				$request->form['formpage'] = $request->form['lastpage'];
			
			$visible = true;
			$form->setDati(PREFIX_DB."node", "id_node", $request->form['dettaglio'], array ("content"));
			$form->addMultiInputReadOnly(array ("id_node" => 0));
			$form->addMultiInputText(array ("node" => 1, "id_dom" => 2, "type" => 3, "application" => 4, "window" => 5, "fk_parent" => 6,  "fk_menu" => 9, "order_menu" => 10, "last_date" => 11, "have_child" => 12, "permissions" => 13, "is_sys" => 16));
			$form->addSelectDb($order = 14, $nome_tabella = PREFIX_DB."users", $campi = array ("id_user", "username"), $label_scelta = "Scegli un utente", $fk = true);
			$form->addSelectDb($order = 15, $nome_tabella = PREFIX_DB."groups", $campi = array ("id_group", "groupname"), $label_scelta = "Scegli un gruppo", $fk = true);
			$form->addImage(array("icon" => 17), DIR_THUMB , array("/22x22/","/48x48/"));
			$form->addTextArea(array ("content" => 8));
			$form->addStateFullParam("action");
			$form->addStateFullParam("dettaglio");
			$form->addStateFullParam("lastpage");
			$form->PreparePage();
			$form->addPage(5, "Informazioni generali", array (0, 1, 3, 4, 5, 6, 12, 16), true); //
			$form->addPage(5, "Contenuto", array (8));
			$form->addPage(5, "Menu", array (9, 10));
			$form->addPage(5, "Icone", array (17));
			$form->addPage(5, "Permessi", array (11, 13, 14, 15));
			$form->ClosePage();
			$form->addFormToolbar($request->form['dettaglio']);
			$form->createForm("Dettaglio Nodo", $this->applicazione, $visible);
		}

		$this->add_element($tbl_dati);
		if ((!isset ($request->form['action']) && !isset ($request->form['dettaglio'])) || @ $request->form['action'] == "Elenco Nodi") {
			$this->add_element($filtroaz);
			$this->add_element($filtro);
		}
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