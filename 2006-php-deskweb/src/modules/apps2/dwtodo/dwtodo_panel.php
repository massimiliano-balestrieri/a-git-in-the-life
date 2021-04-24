<?php


/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package TodoDeskweb
 */

/**
 * class TodoPanelDeskWeb
 */

class DWTodoPanelDeskWeb extends WidgetDeskWeb {

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
	function DWTodoPanelDeskWeb($id_array, $id_sezione, $model) {

		require_once ($_SERVER['DOCUMENT_ROOT']."/".DIR_DESKWEB."/widgets/fm/include_fm.php");

		$this->id_applicazione = "applicazione_".$id_sezione;
		$this->applicazione = "dwtodo";
		$this->panel($id_sezione);

		global $request, $session;
		if (!($session->getUserAgent() == 'ie' && !$session->getJavascript())) {
			require_once (dirname(__FILE__)."/dwtodo_menu.php");
			$barra_menu = new DWTodoMenu($id_sezione);
			$this->open_element .= $barra_menu->open_element;
		}

		$visible = false;
		$tbl_dati = new TableDeskWeb($id_array, $id_sezione, $this->id_applicazione, array ("id_todo", "attivita", "scadenza", "percentuale"), "id_todo", true);
		$tbl_dati->addButtonPanel($id_sezione, "Elenco Attivita", true);

		if ((!isset ($request->form['action']) && !isset ($request->form['dettaglio'])) || @ $request->form['action'] == "Elenco Attivita") {
			$visible = true;

			$tbl_dati->InitTable();
			$tbl_dati->setPaging($model->num_record, $model->paging);
			$tbl_dati->set_classname("tblwidget");
			$tbl_dati->setField("percentuale", "progressbar");
			$tbl_dati->setDati($model->arr_todo);
			$tbl_dati->createTable("Elenco Attivita", $visible);
		}

		$form = new FormDeskWeb($id_sezione,false);
		$form->addButtonPanel($id_sezione, "Dettaglio Attivita", true);

		$visible = false;
		if (isset ($request->form['dettaglio']) || @ $request->form['action'] == "Dettaglio Nodo" || @ $request->form['action'] == "Dettaglio Attivita" || @ $request->form['action'] == "modifica") {

			if (!isset ($request->form['dettaglio']))
				$request->form['dettaglio'] = "last";

			if (isset ($request->form['formpage']))
				$request->form['lastpage'] = $request->form['formpage'];
			elseif (isset ($request->form['lastpage'])) $request->form['formpage'] = $request->form['lastpage'];

			$visible = true;

			$form->setDati(PREFIX_DB."todo", "id_todo", $request->form['dettaglio']);
			$form->addMultiInputReadOnly(array ("id_todo" => 1));
			$form->addMultiInputText(array ("attivita" => 2, "percentuale" => 4));
			$form->addTextArea(array ("descrizione" => 5));
			$form->addDateField(3,"scadenza");
			$form->addStateFullParam("action");
			$form->addStateFullParam("dettaglio");
			$form->addStateFullParam("lastpage");
			$form->PreparePage();
			$form->addInputHiddenValue(array ("firstpage" => 0), "Informazioni Attivita");
			$form->addPage(2, "Informazioni Attivita", array (1, 2, 3, 4), true); //
			$form->addPage(2, "Descrizione", array (5));
			$form->ClosePage();
			$form->addFormToolbar($request->form['dettaglio']);
			$form->createForm("Dettaglio Attivita", $this->applicazione, $visible);
		}
		$this->add_element($tbl_dati);
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