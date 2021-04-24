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
 * @package Core
 */

/**
 * classe MySqlDao di deskweb
 * 
 * attraverso metodi statici da la possibilit� di avere i dati sotto forma di array associativi
 * 
 * todo:
 * creare il dao per oracle e postgree
 */
class MySqlDao {

	/**
	 * metodo getDati
	 * restituisce i dati di una select a db
	 */
	function getDati($sql) {
		$dati = null;
		global $conn, $link_db;
		$result = mysql_query($sql, $link_db);

		if (@ mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$dati[] = $row;
			}
			//print_r($dati);
			mysql_free_result($result);
		} else {
			if (mysql_error()) {
				if ($_SERVER['SERVER_NAME'] == "perseo.csi.it" || $_SERVER['REMOTE_ADDR'] == "127.0.0.1" || $_SERVER['REMOTE_ADDR'] == "10.0.0.10" || $_SERVER['REMOTE_ADDR'] == "10.0.0.1") {
					echo "<hr />Errore durante l'esecuzione di:<br />".$sql."<br>".mysql_error()."<hr />";
				}
			}
		}
		return $dati;
	}

	/**
	 * metodo insertDati
	 * restituisce l'id inserito
	 */
	function insertDati($sql) {
		$dati = null;
		global $conn, $link_db;
		$result = mysql_query($sql, $link_db);
		if (@ mysql_insert_id()) {
			$id = mysql_insert_id();
			return $id;
		}
		if (@ mysql_error()) {
			if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1" || $_SERVER['REMOTE_ADDR'] == "10.0.0.10" || $_SERVER['REMOTE_ADDR'] == "10.0.0.1") {
				echo "<hr />Erorre durante l'esecuzione di:<br />".$sql."<br>".mysql_error()."<hr />";
			}
		}

	}
	/**
	 * metodo deleteDati
	 * restituisce le righe interssate dalla sql
	 */
	function deleteDati($sql) {
		$dati = null;
		global $conn, $link_db;
		$result = mysql_query($sql, $link_db);

		if (mysql_affected_rows())
			return mysql_affected_rows();

		if (mysql_error()) {
			if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1" || $_SERVER['REMOTE_ADDR'] == "10.0.0.10" || $_SERVER['REMOTE_ADDR'] == "10.0.0.1") {
				echo "<hr />Erorre durante l'esecuzione di:<br />".$sql."<br>".mysql_error()."<hr />";
			}
		}

		mysql_close();
	}
	/**
	 * metodo updateDati
	 * restituisce le righe interessate
	 */
	function updateDati($sql) {
		$dati = null;
		global $conn, $link_db;
		$result = mysql_query($sql, $link_db);

		if (mysql_affected_rows())
			return mysql_affected_rows();

		if (mysql_error()) {
			if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1" || $_SERVER['REMOTE_ADDR'] == "10.0.0.10" || $_SERVER['REMOTE_ADDR'] == "10.0.0.1") {
				echo "<hr />Erorre durante l'esecuzione di:<br />".$sql."<br>".mysql_error()."<hr />";
			}
		}

	}
	/**
	 * metodo di supporto alla crezione di cloni 
	 * aggiunge gli apici ad ogni valore dell'array passato
	 */
	function addSlashes(& $elem) {
		if (!is_array($elem)) {
			$elem = "'".$elem."'";
		} else {
			foreach ($elem as $key => $value)
				$elem[$key] = MySqlDao :: addSlashes($value);
		}
		return $elem;
	}
	/**
	 * metodo per la conversione della data
	 */
	function mkDate($data) {
		$giorno = substr($data, 0, 2);
		$mese = substr($data, 3, 2);
		$anno = substr($data, 6, 4);
		return date("Y-m-d", mktime(0, 0, 0, $mese, $giorno, $anno));
	}
}
?>