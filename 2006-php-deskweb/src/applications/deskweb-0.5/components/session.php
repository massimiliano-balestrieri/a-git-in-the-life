<?php



/**
 * Classe Session
 */

class SessionDeskWeb {

	/**
	 * class constructor
	 * 
	 */
	function SessionDeskWeb() {
		//start session
		session_start();

		// check logout request
		$this->_checkLogout();

		// check init
		$singleton = $this->_checkInit();
		if ($singleton != 1)
			$this->_init();

		// check request change desktop
		$this->_checkDesktop();

		// check requests
		$this->_analizeRequest();
		// close session
		session_write_close();
	}
	/**
	 * static method
	 */
	function existPreviousRequest() {
		if ($_SESSION['HISTORY']['ACTIVE'] > 0)
			return true;
	}
	function existNextRequest() {
		if (isset ($_SESSION['HISTORY']['LEFT']))
			return true;
	}
	function existClipboard() {
		if (isset ($_SESSION['CLIPBOARD']['COPY']) || (isset ($_SESSION['CLIPBOARD']['FROM']) && isset ($_SESSION['CLIPBOARD']['NODES'])))
			return true;
	}
	function checkCurrentView($view) {
		if (SessionDeskWeb :: getView() != $view)
			return true;
	}
	/**
	 * public method
	 */
	function authFromForm($dati){
		session_start();
		$_SESSION['AUTH']['USER'] = $dati['id_user'];
		$_SESSION['AUTH']['GROUP'] = $dati['fk_firstgroup'];
		$_SESSION['AUTH']['BGCOLOR'] = $dati['desktop_bg'];
		$_SESSION['AUTH']['ATTEMPT'] = 0;
		session_write_close();	
	}
	function addAuthAttempt(){
		session_start();
		$_SESSION['AUTH']['ATTEMPT']++;
		session_write_close();
	}
	function getAuthAttempt(){
		return $_SESSION['AUTH']['ATTEMPT'];
	}
	function getAuthBgColor(){
		return $_SESSION['AUTH']['BGCOLOR'];
	}
	//AJAX
	function ajaxRegisterWindowProperties($properties) {
		if (isset ($_SESSION['DESKTOP'][$properties['desktop']][$properties['id']])) {
			session_start();
			$_SESSION['DESKTOP'][$properties['desktop']][$properties['id']]['top'] = $properties['top'];
			$_SESSION['DESKTOP'][$properties['desktop']][$properties['id']]['left'] = $properties['left'];
			$_SESSION['DESKTOP'][$properties['desktop']][$properties['id']]['width'] = $properties['width'];
			$_SESSION['DESKTOP'][$properties['desktop']][$properties['id']]['height'] = $properties['height'];
			$_SESSION['DESKTOP'][$properties['desktop']][$properties['id']]['z'] = $properties['z'];
			session_write_close();
		}
	}
	//FINE AJAX
	function setUserAgentFeatures() {
		//print_r($_COOKIE);
		if (!isset ($_SESSION['FEATURES']['USERAGENT'])) {
			global $sniffer;
			session_start();
			$_SESSION['FEATURES']['USERAGENT'] = $sniffer->get_property("browser");
			$_SESSION['FEATURES']['COOKIES'] = $sniffer->get_property("st_cookies");
			$js = 0;
			if (isset ($_COOKIE['js']))
				$js = 1;
			$_SESSION['FEATURES']['AJAX'] = $js;
			$_SESSION['FEATURES']['JAVASCRIPT'] = $js;
			session_write_close();
		}
	}
	function setView($view) {
		session_start();
		$_SESSION['FEATURES']['VIEW'] = $view;
		session_write_close();
	}
	function setFullscreen() {
		session_start();
		if ($_SESSION['FEATURES']['FULLSCREEN'] == 0)
			$_SESSION['FEATURES']['FULLSCREEN'] = 1;
		else
			$_SESSION['FEATURES']['FULLSCREEN'] = 0;
		session_write_close();
	}

	function registerCopy($tree) {
		$this->purgeClipboard();
		session_start();
		$_SESSION['CLIPBOARD']['COPY'] = $tree;
		session_write_close();
	}
	function registerCut() {
		$this->purgeClipboard();
		global $request;
		$node_to_cut = $request->form['id_node'];
		session_start();
		$_SESSION['CLIPBOARD']['FROM'] = $request->id;
		$_SESSION['CLIPBOARD']['NODES'] = $node_to_cut;
		session_write_close();
	}
	function getClipboardCopy() {
		if (isset ($_SESSION['CLIPBOARD']['COPY']))
			return $_SESSION['CLIPBOARD']['COPY'];
	}
	function getClipboardFrom() {
		return $_SESSION['CLIPBOARD']['FROM'];
	}
	function getClipboardNodes() {
		return $_SESSION['CLIPBOARD']['NODES'];
	}
	function purgeClipboard() {
		session_start();
		if (isset ($_SESSION['CLIPBOARD']['COPY']))
			unset ($_SESSION['CLIPBOARD']['COPY']);
		if (isset ($_SESSION['CLIPBOARD']['FROM']))
			unset ($_SESSION['CLIPBOARD']['FROM']);
		if (isset ($_SESSION['CLIPBOARD']['NODES']))
			unset ($_SESSION['CLIPBOARD']['NODES']);
		session_write_close();
	}
	function getActive() {
		return $_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']];
	}
	function getIdDesktopActive() {
		return $_SESSION['DESKTOP']['ACTIVE'];
	}
	function getDesktopManager() {
		return $_SESSION['DM'];
	}

	function getPublic() {
		return $_SESSION['AUTH']['PUBLIC'];
	}
	function getHomeCurrentUser() {
		return $_SESSION['AUTH']['HOME'];
	}
	function getCurrentUser() {
		return $_SESSION['AUTH']['USER'];
	}
	function getCurrentGroup() {
		return $_SESSION['AUTH']['GROUP'];
	}
	function getActiveDeskwebApps() {
		return $_SESSION['MODEL']['DESKWEB_APPS'];
	}
	function getAjax() {
		return $_SESSION['FEATURES']['AJAX'];
	}
	function getUserAgent() {
		return $_SESSION['FEATURES']['USERAGENT'];
	}
	function getView() {
		return $_SESSION['FEATURES']['VIEW'];
	}
	function getFullscreen() {
		return $_SESSION['FEATURES']['FULLSCREEN'];
	}
	function getJavascript() {
		return $_SESSION['FEATURES']['JAVASCRIPT'];
	}
	function getPreviousRequest() {
		$active = $_SESSION['HISTORY']['ACTIVE'];
		if ($active > 0) {
			$lastreq = $_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']][$active -1];
			session_start();
			//unset($_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']][$active]);
			$_SESSION['HISTORY']['ACTIVE'] = count($_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']]) - 1;
			@ $_SESSION['HISTORY']['LEFT']++;
			session_write_close();
			return $lastreq;
		} else {
			return $lastreq = $_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']][$active];
		}
	}
	function getNextRequest() {
		if (isset ($_SESSION['HISTORY']['LEFT'])) {
			$active = $_SESSION['HISTORY']['ACTIVE'];
			$left = $_SESSION['HISTORY']['LEFT'];
			$id = $_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']][$active +1];
			$position = $active +1;
			$_SESSION['HISTORY']['ACTIVE'] = $position;
			@ $_SESSION['HISTORY']['LEFT']--;
			if ($_SESSION['HISTORY']['LEFT'] == 0)
				unset ($_SESSION['HISTORY']['LEFT']);
			return $id;
		} else {
			global $request;
			return $request->id;
		}
	}
	function setWindowPosition($id, $height, $width) {
		//perche?
		if (isset ($_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']][$id])) {
			session_start();
			$_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']][$id]['width'] = $width;
			$_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']][$id]['height'] = $height;
			session_write_close();
		}
	}
	function addDeskwebApp($app) {
		session_start();
		if ($this->allowMultiWindow() == 0)
			$_SESSION['MODEL']['DESKWEB_APPS'] = array ();

		if (!in_array($app, $_SESSION['MODEL']['DESKWEB_APPS'])) {
			$_SESSION['MODEL']['DESKWEB_APPS'][] = $app;
		}
		session_write_close();
	}
	function purgeActive() {
		//$this->_start();
		session_start();
		//print_r($_SESSION['MODEL']['DESKWEB_APPS']);
		$_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']] = array ();
		$_SESSION['MODEL']['DESKWEB_APPS'] = array ();
		session_write_close();
		//$this->_write_close(); //print_r($_SESSION);
	}
	function removeFromActive($id) {
		session_start();
		unset ($_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']][$id]);
		session_write_close();
	}
	function removeOtherActive($id) {
		$temp = $_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']][$id];
		session_start();
		$_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']] = array ();
		$_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']][$id] = $temp;
		session_write_close();

	}
	function allowMultiWindow() {
		return $_SESSION['FEATURES']['ALLOWMULTIWINDOWS'];
	}
	/**
	 * METODI PRIVATI:
	*/

	function _checkLogout() {
		global $request;
		if (isset ($request->logout))
			$this->_logout();
	}
	function _checkInit() {
		if (isset ($_SESSION['INIT']))
			return 1;
	}
	function _checkDesktop() {
		global $request;
		if (isset ($request->desktop) && is_numeric($request->desktop))
			if ($request->desktop > 0 && $request->desktop <= NUM_DESKTOP)
				$_SESSION['DESKTOP']['ACTIVE'] = $request->desktop;
	}
	function _init() {

		// inizializza il desktop manager
		$_SESSION['ID'] = session_id();
		// inizializza il desktop manager
		$_SESSION['DM'] = DEFAULT_DM;

		// inizializza l'autentificazione predefinita
		$this->_setInitAuthentification();

		// inizializza le funzionalit� predefinite
		$this->_setInitFeatures();

		// inizializza le applicazioni in memoria
		$this->_setInitDeskwebApps();

		// inizializza i desktop
		$this->_setInitDesktop();

		// inizializza l'history
		$this->_setInitHistory();

		// inizializza i link di test per il dump
		if (DEBUG == 1)
			$this->_setDumpUtils();

		//init
		$_SESSION['INIT'] = 1;

	}
	function _analizeRequest() {
		global $request;

		if (isset ($request->id) && is_numeric(($request->id))) {
			if (ModelDeskWeb :: isReadable($request->id)) {
				$this->_registerHistory($request->id);
				if (!$this->allowMultiWindow() && !array_key_exists($request->id, $_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']])) {
					$_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']] = array ();
				}
				if (!array_key_exists($request->id, $_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']])) {
					$_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']][$request->id] = array ();
					$_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']][$request->id]['top'] = 39 + (count($_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']]) * 10)."px";
					$_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']][$request->id]['left'] = 90 + (count($_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']]) * 10)."px";
					$_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']][$request->id]['width'] = "379px";
					$_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']][$request->id]['height'] = "400px";
					$_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']][$request->id]['z'] = count($_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']]);
					$_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']][$request->id]['new'] = 1;
				}
			}
		} else {
			if (count($_SESSION['DESKTOP'][$_SESSION['DESKTOP']['ACTIVE']]) == 0) {
				$_SESSION['FEATURES']['FULLSCREEN'] = 0;
			}
		}

	}
	function _registerHistory($id) {

		$last2 = 0;
		$lastid = 0;
		$current_active = 0;
		if (count($_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']]) > 0) {
			$lastid = $_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']][count($_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']]) - 1];
			$last = count($_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']]) - 1;
			$position = $_SESSION['HISTORY']['ACTIVE'];
			$current_active = $_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']][$_SESSION['HISTORY']['ACTIVE']];
		} else {
			$last = 0;
			$position = 0;
		}
		if ($id != $current_active) {
			if ($position == $last) {
				if (!isset ($_SESSION['HISTORY']['LEFT'])) {
					$_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']][] = $id;
					$_SESSION['HISTORY']['ACTIVE'] = count($_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']]) - 1;
				} else {
					$_SESSION['HISTORY']['ACTIVE'] = count($_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']]) - ($_SESSION['HISTORY']['LEFT'] + 1);
				}

			} else {
				//cancello la parte di array che non mi interessa
				$_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']] = array_slice($_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']], 0, $position +1);
				$_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']][] = $id;
				$_SESSION['HISTORY']['ACTIVE'] = count($_SESSION['HISTORY'][$_SESSION['DESKTOP']['ACTIVE']]) - 1;
				unset ($_SESSION['HISTORY']['LEFT']);
				//echo "non sono sull'ultimo";
				//echo $last;
				//echo $position;
				//echo $current_active;
				//print_r($temp);
			}
		}
	}
	function _setInitDesktop() {
		$this->_setDefaultSessionValue('DESKTOP', 'ACTIVE', 1);
		for ($x = 1; $x <= NUM_DESKTOP; $x ++) {
			$this->_setDefaultSessionValue('DESKTOP', $x, array ());
		}
	}
	function _setInitHistory() {
		for ($x = 1; $x <= NUM_DESKTOP; $x ++) {
			$this->_setDefaultSessionValue('HISTORY', $x, array ());
		}
	}
	/**
	* _setInitAuthentification()
	*/
	function _setInitAuthentification() {

		$this->_setDefaultSessionValue('AUTH', 'GROUP', 0);
		$this->_setDefaultSessionValue('AUTH', 'USER', 0);
		$this->_setDefaultSessionValue('AUTH', 'HOME', 4);
		$this->_setDefaultSessionValue('AUTH', 'BGCOLOR', '008000');
		$this->_setDefaultSessionValue('AUTH', 'PUBLIC', 4);
		$this->_setDefaultSessionValue('AUTH', 'ATTEMPT', 0);
	}

	/**
	 * _setInitFeatures()
	 */
	function _setInitFeatures() {

		$this->_setDefaultSessionValue('FEATURES', 'ALLOWMULTIWINDOWS', 1);
		$this->_setDefaultSessionValue('FEATURES', 'VIEW', VIEW_ICON);
		$this->_setDefaultSessionValue('FEATURES', 'FULLSCREEN', VIEW_FULLSCREEN);
	}

	/**
	 * _setInitDeskwebApps()
	 */
	function _setInitDeskwebApps() {
		$this->_setDefaultSessionValue('MODEL', 'DESKWEB_APPS', array ());
	}
	/**
	 * _setInitLogout()
	 */
	function _setDumpUtils() {
	}

	/**
	 * _setDefaultSessionValue(id,valore)
	 */
	function _setDefaultSessionValue($cat, $id, $value) {
		if (!isset ($_SESSION[$cat][$id]))
			$_SESSION[$cat][$id] = $value;
	}
	/**
	 * logout
	 */
	function _logout() {
		$old_sessid = session_id();
		session_regenerate_id();
		$new_sessid = session_id();
		session_id($old_sessid);
		session_destroy();
		header("Location:".MAIN);
	}

}
?>