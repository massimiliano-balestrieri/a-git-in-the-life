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
 * class DWNanoContentDeskWeb
 */
class DWNanoContentDeskWeb extends WidgetDeskWeb {

	/**
	  * class constructor
	  */
	function DWNanoContentDeskWeb($contenuto) {

		if (strlen($contenuto) > 0)
			$contenuto = "<pre class='nano_pre'>\n".stripslashes($contenuto)."</pre>\n";
		$this->open_element = "<div class='contenuto_nano'>\n".$contenuto;
		$this->close_element = "</div>\n";

	}

}
?>