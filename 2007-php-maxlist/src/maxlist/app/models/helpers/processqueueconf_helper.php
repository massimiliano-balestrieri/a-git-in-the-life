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
 * $Id: processqueueconf_helper.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/processqueueconf_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class ProcessqueueconfHelper extends ProcessqueuebaseHelper{
	
	//var batch
	private $_num_per_batch = 0;
	private $_maxbatch = -1;//why -1
	
	private $_batch_period = 0;
	private $_minbatchperiod = -1;
	
	private $_safemode = false;
	private $_recently = false;
	
	private $_original_num_per_batch = 0;
	
	
	public function __construct(){
		$this->_init();	
	}
	
	public function init_conf(){
		$this->_check_localconf();//TODO
		$this->_set_num_per_batch();
		$this->_set_batch_period(); 
		$this->_check_safemode(); 
		$this->_check_lastbatch();
		$this->_time_limit();
		$this->_isp_restrictions();
		$this->_isp_lockfile();
		$this->_check_num_per_batch();//direi che non entra da alcuna parte.... MAILQUEUE_BATCH_SIZE = 0		
		$this->_set_bigtables();//direi che non entra da alcuna parte.... MAILQUEUE_BATCH_SIZE = 0		
		$this->_min_num_per_batch();
	}
	public function log_conf(){
		global $APP;
		if (!$this->_safemode) {
			if (!$this->_num_per_batch) {
				$this->_logger('It is safe to click your stop button now.Reports will be sent by email to' . 
												$APP->CONF->get('report_address'),  P_LEV_LOW);//TODO : when?
				die("TEST: log_conf");
			} else {
				$this->_logger('Please leave this window open. You have batch processing enabled, so it will reload several times to send the messages. Reports will be sent by email to'. 
												$APP->CONF->get('report_address'),  P_LEV_INTER);
			}
		} else {
			$this->_logger('Your webserver is running in safe_mode. Please keep this window open. It may reload several times to make sure all messages are sent. Reports will be sent by email to' .  
						  						$APP->CONF->get('report_address'),  P_LEV_LOW);
		}
	}
	public function get_num_per_batch(){
		return $this->_num_per_batch;
	}
	public function get_batch_period(){
		return $this->_batch_period;
	}
	public function get_original_num_per_batch(){
		return $this->_original_num_per_batch;
	}
	
	private function _check_localconf(){
		//TODO:
	}
	private function _set_num_per_batch(){
		if (MAILQUEUE_BATCH_SIZE) {
			if ($this->_maxbatch > 0) {//set by localconf
				$this->_num_per_batch = min(MAILQUEUE_BATCH_SIZE, $this->_maxbatch);
			} else {
				$this->_num_per_batch = sprintf('%d', MAILQUEUE_BATCH_SIZE);
			}
		} else {
			if ($this->_maxbatch > 0) {
				$this->_num_per_batch = $this->_maxbatch;
			}
		}
		
		$this->_logger('num_per_batch : ' . $this->_num_per_batch,  P_LEV_INTER);
		$this->_logger('maxbatch : ' . $this->_maxbatch,  P_LEV_INTER);
		
	}
	private function _set_batch_period(){
		if (MAILQUEUE_BATCH_PERIOD) {
			if ($this->_minbatchperiod > 0) {//set by localconf
				$this->_batch_period = max(MAILQUEUE_BATCH_PERIOD, $this->_minbatchperiod);
			} else {
				$this->_batch_period = MAILQUEUE_BATCH_PERIOD;
			}
		}
		$this->_logger('batch_period : ' . $this->_batch_period .'s',  P_LEV_INTER);//TODO: test
		$this->_logger('minbatchperiod : ' . $this->_minbatchperiod,  P_LEV_INTER);
	}
	private function _check_safemode(){
		$safemode = 0;
		if ($safemode = ini_get("safe_mode")) {
			# keep an eye on timeouts
			$this->_safemode = 1;
			$this->_num_per_batch = min(100, $this->_num_per_batch);
			#  Fatal_Error("Process queue will not work in safe mode");
			$this->_logger('num_per_batch min(100): ' . $this->_num_per_batch,  P_LEV_MEDIUM);
			$this->_logger($this->_('In safe mode, batches are set to a maximum of 100'),  P_LEV_LOW);
		}
		$this->_logger('safemode : ' .$safemode,  P_LEV_INTER);
	}
	private function _check_lastbatch(){
		if ($this->_num_per_batch && $this->_batch_period) {
			# check how many were sent in the last batch period and take off that
			# amount from this batch
			$this->_original_num_per_batch = $this->_num_per_batch;
			//TODO:
			$this->_recently = $this->_pq->_helper_stat->get_recently_sent($this->_batch_period);
			$this->_num_per_batch -= $this->_recently;
			//TODO: why? che logica c'è qui?   
			//1) num_per_batch diventa recently sent?
			//$this->_num_per_batch = 2;//TEST
			
			# if this ends up being 0 or less, don't send anything at all
			if ($this->_num_per_batch == 0) {
				$this->_num_per_batch = -1;
				$this->_logger('num_per_batch : FALSE',  P_LEV_LOW);//?
			}
			$this->_logger('recently_sent : ' .$this->_recently,  P_LEV_INTER);
			
		}
	}
	private function _time_limit(){
		//init pqueue
		# we don not want to timeout or abort
		ignore_user_abort(1);//$abort = ?
		$this->_logger('ignore_user_abort = 1',  P_LEV_INTER);
		
		$flag = @set_time_limit(600);
		if($flag)
			$this->_logger('set_time_limit : 600',  P_LEV_INTER);
	}
	private function _isp_restrictions(){
		//TODO:
		//if ($this->_isp_restrictions != "") {
		//	$this->_logger($this->_isp_restrictions);
		//}
		
	}
	private function _isp_lockfile(){
		//TODO:
		//if (is_file($this->_isp_lockfile)) {
			//TODO: ProcessError($this->_('Processing has been suspended by your ISP, please try again later'), 1);
		//}
	}
	private function _check_num_per_batch(){
		//$this->_num_per_batch = -1;//TEST TODO
		//$this->_original_num_per_batch = $this->_num_per_batch+1;//TEST 2
		if ($this->_num_per_batch > 0) {
			if ($this->_original_num_per_batch != $this->_num_per_batch) {
				$diff = $this->_original_num_per_batch - $this->_num_per_batch;
				$this->_logger('This batch will be ' . $this->_num_per_batch . 
							   ' emails, because in the last ' . $this->_batch_period .  
							   ' seconds (recently : '. $this->_recently .') ' . $diff . ' emails were sent',  P_LEV_LOW);
			} else {
				$this->_logger('Sending in batches of ' . $this->_num_per_batch . ' emails. (recently : '. $this->_recently .')',  P_LEV_LOW);
			}
		}
		elseif ($this->_num_per_batch < 0) {
			$this->_logger('In the last ' . $this->_batch_period . 
						   ' seconds more emails were sent' . " ({$this->_recently}) " . 
						   ' than is currently allowed per batch' . " ({$this->_original_num_per_batch}).",  P_LEV_LOW);
			$this->_pq->_helper_batch->limit_reached();
		}
	}
	private function _set_bigtables(){
		$this->_pq->_dao->set_sql_big_tables();
		$this->_logger('set big tables',  P_LEV_INTER);
	}
	private function _min_num_per_batch(){
		if (!$this->_num_per_batch) {
			$this->_num_per_batch = 1000000;
			$this->_logger('num_per_batch : 1000000',  P_LEV_LOW);//TODO : when?
			die("Test : _min_num_per_batch");
		}
	}
}