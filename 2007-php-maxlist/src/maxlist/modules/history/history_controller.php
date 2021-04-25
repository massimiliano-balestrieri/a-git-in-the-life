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
 * $Id:scaffold_controller.php 264 2007-11-16 19:25:56Z maxbnet $
 * $LastChangedDate:2007-11-16 20:25:56 +0100 (ven, 16 nov 2007) $
 * $LastChangedRevision:264 $
 * $LastChangedBy:maxbnet $
 * $HeadURL:https://maxlist.svn.sourceforge.net/svnroot/maxlist/trunk/maxlist/modules/_scaffold/scaffold_controller.php $
 * 
 * $Author:maxbnet $
 * $Date:2007-11-16 20:25:56 +0100 (ven, 16 nov 2007) $
 */

class HistoryController extends ModuleController implements IModuleController{
	
	public function __construct(){
		
		global $APP;
		//TODO : check_role -  
		//$this->_check_role_view('admin');
		
		//istance model
		//TODO: actions,ajax, roles
		//params
		$params = array(
					'unblacklist'=> array('m' => 'post'),
					'do'=> array('in' => '', 'm' => 'post'),//TODO : options in
					'confirm'=>array('m' => 'post')
		);
		
		
		$this->_check_params($params);
		
		
		$this->_model = $APP->get_model2("user", $this->_params);  
		
		$this->_do();
		
		$this->_routing();
		
	}
	//GET
	protected function _view(){
		//carica il model
		global $APP;
		$id = $APP->ROUTING->id;
		$data = $this->_prepare_data_user_history($APP->ROUTING->id);
		$this->tpl = 'history';
		new HistoryView($this->_params, $data);	
	}
	//GET
	protected function _unblacklist(){
		$this->_view();
	}
	//POST
	protected function _do_unblacklist(){
		global $APP;
		$unblacklist = $this->_params['unblacklist'];
		$id = $this->_id();
		$model = $APP->get_model2('user');
		$user = $model->get($id);
		if($this->_check_confirm() && $model->unblacklist($id,$user['email'], $APP->SESSION->get_username())){
			$this->_flash(LOG_LEVEL, $this->_('user_unblacklisted'));	
		}
	    $this->_redirect('history','view',$id); 
	}
	private function _prepare_data_user_history($id){
		global $APP;
		$data['user'] = $this->_model->get($id);
		$data['list_bounces'] = $APP->get_model2("bounce")->get_user_bounces($id);
		$data['msg_data'] = $APP->get_model2("usermessage")->get_user_messages_data($id, $data['list_bounces']);
		$data['bl_data'] = $APP->get_model2("userblacklist")->get_user_blacklist_info($data['user']['email']);
		$data['list_sub'] =  $APP->get_model2("userhistory")->get_userhistory($id);
		//print_r($data['list_sub']);die;
		return $data;
	}	
}
