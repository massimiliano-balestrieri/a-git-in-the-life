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
 * The button base widget
 */
class ButtonDeskWeb extends ImageDeskWeb {

	var $type = null;
	var $name = null;
	var $value = null;
	var $disabled = null;
	/**
	 * the constructor istance a base Image object IconDeskWeb
	 */
	function ButtonDeskWeb() {
		$this->tag = "input";
	}

	function make($src, $dim, $name, $action, $alt = "", $check_method = null) {
		global $session;
		if($session->getUserAgent()=="ie"){
			$this->type = "submit";
		}else{
			$this->type = "image";
		}
		$this->set_dim($dim);
		$this->set_src_mime($src);
		$this->name = $name;
		$this->set_alt($alt);
		$this->set_value($action);
		if ($check_method == "disabled") {
			$this->set_disabled();
			$this->set_src_mime("dis_".$src);
		} else {
			if ($check_method != null) {
				$esito = false;
				eval ('$esito ='.$check_method.';');
				if (!$esito) {
					$this->set_disabled();
					$this->set_src_mime("dis_".$src);
				}
			}
		}
		$this->crea_tag();

	}

	function set_name($name) {
		$this->name = $name;
	}
	function set_disabled() {
		$this->disabled = " disabled='disabled '";
	}
	function set_value($value) {
		$this->value = $value;
	}
	function crea_tag() {
		global $session;
		if($session->getUserAgent()=="ie"){
			$this->open_element .= "<".$this->tag." type='".$this->type."' name='".$this->name."' value='".$this->value."' src='".$this->directory.$this->src."' class='toolbar_button' ".$this->disabled."/>\n";
		}else{
			$this->open_element .= "<".$this->tag." type='".$this->type."' name='".$this->name."' value='".$this->value."' src='".$this->directory.$this->src."' class='toolbar_button' ".$this->disabled."/>\n";
		}
		$this->disabled = null;		
	}
	function preparse(){
		global $session;
		if ($session->getUserAgent() == "ie") {
			require_once ($_SERVER['DOCUMENT_ROOT']."/libraries/ie-png-transparency/replacePngTags.php");
			$this->open_element = replacePngTags($this->open_element, "/libraries/ie-png-transparency/");
		}	
	}
	/**
	 * separatore per toolbar
	*/
	function separator() {
		$this->open_element .= "<span class='separator'>&nbsp;</span>\n";
	}
}
?>