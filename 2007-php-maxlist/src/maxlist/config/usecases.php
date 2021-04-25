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
 * $Id: usecases.php 190 2007-11-09 09:17:08Z maxbnet $
 * $LastChangedDate: 2007-11-09 09:17:08 +0000 (Fri, 09 Nov 2007) $
 * $LastChangedRevision: 190 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/config/usecases.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-11-09 09:17:08 +0000 (Fri, 09 Nov 2007) $
*/

$GLOBALS['ROLES']= array(
							0=>'guest',
							1=>'root',
							2=>'admin',
							3=>'master',
							4=>'simple',
);
define('SIMPLE_ROLE',4);
$GLOBALS['R_USE_CASES']['VIEW'] = array(
										//ORDINE ALFABETICO
										'adminattributes'	=> 'ADMIN', // ver 1.0
										//'about'				=> 'GUEST', // ver 1.0
										'admin'		 		=> 'SIMPLE',// ver 1.0
										'admins'	 		=> 'MASTER',// ver 1.0
										'attributes'		=> 'ADMIN', // ver 1.0
										'bounce'			=> 'MASTER', // ver 1.0
										//'bouncerule'		=> 'ROOT', // ver 2.0 
										//'bouncerules'		=> 'ROOT', // ver 2.0 
										'bounces'			=> 'MASTER', // ver 1.0
										//'checkbouncerules'	=> '?', // ver 2.0 
										//'checki18n'			=> 'ROOT',// ver 2.0  
										'configure'  		=> 'ROOT', // ver 1.0
										//'dbcheck'			=> 'ROOT',// ver 2.0  
										//'defaults'			=> '?',// ver 2.0 
										//'domainstats'		=> '?',// ver 2.0  
										'editattributes'	=> 'ADMIN',
										'editlist'			=> 'MASTER',// ver 1.0
										'eventlog'			=> 'ROOT', // ver 1.0
										'export'	 		=> 'ADMIN', // ver 1.0
										//'generatebouncerules'=> '?',// ver 2.0
										'home'				=> 'SIMPLE',// ver 1.0
										'import'	 		=> 'ADMIN',// ver 1.0
										//'importadmin'		=> 'ROOT',// ver 2.0
										//'initialise'		=> '?',// ver 2.0
										//'listbounces'		=> '?',// ver 2.0
										'list'		 		=> 'MASTER', // ver 1.0
										'login'				=> 'GUEST',// ver 1.0
										'logout'			=> 'GUEST',// ver 1.0
										//'massunconfirm'		=> '?',// ver 2.0
										//'mclicks'			=> '?', // ver 2.0
										'members'			=> 'MASTER', // ver 1.0
										'message'			=> 'SIMPLE', // ver 1.0
										'messages'			=> 'SIMPLE', // ver 1.0
										//'mviews'			=> '?',// ver 2.0 
										'processbounces'	=> 'ADMIN',
										'processqueue'		=> 'ADMIN', // ver 1.0
										//'reconcileusers'	=> '?',// ver 2.0
										'send'				=> 'SIMPLE', // ver 1.0
										//'setup'				=> '?',// ver 2.0
										//'spagedit'			=> 'ROOT',//ver 2.0
										//'spage'				=> 'ROOT',//ver 2.0
										'statistics'		=> 'MASTER',
										//'statsoverview'		=> '?', // ver 2.0
										//'subscriberstats'	=> '?', // ver 2.0
										'templates'			=> 'ROOT',
										'template'			=> 'ROOT',
										//'uclicks'			=> '?', // ver 2.0
										//'upgrade'			=> '?',// ver 2.0
										//'usercheck'			=> '?', // ver 2.0
										//'userclicks'		=> '?',// ver 2.0
										'userhistory'		=> 'MASTER',//ver 1.0
										'user'		 		=> 'MASTER', // ver 1.0
										'users'		 		=> 'MASTER', // ver 1.0
										//'viewmessage'		=> '?',// ver 2.0
										//'viewtemplate'		=> '?',// ver 2.0						
										'viewprocess'		=> 'ADMIN', // ver 1.0						

										'subscribe'			=> 'GUEST',// ver 1.0
										'archive'			=> 'GUEST',// ver 1.0
										'unsubscribe'		=> 'GUEST',// ver 1.0
										'preferences'		=> 'GUEST',// ver 1.0
										'viewmessage'		=> 'GUEST', // ver 1.0
										'confirm'			=> 'GUEST', // ver 1.0
);
$GLOBALS['M_USE_CASES'] = array(
										'ROOT' => array(
													'DESC'=>'Other root functions',
													'DESC_ROLE'=>'',
										),
										'ADMIN' => array(
													'DESC'=>'Other admin functions',
													'DESC_ROLE'=>'admin',
										),
										'MASTER' => array(
													'DESC'=>'Other functions',
													'DESC_ROLE'=>'admin,master',
										),
										'SIMPLE' => array(
													'DESC'=>'Other admin functions',
													'DESC_ROLE'=>'admin,master,simple',
										),
										'GUEST' => array(
													'DESC'=>'Other admin functions',
													'DESC_ROLE'=>'admin,master,simple,guest',
										),

);
?>