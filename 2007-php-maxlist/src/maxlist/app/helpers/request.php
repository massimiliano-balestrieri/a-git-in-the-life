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
 * Maxlist is a fork of PhpList, a newsletter manager. 
 * The code was deeply changed so there are features of the original phpList and new ones. 
 * It uses smarty, generates XHTML strict, uses an AJAX layer, italian language ,
 * multi-istance, and use case based.
 *
 * 
 * $Id: request.php 374 2008-01-08 10:42:54Z maxbnet $
 * $LastChangedDate: 2008-01-08 10:42:54 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 374 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/helpers/request.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 10:42:54 +0000 (Tue, 08 Jan 2008) $
 */

class MaxRequestHelper {
	
	public $post;
	public $get;
	public $request;
	private $_magic_quotes = true;
	
	public function __construct(){
		$this->_magic_quotes = $this->_set_magic_quotes();
		$this->_init();
		//print_r($this);die;
	}
	private function _init(){
		$this->_apply_magic_quotes();
		$this->_convert_on_to_one();
	}
	private function _convert_on_to_one(){
		$this->post = $this->_convert_on_to_one_deep($this->post);
	}
	private function _apply_magic_quotes(){
		if($this->_magic_quotes){
			$this->post = $_POST;
			$this->request = $_REQUEST;
			$this->get = $_GET;
		}else{
			$this->post = $this->_addslashes_deep($_POST);
			$this->request = $this->_addslashes_deep($_REQUEST);
			$this->get = $this->_addslashes_deep($_GET);
		}
	}
	public function request($param){
		if(isset($this->request[$param]))	
			return $this->request[$param];
		else
			return false;
	}
	public function get($param){
		if(isset($this->get[$param]))	
			return $this->get[$param];
		else
			return false;
	}
	public function post($param){
		if(isset($this->post[$param]))	
			return $this->post[$param];
		else
			return false;
	}
	private function _parse($param){
		//TODO: removexss
	}
	public function remove_param($key, $urlencode = true) {
		$str = null;
		$x = 0;
		$param = $_GET;
		while ($array_cell = each($param)) {
			if ($array_cell['key'] != $key)
				$str .= $array_cell['key'] . "=" . $array_cell['value'];
			$x++;
			if ($x < sizeof($param) && $array_cell['key'] != $key) {
				$urlencode ? $str .= "&" : $str .= "&amp;";
			}
		}
		return $str;
	}
	
	public function redirect($controller = false, $action = false, $id = false, $qs = false){
		global $APP;
		if(!$controller)
			$controller = $APP->ROUTING->controller;
			
		if(is_object($APP->I18N))	
			$save_and = ($this->request('confirm') == $APP->I18N->_('save_and'));
		else
			$save_and = false;
			
		$redir = $APP->ROUTING->istance . "/";
		if(!$save_and){
			$redir .= $controller;
			if($action) $redir .= "/" . $action;
			if($id) $redir .= "/" . $id;
		}else{
			$redir .= $APP->ROUTING->controller;
			if($APP->ROUTING->action) $redir .= "/" . $APP->ROUTING->action;
			if($APP->ROUTING->id) $redir .= "/" . $APP->ROUTING->id;
		}
		$qs = $this->_check_paging($qs);
		if($qs) $redir .= "?" . $qs;
		header("location:" . URL_BASE . $redir);
		exit;//TODO: no redirect ajax
	}
	
	public function redirect_last_page(){
		//TODO: history e getLastPage() 0.3
	}
	private function _check_paging($qs){
		if($qs) $ret[] = $qs;
		if(isset($_REQUEST['pg']))
			$ret[] = 'pg='.$_REQUEST['pg'];
		if(isset($_REQUEST['block']))
			$ret[] = 'block='.$_REQUEST['block'];
		if(isset($ret) && is_array($ret))
		return implode('&',$ret);	
	}
	private function _addslashes_deep($value) {
        $value = is_array($value) ? array_map(array($this, "_addslashes_deep"), $value) : addslashes($value);
        return $value;
    }
    private function _on_to_one($value){
    	//echo $value;die;
    	return $value == 'on'? 1: $value;
    }
    private function _convert_on_to_one_deep($value) {
        //print_r($value);
        $value = is_array($value) ? array_map(array($this, "_convert_on_to_one_deep"), $value) : $this->_on_to_one($value);
        return $value;
    }
	private function _set_magic_quotes(){
		
		if(get_magic_quotes_gpc()){
			return true;
		}else{
			return false;
		}
	}
}