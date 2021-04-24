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
 * @package Deskweb
 */

/**
 * Dialog Base Widget
 */
class DialogDeskWeb extends WidgetDeskWeb {

	/**
	 * writable flad
	 */
	var $writable = false;

	/**
	 * the constructor: se il contenuto non è editabile istanzia LoginDialog
	 */
	function DialogDeskWeb($id_sezione, $messaggio, $href = null) {

		global $session, $request, $model; //print_r($model->arr_contents);die();
		if (ModelDeskWeb :: isWriteable($id_sezione))
			$this->writable = true;
		//$session->getCurrentUser() != 0 && 
		if ($this->writable) {
			//die();
			$this->open_element = "<div class='bordo_dialog'>\n"."<div class='dialog'>\n";
			$this->open_element .= "<div class='dialog_barra_titolo'>".$messaggio."</div>\n"."<form method='post' action='?".$href."'>\n";
			$this->close_element = "<p><input type='submit' name='annulla' id='annulla' value='Annulla' /><input type='submit' name='salva' id='salva' value='Salva' /></p>"."</form>\n"."</div>\n"."</div>\n";
		} else {
			require_once (dirname(__FILE__)."/fm/login.php");
			$dialog = new LoginDialog();
			//$this->add_element($dialog);
			$this->open_element .= $dialog->open_element.$dialog->close_element;

		}

	}
	/**
	 * funzione ereditata da tutti i dialog per la crezione di campi testuali
	 */
	function creaInput($label, $id, $is_label = 0, $value = null) {
		global $session;
		if ($session->getCurrentUser() != 0 && $this->writable) {
			$this->open_element .= "<p>\n";
			if ($is_label == 1)
				$this->open_element .= "<label for='".$id."'>$label</label>\n";
			$this->open_element .= "<input type='text' name='".$id."' id='".$id."' value='".$value."' />\n"."</p>\n";
		}
	}
	/**
	 * funzione ereditata da tutti i dialog per la crezione di campi testuali nascosti
	 */
	function creaInputHidden($id, $value = null) {
		global $session;
		if ($session->getCurrentUser() != 0 && $this->writable) {
			$this->open_element .= "<input type='hidden' name='".$id."' id='".$id."' value='".$value."' />\n";
		}
	}
	/**
	 * funzione ereditata da tutti i dialog per la crezione del form dei permessi
	 */
	function creaGroupCheck($label, $id, $is_label = 0, $check) {
		global $session;
		if ($session->getCurrentUser() != 0 && $this->writable) {
			$this->open_element .= "<p style='overflow:auto;'>\n";
			if ($is_label == 1)
				$this->open_element .= "<label>".$label."</label>";
			while ($array_cell = each($check)) {
				if ($is_label == 1)
					$this->open_element .= "<label style='width:auto;display:inline;' for='".$array_cell['key']."'>".$array_cell['key']."</label>\n";
				$this->open_element .= "<input style='width:auto;display:inline;' type='checkbox' name='".$array_cell['key']."' id='".$array_cell['key']."' value='".$array_cell['value']."'/>\n";
			}
			$this->open_element .= "</p>\n";
		}
	}
	function creaSelectElenco($label, $name, $values, $labels = null) {
		global $session;
		if ($session->getCurrentUser() != 0 && $this->writable) {
			$this->open_element .= "<p style='overflow:auto;'>\n";
			$this->open_element .= "<label>".$label."</label>\n";
			$this->open_element .= "<select name='".$name."'>\n";
			$x = 0;
			while ($array_cell = each($values)) {
				$this->open_element .= "<option value='".$array_cell['value']."'>\n";
				if (is_array($labels))
					$this->open_element .= $labels[$x];
				else
					$this->open_element .= $array_cell['value'];
				$this->open_element .= "</option>\n";
				$x ++;
			}
			$this->open_element .= "</select>\n</p>\n";
		}

	}

}
?>