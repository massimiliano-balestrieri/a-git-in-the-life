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
 * $Id: processqueuethrottle_helper.php 355 2007-12-23 17:46:42Z maxbnet $
 * $LastChangedDate: 2007-12-23 17:46:42 +0000 (Sun, 23 Dec 2007) $
 * $LastChangedRevision: 355 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/processqueuethrottle_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-23 17:46:42 +0000 (Sun, 23 Dec 2007) $
 */

class ProcessqueuethrottleHelper extends ProcessqueuebaseHelper{
	
	private $_domainthrottle = array();
	private $_dt_interval = false;
	private $_running_throttle_delay = false;
	private $_throttled = false;//flag
	private $_throttlecount = 0;
	
	private $_time_last = false;
	private $_timer = false;
	private $_time = false;
	
	
	static public $waited = 0;
	
	public function __construct(){
		$this->_init();	
	}
	
	public function reset_counter(){
		$this->_throttlecount = 0;
		$this->_logger('Throttlecounter : 0', P_LEV_INTER);
	}
	public function get_throttled(){
		return $this->_throttled;
	}
	public function increase_throttle(){
		$this->_throttled++;
		$this->_logger('Increase throttled: ' . $this->_throttled, P_LEV_MEDIUM);
	}
	public function delay(){
		if(!USE_DOMAIN_THROTTLE)
			return;
		
		$stat = $this->_pq->_helper_stat;
		$sent = $stat->get_sent();
		if ($this->_running_throttle_delay) {
			//TODO: test
			$this->_logger('waited for (running_throttle_delay)' . $this->_running_throttle_delay . 'sec', P_LEV_HIGH);
			$this->_wait($this->_running_throttle_delay);
			if (($sent % 5) == 0) {
				# retry running faster after some more messages, to see if that helps
				$this->_running_throttle_delay = false;
				$this->_logger('Ogni 5 inviati resetto il delay.',P_LEV_HIGH);
			}
		}elseif (MAILQUEUE_THROTTLE) {
			$this->_logger('waited for (MAILQUEUE_THROTTLE)' . MAILQUEUE_THROTTLE . 'sec', P_LEV_HIGH);
			$this->_wait(MAILQUEUE_THROTTLE);
		}elseif (MAILQUEUE_BATCH_SIZE && MAILQUEUE_AUTOTHROTTLE && $sent > 10) {//sent 10
		
			$totaltime = $this->_get_totaltime_elapsed();
			$this->_logger('Elapsed (TEST) ' . $totaltime, P_LEV_HIGH);
			$msgperhour = (int) ((3600 / $totaltime) * $sent);
			$msgpersec = (int)  ($msgperhour / 3600);
			$secpermsg = (int) ($totaltime / $sent);
			$target = MAILQUEUE_BATCH_SIZE / MAILQUEUE_BATCH_PERIOD;
			$actual = (int) ($sent / $totaltime);
			$delay = (int)  ($actual - $target);
			$this->_logger("Sent: {$sent} mph $msgperhour mps $msgpersec secpm $secpermsg target $target actual $actual d $delay",P_LEV_LOW);
			if ($delay > 0) {
				@$expected = MAILQUEUE_BATCH_PERIOD / $secpermsg;
				@$delay = MAILQUEUE_BATCH_SIZE / $expected;
				$this->_logger('waiting for ' . $delay . ' seconds to make sure we don\'t exceed our limit of ' . MAILQUEUE_BATCH_SIZE . 
								   ' messages in ' . MAILQUEUE_BATCH_PERIOD . ' seconds', P_LEV_HIGH);
				//?$delay = $delay * 1000000;
				$this->_wait($delay);
			}
		}
		
	}
	
	private function _wait($sec){
		$waited = ProcessqueuethrottleHelper::$waited += $sec;
		$this->_logger(TEST_PROCESS . ' - WAIT add ' . $sec . '- WAITED :' . $waited , P_LEV_HIGH);
		if(!TEST_PROCESS){
			sleep($sec);
		}
	}

	//qui vede se inviare
	public function check_domain_throttle($email){
		if(!USE_DOMAIN_THROTTLE)
			return;

		$msg = $this->_pq->_helper_msg;
		$user = $this->_pq->_helper_user;
		//se non è in blacklist
		if ($msg->can_send() && USE_DOMAIN_THROTTLE) {
			list ($mailbox, $domainname) = explode('@', $email);
			$this->_init_time();
			//ora controllo se non è settato.
			if($this->_check_init_domainthrottle_interval($domainname)){
				
				$this->_increase_attempted($domainname);
				//se è settato vedo se è passato il tempo.
				if(!$this->_check_time($domainname)){
					//throttledomain quindi non invio.
					$this->_logger('DOMAIN_AUTO_THROTTLE :' . $domainname . ' attempted_:' . $this->_domainthrottle[$domainname]['attempted'], P_LEV_HIGH);
					//check_autothrottle (se ho poco carico. 1 messaggio e utenti meno di 1000)
					if (DOMAIN_AUTO_THROTTLE 
						&& $this->_domainthrottle[$domainname]['attempted'] > DOMAIN_AUTO_THROTTLE_ATTEMPTED # skip a few before auto throttling
						&& $msg->num_messages <= DOMAIN_AUTO_THROTTLE_MSGS # only do this when there's only one message to process otherwise the other ones don't get a change
						&& $user->num_users < DOMAIN_AUTO_THROTTLE_USERS # and also when there's not too many left, because then it's likely they're all being throttled
					) {
						$this->_domainthrottle[$domainname]['attempted'] = 0;
						$this->_logger(sprintf('There have been more than 10 attempts to send to %s that have been blocked for domain throttling.', $domainname), P_LEV_HIGH);
						$this->_logger('Introducing extra delay to decrease throttle failures', P_LEV_HIGH);
						if (!$this->_running_throttle_delay) {
							$this->_running_throttle_delay = (int) (MAILQUEUE_THROTTLE + (DOMAIN_BATCH_PERIOD / (DOMAIN_BATCH_SIZE * 4)));
						} else {
							$this->_running_throttle_delay += (int) (DOMAIN_BATCH_PERIOD / (DOMAIN_BATCH_SIZE * 4));
						}
						$this->_logger('Running throttle delay: '.$this->_running_throttle_delay, P_LEV_HIGH);
						$this->_logger('Viene settata una futura pausa di 5 secondi ma invio.', P_LEV_HIGH);
						$this->_pq->_helper_msg->set_cansend();
					}else{
						$this->_logger(sprintf('%s is currently over throttle limit of %d per %d seconds (' . 
										$this->_domainthrottle[$domainname]['sent'] . ')', 
										$domainname, DOMAIN_BATCH_SIZE, DOMAIN_BATCH_PERIOD), P_LEV_HIGH);
						$this->_pq->_helper_msg->set_cannotsend();
					}
					//non aggiorno i tempi. quindi al prossimo giro dovrei avere più margine e passare il check_time
					
				}else{
					$this->_pq->_helper_msg->set_cansend();
					//il time è passato. quindi posso inviare.
					//non aggiorno il timer. aspetto l'esito del messaggio per farlo
				}
			}else{
				$this->_logger(' Prima volta per il dominio:' . $domainname, P_LEV_HIGH);
				//posso inviare
				$this->_pq->_helper_msg->set_cansend();
						
			}
		}
	}
	
	//inviato 
	public function update_success_domain_throttle($email){
		if(!USE_DOMAIN_THROTTLE)
			return;
			
		list ($mailbox, $domainname) = explode('@', $email);
			if(!$this->_check_init_domainthrottle_interval($domainname)){
			$this->_init_domainthrottle($domainname);
			$this->_logger('Dominio : ' . $domainname . ' inizializzato.', P_LEV_HIGH);
		}
		$this->_update_domainthrottle_success($domainname);
	}
	//fallito l'invio
	public function update_failed_domain_throttle($email){
		if(!USE_DOMAIN_THROTTLE)
			return;

		list ($mailbox, $domainname) = explode('@', $email);
		if(!$this->_check_init_domainthrottle_interval($domainname)){
			$this->_init_domainthrottle($domainname);
			$this->_logger('Dominio : ' . $domainname . ' inizializzato.', P_LEV_HIGH);
		}
		$this->_update_domainthrottle_failed($domainname);
	}
	private function _update_domainthrottle_success($domainname){
		$this->_domainthrottle[$domainname]['sent']++;//?
		$this->_domainthrottle[$domainname]['last'] = $this->_time;
		$this->_logger('Dominio : ' . $domainname . ' inviati: ' . $this->_domainthrottle[$domainname]['sent'], P_LEV_HIGH);
		$this->_logger('Dominio : ' . $domainname . ' time: ' . $this->_time, P_LEV_HIGH);
	}
	private function _update_domainthrottle_failed($domainname){
		$failed = $this->_domainthrottle[$domainname]['failed']++;//?
		$this->_domainthrottle[$domainname]['last'] = $this->_time;
		$this->_logger('Dominio : ' . $domainname . ' falliti: ' . $failed, P_LEV_HIGH);
		$this->_logger('Dominio : ' . $domainname . ' time: ' . $this->_time, P_LEV_HIGH);
	}
	private function _init_domainthrottle($domainname){
		$this->_domainthrottle[$domainname] = array ();
		$this->_domainthrottle[$domainname]['sent'] = 0;//?
		$this->_domainthrottle[$domainname]['failed'] = 0;//?attempted
		$this->_domainthrottle[$domainname]['attempted'] = 0;//?attempted
	}
	
	private function _increase_attempted($domainname){
		$this->_domainthrottle[$domainname]['attempted']++;
	}	
	private function _check_time($domainname){
		$time = $this->_time;
		$time2 = $this->_domainthrottle[$domainname]['last'];
		$diff = ($time - $time2);
		$esito = $diff >= DOMAIN_BATCH_PERIOD;
		$this->_logger('Dominio:' . $domainname . '. passato tempo :' . $diff . 'quindi :' . print_r($esito,true), P_LEV_HIGH);
		return $esito;	
	}
	private function _init_time(){
		//salvo 
		if(!$this->_timer)
			$this->_timer = new MaxTimerHelper();
		
		$this->_time_last = $this->_time; 
		if(!$this->_time)
			$this->_time = time();
		
		//se siamo in test
		if(TEST_PROCESS && TEST_SLEEP_PER_MAIL)
			$this->_time += TEST_SLEEP_PER_MAIL; 	
		else
			$this->_time = time();
			
		$this->_logger('Ore:' . $this->_time , P_LEV_HIGH);
	}
	private function _get_totaltime_elapsed(){
		$stat = $this->_pq->_helper_stat;
		$sent = $stat->get_sent();
		$wait = (int) ProcessqueuethrottleHelper::$waited;
		if(TEST_PROCESS && TEST_SLEEP_PER_MAIL){
			return $this->_timer->elapsed(1) + ($sent*TEST_SLEEP_PER_MAIL) + $wait;
		}else{
			return $this->_timer->elapsed(1);
		}
	}
	private function _check_init_domainthrottle_interval($domainname){
		return isset($this->_domainthrottle[$domainname]);
	}
}