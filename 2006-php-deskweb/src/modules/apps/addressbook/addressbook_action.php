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