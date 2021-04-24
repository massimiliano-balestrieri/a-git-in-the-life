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
 * @package DesktopManager
 */

/**
 * TastoPanelNav Widget
 */
class TastoPanelNav extends WidgetDeskWeb{
  
  /**
   * proprietà contenente la larghezza del tasto
   */
  var $larghezza_tasto = null;
  
  /**
   * Class constructor
   * Istanzia:
   * TitoloTastoPanelNav contenenete il titolo del tasto
   * Setta:
   * La larghezza
   */
  function TastoPanelNav($id_finestra,$numero_tasti,$nome_finestra,$icona){
    global $model,$request,$session;
    $active = true;
    $this->larghezza_tasto = round(97/($numero_tasti))-1;
    $barra_titolo_tasto = new TitoloTastoPanelNav($id_finestra,$numero_tasti,$nome_finestra,$icona);
    $this->add_element($barra_titolo_tasto);
    $tasti = implode("@",array_keys($session->getActive()));
    $this->open_element = "<div id='bordo_tasto_panel_nav_livello_".$id_finestra."' class='bordo_tasto_panel_nav' style='width:".$this->larghezza_tasto."%'>\n<div id='tasto_panel_nav_livello_".$id_finestra."' class='tasto_panel_nav".$this->_set_active($active)."'";
    
	if($session->getJavascript())
		$this->open_element .= " onclick='color_active(".$id_finestra.",\"".$tasti."\",true);'";
		
	$this->open_element .=">\n";
	
    $this->close_element = "</div>\n</div>\n";
    
  }
  /**
   * setta il pulsante attivo
   */
  function _set_active($active){
    if ($active){
      return "_active";
    }
  }
 


}

?>