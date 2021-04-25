<?php
/**
 * Project: maxlist <br />
 * Copyright (C) 2006 Massimiliano Balestrieri
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
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 1.0
 * @copyright 2006 Massimiliano Balestrieri.
 * @package Models
 */
 
//ATTENTION : use schema
 
class MessageModel extends ModuleModel{
	
	public $helper = false;
	private $_join_listmessage = false;
	private $_join_messagedata = false;
	
	private $_join_sendmail = false;
	private $_join_user = false;
		
	public function __construct($params){
		$this->_name = 'message';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
		
		global $APP;
		$this->_join_listmessage = $APP->get_model2("listmessage");
		$this->_join_messagedata = $APP->get_model2("messagedata");
		
		//SEND TEST
		$this->_join_user = $APP->get_model2("user");
		$this->_join_sendmail = $APP->get_model2("sendmail");
		
		$this->helper = $APP->get_helper("message");//public. call by controller
		
		$this->_dao->delete_draft_old();
	}
	//POST
	public function insert(){
		return $this->_dao->insert();
	}
	public function update($id){
		
		$aff =  $this->_dao->update($id);
		//print_r($this->_params);die;
		$lists = $this->_join_listmessage->set_targetlist($id,$this->_params); // STEP 2
		$notify = $this->_join_messagedata->set_notify($id,$this->_params);//STEP 3
		if($lists)
			return $aff || $lists || $notify;
		else
			return false;
	}
	public function delete($id){
		return $this->_dao->delete($id);
	}
	public function queue($id){
		return $this->_dao->queue($id);
	}
	public function send_test($id){
		
		// il test deve essere inviato ad un iscritto
		// OK, let's get to sending!
	    $emailaddresses = split('[/,,/;]', $this->_param_in('msg','testtarget'));
		foreach ($emailaddresses as $address) {
	      $address = trim($address);
	      //TODO: get USER
	      $result = $this->_join_user->get_by_email($address);
	      if($result){
	      	$msg = $this->get($id);
	      	$this->_join_sendmail->set($result['uniqid'], $msg);
	      	return $this->_join_sendmail->send_email($id, $address, $result['uniqid'], 1);//TODO: fix this
	      }
	    }
	    
	    
	    die("se invio fallisce... cosa faccio?");
    }
	//GET
	//view message
	public function get($id, $i18n = false){
		$msg = $this->_dao->get($id);
		if($i18n)
			$msg = $this->_parse_18n($msg);
			
		return $msg;
	}
	//messages
	public function get_messages(){
		$messages = $this->_dao->get_messages_nodata();
		if (is_array($messages['messages']))
			foreach ($messages['messages'] as $key => $msg) {
				$messages['messages'][$key]['lists'] = $this->_join_listmessage->get_csv_listdone($msg['id']);
			}
		//print_r($messages);die;
		return $messages;
	}
	//help processbounce_model
	public function increase_bouncecount($msgid){
		return $this->_dao->increase_bouncecount($msgid);
	}
	//help processqueue_model->_end_send_message
	public function update_processed($messageid) {
		return $this->_dao->update_processed($messageid);
	}
	//help processqueue_model->_sendstart
	public function set_message_status($messageid,$status) {
		return $this->_dao->set_message_status($messageid,$status);
	}
	//help processqueue_model->_sendstart
	public function set_sendstart($messageid) {
		return $this->_dao->set_sendstart($messageid);
	}
	//help model::processqueue_model->_end
	public function set_sent($messageid){
		return $this->_dao->set_sent($messageid);
	}
	//help model::processqueue_model->_end
	public function get_timetaken($messageid){
		return $this->_dao->get_timetaken($messageid);
	}
	//help processqueue_model->_process_message
	public function get_message_status($messageid) {
		return $this->_dao->get_message_status($messageid);
	}
	//help process_controller->listall
	public function get_messages_tosend(){
		$messages = $this->_dao->get_messages_tosend();
		if (is_array($messages['messages']))
			foreach ($messages['messages'] as $key => $msg) {
				$messages['messages'][$key]['lists'] = $this->_join_listmessage->get_csv_listdone($msg['id']);
			}
		//print_r($messages);die;
		return $messages;
	}
	//help archive_model->get_archive
	public function get_messages_send(){
		return $this->_dao->get_messages_send_nodata();
	}
	//help message_controller->edit
	public function get_messagedata($id){
		$ret = array();
		$res = $this->_dao->get_messagedata($id);
		foreach($res as $row){
			$ret[$row['name']] = $row['data'];
		}
		return $ret;
	}
	
	//also help statistic_model
	public function get_messages_nodata(){
		return $this->_dao->get_messages_nodata();
	}
	//HELP OTHER
	//help view_controller
	public function view($msgid){
		return $this->_dao->get($msgid);
	}
	//help bounce_model->get_page_bounces
	public function get_subject($msgid){
		return $this->_dao->get_subject($msgid);
	}
	//VALIDATE
	//help message_controller->edit
	public function can_edit($id){
		return $this->_dao->can_edit($id);
	}
	//PRIVATE
	//help get
	private function _parse_18n($msg){
		global $APP;
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
		$ret = array();
		foreach($schema as $field => $val) {
			if($field == "message"){
		   		$ret[$APP->I18N->_($field)] = '<a href="'.URL_BASE. $APP->SESSION->get_istance() . '/view/message/'.$msg['id'].'">visualizza contenuto</a>';//TODO: I18N
		  	}else{
		  		$ret[$APP->I18N->_($field)] = $msg["htmlformatted"] ? stripslashes($msg[$field]) : nl2br(stripslashes($msg[$field]));	
		   	}	
		}
		return $ret;
	}

	
}
