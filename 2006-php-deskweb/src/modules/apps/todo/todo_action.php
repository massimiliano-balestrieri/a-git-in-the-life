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
 * @package TodoDeskweb
 */

/**
 * class TodoActionDeskweb
 */

class TodoActionDeskweb {
	/**
	 * class constructor
	 * la classe action viene invocata dal controller di Deskweb in modo da risparmiare
	 * memoria.
	 * Il nome di questo file deve rispettare questo patter
	 * nomeapp_action.php
	 * la classe si deve chiamare
	 * nomeappActionDeskweb
	 */

	function TodoActionDeskweb() {
		global $request;
		if (isset ($request->form['applicazione']) && $request->form['applicazione'] == "todo") {
			if (isset ($request->form['invia'])) {
				switch ($request->form['invia']) {
					case "inserisci" :
						$sql = "insert into ".PREFIX_DB."todo(attivita,scadenza,percentuale,descrizione) values ('".$request->form['attivita']."','".$request->form['scadenza']."','".$request->form['percentuale']."','".$request->form['descrizione']."')";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
					case "modifica" :
						$sql = "update ".PREFIX_DB."todo set attivita = '".$request->form['attivita']."',scadenza = '".$request->form['scadenza']."',percentuale = '".$request->form['percentuale']."',descrizione = '".$request->form['descrizione']."' where id_todo = '".$request->form['id_todo']."';";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
					case "elimina" :
						$sql = "delete from ".PREFIX_DB."todo where id_todo = '".$request->form['id_todo']."' limit 1";
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