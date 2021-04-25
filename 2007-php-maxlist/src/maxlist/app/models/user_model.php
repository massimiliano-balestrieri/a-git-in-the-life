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
 * $Id:user_model.php 314 2007-11-25 08:09:32Z maxbnet $
 * $LastChangedDate:2007-11-25 09:09:32 +0100 (dom, 25 nov 2007) $
 * $LastChangedRevision:314 $
 * $LastChangedBy:maxbnet $
 * $HeadURL:https://maxlist.svn.sourceforge.net/svnroot/maxlist/trunk/maxlist/app/models/old/user_model.php $
 * 
 * $Author:maxbnet $
 * $Date:2007-11-25 09:09:32 +0100 (dom, 25 nov 2007) $
 */


class UserModel extends ModuleModel{
	

	private $_join_listuser = false;
	private $_join_usermessage = false;
	private $_join_userstat = false;
	private $_join_userblacklist = false;
	private $_join_userhistory = false;
	
	private $_join_attribute = false;
	
	public function __construct($params = false, $context = false){
		$this->_name = 'user';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);

		global $APP;		
		//join 
		$this->_join_listuser = $APP->get_model2('members');
		$this->_join_userstat = $APP->get_model2('userstat');
		$this->_join_userblacklist = $APP->get_model2('userblacklist');
		$this->_join_usermessage = $APP->get_model2('usermessage');
		$this->_join_userhistory = $APP->get_model2('userhistory');
		
		$APP->load_model('attribute');
		$this->_join_attribute = new AttributeModel($this->_params, 'user'); 
		
		require_once (APP_ROOT . '/app/models/helpers/user_helper.php');
		$this->_helper = new UserHelper($params, $context);
	}
	//GET users
	public function get_page_users(){
		$result = $this->_dao->get_page_users();
		$lists = $nummsg = array();
		
		foreach($result['data'] as $row){
			$lists[$row['id']] = $this->_join_listuser->get_csv_memberships($row['id']);
			$nummsg[$row['id']] = $this->_join_usermessage->get_user_number_messages($row['id']);
		} 
		return array('total' => $result['total'], 'data' => $result['data'], 'lists' => $lists, 'nummsg' => $nummsg);
	}
	//GET user
	public function get($id){
		return $this->_dao->get($id);
	}
	//GET attribute
	public function get_user_attributes($id){
		return $this->_join_attribute->get_fields($id);
	}
	public function get_user_attributes_values($id){
		return $this->_join_attribute->get_user_attributes_values($id);
	}
	//GET - exception
	public function confirm($id){
		$user = $this->get($id);
		$blacklisted = $this->_join_userblacklist->is_email_blacklisted($user["email"]);
		
		$aff = $this->_dao->confirm($id);
		
		$str_new_lists = $this->_join_listuser->get_csv_memberships($id);
		$this->_helper->cache_str_new_lists($str_new_lists);
		
		if ($blacklisted) {
			$this->unblacklist($user['email']);
		}
		$user_history_id = $this->_join_userhistory->add_user_history($id,
																	"Confirmation",
	 																"Lists: $str_new_lists");
			
		$this->_helper->send_confirm($id, $user, $blacklisted);
		$this->_join_userstat->add_subscriber_statistics('confirmation',1);
		return true;//TODO: true se send email . rollback nel caso
	}
	//POST
	public function delete($id){
		return $this->_dao->delete($id);
	}
	//POST
	public function insert($params = false){
		if(!$params) $params = $this->_params;
		$id = $this->_dao->insert($params);
		
		//echo $id;die;
		if($id){
			$this->_helper->is_new();//
			if($this->_helper->context == 'fo'){
				$this->_join_userstat->add_subscriber_statistics('total users',1);
			}
			$this->update($id, $params);//, $this->_params['user']
			return $id;	
		}else{
			return false;
		}
	}
	//POST
	public function update($id, $params = false){
		if(!$params) $params = $this->_params;//important EXTERNAL CONTEXT
		
		$old_user = $this->_dao->get($id);
		$old_attributes = $this->get_user_attributes_values($id);
		$old_subscribe = $this->_join_listuser->get_array_memberships($id);
		
		$this->_helper->cache_old_user($old_user, $old_attributes);
		$this->_helper->cache_old_subscribe($old_subscribe);
		
		//print_r($old_attributes);die;
		
		$updated = $this->_dao->update($id, $params);
		
		//STEP attribute
		$attributes_updated = $this->_join_attribute->save_attributes($id);
		if($attributes_updated)
				$this->_log($this->_('attributes_saved'));
		
		//STEP subscribe
		
		$subscribe = $this->_join_listuser->subscribe($id, $params,$this->_helper->context);
		if($subscribe)
			$this->_flash(0,$this->_('user_lists_subscribe'));
		
		
		//STEP history
		//die("user->update->history");
		$new_user = $this->_dao->get($id);
		$new_attributes = $this->get_user_attributes_values($id);
		$new_subscribe = $this->_join_listuser->get_array_memberships($id);
		$str_new_lists = $this->_join_listuser->get_csv_memberships($id);
		
		$this->_helper->cache_new_user($new_user, $new_attributes);
		$this->_helper->cache_new_subscribe($new_subscribe);
		$this->_helper->cache_str_new_lists($str_new_lists);
		
		$userid = $new_user['id'];
		
		$history = $this->_helper->get_history($id);
	 	$user_history_id = $this->_join_userhistory->add_user_history($userid,
	 												$history['history_subject'],
	 												$history['history_entry']);
	 												
		//STEP emails
		if($this->_helper->context == 'fo'){
		
				$email = $this->_helper->send_emails($id);
				if(!$email){
					//$this->_rollback_update($id, $old_subscribe, $user_history_id);
					//$this->_flash(LOG_LEVEL, 'Fatal Error');
					//$this->_redirect();	
				}
		}
		return $updated || $subscribe || $attributes_updated;
		
	}
	//POST
	public function unsubscribe($id, $params = false){//call by fo controller
		if($params)
			$this->_params = $params;
		
		$user = $this->get($id);
		
		$email = trim($user['email']);
		$reason = $this->_params['unsubscribe']['reason'];
		
		$unsubscribe = $this->_join_listuser->unsubscribe($id);
		
		
		# add user to blacklist
		$this->_join_userblacklist->add_blacklist($id,$email,$reason);
		$this->_dao->blacklist($email);
		
		$lists = "* ".$this->_('all_lists')."\n";//TODO
		$this->_join_userhistory->add_user_history($id,"Unsubscription","Unsubscribed from $lists Reason:$reason");
		
		$this->_helper->send_unsubscribe($id, $user, $reason);
		
		$this->_join_userstat->add_subscriber_statistics('unsubscription',1);
		return true;	
	}
	//HELP OTHER
	//help attribute_dao::fix_users
	public function get_array_id_users(){
		$res = $this->_dao->get_array_id_users();
		$ret = array();
		foreach($res as $row){
			$ret[$row[0]] =$row[0];
		}
		return $ret;
	}
	//help members_controller->new
	public function insert_member($params){
		$id = $this->_dao->insert_member($params);
		
		$attributes_updated = $this->_join_attribute->save_attributes($id);
		if($attributes_updated)
				$this->_flash(LOG_LEVEL,$this->_('attributes_saved'));
				
		return $id;
	}
	//help members_model->html_checked, members_model->html_all
	public function set_html($userid){
		return $this->_dao->set_html($userid);
	}
	//help processbouncebatch_helper
	public function increase_bouncecount($userid){
		return $this->_dao->increase_bouncecount($userid);
	}
	//help processbouncebatch_helper
	public function set_unconfirmed($id){
		return $this->_dao->set_unconfirmed($id);
	}
	//help processqueue_model->_get_users
	public function get_users_tosend($messageid, $userconfirmed, $exclusion, $user_attribute_query,$num_to_send = false){
		return $this->_dao->get_users_tosend($messageid, $userconfirmed, $exclusion, $user_attribute_query,$num_to_send);
	}
	//help $this->confirm $fromadmin = false
	//help history_controller->do_unblacklist $fromadmin = true
	public function unblacklist($id,$email, $fromadmin = false){
		$data = $this->_join_userblacklist->delete_blacklist($email);
		$aff = $this->_dao->un_blacklist($email);
		if($fromadmin){
			$historysubject = $historymessage = "Removed from blacklist by ".$fromadmin;
    	}else{
    		$historysubject = "Confirmation";
	 		$historymessage = "User removed from Blacklist for manual confirmation of subscription";
    	}
		$user_history_id = $this->_join_userhistory->add_user_history($id,$historysubject, $historymessage);
	 	return $aff;		
	}
	//help model::processbouncebatch_helper
	public function get_id_by_email($email){
		return $this->_dao->get_id_by_email($email);
	}
	//help message_controller->send_test
	public function get_by_email($email){
		return $this->_dao->get_by_email($email);
	}
	//help bounce_model->get_page_bounces
	public function get_email($userid){
		return $this->_dao->get_email($userid);
	}
	//help CONF helper
	public function get_uniqid_by_id($id){
		return $this->_dao->get_uniqid_by_id($id);
	}
	//help subscribe_controller
	public function get_id_by_uniqid($uid){
		return $this->_dao->get_id_by_uniqid($uid);
	}
	//VALIDATE
	//validate attributes
	public function validate_attributes(){
		$this->_join_attribute->validate_attributes();
		$this->merge_errors($this->_join_attribute->errors);
	}
	public function is_email_valid($email){
		//mail
		$email = trim($email);
  		# hmm, it seems people are starting to have emails with & and ' or ` chars in the name
		$pattern =
		"^[\&\'-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ac|ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dev|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|home|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|loc|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|quipu|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$";
  		return eregi($pattern, $email);
	}
	public function email_not_exist($email){
		return $this->_dao->email_not_exist($email);
	}
}
