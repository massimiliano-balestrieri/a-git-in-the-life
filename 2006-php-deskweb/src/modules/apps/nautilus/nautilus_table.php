<?php


/**
 * Project:     deskweb - the dekstop manager for web <br />
 */

/**
 * The table widget
 */
class NautilusTableDeskWeb extends WidgetDeskweb {

	var $output;
	var $classname;
	/**
	 * the Constructor 
	 * istance of this class are simply label element
	 */
	function NautilusTableDeskWeb() {

	}
	function setClassname($class) {
		$this->classname = $class;
	}
	function setIntestazioni($intestazioni) {
		if (is_array($intestazioni)) {
			$this->output .= "<thead>\n<tr>\n";

			while ($array_cell = each($intestazioni)) {
				//pulisco l'intestazione
				if ($array_cell['value'] != null)
					$this->output .= "<th><input class='int_nautilus_col' type='submit' name='orderby' value='".$array_cell['value']."' /></th>\n";
				else
					$this->output .= "<th>&nbsp;</th>\n";

			}

			$this->output .= "</tr></thead>\n";

		}

	}
	function openRow($class) {
		if ($class)
			$class = " class='".$class."'";
		$this->output .= "<tr$class>\n";
	}
	function closeRow() {
		$this->output .= "</tr>\n";
	}
	function addCell($content) {
		$this->output .= "<td>\n".$content."</td>\n";
	}
	function createTable() {
		if ($this->classname)
			$this->classname = " class='".$this->classname."'";
		$this->open_element .= "<table width='99%'".$this->classname.">\n".$this->output."\n</table>\n";
	}

}
?>