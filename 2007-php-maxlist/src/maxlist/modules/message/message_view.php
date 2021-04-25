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
 * $Id: message_view.php 379 2008-01-08 16:51:16Z maxbnet $
 * $LastChangedDate: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 * $LastChangedRevision: 379 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/modules/message/message_view.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-08 16:51:16 +0000 (Tue, 08 Jan 2008) $
 */
 
class MessageView extends ModuleView implements IModuleView{
	
	public function __construct($params, $data, $errors = false){
		$this->_init($params, $data, $errors);
		$this->_routing();
	}
	protected function _listall(){
		global $APP;
		//paging
		$paging = new TablePaging(LIMIT_PAGE, $this->_data['total'], $this->_params['pg'], $this->_params['block']);
		$paging->setTarget('container_messages');
		
		//form
		$APP->TPL->assign('tpl_select_findby',array('draft','queued','sent'));
		//paging
		$APP->TPL->assign('tpl_tbl_title',$APP->I18N->_('Messages'));
		$APP->TPL->assign('tpl_paging_total',$this->_data['total']);
		$APP->TPL->assign('tpl_paging_npages',ceil($this->_data['total']/LIMIT_PAGE));
		$APP->TPL->assign('tpl_paging_link', $paging->output());
		$APP->TPL->assign('tpl_list_messages', $this->_data['messages']);
		$APP->TPL->assign('tpl_type', $this->_params['type']);
		
	}
	protected function _view(){
		global $APP;
		//table
		$APP->TPL->assign('tpl_msg',$this->_data['msg']);
		$APP->TPL->assign('tpl_attachments',$this->_data['attachments']);
		$APP->TPL->assign('tpl_listdone',$this->_data['done']);
		$APP->TPL->assign('tpl_resend',$this->_data['resend']);
		
		//config
		$APP->TPL->assign('tpl_config',array('ALLOW_ATTACHMENTS'	=>	ALLOW_ATTACHMENTS));
	
	}
	protected function _edit(){
		global $APP;
		
		$this->_push_post('msg');
		$this->_push_post('targetlist');
		$this->_data['msg']['embargo_ita'] = $this->_convert_date($this->_data['msg']['embargo']);
		
		$this->_assign_calendars();
		$this->_assign_tinymce();
		
		$APP->TPL->assign('tpl_checked',$this->_get_checked_form());
		$APP->TPL->assign('tpl_config',$this->_get_config_form());
		//dati
		$APP->TPL->assign('msg',$this->_data['msg']);
		$APP->TPL->assign('messagedata',$this->_data['messagedata']);
		$APP->TPL->assign('templates',$this->_data['templates']);
		$APP->TPL->assign('lists',$this->_data['lists']);
		$APP->TPL->assign('targetlist',$this->_data['targetlist']);
		$APP->TPL->assign('attachments',$this->_data['attachments']);
		
		$APP->TPL->assign('MSG_DATA', print_r($this->_errors,true) . print_r($this->_data,true));
	}
	private function _get_checked_form(){
		
		$is_html = (isset($this->_params['msg']['sendformat']) && $this->_params['msg']['sendformat'] == 'HTML') 
				   || $this->_data['msg']['sendformat'] == 'HTML';
		
		$is_text = (isset($this->_params['msg']['sendformat']) && $this->_params['msg']['sendformat'] == 'text')
				   || $this->_data['msg']['sendformat'] == 'text';
		
		$is_both = (isset($this->_params['msg']['sendformat']) && $this->_params['msg']['sendformat'] == 'text and HTML')
				   || $this->_data['msg']['sendformat'] == 'text and HTML';
		
		return array(
							'alllists' => isset($this->_params['targetlist']['all']) ?' checked="checked"':'',
							//'criteria_match_all' => @$existing_overall_operator == 'all'? ' checked="checked"':'',
							//'criteria_match_any' => @$existing_overall_operator == 'any'? ' checked="checked"':'',
							'sendformat_html' =>  $is_html ?' checked="checked"':'',
							'sendformat_text'=> $is_text ?' checked="checked"':'',
							'sendformat_textandhtml'=> $is_both ?' checked="checked"':'',
			//				'sendformat_pdf'=> @$_POST['sendformat'] == 'pdf' ?' checked="checked"':'',
			//				'sendformat_textandpdf'=> @$_POST['sendformat'] == 'text and PDF' ?' checked="checked"':'',
							
		);
	}
	private function _get_config_form(){
		return array(
							//'USE_LIST_EXCLUDE' => USE_LIST_EXCLUDE,
							//'NUMCRITERIAS'=> (NUMCRITERIAS +1),
							//'STACKED_ATTRIBUTE_SELECTION' => STACKED_ATTRIBUTE_SELECTION,
							//'USE_REPETITION'=> USE_REPETITION,
							'WEBMASTER_EMAIL'=>WEBMASTER_EMAIL,
							'ALLOW_ATTACHMENTS'=>ALLOW_ATTACHMENTS,
							'NUM_ATTACHMENTS'=>(NUM_ATTACHMENTS + 1),
							'POST_MAX_SIZE'=>ini_get("post_max_size"),
							'UPLOAD_MAX_FILESIZE'=>ini_get("upload_max_filesize"),
							'ENC_TYPE' => ALLOW_ATTACHMENTS ?  ' enctype="multipart/form-data"': '',
							//'USE_PDF'=>(USE_PDF),
		);
		
	}

	private function _assign_tinymce(){
		global $APP;
		$APP->TPL->assign('USE_TINYMCE',USE_TINYMCE);
		$APP->TPL->assign('URL_TINYMCE',URL_TINYMCE);
	}
	private function _assign_calendars(){
		global $APP;
		$embargo = $this->_data['msg']['embargo_ita'];
		//$embargo = myconvertDate($_POST['embargo']) ;
		//$repeatuntil = myconvertDate($_POST['repeatuntil']) ;
		
		$embargo_h = date("H",strtotime($this->_data['msg']['embargo']));
		
		$embargo_m = date("i",strtotime($this->_data['msg']['embargo']));
		//TODO:$repeatuntil_h = date("H",strtotime($repeatuntil_eng));
		//TODO:$repeatuntil_m = date("i",strtotime($repeatuntil_eng));
		
		//request
		//calendar
		require_once(DIR_JSCALENDAR . "/calendar.php");
		$cal_embargo = new DHTML_Calendar(URL_JSCALENDAR. "/",'it','calendar-blue');
		$cal_embargo->set_option('ifFormat','%d/%m/%Y');
		$cal_embargo->set_option('daFormat','%d/%m/%Y');
		$html_cal_embargo = $cal_embargo->return_input_field(array(),array('name' => 'msg[embargo]','value' => $embargo));
		
		/* TODO:
		if(USE_REPETITION){
			$cal_repeatuntil = new DHTML_Calendar(URLJSCALENDAR . "/",'it','calendar-blue');
			$cal_repeatuntil->set_option('ifFormat','%d/%m/%Y');
			$cal_repeatuntil->set_option('daFormat','%d/%m/%Y');
			$html_cal_repeatuntil = $cal_repeatuntil->return_input_field(array(),array('name' => 'repeatuntil','value' => $repeatuntil));
		}
		*/
	
		//jscalendar
		$APP->TPL->assign('tpl_jscalendar_files',$cal_embargo->return_files());
		$APP->TPL->assign('tpl_form_cal_embargo',$html_cal_embargo);
		$APP->TPL->assign('tpl_form_cal_embargo_h',$embargo_h);
		$APP->TPL->assign('tpl_form_cal_embargo_m',$embargo_m);	
		
		/* TODO:
		if(USE_REPETITION){
			$APP->TPL->assign('tpl_form_select_repeat',$lists_repeatinterval);
			$APP->TPL->assign('tpl_form_cal_repeatuntil',$html_cal_repeatuntil);
			$APP->TPL->assign('tpl_form_cal_repeatuntil_h',$repeatuntil_h);
			$APP->TPL->assign('tpl_form_cal_repeatuntil_m',$repeatuntil_m);
		}
		**/
	}
	//PRIVATE
	private function _convert_date($date) {
		//echo $date."<hr>";
		//es: 2006-09-11 15:40:13
		if (strpos($date, "/") > 0) {
			return $date;
		} else {
			$dm = split(" ", $date);
			$d = split("-", $dm[0]);
			return $d[2] . "/" . $d[1] . "/" . $d[0];
		}
	}
	//TEMP
	protected function _ex_edit(){
				
		/*	
		
		if(STACKED_ATTRIBUTE_SELECTION){
			$APP->TPL->assign('tpl_form_stacked_attrs_drop',$att_drop);
			$APP->TPL->assign('tpl_form_stacked_operator_drop',$operator_drop);
			$APP->TPL->assign('tpl_form_stacked_values_drop',$values_drop);
			$APP->TPL->assign('tpl_form_stacked_js',$att_js);//temp
			//head
			$APP->TPL->assign('tpl_th_stacked',array('existingcriteria','operator','values'));
			$APP->TPL->assign('tpl_list_stacked_attrs', $list_stacked_attrs);
		}
		*/
		
		
		
		
		
		/*
		//lists
		$APP->TPL->assign('tpl_form_lists_templates', $lists_templates);
		$APP->TPL->assign('tpl_form_lists_exclude', $lists_exclude);
		$APP->TPL->assign('tpl_form_lists_include', $lists_include);
		$APP->TPL->assign('tpl_form_lists_criteria', $lists_criteria);
		*/

		
	}
	private function _tmp_send_commandline(){
		
		if (isset($done) && $done) {
		  if ($GLOBALS["commandline"]) {
		    ob_end_clean();
		    print clineSignature();
		    print "Message with subject ".$_POST["subject"]. " was sent to ". $lists."\n";
		    exit;
		  }
		  return;
		}
		
	}
}
