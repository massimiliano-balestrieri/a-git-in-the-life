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
 * Maxlist is a fork of PhpList, a newsletter manager. 
 * The code was deeply changed so there are features of the original phpList and new ones. 
 * It uses smarty, generates XHTML strict, uses an AJAX layer, italian language ,
 * multi-istance, and use case based.
 *
 * 
 * $Id: session.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/helpers/session.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class MaxSessionHelper {
	
	public function __construct(){
		
	}
	//wrap
	public function set($key,$value){
		$_SESSION[VERSION][$key] = $value;
	}
	public function get($key){
		return isset($_SESSION[VERSION][$key]) ? $_SESSION[VERSION][$key] : false;
	}
	
	
	//LANGUAGE
	public function get_language(){
		return isset($_SESSION[VERSION]['lan']) ? $_SESSION[VERSION]['lan'] : false;
	}
	public function set_language($lan){
		$_SESSION[VERSION]['lan'] = $lan;
	}
	public function get_iso_language(){
		return isset($_SESSION[VERSION]['lan']['iso']) ? $_SESSION[VERSION]['lan']['iso'] : false;
	}
	
	//AUTH
	public function set_auth_details($username, $auth_data){
		global $APP;
		$role = $APP->ROLE->role_user($auth_data[0]);
		$is_super_user = ($role == 1);
		$_SESSION[VERSION]['auth'] = array (
					'username' => $username,
					'id' => $auth_data[0],
					'superuser' => $role, 
					'role' => $is_super_user, 
					'debug' => $is_super_user, 
					'ajax' => $this->get_ajax_setting(),
					);
		unset($_SESSION[VERSION]['login']);
		
	}
	public function get_session_auth(){
		return isset($_SESSION[VERSION]['auth']) ? $_SESSION[VERSION]['auth'] : false;
	}
	public function get_ajax_setting(){
		return isset($_SESSION[VERSION]['auth']['ajax']) ? $_SESSION[VERSION]['auth']['ajax'] : AJAX;
	}
	public function get_username(){
		return isset($_SESSION[VERSION]['auth']['username']) ? $_SESSION[VERSION]['auth']['username'] : false;
	}
	public function get_role(){
		return isset($_SESSION[VERSION]['auth']['role']) ? $_SESSION[VERSION]['auth']['role'] : false;
	}
	public function get_superuser(){
		return isset($_SESSION[VERSION]['auth']['superuser']) ? $_SESSION[VERSION]['auth']['superuser'] : false;
	}
	public function get_auth_id(){
		return isset($_SESSION[VERSION]['auth']['id']) ? $_SESSION[VERSION]['auth']['id'] : false;
	}
	//LOGIN
	public function get_session_login(){
		return isset($_SESSION[VERSION]['login']) ? $_SESSION[VERSION]['login'] : false;
	}
	public function get_req_istance(){
		return isset($_SESSION[VERSION]['login']['istance']) ? $_SESSION[VERSION]['login']['istance'] : false;
	}
	//ISTANCE
	public function get_istance(){
		return isset($_SESSION[VERSION]['istance']) ? $_SESSION[VERSION]['istance'] : false;
	}
	public function set_istance($istance){
		$_SESSION[VERSION]['istance'] = $istance;
		unset($_SESSION[VERSION]['login']['istance']);
	}
	
	//IP
	public function set_ip(){
		$_SESSION[VERSION]['ip'] = $_SERVER["REMOTE_ADDR"];
	}
	
	//INFO
	public function add_info($msg, $role = SIMPLE_ROLE){
		$_SESSION[VERSION]['INFO'][] = array(
											'msg'	=>	$msg,
											'role'	=> 	$role
		);
	}
	public function get_info(){
		return isset($_SESSION[VERSION]['INFO']) ? $_SESSION[VERSION]['INFO'] : false;
	}
	public function clean_info(){
		unset($_SESSION[VERSION]['INFO']);
	}
	//SWITCHER
	public function set_role($role){
			$_SESSION[VERSION]['auth']['role'] = $_POST['setrole'];
	}
	public function set_debug($debug){
			$_SESSION[VERSION]['auth']['debug'] = $_POST['setdebug'];
	}
	public function set_user($id, $role, $username){
		$_SESSION[VERSION]['logindetails']['id'] = $id;
		$_SESSION[VERSION]['auth']['role'] = $role;
		$_SESSION[VERSION]['logindetails']['username'] = $username;
	}
	public function set_ajax($ajax){
			$_SESSION[VERSION]['logindetails']['ajax'] = $_POST['setajax'];
	}

	
	public function debug(){
		echo "<pre>" . print_r($_SESSION,true);
	}
	
	private function logout(){
		return;//TODO:logout
		$old_sessid = session_id();
		session_regenerate_id();
		$new_sessid = session_id();
		session_id($old_sessid);
		session_destroy();
		myRedirectLogout();
	}
}