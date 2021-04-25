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
 * $Id: db2.php 394 2008-01-18 18:12:54Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:12:54 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 394 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/helpers/old/db2.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:12:54 +0000 (Fri, 18 Jan 2008) $
 */

class MaxDb2Helper {
	
	public $CONN = false;
	public static $n = 0;
	private $_page = 10;
	private $_last_count = false;
	
	public function __construct() {
		die('ADODB');
		if (!function_exists("mysql_connect")) {
		  print "Fatal Error: Mysql is not supported in your PHP, recompile and try again.";
		  exit;
		}
		
		$this->_page = LIMIT_PAGE;
		
		if(!$this->CONN){
			require_once ( DIR_ADODBLITE . '/adodb.inc.php');
			require_once ( DIR_ADODBLITE . '/adodb-errorhandler.inc.php');
	
			define('ADODB_ERROR_LOG_TYPE', 3);
			define('ADODB_ERROR_LOG_DEST', REPOSITORY_ROOT . '/log/adodb_errors.log');
			
			$this->CONN = ADONewConnection('mysql');
			$this->CONN->debug = false;
			$this->CONN->Connect(DB_HOST, DB_USER, DB_PWD, DB_NAME);
			//print_r($database_connection);die;
		}
	}
	public function get_prefix(){
		return TABLE_PREFIX;
	}
	public function get_table($table){
		global $APP;
		if(!defined('TABLE_PREFIX') || !defined('TABLE_PREFIX_USR')){
			die("TABLE_PREFIX not defined");
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

	public function insert($query) {
		global $APP;
		$start = $this->_start_timer($query);
		
		$rs = $this->CONN->Execute($query);
		$id = $this->CONN->Insert_ID();
		
		$this->_end_timer($start,$query);
		return $id;
	}
	public function execute($query) {
		global $APP;
		$start = $this->_start_timer($query);
		
		$rs = $this->CONN->Execute($query);
		$aff = $this->CONN->Affected_Rows();
		
		$this->_end_timer($start,$query);
		return $aff;
	}
	public function sql_query_page($query,$offset) {
		
		$start = $this->_start_timer($query);
		
		$offset = $this->_page * --$offset;
		$rs = $this->CONN->Execute($query);
		$this->_last_count = $rs->RecordCount();
		$rs = $this->CONN->SelectLimit($query,$this->_page,$offset);
		$ret = $rs->GetArray();
		
		$this->_end_timer($start,$query);
		return $ret;
		
	}
	public function sql_fetch_array_query($query) {
		$start = $this->_start_timer($query);
		
		$ret = $this->CONN->Execute($query);
		$ret = $ret->GetAll();
		$this->_last_count = 1;
		
		$this->_end_timer($start,$query);
		return isset($ret[0]) ? $ret[0] : false;
	}
	public function sql_fetch_row_query($query) {
		return $this->sql_fetch_array_query($query);
	}
	public function sql_query($query) {
		$start = $this->_start_timer($query);
		
		$rs = $this->CONN->Execute($query);
		//temp 
		if(is_numeric(strpos($query,"insert"))){ echo $query;die;}
		if(is_numeric(strpos($query,"update"))){ echo $query;die;}
		if(is_numeric(strpos($query,"delete"))){ echo $query;die;}
		
		$this->_last_count = $rs->RecordCount();
		$ret = $rs->GetArray();

		$this->_end_timer($start,$query);
		return $ret;
	}
	public function count(){
		return $this->_last_count;
	}
	private function _start_timer($query){
		global $APP;
		if (DEV_EMAIL) {
			MaxDb2Helper::$n++;
			$now = gettimeofday();
			$start = $now["sec"] * 1000000 + $now["usec"];
			$APP->MSG->query($query);
		}
		return $start;
	}
	private function _end_timer($start,$query){
		global $APP;
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
	}
}