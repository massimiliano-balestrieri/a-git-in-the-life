<?php


/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package SkeletonDeskweb
 */

/**
 * class SkeletonFormDeskWeb
 */

class DWSkeletonFormDeskWeb extends WidgetWebdesktop {
	/**
	 * class constructor
	 */
	function DWSkeletonFormDeskWeb(& $contenuto) {

		global $request;
		$this->text_apertura = "<p>\n<textarea name='contenuto' cols='40' rows='12'>".stripcslashes($contenuto);
		$this->text_chiusura = "</textarea>\n<input type='hidden' name='w' value='".$request->w."' />\n</p>\n";
	}
}
?>