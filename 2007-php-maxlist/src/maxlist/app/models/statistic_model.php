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
 * $Id: statistic_model.php 323 2007-11-26 18:23:10Z maxbnet $
 * $LastChangedDate: 2007-11-26 18:23:10 +0000 (Mon, 26 Nov 2007) $
 * $LastChangedRevision: 323 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/statistic_model.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-11-26 18:23:10 +0000 (Mon, 26 Nov 2007) $
 */

class StatisticModel extends ModuleModel {

	private $_join_message;
	private $_join_listmessage;
	private $_join_usermessage;
	private $_helper;

	public function __construct($params = false) {
		$this->_name = 'statistic';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);

		global $APP;
		$this->_join_message = $APP->get_model2("message", $this->_params);//IMPORTANT : only type = sent
		$this->_join_listmessage = $APP->get_model2("listmessage");
		$this->_join_usermessage = $APP->get_model2("usermessage");
		$this->_join_linktrack = $APP->get_model2("linktrack");
		$this->_helper = $APP->get_helper("statistic");
	}
	//GET
	public function get_statistics() {
		$messages = $this->_join_message->get_messages_nodata();
		if (is_array($messages['messages']))
			foreach ($messages['messages'] as $key => $msg) {
				$messages['messages'][$key]['unique'] = $msg['sent'] && $msg['viewed'] ? $this->_join_usermessage->get_viewed($msg['id']) : 0;
				$messages['messages'][$key]['clicks'] = $this->_join_linktrack->get_clicks($msg['id']);
				$messages['messages'][$key]['timetosend'] = $this->_helper->time_diff($msg['sendstart'], $msg['sent']);
				$messages['messages'][$key]['lists'] = $this->_join_listmessage->get_csv_listdone($msg['id']);
			}
		//print_r($messages);die;
		return $messages;
	}

}