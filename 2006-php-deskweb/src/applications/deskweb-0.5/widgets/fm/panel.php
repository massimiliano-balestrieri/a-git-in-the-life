<?php


/**
 * Project:     deskweb - the dekstop manager for web <br />
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * You may contact the authors of Deskweb by emial at: <br />
 * io@maxb.net <br />
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
 * @package Deskweb
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