<?php
/**
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