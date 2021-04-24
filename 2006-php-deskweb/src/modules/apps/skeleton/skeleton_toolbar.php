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
 * @package SkeletonDeskweb
 */

/**
 * class SkeletonToolbar
 */

class SkeletonToolbar extends ToolbarDeskWeb {

	/**
	* class constructor
	*/
	function SkeletonToolbar($id_sezione) {
		$this->ToolbarDeskWeb();
		$icone = new ButtonDeskWeb();
		
		
		$icone->make($src = "1leftarrow.png", $dim = "22x22", $name = "n", $action = ACTION_LEFT, $alt = "indietro", "SessionDeskWeb::existPreviousRequest()");
		$icone->make($src = "1rightarrow.png", $dim = "22x22", $name = "n", $action = ACTION_RIGHT, $alt = "avanti", "SessionDeskWeb::existNextRequest()");
		$icone->make($src = "1uparrow.png", $dim = "22x22", $name = "n", $action = ACTION_UP, $alt = "su");
		$icone->make($src = "reload3.png", $dim = "22x22", $name = "n", $action = ACTION_RELOAD, $alt = "aggiorna");
		
		$icone->separator();
		
		$icone->make($src = "gohome.png", $dim = "22x22", $name = "n", $action = ACTION_GO_HOME, $alt = "home");
		$icone->make($src = "system.png", $dim = "22x22", $name = "n", $action = ACTION_GO_PUBLIC, $alt = "public");
		
		$icone->separator();
		
		
		$icone->make($src = "help.png", $dim = "22x22", $name = "n", $action = ACTION_GO_HELP, $alt = "aiuto", "disabled");
		
		$this->add_element($icone);
	}
	function add_element($object)
	{
		$this->open_element .= $object->open_element . $object->close_element;	
	}

}
?>