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
 * $Id: sendclicktrack_helper.php 352 2007-12-20 19:11:32Z maxbnet $
 * $LastChangedDate: 2007-12-20 19:11:32 +0000 (Thu, 20 Dec 2007) $
 * $LastChangedRevision: 352 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/sendclicktrack_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-20 19:11:32 +0000 (Thu, 20 Dec 2007) $
 */

class SendclicktrackHelper{
	
	public function __construct(){
		if (CLICKTRACK)
		 die("set CLICKTRACK to 0. not implemented");
	}
	private function _temp(){
		## click tracking
		# for now we won't click track forwards, as they are not necessarily users, so everything would fail
		#print_r($text);die;
		//TODO: clicktrack
		/*
		if (CLICKTRACK && $hash != 'forwarded') {
			$urlbase = '';
			# let's leave this for now
			
			#if (preg_match('/<base href="(.*)"([^>]*)>/Umis',$htmlmessage,$regs)) {
			#  $urlbase = $regs[1];
			#} else {
			#  $urlbase = '';
			#}
			#    print "URLBASE: $urlbase<br/>";
			
	
			# convert html message
			#    preg_match_all('/<a href="?([^> "]*)"?([^>]*)>(.*)<\/a>/Umis',$htmlmessage,$links);
			preg_match_all('/<a(.*)href="(.*)"([^>]*)>(.*)<\/a>/Umis', $htmlmessage, $links);
	
			# to process the Yahoo webpage with base href and link like <a href=link> we'd need this one
			#    preg_match_all('/<a href=([^> ]*)([^>]*)>(.*)<\/a>/Umis',$htmlmessage,$links);
			$clicktrack_root = sprintf('http://%s/lt.php', $website . $GLOBALS["pageroot"]);
			for ($i = 0; $i < count($links[2]); $i++) {
				$link = cleanUrl($links[2][$i]);
				$link = str_replace('"', '', $link);
				if (preg_match('/\.$/', $link)) {
					$link = substr($link, 0, -1);
				}
				$linkid = 0;
				#      print "LINK: $link<br/>";
				if ((preg_match('/^http|ftp/', $link) || preg_match('/^http|ftp/', $urlbase)) && $link != 'http://www.phplist.com' && !strpos($link, $clicktrack_root)) {
					# take off personal uids
					$url = cleanUrl($link, array (
						'PHPSESSID',
						'uid'
					));
	
					#        $url = preg_replace('/&uid=[^\s&]+/','',$link);
	
					#        if (!strpos('http:',$link)) {
					#          $link = $urlbase . $link;
					#        }
	
					$req = Sql_Query(sprintf('insert ignore into %s (messageid,userid,url,forward)
													          values(%d,%d,"%s","%s")', $GLOBALS['tables']['linktrack'], $messageid, $userdata['id'], $url, addslashes($link)));
					$req = Sql_Fetch_Row_Query(sprintf('select linkid from %s where messageid = %s and userid = %d and forward = "%s"
													        ', $GLOBALS['tables']['linktrack'], $messageid, $userdata['id'], $link));
					$linkid = $req[0];
	
					$masked = "H|$linkid|$messageid|" . $userdata['id'] ^ XORmask;
					$masked = urlencode(base64_encode($masked));
					$newlink = sprintf('<a%shref="http://%s/lt.php?id=%s" %s>%s</a>', $links[1][$i], $website . $GLOBALS["pageroot"], $masked, $links[3][$i], $links[4][$i]);
					$htmlmessage = str_replace($links[0][$i], $newlink, $htmlmessage);
				}
			}
	
			# convert Text message
			# first find occurances of our top domain, to avoid replacing them later
			preg_match_all('#(https?://' . $GLOBALS['website'] . '/?)\s+#mis', $textmessage, $links);
			#    preg_match_all('#(https?://[a-z0-9\./\#\?&:@=%\-]+)#ims',$textmessage,$links);
			#    preg_match_all('!(https?:\/\/www\.[a-zA-Z0-9\.\/#~\?+=&%@-_]+)!mis',$textmessage,$links);
	
			for ($i = 0; $i < count($links[1]); $i++) {
				$link = strtolower(cleanUrl($links[1][$i]));
				if (preg_match('/\.$/', $link)) {
					$link = substr($link, 0, -1);
				}
				$linkid = 0;
				if (preg_match('/^http|ftp/', $link) && $link != 'http://www.phplist.com' && !strpos($link, $clicktrack_root)) {
					$url = cleanUrl($link, array (
						'PHPSESSID',
						'uid'
					));
					$req = Sql_Query(sprintf('insert ignore into %s (messageid,userid,url,forward)
													          values(%d,%d,"%s","%s")', $GLOBALS['tables']['linktrack'], $messageid, $userdata['id'], $url, $link));
					$req = Sql_Fetch_Row_Query(sprintf('select linkid from %s where messageid = %s and userid = %d and forward = "%s"
													        ', $GLOBALS['tables']['linktrack'], $messageid, $userdata['id'], $link));
					$linkid = $req[0];
	
					$masked = "T|$linkid|$messageid|" . $userdata['id'] ^ XORmask;
					$masked = urlencode(base64_encode($masked));
					$newlink = sprintf('http://%s/lt.php?id=%s', $website . $GLOBALS["pageroot"], $masked);
					$textmessage = str_replace($links[0][$i], '<' . $newlink . '>', $textmessage);
				}
			}
	
			#now find the rest
			# @@@ needs to expand to find complete urls like:
			#http://user:password@www.web-site.com:1234/document.php?parameter=something&otherpar=somethingelse#anchor
			# or secure
			#https://user:password@www.website.com:2345/document.php?parameter=something%20&otherpar=somethingelse#anchor
	
			preg_match_all('#(https?://[^\s\>\}\,]+)#mis', $textmessage, $links);
			#    preg_match_all('#(https?://[a-z0-9\./\#\?&:@=%\-]+)#ims',$textmessage,$links);
			#    preg_match_all('!(https?:\/\/www\.[a-zA-Z0-9\.\/#~\?+=&%@-_]+)!mis',$textmessage,$links);
	
			for ($i = 0; $i < count($links[1]); $i++) {
				$link = strtolower(cleanUrl($links[1][$i]));
				if (preg_match('/\.$/', $link)) {
					$link = substr($link, 0, -1);
				}
				$linkid = 0;
				if (preg_match('/^http|ftp/', $link) && $link != 'http://www.phplist.com' && !strpos($link, $clicktrack_root)) {
					$url = cleanUrl($link, array (
						'PHPSESSID',
						'uid'
					));
	
					$req = Sql_Query(sprintf('insert ignore into %s (messageid,userid,url,forward)
													          values(%d,%d,"%s","%s")', $GLOBALS['tables']['linktrack'], $messageid, $userdata['id'], $url, $link));
					$req = Sql_Fetch_Row_Query(sprintf('select linkid from %s where messageid = %s and userid = %d and forward = "%s"
													        ', $GLOBALS['tables']['linktrack'], $messageid, $userdata['id'], $link));
					$linkid = $req[0];
	
					$masked = "T|$linkid|$messageid|" . $userdata['id'] ^ XORmask;
					$masked = urlencode(base64_encode($masked));
					$newlink = sprintf('http://%s/lt.php?id=%s', $website . $GLOBALS["pageroot"], $masked);
					$textmessage = str_replace($links[0][$i], '<' . $newlink . '> ', $textmessage);
				}
			}
		}
		*/
	}
}