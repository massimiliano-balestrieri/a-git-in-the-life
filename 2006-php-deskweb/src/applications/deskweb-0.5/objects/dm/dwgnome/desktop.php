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