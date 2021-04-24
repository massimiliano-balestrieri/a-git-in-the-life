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
 * @package DWNanoDeskweb
 */

/**
 * class DWNanoMenu
 */
class DWNanoMenu extends SonOfSuckerFishMenu {

	/**
	* class constructor
	* la classe menu estende il menu dropdown 
	* ogni applicazione deve implementare un menu
	*/
	function DWNanoMenu($id_sezione) {
		global $model, $request;
		$numero_menu = 2;
		$this->prepareMenu($id_sezione, $numero_menu);
		$this->addMenu("File");
		$this->prepareItem();
		$this->addItemMenu("Nuovo", array ("id" => $id_sezione, "w" => 1));
		$this->addItemMenu("Modifica", array ("id" => $id_sezione, "w" => 2));
		if ($request->w == 2) {
			$this->addItemMenuJS("Salva", "javascript:dom(\"nano\",\"".$id_sezione."\").submit();");
			$this->addItemMenu("Salva con nome", array ("id" => $id_sezione, "w" => 4));
			$this->addItemMenu("Annulla", "id=".array ("id" => $id_sezione));
		}
		$this->addItemMenu("Chiudi le altre finestre", array ("id" => $id_sezione, "action" => ACTION_CLOSE_OTHER_CONTENT));
		$this->addItemMenu("Chiudi tutte le finestre", array ("action" => ACTION_CLOSE_CONTENTS));
		$this->addItemMenu("Chiudi", array ("id" => $id_sezione, "action" => ACTION_CLOSE_CONTENT));
		$this->CloseItem();
		$this->closeMenu();

		$this->addMenu("Aiuto");
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