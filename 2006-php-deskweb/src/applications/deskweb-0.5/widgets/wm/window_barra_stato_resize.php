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
 * @package Window Manager
 */

/**
 * WindowStatusBarResizeDeskWeb Widget
 */

class WindowStatusBarResizeDeskWeb extends WidgetDeskWeb {

	/**
	* Constructor class
	* La classe costruttore disegna la barra di ridimensione della finestra
	* Istanzia:
	* l'immagine contentente la funzione js di ridimensionamento
	*/
	function WindowStatusBarResizeDeskWeb($id_finestra, $coordinate, $isTrackable = true) {

		$resize = new ImageDeskWeb();
		$resize->set_alt("ridimensiona finestra");
		$resize->set_src_mime("ridimensiona.gif");
		$resize->set_classname("window_tasto_ridimensiona");
		$resize->crea_tag();
		$this->add_element($resize);

		$this->open_element = "<div class='window_barra_stato_resize' ";
		global $session;
		if ($isTrackable && $session->getJavascript() && !$session->getFullscreen())
			$this->open_element .= "onmousedown='dragAndResize(\"Resize\",\"".$id_finestra."\",event,".$coordinate['top'].",".$coordinate['right'].",".$coordinate['bottom'].",".$coordinate['left'].",".$coordinate['width'].",".$coordinate['height'].",".$coordinate['z'].",".$id_finestra.",".$session->getIdDesktopActive().");'";
		else
			$this->open_element .= "style='cursor:auto;'";
		
		$this->open_element .= ">\n";
		$this->close_element = "</div>\n";

	}

}
?>