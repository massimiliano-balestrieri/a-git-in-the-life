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
 * $Id: usermessage_model.php 341 2007-12-03 23:10:20Z maxbnet $
 * $LastChangedDate: 2007-12-03 23:10:20 +0000 (Mon, 03 Dec 2007) $
 * $LastChangedRevision: 341 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/usermessage_model.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-03 23:10:20 +0000 (Mon, 03 Dec 2007) $
 */


class UsermessageModel extends ModuleModel{
	
	private $_helper = false;
	
	public function __construct($params = false){
		$this->_name = 'usermessage';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
		
		global $APP;
		$this->_helper = $APP->get_helper("usermessage");
		
	}
	//help processqueue_model->_success_send_email //STEP 8 : set status send
	//help processqueue_model->_unconfirmed_email
	//help processqueue_model->_invalid_email
	public function set_status($messageid ,$userid, $msg){
		return $this->_dao->set_status($messageid ,$userid, $msg);
	}
	//help processqueue_model->_check_lastbatch (substep)
	public function get_recently_sended($batch_period){
		return $this->_dao->get_recently_sended($batch_period);
	}
	//help processqueue_model->_send_message (STEP 4)
	public function get($messageid ,$userid){
		return $this->_dao->get($messageid ,$userid);
	}
	//help statistics_model
	public function get_viewed($id){
		return $this->_dao->get_viewed($id);
	}
	//help user_model->get_page_users
	public function get_user_number_messages($id){
		return $this->_dao->get_user_number_messages($id);
	}
	//help userhistory_controller->get
	public function get_user_messages_data($id, $bounces = array()){
		$data = $this->_dao->get_user_messages_data($id);
		$list_msg = array();$avgresp = 0; $resptime = 0;$totalresp = 0;
		foreach ($data['data'] as $key => $msg) {
			$clicks = 0;
		if (CLICKTRACK) {
			//TODO: $clicks = $this->db->sql_fetch_row_query(sprintf('select sum(clicked) as numclicks from %s where userid = %s and messageid = %s',
				//								$GLOBALS['tables']['linktrack'],$id,$msg['messageid']));
			//$clicks = @$clicks[0];
		}
		if (!$msg['notviewed']) {
			$resptime += $msg['responsetime'];
			$totalresp += 1;
		}
			$data['data'][$key]['clicks'] = $clicks;
			$data['data'][$key]['sent'] = $this->_helper->format_date_time($msg["entered"],1);
			$data['data'][$key]['viewed'] = $this->_helper->format_date_time($msg["viewed"],1);
			$data['data'][$key]['bounce'] = isset($bounces[$msg["messageid"]]) ? $bounces[$msg["messageid"]]['ftime'] : '';
			//'isviewed'=> !$msg['notviewed'],
			//TODO:'bounce'=> @$bounces[$msg["messageid"]],//TODO query secca?
		}
		if ($totalresp) {
			$avgresp = sprintf('%d',($resptime / $totalresp));
		}
		//sono costretto. come faccio a far arrivare tutti questi dati altrimenti? soluzione è comunque creare un metodo pubblico di semplice
		//recupero dei dati, e un metodo wrapper che ritorna i metadati
		return array(
					'num_msg' => $data['total'],
					'avg_resp'=> $avgresp,
					'list_msg'=> $data['data']
					);
	}
}
