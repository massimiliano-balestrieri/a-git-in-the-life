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
 * $Id: usermessage_helper.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/usermessage_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class UsermessageHelper{
	
	//help usermessage_model->get_user_messages_data
	public function format_date_time ($datetime,$short = 0) {
  		$date = substr($datetime,0,10);
  		$time = substr($datetime,11,8);
  		return $this->_format_date($date,$short). " ".$this->_format_time($time,$short);
	}
	//help _format_date_time
	private function _format_time($time,$short = 0) {
  		return $time;
	}
	
	//help _format_date_time
	private function _format_date($date,$short = 0) {
  		global $APP;
  		$months = array("",
		$APP->I18N->_("January"),
		$APP->I18N->_("February"),
		$APP->I18N->_("March"),
		$APP->I18N->_("April"),
		$APP->I18N->_("May"),
		$APP->I18N->_("June"),
		$APP->I18N->_("July"),
		$APP->I18N->_("August"),
		$APP->I18N->_("September"),
		$APP->I18N->_("October"),
		$APP->I18N->_("November"),
		$APP->I18N->_("December"));
		$shortmonths = array("",
		$APP->I18N->_("Jan"),
		$APP->I18N->_("Feb"),
		$APP->I18N->_("Mar"),
		$APP->I18N->_("Apr"),
		$APP->I18N->_("May"),
		$APP->I18N->_("Jun"),
		$APP->I18N->_("Jul"),
		$APP->I18N->_("Aug"),
		$APP->I18N->_("Sep"),
		$APP->I18N->_("Oct"),
		$APP->I18N->_("Nov"),
		$APP->I18N->_("Dec"));
		$year = substr($date,0,4);
		$month = substr($date,5,2);
		$day = substr($date,8,2);
		$day = ereg_replace("^0","",$day);
		
		if ($date) {
			if ($short)
			return $day . "&nbsp;" . $shortmonths[intval($month)] . "&nbsp;" . $year;
			else
			return $day . "&nbsp;" . $months[intval($month)] . "&nbsp;" . $year;
		}

	}
}