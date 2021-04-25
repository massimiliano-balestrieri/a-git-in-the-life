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
 * $Id: module.php 386 2008-01-08 22:41:31Z maxbnet $
 * $LastChangedDate: 2008-01-08 22:41:31 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 386 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/inc/module.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 22:41:31 +0000 (Tue, 08 Jan 2008) $
 */
 
class MaxlistModule{
	
	public $model = false;
	
	public function __construct(){
		
		global $APP;
		
		$controller = $APP->ROUTING->controller;
		if ($controller == 'login') exit;
		
		if (is_file(DIR_MODULES ."/". $controller ."/".$controller. "_controller.php")) {
			require_once DIR_MODULES ."/". $controller ."/".$controller. "_controller.php";
		}
		
		//helpers if exists
		if (is_file(APP_ROOT ."/app/models/helpers/". $controller. "_helper.php")) {
			require_once APP_ROOT ."/app/models/helpers/". $controller. "_helper.php";
		}
		//models2
		if (is_file(APP_ROOT ."/app/models/". $controller. "_model.php")) {
			require_once APP_ROOT ."/app/models/". $controller. "_model.php";
		}
		//TEMP
		if (is_file(DIR_MODULES ."/". $controller ."/".$controller. "_model.php")) {
			require_once DIR_MODULES ."/". $controller ."/".$controller. "_model.php";
		}
		if (is_file(DIR_MODULES ."/". $controller ."/".$controller.  "_view.php")) {
			require_once DIR_MODULES ."/". $controller ."/".$controller. "_view.php";
		}
		if (is_file(DIR_MODULES ."/". $controller ."/".$controller.  "_session.php")) {
			require_once DIR_MODULES ."/". $controller ."/".$controller. "_session.php";
		}
		$controller = $controller . "Controller";
		
		if(class_exists($controller))
			$APP->MODULE = new $controller;
		else
			die("<!-- not implemented-->");//TODO: redirect? log?
		
	}

}
interface IModuleView {
}
interface IModuleController {
}
abstract class mvcClass{
	
	protected $_params = false;
		
	public $tpl = false;
	
	protected function _id(){
		global $APP;
		return $APP->ROUTING->id;
	}
	protected function _controller(){
		global $APP;
		return $APP->ROUTING->controller;
	}
	protected function _action(){
		global $APP;
		return $APP->ROUTING->action;
	}
	
	protected function _redirect($controller = false, $action = false, $id = false, $qs = false){
		global $APP;
		if(!$controller) $controller = $APP->ROUTING->controller;
		$APP->REQUEST->redirect($controller,$action,$id,$qs);
	}
	protected function _info($msg){
		global $APP;
		$APP->MSG->info($msg);
	}
	protected function _flash($level = 0, $subject = false, $message = false, $to = false, $header = "", $parameters = "", $skipblacklistcheck = 0){
		global $APP;
		$APP->MSG->flash($level, $subject, $message, $to, $header, $parameters, $skipblacklistcheck);
	}
	protected function _log($msg){
		global $APP;
		$APP->MSG->log($msg);
	}
	protected function _($index){
		global $APP;
		return $APP->I18N->_($index);
	}
	protected function _add_language($module){
		global $APP;
		return $APP->I18N->add_language($module);
	}
	protected function _routing(){
	
		global $APP;
		$action = $APP->ROUTING->action;
		$init = $APP->ROUTING->init;
		$init = '_' . $init;
		$action = '_' . $action;
		$action == '_' ? $action = '' : null;
		
		//var_dump(method_exists($this,$action));
		//echo $init."<br>";
		if(method_exists($this,$action)){
			$this->$action();
		}else{
			if(method_exists($this,$init)){
				$this->$init();
			}else{
				die("<!-- action default not implemented-->");
			}
		}
	
	}
	
	protected function _do(){
		$do = '_'  . $this->_params['do'];
		$do == '_' ? $do = '' : null;
		if(method_exists($this,$do)){
			$this->$do();
		}else{
			//molto importante i18n. i pulsanti form in italiano scatenano sempre una chiave che può essere inglese. cancella scatena delete, 
			//limitazione dovuta al submit che non ha un attributo label 
			//ATTENZIONE: non basarsi su label in lingua che contengono duplicati. es: aggiungi/add aggiungi/create
			//Quindi se non funzionano le azioni e il routing fallisce controllare nei file della lingua se esiste una traduzione duplicate
			//per l'azione che non funziona. Es: modifica, nella lingua trovo modified=>modifica. La pressione di un button edit con traduzione
			//modifica non invoca il metodo _edit ma il metodo _modified che non esiste.
			return;
			//TODO
			die("ATTENZIONE do");
			global $APP;
			//in_array($this->_params['do'],$APP->I18N->labels);
			$labels = array_flip($APP->I18N->labels);
			//ATTENZIONE 2: secondo problema di questo metodo. "cambia l'ordine" in italiano contiene un'apice
			$this->_params['do'] = stripslashes($this->_params['do']);
			if(isset($labels[$this->_params['do']])){
				$do = '_' . $labels[$this->_params['do']];
				if(method_exists($this,$do)){
					$this->$do();
				}
			}
		}	
		
	}
	//bottoni speciali che non possono chiamarsi do. recuperarli settando a false il predefinito
	protected function _special_do($param){
		//echo $this->_params[$param];die;
		if(isset($this->_params[$param]) && $this->_params[$param] !== false){
			$do = '_'  . $param;
			//echo $do;die;
			if(method_exists($this,$do))
				$this->$do();
		}
	}
	//sopprime l'errore
	protected function _param($key){
		return isset($this->_params[$key]) ? $this->_params[$key] : false;
	}
	protected function _param_in($elem, $key){
		//return isset($this->_params[$key]) ? $this->_params[$key] : false;
		//deep
		return isset($this->_params[$elem][$key]) ? $this->_params[$elem][$key] : false;
	}
}
abstract class ModuleController extends mvcClass{
	
	protected $_errors = false;
	protected $_model = false;
	// TODO: questo metodo di routing subito dopo una richiesta di azione via POST potrebbe essere passata al controller base. 
	protected function _check_uri($action, $id = false){
		
		global $APP;
		if($APP->ROUTING->action != $action){
			if($id)
				$id = is_numeric($id) ? $id : $this->_params['id'];
				
			$APP->REQUEST->redirect($APP->ROUTING->controller, $action, $id);
		}
	}
	protected function _check_params($params){
		foreach ($params as $key => $options){
			if(is_numeric($key)){
				$this->_check_param($options, array());
			}else{
				$this->_check_param($key, $options);
			}
		}
			//echo "<hr>" . $key. "=>". $options . "<hr>";
			//
	}
	
	protected function _check_param($key, $options = array()){
		
		$method = isset($options['m']) ? $options['m'] : 'request';
		$default = isset($options['d']) ? $options['d'] : false;
		$type =isset($options['t']) ? $options['t'] : 'string';
		
		global $APP;
		
		
		switch($type){
			case 'string':
				$mask =  '%s';
			break;
			case 'int':
				$mask =  '%d'; 
			break;
		}
		if ($p = $APP->REQUEST->$method($key)){
		  if(is_array($p))
		  	$this->_params[$key] = $p;
		  else
		  	$this->_params[$key] = sprintf($mask,$p);
		} else {
		  $this->_params[$key] = $default;
		}
		
		if($key == 'do' && $method == 'post' && $this->_params[$key])//action only post
		 	$this->_params[$key] = strtolower($this->_params[$key]);
		
	}
	//this method set default value of param. 
	//The idea is have a 0 value in checkbox not checked for important value
	protected function _set_param_default_value($key, $value, $parent = false){
		if($parent)
			$ref = &$this->_params[$parent];
		else
			$ref = &$this->_params;
		//print_r($ref);
		if(!isset($ref[$key])){//checkbox value
			$ref[$key] = $value;
		}
	}
	protected function _check_confirm(){
		global $APP;
		$yes = $APP->I18N->_('yes');
		$no = $APP->I18N->_('no');
		$controller = $APP->ROUTING->controller;
		if($this->_param('confirm') == $yes){
			return true;
		}else if($this->_param('confirm') == $no){
			$APP->REQUEST->redirect($controller);
		}else{
			return false;
		}
	}
	
	protected function _check_create(){
		return ($this->_param('do') == 'new');//from url rewrite no i18n this
	}
	
	protected function _check_edit(){
		return ($this->_param('do') == 'update'); //from url rewrite no i18n this
	}
	
	protected function _check_errors(){
		if(isset($this->_model->errors))
		return ($this->_model->errors == false);
	}
	/*
	protected function _get($key){
		if(isset($this->_params[$key]))
			return $this->_params[$key];
		else
			return false;
	}*/
		
}

abstract class ModuleView extends mvcClass{

	protected $_data = false;
	
	
	public function _init($params, $data, $errors = false){
		global $APP;
		
		$this->_params = $params;
		$this->_data = $data;//$this->_push_post($data);
		$this->_errors = $errors;
		
		/*echo "<pre>".print_r($this->_data,true);
		//echo "<hr>";
		//echo "<pre>".print_r($this->_params,true);echo "<hr>";
		echo "<pre>".print_r($this->_data,true);
		//echo "<hr>";
		//echo "<pre>".print_r($this->_params,true);echo "<hr>";
		die;*/
		
		$APP->TPL->assign('errors', $errors);
		
	}
	//partiamo semplice : 
	//$APP->REQUEST->post
	//$this->_data
	protected function _push_post($index){
		if(is_array($this->_data[$index]))
		foreach($this->_data[$index] as $key => $value){
			//exclude $key numeric sql_fetch_array_query
			if(isset($this->_params[$index][$key]) && !is_numeric($this->_data[$index][$key])){
					//echo $key. "<hr>";
					//echo $this->_data[$index][$key] . "- ".$this->_param_to_data($this->_params[$index][$key]). "<hr>";
					//$this->_data[$index][$key] = $this->_param_to_data($this->_params[$index][$key]);
				$this->_data[$index][$key] = $this->_params[$index][$key];
			}
		}
		//echo "baco : _push_post risolvere: http://beta.maxlist.local/maxlist/user/create senza post. Eliminare param_to_data<hr>";
		//print_r($this->_params[$index]);die;
		if(is_array($this->_params[$index]))
		foreach($this->_params[$index] as $key => $value){
			if(!isset($this->_data[$index][$key])){//$this->_param_in($index,$key)){
		//		echo $key. "<hr>";
				//$this->_data[$index][$key] = $this->_param_to_data($this->_params[$index][$key]);
				$this->_data[$index][$key] = $this->_params[$index][$key];
			}
		}
		//echo "<hr><pre>";
		//print_r($this->_data);
		//die;
	}
	
	private function _param_to_data($data){
		//echo $data;die;
		switch($data){
			case 'on':
				return ' checked="checked"';
			break;
			default:
				return $data;
			break;
		}
	}
}
abstract class ModuleModel extends mvcClass{
	protected $_name = false;
	protected $_dao = false;
	public $errors = false;
	protected function _get_dao($path, $params){
		$this->_params = $params;
		require_once $path . '/dao/'.$this->_name.'_dao.php';
		$dao = $this->_name . 'Dao';
		return new $dao($params);	
	}
	public function merge_errors($errors){
		if(is_array($errors))
			if(is_array($this->errors))
				$this->errors = array_merge($this->errors, $errors);
			else
				$this->errors = $errors;
	}
	public function add_error($key){
		global $APP;
		$this->errors[$key]['img'] = sprintf($APP->I18N->_('error_form %s'), URL_IMG_ERROR);
		$this->errors[$key]['classname'] = CSS_INPUT_ERROR;
	}
	public function validate($entity, $params, $callback_model){
		global $APP;
		if(sizeof($APP->REQUEST->post) > 0)
		foreach ($params as $key => $lbl){
			$this->_validate_callback($entity, $key, $lbl,$callback_model);
		}
	}
	private function _validate_callback($entity, $key, $lbl, $callback_model){
		global $APP;
		if (!(isset($this->_params[$entity][$key]) && $this->$callback_model($this->_params[$entity][$key]))){
		  $this->errors[$key]['img'] = sprintf($APP->I18N->_('error_form %s'), URL_IMG_ERROR);
		  $this->errors[$key]['classname'] = CSS_INPUT_ERROR;
		  $APP->MSG->info($APP->I18N->_($lbl));
		} 
	}
	public function validates_presence_of($entity, $params){
		global $APP;
		if(sizeof($APP->REQUEST->post) > 0)
		foreach ($params as $key => $lbl){
			$this->_validate_presence_of($entity, $key, $lbl);
		}
	}
	
	private function _validate_presence_of($entity, $key, $lbl){
		global $APP;
		$params = $entity ? $this->_params[$entity] : $this->_params;
		
		if ((isset($params[$key]) && !is_array($params[$key]) && strlen($params[$key]) ==  0)
			||
			(isset($params[$key]) && is_array($params[$key]) && count($params[$key]) == 0)
			){
		  $this->errors[$key]['img'] = sprintf($APP->I18N->_('error_form %s'), URL_IMG_ERROR);
		  $this->errors[$key]['classname'] = CSS_INPUT_ERROR;
		  if($lbl)
		  $APP->MSG->info($lbl);//$APP->I18N->_($lbl)
		} 
	}
	
	
}
abstract class ModuleDao extends mvcClass{
	
}
abstract class ModuleSession {
	
	public function set($key, $value){
		global $APP;
		$module = $APP->ROUTING->controller; 
		$_SESSION[VERSION][$module][$key] = $value;
	}
	public function push($key, $value){
		global $APP;
		$module = $APP->ROUTING->controller; 
		if(!is_array($_SESSION[VERSION][$module][$key]))
			$_SESSION[VERSION][$module][$key] = array();
		array_push($_SESSION[VERSION][$module][$key], $value);
	}
	public function get($key){
		global $APP;
		$module = $APP->ROUTING->controller; 
		return isset($_SESSION[VERSION][$module][$key]) ? $_SESSION[VERSION][$module][$key] : false;
	}
	public function delete($key){
		global $APP;
		$module = $APP->ROUTING->controller; 
		unset($_SESSION[VERSION][$module][$key]);
	}

}
