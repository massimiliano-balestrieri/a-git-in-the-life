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
 * $Id: sendrss_helper.php 352 2007-12-20 19:11:32Z maxbnet $
 * $LastChangedDate: 2007-12-20 19:11:32 +0000 (Thu, 20 Dec 2007) $
 * $LastChangedRevision: 352 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/sendrss_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-20 19:11:32 +0000 (Thu, 20 Dec 2007) $
 */

class SendrssHelper{
	public function __construct(){
		if (ENABLE_RSS)
		 die("set ENABLE_RSS to 0. not implemented");
	}
	private function _temp(){
		//TODO RSS
		/*
		if (ENABLE_RSS && sizeof($rssitems)) {
			$rssentries = array ();
			$request = join(",", $rssitems);
			$texttemplate = getConfig("rsstexttemplate");
			$htmltemplate = getConfig("rsshtmltemplate");
			$textseparatortemplate = getConfig("rsstextseparatortemplate");
			$htmlseparatortemplate = getConfig("rsshtmlseparatortemplate");
			$req = Sql_Query("select * from {$GLOBALS["tables"]["rssitem"]} where id in ($request) order by list,added");
			$curlist = "";
			while ($row = Sql_Fetch_array($req)) {
				if ($curlist != $row["list"]) {
					$row["listname"] = ListName($row["list"]);
					$curlist = $row["list"];
					$rssentries["text"] .= parseRSSTemplate($textseparatortemplate, $row);
					$rssentries["html"] .= parseRSSTemplate($htmlseparatortemplate, $row);
				}
		
				$data_req = Sql_Query("select * from {$GLOBALS["tables"]["rssitem_data"]} where itemid = {$row["id"]}");
				while ($data = Sql_Fetch_Array($data_req))
					$row[$data["tag"]] = $data["data"];
		
				$rssentries["text"] .= stripHTML(parseRSSTemplate($texttemplate, $row));
				$rssentries["html"] .= parseRSSTemplate($htmltemplate, $row);
			}
			$htmlmessage = eregi_replace("\[RSS\]", $rssentries["html"], $htmlmessage);
			$textmessage = eregi_replace("\[RSS\]", $rssentries["text"], $textmessage);
		}
		*/
			
	}
}