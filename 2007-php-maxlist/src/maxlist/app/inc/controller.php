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
 * $Id: controller.php 190 2007-11-09 09:17:08Z maxbnet $
 * $LastChangedDate: 2007-11-09 09:17:08 +0000 (Fri, 09 Nov 2007) $
 * $LastChangedRevision: 190 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/inc/controller.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-11-09 09:17:08 +0000 (Fri, 09 Nov 2007) $
 */
 
class MaxlistController{
	
	public function __construct(){
		
		//set view
		//$this->set_view();	
		
		//set language
		$this->set_language();
		
		
	}
	
	//GET REQUESTS
	public function _set_view(){
		
		//global $APP;
		//if (isset ($_GET['view'])) {
		//	$APP->set_view($_GET['view']);
		//}
		
	}
	
	//POST REQUESTS
	public function set_language(){
		
		global $APP;
		if (isset ($_POST['language']) && $_POST['language'] && is_array($APP->I18N->languages[$_POST['language']])) {
			$APP->I18N->set_language($_POST['language']);
		}
		
	}
}





