<?php


/**
 * Project:     deskweb - the dekstop manager for web <br />
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * You may contact the authors of Deskweb by emial at: <br />
 * io@maxb.net <br />
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
 * @package AddressbookDeskweb
 */

/**
 * class AddressbookPanelDeskWeb
 */

class AddressbookPanelDeskWeb extends WidgetDeskWeb {
	
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
	function AddressbookPanelDeskWeb($id_array, $id_sezione, $model) {
		
		$this->id_applicazione = "applicazione_".$id_sezione;		
		$this->applicazione = "addressbook";		
		$this->panel($id_sezione);
		
		global $request;
		require_once ("addressbook_menu.php");
		$barra_menu = new AddressbookMenu($id_sezione);
		$this->open_element .= $barra_menu->open_element;

		$visible = true;
		if (isset ($request->form['action']) && strlen($request->form['action']))
			$visible = false;
		
		$tbl_dati = new TableDeskWeb($id_array, $id_sezione,$this->id_applicazione, array ("id_addressbook", "firstname", "surname", "address", "cap", "city", "tel", "cell", "mail"), "id_addressbook", true);
		$tbl_dati->setPaging($model->num_record,$model->paging);
		$tbl_dati->set_classname("tblwidget");
		$tbl_dati->setDati($model->arr_addressbook);
		$tbl_dati->createTable("Elenco Contatti",$visible);

		$visible = false;
		if (isset ($request->form['firstletter']))
			$visible = true;
		$filtroaz = new LetterFilterFormDeskWeb($id_array, $id_sezione,$this->id_applicazione, array ("firstname", "surname", "address", "city", "mail"), "surname");
		$filtroaz->createForm("Filtro per lettera", $visible);

		$visible = false;
		if (isset ($request->form['filter']))
			$visible = true;
		$filtro = new FilterFormDeskWeb($id_array, $id_sezione,$this->applicazione, array ("id_addressbook", "firstname", "surname", "address", "cap", "city", "tel", "cell", "mail"), "surname");
		$filtro->createForm("Ricerca", $visible);

		$visible = false;
		if (isset ($request->form['invia']))
			$visible = true;
		$form = new FormDeskWeb($id_sezione);
		$form->addMultiInputText(array ("firstname" => 1, "surname" => 2, "address" => 3, "cap" => 4, "city" => 5, "tel" => 6, "cell" => 7, "mail" => 8));
		$form->createForm("Inserisci Contatto", "inserisci", $this->applicazione,$visible);

		$visible = false;
		if (isset ($request->form['action']) && isset ($request->form['dettaglio'])) {
			switch ($request->form['action']) {
				case "modifica" :
					$visible = true;
					$form = new FormDeskWeb($id_sezione);
					$form->setDati(PREFIX_DB."addressbook","id_addressbook",$request->form['dettaglio']);
					$form->addMultiInputHidden(array ("id_addressbook" => 0));
					$form->addMultiInputText(array ("firstname" => 1, "surname" => 2, "address" => 3, "cap" => 4, "city" => 5, "tel" => 6, "cell" => 7, "mail" => 8));
					$form->createForm("Modifica Contatto", "modifica", $this->applicazione,$visible);
					break;
				case "elimina" :
					$visible = true;
					$form = new FormDeskWeb($id_sezione);
					$form->setDati(PREFIX_DB."addressbook","id_addressbook",$request->form['dettaglio']);
					$form->addMultiInputHidden(array ("id_addressbook" => 0));
					$form->addMultiInputText(array ("firstname" => 1, "surname" => 2, "address" => 3, "cap" => 4, "city" => 5, "tel" => 6, "cell" => 7, "mail" => 8));
					$form->createForm("Elimina Contatto", "elimina", $this->applicazione,$visible);
					break;
			}
		}

		$this->add_element($tbl_dati);
		$this->add_element($filtroaz);
		$this->add_element($filtro);
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