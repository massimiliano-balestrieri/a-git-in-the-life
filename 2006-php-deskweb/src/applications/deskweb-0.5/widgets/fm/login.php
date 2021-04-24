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
 * @package Dialog
 */

/**
 * LoginDialog Widget
 */
class LoginDialog extends DialogDeskWeb {
	
	/**
	 * constructor class
	 * Istanzia una finestra di dialogo con il form per effettuare il login
	 * Viene chiamato ogniqualvolta una dialog implementata vede che il livello di utenza richiesto non rispetta il livello in sezione   
	 */
	function LoginDialog() {
		
		$this->open_element .= "<div class='bordo_dialog'>\n"."<div class='dialog'>\n";
		$this->open_element .= "<div class='dialog_barra_titolo'>Login</div>\n"."<form method='post' action='".htmlspecialchars($_SERVER['REQUEST_URI'])."'>\n";
		$this->open_element .= "<p><label for='user_utente'>Username</label>"."<input type='text' name='user_utente' id='user_utente' value='' />"."</p>"."<p>"."<label for='p_utente'>Password</label>"."<input type='password' name='p_utente' id='p_utente' value='' />"."</p>";
		$this->open_element .= "<p><input class='button' type='submit' name='action'  value='".ACTION_TEXT_ANNULLA."' /><input type='submit' class='button' name='action' value='".ACTION_TEXT_REGISTER."' /><input type='submit' class='button' name='action' value='".ACTION_TEXT_LOGIN."' /></p>"."</form>\n";
		$this->close_element = "</div>\n</div>\n";

	}

}
?>