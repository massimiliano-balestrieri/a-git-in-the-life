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
 * @package DWNautilusDeskweb
 */

/**
 * class DWNautilusToolbar
 */

class DWNautilusToolbar extends WindowToolbarDeskWeb {

	/**
	* class constructor
	*/
	function DWNautilusToolbar($id_sezione) {
		$this->WindowToolbarDeskWeb();
		$icone = new ButtonDeskWeb();

		$icone->make($src = "add.png", $dim = "22x22", $name = "n", $action = ACTION_NEW, $alt = "nuovo");
		$icone->make($src = "kgpg.png", $dim = "22x22", $name = "n", $action = ACTION_PROPERTIES, $alt = "propriet&agrave;", "disabled");

		$icone->separator();

		global $session;
		if (!$session->allowMultiWindow()) {
			$icone->make($src = "1leftarrow.png", $dim = "22x22", $name = "n", $action = ACTION_LEFT, $alt = "indietro", "SessionDeskWeb::existPreviousRequest()");
			$icone->make($src = "1rightarrow.png", $dim = "22x22", $name = "n", $action = ACTION_RIGHT, $alt = "avanti", "SessionDeskWeb::existNextRequest()");
			$icone->make($src = "1uparrow.png", $dim = "22x22", $name = "n", $action = ACTION_UP, $alt = "su");
		}
		
		$icone->make($src = "reload3.png", $dim = "22x22", $name = "n", $action = ACTION_RELOAD, $alt = "aggiorna");
		
		$icone->separator();

		$icone->make($src = "gohome.png", $dim = "22x22", $name = "n", $action = ACTION_GO_HOME, $alt = "home");
		$icone->make($src = "system.png", $dim = "22x22", $name = "n", $action = ACTION_GO_PUBLIC, $alt = "public");

		$icone->separator();

		$icone->make($src = "editcut.png", $dim = "22x22", $name = "n", $action = ACTION_CUT, $alt = "taglia");
		$icone->make($src = "editcopy.png", $dim = "22x22", $name = "n", $action = ACTION_COPY, $alt = "copia");
		$icone->make($src = "editpaste.png", $dim = "22x22", $name = "n", $action = ACTION_PASTE, $alt = "incolla", "SessionDeskWeb::existClipboard()");
		$icone->make($src = "editdelete.png", $dim = "22x22", $name = "n", $action = ACTION_DELETE, $alt = "elimina");

		$icone->separator();

		$icone->make($src = "view_icon.png", $dim = "22x22", $name = "n", $action = ACTION_VIEW_ICON, $alt = "icone", "SessionDeskWeb::checkCurrentView(VIEW_ICON)");
		$icone->make($src = "view_detailed.png", $dim = "22x22", $name = "n", $action = ACTION_VIEW_DETAILED, $alt = "dettagli", "SessionDeskWeb::checkCurrentView(VIEW_DETAILED)");
		$icone->make($src = "view_fullscreen.png", $dim = "22x22", $name = "n", $action = ACTION_VIEW_FULLSCREEN, $alt = "pieno schermo");

		$icone->separator();

		$icone->make($src = "help.png", $dim = "22x22", $name = "n", $action = ACTION_GO_HELP, $alt = "aiuto", "disabled");
		$icone->preparse();
		$this->add_element($icone);
	}
	function add_element($object) {
		$this->open_element .= $object->open_element.$object->close_element;
	}

}
?>