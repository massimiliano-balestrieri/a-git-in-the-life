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
 * classe WebletNewsProject
 */
class WebletNewsProject extends WidgetDeskWeb {
	/**
	 * la weblet � un'applicazione che non estende window.
	 * appare appiccicata al desktop
	 * 
	 * in questo caso la weblet � complessa
	 * istanzia
	 * 
	 * modello weblet
	 * passa al panel il contenuto 
	 */
	function WebletNewsProject() {
		require_once ("model_news_project.php");
		$model = new ModelNewsProject();

		require_once ("panel_news_project.php");
		$panel = new WebletNewsProjectPanel($model->arr_news);
		$this->add_element($panel);
		
		$this->open_element = "<div id='news_project'>\n";
		$this->close_element = "</div>\n";
	}
}
?>