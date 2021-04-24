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
 * @package DWAddressbookDeskWeb
 */

/**
 * class DWAddressbookActionDeskweb
 */

class DWAddressbookActionDeskweb {

	/**
	 * class constructor
	 * la classe action viene invocata dal controller di Deskweb in modo da risparmiare
	 * memoria.
	 * Il nome di questo file deve rispettare questo patter
	 * nomeapp_action.php
	 * la classe si deve chiamare
	 * nomeappActionDeskweb
	 */

	function DWAddressbookActionDeskweb() {

		global $request;
		
		if (isset($request->form['applicazione']) && $request->form['applicazione'] == "dwaddressbook") {
			if (isset ($request->form['invia'])) {
				switch ($request->form['invia']) {
					case "inserisci" :
						$sql = "insert into ".PREFIX_DB."addressbook(nome,cognome) values ('nome','cognome')";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
					case "duplica" :
						$sql = "insert into ".PREFIX_DB."addressbook(
						nome, cognome, azienda, azienda_titolo,
						telefono_ufficio, fax_ufficio, telefono_cellulare,
						telefono_abitazione, fax_abitazione, cercapersone,
						homepage, email, ufficio_indirizzo, ufficio_cap,
						ufficio_localita, abitazione_indirizzo, abitazione_cap,
						abitazione_localita, data_nascita, note
						) values (
						'".$request->form['nome']."',
						'".$request->form['cognome']."',
						'".$request->form['azienda']."',
						'".$request->form['azienda_titolo']."',
						'".$request->form['telefono_ufficio']."',
						'".$request->form['fax_ufficio']."',
						'".$request->form['telefono_cellulare']."',
						'".$request->form['telefono_abitazione']."',
						'".$request->form['fax_abitazione']."',
						'".$request->form['cercapersone']."',
						'".$request->form['homepage']."',
						'".$request->form['email']."',
						'".$request->form['ufficio_indirizzo']."',
						'".$request->form['ufficio_cap']."',
						'".$request->form['ufficio_localita']."',
						'".$request->form['abitazione_indirizzo']."',
						'".$request->form['abitazione_cap']."',
						'".$request->form['abitazione_localita']."',
						'".MySqlDao :: mkDate($request->form['data_nascita'])."',
						'".$request->form['note']."'
						)";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
					case "modifica" :
						$sql = "update ".PREFIX_DB."addressbook set 
						nome = '".$request->form['nome']."',
						cognome = '".$request->form['cognome']."',
						azienda = '".$request->form['azienda']."',
						azienda_titolo = '".$request->form['azienda_titolo']."',
						telefono_ufficio = '".$request->form['telefono_ufficio']."',
						fax_ufficio = '".$request->form['fax_ufficio']."',
						telefono_cellulare = '".$request->form['telefono_cellulare']."',
						telefono_abitazione = '".$request->form['telefono_abitazione']."',
						fax_abitazione = '".$request->form['fax_abitazione']."',
						cercapersone = '".$request->form['cercapersone']."',
						homepage = '".$request->form['homepage']."',
						email = '".$request->form['email']."',
						ufficio_indirizzo = '".$request->form['ufficio_indirizzo']."',
						ufficio_cap = '".$request->form['ufficio_cap']."',
						ufficio_localita = '".$request->form['ufficio_localita']."',
						abitazione_indirizzo = '".$request->form['abitazione_indirizzo']."',
						abitazione_cap = '".$request->form['abitazione_cap']."',
						abitazione_localita = '".$request->form['abitazione_localita']."',
						data_nascita = '".MySqlDao :: mkDate($request->form['data_nascita'])."',
						note = '".$request->form['note']."'
						where id_addressbook = '".$request->form['id_addressbook']."'";//echo $sql;
						$esito = MySqlDao :: updateDati($sql);
						break;
					case "elimina" :
						$sql = "delete from ".PREFIX_DB."addressbook where id_addressbook = '".$request->form['id_addressbook']."' limit 1";
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