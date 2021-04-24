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
 * classe WebletNotes
 */
class WebletNotes extends WidgetDeskWeb {
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
	function WebletNotes() {
		require_once ("notes_model.php");
		$model = new NotesModel();

		if(count($model->arr_notes)>0)
		{
			require_once ("notes_panel.php");
			$panel = new WebletNotesPanel($model->arr_notes);
			$this->add_element($panel);
		}
		$this->open_element = "<div id='notes'>\n";
		$this->close_element = "</div>\n";
	}
}
?>