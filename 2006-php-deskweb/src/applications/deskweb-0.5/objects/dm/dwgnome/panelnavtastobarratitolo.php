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
 * @package DesktopManager
 */

/**
 * TitoloTastoPanelNav Widget
 */
class TitoloTastoPanelNav extends WidgetDeskWeb {
	
	/**
	 * Class constructor
	 * Istanzia:
	 * Icona del tasto
	 * Testo del tasto
	 */
	function TitoloTastoPanelNav($id_finestra, $numero_tasti, $nome_finestra, $icona) {
		
		$icona_sezione = new ImageDeskWeb();
		$icona_sezione->set_classname("icona_sezione");
		$icona_sezione->set_alt("icona sezione");
		$icona_sezione->set_dim("12x12");
		$icona_sezione->set_src_mime($icona);
		$icona_sezione->crea_tag();
		
		$titolo_sezione = new TextDeskWeb();
		$titolo_sezione->set_classname("titolo_sezione");
		$titolo_sezione->set_text($this->_tronca_lunghezza($numero_tasti, $nome_finestra));
		$titolo_sezione->crea_tag();
		$this->add_element($icona_sezione);
		$this->add_element($titolo_sezione);

		$this->text_apertura = "<div id='panel_nav_tasto_barra_titolo_".$id_finestra."' class='panel_nav_tasto_barra_titolo'>\n";
		$this->text_chiusura = "</div>\n";
	}
	/**
	 * metodo per troncare la lunghezza del testo in base al numero dei tasti
	 */
	function _tronca_lunghezza($numero_tasti, $nome_finestra) {
		if ($numero_tasti > 5 && strlen($nome_finestra) > 8) {
			return substr($nome_finestra, 0, 8)."...";
		} else {
			return $nome_finestra;
		}
	}
}
?>