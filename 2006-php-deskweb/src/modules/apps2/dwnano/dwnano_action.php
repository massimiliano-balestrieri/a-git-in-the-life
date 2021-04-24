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
 * @package DWNanoDeskweb
 */

/**
 * classe DWNanoActionDeskWeb
 */
class DWNanoActionDeskWeb {

	/**
	 * constructor class
	 */
	function DWNanoActionDeskWeb() {
		require_once (dirname(__FILE__)."/dwnano_config.php");
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
						$request->form['application'] = "dwnano";
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