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
 * $Id: attachment_model.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/attachment_model.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */


class AttachmentModel extends ModuleModel{
	
	private $_join_messageattachment = false;
	
	public function __construct($params = false){
		$this->_name = 'attachment';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
		
		global $APP;
		$this->_join_messageattachment = $APP->get_model2('messageattachment');
	}
	//GET
	public function get_attachment($id){
		return $this->_dao->get_attachment($id);
	}
	//controller_message->upload_attachment
	public function upload_attachment($messageid){
		if (!ALLOW_ATTACHMENTS)
			return;
		
		for ($att_cnt = 1;$att_cnt <= NUM_ATTACHMENTS;$att_cnt++) {
		
			$fieldname = "attachment".$att_cnt;
			if(isset($_FILES[$fieldname]['tmp_name'])){
				$tmpfile = $_FILES[$fieldname]['tmp_name'];
				$remotename = $_FILES[$fieldname]["name"];
				$type = $_FILES[$fieldname]["type"];
				$file_size = $_FILES[$fieldname]["size"];
				
				#if (strlen($_POST[$type]) > 255)
				#print Warn($GLOBALS['I18N']->get("longmimetype"));
				
				$description = $this->_param_in('files',$fieldname."_description");
				
				if ($_FILES[$fieldname] && $_FILES[$fieldname]['size'] > 10) {
					list($name,$ext) = explode(".",basename($remotename));
					# create a temporary file to make sure to use a unique file name to store with
					
					$newfiledir = TMP_REPOSITORY.'/'. $_FILES[$fieldname]['name'].time();
					$newfile = $_FILES[$fieldname]['name'].time();
					
					move_uploaded_file($_FILES[$fieldname]['tmp_name'], $newfiledir);
					
					if( !($fp = fopen ($newfiledir, "r"))) {
						$this->_flash(LOG_LEVEL,sprintf($this->_('Cannot read %s. file is not readable !'),$newfiledir));
						return false;
					}
					fclose($fp);
					$tmpfile = $newfiledir;
							
					
					$fd = fopen( $tmpfile, "r" );
					$contents = fread( $fd, filesize( $tmpfile ) );
					fclose( $fd );
					
					if ($file_size > 10) {
						# this may seem odd, but it allows for a remote (ftp) repository
						# also, "copy" does not work across filesystems
						$fd = fopen(ATTACHMENTS_REPOSITORY."/".$newfile, "w" );
						fwrite( $fd, $contents );
						fclose( $fd );
						$attachmentid = $this->_dao->save_attachment($newfile,$remotename,$type,$description,$file_size);
						$this->_join_messageattachment->save_messageattachment($messageid,$attachmentid);
					} else {
						$this->_flash(LOG_LEVEL,$this->_('uploadfailed'));
						return false;
					}
				}
			}
		}
			/*TODO:		
			  		} elseif (@$_POST["localattachment".$att_cnt]) {
						$type = findMime(basename($_POST["localattachment".$att_cnt]));
						Sql_query(sprintf('insert into %s (remotefile,mimetype,description,size) values("%s","%s","%s",%d)',
											$tables["attachment"],
											$_POST["localattachment".$att_cnt],
											$type,
											$description,
											filesize($_POST["localattachment".$att_cnt])));
						$attachmentid = Sql_Insert_id();
						Sql_query(sprintf('insert into %s (messageid,attachmentid) values(%d,%d)',
										$tables["message_attachment"],
										$messageid,
										$attachmentid));
						addPublicSessionInfo($GLOBALS['I18N']->get("addingattachment")." ".$att_cnt. " mime: $type");
					}*/
		
	}
}
