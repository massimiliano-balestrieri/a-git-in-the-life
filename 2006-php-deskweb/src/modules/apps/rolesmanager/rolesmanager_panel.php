<?php


/**
 * Project:     deskweb - the desktop manager for web <br />
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
 * @package RolesmanagerDeskweb
 */

/**
 * class RolesmanagerPanelDeskWeb
 */

class RolesmanagerPanelDeskWeb extends WidgetDeskWeb {

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
	function RolesmanagerPanelDeskWeb($id_array, $id_sezione, $model) {

		$this->id_applicazione = "applicazione_".$id_sezione;
		$this->applicazione = "rolesmanager";
		$this->panel($id_sezione);

		global $request;
		require_once (dirname(__FILE__)."/rolesmanager_menu.php");
		$barra_menu = new RolesmanagerMenu($id_sezione);
		$this->open_element .= $barra_menu->open_element;

		$main = new ContainerDeskWeb();
		
		$left = new ContainerDeskWeb();
		$left->setFloat("left");
		$left->setWidth("20%");
		$left->make();
		
		$visible = true;
		$formusers = new FormDeskWeb($id_sezione);
		$formusers->addTreeButton($nome_tabella = PREFIX_DB."users", $campi = array ("id_user", "username"),$pk = "id_user");
		$formusers->createForm("Elenco Utenti", false, $this->applicazione, $visible);
		$left->add_element($formusers);
		
		
		$right = new ContainerDeskWeb();
		$right->setFloat("left");
		$right->setWidth("78%");
		$right->make();
		if (isset ($request->form['id_user']) && $request->form['id_user'] != 'default') {
			
			$visible = true;
			if (isset ($request->form['action']) && strlen($request->form['action']))
				$visible = false;

			$tbl_dati = new TableDeskWeb($id_array, $id_sezione, $this->id_applicazione, array ("id_role","name_group", "role"), "id_role", true);
			$tbl_dati->setPaging($model->num_record, $model->paging);
			$tbl_dati->set_classname("tblwidget");
			$tbl_dati->setDati($model->arr_rolesmanager,$del = true,$upd = false);
			$tbl_dati->addStateFullParam("id_user");
			$tbl_dati->createTable("Elenco Ruoli", $visible);
			$right->add_element($tbl_dati);
		
			$visible = false;
			if (isset ($request->form['invia']))
				$visible = true;
			$form = new FormDeskWeb($id_sezione);
			$form->addInputHiddenValue(array ("fk_user" => 0), $request->form['id_user']);
			$form->addSelectDb($nome_tabella = PREFIX_DB."groups", $campi = array ("id_group", "name_group"), $label_scelta = "Scegli un gruppo", $fk = true);
			$form->addMultiInputText(array ("role" => 1));
			$form->addStateFullParam("id_user");
			$form->createForm("Inserisci Ruolo", "inserisci", $this->applicazione, $visible);
			
			$visible = false;
			if (isset ($request->form['action']) && isset ($request->form['dettaglio'])) {
				switch ($request->form['action']) {
					case "elimina" :
						$visible = true;
						$form = new FormDeskWeb($id_sezione);
						$form->setDati(PREFIX_DB."roles", "id_role", $request->form['dettaglio']);
						$form->addMultiInputHidden(array ("id_role" => 0));
						$form->addSelectDb($nome_tabella = PREFIX_DB."groups", $campi = array ("id_group", "name_group"), $label_scelta = "Scegli un gruppo", $fk = true);
						$form->addMultiInputText(array ("role" => 1));
						$form->addStateFullParam("id_user");
						$form->createForm("Elimina Ruolo", "elimina", $this->applicazione, $visible);
						break;

				}
			}
			$right->add_element($form);
			
			
		}
		//$right->close_element .= "<pre style='clear:both;'>".print_r($request->form,true)."</pre>";
		
		
		$main->add_element($left);
		$main->add_element($right);
		
		$this->add_element($main);
		
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