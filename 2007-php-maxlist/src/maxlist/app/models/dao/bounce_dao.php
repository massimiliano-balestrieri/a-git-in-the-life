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

class BounceDao extends ModuleDao {

	public $table = false;
	public $db = false;

	public function __construct($params = false) {
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('bounce');
		$this->table_umb = $this->db->get_table('user_message_bounce');
		$this->_params = $params;
	}
	//call by model::processbounce::processbouncebatch_helper
	public function insert($msg_date, $header, $body){
		return $this->db->insert(sprintf('insert into %s (date,header,data) values("%s","%s","%s")', 
				$this->table, 
				date("Y-m-d H:i", strtotime($msg_date)), 
				addslashes($header), 
				addslashes($body)));
		
	}
	public function bounced_list_message($msgid,$userid,$bounceid){
		return $this->db->execute(sprintf('update %s
			      				set status = "bounced list message %d",
			      				comment = "%s bouncecount increased"
			      				where id = %d', 
			      				$this->table,
			      				$msgid, 
			      				$userid,
			      				$bounceid));			 

	}
	public function bounced_system_message($userid,$bounceid){
		return $this->db->execute(sprintf('update %s
			      				set status = "bounced system message",
			      				comment = "%s marked unconfirmed"
			      				where id = %d', 
			      				$this->table,
			      				$userid, 
			      				$bounceid));
	}
	public function bounced_unidentified_message($userid,$bounceid){
		return $this->db->execute(sprintf('update %s
			      				set status = "bounced unidentified message",
			      				comment = "%s bouncecount increased"
			      				where id = %d', 
			      				$this->table,
			      				$userid, 
			      				$bounceid));
	}
	public function unidentified_bounce($bounceid){
		return $this->db->execute(sprintf('update %s
							      set status = "unidentified bounce",
							      comment = "not processed"
							      where id = %d', $this->table, $bounceid));
	}
	
	public function get_page_bounces() {

		$params = $this->_params;
		$where = ' where status != "unidentified bounce" ';
		$pg = $params['pg'];
		$sql = 'select * from ' . $this->table . ' ' . $where . ' order by date desc ';
		$result = $this->db->get_select_page($sql, $pg);
		$total = $this->db->count();
		return array (
			'total' => $total,
			'data' => $result
		);
	}

	public function get($id) {
		$result = $this->db->fetch_query("SELECT * FROM {$this->table} where id = $id");
		return $result;
	}
	//help userhistory_controller->get
	public function get_user_bounces($id){
		$bounces = array();
		$list_bounces = array();
		# check for bounces
		return $this->db->query(sprintf('select *,date_format(time,"%%e %%b %%Y %%T") as ftime from %s where user = %d',
									$this->table_umb,$id));
		//TODO:    $bounces[$row["message"]] = $row["ftime"];
	}
}