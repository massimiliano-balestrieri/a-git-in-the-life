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
 * @package Weblets
 */

/**
 * classe WebletNotes
 */
class WebletNotes extends WidgetDeskWeb {
	/**
	 * la weblet è un'applicazione che non estende window.
	 * appare appiccicata al desktop
	 * 
	 * in questo caso la weblet è complessa
	 * istanzia
	 * 
	 * modello weblet
	 * passa al panel il contenuto 
	 */
	function WebletNotes() {
		require_once ("notes_model.php");
		$model = new NotesModel();

		if(count($model->arr_notes)>0)
		{
			require_once ("notes_panel.php");
			$panel = new WebletNotesPanel($model->arr_notes);
			$this->add_element($panel);
		}
		$this->open_element = "<div id='notes'>\n";
		$this->close_element = "</div>\n";
	}
}
?>