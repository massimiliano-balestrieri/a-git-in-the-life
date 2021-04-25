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
 * $Id: processqueuepolling_helper.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/processqueuepolling_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class ProcessqueuepollingHelper extends ProcessqueuebaseHelper{
	
	
	
	public function __construct(){
		$this->_init();
	}
	//session
	public function set_polling(){
		$this->_pq->_helper_session->set_polling();
		$this->_polling = $this->_pq->_helper_session->get_polling();
		$this->_logger('Polling: ' .  $this->_polling,  P_LEV_INTER);
	}
	public function reset_polling(){ 
		$this->_pq->_helper_session->reset_polling();
		$this->_logger('Reset polling',  P_LEV_INTER);
	}
	public function stat_lastpoll(){ 
		###debug
		//@ $this->_lastsent = sprintf('%d', $_GET['lastsent']);//TODO : 
		//@ $this->_lastskipped = sprintf('%d', $_GET['lastskipped']);//TODO 
		$this->_logger('Lastsent: ' .  $this->_pq->_helper_session->get_lastsent(),  P_LEV_INTER);
		$this->_logger('Lastskipped: ' .  $this->_pq->_helper_session->get_lastskipped(),  P_LEV_INTER);
		//TODO : reload?
		//if ($this->_reload) {
			//$this->_logger("Reload count: $this->_reload");
			//$this->_logger("Total processed: ".$this->_reload * $this->_num_per_batch);
			//$this->_logger($this->_('Sent in last run') . ':'. $this->_lastsent);
			//$this->_logger($this->_('Skipped in last run') .':'.$this->_lastskipped);
		//}
	}
}