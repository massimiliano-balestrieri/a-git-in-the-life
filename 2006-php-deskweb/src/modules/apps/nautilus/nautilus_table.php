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