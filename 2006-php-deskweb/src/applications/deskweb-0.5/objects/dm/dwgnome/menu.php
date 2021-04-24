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
 * @package WidgetsDeskweb
 */

/**
 * class WidgetsMenu
 */

class DWgnomeMenu extends SonOfSuckerFishMenu {

	/**
	 * class constructor
	 * la classe menu estende il menu dropdown 
	 * ogni applicazione deve implementare un menu
	 */
	function DWgnomeMenuApplicationsDB($id_sezione) {

		$id_menu_places = 1;

		global $model, $request;
		$this->setType("horizontal");
		$numero_menu = 1;
		$this->prepareMenu($id_sezione, $numero_menu, "gnome_menu1");

		$this->_getItems($id_menu_places);
		
		//$this->closeMenu();
		$this->SonOfSuckerFishMenu($id_sezione);
	}
	function DWgnomeMenuPlacesDB($id_sezione) {

		$id_menu_places = 2;

		global $model, $request;
		$this->setType("horizontal");
		$numero_menu = 1;
		$this->prepareMenu($id_sezione, $numero_menu, "gnome_menu2");

		$this->_getItems($id_menu_places);
		
		//$this->closeMenu();
		$this->SonOfSuckerFishMenu($id_sezione);
	}
	function DWgnomeMenuSystemDB($id_sezione) {

		$id_menu_system = 3;

		global $model, $request;
		$this->setType("horizontal");
		$numero_menu = 1;
		$this->prepareMenu($id_sezione, $numero_menu, "gnome_menu3");

		$this->_getItems($id_menu_system);

		//$this->closeMenu();
		$this->SonOfSuckerFishMenu($id_sezione);
	}
	function DWgnomeMenuApplications($id_sezione) {
		global $model, $request;
		$this->setType("horizontal");
		$numero_menu = 1;
		$this->prepareMenu($id_sezione, $numero_menu, "gnome_menu1");

		$this->addMenuImage("Accessori", "package_utilities.png", true);
		$this->prepareItem();
		$this->addItemImageMenu("BookMarks", "keditbookmarks.png", array ("id" => 3));
		$this->addItemImageMenu("News", "knewsletter.png", array ("id" => 4));
		$this->addItemImageMenu("Notes", "klipper.png", array ("id" => 5));
		$this->addItemImageMenu("Calendar", "date.png", 1);
		$this->addItemImageMenu("Notepad", "kate.png", 1);
		$this->addItemImageMenu("FCKEditor", "browser.png", 1);
		$this->addItemImageMenu("Todo", "korganizer.png", 1);
		$this->CloseItem();
		$this->addMenuImage("Internet", "browser.png", true);
		$this->prepareItem();
		$this->addItemImageMenu("Rubrica", "keditbookmarks.png", 1);
		$this->addItemImageMenu("Mail", "email.png", 1);
		$this->addItemImageMenu("Sharing", "amule.png", 1);
		$this->addItemImageMenu("Chat", "chat.png", 1);
		$this->addItemImageMenu("Aggregator", "akregator.png", 1);
		$this->addItemImageMenu("Rss", "klipper.png", 1);
		$this->CloseItem();
		$this->addMenuImage("Multimedia", "kmix.png", true);
		$this->prepareItem();
		$this->addItemImageMenu("Audio", "juk.png", 1);
		$this->addItemImageMenu("Video", "kaboodle.png", 1);
		$this->addItemImageMenu("Immagini", "klipper.png", 1);
		$this->CloseItem();
		$this->addMenuImage("Sistema", "ksysguard.png", true);
		$this->prepareItem();
		$this->addItemImageMenu("File Manager", "kfm.png", 1);
		$this->addItemImageMenu("Terminale", "Eterm.png", 1);
		$this->CloseItem();

		$this->closeMenu();
		$this->SonOfSuckerFishMenu($id_sezione);
	}
	function DWgnomeMenuPlaces($id_sezione) {
		global $model, $request;
		$this->setType("horizontal");
		$numero_menu = 1;
		$this->prepareMenu($id_sezione, $numero_menu, "gnome_menu2");

		$this->addMenuImage("Home", "kfm_home.png");
		$this->addMenuImage("Public", "mycomputer.png");

		$this->closeMenu();
		$this->SonOfSuckerFishMenu($id_sezione);
	}
	function DWgnomeMenuSystem($id_sezione) {
		global $model, $request;
		$this->setType("horizontal");
		$numero_menu = 1;
		$this->prepareMenu($id_sezione, $numero_menu, "gnome_menu3");

		$this->addMenuImage("Amministrazione", "kcontrol.png", true);
		$this->prepareItem();
		$this->addItemImageMenu("User Manager", "Login_Manager.png", 1);
		$this->CloseItem();

		$this->addMenuImage("Preferenze", "kservices.png", true);
		$this->prepareItem();
		$this->addItemImageMenu("Wallpaper", "background.png", 1);
		$this->addItemImageMenu("Fonts", "fonts.png", 1);
		$this->addItemImageMenu("Localizzazione", "keyboard_layout.png", 1);
		$this->addItemImageMenu("Temi", "looknfeel.png", 1);
		$this->CloseItem();

		$this->addMenuImage("Logout", "logout.png");

		$this->closeMenu();
		$this->SonOfSuckerFishMenu($id_sezione);
	}
	function _getItems($id) {
		global $model;
		//print_r($model->arr_menujs['padri']);die();
		for ($x = 0; $x <= sizeof($model->arr_menujs['padri']) - 1; $x ++) {
			if ($model->arr_menujs['padri'][$x]['fk_parent'] == $id) {
				// non mi piace temporaneo
				if ($model->arr_menujs['padri'][$x]['have_child'] == 1 and $model->arr_menujs['padri'][$x]['fk_menu'] == 0) {
					$this->addMenuImage($this->_cleanNode($model->arr_menujs['padri'][$x]['node']), $model->arr_menujs['padri'][$x]['icon'], true);
					reset($model->arr_menujs['figli']);
					$tempid = $model->arr_menujs['padri'][$x]['id_node'];
					for ($y = 0; $y <= sizeof($model->arr_menujs['figli']) - 1; $y ++) {
						if ($y == 0)
							$this->prepareItem();
						if ($model->arr_menujs['figli'][$y]['fk_parent'] == $tempid) {
							$this->addItemImageMenu($this->_cleanNode($model->arr_menujs['figli'][$y]['node']), $model->arr_menujs['figli'][$y]['icon'], $this->_getTypeLink($model->arr_menujs['figli'][$y]));
						}
						if ($y == sizeof($model->arr_menujs['figli']) - 1)
							$this->CloseItem();
					}

				} else {
					$this->addItemImageMenu($this->_cleanNode($model->arr_menujs['padri'][$x]['node']), $model->arr_menujs['padri'][$x]['icon'], $this->_getTypeLink($model->arr_menujs['padri'][$x]));
				}
			}
		}
	}
	function _getTypeLink($node) {
		if ($node['type'] == "link") {
			if (strpos($node['node'], "#") > 0) {
				$temp['link'] = substr($node['node'], strpos($node['node'], "#") + 1);
				//$temp['node'] = substr($node, 0, strpos($node, "#"));
				if (substr($temp['link'], 0, 6) == "action") {
					$temp['link'] = substr($temp['link'], 7);
					$action = substr($temp['link'], 0, strpos($temp['link'], "="));
					$idaction = substr($temp['link'], strpos($temp['link'], "=") + 1);
					return array ($action => $idaction);
				}
				if (substr($temp['link'], 0, 4) == "link") {
					$temp['link'] = substr($temp['link'], 4);
					$action = "link";
					$idaction = substr($temp['link'], strpos($temp['link'], "=") + 1);
					return array ($action => $idaction);
				}
				//else
				//$icone[$array_cell['key']]->set_href_external($array_cell['value']['link']);
			}
		} else {
			return array ("id" => $node['id_node']);
		}

	}
	function _cleanNode($string) {
		if (strpos($string, "#") > 0)
			return substr($string, 0, strpos($string, "#"));
		else
			return $string;
	}
}
?>