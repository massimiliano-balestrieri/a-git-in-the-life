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
 * @package DWAddressbookDeskWeb
 */

/**
 * class DWAddressbookPanelDeskWeb
 */

class DWAddressbookPanelDeskWeb extends WidgetDeskWeb {

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
	function DWAddressbookPanelDeskWeb($id_array, $id_sezione, $model) {

		require_once ($_SERVER['DOCUMENT_ROOT'] . "/". DIR_DESKWEB."/widgets/fm/include_fm.php");

		$this->id_applicazione = "applicazione_".$id_sezione;
		$this->applicazione = "dwaddressbook";
		$this->panel($id_sezione);

		global $request, $session;
		if (!($session->getUserAgent() == 'ie' && !$session->getJavascript())) {

			require_once (dirname(__FILE__)."/dwaddressbook_menu.php");
			$barra_menu = new DWAddressbookMenu($id_sezione);
			$this->open_element .= $barra_menu->open_element;
		}

		$visible = false;
		$tbl_dati = new TableDeskWeb($id_array, $id_sezione, $this->id_applicazione, array ("id_addressbook", "nome", "cognome", "email", "azienda","telefono_ufficio","telefono_cellulare"),"id_addressbook", true);
		$tbl_dati->addButtonPanel($id_sezione, "Elenco Contatti", true);
		if ((!isset ($request->form['action']) && !isset ($request->form['dettaglio'])) || @ $request->form['action'] == "Elenco Contatti") {
			$visible = true;
			$tbl_dati->InitTable();
			$tbl_dati->setPaging($model->num_record, $model->paging);
			$tbl_dati->set_classname("tblwidget");
			$tbl_dati->setDati($model->arr_addressbook);
			$tbl_dati->addStateFullParam("filter");
			$tbl_dati->addStateFullParam("filterwhere");
			$tbl_dati->addStateFullParam("firstletter");
			$tbl_dati->addStateFullParam("firstletterwhere");
			$tbl_dati->createTable("Elenco Contatti", $visible);

			$visible = false;
			if (isset ($request->form['firstletter']))
				$visible = true;
			$filtroaz = new LetterFilterFormDeskWeb($id_array, $id_sezione, $this->id_applicazione, array ("nome", "cognome","email", "azienda"), "cognome");
			$filtroaz->addStateFullParam("orderby");
			$filtroaz->createForm("Filtro per lettera", $visible);

			$visible = false;
			if (isset ($request->form['filter']))
				$visible = true;
			$filtro = new FilterFormDeskWeb($id_array, $id_sezione, $this->applicazione, array ("id_addressbook", "nome", "cognome", "email", "azienda"), "cognome");
			$filtro->createForm("Ricerca", $visible);
		}
		$form = new FormDeskWeb($id_sezione, false);
		$form->addButtonPanel($id_sezione, "Dettaglio Contatto", true);

		$visible = false;
		if (isset ($request->form['dettaglio']) || @ $request->form['action'] == "Dettaglio Contatto" || @ $request->form['action'] == "Dettaglio Contatto" || @ $request->form['action'] == "modifica") {
			
			$visible = true;
			
			if (!isset ($request->form['dettaglio']))
				$request->form['dettaglio'] = "last";

			if (isset ($request->form['formpage']))
				$request->form['lastpage'] = $request->form['formpage'];
			elseif (isset ($request->form['lastpage'])) $request->form['formpage'] = $request->form['lastpage'];

			$form->setDati(PREFIX_DB."addressbook", "id_addressbook", $request->form['dettaglio'], array ("note"));
			//page 1 Generali
			$form->addMultiInputReadOnly(array ("id_addressbook" => 1));
			$form->addMultiInputText(array ("nome" => 2, "cognome" => 3));
			$form->addMultiInputText(array ("homepage" => 4, "email" => 5));
			$form->addDateField(6,"data_nascita");
			//page 2 Ufficio
			$form->addMultiInputText(array ("azienda" => 7, "azienda_titolo" =>8));
			$form->addMultiInputText(array ("ufficio_indirizzo" => 9, "ufficio_localita" => 10, "ufficio_cap" => 11));
			//page 3 Abitazione
			$form->addMultiInputText(array ("abitazione_indirizzo" => 12, "abitazione_localita" => 13, "abitazione_cap" => 14));
			//page 4 Telefoni
			$form->addMultiInputText(array ("telefono_ufficio" => 15, "fax_ufficio" => 16));
			$form->addMultiInputText(array ("telefono_cellulare" => 17, "cercapersone" => 18));
			$form->addMultiInputText(array ("telefono_abitazione" => 19, "fax_abitazione" => 20));
			//page 5 Extra
			$form->addTextArea(array ("note" => 21));
			$form->addStateFullParam("action");
			$form->addStateFullParam("dettaglio");
			$form->addStateFullParam("lastpage");
			$form->PreparePage();
			$form->addInputHiddenValue(array ("firstpage" => 0), "Contatto");
			$form->addPage(5, "Contatto", array (1, 2, 3, 4,5,6), true); //
			$form->addPage(5, "Ufficio", array (7,8,9,10,11));
			$form->addPage(5, "Abitazione", array (12,13,14));
			$form->addPage(5, "Telefoni", array (15,16,17,18,19,20));
			$form->addPage(5, "Extra", array (21));
			$form->ClosePage();
			$form->addFormToolbar($request->form['dettaglio']);
			$form->createForm("Dettaglio Contatto", $this->applicazione, $visible);
		}
		$this->add_element($tbl_dati);
		if ((!isset ($request->form['action']) && !isset ($request->form['dettaglio'])) || @ $request->form['action'] == "Elenco Contatti") {
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