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
 * $Id: eventlog_controller.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/eventlog/eventlog_controller.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */
 
class EventlogController extends ModuleController implements IModuleController{
	
	
	public function __construct(){
		
		//TODO : check_role -  
		//$this->_check_role_view('eventlog');
		
		$params = array(
					'pg' 	=> array('t' => 'int', 'd' => 1),
					'block' => array('t' => 'int', 'd' => 1),
					'delete'=> array('m' => 'post'),
					'filter'=> array(),
					'do'=> array('in' => 'do_deleteall,do_deleteold,do_delete', 'm' => 'post'),//TODO : options in
					'confirm'=>array('m' => 'post')
		);
		
		$this->_check_params($params);
		
		$this->_model = new EventlogModel($this->_params);  
		
		$this->_do();
		
		$this->_routing();
		
	}
	//GET
	protected function _listall(){

		//carica il model
		$data = $this->_model->get_page_events($this->_params);
		$this->tpl = 'eventlog';
		//carica la vista
		new EventlogView($this->_params, $data);
		
	}
	protected function _deleteold(){
		$this->_listall();
	}
	protected function _deleteall(){
		$this->_listall();
	}	
	protected function _delete(){
		$this->_listall();
	}
	//POST
	protected function _do_delete(){
		if($this->_check_confirm()){
		  	if($this->_model->delete($this->_params['delete'])){
		  		$this->_flash(0, $this->_('record_deleted'));
		  	}
		}
		$this->_redirect();
	}	
	protected function _do_deleteall(){
		if($this->_check_confirm()){
			$events = $this->_model->get_events();
			if($this->_model->delete_all()){
		    	if(LOG_SEND)
		    		$mail = "<pre>".print_r($events,true)."</pre>";
		    	else
		    		$mail = 'Delete events';
		    		 
		    	$this->_flash(LOG_MAIL_LEVEL, $this->_('admin_del_log'), $mail);
			} 
		}
	   	$this->_redirect();
	}
	protected function _do_deleteold(){
		if($this->_check_confirm()){
			$events = $this->_model->get_events_old();
			if($this->_model->delete_old()){
		    	$mail = "<pre>".print_r($events,true)."</pre>";
		    	$this->_flash(LOG_MAIL_LEVEL, $this->_('admin_del_log_old'), $mail);
		    }
		}
	   	$this->_redirect();	
	}
}