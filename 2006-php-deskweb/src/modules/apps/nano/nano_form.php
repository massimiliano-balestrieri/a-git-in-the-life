<?php
/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package NanoDeskweb
 */

/**
 * class NanoFormDeskWeb
 */

class NanoFormDeskWeb extends FormDeskWeb {

	/**
	  * class constructor
	  */
	function NanoFormDeskWeb($id_sezione, & $contenuto) {

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