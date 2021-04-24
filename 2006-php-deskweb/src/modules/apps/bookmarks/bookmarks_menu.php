<?php
/**
 * Project:     desktop - the dekstop manager for web <br />
 *
 *
 * The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package BookmarksDeskweb
 */

/**
 * class BookmarksMenu
 */

class BookmarksMenu extends SonOfSuckerFishMenu {
	/**
	 * class constructor
	 * la classe menu estende il menu dropdown 
	 * ogni applicazione deve implementare un menu
	 */

	function BookmarksMenu($id_sezione) {
		//n 11
		global $model, $request;
		$numero_menu = 6;
		$this->prepareMenu($id_sezione, $numero_menu);
		$this->addMenu("File");
		$this->prepareItem();
		$this->addItemMenu("Link", array ("id" => $id_sezione, "n" => 11));
		$this->addItemMenu("Chiudi le altre finestre", array ("id" => $id_sezione, "n" => 5));
		$this->addItemMenu("Chiudi tutte le finestre", array ("n" => 1));
		$this->addItemMenu("Chiudi", array ("id" => $id_sezione, "action" => ACTION_CLOSE_CONTENT));
		$this->CloseItem();
		$this->closeMenu();
		$this->addMenu("Modifica");
		$this->prepareItem();
		$this->addItemMenu("Taglia");
		$this->addItemMenu("Copia");
		$this->addItemMenu("Incolla");
		$this->addItemMenu("Seleziona tutto");
		$this->addItemMenu("Seleziona modello");
		$this->addItemMenu("Incolla");
		$this->addItemMenu("Duplica");
		$this->addItemMenu("Crea collegamento");
		$this->addItemMenu("Rinomina");
		$this->addItemMenu("Sposta nel cestino");
		$this->CloseItem();
		$this->closeMenu();
		$this->addMenu("Visualizza");
		$this->prepareItem();
		$this->addItemMenu("Aggiorna");
		$this->addItemMenu("Barra Strumenti");
		$this->addItemMenu("Barra di stato");
		$this->addItemMenu("Usa impostazioni predefinite");
		$this->addItemNested("Disponi oggetti");
		$this->prepareItem();
		$this->addItemMenu("Per Nome");
		$this->addItemMenu("Per Tipo");
		$this->addItemMenu("Per Data");
		$this->CloseItem();
		$this->addItemMenu("Vedi come lista");
		$this->addItemMenu("Vedi come icone");
		$this->CloseItem();
		$this->closeMenu();
		$this->addMenu("Vai");
		$this->prepareItem();
		$this->addItemMenu("Cartella genitrice");
		$this->addItemMenu("Avanti");
		$this->addItemMenu("Indietro");
		/*if (is_array($model->arr_menu)) {
			reset($model->arr_menu);
			for ($x = 0; $x <= count($model->arr_menu) - 1; $x ++) {
				$this->addItemMenu($model->arr_menu[$x]['node']);
			}
		}*/
		$this->addItemMenu("Vedi come lista");
		$this->addItemMenu("Vedi come icone");
		$this->CloseItem();
		$this->closeMenu();
		$this->addMenu("Segnalibri");
		$this->prepareItem();
		$this->addItemMenu("Aggiungi Segnalibro");
		$this->CloseItem();
		$this->addMenu("?");
		$this->prepareItem();
		$this->addItemMenu("Informazioni");
		$this->CloseItem();
		$this->closeMenu();
		$this->SonOfSuckerFishMenu($id_sezione);
		//
		//$this->prepareItemMenu("Nuova Directory");
		//$this->prepareItemMenu("Nuovo File");
		//$this->addMenu($id_sezione);

	}

}
?>