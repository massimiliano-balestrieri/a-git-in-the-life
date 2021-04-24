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
 * @version 0.1.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package Deskweb
 */

/**
 * The image base widget
 */
class ImageDeskWeb extends WidgetDeskWeb {
	/**
	 * the dimesion of the image
	 */
	var $dim = null;
	/**
	 * the directory of image
	 */
	var $directory = null;
	/**
	 * the source of the image
	 */
	var $src = null;
	/**
	 * the alternative text
	 */
	var $alt = null;
	/**
	 * the href value
	 */
	var $href = false;
	/**
	 * the href external value
	 */
	var $href_ext = false;
	/**
	 * the url of the href field
	 */
	var $url = null;
	/**
	 * the function handled by onclick
	 */
	var $onclick = null;
	/**
	 * the function handled by onmouseover
	 */
	var $onMouseOver = null;
	/**
	 * the function handled by onmouseout
	 */
	var $onMouseOut = null;
	/**
	 * the onclick argument
	 */
	var $onclick_param = null;
	/**
	 * the onmouseover argument
	 */
	var $onmouseover_param = null;
	/**
	 * the onmouseout argument
	 */
	var $onmouseout_param = null;

	/**
	* Constructor class
	*/
	function ImageDeskWeb() {

		$this->directory = DIR_GUI."/";
		$this->tag = "img";
	}

	/**
	 * set an alternative text
	 */
	function set_alt($name) {
		$this->alt = $name;
	}
	/**
	 * set source of mime
	 */
	function set_src_mime($name, $tipo = 0) {
		if ($name) {
			$this->src = $name;
		} else {
			$this->src = $this->_mime($tipo);
		}

	}

	/**
	 * set the onclick function 
	 */
	function set_onclick($nome_function, $args) {
		global $session;
		if ($session->getJavascript() == 1) {
			$this->href = true;
			$this->onclick = $nome_function;
			$this->onclick_param = $args;
		}
	}
	/**
	 * set the onclick function 
	 */
	function set_onMouseOver($nome_function, $args) {
		global $session;
		if ($session->getJavascript() == 1) {
			$this->href = true;
			$this->onMouseOver = $nome_function;
			$this->onmouseover_param = $args;
		}
	}
	/**
	 * set the onclick function 
	 */
	function set_onMouseOut($nome_function, $args) {
		global $session;
		if ($session->getJavascript() == 1) {
			$this->href = true;
			$this->onMouseOut = $nome_function;
			$this->onmouseout_param = $args;
		}
	}
	/**
	 * the overridded method for the creation of components
	 */
	function crea_tag() {
		if ($this->href) {
			if ($this->onclick || $this->onMouseOver || $this->onMouseOut) {
				$this->open_element .= "<a href='#'>";
			} else {
				$this->open_element .= "<a href='?".$this->url."'>";
			}
		}
		if ($this->href_ext) {
			$this->open_element .= "<a href='http://".$this->url."'>";
		}
		$this->open_element .= "<".$this->tag;
		if ($this->id)
			$this->open_element .= " id='".$this->id."'";
		if ($this->classname)
			$this->open_element .= " class='".$this->classname."'";
		if ($this->tag == "img")
			$this->open_element .= " alt='".$this->alt."'";
		$nome_icona_def = "icon.png";

		if ($this->src) {
			if (is_file($_SERVER['DOCUMENT_ROOT'].$this->directory.$this->src))
				$this->open_element .= " src='".$this->directory.$this->src."'";
			else
				$this->open_element .= " src='".$this->directory.$nome_icona_def."'";
		}

		if ($this->onclick && $this->tag == "img")
			$this->open_element .= " onclick='".$this->onclick."(".$this->onclick_param.");'";
		if ($this->onMouseOver && $this->tag == "img")
			$this->open_element .= " onmouseover='".$this->onMouseOver."(".$this->onmouseover_param.");'";
		if ($this->onMouseOut && $this->tag == "img")
			$this->open_element .= " onmouseout='".$this->onMouseOut."(".$this->onmouseout_param.");'";
		$this->open_element .= " />";
		if ($this->href || $this->href_ext)
			$this->open_element .= "</a>\n";
		else
			$this->open_element .= "\n";

		//fix png trasparency
		global $session;
		if ($session->getUserAgent() == "ie") {
			require_once ($_SERVER['DOCUMENT_ROOT']."/libraries/ie-png-transparency/replacePngTags.php");
			$this->open_element = replacePngTags($this->open_element, "/libraries/ie-png-transparency/");
		}
	}
	/**
	 * set the dimension of image
	 */
	function set_dim($value) {
		$this->dim = $value;
		$this->directory = DIR_THUMB."/".$value."/";
	}
	/**
	 * set the base href (es:id=1)
	 */
	function set_href($id) {
		if (!is_array($id)) {
			$this->href = true;
			$this->url = "id=".$id;
		} else {
			$this->href = true;
			$href = $this->_genera_link($id);
			$this->url = $href;
		}
	}
	/**
	 * set the base href (es:id=1)
	 */
	function set_href_action($action) {
		$this->href = true;
		$this->url = $action;
	}
	/**
	 * set the href external
	 */
	function set_href_external($href) {
		$this->href_ext = true;
		$this->url = $href;
	}

	/**
	 * Private Methods
	 */
	/**
		 * set the href # for link javascript based
		 */
	function _set_href_javascript($href) {
		$this->href_javascript = true;
		$this->url = $href;
	}
	/**
	 * set a url with get values
	 */
	function _set_href_multiparam($array) {
		$this->href = true;
		$href = $this->genera_link($array);
		$this->url = $href;
	}
	/**
	 * return the querystring with many value
	 */
	function _genera_link($href) {
		$temp = null;
		if (is_array($href))
			while ($array_cell = each($href)) {
				if (strlen($temp) > 0)
					$temp .= "&amp;";
				if ($array_cell['value'])
					$temp .= $array_cell['key']."=".$array_cell['value'];

			}
		return $temp;
	}
	/**
	 * return a name of standard icon for a limited numer of mime files
	 */
	function _mime($mime) {

		$rmime = null;
		switch ($mime) {
			case "dir" :
				$rmime = "cartella.png";
				break;
			case "doc" :
				$rmime = "doc.png";
				break;
			default :
				$rmime = "cartella.png";
				break;

		}

		return $rmime;
	}

}
?>