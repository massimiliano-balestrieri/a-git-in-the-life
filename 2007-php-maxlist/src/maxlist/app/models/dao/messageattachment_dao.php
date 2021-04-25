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
 * $Id: messageattachment_dao.php 393 2008-01-18 18:09:49Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 393 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/dao/messageattachment_dao.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 */

class MessageattachmentDao extends ModuleDao {

	public $table = false;
	public $parent_table = false;
	public $db = false;

	public function __construct($params = false) {
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('message_attachment');
		$this->parent_table = $this->db->get_table('attachment');
		$this->_params = $params;

	}
	//get misc
	public function get_attachments($id){
		//print_r($arr_msg);die;
		if (ALLOW_ATTACHMENTS) {
		  return $this->db->query("select * from " .
		  		"{$this->table}," .
		  		"{$this->parent_table} where " .
		  		"{$this->table}.attachmentid = {$this->parent_table}.id and
		    	 {$this->table}.messageid = $id");
		}
	}
	//POST
	//model::controller_message->delete_attachments
	public function delete_attachment($msgid,$attid){
	 return $this->db->execute(sprintf("delete from %s where id = %d and messageid = %d",
		        $this->table,
		        $attid,
		        $msgid));
	}
	//model::attachment_model->save_attachment
	public function save_messageattachment($msgid,$attid){
		return $this->db->insert(sprintf('insert into %s (messageid,attachmentid) values(%d,%d)',
											$this->table,
											$msgid,
											$attid));
	}
}