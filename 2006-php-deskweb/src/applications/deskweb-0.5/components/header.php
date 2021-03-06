<?php

/**
 * classe header deskweb
 * 
 * produce l'header della applicazione
 * todo:
 * implementare nella classe widget e nelle classi applicazioni/windows un metodo che produca
 * l'header per poter riutilizzare i componenti anche fuori dall'applicazione 
 */

class HeaderDeskWeb {
	/**
	 * titolo della pagina 
	 */
	var $titolo = null;

	/**
	 * scripts inclusi
	 */
	var $arr_script = null;
	/**
	 * css incluso
	 */
	var $arr_css = null;

	/**
	 * constructor class
	 * crea il titolo dal modello
	 */
	function HeaderDeskWeb() {
		global $model;
		if (is_array($model->arr_contents))
			$this->titolo = ' - '.$model->arr_contents[count($model->arr_contents) - 1]['node'];

		global $session;
		if ($session->getJavascript()) {
			if($session->getUserAgent() == "ie"){
				$this->_addScript("/libraries/suckerfish/suckerfish.js");
				$this->_addScript("/libraries/suckerfish/goetter.js");
			}
			if ($session->getAjax()) {
				$this->_addScript("/libraries/tw-sack/tw-sack.js");
			}
			$this->_addScript(JS_URL);
			
		}
		if (!($session->getUserAgent() == 'ie' && !$session->getJavascript())) {
			$this->_addCss("/libraries/suckerfish/suckerfish.css");
		}
		$this->_addCss(CSS_URL);

		//delego le action
		$css_apps = $session->getActiveDeskwebApps();
		if (is_array($css_apps)) {

			for ($x = 0; $x <= sizeof($css_apps) - 1; $x ++) {
				$css = DIR_APPS."/".$css_apps[$x]."/css/style.css";
				$file = $_SERVER['DOCUMENT_ROOT'].DIR_APPS."/".$css_apps[$x]."/css/style.css";
				if (is_file($file)) {
					$this->_addCss($css);
				}
			}
		}
	}

	/**
	 * metodo output
	 * stampa l'output
	 * 
	 * Costanti prese dal file di configurazione
	 * 
	 * todo:
	 * inserire nel costruttore gli argomenti per separare l'oggetto dal file di config
	 */
	function output() {
?><?=chr(60)?>?xml version="1.0" encoding="ISO-8859-1"?<?=chr(62)?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="it">
    <head>
    <title><?= PREFIX_TITLE_PROJ . $this->titolo ?></title>
    <meta name="description" content="<?=DESC_PROJ?>" />
    <meta name="author" content="<?=AUTHOR_PROJ?>" />
    <meta name="keywords" content="<?=KEYS_PROJ?>" />

    <?


		echo $this->_getScript();
		echo $this->_getCss();
?>	

	</head>
	<?


	}
	function addScript($str) {
		$this->arr_script[] = $str;
	}
	function _addScript($str) {
		$this->arr_script[] = $str;
	}
	function insertStyle($str) {
		echo "\t<link rel='stylesheet' type='text/css' href='".$str."' />\n";
	}
	function addCss($str) {
		$this->arr_css[] = $str;
	}
	function _addCss($str) {
		$this->arr_css[] = $str;
	}
	function _getScript() {
		$str = null;
		for ($x = 0; $x <= sizeof($this->arr_script) - 1; $x ++) {
			$str .= "\t<script type='text/javascript' src='".$this->arr_script[$x]."'></script>\n";
		}
		return $str;
	}
	function _getCss() {
		$str = null;
		for ($x = 0; $x <= sizeof($this->arr_css) - 1; $x ++) {
			$str .= "\t<link rel='stylesheet' type='text/css' href='".$this->arr_css[$x]."' />\n";
		}
		return $str;
	}
}
