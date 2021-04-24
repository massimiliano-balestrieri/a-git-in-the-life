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
 * @package WishlistDeskweb
 */

/**
 * class WishlistActionDeskweb
 */

class DWWishlistActionDeskweb {
	/**
	 * class constructor
	 * la classe action viene invocata dal controller di Deskweb in modo da risparmiare
	 * memoria.
	 * Il nome di questo file deve rispettare questo patter
	 * nomeapp_action.php
	 * la classe si deve chiamare
	 * nomeappActionDeskweb
	 */

	function DWWishlistActionDeskweb() {
		global $request,$session;
		if (isset ($request->form['applicazione']) && $request->form['applicazione'] == "dwwishlist") {
			if (isset ($request->form['invia'])) {
				switch ($request->form['invia']) {
					case "duplica" :
						$sql = "insert into ".PREFIX_DB."wishlist(titolo,data,esaudito,descrizione,fk_user) values ('".$request->form['titolo']."','".$request->form['data']."','".$request->form['esaudito']."','".$request->form['descrizione']."','".$request->form['fk_user']."')";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
					case "inserisci" :
						$sql = "insert into ".PREFIX_DB."wishlist(titolo,data,esaudito,descrizione,fk_user) values ('nome wishlist','".date('Y-m-d H:i:s')."','0','','".$session->getCurrentUser()."')";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
					case "modifica" :
						$sql = "update ".PREFIX_DB."wishlist set titolo = '".$request->form['titolo']."',data = '".MySqlDao :: mkDate($request->form['data'])."',esaudito = '".$request->form['esaudito']."',descrizione = '".$request->form['descrizione']."',fk_user = '".$session->getCurrentUser()."' where id_wishlist = '".$request->form['id_wishlist']."';";
						//echo $sql;
						$esito = MySqlDao :: updateDati($sql);
						break;
					case "elimina" :
						$sql = "delete from ".PREFIX_DB."wishlist where id_wishlist = '".$request->form['id_wishlist']."' limit 1";
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