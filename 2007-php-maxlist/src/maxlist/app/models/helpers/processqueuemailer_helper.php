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
 * $Id: processqueuemailer_helper.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/processqueuemailer_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class ProcessqueuemailerHelper extends ProcessqueuebaseHelper{
	
	public function __construct(){
		$this->_init();	
	}

	public function notify(){
		//TODO
		//$msgdata = loadMessageData($messageid);
		//
		//$failed_sent = 0;
		//$throttlecount = 0;

		//$msgdata = loadMessageData($messageid);
		//if (!empty ($msgdata['notify_start']) && !isset ($msgdata['start_notified'])) {
		//	$notifications = explode(',', $msgdata['notify_start']);
		//	foreach ($notifications as $notification) {
		//		sendMail($notification, $this->_('Message Sending has started'), sprintf($this->_('phplist has started sending the message with subject %s'), $message['subject'] .
		//		"\n" .
		//		sprintf($this->_('to view the progress of this message, go to %s'), URL_BO . '?view=viewprocess')));
		//	}
		//	Sql_Query(sprintf('insert ignore into %s (name,id,data) values("start_notified",%d,now())', $GLOBALS['tables']['messagedata'], $messageid));
		//}
	}
}