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
 * $Id: role.php 395 2008-01-18 18:55:07Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:55:07 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 395 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/helpers/role.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:55:07 +0000 (Fri, 18 Jan 2008) $
 */

class MaxRoleHelper {
	//TODO: rewrite roles 
	//DB
	public function role_user($id) {
		global $APP;
		$req = $APP->DB->fetch_query(sprintf('select role from %s where id = %d', $APP->DB->get_table("admin"), $id));
		if(isset($req[0])){
			return $req[0];	
		}else{
			die("<!-- role not defined -->");
		}
		
	}

	//SESSION
	public function is_super_user() {
	  global $APP;
	  return $APP->SESSION->get_superuser();
	}
	function is_guest(){
  		global $APP;
  		return $APP->SESSION->get_session_auth();
	}
	function is_role_admin() {
		global $APP;//TODO : check_role
  		return ($APP->SESSION->get_role() == 2);
	}
	function is_role_master() {
		global $APP;//TODO : check_role
  		return ($APP->SESSION->get_role() == 3);
	}
	function is_role_simple() {
		global $APP;//TODO : check_role
  		return ($APP->SESSION->get_role() == 4);
	}
	//ROLES METHODS
	public function check_role_view($view){
		return true;
		//TODO : check_role
		if(in_array($page,$GLOBALS['pages_test']))
		  	return 0;
		  if(isSuperUser() && isset($_SESSION[VERSION]['logindetails']['role']) && $_SESSION[VERSION]['logindetails']['role'] == 1) 
		  	return 1;
		  if(isset($_SESSION[VERSION]['logindetails']['role'])){
		  	$desc_role = $GLOBALS['ROLES'][$_SESSION[VERSION]['logindetails']['role']];
		  }else{
		  	$desc_role = "guest";
		  }	
		  ###
		  if(array_key_exists($page,$GLOBALS['R_USE_CASES']['VIEW'])){
		  	//è presente
		  	$role = $GLOBALS['R_USE_CASES']['VIEW'][$page];
		  	//può essere un ruolo o un array di ruoli
		  	if(is_array($role)){
		  		$esito = false;
		  		foreach($role as $s){
		  			$ruoli = split(",",$GLOBALS['M_USE_CASES'][$s]['DESC_ROLE']);
			  		if(!$esito)
			  			$esito = in_array($desc_role,$ruoli);
		  		}
		  		
		  		return $esito;
		  	}else{
		  		//se non è un array di ruoli: es ROOT o BO-XXXXX
		  		$ruoli = split(",",$GLOBALS['M_USE_CASES'][$role]['DESC_ROLE']);
		  		return in_array($desc_role,$ruoli);
		  	}
		  }else{
		  	Csi_Error("La vista ".$page." non è presente nei casi d'uso.");
		  	return 0;
		  }
		  ###
	}

}