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
 * @package DesktopManager
 */

/**
 * gnomePanelMenu Widget
 */
class DWgnomePanelMenu extends WidgetDeskWeb {

	/**
	 * class constructor
	 * istanzia il logo (temp)
	 * la barra dell'ora
	 * l'ora
	 * il pannello con il menu di avvio veloce
	 * 
	 * todo:
	 * l'ora js
	 * il menu del desktop
	 */
	function DWgnomePanelMenu() {

		global $request, $session;
		//logo

		$applicazioni = new ImageDeskWeb();
		$applicazioni->set_alt("applications");
		$applicazioni->set_classname("menu_gnome");
		$applicazioni->set_src_mime("applicazioni.png");
		$applicazioni->set_href(1);
		$applicazioni->set_onMouseOver("displayMenu", '"gnome_menu","1"');
		$applicazioni->crea_tag();

		$places = new ImageDeskWeb();
		$places->set_alt("places");
		$places->set_classname("menu_gnome");
		$places->set_src_mime("risorse.png");
		$places->set_href(2);
		$places->set_onMouseOver("displayMenu", '"gnome_menu","2"');
		$places->crea_tag();

		$system = new ImageDeskWeb();
		$system->set_alt("system");
		$system->set_classname("menu_gnome");
		$system->set_src_mime("sistema.png");
		$system->set_href(3);
		$system->set_onMouseOver("displayMenu", '"gnome_menu","3"');
		$system->crea_tag();

		//barra ora
		$barra_ora = new ImageDeskWeb();
		$barra_ora->set_id("barra_ora");
		$barra_ora->set_src_mime("barra_ora.gif");
		$barra_ora->crea_tag();

		//loading
		$loading = new ImageDeskWeb();
		$loading->set_id("loading");
		$loading->set_src_mime("loading.png");
		$loading->crea_tag();
		$loaded = new ImageDeskWeb();
		$loaded->set_id("loaded");
		$loaded->set_src_mime("loaded.png");
		$loaded->crea_tag();

		//ora
		$ora = new TextDeskWeb();
		$ora->set_id("ora");
		$ora->set_text(date('d-m-Y H:i'));
		$ora->crea_tag();

		
		//avvio veloce
		$avvio_veloce = new PanelQuickStart();

		$this->add_element($applicazioni);
		$this->add_element($places);
		$this->add_element($system);
		$this->add_element($avvio_veloce);
		$this->add_element($barra_ora);
		$this->add_element($loading);
		$this->add_element($loaded);
		$this->add_element($ora);

		$this->open_element = "<div id='panel_menu'>\n";
		$this->close_element = "</div>\n";

		global $session;
		if ($session->getJavascript() == 1) {
			require_once (dirname(__FILE__)."/menu.php");
			$menuApplications = new DWgnomeMenu(0);
			$menuApplications->DWgnomeMenuApplicationsDB(0);

			$menuPlaces = new DWgnomeMenu(0);
			$menuPlaces->DWgnomeMenuPlacesDB(0);

			$menuSystem = new DWgnomeMenu(0);
			$menuSystem->DWgnomeMenuSystemDB(0);

			$this->append_element($menuApplications);
			$this->append_element($menuPlaces);
			$this->append_element($menuSystem);
		}

	}

}
?>