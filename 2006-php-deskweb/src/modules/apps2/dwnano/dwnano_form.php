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
 * @package DWNanoDeskweb
 */

/**
 * class DWNanoFormDeskWeb
 */

class DWNanoFormDeskWeb extends FormDeskWeb {

	/**
	  * class constructor
	  */
	function DWNanoFormDeskWeb($id_sezione, & $contenuto) {

		/*global $request;
		if(isset($request->form['w']))
		$w = $request->form['w'];
		else
		$w = $request->w;
		*/
		$auth = $this->FormDeskWeb($id_sezione);
		if ($auth) {
			$this->open_element = "<p>\n<textarea name='contenuto' cols='40' rows='12'>".stripcslashes($contenuto);
			$this->close_element = "</textarea>\n</p>\n<input type='hidden' name='applicazione' value='nano' />\n";
		}

	}

}
?>