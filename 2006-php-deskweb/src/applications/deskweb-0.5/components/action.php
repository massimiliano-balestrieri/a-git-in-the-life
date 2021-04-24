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
 * @package Core
 */

/**
 * classe Action
 */
class ActionDeskWeb {

	/**
	 * constructor class
	 */
	function ActionDeskWeb() {
		$this->_checkCancel();
		$this->_checkGetPublicActions();
		$this->_checkPostPublicActions();
		$this->_checkPostNoPublicActions();
	}
	function _checkGetPublicActions() {

		global $request, $session;
		switch ($request->action) {
			case ACTION_VIEW_FULLSCREEN :
				global $session, $request;
				$session->setFullscreen();
				header("Location:".MAIN."?id=".$request->id);
				exit ();
				break;
			case ACTION_CLOSE_CONTENTS :
				$session->purgeActive();
				header("Location:".MAIN);
				break;
			case ACTION_CLOSE_CONTENT : //chiudi la finestra cliccata
				$session->removeFromActive($request->id);
				header("Location:".MAIN);
				break;
			case ACTION_CLOSE_OTHER_CONTENT : //chiudi le altre finestre
				$session->removeOtherActive($request->id);
				header("Location:".MAIN);
				break;

		}

	}
	function _checkPostPublicActions() {

		global $request;
		///////////////////////////AZIONI
		//print_r($request->form);
		if (isset ($request->form['action'])) {
			switch ($request->form['action']) {
				case ACTION_TEXT_LOGIN :
					global $session, $request;
					if ($session->getAuthAttempt() < 3) {
						$sql = "select id_user,username,pass,fk_firstgroup,desktop_bg from ".PREFIX_DB."users where username='".$request->form['user_utente']."'";
						//echo $sql;
						$dati = MySqlDao :: getDati($sql);
						if (is_array($dati)) {
							if ($dati[0]['pass'] == md5($request->form['p_utente'])) {
								$session->authFromForm($dati[0]);
							}
						} else {
							$session->addAuthAttempt();
						}
						header("Location:".MAIN);
					}
					break;
				case ACTION_TEXT_REGISTER :
					global $session, $request;
					$sql = "select username,pass,fk_firstgroup,desktop_bg from ".PREFIX_DB."users where username='".$request->form['user_utente']."'";
					$dati = MySqlDao :: getDati($sql);
					if (!is_array($dati[0])) {
						$sql = "select id_user from ".PREFIX_DB."users order by id_user desc limit 1";
						$new_id_user = MySqlDao :: getDati($sql);
						$new_id_user = ++ $new_id_user[0]['id_user'];
						if ($new_id_user < 1000)
							$new_id_user = 1000;
						//$sql = "select id_group from ".PREFIX_DB."groups order by id_group desc limit 1";
						//$new_id_group = MySqlDao :: getDati($sql);
						//$new_id_group = ++$new_id_group[0]['id_group'];
						//$sql = "insert into ".PREFIX_DB."groups (id_group,groupname) values('".$new_id_group."','".$request->form['user_utente']."')";
						//$id_group = MySqlDao :: insertDati($sql);

						$new_id_group = 1000;

						$sql = "insert into ".PREFIX_DB."users (id_user,username,pass,mail,fk_firstgroup,desktop_bg) values('".$new_id_user."','".$request->form['user_utente']."','".md5($request->form['p_utente'])."','".$request->form['email']."','".$new_id_group."','".$request->form['color']."')";
						$id_user = MySqlDao :: insertDati($sql);

						$sql = "select id_user,username,pass,fk_firstgroup,desktop_bg from ".PREFIX_DB."users where username='".$request->form['user_utente']."'";
						//echo $sql;
						$dati = MySqlDao :: getDati($sql);
						$session->authFromForm($dati[0]);
						header("Location:".MAIN."?id=".$request->id."&action=".ACTION_CLOSE_CONTENT);
					}
					break;
			}
		}

		// ALTRE AZIONI
		if (isset ($request->form['n'])) {
			switch ($request->form['n']) {
				case ACTION_LEFT :
					global $session;
					$req = $session->getPreviousRequest();
					header("Location:".MAIN."?id=".$req);
					break;
				case ACTION_RIGHT :
					global $session;
					$req = $session->getNextRequest();
					header("Location:".MAIN."?id=".$req);
					break;
				case ACTION_CUT :
					if (!isset ($request->form['id_node']))
						return;
					global $session;
					$session->registerCut();
					break;
				case ACTION_COPY :
					if (!isset ($request->form['id_node']))
						return;
					$tree = ModelDeskWeb :: getTree($request->form['id_node'], $tree);
					global $session;
					$session->registerCopy($tree);
					header("Location:".MAIN);
					//echo "<pre>".print_r($tree,true)."</pre>";
					//die();
					break;
				case ACTION_PASTE :
					global $session, $request;
					$copy = $session->getClipboardCopy();
					if ($copy != null) {
						//echo "<pre>".print_r($copy,true)."</pre><hr>";
						$destinazione_iniziale = $request->id;
						$new_id = null;

						for ($x = 0; $x <= sizeof($copy) - 1; $x ++) {
							//echo strpos($copy[$x]['clone'],"{destination}")."<hr>";
							if (strpos($copy[$x]['clone'], "{destination}") > 0) {
								$sql = str_replace("{destination}", $destinazione_iniziale, $copy[$x]['clone']);
								//echo $copy[$x]['clone']."<hr>";
							} else {
								$parent = substr($copy[$x]['fk_parent'], 1, strlen($copy[$x]['fk_parent']) - 2);
								$sql = str_replace($copy[$x]['fk_parent'], $new_id[$parent], $copy[$x]['clone']);
								//echo $copy[$x]['clone']."<hr>";
							}
							$id = MySqlDao :: insertDati($sql);
							//prova
							$new_id[$copy[$x]['id_node']] = $id;
							//echo $sql."<hr>";
						}
						//echo "<pre>".print_r($new_id,true)."</pre><hr>";
						$session->purgeClipboard();
						header("Location:".MAIN);
						die();
					} else {
						if ($session->getClipboardFrom() != $request->id) {
							$sql = "update ".PREFIX_DB."node set fk_parent = '".$request->id."' where id_node  in(".join(",", $session->getClipboardNodes()).");";
							//echo $sql;//die();
							$rows = MySqlDao :: updateDati($sql);
							$session->purgeClipboard();
							header("Location:".MAIN);
						}
					}
					break;
				case ACTION_DELETE :
					if (!isset ($request->form['id_node']))
						return;
					$tree = ModelDeskWeb :: getTreeId($request->form['id_node'], $tree);
					//echo "<pre>".print_r($tree,true)."</pre><hr>";
					$sql = "delete from ".PREFIX_DB."node where id_node in(".join(",", $tree).")";
					//echo $sql;die();
					$delrows = MySqlDao :: deleteDati($sql);
					header("Location:".MAIN);
					exit ();
					break;
				case ACTION_DELETE_CONTENT :
					$sql = "delete from ".PREFIX_DB."node where id_node = '".$request->id."' limit 1";
					//echo $sql;
					$aff = MySqlDao :: updateDati($sql);
					header("Location:".MAIN."?id=".DEFAULT_SAVE_POSITION);
					exit ();
					break;
				case ACTION_RELOAD :
					global $request;
					header("Location:".MAIN."?id=".$request->id);
					exit ();
					break;
				case ACTION_GO_PUBLIC :
					global $session;
					header("Location:".MAIN."?id=".$session->getPublic());
					exit ();
					break;
				case ACTION_GO_HOME :
					global $session;
					header("Location:".MAIN."?id=".$session->getHomeCurrentUser());
					exit ();
					break;
				case ACTION_UP :
					global $request;
					$parent = ModelDeskWeb :: getParent($request->id);
					header("Location:".MAIN."?id=".$parent);
					exit ();
					break;
				case ACTION_VIEW_DETAILED :
					global $session, $request;
					$session->setView(VIEW_DETAILED);
					header("Location:".MAIN."?id=".$request->id);
					exit ();
					break;
				case ACTION_VIEW_ICON :
					global $session, $request;
					$session->setView(VIEW_ICON);
					header("Location:".MAIN."?id=".$request->id);
					exit ();
					break;
				case ACTION_VIEW_FULLSCREEN :
					global $session, $request;
					$session->setFullscreen();
					header("Location:".MAIN."?id=".$request->id);
					exit ();
					break;

			}
		}

	}
	function _checkCancel() {
		global $request;
		if (isset ($request->form['annulla']) || (isset ($request->form['action']) && $request->form['action'] == ACTION_TEXT_ANNULLA))
			header("Location:".MAIN);

	}
	function _checkPostNoPublicActions() {

		global $request, $session;

		//die();
		if ($session->getCurrentUser() > 0) {
			if (count($request->form) > 0 && !isset ($request->form['applicazione'])) {

				//CREAZIONI FILE
				if (isset ($request->form['type'])) {

					switch ($request->form['type']) {
						case "dir" :
							//////////////////////////////////////////////////////////CREA DIRECTORY//////////////////////////////////////////////////////////
							//print_r($_POST);
							if (@ strlen($request->form['icona']) == 0)
								$request->form['icona'] = "cartella.png";

							$request->form['node'] = $request->form['nome_file'];
							$request->form['application'] = "dwnautilus";
							$request->form['have_child'] = 1;
							break;
						case "html" :

							if (@ strlen($request->form['icona']) == 0)
								$request->form['icona'] = "html.png";

							$request->form['node'] = $request->form['nome_file'];
							$request->form['application'] = "dweditor";
							$request->form['have_child'] = 0;
							break;
						case "news" :
							#ver 0.3
							//crea news
							if (@ strlen($request->form['icona']) == 0)
								$request->form['icona'] = 'doc.png';

							$request->form['node'] = $request->form['nome_file'];
							$request->form['application'] = "dweditor";
							$request->form['have_child'] = 0;
							break;
						case "txt" :
							//crea txt
							if (@ strlen($request->form['icona']) == 0)
								$request->form['icona'] = "kate.png";

							$request->form['node'] = $request->form['nome_file'];
							$request->form['application'] = "dwnano";
							$request->form['have_child'] = 0;
							break;
						case "form" :
							//crea modulo
							if (@ strlen($request->form['icona']) == 0)
								$request->form['icona'] = "browser.png";

							$request->form['node'] = $request->form['nome_file'];
							$request->form['application'] = "dweditor";
							$request->form['have_child'] = 0;
							break;
						case "link" :
							#ver 0.3
							//crea link
							if (@ strlen($request->form['icona']) == 0)
								$request->form['icona'] = "web.png";
							if (!isset ($request->form['link'])) {
								$request->form['link'] = substr($request->form['nome_file'], strpos($request->form['nome_file'], "#") + 1);
								$request->form['nome_file'] = substr($request->form['nome_file'], 0, strpos($request->form['nome_file'], "#"));
							}
							$request->form['node'] = $request->form['nome_file']."#".$request->form['link'];
							$request->form['application'] = null;
							$request->form['have_child'] = 0;
							break;
						case "note" :
							#ver 0.3
							//crea nota
							$request->form['node'] = $request->form['nome_file'];
							$request->form['application'] = "dwnano";
							$request->form['icona'] = "klipper.png";
							$request->form['have_child'] = 0;
							break;
					}
					$permessi = $request->recuperaPermessi();
					$sql = "insert into ".PREFIX_DB."node(node,fk_parent,type,application,icon,last_date,permissions,have_child,fk_user,fk_group)values("."'".$request->form['node']."',"."'".$request->id."',"."'".$request->form['type']."',"."'".$request->form['application']."',"."'".$request->form['icona']."',"."'".date("Y-m-d H:i:s")."',"."'rwx---".$permessi."',"."'".$request->form['have_child']."',"."'".$session->getCurrentUser()."',"."'".$session->getCurrentGroup()."')";
					//echo $sql;//die();
					if (@ strlen($request->form['node']) > 0)
						$id = MySqlDao :: insertDati($sql);
					header("Location:".MAIN);
				}

			}
		}
	}

}
?>