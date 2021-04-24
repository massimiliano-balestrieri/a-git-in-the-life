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
 * classe SystemModelDeskWeb
 */
class SystemModelDeskWeb {

	/**
	 * array dati weblets
	 */
	var $arr_system = array ();
	/**
	 * numero di record
	 */
	var $num_record;
	/**
	 * int paging
	 */
	var $paging = 5;
	/**
	 * costruttore
	 * prende da metodo statico di dao i dati che servono all'applicazione
	 */
	function SystemModelDeskWeb() {
		global $request;
		$orderby = null;
		$where = null;
		$limit = null;

		if (isset ($request->form['page'])) {
			$partida = ($request->form['page'] - 1) * $this->paging;
			$limit = " limit ".$partida.",".$this->paging;
		} else {
			$limit = " limit 0,".$this->paging;
		}

		if (isset ($request->form['orderby']) || isset ($request->form['firstletterwhere']) || isset ($request->form['filterwhere'])) {
			$sql = "SHOW FIELDS FROM ".PREFIX_DB."node";
			$dati = MySqlDao :: getDati($sql);
			$esito1 = false;
			$esito2 = false;
			$esito3 = false;
			if (isset ($request->form['firstletter']) && $request->form['firstletter'] == "TUTTI")
				$request->form['firstletter'] = "%";

			for ($x = 0; $x <= sizeof($dati) - 1; $x ++) {

				if (isset ($request->form['orderby']) && $dati[$x]['Field'] == $request->form['orderby'])
					$esito1 = true;
				if (isset ($request->form['firstletterwhere']) && $dati[$x]['Field'] == $request->form['firstletterwhere'])
					$esito2 = true;
				if (isset ($request->form['filterwhere']) && $dati[$x]['Field'] == $request->form['filterwhere'])
					$esito3 = true;
			}
			if ($esito1)
				$orderby = "order by ".$request->form['orderby'];
			if ($esito2)
				$where = "where ".$request->form['firstletterwhere']." like '".strtolower($request->form['firstletter'])."%'";
			if ($esito3)
				$where = "where ".$request->form['filterwhere']." like '%".strtolower($request->form['filter'])."%'";
		} else {
			$orderby = null;
		}
		//$sql = "select id_sezione, nome_sezione, data_ultima_modifica from maxb where tipo_contenuto = '6' order by data_ultima_modifica desc";
		$sql = "select * from ".PREFIX_DB."node ".$where.$orderby.$limit;
		
		$this->arr_system = MySqlDao :: getDati($sql);
		$sql = "select count(*) as num_record from ".PREFIX_DB."node ".$where.$orderby;
		//echo $sql;
		$dati = MySqlDao :: getDati($sql);
		$this->num_record = $dati[0]['num_record'];
	}
}
?>