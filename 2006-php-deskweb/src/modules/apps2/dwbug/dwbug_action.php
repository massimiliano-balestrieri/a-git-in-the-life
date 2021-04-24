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
 * @package BugDeskweb
 */

/**
 * class BugActionDeskweb
 */

class DWBugActionDeskweb {
	/**
	 * class constructor
	 * la classe action viene invocata dal controller di Deskweb in modo da risparmiare
	 * memoria.
	 * Il nome di questo file deve rispettare questo patter
	 * nomeapp_action.php
	 * la classe si deve chiamare
	 * nomeappActionDeskweb
	 */

	function DWBugActionDeskweb() {
		global $request,$session;
		if (isset ($request->form['applicazione']) && $request->form['applicazione'] == "dwbug") {
			if (isset ($request->form['invia'])) {
				switch ($request->form['invia']) {
					case "duplica" :
						$sql = "insert into ".PREFIX_DB."bug(titolo,data,risolto,descrizione,fk_user) values ('".$request->form['titolo']."','".$request->form['data']."','".$request->form['risolto']."','".$request->form['descrizione']."','".$request->form['fk_user']."')";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
					case "inserisci" :
						$sql = "insert into ".PREFIX_DB."bug(titolo,data,risolto,descrizione,fk_user) values ('nome bug','".date('Y-m-d H:i:s')."','0','','".$session->getCurrentUser()."')";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
					case "modifica" :
						$sql = "update ".PREFIX_DB."bug set titolo = '".$request->form['titolo']."',data = '".MySqlDao :: mkDate($request->form['data'])."',risolto = '".$request->form['risolto']."',descrizione = '".$request->form['descrizione']."',fk_user = '".$session->getCurrentUser()."' where id_bug = '".$request->form['id_bug']."';";
						//echo $sql;
						$esito = MySqlDao :: updateDati($sql);
						break;
					case "elimina" :
						$sql = "delete from ".PREFIX_DB."bug where id_bug = '".$request->form['id_bug']."' limit 1";
						//echo $sql;
						$esito = MySqlDao :: deleteDati($sql);
						break;
				}
				//header("Location:".$_SERVER['REQUEST_URI']);
			}
		}
	}

}
?>