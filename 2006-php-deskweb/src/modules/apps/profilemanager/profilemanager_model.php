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
 * @package ProfilemanagerDeskweb
 */

/**
 * classe ProfilemanagerModelDeskWeb
 */
class ProfilemanagerModelDeskWeb {

	/**
	 * array dati weblets
	 */
	var $arr_profilemanager = array ();
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
	function ProfilemanagerModelDeskWeb() {
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
			$sql = "SHOW FIELDS FROM ".PREFIX_DB."users";
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
		$sql = "select id_user,username,pass,mail from ".PREFIX_DB."users ".$where.$orderby.$limit;
		//echo $sql;
		$this->arr_profilemanager = MySqlDao :: getDati($sql);
		$sql = "select count(*) as num_record from ".PREFIX_DB."users ".$where.$orderby;
		$dati = MySqlDao :: getDati($sql);
		$this->num_record = $dati[0]['num_record'];
	}
}
?>