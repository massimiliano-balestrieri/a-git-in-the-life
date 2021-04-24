<?php


/**
 * Project:     deskweb - the dekstop manager for web <br />
 */

/**
 * The panel base widget
 */
class PanelDeskWeb extends WidgetDeskWeb {

	/**
	 * int id_sezione
	 */
	var $id_sezione = null;
	/**
	 * int id_array
	 */
	var $id_array = null;
	/**
	 * int id_applicazione
	 */
	var $id_applicazione = null;
	/**
	 * the Constructor 
	 */
	function PanelDeskWeb($id_sezione, $label, $visible = true) {
		$id_label = strtolower(str_replace(" ", "_", $label));

		if ($visible) {
			$visible_tastoup = "";
			$visible_tastodown = " style='display:none'";
			$visible_panel = "";
		} else {
			$visible_tastoup = " style='display:none'";
			$visible_tastodown = "";
			$visible_panel = " style='display:none'";
		}
		$this->open_element = "<div class='titolo_panel'>\n";
		global $session;
		if ($session->getJavascript()) {
			//$this->open_element .= "<a href='#'  id='tasto_up_".$id_label."_".$id_sezione."' onclick='actionPanel(".$id_sezione.",\"".$id_label."\",\"up\")'$visible_tastoup>\n
			//												 <img src='".DIR_GUI."/arrow_up.gif' alt='arrow_up'  class='arrow' align='right' /></a>\n
			//												 <a href='#'  id='tasto_down_".$id_label."_".$id_sezione."' onclick='actionPanel(".$id_sezione.",\"".$id_label."\",\"down\")'$visible_tastodown>\n
			//												 <img src='".DIR_GUI."/arrow_down.gif' alt='arrow_down'  class='arrow' align='right' /></a>\n";
		} else {
			$visible_panel = "";
		}
		$this->open_element .= $label."</div>"."<div class='panel' id='panel_".$id_label."_".$id_sezione."'$visible_panel>";
		$this->close_element = "</div>";
	}
	
	function addButtonPanel($id_sezione,$label, $visible){
		$id_label = strtolower(str_replace(" ", "_", $label));
		$this->open_element = "<div class='titolo_panel'>\n";
		$this->open_element .= "<form method='post' action='?id=".$id_sezione."'>\n<input class='titolo_input' type='submit' name='action' value='".$label."' />\n</form>\n</div>"."<div class='panel' id='panel_".$id_label."_".$id_sezione."'>";
		$this->close_element = "</div>";
	}
	
}
?>