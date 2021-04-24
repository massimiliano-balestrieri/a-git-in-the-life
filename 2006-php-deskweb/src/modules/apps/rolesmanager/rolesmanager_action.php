<?php

/** The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package RolesmanagerDeskweb
 */

/**
 * class RolesmanagerActionDeskweb
 */

class RolesmanagerActionDeskweb {
	/**
	 * class constructor
	 * la classe action viene invocata dal controller di Deskweb in modo da risparmiare
	 * memoria.
	 * Il nome di questo file deve rispettare questo patter
	 * nomeapp_action.php
	 * la classe si deve chiamare
	 * nomeappActionDeskweb
	 */

	function RolesmanagerActionDeskweb() {
		global $request; //print_r($request->form);
		if (isset ($request->form['applicazione']) && $request->form['applicazione'] == "rolesmanager") {
			if (isset ($request->form['invia'])) {
				switch ($request->form['invia']) {
					case "inserisci" :
						$sql = "insert into ".PREFIX_DB."roles(fk_user,fk_group,role) values ('".$request->form['fk_user']."','".$request->form['fk_group']."','".$request->form['role']."')";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
					case "elimina" :
						$sql = "delete from ".PREFIX_DB."roles where id_role = '".$request->form['id_role']."' limit 1";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
				}
				if (isset ($request->form['invia']) && $request->form['invia'] != 'scegli');

				//header("Location:".$_SERVER['REQUEST_URI']);
			}
		}
	}

}
?>