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
 * @package DesktopManager
 */

/**
 * gnomeDesktop Widget
 */
class DWgnomeDesktop extends WidgetDeskWeb {

	/**
	 * Class constructor
	 * Istanzia:
	 * 
	 * menu sx (oggetto gnome)
	 * menu dx (oggetto gnome)
	 * 
	 * content (oggetto generale)
	 * 
	 * weblet news
	 * weblet calendar
	 * 
	 * 
	 */
	function DWgnomeDesktop() {

		global $model, $request, $session;

		$menu_sx = new panelIconeSx();
		$menu_dx = new panelIconeDx();

		//$news_project = new WebletNewsProject();
		//$notes = new WebletNotes();
		$content = new ContentDeskWeb();

		$this->add_element($menu_sx);
		//$this->add_element($news_project);
		//$this->add_element($notes);
		$this->add_element($menu_dx);
		$this->add_element($content);
		
		$this->text_apertura = "<div id='content'>\n";
		$this->text_chiusura = "</div>\n";

	}

}
?>