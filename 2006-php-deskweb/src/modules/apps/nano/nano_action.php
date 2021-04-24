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
 * @package NanoDeskweb
 */

/**
 * classe NanoActionDeskWeb
 */
class NanoActionDeskWeb {

	/**
	 * constructor class
	 */
	function NanoActionDeskWeb() {
		require_once (dirname(__FILE__)."/nano_config.php");
		$this->_checkGetPublicActions();

		$this->_checkPostNoPublicActions();
	}
	function _checkGetPublicActions() {

		global $request, $session;
		switch ($request->w) {

		}

	}
	function _checkPostNoPublicActions() {

		global $request, $session;
		//print_r($request);//die();
		if (isset ($request->form['annulla']))
			header("Location:".MAIN);

		//die();
		if (!isset ($request->form['annulla']) && count($request->form) > 0  && @$request->form['applicazione'] == "nano") {

			//CREAZIONI FILE
			if (isset ($request->form['type'])) {

				switch ($request->form['type']) {
					case "txt" :
						//crea txt
						if (@ strlen($request->form['icona']) == 0)
							$request->form['icona'] = "kate.png";

						$request->form['node'] = $request->form['nome_file'];
						$request->form['application'] = "nano";
						$request->form['have_child'] = 0;
						break;
				}
				$permessi = $request->recuperaPermessi();
				$sql = "insert into ".PREFIX_DB."node(node,fk_parent,type,application,icon,last_date,permissions,have_child,fk_user,fk_group)values("."'".$request->form['node']."',"."'".NANO_SAVE_POSITION."',"."'".$request->form['type']."',"."'".$request->form['application']."',"."'".$request->form['icona']."',"."'".date("Y-m-d H:i:s")."',"."'rwx---".$permessi."',"."'".$request->form['have_child']."',"."'".$session->getCurrentUser()."',"."'".$session->getCurrentGroup()."')";
				//echo $sql;die();
				if (@ strlen($request->form['node']) > 0)
					$id = MySqlDao :: insertDati($sql);
				header("Location:".MAIN."?id=".$id);
			}

			// ALTRE AZIONI
			if (isset ($request->form['w'])) {
				switch ($request->form['w']) {
					case ACTION_SAVE_NANO :
						$sql = "update ".PREFIX_DB."node set content = '".addslashes($request->form['contenuto'])."' where id_node = '".$request->id."'";
						//echo $sql;
						$aff = MySqlDao :: updateDati($sql);
						header("Location:".MAIN."?id=".$request->id);
						exit ();
						break;
					
				}
			}
		}
	}

}
?>