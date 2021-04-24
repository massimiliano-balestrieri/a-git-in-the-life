<?php


/**
 * Project:     deskweb - the dekstop manager for web <br />
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
 * @package SystemDeskweb
 */

/**
 * class SystemActionDeskweb
 */

class SystemActionDeskweb {
	/**
	 * class constructor
	 * la classe action viene invocata dal controller di Deskweb in modo da risparmiare
	 * memoria.
	 * Il nome di questo file deve rispettare questo patter
	 * nomeapp_action.php
	 * la classe si deve chiamare
	 * nomeappActionDeskweb
	 */

	function SystemActionDeskweb() {
		global $request;
		if (isset($request->form['applicazione']) && $request->form['applicazione'] == "system") {
			if (isset ($request->form['invia'])) {
				switch ($request->form['invia']) {
					case "duplica" :
						$sql = "insert into ".PREFIX_DB."node(" .
								"node,id_dom,type," .
								"application,window,fk_parent," .
								"icon,content,fk_menu," .
								"order_menu,last_date," .
								"have_child,permissions,fk_user," .
								"fk_group " .
								") values (" .
								"'".$request->form['node']."'," .
								"'".$request->form['id_dom']."'," .
								"'".$request->form['type']."'," .
								"'".$request->form['application']."'," .
								"'".$request->form['window']."'," .
								"'".$request->form['fk_parent']."'," .
								"'".$request->form['icon']."'," .
								"'".$request->richform['content']."'," .
								"'".$request->form['fk_menu']."'," .
								"'".$request->form['order_menu']."'," .
								"'".$request->form['last_date']."'," .
								"'".$request->form['have_child']."'," .
								"'".$request->form['permissions']."'," .
								"'".$request->form['fk_user']."'," .
								"'".$request->form['fk_group']."')";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
					case "inserisci" :
						$sql = "insert into ".PREFIX_DB."node(" .
								"node,id_dom,type," .
								"application,window,fk_parent," .
								"icon,content,fk_menu," .
								"order_menu,last_date," .
								"have_child,permissions,fk_user," .
								"fk_group " .
								") values (" .
								"'nuovo'," .
								"''," .
								"'txt'," .
								"'nano'," .
								"''," .
								"'".DEFAULT_SAVE_POSITION."'," .
								"'icon.png'," .
								"''," .
								"''," .
								"''," .
								"'".date("Y-m-d h:i:s")."'," .
								"'0'," .
								"'rwx------'," .
								"'0'," .
								"'0')";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
						case "modifica" :
					//print_r($request->form);
						$sql = "update ".PREFIX_DB."node set" .
							   " node = '".$request->form['node']."',id_dom = '".$request->form['id_dom']."',type = '".$request->form['type']."', " .
							   " application = '".$request->form['application']."',window = '".$request->form['window']."',fk_parent = '".$request->form['fk_parent']."', " .
							   " icon = '".$request->form['icon']."',content = '".$request->richform['content']."',fk_menu = '".$request->form['fk_menu']."', " .
							   " order_menu = '".$request->form['order_menu']."',last_date = '".date("Y-m-d h:i:s")."', " .
							   " have_child = '".$request->form['have_child']."',permissions = '".$request->form['permissions']."',fk_user = '".$request->form['fk_user']."', " .
							   " fk_group = '".$request->form['fk_group']."'".
							   " where id_node = '".$request->form['id_node']."';";
						//echo $sql;
						$esito = MySqlDao :: insertDati($sql);
						break;
					case "elimina" :
						$sql = "delete from ".PREFIX_DB."node where id_node = '".$request->form['id_node']."' limit 1";
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