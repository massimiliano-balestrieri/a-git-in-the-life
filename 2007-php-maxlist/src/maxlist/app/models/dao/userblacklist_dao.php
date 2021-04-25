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
 * $Id: userblacklist_dao.php 393 2008-01-18 18:09:49Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 393 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/dao/userblacklist_dao.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 */

class UserblacklistDao extends ModuleDao {

	public $table = false;
	public $db = false;

	public function __construct($params = false) {
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('user_blacklist');
		$this->table_data = $this->db->get_table('user_blacklist_data');
		$this->_params = $params;
	}
	
	//help model::userhistory_controller->get
	public function get_user_blacklist_info($email){
		 return $this->db->fetch_query(sprintf('select * from %s where email = "%s"',
		    												$this->table,$email));
	}
	//help model::userhistory_controller->get
	public function get_user_blacklist_data($email){
		 return $this->db->query(sprintf('select * from %s where email = "%s"',
		  							  $this->table_data,$email));
	}
	
	//help model::get_user_blacklist_info (userhistory_controller->get)
	//help model::MAILER helper is_email_blacklisted
	//help model::user_model->confirm
	public function is_email_blacklisted($email){
		if (!$email) return 0;
		  
		global $APP;
	  	$gracetime = sprintf('%d',BLACKLIST_GRACETIME);
	  	if (!$gracetime || $gracetime > 15 || $gracetime < 0) {
	    	$gracetime = 5;
	  	}
  		# allow 5 minutes to send the last message acknowledging unsubscription
  		$sql = sprintf('select * from %s where email = "%s" and date_add(added,interval %d minute) < now()',
  						$this->table,$email,$gracetime);
  		return $this->db->query($sql);
		
	}
	//help  model::user_model->unsubsubscribe
	public function add_blacklist($email,$reason){
		$this->db->insert(sprintf('insert ignore into %s (email,added) values("%s",now())',
							$this->table,stripslashes($email)));
		
		# save the reason, and other data
		$this->db->insert(sprintf('insert ignore into %s (email,name,data) values("%s","%s","%s")',
							$this->table_data,stripslashes($email),
							"reason",stripslashes($reason)));
		foreach (array("REMOTE_ADDR") as $item ) { # @@@do we want to know more?
			if (isset($_SERVER[$item])) {
				$this->db->insert(sprintf('insert ignore into %s (email,name,data) values("%s","%s","%s")',
									$this->table_data,stripslashes($email),$item,stripslashes($_SERVER[$item])));
			}
		}
	}
	//help  model::user_model->confirm
	public function delete_blacklist($email){
		$this->db->execute(sprintf('delete from %s where email = "%s"',
							$this->table,stripslashes($email)));
		# save the reason, and other data
		$this->db->execute(sprintf('delete from %s where email = "%s"',
							$this->table_data,stripslashes($email)));
	}
	
}