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
 * 
 * $Id: menu.php 387 2008-01-11 17:48:38Z maxbnet $
 * $LastChangedDate: 2008-01-11 17:48:38 +0000 (Fri, 11 Jan 2008) $
 * $LastChangedRevision: 387 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/inc/menu.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-11 17:48:38 +0000 (Fri, 11 Jan 2008) $
 */

class MaxlistMenu{
	
	private $_menu_items = array();
	private $_menu_subitems = array();
	private $_html_items = array();
	public function __construct() {
		
		global $APP;
		$APP->MENU = $this;
		
		$this->_set_menu_items();
		$this->_set_menu_subitems();
			
	}
	public function get_html_items() {
  		
  		global $APP;
		$controller = $APP->ROUTING->controller;
  		
  		$spb ='<li>';
  		$spactive ='<li class="active">';
  		$spnactive ='<li class="no_active">';
  		$spl ='<li class="last">';
  		$spla = '<li class="lastlink">';
  		$spe = '</li>';
  		$nm = strtolower(NAME);
  
  		foreach ($this->_menu_items as $page => $desc) {
		    //echo "Page: $page <br>Request:  $_REQUEST[page] <hr>";
			$link = $APP->LINK->make_link($page,$desc,false);
			$link_active = $APP->LINK->make_link($page,$desc,false,true);
			
			$active = false;
		    
		    if ($link && strlen($desc)>0) {
		    	//login logout 
		    	if(!$APP->ROLE->is_guest() && $page == "logout" || $APP->ROLE->is_guest() && $page == "login"){
		    		//salta
		    	}else{
		    		$is_detail = $this->_have_submenu($page,$controller);
						
					//echo "<hr>IsDetail(se uguale 1 viene rosso) ($page - $_REQUEST[page]): ".print_r($is_detail,true)."<hr>";		
		    		if($APP->ROLE->check_role_view($page)){
						//if(isset($_REQUEST['page']) && ($_REQUEST['page']==$page || inMenu($page,$_REQUEST['page']) || $is_detail)){    			
							if($controller == $page){
								//$link = '<span>' . $APP->I18N->_($desc) . '</span>';
								$link = $link_active;
								$active = true;
								
							}else{
								$link = $link_active;
								$spl = '<li class="lastmenu">';
								
							}
							if($is_detail){
								$spactive = $spl;
							}
							$sottomenu = $this->_get_submenu($page);
							
							if(is_numeric(strpos($sottomenu,'id="submenu_on"')))
								$active = true;
								
							if($sottomenu){
		    					if($active)
									$this->_html_items[] = $spla . $link . $sottomenu .$spe;
								else
									$this->_html_items[] = $spl . $link . $sottomenu .$spe;
							}else{
								if($active)
									$this->_html_items[] = $spactive . $link . $spe;
								else
									$this->_html_items[] = $spnactive . $link . $spe;
							}
						//}else{
						//	$this->_html_items[] = $spb . $link .$spe;
						//}	
		    		}
		        	
		    	}
		    }
		  }//die;
		  //print_r($this->_html_items);die;
		  return $this->_html_items;
	}
	//INIT PRIVATE
	private function _set_menu_items(){
		
		//TODO : config this? db o files?
		
		global $APP;
		$this->_menu_items['home'] = $APP->I18N->_('Home');
		$this->_menu_items['about'] = $APP->I18N->_('About');
		$this->_menu_items['eventlog'] = $APP->I18N->_('Eventlog');
		$this->_menu_items['configure'] = $APP->I18N->_('Configure');
		$this->_menu_items['list'] = $APP->I18N->_('Lists');
		$this->_menu_items['user'] = $APP->I18N->_('Users');
		//TODO: $this->_menu_items['admin'] = $APP->I18N->_('Admin');
		$this->_menu_items['message'] = $APP->I18N->_('Messages');
		$this->_menu_items['statistic'] = $APP->I18N->_('Statistics');
		$this->_menu_items['subscribe'] = $APP->I18N->_('subscribe');
		
		if(!$APP->SESSION->get_session_auth()){
			array_merge(array('login'=>'login'),$this->_menu_items);
		}
		
	}
	
	private function _set_menu_subitems(){
		
		//TODO : config this? db o files?
		global $APP;
		
		$this->_menu_subitems['user']['child']['attribute'] = $APP->I18N->_('Attributes');
		//TODO: $this->_menu_subitems['user']['child']['export/user'] = $APP->I18N->_('Export');
		//TODO: $this->_menu_subitems['user']['child']['import/user'] = $APP->I18N->_('Import');

		//TODO: $this->_menu_subitems['admin']['child']['adminattribute'] = $APP->I18N->_('Admin attributes');
		//TODO: $this->_menu_subitems['admin']['child']['group'] = $APP->I18N->_('Groups');
		
		$this->_menu_subitems['message']['child']['message/create'] = $APP->I18N->_('Send a message');
		$this->_menu_subitems['message']['child']['process/queue'] = $APP->I18N->_('Process Queue');
		$this->_menu_subitems['message']['child']['template'] = $APP->I18N->_('Templates');
		
		$this->_menu_subitems['statistic']['child']['bounce'] = $APP->I18N->_('View Bounces');
		$this->_menu_subitems['statistic']['child']['process/bounces'] = $APP->I18N->_('Process Bounces');
		
		//TODO: test. remove 
		$this->_menu_subitems['subscribe']['child']['archive'] = $APP->I18N->_('archive');

	}
	
	private function _get_submenu($item){
	  	
	  	global $APP;
	  	$controller = $APP->ROUTING->route ? $APP->ROUTING->route : $APP->ROUTING->controller;
  		
  		$spb ='<li>';
		$spactive ='<li id="submenu_on">';
	  	$spl ='<li class="last">'."\n";
		$spe = '</li>'."\n";
		
		$lista = "";
		//print_r($this->_menu_subitems[$view]);die;
		if(isset($this->_menu_subitems[$item])){
			$lista .= "\n".'<ul class="submenu">'."\n";
		
			foreach ($this->_menu_subitems[$item]['child'] as $page => $desc) {
				$link = $APP->LINK->make_link($page,$APP->I18N->_($desc));
				    if ($link && strlen($desc)>0) {
				    	//login logout 
				    	if(!$APP->ROLE->is_guest() && $page == "logout" || $APP->ROLE->is_guest() && $page == "login"){
				    		//salta
				    	}else{
				    		if($APP->ROLE->check_role_view($page)){
				    			if($controller == $page){    			
									if($page == "send"){ //TODO: 
										$lista .= $spb . $link .$spe;
									}else{
										$lista .= $spactive . $link .$spe;
									}
								}else{
									$lista .= $spb . $link .$spe;
								}	
				    		}
				        	
				    	}
				    }		
			}
			
			$lista .= "</ul>\n";
		}
		//print_r($lista);die;
		
		if(strlen($lista)>0){
			return $lista;
		}else{
			return false;
		}
	}
	private function _have_submenu($page,$request){

		if(isset($this->_menu_subitems[$page])){
			
			if(is_array($this->_menu_subitems[$page])){
				$flag = in_array($request,$this->_menu_subitems[$page]);
				$flag_criteria = true;##$this->check_criteria($flag,$page,$request);
				$flag_final = ($flag && $flag_criteria);
				return $flag_final;
			}else{
				$flag= ($request == $this->_menu_subitems[$page]);
				$flag_criteria = true;##checkCriteria($flag,$page,$request);
				$flag_final = ($flag && $flag_criteria);
				return $flag_final;
	    	}
		}else{
			return false;
		}

	}
	
}