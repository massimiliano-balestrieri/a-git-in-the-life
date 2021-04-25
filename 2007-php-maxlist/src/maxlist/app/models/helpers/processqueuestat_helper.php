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
 * $Id: processqueuestat_helper.php 355 2007-12-23 17:46:42Z maxbnet $
 * $LastChangedDate: 2007-12-23 17:46:42 +0000 (Sun, 23 Dec 2007) $
 * $LastChangedRevision: 355 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/processqueuestat_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-23 17:46:42 +0000 (Sun, 23 Dec 2007) $
 */

class ProcessqueuestatHelper extends ProcessqueuebaseHelper{
	
	//counter
	private $_sent = 0;
	private $_notsent = 0;
	private $_invalid = 0;
	private $_unconfirmed = 0;
	private $_cannotsend = 0;
	private $_failed_sent = 0;
	private $_throttlecount = 0;
	
	private $_recently_sent = 0;
	
	private $_someusers = 0;
	
	private $_batch_total = 0;//num_users
	
	private $_wait = false;//TODO
	
	public function __construct(){
		$this->_init();	
	}
	public function get_sent(){
		return $this->_sent;
	}
	public function set_batch_total($total){
		$this->_batch_total = $total;
	}
	public function increase_notsent(){
		$this->_notsent++;
	}
	public function increase_unconfirmed(){
		$this->_unconfirmed++;
	}
	public function increase_invalid(){
		$this->_invalid++;
	}
	public function increase_sent(){
		$this->_sent++;
	}
	public function increase_failed_sent(){
		$this->_failed_sent++;
	}
	public function increase_cannot_sent(){
		$this->_cannotsend++;
	}
	public function someusers(){
		$this->_someusers = 1;
	}
	public function check_batch_limit_reached(){
		$conf = $this->_pq->_helper_conf;
		$stat = $this->_pq->_helper_stat;
		$num_per_batch = $conf->get_num_per_batch();
		$batch_period = $conf->get_batch_period();
		$sent = $stat->get_sent();
		if ($num_per_batch && $sent >= $num_per_batch) {
		//if(1){
	    	$this->_logger('batch limit reached'.": {$sent} ($num_per_batch)",  P_LEV_HIGH);
	    	$this->_wait = $batch_period;//TODO:here?
	    	die('Batch limit reached<br/><br/>');
	    }
	}
	public function log_shutdown_stage_5(){
		$conf = $this->_pq->_helper_conf;
		$num_per_batch = $conf->get_num_per_batch();  
		$batch_period = $conf->get_batch_period();
		$original_num_per_batch = $conf->get_original_num_per_batch();
		if ($num_per_batch && $batch_period) {//!$GLOBALS["commandline"] && 
			if ($this->_sent + 10 < $original_num_per_batch && !$this->_wait) {
				$this->_logger('Less than batch size were sent, so reloading imminently',  P_LEV_LOW);
				$delaytime = 10000;
			} else {
				$this->_logger(sprintf('Waiting for %d seconds before reloading', $batch_period),  P_LEV_LOW);
				$delaytime = $batch_period * 1000;
			}
			//se è batch attivo il polling?
			
			//$this->_logger("Do not reload this page yourself, because the next batch would fail");
			/*printf('<script language="Javascript" type="text/javascript">
			function reload() {
			var query = window.location.search;
			query = query.replace(/&reload=\d+/,"");
			query = query.replace(/&lastsent=\d+/,"");
			query = query.replace(/&lastskipped=\d+/,"");
			//document.location = document.location.pathname + query + "&reload=%d&lastsent=%d&lastskipped=%d";
			}
			setTimeout("reload()",%d);
			</script>', $this->_reload, $this->_sent, $this->_notsent, $delaytime);*/
		} else {
			/*printf('<script language="Javascript" type="text/javascript">
			var query = window.location.search;
			query = query.replace(/&reload=\d+/,"");
			query = query.replace(/&lastsent=\d+/,"");
			query = query.replace(/&lastskipped=\d+/,"");
			//document.location = document.location.pathname + query + "&reload=%d&lastsent=%d&lastskipped=%d";
			</script>', $this->_reload, $this->_sent, $this->_notsent);*/
			$this->_logger('Reload required',  P_LEV_LOW);
		}
	}
	public function log_end_send_message() {
		return;
		//TODO:
		$reload = $affrows = 0;
		$this->_processed = $this->_notsent + $this->_sent + $this->_invalid + $this->_unconfirmed + $this->_cannotsend + $this->_failed_sent;
		
		if ($this->_processed % 10 == 0) {
		#if (0) {
			$this->_logger(	'AR?' . $affrows . 
							' NUSERS ' . $this->_num_users . 
							' PROCESSED' . $this->_processed . 
						   	' SENT ' . $this->_sent . 
							' N' . $this->_notsent . 
							' INVALID' . $this->_invalid . 
							' UNCONF' . $this->_unconfirmed . 
						   	' CANNOT' . $this->_cannotsend . 
							' FAILED' . $this->_failed_sent,  P_LEV_HIGH);
			$rn = $reload * $this->_num_per_batch;
			$this->_logger(' PROCESSED ' . $this->_processed . 
						   ' NUSERS' . $this->_num_users . 
						   ' NUM_PER_BATCH' . $this->_num_per_batch . 
						   ' BATCH_TOTAL' . $this->_batch_total . 
						   ' RELOAD' . $reload . 
						   ' RELOAD_X_MAX' . $rn,  P_LEV_HIGH);
		}
	}
	public function log_statpoll($num_users){
		$this->_processed = $this->_notsent + $this->_sent + $this->_invalid + $this->_unconfirmed + $this->_cannotsend + $this->_failed_sent;
		$this->_logger('End - Processed ' . $this->_processed . ' out of ' . $num_users . ' users', P_LEV_LOW);
	}
	public function log_stat($totaltime){
		
		$msgperhour = (3600 / $totaltime) * $this->_sent;
		if ($this->_sent){
		    $this->_logger($this->_sent . ' messages sent in '. $totaltime. ' s '. (int)$msgperhour. ' msgs/hr.',  P_LEV_LOW);
			$this->_pq->_helper_session->set_lastsent($this->_sent);
			$this->_logger('Set lastsent:' . $this->_sent, P_LEV_HIGH);
		}
		if ($this->_invalid)
			$this->_logger(sprintf('%d %s', $this->_invalid, 'invalid emails'),  P_LEV_LOW);
		if ($this->_failed_sent)
			$this->_logger(sprintf('%d %s', $this->_failed_sent, 'emails failed (will retry later)'),  P_LEV_LOW);
		if ($this->_unconfirmed)
			$this->_logger(sprintf('%d %s', $this->_unconfirmed, 'emails unconfirmed (not sent)'),  P_LEV_LOW);
		
		$lastskipped = $this->_invalid + $this->_failed_sent + $this->_unconfirmed;  
    	$this->_pq->_helper_session->set_lastskipped($lastskipped);
		$this->_logger('Set lastskipped:' . $lastskipped, P_LEV_INTER);
    	
	}
	public function get_recently_sent($period){
		$this->_set_recently_sent($period);
		return $this->_recently_sent;
	}
	private function _set_recently_sent($period){
		$recently_sent = $this->_pq->_join_usermessage->get_recently_sended($period);
		$this->_recently_sent =  $recently_sent;//
	}
	
}