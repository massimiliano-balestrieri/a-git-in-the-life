<?php
/***
 * Project: Maxlist <br />
 * Copyright (C) 2007 Massimiliano Balestrieri
 * 
 * Software based on : 
 * PHPlist, Mailinglist system using PHP and Mysql
 * Copyright (C) 2000,2001,2002,2003,2004,2005 Michiel Dethmers, tincan ltd
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Maxlist is a fork of PhpList, a newsletter manager. 
 * The code was deeply changed so there are features of the original phpList and new ones. 
 * It uses smarty, generates XHTML strict, uses an AJAX layer, italian language ,
 * multi-istance, and use case based.
 *
 * 
 * $Id: i18n.php 386 2008-01-08 22:41:31Z maxbnet $
 * $LastChangedDate: 2008-01-08 22:41:31 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 386 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/inc/i18n.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 22:41:31 +0000 (Tue, 08 Jan 2008) $
 */

class MaxlistI18N {

	public $labels = array ();
	public $languages = array ();
	public $info = false;
	
	private $_obj = false; 

	public function __construct() {
		
		global $APP;
		$APP->I18N = $this;

		$this->_config();
		$this->_init();
		$this->_load_mo();
		
	}
	public function add_language($module) {
		global $APP;
		$iso = $this->_get_code_language();
		$country = $this->_get_country();
			
		$dir = DIR_I18N . '/' . $iso . '_' . $country . '/LC_MESSAGES/';
			
		$file = $dir . $module . '.mo';
			
		if(is_file($file))
			$this->_obj->addTranslation($file, $iso);
		else
			die('make mo' . $file);
		
	}
	public function _($text) {
		return $this->_obj->_($text);
	}
	public function get($text) {
		die("FIX I18N");
		global $APP;
		//$controller = $APP->ROUTING->controller;
		$lang = $this->get_code_language();
		//echo $text . "<br>";
		if (trim($text) == "")
			return "";
		if (strip_tags($text) == "")
			return $text;

		if (isset ($this->labels[$text])) {
			return $this->_formatText($this->labels[$text]);
		}
		if (isset ($this->labels[strtolower($text)])) {
			return $this->_formatText($this->labels[strtolower($text)]);
		}
		if (isset ($this->labels[strtoupper($text)])) {
			return $this->_formatText($this->labels[strtoupper($text)]);
		}
		
		return $this->_missingText($text);
	}
	
	public function set_language($language){
			global $APP;
			$lan = array (
				"info" => $language,
				"iso" => $language,
				"charset" => $this->languages[$language][1],
			);
			$APP->SESSION->set_language($lan);
	}
	
	
	
	private function _config(){
		
		//Languages, countries, and the charsets typically used for them
		//http://www.w3.org/International/O-charset-lang.html
		
		$this->languages = array(
			#"af" => array("Afrikaans","iso-8859-1, windows-1252"),
			#"sq" => array("Albanian","iso-8859-1, windows-1252"),
			#"ar" => array("Arabic","iso-8859-6"),
			#"eu" => array("Basque","iso-8859-1, windows-1252"),
			#"bg" => array("Bulgarian","iso-8859-5"),
			#"be" => array("Byelorussian","iso-8859-5"),
			#"ca" => array("Catalan","iso-8859-1, windows-1252"),
			#"hr" => array("Croatian"," iso-8859-2, windows-1250 "),
			#"cs" => array("Czech "," iso-8859-2 "),
			#"da" => array("Danish "," iso-8859-1, windows-1252 "),
			#"nl"=> array("Dutch "," iso-8859-1, windows-1252 "),
			#"eo" => array("Esperanto "," iso-8859-3* "),
			#"et" => array("Estonian ","iso-8859-15 "),
			#"fo" => array("Faroese "," iso-8859-1, windows-1252 "),
			#"fi"=> array("Finnish "," iso-8859-1, windows-1252 "),
			"de" => array("Deutsch ","iso-8859-1","iso-8859-1, windows-1252 "),
			"en" => array("English ","iso-8859-1","iso-8859-1, windows-1252 "),
			"es"=>	array("Espa&ntilde;ol","iso-8859-1","iso-8859-1, windows-1252"),
			"fr"=>	array("Fran&ccedil;ais ","iso-8859-1","iso-8859-1, windows-1252 "),
			#"gl"=>array("Galician "," iso-8859-1, windows-1252 "),
			#"el"=> array("Greek "," iso-8859-7 "),
			#"iw"=> array("Hebrew "," iso-8859-8 "),
			#"hu"=>array("Hungarian "," iso-8859-2 "),
			#"is"=>array("Icelandic "," iso-8859-1, windows-1252 "),
			#"ga"=>array("Irish "," iso-8859-1, windows-1252 "),
			"it"=>array("Italian "," iso-8859-1, windows-1252 "),
			#"ja"=>array("Japanese "," shift_jis, iso-2022-jp, euc-jp"),
			#"lv"=> array("Latvian ","iso-8859-13, windows-1257"),
			#"lt"=> array("Lithuanian "," iso-8859-13, windows-1257"),
			#"mk"=> array("Macedonian ","iso-8859-5, windows-1251"),
			#"mt"=> array("Maltese ","iso-8859-3"),
			#"no"=>array("Norwegian ","iso-8859-1, windows-1252"),
			#"pl"=>array("Polish ","iso-8859-2"),
			#"pt"=>array("Portuguese "," iso-8859-1, windows-1252"),
			#"pt-br"=>array("portugu&ecirc;s ","iso-8859-1","iso-8859-1, windows-1252"),
			#"ro"=>array("Romanian "," iso-8859-2"),
			#"ru"=>array("Russian "," koi8-r, iso-8859-5"),
			#"gd"=>array("Scottish "," iso-8859-1, windows-1252"),
			#"srcyrillic"=>array("Serbian "," windows-1251, iso-8859-5"),
			#"srlatin"=>array("Serbian "," iso-8859-2, windows-1250"),
			#"sk"=>array( "Slovak "," iso-8859-2"),
			#"sl"=>array( "Slovenian "," iso-8859-2, windows-1250"),
			#"sv"=>array("Swedish "," iso-8859-1, windows-1252"),
			#"tr"=> array("Turkish "," iso-8859-9, windows-1254"),
			#"uk"=>array("Ukrainian "," iso-8859-5"),
			#"zh-tw" => array("Traditional Chinese","utf-8","utf-8"),
		);
	}
	private function _init() {
		
		global $APP;
		
		//print_r($_SESSION);
		
		if ($APP->REQUEST->post('set_lang') || !$APP->SESSION->get_language()) {
			if($APP->REQUEST->post('set_lang')){
				$accept_lan = array ($APP->REQUEST->post('set_lang'));
			} elseif (isset ($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
				$accept_lan = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
			} else {
				$accept_lan = array (LANG);
			}
			//print_r($accept_lan);die;
			
			$detectlan = '';
			$country = '';
			foreach ($accept_lan as $lan) {
				if (!$detectlan) {
					if (preg_match('/^([\w-]+)/', $lan, $regs)) {
						$code = $regs[1];
						if (isset ($this->languages[$code])) {
							$detectlan = $code;
							$country = $code;
						}
						elseif (ereg('-', $code)) {
							list ($language, $country) = explode('-', $code);
							//echo $country;die;
							if (isset ($this->languages[$language])) {
								$detectlan = $language;
							}
						}
					}
				}
			}
			//print_r($detectlan);die;
			if (!$detectlan) {
				$detectlan = LANG;
			}
			
			if($country == 'en')
				$country = 'us';
							
			$lan = array (
				'info' => $detectlan,
				'iso' => $detectlan,
				'country' => strtoupper($country),
				//TODO: utf8 ? "charset" => $this->languages[$detectlan][1],
				
			);
			$APP->SESSION->set_language($lan);
		}

	}
	private function _load_mo(){
		global $APP;
		if ($APP->SESSION->get_language()) {
			require_once( DIR_ZEND . 'Zend/Translate.php');
			
			
			$iso = $this->_get_code_language();
			$country = $this->_get_country();
			$controller = $APP->ROUTING->controller;
			$action = $APP->ROUTING->action;
			
			$dir = DIR_I18N . '/' . $iso . '_' . $country . '/LC_MESSAGES/';
			
			if(!$action || $controller == $action) $action = 'info';
			
			$file1 = $dir . 'common.mo';
			$file2 = $dir . $controller . '.mo';
			
			if(is_file($file1))
				$this->_obj = new Zend_Translate('gettext', $file1, $iso);
			else
				die("<!-- language not found -->");
				

			if(is_file($file2))
				$this->_obj->addTranslation($file2, $iso);
			else
				die('make mo' . $file2);
			//include_once (DIR_MODULES . "/" . $controller . "/i18n/". $iso . "/" . $controller . ".php");
			//$this->labels = array_merge($this->labels, $GLOBALS['lan']);
			
			//TODO: INFO?
			//$file2 = DIR_MODULES . "/" . $controller . "/i18n/". $iso . "/".$action.".php";
			//if(is_file($file2)) {
			//	//TODO:$this->info = file_get_contents(DIR_MODULES . "/" . $controller . "/i18n/". $iso . "/".$action.".php");
			//}
			
			
			
			
		} else {
			die("<!-- language not found -->");
		}
	}
	private function _load(){
		
		global $APP;
		
		$GLOBALS['lan'] = array();//TODO rimuovere globals
		if ($APP->SESSION->get_language()) {
			
			$iso = $this->get_code_language();
			$controller = $APP->ROUTING->controller;
			$action = $APP->ROUTING->action;
			if(!$action || $controller == $action) $action = 'info';
			
			if (is_file(DIR_MODULES . "/" . $controller . "/i18n/". $iso . "/".$action.".php")) {
				$this->info = file_get_contents(DIR_MODULES . "/" . $controller . "/i18n/". $iso . "/".$action.".php");
			}
			
			if (is_file(DIR_LAN . "/" . $iso . "/_common.php")) {
				require_once (DIR_LAN . "/" . $iso . "/_common.php");
				$this->labels = $GLOBALS['lan'];
				//print_r($this->labels);
				// TODO : no GLOBALS. 
			}else{
				// TODO : notice no common file
			}
			
			//if (is_file(DIR_LAN . "/" . $iso . "/" . $controller . ".php")) {
			//	include_once (DIR_LAN . "/" . $iso . "/" . $controller . ".php");
			if (is_file(DIR_MODULES . "/" . $controller . "/i18n/". $iso . "/" . $controller . ".php")) {
				include_once (DIR_MODULES . "/" . $controller . "/i18n/". $iso . "/" . $controller . ".php");
				##$this->labels = array_merge($GLOBALS['commonlan'], $GLOBALS['lan']);
				$this->labels = array_merge($this->labels, $GLOBALS['lan']);
				// TODO : no GLOBALS. 
			}
			//print_r($this->labels);die;
			
		} else {
			die("<!-- language not found -->");
		}
	}

	
	private function _formatText($text) {
 	    return str_replace("\n","",$text);
	}
	private function _missingText($text) {
		if (DEBUG) {
			return '<span style="color:#ff1">' . $text . '</span>';
		}
		return $text;
	}
	private function _get_code_language(){
		global $APP;
		$lan = $APP->SESSION->get_language();
		return $lan['iso'];
	}
	private function _get_country(){
		global $APP;
		$lan = $APP->SESSION->get_language();
		return $lan['country'];
	}
}