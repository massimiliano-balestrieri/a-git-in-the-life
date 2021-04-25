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
 * $Id: istance.php 280 2007-11-20 18:47:32Z maxbnet $
 * $LastChangedDate: 2007-11-20 18:47:32 +0000 (Tue, 20 Nov 2007) $
 * $LastChangedRevision: 280 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/inc/istance.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-11-20 18:47:32 +0000 (Tue, 20 Nov 2007) $
 */

class MaxlistIstance{

	public function __construct() {
		global $APP;
		$req_istance = $APP->SESSION->get_req_istance();
		$istance = $APP->SESSION->get_istance();
		//print_r($req_istance);die;
		if ($req_istance && is_file(DIR_CONF . "/" . $req_istance . ".php")) {
			$APP->SESSION->set_istance($req_istance);
			//require_once (DIR_CONF . "/" . $req_istance . ".php");
			$APP->REQUEST->redirect();
		}
		elseif ($istance && is_file(DIR_CONF . "/" . $istance . ".php")) {
			require_once (DIR_CONF . "/" . $istance . ".php");
		} else {
			die("<!--No Istance-->");
		}		
		//print_r($APP->SESSION);die;
	}

}