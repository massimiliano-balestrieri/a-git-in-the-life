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