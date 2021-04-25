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
 * $Id: maxlist.php 394 2008-01-18 18:12:54Z maxbnet $
 * $LastChangedDate: 2008-01-18 18:12:54 +0000 (Fri, 18 Jan 2008) $
 * $LastChangedRevision: 394 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/maxlist.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-18 18:12:54 +0000 (Fri, 18 Jan 2008) $
 */

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

//zend
require_once (SERVER_ROOT . '/libraries/zend/include.php');

//external lib
require_once (SERVER_ROOT . '/libraries/phpmailer/class.phpmailer.php');
require_once (SERVER_ROOT . '/libraries/jscalendar-1.0/calendar.php');

//lib
require_once (dirname(__FILE__) . '/inc/auth.php');
require_once( dirname(__FILE__) . '/inc/paging.php');

//objects
require_once (dirname(__FILE__) . '/inc/istance.php');
require_once( dirname(__FILE__) . '/inc/conf.php');
require_once (dirname(__FILE__) . '/inc/routing.php');
require_once (dirname(__FILE__) . '/inc/controller.php');
require_once (dirname(__FILE__) . '/inc/menu.php');
require_once (dirname(__FILE__) . '/inc/template.php');
require_once (dirname(__FILE__) . '/inc/module.php');
require_once (dirname(__FILE__) . '/inc/output.php');
require_once (dirname(__FILE__) . '/inc/stats.php');
require_once( dirname(__FILE__) . '/inc/i18n.php');
require_once( dirname(__FILE__) . '/inc/mailer.php');

//require helpers
require_once( dirname(__FILE__) . '/helpers/db.php');
//require_once( dirname(__FILE__) . '/helpers/db2.php');
require_once( dirname(__FILE__) . '/helpers/session.php');
require_once( dirname(__FILE__) . '/helpers/request.php');
require_once( dirname(__FILE__) . '/helpers/role.php');
require_once( dirname(__FILE__) . '/helpers/msg.php');
require_once( dirname(__FILE__) . '/helpers/mailer.php');
require_once( dirname(__FILE__) . '/helpers/link.php');
require_once( dirname(__FILE__) . '/helpers/dev.php');
#require_once( dirname(__FILE__) . '/helpers/schema.php');//TODO: remove this
require_once( dirname(__FILE__) . '/helpers/timer.php');

class MaxList{
	
	//helpers
	public $DB = false;
	//public $ADODB_LITE = false;
	public $SESSION = false;
	public $REQUEST = false;
	public $ROLE = false;
	public $MSG = false;
	public $MAILER = false;
	public $I18N = false;
	public $DEV = false;
	//public $SCHEMA = false;
	
	//objects
	public $CONF = false;
	public $AUTH = false;
	public $TPL = false;
	public $MENU = false;
	public $MODULE = false;
	public $ROUTING = false;
	public $MODEL = false;
		
	//vars
	private $_view = 'home';
	
	
	public function __construct(){
		session_start();
		$this->REQUEST = new MaxRequestHelper();
		$this->SESSION = new MaxSessionHelper();
		$this->DB = new MaxDbHelper();
		//$this->ADODB_LITE = new MaxDb2Helper();
		$this->ROLE = new MaxRoleHelper();
		$this->MSG = new MaxMsgHelper();
		$this->MAILER = new MaxMailerHelper();
		$this->LINK = new MaxLinkHelper();
		$this->DEV = new MaxDevHelper();
		//$this->SCHEMA = new MaxSchemaHelper();
		$this->MODEL = false;
	}
	//INITS
	public function init_controller(){
		new MaxlistController();
	}
	public function init_routing(){
		new MaxlistRouting(URL_BASE);
	}
	public function init_istance(){
		new MaxlistIstance();
	}
	public function init_conf(){
		new MaxlistConf();
	}
	public function init_auth(){
		new MaxlistAuth();
	}
	public function init_i18n(){
		new MaxlistI18N();
	}
	public function init_menu(){
		new MaxlistMenu();
	}
	public function init_template(){
		new MaxlistTemplate();
	}
	public function init_module(){
		new MaxlistModule();
	}
	public function init_output(){
		new MaxlistOutput();
	}
	public function init_stats(){
		new MaxlistStats();
	}
	
	//VIEW
	public function _get_view(){
		return $this->_view;
	}
	public function _set_view($view){
		return $this->_view = $view;
	}
	
	//MODULES
	public function _get_model($module, $params = false){
		require_once (DIR_MODULES . '/' . $module . '/' . strtolower($module) .'_model.php');
		$model = $module . 'Model';
		return new $model($params);
	}
	public function get_model2($module, $params = false){
		require_once (APP_ROOT . '/app/models/' . strtolower($module) .'_model.php');
		$model = $module . 'Model';
		return new $model($params);
	}
	public function load_model($module){
		require_once (APP_ROOT . '/app/models/' . strtolower($module) .'_model.php');
	}
	public function get_dao($module, $params = false){
		require_once (APP_ROOT . '/app/models/dao/' . strtolower($module) .'_dao.php');
		$dao = $module . 'Dao';
		return new $dao($params);
	}
	public function get_helper($module, $params = false){
		require_once (APP_ROOT . '/app/models/helpers/' . strtolower($module) .'_helper.php');
		$helper = $module . 'Helper';
		return new $helper($params);
	}
	//FUNCTIONS GENERAL
	public function debug($var) {
   		echo "\n<pre>".print_r($var,true)."</pre><hr>\n";
	}
	public function normalize($var) {
		  $var = str_replace(" ","_",$var);
		  $var = str_replace(";","",$var);
		  return $var;
	}
	
}
