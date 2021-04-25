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
 * $Id: auth.php 395 2008-01-18 18:55:07Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:55:07 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 395 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/inc/auth.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:55:07 +0000 (Fri, 18 Jan 2008) $
 */

//CONTROLLER
class MaxlistAuth{
	
	public function __construct(){
		
		global $APP;
		
		$login = $APP->SESSION->get_session_login();
		
		if ($login) {
			
			$username = $login['username'];
			$md5 = $login['password'];
			
			$auth = new MaxAuth();
			$auth_class = $auth->factory(­AUTH_MODULE);
			
			$APP->AUTH = $auth_class;
			$auth_data = $auth_class->validate($username,$md5);
			
			if (!$auth_data[0]) {
				$APP->set_view = 'about';
			} else {
				$APP->SESSION->set_ip();
				$APP->SESSION->set_auth_details($username, $auth_data);
				
				
			}
		}else{
			//istance AUTH module 
			$auth = new MaxAuth();
			$auth_class = $auth->factory(­AUTH_MODULE);
			
			$APP->AUTH = $auth_class;
		}
	}
	
}


//LIBS
interface IMaxAuth {
	public function validate($user, $pwd);
}

abstract class AbMaxAuth implements IMaxAuth{
	
	public function validate($user, $pwd){
	}
	
}

class MaxAuth extends AbMaxAuth{
	
	public function __construct(){
	}	
	
	public function factory($class){
		if(class_exists($class)){
			return new $class();
		}else{
			die("Modulo Auth non presente");	
		}
	}
	
}

class MySqlAuth implements IMaxAuth{
	
	public function __construct(){
		
	}
	
	public function validate($user, $md5){
		
		global $APP;
		
		$sql = sprintf('select password,disabled,id from %s where loginname = "%s"', $APP->DB->get_table("admin"), $user);
		$admindata = $APP->DB->fetch_query($sql);
		//print_r($admindata);die;
		if ($admindata["disabled"]) {
			return array (
				0,
				"your account has been disabled"
			);
		}
		elseif ($admindata[0] && $admindata[0] == $md5 && strlen($admindata[0]) > 3) {
			return array (
				$admindata["id"],
				"OK"
			);
		} else {
			return array (
				0,
				"invalid password"
			);
		}
		exit;
	}	
	
	

}
