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
 * $Id: messageattachment_model.php 323 2007-11-26 18:23:10Z maxbnet $
 * $LastChangedDate: 2007-11-26 18:23:10 +0000 (Mon, 26 Nov 2007) $
 * $LastChangedRevision: 323 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/messageattachment_model.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-11-26 18:23:10 +0000 (Mon, 26 Nov 2007) $
 */


class MessageAttachmentModel extends ModuleModel{
	
	private $_helper = false;
	
	public function __construct($params = false){
		$this->_name = 'messageattachment';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
		
		global $APP;
		$this->_helper = $APP->get_helper("messageattachment");
	}
	public function get_attachments($id){
		$attachments = $this->_dao->get_attachments($id);			    	 
		foreach ($attachments as $key => $att){
		  	$attachments[$key]['size'] = $this->_helper->format_bytes($att["size"]);
		}
		return $attachments;
	}
	//help message_controller->upload_attachments->attachment_model->save_attachment
	public function save_messageattachment($msgid,$attid){
		return $this->_dao->save_messageattachment($msgid,$attid);
	}
	
	//model::controller_message->delete_attachments
		//controller_message->_delete_attachments
	public function delete_attachments($id){
		if (ALLOW_ATTACHMENTS) {
		    // Delete Attachment button hit...
		    $aff = false;
		    $deleteattachments = $this->_params["deleteattachments"];
		    //print_r($deleteattachments);echo "qui";die;
			foreach($deleteattachments as $attid){
		 	  $affected = $this->_dao->delete_attachment($id, $attid);
			  if($affected)
			  is_numeric($aff) ? $aff++ : $aff = 1;
			  // NOTE THAT THIS DOESN'T ACTUALLY DELETE THE ATTACHMENT FROM THE DATABASE, OR
		      // FROM THE FILE SYSTEM - IT ONLY REMOVES THE MESSAGE / ATTACHMENT LINK.  THIS
		      // SHOULD PROBABLY BE CORRECTED, BUT I (Pete Ness) AM NOT SURE WHAT OTHER IMPACTS
		      // THIS MAY HAVE.
		      // (My thoughts on this are to check for any orphaned attachment records and if
		      //  there are any, to remove it from the disk and then delete it from the database).
		    }
		}
		return $aff;
	}
	
	
}
