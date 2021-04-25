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
 * $Id:scaffold_view.php 211 2007-11-10 11:45:22Z maxbnet $
 * $LastChangedDate:2007-11-10 12:45:22 +0100 (sab, 10 nov 2007) $
 * $LastChangedRevision:211 $
 * $LastChangedBy:maxbnet $
 * $HeadURL:https://maxlist.svn.sourceforge.net/svnroot/maxlist/trunk/maxlist/modules/_scaffold/scaffold_view.php $
 * 
 * $Author:maxbnet $
 * $Date:2007-11-10 12:45:22 +0100 (sab, 10 nov 2007) $
 */
 
class StatisticView extends ModuleView implements IModuleView{
	
	public function __construct($params, $data, $errors = false){
		$this->_init($params, $data , $errors);
		$this->_routing();
	}
	protected function _listall(){
		global $APP;
		$paging = new TablePaging(LIMIT_PAGE, $this->_data['total'], $this->_params['pg'], $this->_params['block']);
		//paging
		$APP->TPL->assign('tpl_tbl_title',$APP->I18N->_('statistics'));
		$APP->TPL->assign('tpl_paging_total',$this->_data['total']);
		$APP->TPL->assign('tpl_paging_npages',ceil($this->_data['total']/LIMIT_PAGE));
		$APP->TPL->assign('tpl_paging_link', $paging->output());
			
		$APP->TPL->assign('tpl_list_messages', $this->_data['messages']);
	}
	private function statistics(){
		return;
		
		if(!checkRole("messages"))
			myRedirect();
		
		$_REQUEST['type'] = 'sent';
		
		include_once(DIRMODELS . "/messages_model.php");
		
		if(sizeof($list_messages)==0){
			addPublicInfo("Non sono presenti statistiche");
		}
		
		
		//controlli richiesta
		if(isAjax()){
				$APP->TPL->assign('tpl_ajax_form',' onsubmit="return ajaxForm(this,\'users\',\'container_users\');"');
			}
			//head
			$th_messages = array(
			
								'from' => $APP->I18N->_("From:"),
								'subject' => $APP->I18N->_("Subject:"),
								'entered' => $APP->I18N->_("Entered:"),
								'embargo' => $APP->I18N->_("Embargo:"),
								'status' => $APP->I18N->_("Status"),
								'clicks' => $APP->I18N->_('Clicks'),
								'sent' => $APP->I18N->_("Sent"),
								'timetosend' => $APP->I18N->_("Time to send"),
								'viewed' => $APP->I18N->_("Viewed"),
								'unique' => $APP->I18N->_("Unique Views"),
								'text' => $APP->I18N->_("text"),
								'html' => $APP->I18N->_("html"),
								'both' => $APP->I18N->_("both"),
								'total' => $APP->I18N->_("total"),
								'bounced' => $APP->I18N->_("Bounced"),
								#$APP->I18N->_("Message info"),
								#$APP->I18N->_("Action"),
								
								#'from' => $APP->I18N->_('still to process'),
								#'from' => $APP->I18N->_('ETA'),
								#'from' => $APP->I18N->_('Processing'),
								#'from' => $APP->I18N->_('msgs/hr'),
								#'clickstats' => $APP->I18N->_("click stats"),
			);
			//action
			$lbl_action = array(
								'view'	=>	$APP->I18N->_("View"),
								'delete'	=>	$APP->I18N->_("delete"),
								'requeue'	=>	$APP->I18N->_("Requeue"),
								'edit'	=>	$APP->I18N->_("Edit"),
								'deldrafts'=>$APP->I18N->_("Delete all draft messages without subject"),
								'yes'=>$APP->I18N->_("yes"),
								'no'=>$APP->I18N->_("no"),
			#$APP->I18N->_('Suspend Sending'),
			);
			//messages
			$lbl_messages = array(
			);
			//paging
			
			###########################################
			###template
			###########################################
			
			//get
			$APP->TPL->assign('tpl_get',getToString());
			$APP->TPL->assign('tpl_GET',$_GET);
			$APP->TPL->assign('tpl_REQUEST',$_REQUEST);
			//head
			$APP->TPL->assign('tpl_th',$th_messages);
			//action
			$APP->TPL->assign('tpl_lbl_action',$lbl_action);
			//messages
			$APP->TPL->assign('tpl_lbl_messages',$lbl_messages);
			//paging
			$APP->TPL->assign('tpl_tbl_title',$APP->I18N->_('Messages'));
			$APP->TPL->assign('tpl_paging_total',$total);
			$APP->TPL->assign('tpl_paging_npages',ceil($total/MAX_USER_PP));
			$APP->TPL->assign('tpl_paging_link', $paging->output());
			$APP->TPL->assign('tpl_type', $type);
	}
}
