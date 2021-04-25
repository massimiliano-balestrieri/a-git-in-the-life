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
 * $Id: statistic_helper.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/statistic_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class StatisticHelper {
	
	//PRIVATE
	//help get_statistics
	public function time_diff($time1, $time2) {
		global $APP;
		if (!$time1 || !$time2) {
			return $APP->I18N->_('unknown');
		}
		$t1 = strtotime($time1);
		$t2 = strtotime($time2);

		if ($t1 < $t2) {
			$diff = $t2 - $t1;
		} else {
			$diff = $t1 - $t2;
		}
		if ($diff == 0)
			return $APP->I18N->_('very little time');
		$hours = (int) ($diff / 3600);
		$mins = (int) (($diff - ($hours * 3600)) / 60);
		$secs = (int) ($diff - $hours * 3600 - $mins * 60);

		$res = '';
		if ($hours)
			$res = $hours . " hours";
		if ($mins)
			$res .= " " . $mins . " mins";
		if ($secs)
			$res .= " " . $secs . " secs";
		return $res;
	}
}