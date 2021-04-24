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
 * @package DWUsersmanagerDeskWeb
 */

/**
 * class DWUsersmanagerActionDeskweb
 */

class DWUsersmanagerActionDeskweb {

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

	function DWUsersmanagerActionDeskweb() {
		$this->allowUsers = array (1);

		global $session;
		if (is_array($this->allowUsers) && in_array($session->getCurrentUser(), $this->allowUsers)) {
			global $request;
			if (isset ($request->form['applicazione']) && $request->form['applicazione'] == "dwusersmanager") {
				if (isset ($request->form['invia'])) {
					switch ($request->form['invia']) {
						case "inserisci" :
							$sql = "insert into ".PREFIX_DB."users(username,pass,mail,fk_firstgroup,desktop_bg) values ('new_user','".$request->form['pass']."','','1000','green')";
							//echo $sql;
							$esito = MySqlDao :: insertDati($sql);
							break;
						case "modifica" :
							$sql = "update ".PREFIX_DB."users set username = '".$request->form['username']."',pass = '".$request->form['pass']."',mail = '".$request->form['mail']."',fk_firstgroup = '".$request->form['fk_firstgroup']."',desktop_bg = '".$request->form['desktop_bg']."' where id_user = '".$request->form['id_user']."';";
							//echo $sql;
							$esito = MySqlDao :: updateDati($sql);
							break;
						case "elimina" :
							$sql = "delete from ".PREFIX_DB."users where id_user = '".$request->form['id_user']."' limit 1";
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