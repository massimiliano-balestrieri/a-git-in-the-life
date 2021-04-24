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
 * @package Core
 */

/**
 * classe Request di deskweb
 */
class RequestDeskWeb {

	/**
	 * id della sezione di deskweb
	 */
	var $id = null;
	/**
	 * desktop
	 */
	var $desktop = null;
	/**
	 * logout
	 */
	var $logout = null;
	/**
	 * action
	 */
	var $action = null;
	/**
	 * nautilus action
	 */
	var $n = null;
	/**
	 * nano action
	 */
	var $w = null;
	/**
	 * dweditor action
	 */
	var $p = null;
	/**
	 * array contenente POST non filtrato
	 */
	var $richform = array ();
	/**
	 * array contenente POST
	 */
	var $form = array ();
	/**
	 * class constructor
	 * assegna alle proprietà della classe i valori passati via GET o POST
	 */
	function RequestDeskWeb() {

		//check logout
		$this->_checkGet('logout');
		//check sezione
		$this->_checkGet('id');
		//check sezione
		$this->_checkGet('desktop');
		//check action
		$this->_checkGet('action');

		//check n
		$this->_checkGet('n');
		//check w
		$this->_checkGet('w');
		//check w
		$this->_checkGet('p');
		// action annulla

		if (isset ($_POST)) {
			$this->richform = $_POST;
			$this->form = $this->_array_htmlentities($_POST);
		}
		//annulla

		if ($this->action == "0") {
			header("location:".MAIN);
		}

		//ajax actions
		if (isset ($_GET['ajax'])) {
			switch ($_GET['action']) {
				case 'REGISTER_WIN' :
					global $session;
					$properties = $this->_getWindowProperties();
					$session->ajaxRegisterWindowProperties($properties);
					break;
			}

		}

	}

	/**
	 * recupera i permessi di un elemento creato
	 * todo:
	 * delegare alle singole applicazioni ?
	 */
	function recuperaPermessi() {
		$permessi = null;
		if (isset ($this->form['R']))
			$permessi = $this->_checkPermessi($this->form['R']);
		else
			$permessi = "-";

		if (isset ($this->form['W']))
			$permessi .= $this->_checkPermessi($this->form['W']);
		else
			$permessi .= "-";

		if (isset ($this->form['X']))
			$permessi .= $this->_checkPermessi($this->form['X']);
		else
			$permessi .= "-";
		return $permessi;
	}

	/**
	 * sostituisce "-" se il permesso non viene trovato
	 */
	function _getWindowProperties() {
		$winprop = array ('desktop' => $_GET['desktop'], 'id' => $_GET['win_id'], 'left' => $_GET['win_left'], 'top' => $_GET['win_top'], 'width' => $_GET['win_width'], 'height' => $_GET['win_height'], 'z' => $_GET['win_z']);
		//$this->_array_str_replace("px","",$winprop);
		return $winprop;
	}
	function _checkPermessi($dato) {
		if (isset ($dato))
			return $dato;
		else
			return "-";
	}
	function _checkGet($var) {
		if (isset ($_GET[$var]))
			$this-> $var = $_GET[$var];

	}
	function _checkPost($var) {
		if (isset ($_POST[$var]))
			$this-> $var = $_POST[$var];

	}
	/**
	 * parsa la richiesta e codifica l'html per impedire l'uso di tag
	 */
	function _array_htmlentities(& $elem) {
		if (!is_array($elem)) {
			$elem = htmlentities($elem);
		} else {
			foreach ($elem as $key => $value)
				$elem[$key] = $this->_array_htmlentities($value);
		}
		return $elem;
	}
	/**
	 * parsa la richiesta e codifica l'html per impedire l'uso di tag
	 */
	function _array_str_replace($search, $replace, & $elem) {
		if (!is_array($elem)) {
			$elem = str_replace($search, $replace, $elem);
		} else {
			foreach ($elem as $key => $value)
				$elem[$key] = $this->_array_str_replace($search, $replace, $value);
		}
		return $elem;
	}
}
?>