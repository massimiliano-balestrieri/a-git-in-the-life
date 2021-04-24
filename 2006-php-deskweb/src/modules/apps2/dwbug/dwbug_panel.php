<?php
/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package BugDeskweb
 */

/**
 * class BugPanelDeskWeb
 */

class DWBugPanelDeskWeb extends WidgetDeskWeb {

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
	function DWBugPanelDeskWeb($id_array, $id_sezione, $model) {

		require_once ($_SERVER['DOCUMENT_ROOT']."/".DIR_DESKWEB."/widgets/fm/include_fm.php");

		$this->id_applicazione = "applicazione_".$id_sezione;
		$this->applicazione = "dwbug";
		$this->panel($id_sezione);

		global $request, $session;
		if (!($session->getUserAgent() == 'ie' && !$session->getJavascript())) {
			require_once (dirname(__FILE__)."/dwbug_menu.php");
			$barra_menu = new DWBugMenu($id_sezione);
			$this->open_element .= $barra_menu->open_element;
		}

		$visible = true;
		$tbl_dati = new TableDeskWeb($id_array, $id_sezione, $this->id_applicazione, array ("id_bug", "titolo", "data", "risolto", "fk_user"), "id_bug", true);
		$tbl_dati->addButtonPanel($id_sezione, "Elenco Bug", true);

		if ((!isset ($request->form['action']) && !isset ($request->form['dettaglio'])) || @ $request->form['action'] == "Elenco Bug") {
			$visible = true;

			$tbl_dati->InitTable();
			$tbl_dati->setPaging($model->num_record, $model->paging);
			$tbl_dati->set_classname("tblwidget");
			$tbl_dati->setField("risolto", "check");
			$tbl_dati->setDati($model->arr_bug);
			$tbl_dati->createTable("Elenco Bug", $visible);
		}

		$form = new FormDeskWeb($id_sezione,false);
		$form->addButtonPanel($id_sezione, "Dettaglio Bug", true);

		$visible = false;
		if (isset ($request->form['dettaglio']) || @ $request->form['action'] == "Dettaglio Nodo" || @ $request->form['action'] == "Dettaglio Bug" || @ $request->form['action'] == "modifica") {

			if (!isset ($request->form['dettaglio']))
				$request->form['dettaglio'] = "last";

			if (isset ($request->form['formpage']))
				$request->form['lastpage'] = $request->form['formpage'];
			elseif (isset ($request->form['lastpage'])) $request->form['formpage'] = $request->form['lastpage'];

			$visible = true;

			$form->setDati(PREFIX_DB."bug", "id_bug", $request->form['dettaglio']);
			$form->addMultiInputReadOnly(array ("id_bug" => 1,"fk_user" => 6));
			$form->addMultiInputText(array ("titolo" => 2, "risolto" => 4));
			$form->addTextArea(array ("descrizione" => 5));
			$form->addDateField(3,"data");
			$form->addStateFullParam("action");
			$form->addStateFullParam("dettaglio");
			$form->addStateFullParam("lastpage");
			$form->PreparePage();
			$form->addInputHiddenValue(array ("firstpage" => 0), "Informazioni Bug");
			$form->addPage(2, "Informazioni Bug", array (1, 2, 3, 4,6), true); //
			$form->addPage(2, "Descrizione", array (5));
			$form->ClosePage();
			$form->addFormToolbar($request->form['dettaglio']);
			$form->createForm("Dettaglio Bug", $this->applicazione, $visible);
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