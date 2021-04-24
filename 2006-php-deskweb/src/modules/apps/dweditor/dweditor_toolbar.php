<?php


/**
 * Project:     deskweb - the dekstop manager for web <br />
 *
 *
 * The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package DwEditorDeskweb
 */

/**
 * class DwEditorToolbar
 */

class DwEditorToolbar extends ToolbarDeskWeb {

	/**
	* class constructor
	*/
	function DwEditorToolbar($id_sezione) {
		$this->ToolbarDeskWeb();
		$icone = new ButtonDeskWeb();
		global $model, $request;
		if ($model->is_sys($id_sezione)) {
			$icone->make($src = "add.png", $dim = "22x22", $name = "p", $action = ACTION_NEW_DWEDITOR, $alt = "nuovo");
		} else {
			if ($request->p == ACTION_EDIT_DWEDITOR || @ $request->form['p'] == ACTION_EDIT_DWEDITOR) {
				$icone->make($src = "save.png", $dim = "22x22", $name = "p", $action = ACTION_SAVE_DWEDITOR, $alt = "nuovo");
			} else {
				$icone->make($src = "kate.png", $dim = "22x22", $name = "p", $action = ACTION_EDIT_DWEDITOR, $alt = "nuovo");
			}
			$icone->make($src = "editdelete.png", $dim = "22x22", $name = "n", $action = ACTION_DELETE_CONTENT, $alt = "elimina");
			$icone->make($src = "kgpg.png", $dim = "22x22", $name = "p", $action = ACTION_PROPERTIES_DWEDITOR, $alt = "propriet&agrave;", "disabled");
		}

		$icone->separator();

		$icone->make($src = "1leftarrow.png", $dim = "22x22", $name = "n", $action = ACTION_LEFT, $alt = "indietro", "SessionDeskWeb::existPreviousRequest()");
		$icone->make($src = "1rightarrow.png", $dim = "22x22", $name = "n", $action = ACTION_RIGHT, $alt = "avanti", "SessionDeskWeb::existNextRequest()");
		$icone->make($src = "1uparrow.png", $dim = "22x22", $name = "n", $action = ACTION_UP, $alt = "su");
		$icone->make($src = "reload3.png", $dim = "22x22", $name = "n", $action = ACTION_RELOAD, $alt = "aggiorna");

		$icone->separator();

		$icone->make($src = "gohome.png", $dim = "22x22", $name = "n", $action = ACTION_GO_HOME, $alt = "home");
		$icone->make($src = "system.png", $dim = "22x22", $name = "n", $action = ACTION_GO_PUBLIC, $alt = "public");

		$icone->separator();

		$icone->make($src = "help.png", $dim = "22x22", $name = "n", $action = ACTION_GO_HELP, $alt = "aiuto", "disabled");

		$this->add_element($icone);
	}
	function add_element($object) {
		$this->open_element .= $object->open_element.$object->close_element;
	}

}
?>