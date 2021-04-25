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
 *
 * Maxlist is a fork of PhpList, a newsletter manager. 
 * The code was deeply changed so there are features of the original phpList and new ones. 
 * It uses smarty, generates XHTML strict, uses an AJAX layer, italian language ,
 * multi-istance, and use case based.
 *
 * 
 * $Id: mailer.php 335 2007-12-01 17:59:29Z maxbnet $
 * $LastChangedDate: 2007-12-01 17:59:29 +0000 (Sat, 01 Dec 2007) $
 * $LastChangedRevision: 335 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/helpers/mailer.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-01 17:59:29 +0000 (Sat, 01 Dec 2007) $
 */

Class MaxMailerHelper {

	public function send_mail($to, $subject, $message, $skipblacklistcheck = 0) {
		if (TEST)
			return 1;
		//echo $skipblacklistcheck;die;
		# do a quick check on mail injection attempt, @@@ needs more work
		if (preg_match("/\n/", $to)) {
			global $APP;
			$APP->MSG->watchdog(LOG_LEVEL,"Error: invalid recipient, containing newlines, email blocked");
			return 0;
		}
		if (preg_match("/\n/", $subject)) {
			global $APP;
			$APP->MSG->watchdog(LOG_LEVEL,"Error: invalid subject, containing newlines, email blocked");
			return 0;
		}

		if (!$to) {
			global $APP;
			$APP->MSG->watchdog(LOG_LEVEL,"Error: empty To: in message with subject $subject to send");
			return 0;
		}
		elseif (!$subject) {
			global $APP;
			$APP->MSG->watchdog(LOG_LEVEL,"Error: empty Subject: in message to send to $to");
			return 0;
		}

		if (!$skipblacklistcheck && $this->is_email_blacklisted($to)) {
			$this->error_send_mail_is_blacklisted($to, $subject, $message);
			return 0;
		}
		return $this->send_mail_phpmailer($to, $subject, $message);

	}
	function send_mail_phpmailer($to, $subject, $message) {
		
		global $APP;
		# global function to capture sending emails, to avoid trouble with
		# older (and newer!) php versions
		$fromemail = $APP->CONF->get("message_from_address");
		$fromname = $APP->CONF->get("message_from_name");
		$message_replyto_address = $APP->CONF->get("message_replyto_address");

		if ($message_replyto_address)
			$reply_to = $message_replyto_address;
		else
			$reply_to = $fromemail;

		$destinationemail = '';

		if (!ereg("dev", VERSION)) {
			$mail = new MaxlistMailer('systemmessage', $to);
			$destinationemail = $to;
			$mail->add_text($message);
		} else {
			# send mails to one place when running a test version
			$message = "To: $to\n" . $message;
			if ($GLOBALS["developer_email"]) {
				# fake occasional failure
				if (mt_rand(0, 50) == 1) {
					return 0;
				} else {

					$mail = new MaxlistMailer('systemmessage', $GLOBALS["developer_email"]);
					$mail->add_text($message);
					$destinationemail = $GLOBALS["developer_email"];
				}
			} else {
				print "Error: Running CVS version, but developer_email not set";
			}
		}
		$mail->build_message(array (
			"html_charset" => $APP->CONF->get("html_charset"
		), "html_encoding" => HTMLEMAIL_ENCODING, "text_charset" => $APP->CONF->get("text_charset"), "text_encoding" => TEXTEMAIL_ENCODING));
		return $mail->send("", $destinationemail, $fromname, $fromemail, $subject);
	}
	// BlackList helper
	// depends: UserModel, UserhistoryModel
	public function error_send_mail_is_blacklisted($email, $msg, $detail) {
		global $APP;
		$APP->MSG->watchdog(LOG_LEVEL,"Error, $email is blacklisted, not sending");
		//$user = $APP->get_model2("user");
		//$user->set_email_inblacklist($email);
		##$APP->DB->sql_query(sprintf('update %s set blacklisted = 1 where email = "%s"', $APP->DB->get_["user"], $email));

		$userhistory = $APP->get_model2("userhistory");
		$userhistory->add_user_history($email, "Marked Blacklisted", "Found user in blacklist while trying to send an email, marked black listed");

	}
	// depends: UserModel
	public function is_email_blacklisted($email) {

		global $APP;
		$bl = $APP->get_model2("userblacklist");
		return $bl->is_email_blacklisted($email);
	}

}