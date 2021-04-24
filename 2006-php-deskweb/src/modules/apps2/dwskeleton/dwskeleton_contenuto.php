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
 * class SkeletonContentDeskWeb
 */
class DWSkeletonContentDeskWeb extends WidgetDeskWeb {
	/**
	 * class constructor
	 */
	function DWSkeletonContentDeskWeb($contenuto) {
		$this->text_apertura = "<div id='contenuto_generic'>\n".stripslashes($contenuto);
		$this->text_chiusura = "</div>\n";
	}

}
?>