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
 * $Id: mailer.php 355 2007-12-23 17:46:42Z maxbnet $
 * $LastChangedDate: 2007-12-23 17:46:42 +0000 (Sun, 23 Dec 2007) $
 * $LastChangedRevision: 355 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/inc/mailer.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-23 17:46:42 +0000 (Sun, 23 Dec 2007) $
 */


class MaxlistMailer extends PHPMailer {
    
    var $isText = false;
    var $WordWrap = 75;
    var $encoding = 'base64';
    var $image_types = array(
                  'gif'  => 'image/gif',
                  'jpg'  => 'image/jpeg',
                  'jpeg'  => 'image/jpeg',
                  'jpe'  => 'image/jpeg',
                  'bmp'  => 'image/bmp',
                  'png'  => 'image/png',
                  'tif'  => 'image/tiff',
                  'tiff'  => 'image/tiff',
                  'swf'  => 'application/x-shockwave-flash'
                  );

    function __construct($messageid,$email) {
    
      global $APP;
      #  parent::PHPMailer();
      $this->addCustomHeader("X-Mailer: Maxlist v".VERSION);
      $this->addCustomHeader("X-MessageID: $messageid");
      $this->addCustomHeader("X-ListMember: $email");
      $this->addCustomHeader("Precedence: bulk");
      $this->Host = MAILER_HOST;
      $this->Helo = $APP->CONF->get("website");
      $this->CharSet = $APP->CONF->get("html_charset");
      if (SMTP_USERNAME) {
        $this->SMTPAuth = true;
        $this->Username = SMTP_USERNAME;
        $this->Password = SMTP_PWD;
#        logEvent('Sending authenticated email via '.PHPMAILERHOST);
      }
      $ip = gethostbyname($this->Host);
      if (MESSAGE_ENVELOPE) {
        $this->Sender = MESSAGE_ENVELOPE;
        $this->addCustomHeader("Errors-To: ".MESSAGE_ENVELOPE);
      }
      
      if (!$this->Host || $ip == $this->Host) {
        $this->Mailer = "mail";
#        logEvent('Sending via mail');
      } else {
        $this->Mailer = "smtp";
#        logEvent('Sending via smtp');
      }
    }

    function add_html($html,$text = '',$templateid = 0) {
      $this->Body = $html;
      $this->IsHTML(true);
      if ($text) {
        $this->add_text($text);
      }
      $this->find_html_images($templateid);
    }

    function add_text($text) {
      if (!$this->Body) {
        $this->IsHTML(false);
        $this->Body = $text;
       } else {
        $this->AltBody = $text;
      }
    }

    function append_text($text) {
      if ($this->AltBody) {
        $this->AltBody .= $text;
      } else {
        $this->Body .= $text;
      }
    }

    function build_message() {
    }

    function send($to_name = "", $to_addr, $from_name, $from_addr, $subject = '', $headers = '',$envelope = '') {
      global $APP;
      $this->From = $from_addr;
      $this->FromName = $from_name;
      if (strstr(VERSION, "dev")) {
        # make sure we are not sending out emails to real users
        # when developing
        $this->AddAddress(DEV_EMAIL);
      } else {
        $this->AddAddress($to_addr);
      }
      $this->Subject = $subject;
      //print_r($this);die;
      if(!parent::Send()) {
        #echo "Message was not sent <p>";
        $APP->MSG->log("Mailer Error: " . $this->ErrorInfo);
        return 0;
      }#
      return 1;
    }

    function add_attachment($contents,$filename,$mimetype) {
      // Append to $attachment array
      $cur = count($this->attachment);
      $this->attachment[$cur][0] = chunk_split(base64_encode($contents), 76, $this->LE);
      $this->attachment[$cur][1] = $filename;
      $this->attachment[$cur][2] = $filename;
      $this->attachment[$cur][3] = $this->encoding;
      $this->attachment[$cur][4] = $mimetype;
      $this->attachment[$cur][5] = false; // isStringAttachment
      $this->attachment[$cur][6] = "attachment";
      $this->attachment[$cur][7] = 0;
    }

     function find_html_images($templateid) {
      #if (!$templateid) return;
      // Build the list of image extensions
      while(list($key,) = each($this->image_types))
        $extensions[] = $key;

      preg_match_all('/"([^"]+\.('.implode('|', $extensions).'))"/Ui', $this->Body, $images);

      for($i=0; $i<count($images[1]); $i++){
        if($this->image_exists($templateid,$images[1][$i])){
          $html_images[] = $images[1][$i];
          $this->Body = str_replace($images[1][$i], basename($images[1][$i]), $this->Body);
        }
      }

      if(!empty($html_images)){
        // If duplicate images are embedded, they may show up as attachments, so remove them.
        $html_images = array_unique($html_images);
        sort($html_images);
        for($i=0; $i<count($html_images); $i++){
          if($image = $this->get_template_image($templateid,$html_images[$i])){
            $content_type = $this->image_types[substr($html_images[$i], strrpos($html_images[$i], '.') + 1)];
            $cid = $this->add_html_image($image, basename($html_images[$i]), $content_type);
            $this->Body = str_replace(basename($html_images[$i]), "cid:$cid", $this->Body);#@@@
          }
        }
      }
    }

    function add_html_image($contents, $name = '', $content_type='application/octet-stream') {
      // Append to $attachment array
      $cid = md5(uniqid(time()));
      $cur = count($this->attachment);
      $this->attachment[$cur][0] = $contents;
      $this->attachment[$cur][1] = '';#$filename;
      $this->attachment[$cur][2] = $name;
      $this->attachment[$cur][3] = $this->encoding;
      $this->attachment[$cur][4] = $content_type;
      $this->attachment[$cur][5] = false; // isStringAttachment
      $this->attachment[$cur][6] = "inline";
      $this->attachment[$cur][7] = $cid;

      return $cid;
    }

    function image_exists($templateid,$filename) {
      return false;//TODO
      $req = Sql_Query(sprintf('select * from %s where template = %d and (filename = "%s" or filename = "%s")',
        $GLOBALS["tables"]["templateimage"],$templateid,$filename,basename($filename)));
      return Sql_Affected_Rows();
    }

     function get_template_image($templateid,$filename){
      return true;//TODO
      $req = Sql_Fetch_Row_Query(sprintf('select data from %s where template = %d and (filename = "%s" or filename = "%s")',
        $GLOBALS["tables"]["templateimage"],$templateid,$filename,basename($filename)));
      return $req[0];
    }

    function EncodeFile ($path, $encoding = "base64") {
      # as we already encoded the contents in $path, return $path
      return chunk_split($path, 76, $this->LE);
    }
}
