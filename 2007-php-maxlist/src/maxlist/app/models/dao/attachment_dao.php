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
 * $Id: attachment_dao.php 393 2008-01-18 18:09:49Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 393 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/dao/attachment_dao.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 */

class AttachmentDao extends ModuleDao {

	public $table = false;
	public $db = false;

	public function __construct($params = false) {
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('attachment');
		$this->_params = $params;

	}
	//GET 
	public function get_attachment($id){
		$file = $data = false;
		$data = $this->db->fetch_query("select filename,mimetype,remotefile,description,size from " .
												"{$this->table} where id = $id");
		if(isset($data[0])){
			$file = (ATTACHMENTS_REPOSITORY. "/".$data[0]);
			//echo $file . var_dump(is_file($file));die;
			if (!is_file($file) && isset($data[2]) && is_file($data[2]) && filesize($data[2])) {
			  $file = $data[2];
			}
		}
		return array('file' => $file, 'data' => $data);
	}
	
	//get misc
	public function get_attachments($id){
		//print_r($arr_msg);die;
		if (ALLOW_ATTACHMENTS) {
		  $req = $this->db->query("select * from " .
		  		"{$this->db->get_table("message_attachment")}," .
		  		"{$this->db->get_table("attachment")}
		    where {$this->db->get_table("message_attachment")}.attachmentid = {$this->db->get_table("attachment")}.id and
		    {$this->db->get_table("message_attachment")}.messageid = $id");
		  while ($att = $this->db->sql_fetch_array($req)) {
		  	//print_r($att);die;
		  	$arr_attach[] = array(
							    'id'  => $att["id"],
								'remotefile'	=>$att["remotefile"],
							    'size'			=>$this->_format_bytes($att["size"]),
							    'mimetype'		=>$att["mimetype"],
							    'description'	=>$att["description"],
		    );
		  }
		}
		return $arr_attach;
	}
	//POST
	//model::controller_message->upload_attachments
	public function save_attachment($newfile,$remotename,$type,$description,$file_size){
		return $this->db->insert(sprintf('insert into %s (filename,remotefile,mimetype,description,size) values("%s","%s","%s","%s",%d)',
											$this->table,
											basename($newfile),
											$remotename,
											$type,
											$description,
											$file_size));
	}

}