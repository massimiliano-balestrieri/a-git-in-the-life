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
 * @package DwEditorDeskweb
 */

/**
 * classe DwEditorActionDeskWeb
 */
class DwEditorActionDeskWeb {

	/**
	 * constructor class
	 */
	function DwEditorActionDeskWeb() {
		require_once (dirname(__FILE__)."/dweditor_config.php");
		$this->_checkGetPublicActions();

		$this->_checkPostNoPublicActions();
	}
	function _checkGetPublicActions() {

		global $request, $session;
		switch ($request->p) {

		}

	}
	function _checkPostNoPublicActions() {

		global $request, $session;
		//print_r($request);//die();
		if (isset ($request->form['annulla']))
			header("Location:".MAIN);

		//die();
		if (!isset ($request->form['annulla']) && count($request->form) > 0  && @$request->form['applicazione'] == "dweditor" ) {

			//CREAZIONI FILE
			if (isset ($request->form['type'])) {

				switch ($request->form['type']) {
					case "html" :
						//crea txt
						if (@ strlen($request->form['icona']) == 0)
							$request->form['icona'] = "html.png";

						$request->form['node'] = $request->form['nome_file'];
						$request->form['application'] = "dweditor";
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
			if (isset ($request->form['p'])) {
				switch ($request->form['p']) {
					case ACTION_SAVE_DWEDITOR :
						$sql = "update ".PREFIX_DB."node set content = '".addslashes($request->richform['contenuto'])."' where id_node = '".$request->id."'";
						//echo $sql;die();
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