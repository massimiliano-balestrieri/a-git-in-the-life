<?php

/**
 * The form widget
 */
class FormDeskWeb extends PanelDeskWeb {
	/**
	 * array allowUsers
	 */
	var $allowUsers = false;
	/**
	 * array page
	 */
	var $page = false;
	/**
	 * toolbar
	 */
	var $toolbar = false;
	/**
	 * array page
	 */
	var $firstpage = false;
	/**
	 * int lastid
	 */
	var $lastid = false;
	/**
	 * int firstid
	 */
	var $firstid = false;
	/**
	 * string output
	 */
	var $output = null;
	/**
	 * array fields 
	 */
	var $fields = array ();
	/**
	 * array fields 
	 */
	var $persistent_fields = array ();
	var $statefull = null;
	/**
	* the writoutputable field
	*/
	var $writable = false;
	/**
	 * the Constructor: instanzia LoginDialog se il contenuto non dell'oggetto non � editabile 
	 */
	function FormDeskWeb($id_sezione, $is_auth = true) {
		$this->id_sezione = $id_sezione;

		if ($is_auth) {
			if (ModelDeskWeb :: isWriteable($id_sezione)) {
				return true;
			} else {
				$dialog = new LoginDialog();
				$this->add_element($dialog);

			}
		}

	}
	function setAllowUsers($arr) {
		$this->allowUsers = $arr;
	}
	function addFormToolbar($id) {

		global $request;

		$prefix = null;
		$prefix_disabled = "dis_";
		$disabled = null;

		$isfirst = false;
		$islast = false;

		if ($id == $this->lastid)
			$islast = true;
		if ($id == $this->firstid)
			$isfirst = true;

		if (!$this->_isAllowUser()) {
			$disabled = " disabled='disabled' ";
			$prefix = $prefix_disabled;
		}

		$this->toolbar .= "<div class='toolbar_form'>\n";

		$this->toolbar .= "<input type='image' src='".DIR_MASK."/".$prefix."new.png' name='invia' alt='inserisci' value='inserisci' $disabled/>\n";
		$this->toolbar .= "<input type='image' src='".DIR_MASK."/".$prefix."save.png' name='invia' alt='modifica' value='modifica' $disabled/>\n";
		$this->toolbar .= "<input type='image' src='".DIR_MASK."/".$prefix."duplica.png' name='invia' alt='duplica' value='duplica' $disabled/>\n";
		$this->toolbar .= "<input class='toolbar_sp' type='image' src='".DIR_MASK."/".$prefix."cancel.png' name='invia' alt='annulla' value='annulla' $disabled/>\n";

		$this->toolbar .= "<input class='toolbar_sp' type='image' src='".DIR_MASK."/".$prefix."delete.png' name='invia' alt='elimina' value='elimina' />\n";
		if ($isfirst)
			$this->toolbar .= "<input type='image' src='".DIR_MASK."/dis_first.png' name='formtoolbar' alt='first' value='first' disabled='disabled' />\n";
		else
			$this->toolbar .= "<input type='image' src='".DIR_MASK."/first.png' name='formtoolbar' alt='first' value='first' />\n";

		if ($isfirst)
			$this->toolbar .= "<input type='image' src='".DIR_MASK."/dis_prev.png' name='formtoolbar' alt='prev' value='prev' disabled='disabled' />\n";
		else
			$this->toolbar .= "<input type='image' src='".DIR_MASK."/prev.png' name='formtoolbar' alt='prev' value='prev' />\n";

		if ($islast)
			$this->toolbar .= "<input type='image' src='".DIR_MASK."/dis_next.png' name='formtoolbar' alt='next' value='next' disabled='disabled' />\n";
		else
			$this->toolbar .= "<input type='image' src='".DIR_MASK."/next.png' name='formtoolbar' alt='next' value='next' />\n";

		if ($islast)
			$this->toolbar .= "<input type='image' src='".DIR_MASK."/dis_last.png' name='formtoolbar' alt='last' value='last' disabled='disabled' />\n";
		else
			$this->toolbar .= "<input type='image' src='".DIR_MASK."/last.png' name='formtoolbar' alt='last' value='last' />\n";

		$this->toolbar .= "</div>\n";
	}
	function preparePage() {
		$this->output .= "<div class='page_form'>\n";
	}

	function closePage() {
		$this->output .= "</div>\n";
	}
	/**
	 * metodo per settare i dati
	 */
	function setDati($table, $where, $value, $richform = false) {
		$sql = "select ".$where." from ".$table." order by ".$where." asc limit 1";
		$dati = MySqlDao :: getDati($sql);
		$this->firstid = $dati[0][$where];

		$sql = "select ".$where." from ".$table." order by ".$where." desc limit 1";
		$dati = MySqlDao :: getDati($sql);
		$this->lastid = $dati[0][$where];

		global $request;

		if ($value == "last")
			$value = $this->lastid;

		if (@ $request->form['invia'] == "elimina") {
			$request->form['formtoolbar'] = "del";
		}
		if (@ $request->form['invia'] == "inserisci") {
			$request->form['formtoolbar'] = "next";
		}
		if (@ $request->form['invia'] == "duplica") {
			$request->form['formtoolbar'] = "last";
			$value = $this->lastid;
			$request->form['dettaglio'] = $this->lastid;
			$request->form[$where] = $this->lastid;
		}
		$sql = null;
		switch (@ $request->form['formtoolbar']) {
			case "first" :
				$sql = "select * from ".$table." where ".$where." = '".$this->firstid."' limit 1";
				break;
			case "prev" :
				$sql = "select * from ".$table." where ".$where." <= '".$value."' order by ".$where." desc limit 2";
				break;
			case "del" :
				$sql = "select * from ".$table." where ".$where." <= '".$value."' order by ".$where." desc limit 1";
				break;
			case "next" :
				$sql = "select * from ".$table." where ".$where." >= '".$value."' limit 2";
				break;
			case "last" :
				$sql = "select * from ".$table." where ".$where." = '".$this->lastid."' limit 1";
				break;
			default :
				$sql = "select * from ".$table." where ".$where." = '".$value."'";
				break;
		}
		//echo $sql;
		$dati = MySqlDao :: getDati($sql);
		//print_r($dati);
		$dati[0] = $dati[count($dati) - 1];
		if (is_array($dati[0])) {
			$request->form['dettaglio'] = $dati[0][$where];
			while ($array_cell = each($dati[0])) {
				if (!isset ($request->form[$array_cell['key']]) || isset ($request->form['formtoolbar']) || isset ($request->form['invia']))
					$request->form[$array_cell['key']] = $array_cell['value'];
				elseif ($richform != false && in_array($array_cell['key'], $richform)) $request->form[$array_cell['key']] = stripslashes(stripslashes($request->richform[$array_cell['key']]));
			}
		}
		//print_r($request->form);
	}
	function addDateField($order, $label) {
		$str_label = ucfirst(str_replace("_", "", $label));

		global $header, $request, $session;

		if (isset ($request->form[$label]))
			$valore = $request->form[$label];
		else
			$valore = date("Y-m-d H:i:s");

		if ($session->getJavascript()) {
			$header->addScript("/libraries/jscalendar-1.0/calendar.js");
			$header->addScript("/libraries/jscalendar-1.0/lang/calendar-it.js");
			$header->addScript("/libraries/jscalendar-1.0/calendar-setup.js");
			$header->addCss("/libraries/jscalendar-1.0/calendar-green.css");

			require_once ($_SERVER['DOCUMENT_ROOT']."/libraries/jscalendar-1.0/calendar.php");
			$calendar = new DHTML_Calendar("/libraries/jscalendar-1.0/", "it");
			$arg1 = array ('firstDay' => 1, 'showsTime' => false, 'showOthers' => true, 'ifFormat' => '%d/%m/%Y', 'timeFormat' => '12');
			$arg2 = array ('class' => 'input_text', 'style' => 'text-align: center', 'name' => $label, 'value' => date('d/m/Y', strtotime($valore)));
			$str_calendar = $calendar->make_input_field($arg1, $arg2);
		} else {
			$str_calendar = "<input class='input_text' type='text' name='".$label."' value=\"".date('d/m/Y', strtotime($valore))."\" />";
		}

		$this->fields[$order] = "<p>\n<label for='".$label."'>\n".$str_label."</label>\n".$str_calendar."\n</p>\n";
	}
	/**
	 * metodo per aggiungere un campo select con dati provenienti da db
	 */
	function addSelectDb($order, $tabella, $campi, $label_scelta, $fk = false) {
		$sql = "select ".join(",", $campi)." from ".$tabella;
		$dati = MySqlDao :: getDati($sql);
		if ($fk)
			$label = str_replace("id", "fk", $campi[0]);
		else
			$label = $campi[0];

		$select = "<p>\n<label for='".$label."'>\n".$campi[1]."</label>\n<select name='".$label."'>\n";
		$select .= "<option value='default' selected='selected'>".$label_scelta."</option>\n";
		global $request;
		for ($x = 0; $x <= sizeof($dati) - 1; $x ++) {
			if (isset ($request->form[$label]) && $request->form[$label] == $dati[$x][$campi[0]]) {
				$select .= "<option value='".$dati[$x][$campi[0]]."' selected='selected'>".$dati[$x][$campi[1]]."</option>\n";
			} else {
				$select .= "<option value='".$dati[$x][$campi[0]]."'>".$dati[$x][$campi[1]]."</option>\n";
			}
		}
		$select .= "</select>\n</p>\n";
		$this->fields[$order] = $select;
	}
	/**
	 * 
	 */
	function addTreeButton($tabella, $campi, $pk) {
		$sql = "select ".join(",", $campi)." from ".$tabella;
		$dati = MySqlDao :: getDati($sql);

		$tree = null;
		global $request;
		for ($x = 0; $x <= sizeof($dati) - 1; $x ++) {
			if (isset ($request->form[$pk]) && $request->form[$pk] == $dati[$x][$campi[0]]) {
				//
				$tree .= "<p class='tree'>\n<input type='submit' name='".$pk."' disabled='disabled' value='".$dati[$x][$campi[0]]."' /><label for='".$pk."'>".$dati[$x][$campi[1]]."</label>\n</p>\n";
			} else {
				$tree .= "<p class='tree'>\n<input type='submit' name='".$pk."' value='".$dati[$x][$campi[0]]."' /><label for='".$pk."'>".$dati[$x][$campi[1]]."</label>\n</p>\n";
			}
		}
		$this->fields[$campi[0]] = $tree;
	}
	/**
	 * metodo per aggiungere n. campi input di tipo testo
	 */
	function addMultiInputText($campi) {
		global $request;
		while ($array_cell = each($campi)) {
			$str_label = ucfirst(str_replace("_", "", $array_cell['key']));
			$valore = null;
			if (isset ($request->form[$array_cell['key']]))
				$valore = $request->form[$array_cell['key']];
			$this->fields[$array_cell['value']] = "<p>\n<label for='".$array_cell['key']."'>".$str_label."</label>\n<input class='input_text' type='text' name='".$array_cell['key']."' value=\"".$valore."\" />\n</p>\n";
		}
	}
	/**
	 * 
	 */
	function addImage($campi, $path, $dim) {
		$temp = null;

		global $request;
		while ($array_cell = each($campi)) {
			$str_label = ucfirst(str_replace("_", "", $array_cell['key']));
			$valore = null;
			$temp = "<div>\n<label for='".$array_cell['key']."'>".$str_label."</label>\n";

			if (isset ($request->form[$array_cell['key']]))
				$valore = $request->form[$array_cell['key']];
			for ($x = 0; $x <= count($dim) - 1; $x ++) {
				$file = $_SERVER['DOCUMENT_ROOT'].$path.$dim[$x].$valore;
				//if (!is_file($file))
				//	$temp .= "<div class='field_image'><input type='file' name='".$array_cell['key']."' value='".$valore."' /><input type='submit' name='upload' value='carica' /></div>\n";
				//else
				$temp .= "<table class='field_image'><tr><th colspan='2'>Icona - ".$dim[$x]."</th></tr><tr><td style='width:40%' rowspan='5'><img src='".$path.$dim[$x].$valore."' alt='icona' /></td></tr><tr><td>File: ".$valore."</td></tr><tr><td>Size: ".@ (filesize($file) / 1000)." Kb</td></tr><tr><td>Type: ".substr($valore, strpos($valore, ".") + 1)."</td></tr></table>\n";

			}
			$temp .= "<label for='image'>&nbsp;</label><input type='hidden' name='".$array_cell['key']." 'value='".$valore."' /><input type='submit' name='image' value='reset' />";
			$temp .= "</div>\n";
			$this->fields[$array_cell['value']] = $temp;

		}
	}
	/**
	 * metodo per aggiungere n. campi textarea
	 */
	function addTextArea($campi, $style = null) {
		if ($style != null)
			$style = " style='".$style."'";
		global $request;
		while ($array_cell = each($campi)) {
			$str_label = ucfirst(str_replace("_", "", $array_cell['key']));
			$valore = null;
			if (isset ($request->form[$array_cell['key']]))
				$valore = $request->form[$array_cell['key']];
			$this->fields[$array_cell['value']] = "<p".$style.">\n<label for='".$array_cell['key']."'>".$str_label."</label>\n<textarea  name='".$array_cell['key']."' >".htmlentities($valore)."</textarea>\n</p>\n";
		}
	}

	/**
	 * metodo per aggiungere campo hidden
	 */
	function addMultiInputHidden($campo) {
		global $request;
		while ($array_cell = each($campo)) {
			$valore = null;
			if (isset ($request->form[$array_cell['key']]))
				$valore = $request->form[$array_cell['key']];
			$this->fields[$array_cell['value']] = "<p style='display:none;'>\n<label for='".$array_cell['key']."'>&nbsp;</label>\n<input type='hidden' name='".$array_cell['key']."' value='".$valore."' />\n</p>\n";
		}
	}
	/**
	 * metodo per aggiungere campo hidden
	 */
	function addMultiInputReadOnly($campo) {
		global $request;
		while ($array_cell = each($campo)) {
			$str_label = ucfirst(str_replace("_", "", $array_cell['key']));
			$valore = null;
			if (isset ($request->form[$array_cell['key']]))
				$valore = $request->form[$array_cell['key']];
			$this->fields[$array_cell['value']] = "<p>\n<label for='".$array_cell['key']."'>".$str_label."</label>\n<input class='input_text' readonly='readonly' type='text' name='".$array_cell['key']."' value='".$valore."' style='color:red;' />\n</p>\n";
		}
	}
	/**
	 * metodo per aggiungere campo hidden
	 */
	function addInputHiddenValue($campo, $value) {
		global $request;
		while ($array_cell = each($campo)) {
			$valore = $value;
			$this->fields[$array_cell['value']] = "<p style='display:none;'>\n<label for='".$array_cell['key']."'>&nbsp;</label>\n<input type='hidden' name='".$array_cell['key']."' value='".$valore."' />\n</p>\n";
		}
	}
	function addPage($pages, $label, $id_fields, $first = false) {
		if ($first)
			$this->firstpage = $label;
		$this->page[$label] = $id_fields;
		global $request;
		if (!isset ($request->form['formpage']) && $first == true)
			$class = " class='disformpage' disabled='disabled'";
		elseif (isset ($request->form['formpage']) && $request->form['formpage'] == $label) $class = " class='disformpage' disabled='disabled'";
		else
			$class = " class='formpage'";

		$this->output .= "<input style='width:".round(97 / $pages)."%;' type='submit' name='formpage' value='".$label."' ".$class."/>\n";
	}
	/**
	 * aggiunge nel corretto ordine i campi al form
	 */
	function addFieldsToOutput() {

		global $request;

		if (is_array($this->page)) {
			if (!isset ($request->form['formpage'])) {
				$page = $this->firstpage;
			} else {

				$page = $request->form['formpage'];
			}
		}

		if (@ !is_array($this->page[$page]))
			$page = $request->form['firstpage'];

		while ($array_cell = each($this->fields)) {
			if (isset ($page))
				if (!in_array($array_cell['key'], $this->page[$page])) {
					$field = str_replace("<p>", "<p style='display:none;'>", $array_cell['value']);
					$field = str_replace("<div>", "<div style='display:none;'>", $field);
					$this->output .= $field;

				} else {
					$this->output .= $array_cell['value'];
				}
		}
	}
	/**
	 * aggiunge i campi persistence
	 */
	function addFieldsPersistentToOutput() {
		while ($array_cell = each($this->persistent_fields)) {
			$this->statefull .= $array_cell['value'];
		}
	}
	/**
	 * aggiunge un parametri statefull
	 */
	function addStateFullParam($param) {
		$valore = null;
		global $request;
		if (isset ($request->form[$param]))
			$valore = $request->form[$param];
		$this->persistent_fields[$param] = "<p style='display:none;'>\n<label for='".$param."'>&nbsp;</label>\n<input type='hidden' name='".$param."' value='".$valore."' />\n</p>\n";
	}

	/**
	 * unione del form al panel
	 */
	function createForm($label, $applicazione, $visible = true) {
		@ ksort($this->fields);
		$this->addFieldsToOutput();
		$this->addFieldsPersistentToOutput();
		$this->PanelDeskWeb($this->id_sezione, $label, $visible);
		if ($this->classname)
			$this->classname = " class='".$this->classname."'";
		$this->open_element .= "<form class='deskwebform' method='post' action='#'>\n<input style='display:none;' type='hidden' name='applicazione' value='".$applicazione."' />".$this->output;

		if ($this->toolbar)
			$this->open_element .= $this->toolbar;
		$this->open_element .= $this->statefull."</form>\n";
	}
	/**
	*
	 */
	function _isAllowUser() {
		if (is_array($this->allowUsers)) {
			global $session;
			if (in_array($session->getCurrentUser(), $this->allowUsers)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
}
?>