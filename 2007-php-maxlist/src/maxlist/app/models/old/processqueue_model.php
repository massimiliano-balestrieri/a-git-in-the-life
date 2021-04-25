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
 * $Id: processqueue_model.php 352 2007-12-20 19:11:32Z maxbnet $
 * $LastChangedDate: 2007-12-20 19:11:32 +0000 (Thu, 20 Dec 2007) $
 * $LastChangedRevision: 352 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/old/processqueue_model.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-20 19:11:32 +0000 (Thu, 20 Dec 2007) $
 */

define('INTERACTIVE',1);

class ProcessqueueModel extends ModuleModel {
	
	private $_arrlog = array ();
	//join
	
	private $_helper_statistic = false;
	
	//settings
	
	//batch
	
	
	
	
	
	//lock
	private $_send_process_id = false;
	//data


	
	
	
	
	
	public function __construct($params = false) {
		$this->_name = 'processqueue';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
		
		
		
		
		$this->_helper_statistic = $APP->get_helper('statistic');
		
		
	
	}
	//debug
	

	
	
	
	//STEP 9 : end (call by STEP 4)

	//STEP 8 : set status send




	//help STEP 3

	


	
	private function _send_message_stats($msgid) {
	  return true;
	 //TODO	
	  global $tables;
		  if (defined("NOSTATSCOLLECTION") && NOSTATSCOLLECTION) {
		    return;
		   }
		  $stats_email = $GLOBALS["stats_email"];
		  
		  $data = Sql_Fetch_Array_Query(sprintf('select * from %s where id = %d',
		$tables["message"],$msgid));
		  $msg = "CSIlist version ".VERSION . "\n";
		  $diff = timeDiff($data["sendstart"],$data["sent"]);
		
		  if ($data["id"] && $data["processed"] > 10 && $diff != "very little time") {
		$msg .= "\n".'Time taken: '.$diff;
		foreach (array('entered','processed',
		  'sendstart','sent','htmlformatted','sendformat','template','astext',
		  'ashtml','astextandhtml','aspdf','astextandpdf') as $item) {
		    $msg .= "\n".$item.' => '.$data[$item];
		}
		if ($data["processed"] > 500) {
		  mail("info@maxlist.net",NAME ." stats",$msg);
		} else {
		  mail($stats_email,NAME ." stats",$msg);
		    }
		  }
	}
	private function _repeat_message(){
	 return true;
	 //TODO	
	 #  if (!USE_REPETITION && !USE_RSS) return;
	
	  # get the future embargo, either "repeat" minutes after the old embargo
	  # or "repeat" after this very moment to make sure that we're not sending the
	  # message every time running the queue when there's no embargo set.
	  $msgdata = Sql_Fetch_Array_Query(
	    sprintf('select *,date_add(embargo,interval repeatinterval minute) as newembargo,
	      date_add(now(),interval repeatinterval minute) as newembargo2, date_add(embargo,interval repeatinterval minute) > now() as isfuture
	      from %s where id = %d and repeatuntil > now()',$GLOBALS["tables"]["message"],$msgid));
	  if (!$msgdata["id"] || !$msgdata["repeatinterval"]) return;
	
	  # copy the new message
	  Sql_Query(sprintf('
	    insert into %s (entered) values(now())',$GLOBALS["tables"]["message"]));
	  $id = Sql_Insert_id();
	  require DIRCONF.'/structure.php';
	  if (!is_array($DBstruct["message"])) {
	    logEvent("Error including structure when trying to duplicate message $msgid");
	    return;
	  }
	  foreach ($DBstruct["message"] as $column => $rec) {
	    if ($column != "id" && $column != "entered" && $column != "sendstart") {
	      Sql_Query(sprintf('update %s set %s = "%s" where id = %d',
	        $GLOBALS["tables"]["message"],$column,addslashes($msgdata[$column]),$id));
	     }
	  }
	  $req = Sql_Query(sprintf('select * from %s where id = %d',
	    $GLOBALS['tables']['messagedata'],$msgid));
	  while ($row = Sql_Fetch_Array($req)) {
	    Sql_Query(sprintf('insert into %s (name,id,data) values("%s",%d,"%s")',
	      $GLOBALS['tables']['messagedata'],$row['name'],$id,addslashes($row['data'])));
	  }
	
	  # check whether the new embargo is not on an exclusion
	  if (is_array($GLOBALS["repeat_exclude"])) {
	    $repeatinterval = $msgdata["repeatinterval"];
	    $loopcnt = 0;
	    while (excludedDateForRepetition($msgdata["newembargo"])) {
	      $repeat += $msgdata["repeatinterval"];
	      $loopcnt++;
	      $msgdata = Sql_Fetch_Array_Query(
	          sprintf('select *,date_add(embargo,interval %d minute) as newembargo,
	            date_add(now(),interval %d minute) as newembargo2, date_add(embargo,interval %d minute) > now() as isfuture
	            from %s where id = %d and repeatuntil > now()',$repeatinterval,$repeatinterval,$repeatinterval,
	            $GLOBALS["tables"]["message"],$msgid));
	      if ($loopcnt > 15) {
	        logEvent("Unable to find new embargo date too many exclusions? for message $msgid");
	        return;
	      }
	    }
	  }
	  # correct some values
	  if (!$msgdata["isfuture"]) {
	    $msgdata["newembargo"] = $msgdata["newembargo2"];
	  }
	
	  Sql_Query(sprintf('update %s set embargo = "%s",status = "submitted",sent = "" where id = %d',
	      $GLOBALS["tables"]["message"],$msgdata["newembargo"],$id));
	  foreach (array("processed","astext","ashtml","astextandhtml","aspdf","astextandpdf","viewed", "bouncecount") as $item) {
	    Sql_Query(sprintf('update %s set %s = 0 where id = %d',
	        $GLOBALS["tables"]["message"],$item,$id));
	  }
	
	  # lists
	  $req = Sql_Query(sprintf('select listid from %s where messageid = %d',$GLOBALS["tables"]["listmessage"],$msgid));
	  while ($row = Sql_Fetch_Row($req)) {
	    Sql_Query(sprintf('insert into %s (messageid,listid,entered) values(%d,%d,now())',
	      $GLOBALS["tables"]["listmessage"],$id,$row[0]));
	  }
	
	  # attachments
	  $req = Sql_Query(sprintf('select * from %s,%s where %s.messageid = %d and %s.attachmentid = %s.id',
	    $GLOBALS["tables"]["message_attachment"],$GLOBALS["tables"]["attachment"],
	    $GLOBALS["tables"]["message_attachment"],$msgid,$GLOBALS["tables"]["message_attachment"],
	    $GLOBALS["tables"]["attachment"]));
	  while ($row = Sql_Fetch_Array($req)) {
	    if (is_file($row["remotefile"])) {
	      # if the "remote file" is actually local, we want to refresh the attachment, so we set
	      # filename to nothing
	      $row["filename"] = "";
	    }
	
	    Sql_Query(sprintf('insert into %s (filename,remotefile,mimetype,description,size)
	      values("%s","%s","%s","%s",%d)',
	      $GLOBALS["tables"]["attachment"],addslashes($row["filename"]),addslashes($row["remotefile"]),
	      addslashes($row["mimetype"]),addslashes($row["description"]),$row["size"]));
	    $attid = Sql_Insert_id();
	    Sql_Query(sprintf('insert into %s (messageid,attachmentid) values(%d,%d)',
	      $GLOBALS["tables"]["message_attachment"],$id,$attid));
	  }
	  logEvent("Message $msgid was successfully rescheduled as message $id");
	
	}

	


}
