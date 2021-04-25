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
 * $Id: sendmail_helper.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/sendmail_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */

class SendmailHelper {

	private $_html = array ();
	private $_text = array ();

	private $_hash = false;
	private $_userdata = false;
	private $_mailer = false;
	
	//serve agli urls
	private $_url_base = false;
	private $_subscribe_url = false;
	private $_preferences_url = false;
	private $_unsubscribe_url = false;
	private $_forward_url = false;
	
	//content
	private $_content = false;
	
	private $_textcontent = false;
	private $_htmlcontent = false;
	
	private $_destinationemail = false;
	private $_textmessage = '';
	private $_htmlmessage = '';
	
	//parse from content
	private $_listowner = 0;
	
	//helpers of core helper
	private $_join_utils = false;
	
	public function __construct($params){
		global $APP;

		if(!$params['hash'] || !$params['msgid'] || !$params['userdata'])
			die("<!--sendmail_model->helper only for subscribed users and valid message id");
		
		//need hash
		$this->_hash = $params['hash'];
		
		//need messageid
		$this->_messageid = $params['msgid'];
			
		//need userdata
		$this->_userdata = $params['userdata'];
		
		$this->_join_utils = $APP->get_helper('sendutils');
	}
	//STEP 28
	public function send($email, $fromname_cached,$fromemail_cached,$subject_cached){
		//viene finalmente inviata la mail.
		//TODO return esito
		if (!TEST) {
			//TODO: forwared
			//if ($hash != 'forwarded' || !sizeof($forwardedby)) {
				$fromname = $fromname_cached;
				$fromemail = $fromemail_cached;
				$subject = $subject_cached;
			//} else {
			//	$fromname = '';
			//	$fromemail = $forwardedby['email'];
			//	$subject = $GLOBALS['strFwd'] . ': ' . $this->_cache->cached[$messageid]["subject"];
			//}
			if (!$this->_mailer->send("", $this->_destinationemail, $fromname, $fromemail, $subject)) {
				return array('send' => 0, 
							 'log' => "Error sending message {$this->_messageid} to $email ({$this->_destinationemail})");
			} else {
				return array('send' => 1, 
							 'log' => "Success sending message {$this->_messageid} to $email ({$this->_destinationemail})");
			}
		}
		return array('send' => 0,
					'log'=> "In TEST non viene inviata nessuna mail");
	}
	//STEP 27
	public function build_message_charset($cached_html_charset,$cached_text_charset){
		$this->_mailer->build_message(array (
			"html_charset" => $cached_html_charset,
			"html_encoding" => HTMLEMAIL_ENCODING,
			"text_charset" => $cached_text_charset,
			"text_encoding" => TEXTEMAIL_ENCODING
		));
	}
	//STEP 26 A
	public function build_html_message($cached_templateid){
		$this->_mailer->add_html($this->_htmlmessage, "", $cached_templateid);
		//addAttachments($messageid, $mail, "HTML");
	}
	//STEP 26 B
	public function build_pdf_message(){
		//impl in temphelper TODO: ROADMAP
		//addAttachments($messageid, $mail, "HTML");
	}
	//STEP 26 C
	public function build_pdf_and_text_message(){
		//impl in temphelper TODO: ROADMAP
		//addAttachments($messageid, $mail, "HTML");
	}
	//STEP 26 D
	public function build_text_message(){
		$this->_mailer->add_text($this->_textmessage);
		//addAttachments($messageid, $mail, "text");
	}
	//STEP 26 E
	public function build_both_message($cached_templateid){
		$this->_mailer->add_html($this->_htmlmessage, $this->_textmessage, $cached_templateid);
		//addAttachments($messageid, $mail, "HTML");
	}
	//STEP 25
	public function sendingtextonlyto(){
		//impl in temphelper TODO: ROADMAP
	}
	//STEP 24
	public function istance_mailer(){
		if(!PHPMAILER)
			die("Maxlist work only with phpmailer");
		$this->_mailer = new MaxlistMailer($this->_messageid, $this->_destinationemail);
	}
	//STEP 23
	public function use_carriage_return(){
		//impl in temphelper TODO: ROADMAP
	}
	//STEP 22
	public function parse_dom_message($cached_html_charset){
		# check that the HTML message as proper <head> </head> and <body> </body> tags
		# some readers fail when it doesn't
		if (!preg_match("#<body.*</body>#ims", $this->_htmlmessage)) {
			$this->_htmlmessage = '<body>' . $this->_htmlmessage . '</body>';
		}
		if (!preg_match("#<head>.*</head>#ims", $this->_htmlmessage)) {
			//TODO:if (!$adddefaultstyle) $defaultstyle = "";
			$this->_htmlmessage = '<head>
							        <meta content="text/html;charset=' . $cached_html_charset . '" http-equiv="Content-Type">
							        <title></title>' .
							         //$defaultstyle . //TODO 
									'</head>' . $this->_htmlmessage;
		}
		if (!preg_match("#<html>.*</html>#ims", $this->_htmlmessage)) {
			$this->_htmlmessage = '<html>' . $this->_htmlmessage . '</html>';
		}
	}
	//STEP 21
	public function remove_placeholders(){
		# remove any existing placeholders
		$this->_htmlmessage = eregi_replace("\[[A-Z\. ]+\]", "", $this->_htmlmessage);
		$this->_textmessage = eregi_replace("\[[A-Z\. ]+\]", "", $this->_textmessage);
	}
	//STEP 20
	public function clicktrack(){
		if(CLICKTRACK){
			//impl in helper_rss TODO: ROADMAP
			global $APP;
			$helper = $APP->get_helper('sendclicktrack');
		}
	}
	//STEP 19
	public function parse_lists($lists_html, $lists_text){
		if (eregi("\[LISTS\]", $this->_htmlmessage)) {
			$this->_htmlmessage = ereg_replace("\[LISTS\]", $lists_html, $this->_htmlmessage);
			$this->_textmessage = ereg_replace("\[LISTS\]", $lists_text, $this->_textmessage);
		}
	}
	//STEP 18
	public function have_lists_placeholder(){
		return (eregi("\[LISTS\]", $this->_htmlmessage));
	}
	//STEP 17
	public function set_destinationemail($email){
		if (!$this->_destinationemail) {
			$this->_destinationemail = $email;
		}
		//TODO: ?
		/*
		if (!ereg('@', $destinationemail) && isset ($GLOBALS["expand_unqualifiedemail"])) {
			$destinationemail .= $GLOBALS["expand_unqualifiedemail"];
		}
		*/
	}
	//STEP 16
	public function check_user_attr(){
		//impl in temphelper TODO: ROADMAP
	}
	//STEP 15
	public function parse_user_data(){
		//TODO USERDATA
		if (is_array($this->_userdata)) {
			foreach ($this->_userdata as $name => $value) {
				if (eregi("\[" . $name . "\]", $this->_htmlmessage, $regs)) {
					$this->_htmlmessage = eregi_replace("\[" . $name . "\]", $value, $this->_htmlmessage);
				}
				if (eregi("\[" . $name . "\]", $this->_textmessage, $regs)) {
					$this->_textmessage = eregi_replace("\[" . $name . "\]", $value, $this->_textmessage);
				}
			}
		}
	}
	//STEP 14
	public function rss(){
		if(ENABLE_RSS){
			//impl in helper_rss TODO: ROADMAP
			global $APP;
			$helper = $APP->get_helper('sendrss');
		}
	}
	//STEP 13
	public function parse_default_config(){
		global $APP;
		
		if (is_array($APP->CONF->defaults)) {
			foreach ($APP->CONF->defaults as $key => $val) {
				if (is_array($val)) {
					$this->_htmlmessage = eregi_replace("\[$key\]", $APP->CONF->get($key), $this->_htmlmessage);
					$this->_textmessage = eregi_replace("\[$key\]", $APP->CONF->get($key), $this->_textmessage);
				}
			}
		}
	}
	//STEP 12
	public function parse_listowner(){
		//impl in temphelper TODO: ROADMAP
	}
	//STEP 11
	public function message_track(){
		global $APP;
		//TODO ? 
		#  $req = Sql_Query(sprintf('select filename,data from %s where template = %d',
		#    $GLOBALS["tables"]["templateimage"],$cached[$messageid]["templateid"]));
		//MESSAGE TRACK : TODO
		$image = '<img src="' . URL_BASE . $APP->ROUTING->istance . '/tracking/?msgid=' . $this->_messageid . '&amp;uniqid=' . $this->_hash .'" style="display:none" height="0" width="0" border="0" />';
		$this->_htmlmessage = eregi_replace("\[USERID\]", $this->_hash, $this->_htmlmessage);
		$this->_htmlmessage = preg_replace("/\[USERTRACK\]/i", $image, $this->_htmlmessage, 1);
		$this->_htmlmessage = eregi_replace("\[USERTRACK\]", '', $this->_htmlmessage);
	}
	//STEP 10
	public function append_footer(){
		//MESSAGE
		if (eregi("\[FOOTER\]", $this->_htmlmessage)){
			$this->_htmlmessage = eregi_replace("\[FOOTER\]", $this->_html["footer"], $this->_htmlmessage);
		}elseif ($this->_html["footer"]){
			$this->_htmlmessage = $this->_join_utils->add_html_footer($this->_htmlmessage, '<br /><br />' . $this->_html["footer"]);
		}
		
		if (eregi("\[FOOTER\]", $this->_textmessage)){
			$this->_textmessage = eregi_replace("\[FOOTER\]", $this->_text["footer"], $this->_textmessage);
		}else{
			$this->_textmessage .= "\n\n" . $this->_text["footer"];
		}
	}
	//STEP 9
	public function footer_replace(){
		//MESSAGE FOOTER replace
		$this->_text["footer"] = eregi_replace("\[UNSUBSCRIBE\]", $this->_text["unsubscribe"], $this->_text['footer']);
		$this->_html["footer"] = eregi_replace("\[UNSUBSCRIBE\]", $this->_html["unsubscribe"], $this->_html['footer']);
		$this->_text["footer"] = eregi_replace("\[SUBSCRIBE\]", $this->_text["subscribe"], $this->_text['footer']);
		$this->_html["footer"] = eregi_replace("\[SUBSCRIBE\]", $this->_html["subscribe"], $this->_html['footer']);
		$this->_text["footer"] = eregi_replace("\[PREFERENCES\]", $this->_text["preferences"], $this->_text["footer"]);
		$this->_html["footer"] = eregi_replace("\[PREFERENCES\]", $this->_html["preferences"], $this->_html["footer"]);
		//TODO: forward
		/*
		$text["footer"] = eregi_replace("\[FORWARD\]", $text["forward"], $text["footer"]);
		$html["footer"] = eregi_replace("\[FORWARD\]", $html["forward"], $html["footer"]);
		$html["footer"] = eregi_replace("\[FORWARDFORM\]", $html["forwardform"], $html["footer"]);
		if (sizeof($forwardedby) && isset ($forwardedby['email'])) {
			$html["footer"] = eregi_replace("\[FORWARDEDBY]", $forwardedby["email"], $html["footer"]);
			$text["footer"] = eregi_replace("\[FORWARDEDBY]", $forwardedby["email"], $text["footer"]);
		}
		*/
		
		$this->_html["footer"] = '<div class="emailfooter">' . nl2br($this->_html["footer"]) . '</div>';
	
		
			
	}
	//STEP 8
	public function set_footer($cached_footer){
		//MESSAGE FOOTER
		if ($this->_hash != 'forwarded') {
			$this->_text['footer'] = $cached_footer;
			$this->_html['footer'] = $cached_footer;
		} else {
			//TODO : forwardfooter
			//$text['footer'] = $APP->CONF->get('forwardfooter');
			//$html['footer'] = $text['footer'];
		}
	}
	//STEP 7
	public function message_replace(){
		
		//MESSAGE replace : only one time?
		foreach (array ("forwardform","forward","subscribe","preferences","unsubscribe","signature") as $item) {
			if (eregi('\[' . $item . '\]', $this->_htmlmessage, $regs)) {
				$this->_htmlmessage = eregi_replace('\[' . $item . '\]', $this->_html[$item], $this->_htmlmessage);
				//TODO :unset ($this->_html[$item]);
			}
			if (eregi('\[' . $item . '\]', $this->_textmessage, $regs)) {
				$this->_textmessage = eregi_replace('\[' . $item . '\]', $this->_text[$item], $this->_textmessage);
				//TODO :unset ($this->_text[$item]);
			}
		}
		//MESSAGE replace
		foreach (array ("forwardurl","subscribeurl","preferencesurl","unsubscribeurl") as $item) {
			if (eregi('\[' . $item . '\]', $this->_htmlmessage, $regs)) {
				$this->_htmlmessage = eregi_replace('\[' . $item . '\]', $this->_html[$item], $this->_htmlmessage);
			}
			if (eregi('\[' . $item . '\]', $this->_textmessage, $regs)) {
				$this->_textmessage = eregi_replace('\[' . $item . '\]', $this->_text[$item], $this->_textmessage);
			}
		}
		//print_r($this->_htmlmessage);die;
	}
	//STEP 6
	public function template_replace($cached_template){
		//template init message and set content in message
		//TEMPLATE replace
		if ($cached_template)
			# template used
			$this->_htmlmessage = eregi_replace("\[CONTENT\]", $this->_htmlcontent, $cached_template);
		else {
			# no template used
			$this->_htmlmessage = $this->_htmlcontent;
			//TODO: $adddefaultstyle = 1;
		}
		$this->_textmessage = $this->_textcontent;//NO use template
	}
	//STEP 5
	public function set_html_style(){
		//impl in temphelper TODO: ROADMAP
	}
	//STEP 4
	public function set_text_and_html($cached_htmlformatted, $cached_textcontent){
		//MESSAGE
		
		if ($cached_htmlformatted) {
			if (!$cached_textcontent) {
				$this->_textcontent = $this->_join_utils->strip_html($this->_content);
			} else {
				$this->_textcontent = $cached_textcontent;
			}
			$this->_htmlcontent = $this->_content;
		} else {
			#    $textcontent = $content;
			if (!$cached_textcontent) {
				$this->_textcontent = $this->_content;
			} else {
				$this->_textcontent = $cached_textcontent;
			}
			$this->_htmlcontent = $this->_join_utils->parse_text($this->_content);
		}
	}
	//STEP 3
	public function set_remote_content(){
		//impl in temphelper TODO: ROADMAP
	}
	//STEP 2
	public function set_content($content){
		$this->_content = $content;
		$this->_set_listowner();//TODO:
	}
	
	//STEP 1
	public function set_urls() {
		
		global $APP;
		$this->_url_base = URL_BASE . $APP->ROUTING->istance . '/';
		$this->_subscribe_url = $this->_url_base . $APP->CONF->get("subscribeurl");
		$this->_unsubscribe_url = $this->_url_base . $APP->CONF->get("unsubscribeurl") . $this->_hash;
		$this->_preferences_url = $this->_url_base . $APP->CONF->get("preferencesurl") . $this->_hash;
		//TODO: $this->_forward_url = $this->_url_base . $APP->CONF->get("forwardurl") . $this->_hash;
		
		$this->_set_subscribe();
		$this->_set_unsubscribe();
		$this->_set_preferences();
		//TODO: $this->_set_forward();
	}
	//help step 2
	private function _set_listowner(){
		//TODO: listowner?
		if (preg_match("/##LISTOWNER=(.*)/", $this->_content, $regs)) {
			$this->_listowner = $regs[1];
			$this->_content = ereg_replace($regs[0], "", $this->_content);
		} 
	}	
	//help step 1
	private function _set_preferences(){
		global $APP;
		$this->_html["preferences"] = sprintf('<a href="%s">%s</a>', $this->_preferences_url, $APP->I18N->_('str_this_link'));
		$this->_text["preferences"] = sprintf('%s', $this->_preferences_url);
		$this->_html["preferencesurl"] = sprintf('%s', $this->_preferences_url);
		$this->_text["preferencesurl"] = sprintf('%s', $this->_preferences_url);
	}
	//help step 1
	private function _set_subscribe(){
		global $APP;
		$this->_html["subscribe"] = sprintf('<a href="%s">%s</a>', $this->_subscribe_url, $APP->I18N->_('str_this_link'));
		$this->_text["subscribe"] = sprintf('%s', $this->_subscribe_url);
		$this->_html["subscribeurl"] = sprintf('%s', $this->_subscribe_url);
		$this->_text["subscribeurl"] = sprintf('%s', $this->_subscribe_url);		
	}
	//help step 1
	private function _set_unsubscribe(){
		global $APP;
		$this->_html["unsubscribe"] = sprintf('<a href="%s">%s</a>', $this->_unsubscribe_url, $APP->I18N->_('str_this_link'));
		$this->_text["unsubscribe"] = sprintf('%s', $this->_unsubscribe_url);
		$this->_html["unsubscribeurl"] = sprintf('%s', $this->_unsubscribe_url);
		$this->_text["unsubscribeurl"] = sprintf('%s', $this->_unsubscribe_url);
	}
	//help step 1
	private function _set_forward(){
		//TODO FORWARD e SIGNATURE
		/*
		$html["forward"] = sprintf('<a href="%s%suid=%s&mid=%d">%s</a>', $url, $sep, $hash, $messageid, $strThisLink);
		$text["forward"] = sprintf('%s%suid=%s&mid=%d', $url, $sep, $hash, $messageid);
		$html["forwardurl"] = sprintf('%s%suid=%s&mid=%d', $url, $sep, $hash, $messageid);
		$text["forwardurl"] = $text["forward"];
		$url = $APP->CONF->get("public_baseurl");
		# make sure there are no newlines, otherwise they get turned into <br/>s
		$html["forwardform"] = sprintf('<form method="get" action="%s" name="forwardform" class="forwardform"><input type=hidden name="uid" value="%s" /><input type=hidden name="mid" value="%d" /><input type=hidden name="p" value="forward" /><input type=text name="email" value="" class="forwardinput" /><input name="Send" type="submit" value="%s" class="forwardsubmit"/></form>', $url, $hash, $messageid, $GLOBALS['strForward']);
		//$text["signature"] = "\n\n--\nPowered by PHPlist, www.phplist.com --\n\n";
		 */
	}
	
	
}