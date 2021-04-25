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

class MembersController extends ModuleController implements IModuleController{
	
	private $_user_model = false;
	
	public function __construct(){
		
		global $APP;
		//TODO : check_role -  
		//$this->_check_role_view('admin');
		
		
		//params
		$params = array(
					'pg' 	=> array('t' => 'int', 'd' => 1),
					'block' => array('t' => 'int', 'd' => 1),
					'do'=> array('in' => '', 'm' => 'post'),//TODO : options in

					'user'=> array('m' => 'post'),
					//required
					'attribute'=>array('m' => 'post', 'd' => array()),
					'cbgattribute'=>array('m' => 'post', 'd' => array()),	
					'cbattribute'=>array('m' => 'post', 'd' => array()),	
					'cbgroup'=>array('m' => 'post', 'd' => array()),	
					
					'sortorder' => array('d' => 'asc'),
					'tagaction' => array('m' => 'post'),
					'tagaction_all' => array('m' => 'post'),
					'copydestination' => array('m' => 'post'),
					'copydestination_all' => array('m' => 'post'),
					'movedestination' => array('m' => 'post'),
					'movedestination_all' => array('m' => 'post'),
					'confirm'=>array('m' => 'post')
		);
		
		$this->_add_language('user');
		
		$this->_check_params($params);
		$this->_set_param_default_value('htmlemail',0,'user');
		$this->_set_param_default_value('confirmed',0,'user');
		$this->_set_param_default_value('disabled',0,'user');
		$this->_set_param_default_value('blacklisted',0,'user');
		
		
		$this->_model = new MembersModel($this->_params);  
		
		$this->_user_model = $APP->get_model2('user', $this->_params);
		
		$this->_do();
		
		$this->_routing();
		
	}
	//GET
	protected function _list($user = array()){
		global $APP;
		$id = $APP->ROUTING->id;
		$data = $this->_prepare_data_members($id);
		//print_r($data);die;
		if($data['members']['total'] == 0){
			$this->_info($this->_('list_no_member'));
		}
		$this->tpl = 'members';
		new MembersView($this->_params, $data, $this->_model->errors);	
	}
	//POST
	protected function _subscribe(){
		$id = $this->_id();
		$userid = $this->_params['user']['id'];
		if($this->_model->subscribe_list($userid, $id)){
			$this->_flash(LOG_LEVEL,$this->_('user_subscribe'));
		  	$this->_redirect('members','list',$id); 
		}

	}
	protected function _new(){
		//global $APP;
		//$model = $APP->get_model2('user');
	
		$id = $this->_id();
	
		$this->_validate();
		$this->_validate_new();
		
		if($this->_check_errors() && $this->_check_create()){
				
			if($new = $this->_user_model->insert_member($this->_params['user'])){
				$this->_flash(LOG_LEVEL,$this->_('user_created'));
		  		$this->_model->subscribe_list($new, $id);
		  		$this->_redirect('members','list',$id);
			} 
		}
	}
	protected function _processtags(){
		$action = $this->_check_tagaction();
		
		if(!$action)
			$action = $this->_check_tagaction_all();
		
		if($action){
			$action = '_' . $action;
			//echo $action;
			if(method_exists($this, $action))
				$this->$action();
			else
				die("<!--method not exist $action -->");
		}
	}
	//PRIVATE
	private function _prepare_data_members($id){
		global $APP;
		
		$data['user'] = array();
		if($email = $this->_param_in('user','email')){
			//$model = $APP->get_model2('user');
			$data['user'] = $this->_user_model->get_by_email($email);
			$data['user_attributes'] = $this->_user_model->get_user_attributes(false);
			if(isset($data['user']['id'])){
				$lists = $this->_model->get_array_memberships($data['user']['id']);
				//print_r($lists);die;
				if(array_key_exists($id, $lists))
					$this->_redirect('members','list',$id); 	
			}
		}
			
		//print_r($data['user']);die;
		
		$data['members'] = $this->_model->get_page_members($id);
		$list = $APP->get_model2("list");
		$data['lists'] = $list->get_array_other_lists($id);
		$data['list_name'] = $list->get_list_name($id);
		return $data;
	}
	//help routing
	private function _check_tagaction(){
		return isset($this->_params['tagaction']) ? $this->_return_action('tagaction') : false;
	}
	private function _check_tagaction_all(){
		return isset($this->_params['tagaction_all']) ? $this->_return_action_all('tagaction_all') : false;
	}
	private function _return_action_all($index){
		if($ret = $this->_return_action($index))
			return $ret . '_all';
	}
	private function _return_action($index){
		$val = $this->_params[$index];
		$list = array('move','copy','html', 'delete');
		if(in_array($val, $list))
			return $val;
		else
			return false;	
	}
	//POST ACTIONS
	private function _delete(){
		$id = $this->_id();
		if($id && $aff = $this->_model->unsubscribe_checked($id)){
			$this->_flash(LOG_LEVEL, $aff.' '.$this->_('users were deleted from this list'));
			$this->_redirect('members','list',$id); 
		}
	}
	private function _delete_all(){
		$id = $this->_id();
		if($id && $aff = $this->_model->unsubscribe_all($id)){
			$this->_flash(LOG_LEVEL, $aff.' '.$this->_('users were deleted from this list'));
			$this->_redirect('members','list',$id); 
		}
	}
	private function _copy(){
		global $APP;
		$destination = $this->_params['copydestination'];
		$id = $this->_id();
		if($id && $aff = $this->_model->copy_checked($id, $destination)){
			$this->_flash(LOG_LEVEL, $aff.' '.$this->_('users were copied to') . ' ' . 
						 $APP->get_model2('list')->get_list_name($destination));
			$this->_redirect('members','list',$id); 
		}
	}
	private function _copy_all(){
		global $APP;
		$destination = $this->_params['copydestination_all'];
		$id = $this->_id();
		if($id && $aff = $this->_model->copy_all($id, $destination)){
			$this->_flash(LOG_LEVEL, $aff.' '.$this->_('users were copied to') . ' ' .
						$APP->get_model2('list')->get_list_name($destination));
			$this->_redirect('members','list',$id); 
		}
	}
	private function _move(){
		global $APP;
		$destination = $this->_params['movedestination'];
		$id = $this->_id();
		if($id && $aff = $this->_model->move_checked($id, $destination)){
			$this->_flash(LOG_LEVEL, $aff.' '.$this->_('users were moved to') . ' ' . 
						 $APP->get_model2('list')->get_list_name($destination));
			$this->_redirect('members','list',$id); 
		}
	}
	private function _move_all(){
		global $APP;
		$destination = $this->_params['movedestination_all'];
		$id = $this->_id();
		if($id && $aff = $this->_model->move_all($id, $destination)){
			$this->_flash(LOG_LEVEL, $aff.' '.$this->_('users were moved to') . ' ' .
						$APP->get_model2('list')->get_list_name($destination));
			$this->_redirect('members','list',$id); 
		}
	}
	private function _html(){
		global $APP;
		$id = $this->_id();
		if($id && $aff = $this->_model->html_checked($id)){
			$this->_flash(LOG_LEVEL, $aff.' '.$this->_('users were updated'));
			$this->_redirect('members','list',$id); 
		}
	}
	private function _html_all(){
		global $APP;
		$id = $this->_id();
		if($id && $aff = $this->_model->html_all($id)){
			$this->_flash(LOG_LEVEL, $aff.' '.$this->_('users were updated'));
			$this->_redirect('members','list',$id); 
		}
	}
	//VALIDATE - copy from user
	private function _validate(){
		global $APP;
		//$model = $APP->get_model2('user', $this->_params);
		$this->_user_model->validates_presence_of('user',array('email' => $this->_('email_required')));
		$this->_user_model->validate('user',array('email' => $this->_('email_not_valid')), 'is_email_valid');
		$this->_user_model->validate_attributes();
		$this->_model->merge_errors($this->_user_model->errors);
		//$this->_model->errors = ;
	}
	private function _validate_new(){
		global $APP;
		//$model = $APP->get_model2('user', $this->_params);
		$this->_user_model->validate('user',array('email' => $this->_('email_exist')), 'email_not_exist');

		$this->_model->merge_errors($this->_user_model->errors);

/*		if(is_array($this->_model->errors))
			array_push($this->_model->errors, $model->errors);
		else
			$this->_model->errors = $model->errors;*/
		//TODO: merge_errors: see user_controller
		//$this->_model->merge_errors($this->_model_attribute->errors);
	}

}
