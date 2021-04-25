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
 * $Id: message_helper.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/message_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class MessageHelper{
	
	//help model::message_controller->edit
	public function set_default_value($msg){
		global $APP;
		//$schema = $APP->SCHEMA->get('message');
		$schema = array ( # a message
        "id" => array("integer not null primary key auto_increment","ID"),
        "subject" => array("varchar(255) not null default '(no subject)'","subject"),
        "fromfield" => array("varchar(255) not null default ''","from"),
        "tofield" => array("varchar(255) not null default ''","tofield"),
        "replyto" => array("varchar(255) not null default ''","reply-to"),
        "message" => array("Text","Message"),
        "textmessage" => array("Text","Text version of Message"),
        "footer" => array("text","Footer for a message"),
        "entered" => array("datetime","Entered"),
        "modified" => array("timestamp", "Modified"),
        "embargo" => array("datetime","Time to send message"),
        "repeatinterval" => array("integer default 0","Number of seconds to repeat the message"),
        "repeatuntil" => array("datetime","Final time to stop repetition"),
#        "status" => array("enum('submitted','inprocess','sent','cancelled','prepared','draft')","Status"),
        "status" => array("varchar(255)","Status"),
        "userselection" => array("text","query to select the users for this message"),
        "sent" => array("datetime", "sent"),
        "htmlformatted" => array("tinyint default 0","Is this message HTML formatted"),
        "sendformat" => array("varchar(20)","Format to send this message in"),
        "template" => array("integer","Template to use"),
        "processed" => array("mediumint unsigned default 0", "Number Processed"),
        "astext" => array("integer default 0","Sent as text"),
        "ashtml" => array("integer default 0","Sent as HTML"),
        "astextandhtml" => array("integer default 0","Sent as Text and HTML"), // obsolete
        "aspdf" => array("integer default 0","Sent as PDF"),
        "astextandpdf" => array("integer default 0","Sent as Text and PDF"),
        "viewed" => array("integer default 0","Was the message viewed"),
        "bouncecount" => array("integer default 0","How many bounces on this message"),
        "sendstart" => array("datetime","When did sending of this message start"),
        "rsstemplate" => array("varchar(100)","if used as a RSS template, what frequency"),
        "owner" => array("integer","Admin who is owner"));
        //TODO: SCHEMA ?
		foreach($schema as $field => $val) {
			if(empty($msg[$field])){ 
				switch($field){
					case 'fromfield':
						$msg['fromfield'] = $APP->CONF->get("message_from_name") . ' '.$APP->CONF->get("message_from_address");
					break;
					
					case 'footer':
						$msg['footer'] = $APP->CONF->get("messagefooter");
						$msg['footer'] = $this->_parse_str_to_unsubscribe($msg['footer']);
						$msg['footer'] = $this->_parse_str_to_update($msg['footer']);
					break;
				}
			}
		}
		return $msg;
	}
	//help model::message_controller->edit
	public function set_default_value_messagedata($msgdata){
		if(empty($msgdata['notify_start'])){
			$msgdata['notify_start'] = WEBMASTER_EMAIL;
		} 
		if(empty($msgdata['notify_end'])){
			$msgdata['notify_end'] = WEBMASTER_EMAIL;
		} 
	
		return $msgdata;
	}
	public function _jscal_to_mysql($date,$hour = 0,$minute = 0){
		if (strpos($date, "/") > 0) {
			$d = split("/", $date);
			$date = $d[2] . "-" . $d[1] . "-" . $d[0] . " " . $hour . ":" . $minute;
		} 
		return $date;
	}
	
	//PRIVATE
	//help set_default_value
	private function _parse_str_to_unsubscribe($str){
		global $APP;
		return ereg_replace('\[STR_TO_UNSUBSCRIBE\]', $APP->I18N->_('str_to_unsubscribe'), $str);
	}
	private function _parse_str_to_update($str){
		global $APP;
		return ereg_replace('\[STR_TO_UPDATE\]', $APP->I18N->_('str_to_update'), $str);
	}
	
}