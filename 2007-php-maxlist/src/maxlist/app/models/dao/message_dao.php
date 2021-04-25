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
 * $Id:listmessage_dao.php 314 2007-11-25 08:09:32Z maxbnet $
 * $LastChangedDate:2007-11-25 09:09:32 +0100 (dom, 25 nov 2007) $
 * $LastChangedRevision:314 $
 * $LastChangedBy:maxbnet $
 * $HeadURL:https://maxlist.svn.sourceforge.net/svnroot/maxlist/trunk/maxlist/app/models/dao/old/listmessage_dao.php $
 * 
 * $Author:maxbnet $
 * $Date:2007-11-25 09:09:32 +0100 (dom, 25 nov 2007) $
 */

class MessageDao extends ModuleDao {

	public $table = false;
	public $db = false;
	
	//PRIVATE
	private $helper = false;
	//help form
	private $_subject = false;
	private $_formfield = false;
	private $_message = false;
	private $_htmlformatted = false;
	private $_sendformat = false;
	private $_template = false;
	private $_footer = false;

	//why?
	private $_target_all = false;
	private $_targetlist = false;
	
	
	public function __construct($params = false) {
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('message');
		$this->_params = $params;
		
		$this->_helper = $APP->get_helper('message');
	}
	//POST
	public function insert(){
		global $APP;
		$owner = $APP->SESSION->get_auth_id();
		$default_template = $APP->CONF->get('defaultmessagetemplate');
  		return $this->db->insert(sprintf('insert into %s (subject,status,entered,sendformat,embargo,repeatuntil,owner,template)
    						values("(no subject)","draft",now(),"text and HTML",now(),now(),%d,%d)',
    						$this->table,
    						$owner ,
    						$default_template));
	  	
	}
	public function delete($delete){
		$aff = false;
		$ownerselect_and = '';//TODO: $ownerselect_and
	    $result = $this->db->query("select id from ".$this->table." where id = $delete $ownerselect_and");
	    foreach ($result as $row){
			  $aff = $this->db->execute("delete from ".$this->table." where id = $row[0]");
			  $sql = "delete from ".$this->db->get_table("usermessage")." where messageid = $row[0]";
			  $aff2 = $this->db->execute($sql);
			  $sql = "delete from ".$this->db->get_table("listmessage")." where messageid = $row[0]";
			  $aff3 = $this->db->execute($sql);
	    }
	    return $aff;
	}
	public function update($id){
		$this->_get_params();
		$query = sprintf( 'update %s  set  '.
					      'subject = "%s", '.
					      'fromfield = "%s", '.
					      'footer  =  "%s",  '.
					      'htmlformatted = %d, '.
					      'template  =  %d,  '.
					      'sendformat  =  "%s",  '.
					      'embargo = "%s", '.
					      //TODO:'repeatinterval  =  %d,  '.
					      //TODO:'repeatuntil = "%s", '.
					      'message = "%s" '.
					      /*'tofield = "%s", '.
					      'replyto = "%s", '.
					      'textmessage = "%s", '.
					      'status = "%s", '.
					      'rsstemplate = "%s"  '.*/
					      'where id  =  %d',
					      
					      $this->table,
					      $this->_subject,
					      $this->_fromfield,
					      $this->_footer,
					      $this->_htmlformatted,
					      $this->_template,
					      $this->_sendformat,
					      $this->_helper->_jscal_to_mysql($this->_param_in('msg','embargo'),$this->_param_in('msg','hour_embargo'),$this->_param_in('msg','minute_embargo')),
					      //TODO:$_POST["repeatinterval"],
					      //TODO:jscalToMysql($_POST["repeatuntil"],@$_POST["hour"]["repeatuntil"],@$_POST["minute"]["repeatuntil"]),
					      $this->_message,
					      
					      $id);
					      /*
					      addslashes($_POST["tofield"]),
					      addslashes($_POST["replyto"]),
					      addslashes($_POST["textmessage"]),
					      $status,
					      $_POST["rsstemplate"],
					      */
		#print $query;die();
		return  $this->db->execute($query);
		 
	}
	public function queue($id){
		$query = sprintf( 'update %s  set  '.
						  'status = "%s" '.
						  'where id  =  %d',
						   $this->table,
					      'submitted',
						  $id);
		#print $query;die();
		return  $this->db->execute($query);					  
	}
	//GET
	public function get_messages_nodata() {
		//TODO: paging?
		$subselect = ' where '.$this->_get_messages_subselect();
		if (strlen($this->_params['find']) > 0) {
			$subselect .= ' and (subject like "%' . $this->_params['find'] . '%" or subject like "%' . $this->_params['find'] . '%")';
		}

		$listquery = "SELECT id, subject, fromfield, embargo,sendstart,sent," .
		"viewed, processed, astext,ashtml,astextandhtml," .
		"aspdf,astextandpdf,status,bouncecount " .
		" FROM " . $this->table . " " . $subselect;
		$order = " order by status,{$this->table}.entered desc";

		$sql = "$listquery $order";
		$messages = $this->db->query($sql);
		$count = $this->db->count();
		return array (
			'total' => $count,
			'messages' => $messages
		);

	}
	//VALIDATE
	//help model::message_controller->edit
	public function can_edit($id) {
		$msg = $this->db->fetch_query(sprintf('select status from %s where id = %d', $this->table, $id));
		return isset($msg[0]) && $msg[0] == 'draft';   
	}
	//help model::archive_model->get_archive
	public function get_messages_send_nodata() {
		$subselect = ' where subject <> "(no subject)" and status in ("sent","inprocess") ';
		$listquery = "SELECT id, subject, sent" .
		" FROM " . $this->table . " " . $subselect;
		$order = " order by sent desc";
		$sql = "$listquery $order";
		return $this->db->query($sql);
	}
	//help model::processbounce_model
	public function increase_bouncecount($msgid){
			$sql = sprintf('update %s set bouncecount = bouncecount + 1 where id = %d', $this->table, $msgid);
			return $this->db->execute($sql);
	}
	//help model::processqueue_model->_end_send_message
	public function update_processed($messageid) {
		return $this->db->execute("update {$this->table} set processed = processed +1 where id = $messageid");
	}
	//help model::processqueue_model->_sendstart
	public function set_message_status($messageid,$status) {
		return $this->db->execute("update {$this->table} set status = \"$status\" where id = $messageid");
	}
	//help model::processqueue_model->_sendstart
	public function set_sendstart($messageid) {
		return $this->db->execute('update ' . $this->table . ' set sendstart = now() where sendstart is NULL and id = ' . $messageid);
	}
	//help model::processqueue_model->_end
	public function set_sent($messageid){
		return $this->db->execute(sprintf('update %s set status = "sent",sent = now() where id = %d', $this->table, $messageid));
	}
	//help model::processqueue_model->_end
	public function get_timetaken($messageid){
		return $this->db->fetch_query(("select sent,sendstart from {$this->table} where id = \"$messageid\""));
	}
	//help model::processqueue_model->_process_message
	public function get_message_status($messageid) {
		return $this->db->fetch_query("select id,status from {$this->table} where id = $messageid");
	}
	//help model::process_controller->listall
	public function get_messages_tosend() {
		
	
		//$subselect = ' where subject <> "(no subject)" and status in ("inprocess","submitted","suspended") ';
		$subselect =  " where status != \"draft\" and status != \"sent\" and " .
		 " status != \"prepared\" and " .
		 " status != \"suspended\" " .
		 " and embargo < now() ";
		$listquery = "SELECT id, subject, embargo, userselection, rsstemplate " .
		" FROM " . $this->table . " " . $subselect;
		$order = " order by status,entered desc";
		$sql = "$listquery $order";
		
		$messages = $this->db->query($sql);
		$count = $this->db->count();
		return array (
			'total' => $count,
			'messages' => $messages
		);
	}
	//GET
	//help model::constructor
	public function delete_draft_old(){
		$scad = mktime ((date("H")-1),0,0,date("m"),date("d"),date("Y"));
		$data = strftime("%Y-%m-%d %H:%M:%S",$scad);
		$sql = "delete from {$this->table} where subject = '(no subject)' and  entered < '$data'";
		$aff = $this->db->execute($sql);
		
		if($aff){
			$this->_log(sprintf($this->_('purge_drafts'),$aff,$data));
		}
		return $aff;
	}
	//help model::message_controller->edit 
	public function get_messagedata($id){
		return $this->db->query("SELECT * FROM {$this->db->get_table('messagedata')} where id = $id");
	}
	//help view (from view module)
	//help message (from view action)
	//help model::send_test
	public function get($id) {
		return $this->db->fetch_query("SELECT * FROM {$this->table} where id = '$id'");
	}
	//HELP OTHER
	//help bounce_model->get_page_bounces
	public function get_subject($msgid) {
		$res = $this->db->fetch_query("select subject from  " . $this->table . "  where id = '$msgid'");
		return isset ($res['subject']) ? $res['subject'] : false;
	}
	//PRIVATE
	//help get_messages
	private function _get_messages_subselect(){
		switch ($this->_params['type']) {
		  case "queued":
		#    $subselect = ' status in ("submitted") and (rsstemplate is NULL or rsstemplate = "") ';
		    $subselect = ' subject <> "(no subject)" and status in ("submitted","suspended") ';
		    break;
		  case "draft":
		    $subselect = ' subject <> "(no subject)" and status in ("draft") ';
		    break;
		  case "sent":
		    $subselect = ' subject <> "(no subject)" and status in ("sent","inprocess") ';
		    break;
		  default:
		    $subselect = ' subject <> "(no subject)"';//' status in ("sent","inprocess") ';
		    break;
		}
		return $subselect;
	}
	//help update
	private function _get_params(){
		$this->_subject = $this->_param_in('msg', 'subject');
		$this->_fromfield = $this->_param_in('msg', 'fromfield');
		$this->_message = $this->_param_in('msg', 'message');
		$this->_footer = $this->_param_in('msg', 'footer');
		$this->_template = $this->_param_in('msg', 'template');
		$this->_sendformat = $this->_param_in('msg', 'sendformat');
		
		$this->_target_all = $this->_param_in('targetlist', 'all');
		$this->_targetlist = $this->_param('targetlist');
		
		//5?
		$this->_htmlformatted = strip_tags($this->_message) != $this->_message;
  
	}
	
}