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
 * $Id: sendtemp_helper.php 352 2007-12-20 19:11:32Z maxbnet $
 * $LastChangedDate: 2007-12-20 19:11:32 +0000 (Thu, 20 Dec 2007) $
 * $LastChangedRevision: 352 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/sendtemp_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-20 19:11:32 +0000 (Thu, 20 Dec 2007) $
 */

class SendtempHelper{
	
	//ALL TEMP
	public function build_pdf_and_text_message(){
		/*
		 Sql_Query("update {$GLOBALS["tables"]["message"]} set astextandpdf = astextandpdf + 1 where id = $messageid");
				$pdffile = createPdf($textmessage);
				if (is_file($pdffile) && filesize($pdffile)) {
					$fp = fopen($pdffile, "r");
					if ($fp) {
						$contents = fread($fp, filesize($pdffile));
						fclose($fp);
						unlink($pdffile);
						$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
																		              <html>
																		              <head>
																		                <title></title>
																		              </head>
																		              <body>
																		              <embed src="message.pdf" width="450" height="450" href="message.pdf"></embed>
																		              </body>
																		              </html>';
						#           $mail->add_html($html,$textmessage);
						$mail->add_text($textmessage);
						$mail->add_attachment($contents, "message.pdf", "application/pdf");
					}
				}
				addAttachments($messageid, $mail, "HTML");
		 */
	}
	public function build_pdf_message(){
		/*
		$pdffile = createPdf($textmessage);
		if (is_file($pdffile) && filesize($pdffile)) {
			$fp = fopen($pdffile, "r");
			if ($fp) {
				$contents = fread($fp, filesize($pdffile));
				fclose($fp);
				unlink($pdffile);
				$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
																              <html>
																              <head>
																                <title></title>
																              </head>
																              <body>
																              <embed src="message.pdf" width="450" height="450" href="message.pdf"></embed>
																              </body>
																              </html>';
				#$mail->add_html($html,$textmessage);//PDF + HTML
				#$mail->add_text($textmessage);//PDF + TEXT
				$mail->add_attachment($contents, "message.pdf", "application/pdf");
			}
		}
		addAttachments($messageid, $mail, "HTML");*/
	}
	public function sendingtextonlyto(){
		//TODO : all
		//TODO: domain check 
		/*
		list ($dummy, $domaincheck) = split('@', $destinationemail);
		$text_domains = explode("\n", trim(getConfig("alwayssendtextto")));
		if (in_array($domaincheck, $text_domains)) {
			$htmlpref = 0;
			if (VERBOSE)
				output($GLOBALS['I18N']->get('sendingtextonlyto') .
				" $domaincheck");
		}
		*/
		//TODO: domain check 
		/*
		list ($dummy, $domaincheck) = split('@', $email);
		$text_domains = explode("\n", trim(getConfig("alwayssendtextto")));
		if (in_array($domaincheck, $text_domains)) {
			$htmlpref = 0;
			if (VERBOSE)
				output("Sending text only to $domaincheck");
		}
		*/
	}
	public function use_carriage_return(){
		# particularly Outlook seems to have trouble if it is not \r\n
		# reports have come that instead this creates lots of trouble
		# this is now done in the global sendMail function, so it is not
		# necessary here
		#  if (USE_CARRIAGE_RETURNS) {
		#    $htmlmessage = preg_replace("/\r?\n/", "\r\n", $htmlmessage);
		#    $textmessage = preg_replace("/\r?\n/", "\r\n", $textmessage);
		#  }
	}
	public function clicktrack(){
	
	}
	public function check_user_attr(){
		//TODO:check
		/*
		if (is_array($user_att_values)) {
			foreach ($user_att_values as $att_name => $att_value) {
				if (eregi("\[" . $att_name . "\]", $htmlmessage, $regs)) {
					$htmlmessage = eregi_replace("\[" . $att_name . "\]", $att_value, $htmlmessage);
				}
				if (eregi("\[" . $att_name . "\]", $textmessage, $regs)) {
					$textmessage = eregi_replace("\[" . $att_name . "\]", $att_value, $textmessage);
				}
				# @@@ undocumented, use alternate field for real email to send to
				if (isset ($GLOBALS["alternate_email"]) && strtolower($att_name) == strtolower($GLOBALS["alternate_email"])) {
					$destinationemail = $att_value;
				}
			}
		}
		*/
	}
	public function rss(){
	}
	public function parse_listowner(){
		//TODO ?
		/*if ($listowner) {
			$att_req = Sql_Query("select name,value from {$GLOBALS["tables"]["adminattribute"]},{$GLOBALS["tables"]["admin_attribute"]} where {$GLOBALS["tables"]["adminattribute"]}.id = {$GLOBALS["tables"]["admin_attribute"]}.adminattributeid and {$GLOBALS["tables"]["admin_attribute"]}.adminid = $listowner");
			while ($att = Sql_Fetch_Array($att_req))
				$htmlmessage = preg_replace("#\[LISTOWNER." . strtoupper(preg_quote($att["name"])) . "\]#", $att["value"], $htmlmessage);
		}*/
	}
	public function set_html_style(){
		//TODO
		/*
		$defaultstyle = $APP->CONF->get("html_email_style");
		$adddefaultstyle = 0;
		*/
	}
	public function set_remote_content(){
		//TODO: has_pear_http_request
		/*
		$content = $cached[$messageid]["content"];
		if (preg_match("/##LISTOWNER=(.*)/", $content, $regs)) {
			$listowner = $regs[1];
			$content = ereg_replace($regs[0], "", $content);
		} else {
			$listowner = 0;
		}
		*/
		//TODO: has_pear_http_request
		/*
		if ($GLOBALS["has_pear_http_request"] && preg_match("/\[URL:([^\s]+)\]/i", $content, $regs)) {
			while (strlen($regs[1])) {
				$url = $regs[1];
				if (!preg_match('/^http/i', $url)) {
					$url = 'http://' . $url;
				}
				$remote_content = fetchUrl($url, $userdata);
				if ($remote_content) {
					$content = eregi_replace(preg_quote($regs[0]), $remote_content, $content);
					$cached[$messageid]["htmlformatted"] = strip_tags($content) != $content;
				} else {
					logEvent("Error fetching URL: $regs[1] to send to $email");
					return 0;
				}
				preg_match("/\[URL:([^\s]+)\]/i", $content, $regs);
			}
		}
		*/
	}
	
}