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
 * $Id: messagedata_dao.php 393 2008-01-18 18:09:49Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 393 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/dao/messagedata_dao.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 */

class MessagedataDao extends ModuleDao {

	public $table = false;
	public $db = false;

	public function __construct($params = false) {
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('messagedata');
		$this->_params = $params;

	}
	//help model::model_message->update -> STEP 3
	public function set_notify($id,$params){
		//external context
		$this->params = $params;
		$aff1 = $aff2 = false;
		if ($notify_start = $this->_param_in('messagedata','notify_start')) {
		    $aff1 = $this->db->execute(sprintf('replace into %s set name = "notify_start",id = %d,data = "%s"',
		      					$this->db->get_table('messagedata'),
		      					$id,
		      					$notify_start));
		}
		if ($notify_end = $this->_param_in('messagedata','notify_end')) {
		    $aff2  = $this->db->execute(sprintf('replace into %s set name = "notify_end",id = %d,data = "%s"',
		      					$this->db->get_table('messagedata'),
		      					$id,
		      					$notify_end));
		}
		return $aff1 || $aff2;
	}
	//help model::processqueue_model->_get_users
	public function set_messagedata($msgid,$name,$value){
		return $this->db->execute(sprintf('replace into %s set id = %d,name = "%s", data = "%s"',$this->table,$msgid,$name,$value));
		#  print "setting $name for $msgid to $value";
		#  exit;
	}
}