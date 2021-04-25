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
 *
 * Maxlist is a fork of PhpList, a newsletter manager. 
 * The code was deeply changed so there are features of the original phpList and new ones. 
 * It uses smarty, generates XHTML strict, uses an AJAX layer, italian language ,
 * multi-istance, and use case based.
 *
 * 
 * $Id: processtemp_helper.php 393 2008-01-18 18:09:49Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 393 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/processtemp_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:09:49 +0000 (Fri, 18 Jan 2008) $
 */
 
class ProcesstempHelper{
	//batch
	private $_timer = false;
	
	private $_domainthrottle = array ();
	private $_isp_restrictions = '';
	private $_isp_lockfile = '';
	//TODO: private $_rssitems = array ();
	//TODO: private $_user_attribute_query = '';
	private $_lastsent = false;
	private $_lastskipped = false;

	private $_report = '';
	private $_nothingtodo = 0;
	
	private $_reload = false;//?
	
	
	//counter? 
	private $_notsent =  0;
	private $_sent =  0;
	private $_invalid =  0;
	private $_unconfirmed = 0;
	private $_cannotsend = 0;
	
	
	public function batch() {
		global $APP;
		
		
		
		
		
	}

	
	
	//3 
	private function _pre_send_message(){
		if ($num_per_batch && $sent >= $num_per_batch) {
			$this->_logger($this->_('batch limit reached') . ": $sent ($num_per_batch)");
			$GLOBALS["wait"] = $batch_period;
			return;
		}
		$userid = $userdata[0]; # id of the user
		$some = 1;
		@ set_time_limit(120);
		# check if we have been "killed"
		$alive = checkLock($send_process_id);
		if ($alive)
			keepLock($send_process_id);
		else
			ProcessError($this->_('Process Killed by other process'));

		# check if the message we are working on is still there and in process
		$status = fetch_query("select id,status from {$tables['message']} where id = $messageid");
		if (!$status['id']) {
			ProcessError($this->_('Message I was working on has disappeared'));
		}
		elseif ($status['status'] != 'inprocess') {
			ProcessError($this->_('Sending of this message has been suspended'));
		}

		flush();
		
	}

	private function _use_domain_throttle(){
		
	}
	private function _send_bb(){
		
		
	}

	private function _process_rss(){
		if (ENABLE_RSS && $processrss) {
			foreach ($rssitems as $rssitemid) {
				$status = Sql_query("update {$tables['rssitem']} set processed = processed +1 where id = $rssitemid");
				$um = Sql_query("replace into {$tables['rssitem_user']} (userid,itemid) values($userid,$rssitemid)");
			}
			Sql_Query("replace into {$tables["user_rss"]} (userid,last) values($userid,date_sub(now(),interval 15 minute))");

		}
	}

	
	private function _cannot_send(){
	}
	
	
		

	


	//2 - STEP 4
	private function _get_users(){
		return true;
		# when using commandline we need to exclude users who have already received
		# the email
		# we don't do this otherwise because it slows down the process, possibly
		# causing us to not find anything at all
		$exclusion = "";
		$doneusers = array ();
		$skipusers = array ();
		
		$req = Sql_Query("select userid from {$tables["usermessage"]} where messageid = $messageid");
		$skipped = Sql_Affected_Rows();
		while ($row = Sql_Fetch_Row($req)) {
			$alive = checkLock($send_process_id);
			if ($alive)
				keepLock($send_process_id);
			else
				ProcessError($this->_('Process Killed by other process'));
			array_push($doneusers, $row[0]);
		}
		# also exclude unconfirmed users, otherwise they'll block the process
		# will give quite different statistics than when used web based
		#  $req = Sql_Query("select id from {$tables["user"]} where !confirmed");
		#  while ($row = Sql_Fetch_Row($req)) {
		#    array_push($doneusers,$row[0]);
		#  }
		if (sizeof($doneusers))
			$exclusion = " and listuser.userid not in (" . join(",", $doneusers) . ")";
		if (USE_LIST_EXCLUDE) {
			$excluded_lists = Sql_Fetch_Row_Query(sprintf('select data from %s where name = "excludelist" and id = %d', $GLOBALS["tables"]["messagedata"], $messageid));
			if (strlen($excluded_lists[0])) {
				$req = Sql_Query(sprintf('select listuser.userid from %s as listuser where listid in (%s)', $GLOBALS["tables"]["listuser"], $excluded_lists[0]));
				while ($row = Sql_Fetch_Row($req)) {
					array_push($skipusers, $row[0]);
				}
				$query .= sprintf(' and listuser.listid not in (%s)', $excluded_lists[0]);
			}
			if (sizeof($skipusers))
				$exclusion .= " and listuser.userid not in (" . join(",", $skipusers) . ")";
		}

		$userconfirmed = ' and user.confirmed and !user.blacklisted ';

		
	
	}
	//2 - STEP 3
	private function _user_attribute(){
		return true;//TODO:
		# make selection on attribute, users who at least apply to the attributes
		# lots of ppl seem to use it as a normal mailinglist system, and do not use attributes.
		# Check this and take anyone in that case.
		$numattr = Sql_Fetch_Row_Query("select count(*) from " . $tables["attribute"]);

		if ($userselection && $numattr[0]) {
			$res = Sql_query($userselection);
			$num_users = Sql_Affected_rows($res);
			$this->_logger($num_users . ' ' . $this->_('users apply for attributes, now checking lists'));
			$user_list = "";
			while ($row = Sql_Fetch_row($res)) {
				$user_list .= $row[0] . ",";
			}
			$user_list = substr($user_list, 0, -1);
			if ($user_list)
				$user_attribute_query = " and listuser.userid in ($user_list)";
			else {
				$this->_logger($this->_('No users apply for attributes'));
				$status = Sql_query("update {$tables["message"]} set status = \"sent\",sent = now() where id = \"$messageid\"");
				finish("info", "Message $messageid: \nNo users apply for attributes, ie nothing to do");
				$script_stage = 6;
				# we should actually continue with the next message
				return;
			}
		}
		if ($script_stage < 3)
			$script_stage = 3; # we know the users by attribute
	}
	

	
	
	
	//STEP 4
	
	

	//STEP 1



	
	private function _check_localconf(){
		return true;
		if ($fp = @ fopen("/etc/phplist.conf", "r")) {
			$contents = fread($fp, filesize("/etc/phplist.conf"));
			fclose($fp);
			$lines = explode("\n", $contents);
			$ISPrestrictions = $GLOBALS['I18N']->get('The following restrictions have been set by your ISP:') . "\n";
			foreach ($lines as $line) {
				list ($key, $val) = explode("=", $line);

				switch ($key) {
					case "maxbatch" :
						$maxbatch = sprintf('%d', $val);
						$ISPrestrictions .= "$key = $val\n";
						break;
					case "minbatchperiod" :
						$minbatchperiod = sprintf('%d', $val);
						$ISPrestrictions .= "$key = $val\n";
						break;
					case "lockfile" :
						$ISPlockfile = $val;
				}
			}
		}
	}
	//STEP END


	private function check_commandline(){
		if (!$GLOBALS["commandline"]) {
		  #@ob_end_flush();
		  if (!MANUALLY_PROCESS_QUEUE) {
		    print "This page can only be called from the commandline";
		    return;
		  }
		} else {
		  @ob_end_clean();
		  print ClineSignature();
		  ob_start();
		}
	}
}