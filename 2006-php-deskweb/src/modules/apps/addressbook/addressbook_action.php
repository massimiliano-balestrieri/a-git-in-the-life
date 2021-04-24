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
 * @package AddressbookDeskweb
 */

/**
 * class AddressbookActionDeskweb
 */

class AddressbookActionDeskweb {

	/**
	 * class constructor
	 * la classe action viene invocata dal controller di Deskweb in modo da risparmiare
	 * memoria.
	 * Il nome di questo file deve rispettare questo patter
	 * nomeapp_action.php
	 * la classe si deve chiamare
	 * nomeappActionDeskweb
	 */

	function AddressbookActionDeskweb() {

		global $request;
		
		if (isset($request->form['applicazione']) && $request->form['applicazione'] == "addressbook") {
			if (isset ($request->form['invia'])) {
				switch ($request->form['invia']) {
					case "inserisci" :
						$sql = "insert into ".PREFIX_DB."addressbook(firstname,surname,address,city,cap,tel,cell,mail) values ('".$request->form['firstname']."','".$request->form['surname']."','".$request->form['address']."','".$request->form['city']."','".$request->form['cap']."','".$request->form['tel']."','".$request->form['cell']."','".$request->form['mail']."')";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
					case "modifica" :
						$sql = "update ".PREFIX_DB."addressbook set firstname = '".$request->form['firstname']."',surname = '".$request->form['surname']."',address = '".$request->form['address']."',city = '".$request->form['city']."',cap = '".$request->form['cap']."',tel = '".$request->form['tel']."',cell = '".$request->form['cell']."',mail = '".$request->form['mail']."' where id_addressbook = '".$request->form['id_addressbook']."';";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
					case "elimina" :
						$sql = "delete from ".PREFIX_DB."addressbook where id_addressbook = '".$request->form['id_addressbook']."' limit 1";
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