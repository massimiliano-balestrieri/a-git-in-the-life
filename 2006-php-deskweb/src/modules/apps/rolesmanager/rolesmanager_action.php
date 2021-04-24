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