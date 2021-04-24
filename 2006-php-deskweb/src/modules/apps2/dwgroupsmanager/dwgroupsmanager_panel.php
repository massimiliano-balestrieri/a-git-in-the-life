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
 * @package DWGroupsmanagerDeskWeb
 */

/**
 * class DWGroupsmanagerPanelDeskWeb
 */

class DWGroupsmanagerPanelDeskWeb extends WidgetDeskWeb {

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
	function DWGroupsmanagerPanelDeskWeb($id_array, $id_sezione, $model) {

		require_once ($_SERVER['DOCUMENT_ROOT']."/".DIR_DESKWEB."/widgets/fm/include_fm.php");
		
		$this->id_applicazione = "applicazione_".$id_sezione;
		$this->applicazione = "dwgroupsmanager";
		$this->panel($id_sezione);

		global $request, $session;
		if (!($session->getUserAgent() == 'ie' && !$session->getJavascript())) {
			require_once (dirname(__FILE__)."/dwgroupsmanager_menu.php");
			$barra_menu = new DWGroupsmanagerMenu($id_sezione);
			$this->open_element .= $barra_menu->open_element;
		}
		$visible = false;
		$tbl_dati = new TableDeskWeb($id_array, $id_sezione, $this->id_applicazione, array ("id_group", "groupname"), "id_group", true);
		$tbl_dati->addButtonPanel($id_sezione, "Elenco Gruppi", true);

		if ((!isset ($request->form['action']) && !isset ($request->form['dettaglio'])) || @ $request->form['action'] == "Elenco Gruppi") {
			$visible = true;
			$tbl_dati->InitTable();
			$tbl_dati->setPaging($model->num_record, $model->paging);
			$tbl_dati->set_classname("tblwidget");
			$tbl_dati->setDati($model->arr_groupsmanager);
			$tbl_dati->addStateFullParam("filter");
			$tbl_dati->addStateFullParam("filterwhere");
			$tbl_dati->addStateFullParam("firstletter");
			$tbl_dati->addStateFullParam("firstletterwhere");
			$tbl_dati->createTable("Elenco Gruppi", $visible);

			$visible = false;
			if (isset ($request->form['firstletter']))
				$visible = true;
			$filtroaz = new LetterFilterFormDeskWeb($id_array, $id_sezione, $this->id_applicazione, array ("groupname"), "groupname");
			$filtroaz->addStateFullParam("orderby");
			$filtroaz->createForm("Filtro per lettera", $visible);

			$visible = false;
			if (isset ($request->form['filter']))
				$visible = true;
			$filtro = new FilterFormDeskWeb($id_array, $id_sezione, $this->id_applicazione, array ("groupname"), "groupname");
			$filtro->createForm("Ricerca", $visible);
		}

		$form = new FormDeskWeb($id_sezione);
		$form->setAllowUsers(array(1));
		$form->addButtonPanel($id_sezione, "Dettaglio Gruppo", true);

		$visible = false;
		if (isset ($request->form['dettaglio']) || @ $request->form['action'] == "Dettaglio Gruppo" || @ $request->form['action'] == "Dettaglio Utente" || @ $request->form['action'] == "modifica") {
			$visible = true;
			
			if (!isset ($request->form['dettaglio']))
				$request->form['dettaglio'] = "last";

			if (isset ($request->form['formpage']))
				$request->form['lastpage'] = $request->form['formpage'];
			elseif (isset ($request->form['lastpage'])) $request->form['formpage'] = $request->form['lastpage'];

			$form->setDati(PREFIX_DB."groups", "id_group", $request->form['dettaglio']);
			$form->addMultiInputReadOnly(array ("id_group" => 1));
			$form->addMultiInputText(array ("groupname" => 2));
			$form->addStateFullParam("action");
			$form->addStateFullParam("dettaglio");
			$form->addStateFullParam("lastpage");
			$form->PreparePage();
			$form->addInputHiddenValue(array ("firstpage" => 0), "Informazioni Gruppo");
			$form->addPage(1, "Informazioni Gruppo", array (1, 2), true); //
			$form->ClosePage();
			$form->addFormToolbar($request->form['dettaglio']);
			$form->createForm("Inserisci Gruppo", $this->applicazione, $visible);
		}

		$this->add_element($tbl_dati);
		if ((!isset ($request->form['action']) && !isset ($request->form['dettaglio'])) || @ $request->form['action'] == "Elenco Gruppi") {
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