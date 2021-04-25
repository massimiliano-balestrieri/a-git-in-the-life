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
 * $Id: sendmail_model.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/sendmail_model.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */


class SendmailModel extends ModuleModel{
	
	private $_helper = false;
	private $_temphelper = false;//TEMP
	private $_cache = false;
	
	private $_messageid = false;
	private $_userid = false;
	private $_htmlpref = false;
	
	private $_message = false;
	private $_template = false;
	
	
	private $_join_template = false;
	private $_join_list = false;
	private $_join_user = false;
	
	public function __construct($params = false){
		
		$this->_name = 'sendmail';
		$this->_dao = $this->_get_dao(dirname(__FILE__), $params);
		
		global $APP;
		$this->_temphelper = $APP->get_helper('sendtemp');
		$this->_cache = $APP->get_helper('sendcache');
		
		//NB: core helper need hash
		
		$this->_join_template = $APP->get_model2('template');
		$this->_join_listuser = $APP->get_model2('members');
		$this->_join_user = $APP->get_model2('user');
		
	}
	//help message_model->sent_test
	public function set($hash, $msg){
		global $APP;
		
		$this->_messageid = $msg['id'];
		$this->_userid = $this->_join_user->get_id_by_uniqid($hash);
		$user_data = $this->_join_user->get($this->_userid);
		$this->_htmlpref = $user_data['htmlemail'];
		//core helper
		$this->_helper = $APP->get_helper('sendmail', array('hash' => $hash, 'msgid' => $msg['id'], 'userdata' => $user_data));
		
		$this->_message = $msg;
		if ($msg['template']) {
			$this->_template = $this->_join_template->get($msg['template']);
		}
	}
	//help message_model->sent_test
	public function send_email($messageid, $email, $hash, $htmlpref = 0, $rssitems = array (), $forwardedby = array ()) {
	
		if ($email == "")
			return 0;
			
		if (empty ($this->_cache->cached[$messageid])) {
			$this->_cache->do_cache($messageid, $this->_message, $this->_template);
		}
		
		$cached = $this->_cache->cached[$messageid];
		
		if (VERBOSE)//STEP log 
			$this->_log_sendingmessage($messageid, $email);
		
		
		$this->_helper->set_urls();//STEP 1
		
		
		$this->_helper->set_content($cached['content']);//STEP 1
		
		
		$this->_temphelper->set_remote_content();//STEP 3 - todo temp to helper
		
		$this->_helper->set_text_and_html($cached['htmlformatted'], $cached['textcontent']);//STEP 4
		
		$this->_temphelper->set_html_style();//STEP 5 - todo temp to helper
		
		
				
		$this->_helper->template_replace($cached['template']);//STEP 6
		$this->_helper->message_replace();//STEP 7
		
		$this->_helper->set_footer($cached['footer']);//STEP 8
		$this->_helper->footer_replace();//STEP 9
		$this->_helper->append_footer();//STEP 10
		
		
		$this->_helper->message_track();//STEP 11
		
		$this->_temphelper->parse_listowner();//STEP 12
	
		
		$this->_helper->parse_default_config();//STEP 13
		
		$this->_temphelper->rss();//STEP 14
		
		$this->_helper->parse_user_data();//STEP 15
		
		$this->_temphelper->check_user_attr();//STEP 16
		
		$this->_helper->set_destinationemail($email);//STEP 17
		
		if($this->_helper->have_lists_placeholder()){//STEP 18
			$lists_html = $this->_join_listuser->get_html_lists($this->_userid);
			$lists_txt =  $this->_join_listuser->get_txt_lists($this->_userid);
			$this->_helper->parse_lists($lists_html, $lists_txt);//STEP 19
		}
		
		
		$this->_temphelper->clicktrack();//STEP 20
		
		$this->_helper->remove_placeholders();//STEP 21
		
		$this->_helper->parse_dom_message($cached['html_charset']);//STEP 22
		
		$this->_temphelper->use_carriage_return();//STEP 23
		
		$this->_helper->istance_mailer();//STEP 24
		
		$this->_temphelper->sendingtextonlyto();//STEP 25
		
		$this->build_message($cached['sendformat'],$cached['templateid']);//STEP 26
		
		$this->_helper->build_message_charset($cached['html_charset'],$cached['text_charset']);//STEP 27
		
		
		return $this->_helper->send($email, $cached['fromname'],$cached['fromemail'],$cached['subject']);//STEP 28
		
		#echo $this->_dbg('_cache->cached',$this->_cache->cached);
		#echo $this->_dbg('_helper',$this->_helper);//html, text, urls, content, textcontent, htmlcontent
		#die();

	}
	//STEP 26
	public function build_message($cached_sendformat, $cached_templateid){
		global $APP;
		$text = false; 
		$htmlpref = $this->_htmlpref;
		//echo $cached_sendformat;die;
		# so what do we actually send?
		
		switch ($cached_sendformat) {
			case "HTML" :
				if ($htmlpref) {
					$this->_add_rss("ashtml");
					$this->_helper->build_html_message($cached_templateid);
					$this->_dao->increase_ashtml($this->_messageid);
				}else{
					$text = true;
				}
			break;
			case "both" :
			case "text and HTML" :
				if ($htmlpref) {
					$this->_add_rss("ashtml");
					$this->_helper->build_both_message($cached_templateid);
					$this->_dao->increase_astextandhtml($this->_messageid);
				}else{
					$text = true;
				}
			break;
			case "PDF" :
				if ($htmlpref) {
					$this->_add_rss("aspdf");
					$this->_temphelper->build_pdf_message();
					$this->_dao->increase_aspdf($this->_messageid);
				}else{
					$text = true;
				}
			break;
			case "text and PDF" :
				if ($htmlpref) {
					$this->_add_rss("aspdf");
					$this->_temphelper->build_pdf_and_text_message();
					$this->_dao->increase_astextandpdf($this->_messageid);
				}else{
					$text = true;
				}
			break;
			case "text" :
				$text = true;
			default :
			break;
		}
		
		if($text)
			$this->_build_text_message();
	}
	private function _build_text_message(){
		global $APP;
		
		$this->_add_rss("astext");
		$this->_helper->build_text_message();
		$this->_dao->increase_astext($this->_messageid);
	}
	private function _add_rss($type){
		//TODO: if (ENABLE_RSS && sizeof($rssitems))
		//	updateRSSStats($rssitems, $type);
	}
	private function _log_sendingmessage($messageid, $email){
		$this->_log($this->_('sendingmessage') .' ' . 
					$messageid . ' ' . 
					$this->_('withsubject') . ' ' .
					$this->_cache->cached[$messageid]["subject"] . ' ' . 
					$this->_('to') . ' ' .
					$email);
	
	}
	private function _dbg($title,$var){
		return "<hr>$title<hr><pre>".print_r($var,true)."</pre><hr>";
	}
}
