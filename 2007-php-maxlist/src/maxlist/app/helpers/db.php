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
 * $Id: db.php 394 2008-01-18 18:12:54Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:12:54 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 394 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/helpers/db.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:12:54 +0000 (Fri, 18 Jan 2008) $
 */

class MaxDbHelper {
	
	public $DB = false;
	private $_page = 10;
	private $_count = false;
	public static $n = 0;
	//private $_page = 10;

	public function __construct() {
		if (!function_exists("mysql_connect")) {
		  print "Fatal Error: Mysql is not supported in your PHP, recompile and try again.";
		  exit;
		}
		
		$this->_page = LIMIT_PAGE;
		
		if(!$this->DB){
			require_once(DIR_ZEND . 'Zend/Db.php');
			//TODO:define('ADODB_ERROR_LOG_TYPE', 3);
			//TODO:define('ADODB_ERROR_LOG_DEST', REPOSITORY_ROOT . '/log/adodb_errors.log');
			try {
			   	$this->DB = Zend_Db::factory('Pdo_Mysql', array(
				    'host'     => DB_HOST,
				    'username' => DB_USER,
				    'password' => DB_PWD,
				    'dbname'   => DB_NAME
				));
				$this->DB->getConnection();
				$this->DB->setFetchMode(Zend_Db::FETCH_BOTH);
				//TODO:$this->DB->debug = false;
				//print_r($this->DB);die;
			} catch (Zend_Db_Adapter_Exception $e) {
			    // perhaps a failed login credential, or perhaps the RDBMS is not running
			} catch (Zend_Exception $e) {
			    // perhaps factory() failed to load the specified Adapter class
			}		
			
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
	//ex sql_query
	public function query($sql){
		$start = $this->_start_timer($sql);
		$res = $this->DB->fetchAll($sql);
		$this->_end_timer($start,$sql);
		return $res;
	}
	//ex sql_fetch_array_query - sql_fetch_row_query
	public function fetch_query($sql){
		$start = $this->_start_timer($sql);
		$res = $this->DB->fetchRow($sql);
		$this->_end_timer($start,$sql);
		return $res;
	}
	public function get_select_page($select, $page){//TODO:where e
		$offset = $this->_page * --$page;
		
		//TODO: memory ?
		//print_r($select->__toString());
		//die;
				  
		//print_r($count);die;
		if(is_object($select)){
			$query = $select->limit($this->_page, $offset);
			$str = $query->__toString();
		} else {
			$str = $query = $this->_limit($select, $this->_page, $offset);
		}
			
		$start = $this->_start_timer($str);
		//echo $str;
		//print_r($query->__toString());
						   
		$this->_count = $this->DB->fetchOne($this->_get_sql_count($select));
		$ret = $this->DB->fetchAll($query);
		
		$this->_end_timer($start,$str);
		//print_r($ret);die;
		return $ret;		
	}
	//select
	private function _get_sql_count($select){
		if(is_object($select))
			$sql = $select->__toString();
		else
			$sql = $select;
			
		$sql = preg_replace('#SELECT\s.*?\sFROM#is', 'SELECT COUNT(*) FROM', $sql);
		//echo "<hr>" . $sql;
		//die;			
		return $sql;
	}
	private function _limit($sql, $page, $offset){
		//mysql
		return $sql . ' LIMIT ' . $page .' OFFSET '. $offset;
	}
	//
	public function get_page($table, $page, $where = false, $order = false){//TODO:where e
		
		$offset = $this->_page * --$page;
		$query = $this->DB->select()->from($table);
		$count = $this->DB->select()->from($table, array('count(*)'));
					  	
		if($where){				  	
			$query = $query->where($where);
			$count = $count->where($where);
		}
		
		if($order)				  	
			$query = $query->order($order);
		
		
		$query = $query->limit($this->_page, $offset);
		$start = $this->_start_timer($query->__toString());
		
		//print_r($query->__toString());
						   
		$this->_count = $this->DB->fetchOne($count);
		$ret = $this->DB->query($query)->fetchAll();
		
		$this->_end_timer($start,$query->__toString());
		//print_r($ret);die;
		return $ret;		
	}
	//ex execute : refactory 
	public function delete($table, $where) {
		try{
			return $this->DB->delete($table, $where);
		}catch(Zend_Db_Statement_Exception $e){
			die('Injection');	
		}
	}
	//ex execute
	public function execute($sql) {
		try{
			$res = $this->DB->query($sql);
			$aff = $res->rowCount();
			return $aff;
		}catch(Zend_Db_Statement_Exception $e){
			die('Injection');	
		}
	}
	//ex insert
	public function insert($sql) {
		try{
			$aff = $this->DB->query($sql);
			return $this->DB->lastInsertId();
		}catch(Zend_Db_Statement_Exception $e){
			die('Injection');	
		}
	}
	public function select(){
		return $this->DB->select();
	}
	public function count(){
		return $this->_count;
	}
	private function _start_timer($query){
		global $APP;
		if (DEV_EMAIL) {
			MaxDbHelper::$n++;
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