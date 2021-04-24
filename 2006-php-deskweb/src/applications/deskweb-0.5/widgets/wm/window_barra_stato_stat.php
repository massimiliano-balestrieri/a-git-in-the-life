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
 * WindowStatusBarStatDeskWeb Widget
 */

class WindowStatusBarStatDeskWeb extends WidgetDeskWeb {

	/**
	* Constructor class
	* La classe costruttore disegna la barra di stato delle statistiche
	* Istanzia:
	* la label con le statistiche della finestra
	*/
	function WindowStatusBarStatDeskWeb() {
		$spazio_disponibile = 2000000;
		//global $model;

		//if(isset($model->arr_sezioni[$numero_finestra]['figli']))
		//$numero_elementi = count($model->arr_sezioni[$numero_finestra]['figli']);
		//else
		$numero_elementi = 1;

		$stat = new TextDeskWeb();
		$stat->set_text($this->str_oggetti($numero_elementi).", ".$spazio_disponibile." di spazio libero");
		$stat->crea_tag();
		$this->add_element($stat);

		$this->open_element = "<div class='window_barra_stato_stat'>\n";
		$this->close_element = "</div>\n";

	}

	function str_oggetti($numero_elementi) {
		if ($numero_elementi == 1) {
			return $numero_elementi." oggetto";
		} else {
			return $numero_elementi." oggetti";
		}
	}

}
?>