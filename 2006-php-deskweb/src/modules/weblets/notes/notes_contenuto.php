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
 * @package Weblets
 */

/**
 * classe WebletNotesContent
 */
class WebletNotesContent extends WidgetDeskWeb {
	
	/**
	 * classe costruttore
	 * formatta il contenuto e lo prepara ad essere mandato ad output
	 */
	function WebletNotesContent($contenuto) {
		$this->open_element = "<div id='contenuto_notes'>\n";
		if (is_array($contenuto)) {
			for ($x = 0; $x <= sizeof($contenuto) - 1; $x ++) {
				$this->open_element .= "<p>".date("d/m/Y", strtotime($contenuto[$x]['last_date'])).": "."<br /><a style='font-style:italic;color:black' href='?id=".$contenuto[$x]['id_node']."'>".$contenuto[$x]['node']."</a><br />".$contenuto[$x]['content']."</p>";
			}
		}
		$this->close_element = "</div>\n";
	}
}
?>