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
 * @package WishlistDeskweb
 */

/**
 * class WishlistPanelDeskWeb
 */

class DWWishlistPanelDeskWeb extends WidgetDeskWeb {

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
	function DWWishlistPanelDeskWeb($id_array, $id_sezione, $model) {

		require_once ($_SERVER['DOCUMENT_ROOT']."/".DIR_DESKWEB."/widgets/fm/include_fm.php");

		$this->id_applicazione = "applicazione_".$id_sezione;
		$this->applicazione = "dwwishlist";
		$this->panel($id_sezione);

		global $request, $session;
		if (!($session->getUserAgent() == 'ie' && !$session->getJavascript())) {
			require_once (dirname(__FILE__)."/dwwishlist_menu.php");
			$barra_menu = new DWWishlistMenu($id_sezione);
			$this->open_element .= $barra_menu->open_element;
		}

		$visible = true;
		$tbl_dati = new TableDeskWeb($id_array, $id_sezione, $this->id_applicazione, array ("id_wishlist", "titolo", "data", "esaudito", "fk_user"), "id_wishlist", true);
		$tbl_dati->addButtonPanel($id_sezione, "Elenco Wishlist", true);

		if ((!isset ($request->form['action']) && !isset ($request->form['dettaglio'])) || @ $request->form['action'] == "Elenco Wishlist") {
			$visible = true;

			$tbl_dati->InitTable();
			$tbl_dati->setPaging($model->num_record, $model->paging);
			$tbl_dati->set_classname("tblwidget");
			$tbl_dati->setField("esaudito", "check");
			$tbl_dati->setDati($model->arr_wishlist);
			$tbl_dati->createTable("Elenco Wishlist", $visible);
		}

		$form = new FormDeskWeb($id_sezione,false);
		$form->addButtonPanel($id_sezione, "Dettaglio Wishlist", true);

		$visible = false;
		if (isset ($request->form['dettaglio']) || @ $request->form['action'] == "Dettaglio Nodo" || @ $request->form['action'] == "Dettaglio Wishlist" || @ $request->form['action'] == "modifica") {

			if (!isset ($request->form['dettaglio']))
				$request->form['dettaglio'] = "last";

			if (isset ($request->form['formpage']))
				$request->form['lastpage'] = $request->form['formpage'];
			elseif (isset ($request->form['lastpage'])) $request->form['formpage'] = $request->form['lastpage'];

			$visible = true;

			$form->setDati(PREFIX_DB."wishlist", "id_wishlist", $request->form['dettaglio']);
			$form->addMultiInputReadOnly(array ("id_wishlist" => 1,"fk_user" => 6));
			$form->addMultiInputText(array ("titolo" => 2, "esaudito" => 4));
			$form->addTextArea(array ("descrizione" => 5));
			$form->addDateField(3,"data");
			$form->addStateFullParam("action");
			$form->addStateFullParam("dettaglio");
			$form->addStateFullParam("lastpage");
			$form->PreparePage();
			$form->addInputHiddenValue(array ("firstpage" => 0), "Informazioni Wishlist");
			$form->addPage(2, "Informazioni Wishlist", array (1, 2, 3, 4,6), true); //
			$form->addPage(2, "Descrizione", array (5));
			$form->ClosePage();
			$form->addFormToolbar($request->form['dettaglio']);
			$form->createForm("Dettaglio Wishlist", $this->applicazione, $visible);
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