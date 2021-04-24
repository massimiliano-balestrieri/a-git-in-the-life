<?php


/**
 * DesktopDeskWeb Base Widget
 */
class DesktopDeskWeb extends WidgetDeskWeb {

	/**
	 * desktop constructor:
	 * lancia il login manager se la sessione non risulta valida
	 * lancia il desktop manager scelto (attualmente solo gnome)
	 * istanzia la finestra per il debug
	 * manda ad output se stesso.
	 * ricorsivamente tutti gli oggetti caricati dentro verranno visualizzati
	 */
	function DesktopDeskWeb() {

		//print_r($_SESSION);
		global $msgstack, $session;
		$dm = $session->getDesktopManager();

		switch ($dm) {
			case "GNOME" :

				if (!$session->getFullscreen()) {
					require_once(DIR_DESKWEB . "/objects/dm/dwgnome/include_dwgnome.php");
					$panel_menu = new DWgnomePanelMenu();
					$panel_nav = new DWgnomePanelNav();
					$panel_centrale = new DWgnomeDesktop();
					$this->add_element($panel_menu);
					$this->add_element($panel_centrale);
					$this->add_element($panel_nav);
				} else {
					//$panel_centrale = new gnomeDesktop();
					//$this->add_element($panel_centrale);
					$content = new ContentDeskWeb(true);
					$this->add_element($content);
				}
				break;
		}

		if (!$session->getFullscreen()) {
			$user = $session->getCurrentUser();
			if ($user == 1 || 1==1) {
				require_once (DIR_DESKWEB."/widgets/wm/include_wm.php");
				require_once ($_SERVER['DOCUMENT_ROOT']."/modules/apps/debug/debug.php");
				$window = new DebugDeskWeb();
				$window->set_name("Debug");
				$window->add_application($window->init(0, 0));
				$window->set_position(0, 50, 100, false, false, 379, 400, 0);
				$window->set_trackable(false);
				$window->build_window(0);
				$this->add_element($window);
			}
		}
		$js = null;
		if($session->getJavascript())
		$js = " onclick='hideMenu(\"gnome_menu\");'";
		$this->open_element = "<div id='desktop'".$js." style='background-color:".$session->getAuthBgColor()."'>\n";
		$this->close_element = "</div>\n";
	}

}
?>