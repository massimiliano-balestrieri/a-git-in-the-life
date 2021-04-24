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
 * @package SkeletonDeskweb
 */

/**
 * class SkeletonMenu
 */

class SkeletonMenu extends SonOfSuckerFishMenu {
	/**
	 * class constructor
	 * la classe menu estende il menu dropdown 
	 * ogni applicazione deve implementare un menu
	 */

	function SkeletonMenu($id_sezione) {
		global $model, $request;
		$numero_menu = 2;
		$this->prepareMenu($id_sezione, $numero_menu);
		$this->addMenu("File");
		$this->prepareItem();
		$this->addItemMenu("Chiudi le altre finestre", array ("id" => $id_sezione, "n" => 5));
		$this->addItemMenu("Chiudi tutte le finestre", array ("id" => $request->id, "n" => 1));
		$this->addItemMenu("Chiudi", array ("id" => $id_sezione, "n" => 2));
		$this->CloseItem();
		$this->closeMenu();
		$this->addMenu("?");
		$this->prepareItem();
		$this->addItemMenu("Informazioni");
		$this->CloseItem();
		$this->closeMenu();
		$this->SonOfSuckerFishMenu($id_sezione);
	}

}
?>