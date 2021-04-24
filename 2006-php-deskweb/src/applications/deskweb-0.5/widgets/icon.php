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
 * The icon base widget
 */
class IconDeskWeb extends ImageDeskWeb {

	/**
	 * the label field
	 */
	var $label = null;
	/**
	 * the label class
	 */
	var $label_class = null;
	/**
	 * the container of icon
	 */
	var $container = null;
	/**
	 * the container class
	 */
	var $container_class = null;

	/**
	 * the constructor istance a base Image object IconDeskWeb
	 */
	function IconDeskWeb() {
		$this->ImageDeskWeb();
	}
	function appendCheck($id_sezione) {
		if(ModelDeskWeb::isOwner($id_sezione))
		$this->open_element .= "<input type='checkbox' class='check_icon' name='id_node[]' value='".$id_sezione."' />";
	}
	/**
	 * Append a label to the base object
	 */
	function appendLabel() {

		if ($this->onclick) {
			$this->open_element .= "<a class='".$this->label_class."' href='#' onclick='".$this->onclick."(".$this->onclick_param.");'>\n";
		} else {
			if ($this->href && $this->label)
				$this->open_element .= "<a class='".$this->label_class."' href='?".$this->url."'>\n";
			if ($this->href_ext && $this->label)
				$this->open_element .= "<a class='".$this->label_class."' href='http://".$this->url."'>\n";
		}
		if ($this->label)
			$this->open_element .= $this->label."\n";
		if (($this->href || $this->href_ext) && $this->label)
			$this->open_element .= "</a>\n";
	}
	/**
	 * append text (view detailed)
	 */
	function appendText($text,$class=null){
		if($class)$class = " class='".$class."'";
		$this->open_element .= "<span".$class.">".$text."</span>\n";
	}
	/**
	 * append a container to the base object
	 */
	function appendContainer($type, $class) {
		$this->set_container($type, $class);
		if ($this->container)
			$this->open_element = "<".$this->container." class='".$this->container_class."'>\n".$this->open_element;

		$this->close_element .= "</div>\n";
	}
	/**
	 * set the label of image
	 */
	function set_label($value, $class) {
		$this->label = $value;
		$this->label_class = $class;
	}
	/**
	 * set the container of image
	 */
	function set_container($type, $class) {
		$this->container = $type;
		$this->container_class = $class;
	}
}
?>