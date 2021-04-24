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
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package DesktopManager
 */

/**
 * gnomePanelNav Widget
 */
class DWgnomePanelNav extends WidgetDeskWeb {

	/**
	 * constructor class 
	 * Istanzia
	 * mostra desktop
	 * tasti finestre
	 * tasto per il multi desktop
	 * 
	 * todo:
	 * mostra desktop
	 * seleziona multi desktop
	 */
	function DWgnomePanelNav() {
		$mostra_desktop = new ImageDeskWeb();
		$mostra_desktop->set_id("mostra_desktop");
		$mostra_desktop->set_src_mime("mostra_desktop.gif");
		$mostra_desktop->set_action(ACTION_MOSTRA_DESKTOP);
		$mostra_desktop->crea_tag();

		$tasti = new tastiPanelNav();
		$this->add_element($mostra_desktop);

		$this->add_element($tasti);

		$sel_desktop_container = new ContainerDeskweb();
		$sel_desktop_container->set_id("sel_desktop");
		global $session;
		for ($x = 1; $x <= NUM_DESKTOP; $x ++) {
			$sel_desktop = new ImageDeskWeb();
			if ($session->getIdDesktopActive() == $x) {
				$sel_desktop->set_src_mime("desktop.png");
			} else {
				$sel_desktop->set_src_mime("desktop_dis.png");
			}
			$sel_desktop->set_action(ACTION_CHANGE_DESKTOP, $x);
			$sel_desktop->crea_tag();
			$sel_desktop_container->append_child($sel_desktop);
		}
		$sel_desktop_container->crea_tag();
		$this->add_element($sel_desktop_container);

		$this->open_element = "<div id='panel_nav'>\n";
		$this->close_element = "</div>\n";
	}

}
?>