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
 * $Id: msg.php 393 2008-01-18 18:09:49Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 393 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/helpers/msg.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 */

//USA DB2

class MaxMsgHelper {

	public $info = array();
	public $query = array();
	public $query_slow = array();
	public $query_error = array();
	public $warnings = array();
	public $errors = array();
	
	public function flash($level = 0, $subject = false, $message = false, $to = false, $header = "", $parameters = "", $skipblacklistcheck = 0) {
		switch($level){
			case 0://low
				$log = false;
				$mail = false;
			break;
			case 1://high - log
				$log = true;
				$mail = false;	
			break;
			case 2://high - log + mail
				$log = true;
				$mail = true;
			break;
		}
		
		global $APP;
		
		$APP->MSG->session_info($subject);
			
		if($log)
		$APP->DB->insert(sprintf('insert into %s (entered,page,admin,entry,stack) values(now(),"%s","%s","%s", "%s")', $APP->DB->get_table("eventlog"), $APP->ROUTING->controller, $APP->SESSION->get_username(),addslashes($subject),$this->_get_stack()));
		if($mail){
			if(!$message) $message = $this->_mail_report();
			if(!$to) $to = $APP->CONF->get("report_address");
			$APP->MAILER->send_mail($to, $subject, $message, $header, $parameters, $skipblacklistcheck);
		}
	}
	public function log($msg) {
		global $APP;
		$APP->DB->insert(sprintf('insert into %s (entered,page,admin,entry,stack) values(now(),"%s","%s","%s", "%s")', $APP->DB->get_table("eventlog"), $APP->ROUTING->controller, $APP->SESSION->get_username(),addslashes($msg), $this->_get_stack()));
	}
	//da eliminare
	public function watchdog($level = 0, $subject = false, $message = false, $to = false, $header = "", $parameters = "", $skipblacklistcheck = 0) {
		switch($level){
			case 0://low
				$log = false;
				$mail = false;
			break;
			case 2://high - log + mail
				$log = true;
				$mail = true;
			break;
			case 1://high - log
			default:
				$log = true;
				$mail = false;	
			break;
		}
		
		global $APP;
		
			
		if($log)
		$APP->DB->insert(sprintf('insert into %s (entered,page,admin,entry,stack) values(now(),"%s","%s","%s", "%s")', $APP->DB->get_table("eventlog"), $APP->ROUTING->controller, $APP->SESSION->get_username(),addslashes($subject),$this->_get_stack()));
		if($mail){
			if(!$message) $message = $this->_mail_report();
			if(!$to) $to = $APP->CONF->get("report_address");
			$APP->MAILER->send_mail($to, $subject, $message, $header, $parameters, $skipblacklistcheck);
		}
	}
	private function _mail_report(){
		global $APP;
		return sprintf($APP->I18N->_('request_save'),print_r($APP->REQUEST->post,true));
	}
	private function _mail($to, $subject, $message, $header = "", $parameters = "", $skipblacklistcheck = 0){
		global $APP;
		$APP->MAILER->send_mail($to, $subject, $message, $header = "", $parameters = "", $skipblacklistcheck = 0);
	}
	
	//MESSAGE
	public function get_info(){
		return $this->merge_info();
	}
	public function get_warnings(){
		return $this->warnings;
	}
	public function get_errors(){
		return $this->errors;
	}
	public function get_query(){
		return $this->query;
	}
	public function get_query_slow(){
		return $this->query_slow;
	}
	public function get_query_error(){
		return $this->query_error;
	}
	function info($msg) {
	  global $APP;
	  array_push($this->info,array('msg'=>$APP->I18N->_("information") . $msg, 'role'=> $APP->SESSION->get_role()));
	}
	function query($msg) {
	  array_push($this->query,$msg);
	}
	function query_slow($msg) {
	  array_push($this->query_slow,$msg);
	}
	function query_error($msg) {
	  array_push($this->query_error,$msg);
	}
	function warn($msg) {
	  global $APP;
	  array_push($this->warnings,$APP->I18N->_("warning") .  $msg);
	}
	function error($msg) {
	  global $APP;
	  array_push($this->errors,$APP->I18N->_("error") .  $msg);
	  //TODO : command line interface
	  ##if ($GLOBALS["commandline"]) {
	  ##  clineError($msg);
	  ##  return;
	  ##}
	}
	function form_error($msg,$indice = "main") {
	  $GLOBALS['Form_Error'][$indice] = array();
	  array_push($GLOBALS['Form_Error'][$indice], $msg);
	}
	function fatal_error($msg) {

		global $APP;

		$object = $APP->I18N->_('Mail list error:');
		$message = $APP->I18N->_('An error has occurred in the Mailinglist System') . 'URL: ' . $_SERVER["REQUEST_URI"] . 'Error: ' . $msg;
		$this->send_mail($APP->CONF->get('report_address'), $object, $message, "");
		
		print $APP->I18N->_("fatalerror") . " : " . $msg;
		exit ();
	}
	//SESSION: TODO - role + info rewrite logic
	function session_info($msg,$role = SIMPLE_ROLE) {//TODO: role
		global $APP;
		$APP->SESSION->add_info($msg,$role);
	}
	//UTILS info
	function merge_info(){
		global $APP;
		$info = $this->info;
		if($session_info = $APP->SESSION->get_info()){
			$info = array_merge($session_info,$info);
			$APP->SESSION->clean_info();
		}
		//print_r($info);die;
		return $info;
	}
	function clean_info($role){
		if(sizeof($GLOBALS['PUBLIC_INFO'])==0)
		return;
		if($role == 0){
			unset($GLOBALS['PUBLIC_INFO']);
			return;
		} 
		for($x=0;$x<=sizeof($GLOBALS['PUBLIC_INFO'])-1;$x++){
			if($role > $GLOBALS['PUBLIC_INFO'][$x]['role']){
				unset($GLOBALS['PUBLIC_INFO'][$x]);
			} 
		}
		@sort($GLOBALS['PUBLIC_INFO']);
	}
	
	private function _get_stack(){
		global $APP;
		return 
		addslashes("SESSION: \n" . print_r($_SESSION,true) . "\n" .
		"POST: \n" . print_r($APP->REQUEST->post,true) . "\n" .
		"REQUEST: \n" . print_r($APP->REQUEST->request,true) . "\n" .
		"GET: \n" . print_r($APP->REQUEST->get,true) . "\n");
		//"APP: \n" . print_r($APP,true) . "\n";die;
	}
	
}