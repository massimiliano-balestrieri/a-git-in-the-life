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
 * $Id: db.php 361 2007-12-28 10:25:55Z maxbnet $
 * $LastChangedDate: 2007-12-28 10:25:55 +0000 (Fri, 28 Dec 2007) $
 * $LastChangedRevision: 361 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/helpers/old/db.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-28 10:25:55 +0000 (Fri, 28 Dec 2007) $
 */

class MaxDbHelper {
	
	public $CONN = false;
	public static $n = 0;
	
	public function __construct() {
		if (!function_exists("mysql_connect")) {
		  print "Fatal Error: Mysql is not supported in your PHP, recompile and try again.";
		  exit;
		}
		if(!$this->CONN){
			$this->CONN = mysql_connect(DB_HOST,DB_USER,DB_PWD);
			$res = mysql_select_db(DB_NAME,$this->CONN);
			//print_r($database_connection);die;
		}
	}
	public function get_table($table){
		
		global $APP;
		
		if(!defined('TABLE_PREFIX') || !defined('TABLE_PREFIX_USR')){
			$APP->MSG->fatal_error("TABLE_PREFIX not defined");
		}
		//TODO : fix this please. why?
		switch($table){
			
			case "user": 
			case "user_history":
			case "attribute":
			case "user_attribute":
				return TABLE_PREFIX_USR . $table;
			break;
			default:
				return TABLE_PREFIX . $table;
			break;
		}
		
	}
	
	public function sql_fetch_array_query($query) {
		$req = $this->sql_query($query);
		return $this->sql_fetch_array($req);
	}
	public function sql_fetch_array($dbresult) {
	  return mysql_fetch_array($dbresult);
	}
	public function sql_fetch_row($dbresult) {
	  return @mysql_fetch_row($dbresult);
	}

	public function sql_fetch_row_query($query) {
	  $req = $this->sql_query($query);
	  return $this->sql_fetch_row($req);
	}
	public function sql_affected_rows() {
	  return mysql_affected_rows($this->CONN);
	}
	function sql_insert_id() {
 	 return @mysql_insert_id();
	}
	public function sql_query($query) {

		global $CONN;global $APP;
		//print_r($CONN);die;
		
		if (DEV_EMAIL) {
			#  if (preg_match("/dev$/",VERSION))
			#  print "<b>$query</b><br>\n";
			#  if ($GLOBALS["commandline"]) {
			#    ob_end_clean();
			#    print "Sql: $query\n";
			#    ob_start();
			#  }
			# time queries to see how slow they are, so they can
			# be optimized
			$now = gettimeofday();
			$start = $now["sec"] * 1000000 + $now["usec"];
			$APP->MSG->query($query);
		}
		
		$this->n++;
		$result = mysql_query($query, $this->CONN);
		if ($error = $this->sql_check_error($this->CONN)) {
			if (DEV_EMAIL){
				$APP->MSG->query_error($query);
				$APP->MSG->error($error);
			}else{
				die("<!-- errore bloccante - db -->");//TODO:
			} 
		}
		if (DEV_EMAIL) {
			# log time queries take
			$now = gettimeofday();
			$end = $now["sec"] * 1000000 + $now["usec"];
			$elapsed = $end - $start;
			if ($elapsed > 30000) {
				$query = substr($query, 0, 200);
				$APP->MSG->query_slow($query);
				##sqllog(' [' . $elapsed . '] ' . $query, "/tmp/phplist-sqltimer.log");//TODO : sqllog function
			}
		}

		return $result;
	}
	private function sql_has_error ($dbconnection) {
	  return mysql_errno($dbconnection);
	}
	private function sql_check_error($dbconnection, $errno = 0) {
		
		global $APP;
		
		if (!$errno)
			$errno = $this->sql_has_error($dbconnection);
		if ($errno) {
			switch ($errno) {
				case 1049 : # unknown database
					$APP->MSG->fatal_error("unknown database, cannot continue");
					exit;
				case 1045 : # access denied
					$APP->MSG->fatal_error("Cannot connect to database, access denied. Please contact the administrator");
					exit;
				case 2002 :
					$APP->MSG->fatal_error("Cannot connect to database, Sql server is not running. Please contact the administrator");
					exit;
				case 1040 : # too many connections
					$APP->MSG->fatal_error("Sorry, the server is currently too busy, please try again later.");
					exit;
				case 0 :
					break;
				default :
					return $this->sql_error($dbconnection, $errno);
					exit;
			}
			return 1;
		}
	}
	function sql_error ($dbconnection,$errno = 0) {
	  $msg = mysql_error($dbconnection);
	  return $errno . " " . $msg;
	}

}