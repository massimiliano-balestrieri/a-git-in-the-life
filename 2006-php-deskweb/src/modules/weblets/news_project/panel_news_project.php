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
 * classe WebletNewsProjectPanel
 */
class WebletNewsProjectPanel extends WidgetDeskWeb {
	/**
	 * class constructor
	 * istanzia il contenuto dell'applicazione
	 * 
	 */
	function WebletNewsProjectPanel($contenuto) {
		require_once ("contenuto_news_project.php");
		$contenuto_news_project = new WebletNewsProjectContent($contenuto);
		$this->add_element($contenuto_news_project);

		$this->open_element = "<div id='news_project_panel'>max@deskweb.org:/var/www$ cat ./.project<br />\n";
		$this->close_element = "</div>\n";

	}

}
?>