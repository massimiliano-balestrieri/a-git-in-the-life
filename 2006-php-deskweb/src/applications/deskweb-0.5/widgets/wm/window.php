<?php

/**
 * Project:     deskweb - the desktop manager for web <br />
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
 * @package Window Manager
 */

/**
 * WindowDeskWeb Widget
 */

class WindowDeskWeb extends WidgetDeskWeb {

	/**
	 * Id della finestra
	 */
	var $id_window = null;
	/**
	 * name of window
	 */
	var $name = null;
	/**
	 * L'applicazione contenuta nella finestra
	 */
	var $application = array ();
	/**
	 * La posizione sullo schermo della finestra
	 */
	var $position = "position:absolute;";
	/**
	 * Le coordinate della finestra
	 */
	var $coordinate = array ();
	/**
	 * Indica se la finestra è spostabile
	 */
	var $trackable = true;
	/**
	 * L'oggetto icona della finestra 
	 */
	var $icon = null;
	/**
	 * Il tipo di contenuto della finestra (determina l'applicazione)
	 */
	var $type = null;

	/**
	* Metodo crea_window
	* Crea l'oggetto finestra
	*/
	function build_window($id_finestra)
	{
		global $msgstack;
		global $request;
		global $session;

		$spazio_disponibile = 200000;
		$barra_titolo = new WindowTitleBarDeskWeb($id_finestra, $this->name, $this->icon, $this->type, $this->coordinate, $this->trackable);
		$barra_stato = new WindowStatusBarDeskWeb($id_finestra, $this->name, $this->coordinate, $this->trackable);
		$this->add_element($barra_titolo);
		$this->add_element($this->application[0]);
		$this->add_element($barra_stato);

		if (!isset ($request->ajax) && !$session->getFullscreen()) {
			$this->open_element = "<div id='content_window_".$id_finestra."'>\n";
		}

		$this->open_element .= "<div id='bordo_window_livello_".$id_finestra."' class='bordo_window_1' style='".$this->position."'>\n";
		$tasti = implode("@", array_keys($session->getActive()));
		$this->open_element .= "<div id='window_livello_".$id_finestra."' class='window' ";
		if ($this->trackable && $session->getJavascript() && !$session->getFullscreen())
			$this->open_element .= "onclick='color_active(".$id_finestra.",\"".$tasti."\",false)'";

		$this->open_element .= " >";
		$this->close_element = "</div>\n</div>\n";
		if (!isset ($request->ajax) && !$session->getFullscreen())
			$this->close_element .= "</div>\n";

	}
	/**
	* Metodo setId
	* setta l'id della finestra'
	*/
	function setId($id) {
		$this->id_window = $id;
	}
	/**
	* set name of window
	*/
	function set_name($name) {
		$this->name = $name;
	}
	/**
	* Metodo add_application
	* Aggiunge alla finestra l'oggetto applicazione
	*/
	function add_application($object) {
		array_push($this->application, $object);
	}
	/**
	* Setta le coordinate e quindi la posizione sullo schermo della finestra
	*/
	function build_position($id_finestra) {
		global $session;
		$this->ordine_finestra = $this->_getOrdine(array_keys($session->getActive()), $id_finestra);
		
		$active = $session->getActive();
		
		$this->coordinate['top'] = str_replace("px", "", $active[$id_finestra]['top']);
		$this->coordinate['left'] = str_replace("px", "", $active[$id_finestra]['left']);
		$this->coordinate['height'] = str_replace("px", "", $active[$id_finestra]['height']);
		$this->coordinate['width'] = str_replace("px", "", $active[$id_finestra]['width']);
		$this->coordinate['z'] = $active[$id_finestra]['z'];
		$this->coordinate['right'] = 0;
		$this->coordinate['bottom'] = 0;

		$this->position = "width:".$this->coordinate['width']."px;height:".$this->coordinate['height']."px;position:absolute;left:".$this->coordinate['left']."px;top:".$this->coordinate['top']."px;z-index:".$this->coordinate['z'].";";

	}
	function setFullscreen(){
		$this->position = "margin:auto;width:99%;height:99%;position:relative;";
	}
	/**
	* Setta la posizione
	*/
	function set_position($id_finestra, $top = false, $right = false, $bottom = false, $left = false, $width = false, $height = false, $z = false) {
		if ($top)
			$this->set_coord('top', $top, "px");
		if ($right)
			$this->set_coord('right', $right, "px");
		if ($bottom)
			$this->set_coord('bottom', $bottom, "px");
		if ($left)
			$this->set_coord('left', $left, "px");
		if ($width)
			$this->set_coord('width', $width, "px");
		if ($height)
			$this->set_coord('height', $height, "px");
		if ($z || $z == 0)
			$this->set_coord('z-index', $z);

	}
	/**
	* Setta le dimensioni della finestra
	*/
	function setDimension($width,$height)
	{
		global $session;
		$this->coordinate['height'] = $height;
		$this->coordinate['width'] = $width;
		$session->setWindowPosition($this->id_window, $height,$width);
	}
	/**
	* Setta una cordinata alla volta
	*/
	function set_coord($lato, $value, $unita = null) {
		$this->coordinate[$lato] = $value;
		$this->position .= $lato.":".$value.$unita.";";
	}
	/**
	* Setta la proprietà $trackable
	*/
	function set_trackable($value = true) {
		$this->trackable = $value;
	}
	/**
	* Setta l'icona
	*/
	function set_icon($nome, $tipo) {
		$this->icona = $nome;
		$this->tipo_contenuto = $tipo;
	}
	/**
	* Restituisce la posizione di una data win
	*/
	function _getOrdine(& $haystack, $needle) {
		$x = 0;
		foreach ($haystack as $key => $value) {
			if ($needle == $value) {
				return $x;
			}
			$x ++;
		}
		return false;
	}
}
?>