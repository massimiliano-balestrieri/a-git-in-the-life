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
 * WindowTitleBarDeskWeb Widget
 */

class WindowTitleBarDeskWeb extends WidgetDeskWeb
{

	/**
	 * Constructor class
	 * La classe costruttore disegna la barra del titolo di una generica finestra
	 * Istanzia:
	 * L'icona della finestra
	 * Il titolo
	 * Le icone per ridurre chiudere ingrandire
	 */	
	  function WindowTitleBarDeskWeb($id_finestra,$nome_finestra,$icona,$tipo,$coordinate,$isTrackable)
	  {

		$icona_sezione = new ImageDeskWeb();
		$icona_sezione->set_classname("icona_sezione");
		$icona_sezione->set_dim("12x12");
		$icona_sezione->set_src_mime($icona,$tipo);
		$icona_sezione->set_alt("icona sezione");
		$icona_sezione->crea_tag();
		
		$titolo_sezione = new TextDeskWeb();
		$titolo_sezione->set_classname("titolo_sezione");
		$titolo_sezione->set_text($nome_finestra);
		$titolo_sezione->crea_tag();
		
		$this->add_element($icona_sezione);
		$this->add_element($titolo_sezione);
		
		if($isTrackable){
		$iconizza_win = new ImageDeskWeb();
		$iconizza_win->set_id("iconizza_win_".$id_finestra);
		$iconizza_win->set_classname("iconizza_win");
		$iconizza_win->set_alt("iconizza finestra");
		$iconizza_win->set_src_mime("iconizza.gif");
		//$iconizza_win->set_onclick("settaWin",($id_finestra.","."\"minimize\""));
		$iconizza_win->crea_tag();
		$ingrandisci_win = new ImageDeskWeb();
		$ingrandisci_win->set_id("ingrandisci_win_".$id_finestra);
		$ingrandisci_win->set_classname("ingrandisci_win");
		$ingrandisci_win->set_alt("ingrandisci finestra");
		$ingrandisci_win->set_src_mime("pieno_schermo.gif");
		//$ingrandisci_win->set_onclick("settaWin",($id_finestra.","."\"maximize\""));
		$ingrandisci_win->set_href(array("id"=>$id_finestra,"action"=>ACTION_VIEW_FULLSCREEN));
		$ingrandisci_win->crea_tag();
	    $chiudi_win = new ImageDeskWeb();
		$chiudi_win->set_classname("chiudi_win");
		global $session;
		//if($session->getAjax()){
		//	$chiudi_win->set_onclick("TastiWindowAjax",($id_finestra.","."\"chiudi\""));
		//}else{
			$chiudi_win->set_href(array("id"=>$id_finestra,"action"=>ACTION_CLOSE_CONTENT));
		//}
		
		$chiudi_win->set_src_mime("chiudi.gif");
		$chiudi_win->set_alt("chiudi finestra");
		$chiudi_win->crea_tag();
		$this->add_element($iconizza_win);
	    $this->add_element($ingrandisci_win);
	    $this->add_element($chiudi_win);
		
		}
				
    	$this->open_element = "<div id='window_barra_titolo_".$id_finestra."' class='window_barra_titolo_1' "; //".$active."
    	if($isTrackable && $session->getJavascript()&& !$session->getFullscreen())
    	$this->open_element .= "onmousedown='dragAndResize(\"Drag\",\"".$id_finestra."\",event,".$coordinate['top'].",".$coordinate['right'].",".$coordinate['bottom'].",".$coordinate['left'].",".$coordinate['width'].",".$coordinate['height'].",".$coordinate['z'].",".$id_finestra.",".$session->getIdDesktopActive().");'>\n";
    	else
    	$this->open_element .= " style='cursor:auto;'>";
    	$this->close_element = "</div>\n";
  }



}

?>