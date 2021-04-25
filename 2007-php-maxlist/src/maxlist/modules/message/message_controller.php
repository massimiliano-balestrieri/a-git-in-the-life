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
 *
 * Maxlist is a fork of PhpList, a newsletter manager. 
 * The code was deeply changed so there are features of the original phpList and new ones. 
 * It uses smarty, generates XHTML strict, uses an AJAX layer, italian language ,
 * multi-istance, and use case based.
 *
 * 
 * $Id: message_controller.php 387 2008-01-11 17:48:38Z maxbnet $
 * $LastChangedDate: 2008-01-11 17:48:38 +0000 (Fri, 11 Jan 2008) $
 * $LastChangedRevision: 387 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/message/message_controller.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-11 17:48:38 +0000 (Fri, 11 Jan 2008) $
 */

class MessageController extends ModuleController implements IModuleController{
	
	public function __construct(){
		
		//TODO : i18n fields message dinamic and status too 
		
		//TODO : check_role -  
		//$this->_check_role_view('admin');
		
		//TODO: actions,ajax, roles
		//params
		$params = array(
					'find','type',
					'delete' =>  array('m' => 'post'),
					'status' =>  array('in'=>'queued,draft,sent', 'd' => 'draft'),
					'pg' 	=> array('t' => 'int', 'd' => 1),
					'block' => array('t' => 'int', 'd' => 1),
					'do'=> array('in' => '', 'm' => 'post'),//TODO : options in
					'confirm'=>array('m' => 'post'),
					'id'=>array('m' => 'post'),//redirect da listall
			
					'messagedata' =>  array('m' => 'post', 'd' => array()),
					'files' =>  array('m' => 'post', 'd' => array()),
					'deleteattachments' =>  array('m' => 'post', 'd' => false),//IMPORTANT : do if post array.
					'targetlist' =>  array('m' => 'post', 'd' => array()),
					'msg' =>  array('m' => 'post', 'd' => array()),
		
		);
		
		
		
		
		
		$this->_check_params($params);
		
		$this->_model = new MessageModel($this->_params);  
		
		$this->_do();
		
		$this->_routing();
		
	}
	//GET
	protected function _listall(){
		global $APP;
		$data = $this->_model->get_messages();
		$this->tpl = 'messages';
		new MessageView($this->_params, $data);	
	}
	protected function _delete(){
		$this->_check_uri('delete', true);
		$this->_listall();
	}
	protected function _requeue(){
		$this->_check_uri('requeue', true);
		die;
	}
	protected function _view(){
		global $APP;
		$this->_check_uri('view', true);
		$data = $this->_prepare_data_view();
		$this->tpl = 'message';
		new MessageView($this->_params, $data);
	}
	protected function _edit(){
		$this->_check_uri('edit', true);
		$id = $this->_id();
		if($this->_model->can_edit($id)){
			$data = $this->_prepare_data_edit($id);
			$this->_form($data);
		}else{
			$this->_flash(LOG_MAIL_LEVEL, $this->_('message_send_not_editable'));	
			$this->_redirect();
		}
	}
	//ECCEZIONE - get che crea
	protected function _create(){
		if($id = $this->_model->insert()){
			$this->_flash(LOG_LEVEL, $this->_('message_created'));	
			$this->_redirect('message', 'edit' , $id); 
		}else{
			die("<!-- impossibile creare il messaggio");
		}	
	}
	//POST
	protected function _remove(){
		$delete = $this->_params['delete'];
		if($this->_check_confirm() && $this->_model->delete($delete)){
	  		$this->_flash(LOG_MAIL_LEVEL, $this->_('message_deleted'));	
		     
		}
		$this->_redirect();
	}
	protected function _update(){
		$this->_validate();
		$id = $this->_id();
		
		$redir = false;
		//routing confirm based
		if($this->_check_deleteattachments() && is_array($this->_params['deleteattachments'])){
			$redir = $this->_deleteattachments($id);
		}
		
		if($this->_check_uploadattachment()){
			$redir = $this->_uploadattachment($id);
		}
		if($this->_check_errors() && $this->_check_save_message() && $this->_model->update($id)){
		 	$this->_flash(LOG_LEVEL,$this->_('message_saved'));
			$redir = true;
		}	
		if($this->_check_errors() && $this->_check_send_test() && $test = $this->_model->send_test($id)){
	        $this->_flash(LOG_LEVEL,$test['log']);
			$redir = true;
		}elseif($this->_check_errors() && $this->_check_send()){
			$this->_validate_send();
			if($this->_check_errors() && $this->_model->queue($id)){
				$this->_flash(LOG_LEVEL,$this->_('message_queued'));
				$this->_redirect('message');
			}
		}
		if($redir)
			$this->_redirect('message','edit', $id);
	}
	
	//PRIVATE
	private function _prepare_data_view(){
		global $APP;
		$id = $this->_id();
		$listmessage = $APP->get_model2("listmessage");
		$messageattachment = $APP->get_model2("messageattachment");
		$data['done'] = $listmessage->get_array_lists_done($id);
		$data['resend'] = $listmessage->get_array_lists_resend($id);
		$data['msg'] = $this->_model->get($id,true);
		$data['attachments'] = $messageattachment->get_attachments($id);
		return $data;
	}	
	private function _prepare_data_edit($id){
		global $APP;
		$data['msg'] = $this->_model->get($id);
		$data['msg'] = $this->_model->helper->set_default_value($data['msg']);
		$data['messagedata'] = $this->_model->get_messagedata($id);
		$data['messagedata'] = $this->_model->helper->set_default_value_messagedata($data['messagedata']);
		$data['templates'] = $APP->get_model2("template", $this->_params)->get_array_templates();//chain ability experiment?
		$data['lists'] = $APP->get_model2("list", $this->_params)->get_lists($id);
		$data['targetlist'] = $APP->get_model2("listmessage", $this->_params)->get_targetlist($id);
		//print_r($data['targetlist']);
		$data['attachments'] = $APP->get_model2("messageattachment")->get_attachments($id);
		return $data;	
	}
	//subactions
	private function _deleteattachments($id){
		global $APP;
		$attachment = $APP->get_model2("messageattachment", $this->_params);
		if($aff = $attachment->delete_attachments($id)){
			$this->_flash(LOG_LEVEL, $this->_("removedattachment"));
		}  
		return $aff;
	}
	private function _uploadattachment($id){
		global $APP;
		$attachment = $APP->get_model2("attachment", $this->_params);
		if($aff = $attachment->upload_attachment($id)){
			$this->_flash(LOG_LEVEL, $this->_("addingattachment"));
		}  
		return $aff;
	}
	//help
	private function _form($data){
		$this->tpl = 'form';
		new MessageView($this->_params, $data, $this->_model->errors);		
	}	
	//check
	private function _check_send(){
		return ($this->_params['confirm'] == $this->_('sendmessage'));
	}
	private function _check_send_test(){
		return ($this->_params['confirm'] == $this->_('sendtestmessage'));
	}
	private function _check_save_message(){
		return ($this->_params['confirm'] != $this->_('no'));//$this->_('saveasdraft'));
	}
	private function _check_deleteattachments(){
		return ($this->_params['confirm'] == $this->_('deleteattachments'));
	}
	private function _check_uploadattachment(){
		return ($this->_params['confirm'] == $this->_('uploadandsave'));
	}
	private function _validate_send(){
		$this->_model->validates_presence_of(false,array('targetlist' => 'selectlist'));
	}
	private function _validate(){
		$this->_model->validates_presence_of('msg',array(
					  'subject' => 'entersubject', 
					  'message' => 'entermessage',
					  'fromfield' => 'enterfrom',
					  'sendformat' => 'selectformat',
					  ));
	}
}
