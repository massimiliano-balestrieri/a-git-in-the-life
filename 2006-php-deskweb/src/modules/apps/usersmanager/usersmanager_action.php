<?php


/**
 * Project:     deskweb - the dekstop manager for web <br />
 *
 *
 * The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package UsersmanagerDeskweb
 */

/**
 * class UsersmanagerActionDeskweb
 */

class UsersmanagerActionDeskweb {
	/**
	 * class constructor
	 * la classe action viene invocata dal controller di Deskweb in modo da risparmiare
	 * memoria.
	 * Il nome di questo file deve rispettare questo patter
	 * nomeapp_action.php
	 * la classe si deve chiamare
	 * nomeappActionDeskweb
	 */

	function UsersmanagerActionDeskweb() {
		global $request;
		if (isset ($request->form['applicazione']) && $request->form['applicazione'] == "usersmanager") {
			if (isset ($request->form['invia'])) {
				switch ($request->form['invia']) {
					case "inserisci" :
						$sql = "insert into ".PREFIX_DB."users(username,pass,mail) values ('".$request->form['username']."','".$request->form['pass']."','".$request->form['mail']."')";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
					case "modifica" :
						$sql = "update ".PREFIX_DB."users set username = '".$request->form['username']."',pass = '".$request->form['pass']."',mail = '".$request->form['mail']."' where id_user = '".$request->form['id_user']."';";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
					case "elimina" :
						$sql = "delete from ".PREFIX_DB."users where id_user = '".$request->form['id_user']."' limit 1";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
				}
				header("Location:".$_SERVER['REQUEST_URI']);
			}
		}
	}

}
?>