<?php

/**
 * Project:     deskweb - the dekstop manager for web <br />
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
 * @package Menu
 */

/**
 * SonOfSuckerFishMenu Widget
 */
class SonOfSuckerFishMenu extends WidgetDeskWeb {
	/**
	 * valore temporaneo. 
	 */
	var $temp = null;
	/**
	 * contenitore menu: intestazione 
	 */
	var $text_head = null;
	/**
	 * contenitore menu: footer 
	 */
	var $text_foot = null;
	/**
	 * numero menu
	 */
	var $numero_menu = null;
	/**
	 * tipo
	 */
	var $type = "vertical";

	/**
	 * Constructor
	 * congiunge l'intestazione del menu con il footer
	 */
	function SonOfSuckerFishMenu($id_menu) {
		$this->open_element = $this->text_head."</ul></div>\n";
	}
	function setType($string) {
		switch ($string) {
			case "horizontal" :
				$this->type = "horizontal";
				break;
		}
	}
	/**
	* prepara il menu. questo metodo viene lanciato subito
	* setta il numero dei menu 
	* setta il verso del menu
	* 	menu verticale grazie all'articolo di  Patrick Griffiths, Dan Webb
	* 	menu orizzontale grazie all'articolo di  Nick Rigby
	*/
	function prepareMenu($id_menu, $numero_menu = 1, $id = null) {
		$this->numero_menu = $numero_menu;
		if ($id != null)
			$id = " id='".$id."' ";
		if ($this->type == "vertical") {
			$this->text_head = "<div $id class='menu_container'>\n<ul class='nav_sucker'>\n";
		} else {
			$this->text_head = "<div $id class='menu_container_orizzontale'>\n<ul class='nav_rigby'>\n";
		}
	}
	/**
	 * aggiunge una dropdown al menu
	 */
	function addMenu($voce, $container = false) {
			// 
	if ($container)
			$container = " class='daddy'";
		$this->text_head .= "<li style='width:".round(98 / $this->numero_menu)."%'>\n<a href='#' $container>".$voce."</a>\n";
	}
	/**
	 * aggiunge una dropdown al menu
	 */
	function addMenuImage($voce, $icona, $container = false) {
			// 
	if ($container)
			$container = " class='daddy'";
			
		$img = new ImageDeskWeb();
		$img->set_dim("22x22");
		$img->set_src_mime($icona);
		$img->set_alt($voce);
		$img->crea_tag();	
		
		$this->text_head .= "<li style='width:".round(98 / $this->numero_menu)."%'>\n".$img->open_element."\n<a href='#' $container>".$voce."</a>\n";
	}
	/**
	 * chiude la dropdown
	 */
	function closeMenu() {
		$this->text_head .= "</li>\n";
	}
	/**
	 * prepara il menu a contenere figli
	 */
	function prepareItem() {
		$this->text_head .= "<ul>\n";
	}
	/**
	 * chiude l'item
	 */
	function closeItem() {
		$this->text_head .= "</ul>\n";
	}
	/**
	 * aggiunge un item (elemento/figlio) al menu
	 */
	function addItemMenu($voce, $href = "#", $level = 1001) {
		global $session;
		$group = $session->getCurrentGroup();
		if ($href != "#" && $level >= $group) {
			$href = $this->genera_link($href);
			if (substr($href, 0, 3) == "www")
				$this->text_head .= "<li><a href='http://".$href."'>".$voce."</a></li>\n";
			else
				$this->text_head .= "<li><a href='?".$href."'>".$voce."</a></li>\n";
		} else {
			$this->text_head .= "<li><span>".$voce."</span></li>\n";
		}
	}
	/**
	 * aggiunge un item (elemento/figlio) al menu con icona
	 */
	function addItemImageMenu($voce, $icona, $href = "#", $level = 1001) {
		global $session;
		$group = $session->getCurrentGroup();
		
		$img = new ImageDeskWeb();
		$img->set_dim("22x22");
		$img->set_src_mime($icona);
		$img->set_alt($voce);
		$img->crea_tag();			
		if ($href != "#" && $level >= $group) {
			if (isset($href['link'])){
				$href = $this->genera_link($href);
				$this->text_head .= "<li>".$img->open_element."<a href='http://".$href."'>".$voce."</a></li>\n";
			}elseif(isset($href['action'])){
				$href = $this->genera_link($href);
				$this->text_head .= "<li>".$img->open_element."<a href='?".$href."'>".$voce."</a></li>\n";
			}elseif ($session->getAjax()) {
				$href = $this->genera_link($href);
				$this->text_head .= "<li>".$img->open_element."<a href='#' onclick='WindowAjax(".$href.");'>".$voce."</a></li>\n";
			}		else{
				$href = $this->genera_link($href);
				$this->text_head .= "<li>".$img->open_element."<a href='?".$href."'>".$voce."</a></li>\n";
			}
		} else {
			$this->text_head .= "<li>".$img->open_element."<span>".$voce."</span></li>\n";
		}
	}
	/**
	 * aggiunge un item al menu contenente una funzionalit� js
	 */
	function addItemMenuJS($voce, $href = "#", $level = 1001) {
		global $session;
		$group = $session->getCurrentGroup();
		if ($href != "#" && $level >= $group) {

			$this->text_head .= "<li><a href='#' onclick='".$href."'>".$voce."</a></li>\n";
		} else {
			$this->text_head .= "<li><span>".$voce."</span></li>\n";
		}
	}
	/**
	 * genera un link
	 */
	function genera_link($href) {
		$temp = null;
		//print_r($href);
		if (is_array($href)) {
			while ($array_cell = each($href)) {
				if ($array_cell['key'] == "ext" || $array_cell['key'] == "link") {
					$temp = $array_cell['value'];
					return $temp;
				}
				if (strlen($temp) > 0)
					$temp .= "&amp;";
				if ($array_cell['value'])
					$temp .= $array_cell['key']."=".$array_cell['value'];

			}
		}
		return $temp;
	}
	/**
	 * aggiunge un figlio di secondo livello ad un figlio di primo livello
	 */
	function addItemNested($voce) {
		$this->text_head .= "<li>\n<a href='#' class='daddy'>".$voce."</a>\n";
	}

}
?>