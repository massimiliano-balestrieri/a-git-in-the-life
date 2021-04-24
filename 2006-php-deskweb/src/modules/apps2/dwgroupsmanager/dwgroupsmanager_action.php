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
 * @package DWGroupsmanagerDeskWeb
 */

/**
 * class DWGroupsmanagerActionDeskweb
 */

class DWGroupsmanagerActionDeskweb {

	var $allowUsers = false;
	/**
	 * class constructor
	 * la classe action viene invocata dal controller di Deskweb in modo da risparmiare
	 * memoria.
	 * Il nome di questo file deve rispettare questo patter
	 * nomeapp_action.php
	 * la classe si deve chiamare
	 * nomeappActionDeskweb
	 */

	function DWGroupsmanagerActionDeskweb() {
		$this->allowUsers = array (1);

		global $session;
		if (is_array($this->allowUsers) && in_array($session->getCurrentUser(), $this->allowUsers)) {
			global $request;
			if (isset ($request->form['applicazione']) && $request->form['applicazione'] == "dwgroupsmanager") {
				if (isset ($request->form['invia'])) {
					switch ($request->form['invia']) {
						case "inserisci" :
							$sql = "insert into ".PREFIX_DB."groups(groupname) values ('new_group')";
							//echo $sql;
							$esito = MySqlDao :: insertDati($sql);
							break;
						case "modifica" :
							$sql = "update ".PREFIX_DB."groups set groupname = '".$request->form['groupname']."' where id_group = '".$request->form['id_group']."';";
							//echo $sql;
							$esito = MySqlDao :: updateDati($sql);
							break;
						case "elimina" :
							$sql = "delete from ".PREFIX_DB."groups where id_group = '".$request->form['id_group']."' limit 1";
							//echo $sql;
							$esito = MySqlDao :: deleteDati($sql);
							break;
					}
					//header("Location:".$_SERVER['REQUEST_URI']);
				}
			}
		}
	}

}
?>