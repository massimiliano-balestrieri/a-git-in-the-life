<?php



/**
 * Classe Modello Deskweb
 * questa classe contiene i dati che servono a deskweb
 */
class ModelDeskWeb {

	/*
	 * array menu contenuto nel db
	 */
	var $arr_menu = array ();
	/*
	 * array menujs contenuto nel db
	 */
	var $arr_menujs = array ();
	/*
	 * array contenente la navigazione
	 */
	var $id_contents = array ();
	/*
	 * array contenente i dati delle applicazioni aperte
	 */
	var $arr_contents = null;

	/*
	 * Class constructor
	 * la classe istanzia
	 * 
	 * il menu statico/db
	 * le sezioni 
	 * 
	 */
	function ModelDeskWeb($last = false) {

		global $request, $session;
		$this->arr_menu = $this->_loadMenu();
		if ($last) {
			$this->id_contents = array ($request->id);
		} else {
			$this->id_contents = array_keys($session->getActive());
		}

		$this->arr_contents = $this->_loadContents($this->id_contents);

		if ($session->getJavascript()) {
			$this->arr_menujs = $this->_loadMenuJs();
		}

	}
	/**
	 * metodo statico
	 * restituisce il parent
	 */
	function getParent($id) {

		$sql = "select fk_parent,is_sys from ".PREFIX_DB."node where  id_node='".$id."'";
		$fk = MySqlDao :: getDati($sql);
		//echo $id[0]['fk_parent'];
		if (isset ($fk[0]['fk_parent']) && $fk[0]['is_sys'] == 0)
			return $fk[0]['fk_parent'];
		else
			return $id;
	}
	/**
	 * metodo statico
	 * funzione beta per ricavare l'albero partendo da un nodo
	 */
	function getTree($id, & $tree, $is_parent = false) {

		if (is_array($id)) {
			for ($x = 0; $x <= sizeof($id) - 1; $x ++) {
				ModelDeskWeb :: getTree($id[$x], $tree);
			}
		}
		//destinazione (pattern per la sostituzione)
		if ($is_parent == false)
			$parent = "{destination}";
		else
			$parent = "{".$id."}";
		// campi sql
		$fields = "node, id_dom, type, application, window, fk_parent, icon, content, fk_menu, order_menu, last_date, is_sys, have_child, permissions, fk_user, fk_group";
		// estraggo il padre o i figli
		if ($is_parent == false)
			$sql = "select * from ".PREFIX_DB."node where id_node ='".$id."'";
		else
			$sql = "select * from ".PREFIX_DB."node where fk_parent ='".$id."' order by have_child desc";

		$temp = MySqlDao :: getDati($sql);
		//print_r($temp);die();
		for ($x = 0; $x <= sizeof($temp) - 1; $x ++) {
			//setto la destinazione
			$temp[$x]['fk_parent'] = $parent;
			$values = $temp[$x];
			$values = MySqlDao :: addSlashes($values);
			//rimuovo id
			unset ($values['id_node']);

			$values = join(",", $values);
			$temp[$x]['clone'] = "insert into ".PREFIX_DB."node (".$fields.") values(".@ $values.")";

			$temp2 = array ('id_node' => $temp[$x]['id_node'], 'fk_parent' => $temp[$x]['fk_parent'], 'clone' => $temp[$x]['clone']);

			$tree[] = $temp2;

			if ($temp[$x]['have_child'] == 1)
				ModelDeskWeb :: getTree($temp[$x]['id_node'], $tree, true);

		}
		return $tree;
	}
	/**
	 * metodo statico
	 * funzione beta per ricavare l'albero partendo da un nodo
	 * restituisce solo gli id (serve all'eliminazione)
	 */
	function getTreeId($id, & $tree, $is_parent = false) {

		if (is_array($id)) {
			for ($x = 0; $x <= sizeof($id) - 1; $x ++) {
				ModelDeskWeb :: getTreeId($id[$x], $tree);
			}
		}

		if ($is_parent == false)
			$sql = "select id_node,have_child from ".PREFIX_DB."node where id_node ='".$id."'";
		else
			$sql = "select id_node,have_child from ".PREFIX_DB."node where fk_parent ='".$id."' order by have_child desc";

		$temp = MySqlDao :: getDati($sql);

		for ($x = 0; $x <= sizeof($temp) - 1; $x ++) {
			$tree[] = $temp[$x]['id_node'];
			//trovo i figli
			if ($temp[$x]['have_child'] == 1)
				ModelDeskWeb :: getTreeId($temp[$x]['id_node'], $tree, true);
		}
		return $tree;
	}
	/**
	 * funzione pubblica statica
	 * verifica che una sezione sia leggibile
	 */
	function isReadable($id_sezione) {
		$sql = "select id_node from ".PREFIX_DB."node where id_node = '". $id_sezione ."' and".ModelDeskWeb :: _getSqlRealm(true);
		$dati = MySqlDao :: getDati($sql);
		if (isset ($dati[0]['id_node']))
			return true;
		else
			return false;
	}
	/**
	 * funzione pubblica statica
	 * verifica che una sezione sia scrivibile
	 */
	function isWriteable($id_sezione) {
		
		$sql = "select id_node from ".PREFIX_DB."node where id_node = '". $id_sezione ."' and".ModelDeskWeb :: _getSqlRealm($static = true, $writable = true);
		//echo $sql;
		$dati = MySqlDao :: getDati($sql);
		if (isset ($dati[0]['id_node']))
			return true;
		else
			return false;
			
		
	}
	/**
	 * funzione pubblica statica
	 * verifica se l'utente sia il proprietario della sezione
	 */
	function isOwner($id_sezione) {
		$sql = "select id_node,fk_user,is_sys from ".PREFIX_DB."node where id_node ='".$id_sezione."'";
		$temp = MySqlDao :: getDati($sql);

		global $session;
		$user = $session->getCurrentUser();
		if ($user == $temp[0]['fk_user'] && $temp[0]['is_sys'] == 0) {
			return true;
		} else
			return false;
	}
	/*
	 * metodi pubblici 
	 */
	function is_sys($id_sezione) {
		$sql = "select is_sys from ".PREFIX_DB."node where id_node='".$id_sezione."'";
		$dati = MySqlDao :: getDati($sql);
		return $dati[0]['is_sys'];
	}
	/*
	* carica il menu js
	 */
	function _loadMenuJs() {
		global $session;
		$idmenu_app = 1;
		$idmenu_places = 2;
		$idmenu_sys = 3;

		$user = $session->getCurrentUser();
		$group = $session->getCurrentGroup();
		// 2 livelli di profondit�
		// padri
		$sql = "select id_node,node,icon,type,fk_parent,have_child,fk_menu  from ".PREFIX_DB."node where fk_parent in(".$idmenu_app.",".$idmenu_places.",".$idmenu_sys.") and ".$this->_getSqlRealm();
		$padri = MySqlDao :: getDati($sql);
		if (is_array($padri)) {
			for ($x = 0; $x <= sizeof($padri) - 1; $x ++) {
				$ids[] = $padri[$x]['id_node'];
			}
			//print_r($padri);
			$id_padri = join($ids, ",");
			// figli
			$sql = "select id_node,node,icon,type,fk_parent,have_child from ".PREFIX_DB."node where fk_parent in(".$id_padri.") and ".$this->_getSqlRealm();
			$figli = MySqlDao :: getDati($sql);
			// figli

			return $menujs = array ('padri' => $padri, 'figli' => $figli);
		}
	}
	function _getSqlRealm($static = false, $checkwritable = false) {
		if (!$static) {
			global $session;
			$user = $session->getCurrentUser();
			$group = $session->getCurrentGroup();
		} else {
			$user = $_SESSION['AUTH']['USER'];
			$group = $_SESSION['AUTH']['GROUP'];
		}
		// compongo l'sql per l'estrazione sicura dei dati
		// 1) is_owner
		$sql_owner = " (fk_user = '".$user."')";
		// 2) is_group and is readable from group
		$sql_group = " (fk_group = '".$group."' and substring(permissions,4,1) = 'r')";
		// 5) is public readable
		$sql_public_read = "(substring(permissions,7,1) = 'r')";
		
		$sql_write = "";
		if($checkwritable){
		// and 
		$sql_write .= " and (";
		// 6) is_group writable
		$sql_group_writable = " (fk_group = '".$group."' and substring(permissions,5,1) = 'w') ";
		// 7) is_public wirtable 
		$sql_public_writable = "(substring(permissions,8,1) = 'w')";
		
		$sql_write .= $sql_owner . " or " . $sql_group_writable . " or ".  $sql_public_writable . " )";
		}
		//union policy
		$sql = $sql_owner." or ".$sql_group." or ".$sql_public_read;
		return "(".$sql.")".$sql_write;
	}
	/*
	 * carica il menu
	 */
	function _loadMenu() {
		global $session;
		$user = $session->getCurrentUser();
		$sql = "select id_node,node,icon,type,id_dom,fk_menu from ".PREFIX_DB."node where fk_menu>0 and ".$this->_getSqlRealm();
		//(fk_user = '".$user."' or (fk_user = 0 and fk_group = 0)) order by fk_menu,order_menu";
		return MySqlDao :: getDati($sql);
	}
	/*
	 * carica i dati delle applicazioni in memoria
	 */
	function _loadContents($id_contents) {
		$ids = implode(",", $id_contents);
		if (strlen($ids) > 0) {
			$sql = "select id_node,node,type,application,window,icon,permissions,fk_user,fk_group,have_child,last_date,username,groupname from ".PREFIX_DB."node,".PREFIX_DB."users ,".PREFIX_DB."groups where id_user = fk_user and id_group = fk_group and id_node in(".$ids.") and ".$this->_getSqlRealm();
			$dati = MySqlDao :: getDati($sql);

			//$this->_checkPermissions($dati, "fathers");

			for ($x = 0; $x <= count($dati) - 1; $x ++) {
				global $session;
				$apps = $session->getActiveDeskwebApps();
				$session->addDeskwebApp($dati[$x]['application']);

				if ($dati[$x]['have_child'] == 1) {
					$sql = "select id_node,node,icon,type,id_dom,permissions,fk_user,fk_group,last_date,username,groupname from ".PREFIX_DB."node ,".PREFIX_DB."users ,".PREFIX_DB."groups where id_user = fk_user and id_group = fk_group and fk_parent ='".$dati[$x]['id_node']."' and ".$this->_getSqlRealm()." order by type,node";
					$dati[$x]['sons'] = MySqlDao :: getDati($sql);
					//$this->_checkPermissions($dati[$x]['sons'], "sons");
				}
			}
			return $dati;
		}

	}
	/*
	 * verifica i permessi delle sezioni e restituisce le sezioni che l'utente 
	 * � abilitato a vedere
	 * 
	 * todo:
	 * nelle richieste ajax non ricordo se questo metodo venga invocato
	 */
	function _checkPermissions(& $dati, $livello) {
		if ($this->_isRoot())
			return;
		$arr_uscita = array ();
		for ($x = 0; $x <= count($dati) - 1; $x ++) {
			if (!$this->_isReadable($dati[$x], $livello))
				$arr_uscita[] = $x;
		}
		for ($x = 0; $x <= count($arr_uscita) - 1; $x ++) {
			//if ($livello == "ids" && isset ($_SESSION['id_sezioni'][SessionDeskWeb :: pos_array($_SESSION['id_sezioni'], $dati[$arr_uscita[$x]]['id_node'])])) {
			//	session_start();
			//	unset ($_SESSION['id_sezioni'][SessionDeskWeb :: pos_array($_SESSION['id_sezioni'], $dati[$arr_uscita[$x]]['id_node'])]);
			//	session_write_close();
			//}
			//unset ($dati[$arr_uscita[$x]]);
		}
		if (count($dati) > 0);
		//sort($dati);
		if (count($dati) == 0)
			$dati = null;
	}
	/*
	 * verifica se l'utente � root
	 * 
	 * todo:
	 * verificare quale sia l'id da assegnare a root (penso che alla fine sar� 1)
	 */
	function _isRoot() {
		global $session;
		$user = $session->getCurrentUser();
		if ($user == 1)
			return true;
		else
			return false;
	}
	/*
	 * verifica se l'utente sia il proprietario della sezione
	 */
	function _isOwner($dato) {
		global $session;
		$user = $session->getCurrentUser();
		if ($user == $dato || $dato == 0) {
			return true;
		} else
			return false;
	}
	/*
	 * verifica se l'utente appartenga al gruppo della sezione
	 * 
	 * todo:
	 * implementare le politiche e la gestione dei gruppi
	 */
	function _isGroup($dato) {
		global $session;
		$group = $session->getCurrentGroup();
		if ($group == $dato || $dato == 0)
			return true;
		else
			return false;
	}
	/*
	 * verifica che una sezione sia leggibile
	 */
	function _isReadable($dati, $livello) {
		//se � una directory
		if ($dati['type'] == 'dir') {
			if ($dati['permissions'][6] == 'r' && $livello == "sons") {
				return true;
			}
			elseif ($dati['permissions'][8] == 'x' && $livello == "fathers") {
				return true;
			}
			elseif ($dati['permissions'][5] == 'x' and $this->_isGroup($dati['fk_group'])) {
				return true;
			}
			elseif ($dati['permissions'][2] == 'x' and $this->_isOwner($dati['fk_user'])) {
				return true;
			} else {
				return false;
			}
		} else {
			if ($dati['permissions'][6] == 'r') {
				return true;
			}
			elseif ($dati['permissions'][3] == 'r' and $this->_isGroup($dati['fk_group'])) {
				return true;
			}
			elseif ($dati['permissions'][0] == 'r' and $this->_isOwner($dati['fk_user'])) {
				return true;
			} else {
				return false;
			}
		}
	}

}
?>