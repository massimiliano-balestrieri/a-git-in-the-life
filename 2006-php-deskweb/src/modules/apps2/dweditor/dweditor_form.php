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
 * @package DwEditorDeskweb
 */

/**
 * class DwEditorFormDeskWeb
 */

class DwEditorFormDeskWeb extends FormDeskWeb {

	/**
	 * class constructor
	 */
	function DwEditorFormDeskWeb($id_sezione, $contenuto) {

		//global $request;
		$auth = $this->FormDeskWeb($id_sezione);
		
		if ($auth) {
			require_once ($_SERVER['DOCUMENT_ROOT']."/libraries/FCKeditor/fckeditor.php");
			$input_contenuto = new FCKEditor('contenuto');
			$input_contenuto->Value = $contenuto;
			$input_contenuto->ToolbarSet = "Default";
			$this->open_element = $input_contenuto->CreateHtml();
			$this->close_element = "\n<input type='hidden' name='applicazione' value='dweditor' />\n";
		}

	}

}
?>