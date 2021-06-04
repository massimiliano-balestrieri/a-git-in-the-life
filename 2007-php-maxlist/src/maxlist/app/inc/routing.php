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
 *
 * Maxlist is a fork of PhpList, a newsletter manager. 
 * The code was deeply changed so there are features of the original phpList and new ones. 
 * It uses smarty, generates XHTML strict, uses an AJAX layer, italian language ,
 * multi-istance, and use case based.
 *
 * 
 * $Id: routing.php 398 2010-09-22 06:41:44Z maxbnet $
 * $LastChangedDate: 2010-09-22 06:41:44 +0000 (Wed, 22 Sep 2010) $
 * $LastChangedRevision: 398 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/inc/routing.php $
 * 
 * $Author: maxbnet $
 * $Date: 2010-09-22 06:41:44 +0000 (Wed, 22 Sep 2010) $
 */

class MaxlistRouting{
	
	public $istance = 'default';
	public $controller = 'home';
	public $action = false;
	public $init = 'listall';
	public $href = false;
	public $id = false;
	public $qs = false;
	
	public $route = false;
	
	private $_uri = false;
	private $_args = false;
	
		
	public function __construct($base_url){
		
		global $APP;
		$APP->ROUTING = $this;
		
		$base = $base_url;
		//rimuovo il dominio
		$base_url = str_replace('http://', '',$base_url);
		$base_url = str_replace(getenv('HTTP_HOST'), '',$base_url);
		
		//phpinfo();die;
		$this->_uri = getenv('REQUEST_URI');
		$start = strlen($base_url);
		// if($start = strlen($base_url)){
			$this->_uri = substr($this->_uri, $start);
		// }else{
		// 	die("<!-- error uri -->");
		// }
		
		if(strpos($this->_uri,"?")){
			$this->qs  = substr($this->_uri, strpos($this->_uri,"?"));
			$this->_args  = substr($this->_uri, 0, strpos($this->_uri,"?"));
		}else{
			$this->_args  = substr($this->_uri, strpos($this->_uri,"?"));
		}
		
		if($this->_args){
			$this->_args = explode('/',$this->_args);
			if(isset($this->_args[0])){
				$this->istance = $this->_args[0];
				$this->href = $this->istance;
				
				$req_istance = $APP->SESSION->get_req_istance();
				print_r($req_istance);die('QUA');
				$istance = $APP->SESSION->get_istance();
				if($this->istance != $istance && $this->istance != $req_istance)
					 die("no<!-- no istance -->");
			} 
			if(isset($this->_args[1])){
				$this->controller = $this->_args[1]; 
				$this->href .= '/' . $this->controller;
			} 
			if(isset($this->_args[2])){
				$this->action = $this->_args[2]; 
				$this->href .= '/' . $this->action;
			}
			if(isset($this->_args[3])){
				$this->id = $this->_args[3]; 
				$this->href .= '/' . $this->id;
			} 
			
		}
		
		$this->_static_routing();
		//print_r($this);
	}
	public function set_default_action($init){
		if(empty($this->action))
			$this->action = $init;
		$this->init = $init;
	}
	public function action_to_do(){
		switch($this->action){
			case 'subscribe' : 
			case 'create':
				return 'new';
			break;
			case 'preferences':
			case 'edit':
				return 'update';
			break;
			case 'unsubscribe':
			case 'delete':
				return 'remove';
			break;
		}
	}
	private function _static_routing(){
		$routing = array(
			'adminattribute' => 'attribute'
		);
		if(array_key_exists($this->controller , $routing)){
			$this->route = $this->controller;
			$this->controller = $routing[$this->route];
		}
	}
}