<?php


/**
 * Project:     deskweb - the dekstop manager for web <br />
 */

/**
 * The table widget
 */
class TableDeskWeb extends FormDeskWeb {

	/**
	 * id_applicazione
	 */
	var $id_applicazione = null;
	/**
	 * string output
	 */
	var $output = null;

	/**
	 * int id_array
	 */
	var $id_array = null;
	/**
	 * int id_sezione
	 */
	var $id_sezione = null;

	/**
	 * order by value
	 */
	var $orderby = null;

	/**
	 * boolean writable
	 */
	var $writable = false;

	/**
	 * string action
	 */
	var $action = null;
	/**
	 * int dettaglio
	 */
	var $dettaglio = null;
	/**
	 * string primary key
	 */
	var $pk = null;
	/**
	 * int page
	 */
	var $page = 1;
	/**
	 * string paging
	 */
	var $paging = null;
	/**
	 * array intestazioni
	 */
	var $intestazioni = array ();
	/**
	 * 
	 */
	var $fields = array();
	/**
	 * the initializator 
	 * istance of this class are simply label element
	 */
	function TableDeskWeb($id_array, $id_sezione, $id_applicazione, $intestazioni, $pk = null, $writable = false){
	
		global $request, $session;
		if (isset ($request->form['orderby']))
			$this->orderby = $request->form['orderby'];
		if (isset ($request->form['action']))
			$this->action = $request->form['action'];
		if (isset ($request->form['dettaglio']))
			$this->dettaglio = $request->form['dettaglio'];
		if (isset ($request->form['page']))
			$this->page = $request->form['page'];	
	
		$this->id_array = $id_array;
		$this->id_sezione = $id_sezione;
		$this->id_applicazione = $id_applicazione;
		$this->intestazioni = $intestazioni;
		$this->writable = $writable;
		$this->pk = $pk;
	
	}
	
	function InitTable() {

		global $request, $session;
		if (is_array($this->intestazioni)) {
			$this->output .= "<thead>\n<tr>\n";

			for ($x = 0; $x <= sizeof($this->intestazioni) - 1; $x ++) {
				//pulisco l'intestazione
				$str_intestazione = ucfirst(str_replace("_", " ", $this->intestazioni[$x]));
				if (strstr($str_intestazione, "Id"))
					$str_intestazione = "ID";
				/*if ($session->getAjax()) {
					$this->output .= "<th><a href='#' onclick='ajax_app(".$this->id_array.",".$this->id_sezione.",\"".$this->id_applicazione."\",\"orderby\",\"".$this->intestazioni[$x]."\");'>".$str_intestazione."</a></th>\n";
				}
				elseif ($session->getJavascript()) {
					$this->output .= "<th><a href='#' onclick='orderby(\"formTbl".$this->id_sezione."\",\"".$this->intestazioni[$x]."\");'>".$str_intestazione."</a></th>\n";
				} else {*/
					$this->output .= "<th><input class='tasto' type='submit' name='orderby' value='".$this->intestazioni[$x]."' /></th>\n";
				//}

			}
			//if ($this->writable && !(!$session->getAjax() && !$session->getJavascript()))
			//	$this->output .= "<th>Azioni</th>\n";

			$this->output .= "</tr></thead>\n";

		}

	}
	/**
	 * imposta la paginazione
	 */
	function setPaging($num_record, $record_for_page) {
		global $session;
		if ($num_record > 0) {

			$pages = ($num_record / $record_for_page);
			if (($num_record % $record_for_page) != 0)
				$pages ++;
			//if (!$session->getAjax() && !$session->getJavascript()) {
				$this->paging .= "<tr>\n<th colspan='0'>\n";
				$this->paging .= "<p><label class='small' for='page'>Pagine:</label> ";
			//} else {
			//	$this->paging .= "<tr>\n<th colspan='0'>\n<ul class='paging'> \n";
			//	$this->paging .= "<li>Pagine: </li>\n";
			//}
			for ($x = 1; $x <= $pages; $x ++) {

				/*if ($session->getAjax()) {
					if ($this->page == $x) {
						$this->paging .= "<li style='color:red'>".$x."</li>\n";
					} else {
						$this->paging .= "<li><a href='#' onclick='ajax_app(".$this->id_array.",".$this->id_sezione.",\"".$this->id_applicazione."\",\"page\",\"".$x."\");'>".$x."</a></li>\n";
					}
				}
				elseif ($session->getJavascript()) {
					if ($this->page == $x) {
						$this->paging .= "<li style='color:red'>".$x."</li>\n";
					} else {
						$this->paging .= "<li><a href='#' onclick='paging(\"formTbl".$this->id_sezione."\",".$x.");'>".$x."</a></li>\n";
					}
				} else {*/
					if ($this->page == $x) {
						$this->paging .= "<input class='paging' type='submit' name='page' value='".$x."' disabled='disabled' />\n";
					} else {
						$this->paging .= "<input class='paging' type='submit' name='page' value='".$x."' />\n";
					}
				//}
			}

			//if (!$session->getAjax() && !$session->getJavascript()) {
				$this->paging .= "</p>\n</th>\n</tr>\n";
			//} else {
			//	$this->paging .= "</ul>\n</th>\n</tr>\n";
			//}
		}

	}
	function setField($campo, $tipo){
		switch($tipo){
			case "progressbar"	:
				$this->fields[$campo] = "<div class='progressbar' style='background-color:red;width:{value}%;'>{value}%</div>";
			break;
		}	
	}
	/**
	 * costruisce la tabella con i dati passati in input
	 */
	function setDati($dati,$inserisci = true,$elimina = true,$modifica = true) {
		$pk = null;
		global $session;
		if (is_array($dati)) {
			$this->output .= "<tbody>\n";
			for ($x = 0; $x <= sizeof($dati) - 1; $x ++) {
				if($x%2)
				$class = " class='row_on'";
				else
				$class = " class='row_off'";
				
				$this->output .= "<tr$class>\n";

				while ($array_cell = each($dati[$x])) {
					if (in_array($array_cell['key'], $this->intestazioni)) {
						if ($this->pk == $array_cell['key'])
							$pk = $array_cell['value'];
							//!$session->getAjax() && !$session->getJavascript() && 
						if ($this->pk == $array_cell['key']) {
							$this->output .= "<td><input class='id_table' type='submit' name='dettaglio' value='".$pk."' /></td>\n";
						} else {
							//echo in_array($array_cell['key'],$this->fields);//($array_cell['key']);
							if(array_key_exists($array_cell['key'],$this->fields)){
								$field = str_replace("{value}",$array_cell['value'],$this->fields[$array_cell['key']]);
								$this->output .= "<td>".$field."</td>\n";
							}else{
								$this->output .= "<td>".$array_cell['value']."</td>\n";
							}
						}
					}
				}
				/*if ($this->writable) {
					if ($session->getAjax()) {
						$this->output .= "<th><a href='#' onclick='ajax_app(".$this->id_array.",".$this->id_sezione.",\"".$this->id_applicazione."\",\"action#dettaglio\",\"modifica#".$pk."\");'>Modifica</a> - <a href='#' onclick='formaction(\"formTbl".$this->id_sezione."\",\"elimina\",".$pk.");'>Elimina</a></th>\n";
					}
					elseif ($session->getJavascript()) {
						$this->output .= "<th><a href='#' onclick='formaction(\"formTbl".$this->id_sezione."\",\"modifica\",".$pk.");'>Modifica</a> - <a href='#' onclick='formaction(\"formTbl".$this->id_sezione."\",\"elimina\",".$pk.");'>Elimina</a></th>\n";
					}
				}*/
				$this->output .= "</tr>\n";
			}
			
			$this->output .= "</tbody>\n";
		}

	}
	function createTable($label, $visible = true) {
		global $session;
		$this->addFieldsPersistentToOutput();
		$this->PanelDeskWeb($this->id_sezione, $label, $visible);
		if ($this->classname)
			$this->classname = " class='".$this->classname."'";
		//if (!$session->getAjax() && !$session->getJavascript()) {
			$this->open_element .= "<form method='post' action='#'><table".$this->classname.">\n".$this->output."\n".$this->paging."\n</table>\n";
			
			$this->open_element .= $this->statefull . "</form>";
		//} else {
		//	$this->open_element .= "<table".$this->classname.">\n".$this->output."\n".$this->paging."\n</table>\n<form method='post' action='#' id='formTbl".$this->id_sezione."'><input type='hidden' id='formTbl".$this->id_sezione."_action' name='action' value='".$this->action."' /><input type='hidden' id='formTbl".$this->id_sezione."_orderby' name='orderby' value='".$this->orderby."' /><input type='hidden' id='formTbl".$this->id_sezione."_dettaglio' name='dettaglio' value='".$this->dettaglio."' /><input type='hidden' id='formTbl".$this->id_sezione."_page' name='page' value='".$this->page."' /></form>\n";
		//}
	}

}
?>