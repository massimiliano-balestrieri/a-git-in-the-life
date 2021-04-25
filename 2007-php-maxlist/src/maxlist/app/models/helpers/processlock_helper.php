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
 * $Id: processlock_helper.php 355 2007-12-23 17:46:42Z maxbnet $
 * $LastChangedDate: 2007-12-23 17:46:42 +0000 (Sun, 23 Dec 2007) $
 * $LastChangedRevision: 355 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/processlock_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-23 17:46:42 +0000 (Sun, 23 Dec 2007) $
 */

class ProcesslockHelper{
	
	//process
	private $_process_id = false;
	private $_process = false;
	private $_level_verbosity = 1;
	private $_level_logevent = 1;
	
	//join 
	protected $_join_process = false;
	
	public function __construct($process){
		global $APP;
		if(!$process) die('process no name');
		
		$this->_join_process = $APP->get_model2('process');
	
		$this->_process = $process;
	}
	public function configure($verbosity = 1, $logevent  = 1){
		$this->_level_verbosity = $verbosity;
		$this->_level_logevent = $logevent;
	}
	//call by model & other helpers
	public function release_lock(){
		$this->_do_release_lock();
	}
	public function init_lock(){
		$this->_lock();
	}
	public function keep_lock() {
		set_time_limit(120);
    	# check if we have been "killed"
    	if ($alive = $this->_join_process->check_lock($this->_process_id)){
		   	$this->_join_process->keep_lock($this->_process_id);
		}else {
		   	die('Process Killed by other process');
		}
	}
	
	//call by model
	protected function _check_lock(){
		$this->_process_id = $this->_get_lock();
	}
	protected function _lock(){
		//TODO: 
		$running = $this->_get_running();
		$waited = 0;
		//print_r($running);die;
		while ($running['id']) { # a process is already running
			//TODO:test
			if ($running['t'] > 600) { # some sql queries can take quite a while
				# process has been inactive for too long, kill it
				$this->_join_process->update($running['id']);
			} else {
				
				//if ($GLOBALS["commandline"])
				//	die("Running commandline, quitting. We'll find out what to do in the next run.");
				
				$this->_logger('A process for this page is already running and it was still alive' . $running['id'] .': '. $running['t'] . ' seconds ago',  P_LEV_HIGH);
					
				if(TEST_PROCESS){
					$this->_logger('Not Sleeping for 20 seconds, aborting will quit. TEST_PROCESS',  P_LEV_HIGH);
				}else{
					sleep(1); # to log the messages in the correct order
					$this->_logger('Sleeping for 20 seconds, aborting will quit',  P_LEV_HIGH);
					ignore_user_abort(0);
					sleep(PROCESS_SLEEP_TIME);	
				}
				
			}
			$waited++;
			if ($waited > PROCESS_SLEEP_TIME_MAX) {
				//TODO:test
				# we have waited 10 cycles, abort and quit script
				$this->_logger('We have been waiting too long, I guess the other process is still going ok',  P_LEV_HIGH);
				exit;
			}
			$running = $this->_get_running();
		}
		$this->_process_id = $this->_set_lock();
		//return $process_id;
	}
	private function _do_release_lock(){
		if(!$this->_process_id) 
			$this->_check_lock();
		$aff = $this->_join_process->release_lock($this->_process_id);
		$this->_logger('Release Lock: ' .  print_r($this->_process_id,true),  P_LEV_INTER);
		return $aff;
	}
	private function _set_lock(){
		$process_id = $this->_join_process->insert($this->_process);
		$this->_logger('Set Lock: ' .  print_r($process_id,true),  P_LEV_INTER);
		return $process_id;
	}
	private function _get_lock(){
		$process_id = $this->_join_process->get_lock($this->_process);
		$this->_logger('Get Lock: ' . $process_id ,  P_LEV_INTER);
		return $process_id;
	}
	private function _get_running(){
		return $this->_join_process->get_running($this->_process);
	}
	private function _logger($msg, $verb_level) {
		global $APP;
		//$infostring = "[". date("D j M Y H:i",time()) . "] [" . $_SERVER["REMOTE_ADDR"] ."]";
		if($verb_level <= $this->_level_verbosity)
			print "$msg <br/><br/>";
		$this->_helper_log->_arrlog[] = $msg;
		
		if($verb_level <= $this->_level_logevent)//TODO: test
			$APP->MSG->watchdog(LOG_LEVEL, $msg);
	}
	
}