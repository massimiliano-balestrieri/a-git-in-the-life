<?php
/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package DwEditorDeskweb
 */

/**
 * class DwEditorContentDeskWeb
 */
class DwEditorContentDeskWeb extends WidgetDeskWeb {

	/**
	 * class constructor
	*/
	function DwEditorContentDeskWeb($contenuto) {
		$this->open_element = "<div class='generic_contenuto'>\n".$contenuto;
		$this->close_element = "</div>\n";
	}

}
?>