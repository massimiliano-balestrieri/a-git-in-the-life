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
 * $Id: todo_user_dao.php 364 2008-01-04 14:00:24Z maxbnet $
 * $LastChangedDate: 2008-01-04 14:00:24 +0000 (Fri, 04 Jan 2008) $
 * $LastChangedRevision: 364 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/dao/old/todo_user_dao.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-04 14:00:24 +0000 (Fri, 04 Jan 2008) $
 */


class UserDao extends ModuleDao{
	

	private function _prepare_sql_attributes(){
		//TODO
		/**
		 $findatt = $this->db->sql_fetch_array_query("select id,tablename,type,name from {$this->db->get_table("attribute")} where id = $findby");
		  switch ($findatt["type"]) {
		    case "textline":
		    case "hidden":
		      $findtables = ','.$this->db->get_table("user_attribute");
		      $findbyselect = sprintf(' %s.userid = %s.id and
		        %s.attributeid = %d and %s.value like "%%%s%%"',
		        $this->db->get_table("user_attribute"),
		        $this->db->get_table("user"),
		        $this->db->get_table("user_attribute"),
		        $findby,
		        $this->db->get_table("user_attribute"),
		        $find
		      );
		      $findfield = $this->db->get_table("user_attribute").".value as display, ".$this->db->get_table("user").".bouncecount";
		      $findfieldname = $findatt["name"];
		      break;
		    case "select":
		    case "radio":
		      $findtables = ','.$this->db->get_table("user_attribute").','.TABLE_PREFIX .'listattr_'.$findatt["tablename"];
		      $findbyselect = sprintf(' %s.userid = %s.id and
		        %s.attributeid = %d and %s.value = %s.id and
		        %s.name like "%%%s%%"',
		        $this->db->get_table("user_attribute"),
		        $this->db->get_table("user"),
		        $this->db->get_table("user_attribute"),
		        $findby,
		        $this->db->get_table("user_attribute"),
		        TABLE_PREFIX .'listattr_'.$findatt["tablename"],
		        TABLE_PREFIX .'listattr_'.$findatt["tablename"],
		        $find);
		      $findfield = TABLE_PREFIX .'listattr_'.$findatt["tablename"].".name as display, ".$this->db->get_table("user").".bouncecount";
		      $findfieldname = $findatt["name"];
		      break;
		  }
		 */
	}

	
		//TEMP
	private function old(){
		//dopo aver aggiornato il record - passo a questi STEP	
		//TODO: usegroups
		/***
		  //print_r($_POST);die();
		  
		
		  //TODO : usegroups
		  if ($usegroups) {
		    $this->db->sql_query("delete from user_group where userid = $id");
		    if (is_array($_POST["groups"])) {
		      foreach ($_POST["groups"] as $group) {
		        $this->db->sql_query(sprintf('insert into user_group (userid,groupid) values(%d,%d)',$id,$group));
		      }
		    }
		  }
		  */
		 
		  
	}
	private function _temp_do_subscribe(){
		//TODO:
		/**** 
		  ###da fare
		  #$blacklisted = isBlackListed($email);
		  #$sendrequest = 0;
		  # personalise the thank you page
		  #if ($subscribepagedata["thankyoupage"]) {
		  #   $thankyoupage = $subscribepagedata["thankyoupage"];
		  #} else {
		  #  $thankyoupage = '<h3>'.$strThanks.'</h3>'. $strEmailConfirmation;
		  #}
		  #if (eregi("\[email\]",$thankyoupage,$regs))
		  #  $thankyoupage = eregi_replace("\[email\]",$email,$thankyoupage);
		  #$user_att = getUserAttributeValues($email);
		  #while (list($att_name,$att_value) = each ($user_att)) {
		  #  if (eregi("\[".$att_name."\]",$thankyoupage,$regs))
		  #    $thankyoupage = eregi_replace("\[".$att_name."\]",$att_value,$thankyoupage);
		  #}
		  #if ($blacklisted) {
		  #  $thankyoupage .= '<p>'.$GLOBALS['I18N']->get('YouAreBlacklisted').'</p>';
		  #}
		  #  if ($sendrequest && $listsok) { #is_array($_POST["list"])) {
		  #  if (sendMail($email, getConfig("subscribesubject:$id"), $subscribemessage,system_messageheaders($email),$envelope,1)) {
		  #    sendAdminCopy("Lists subscription","\n".$email . " has subscribed\n\n$history_entry");
		  #    addUserHistory($email,$history_subject,$history_entry);
		  #    print $thankyoupage;
		  #   } else {
		  #    print '<h3>'.$strEmailFailed.'</h3>';
		  #    if ($blacklisted) {
		  #      print '<p>'.$GLOBALS['I18N']->get('YouAreBlacklisted').'</p>';
		  #    }
		  #  }
		  #} else {
		  #  print $thankyoupage;
		  #}
		*/
		
	}
	
}
