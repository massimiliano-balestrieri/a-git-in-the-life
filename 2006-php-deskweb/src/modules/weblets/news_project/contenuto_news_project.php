<?php

/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package Weblets
 */

/**
 * classe WebletNewsProjectContent
 */
class WebletNewsProjectContent extends WidgetDeskWeb {
	
	/**
	 * classe costruttore
	 * formatta il contenuto e lo prepara ad essere mandato ad output
	 */
	function WebletNewsProjectContent($contenuto) {
		$this->open_element = "<div id='contenuto_news_project'>\n";
		if (is_array($contenuto)) {
			for ($x = 0; $x <= sizeof($contenuto) - 1; $x ++) {
				$this->open_element .= "<p>".date("d/m/Y", strtotime($contenuto[$x]['last_date'])).": "."<a style='color:white' href='?id=".$contenuto[$x]['id_node']."'>".$contenuto[$x]['node']."</a></p>";
			}
		}
		$this->close_element = "</div>\n";
	}
}
?>