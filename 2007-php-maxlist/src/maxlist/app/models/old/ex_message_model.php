<?php
/**
 * Project: maxlist <br />
 * Copyright (C) 2006 Massimiliano Balestrieri
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
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 1.0
 * @copyright 2006 Massimiliano Balestrieri.
 * @package Models
 */
 
class MessageModel extends ModuleModel{
	public $messages = array();
	public $table = false;
	public $db = false;
	
	//HELPER
	public $MAILER = false; 
	
	
	
	
	public function __construct($params){
		global $APP;
		$this->table = $APP->DB->get_table('message');
		$this->db = $APP->DB;
		$this->_params = $params;
		//cancella nosubject fino ad un ora prima
		$this->delete_draft_old();
	}
	
	
	//delete_draft ? 
	public function delete_draft(){
		$ownerselect_and = '';//TODO: $ownerselect_and
		$todelete = array();
	    $req = $this->db->sql_query(sprintf('select id from %s where status = "draft" and (subject = "" or subject = "(no subject)") %s',
	    $this->db->get_table("message"),$ownerselect_and));
	    if($this->db->sql_affected_rows()){
			while ($row = $this->db->sql_fetch_row($req)) {
		      array_push($todelete,$row[0]);
		    }
		}
		foreach ($todelete as $delete) {
		# delete the index in delete
			$this->delete($delete);
		}
	}

	
	
	
	
	
	
	// init messages
	private function _temp_pre_get_messages(){
					if(isset($_POST['id'])){
					/*if(isRoleSimple()){*/
						$sql = "SELECT id,status FROM $this->db->get_table[message] where id='$_POST[id]'";
						$result = $this->db->sql_fetch_row_query($sql);
						if($this->db->sql_affected_rows() && @$result[1] != 'draft'){
							addPublicSessionInfo("Il messaggio selezionato non pu&ograve; essere editato perch&egrave; &egrave; stato gi&agrave; inviato.");
							myRedirect("view=messages");
						}else{
							myRedirect("view=send&id=".$_POST['id']);
						}
				}
					
	}
	
	private function _temp_action_send(){

	//2?
		  if ((!isset($_POST["year"]) || !is_array($_POST["year"])) && $_POST["embargo"] && $_POST["embargo"] != "0000-00-00 00:00:00") {
		     ###$embargo->setDateTime($_POST["embargo"]);
		  }
		  if ((!isset($_POST["year"]) || !is_array($_POST["year"])) && $_POST["repeatuntil"] && $_POST["repeatuntil"] != "0000-00-00 00:00:00") {
		    ###$repeatuntil->setDateTime($_POST["repeatuntil"]);
		  }

	//3?
    	$_POST["message"] = nl2br($_POST["message"]);

	//4
		# sanitise the header fields, what else do we need to check on?
		if (preg_match("/\n|\r/",$_POST["from"])) {
		  $from = "";
		} else {
		  $from = $_POST["from"];
		}
		if (preg_match("/\n|\r/",$_POST["msgsubject"])) {
		  $subject = "";
		} else {
		  $subject = $_POST["msgsubject"];
		}
	
	
  	//6?
	    if (!$GLOBALS["has_pear_http_request"] && preg_match("/\[URL:/i",$_POST["message"])) {
	      print Warn($GLOBALS['I18N']->get('warnnopearhttprequest'));
	    }

  	//7? dopo le liste le liste escluse
	
		 


  
  
    
  

  
    




  
  $any = 0;
  $lists_criteria = array();
  for($i=0;$i<=NUMCRITERIAS;$i++){
    $attributes_request = Sql_Query("select * from $tables[attribute]");
    while ($attribute = Sql_Fetch_array($attributes_request)) {
      $xhtml = null;
      switch ($attribute["type"]) {
        case "checkbox":
          $xhtml = csi_content_criteria_checkbox($i,$attribute['id'],$attribute['name']." ".$GLOBALS['I18N']->get('is'));
          break;
        case "select":
        case "radio":
        case "checkboxgroup":
          $values_request = Sql_Query("select * from $table_prefix"."listattr_".$attribute["tablename"]);
          $values = array();
          while ($value = Sql_Fetch_array($values_request)) {
          	$values[] = array('id' => $value["id"],'name'=>htmlentities($value["name"]));
          }
          $xhtml = csi_content_criteria_rad_sel_group($values,$i,$attribute["id"],strip_tags($attribute["name"])." ".$GLOBALS['I18N']->get('is'),$attribute["type"]);
          break;
        default:
          //$criteria_content = "\n<!-- error: huh, unknown type ".$attribute["type"]." -->\n";
      }
      $lists_criteria[] = array(
      							'id' => $attribute["id"],
      							'type' => $attribute["type"],
      							'xhtml'=> $xhtml, 
      							'index'=> $i,
      );
    
    }
    }

	}
	


	private function _temp_old_action_messages(){
		
		
		if (isset($_GET['resend'])) {
		  if(isset($_POST["confirm"]) && $_POST["confirm"] == $GLOBALS['I18N']->get('yes')){
			  $resend = sprintf('%d',$_GET['resend']);
			  # requeue the message in $resend
			  //print $GLOBALS['I18N']->get("Requeuing")." $resend ..";
			  $sql = "update ".$this->table." set status = \"submitted\" where id = $resend";
			  $result = Sql_query($sql);
			  $suc6 = $this->db->sql_affected_rows();
			  # only send it again to users, if we are testing, otherwise only to new users
			  if (TEST)
			    $result = Sql_query("delete from ".$this->db->get_table("usermessage")." where messageid = $resend");
			  if ($suc6)
			    ;//print "... ".$GLOBALS['I18N']->get("Done");
			  else
			    ;//print "... ".$GLOBALS['I18N']->get("failed");
			    
			  addPublicSessionInfo("Il messaggio &egrave; stato riaccodato");
			  myRedirect("view=messages&type=".@$_REQUEST['type']);
		  }elseif(isset($_POST["confirm"]) && $_POST["confirm"] == $GLOBALS['I18N']->get('no')){
		   	myRedirect("view=messages&type=".@$_REQUEST['type']);
		  }
		}
		
		if (isset($_GET['suspend'])) {
		  if(isset($_POST["confirm"]) && $_POST["confirm"] == $GLOBALS['I18N']->get('yes')){
			  $suspend = sprintf('%d',$_GET['suspend']);
			  print $GLOBALS['I18N']->get('Suspending')." $suspend ..";
			  $result = Sql_query(sprintf('update %s set status = "suspended" where id = %d and (status = "inprocess" or status = "submitted")',
			  					$this->table,$suspend));
			  $suc6 = $this->db->sql_affected_rows();
			  if ($suc6)
			    ;//print "... ".$GLOBALS['I18N']->get("Done");
			  else
			    ;//print "... ".$GLOBALS['I18N']->get("failed");
			  
			  addPublicSessionInfo("Il messaggio &egrave; stato sospeso");
			  myRedirect("view=messages&type=".@$_REQUEST['type']);
		    }elseif(isset($_POST["confirm"]) && $_POST["confirm"] == $GLOBALS['I18N']->get('no')){
		   	myRedirect("view=messages&type=".@$_REQUEST['type']);
		  }
		}
		
		##altro
		$id = sprintf('%d',$_GET["id"]);
		if (!$id) {
		  myRedirect();
		}
		if (isset($_POST['back'])){
			myRedirect(getLastPage());
		}
		if (isset($_POST['edit'])){
			myRedirect("view=send&id=".$_POST['id']);
		}
		$subselect = '';
		$owner_select_and = '';
		
		if (isset($_POST['resend']) && is_array($_POST['list'])) {
		  if ($_POST['list']['all']) {
		    $res = Sql_query("select * from $tables[list]");
		    while($list = Sql_fetch_array($res))
		      if ($list["active"])
		        $result = Sql_query("insert into $tables[listmessage] (messageid,listid,entered) values($id,$list[id],now())");
		  } else {
		    foreach($_POST['list'] as $key => $val) {
		      if ($val == 'signup') {
		        $result = Sql_query("insert into $tables[listmessage] (messageid,listid,entered) values($id,$key,now())");
		      }
		    }
		  }
		  $this->db->sql_query("update $tables[message] set status = \"submitted\" where id = $id");
		}
	}
	
	//PRIVATE
	
	//help update
	private function _pre_checks(){
		//$messageok = $this->_check_content() && $this->_check_images() && $this->_check_full_links();
		//if (!$messageok) {
		//	$this->_info($this->_("Some errors were found, template NOT saved!"));
		//}
		//return $messageok;
	}
	
	
	//update - TODO : lists exclude
	private function _temp_set_excludelist(){
		return;
		if (isset($_POST["excludelist"]) && is_array($_POST["excludelist"])) {
	    	$exclude = join(",",$_POST["excludelist"]);
	    	Sql_Query(sprintf('replace into %s (name,id,data) values("excludelist",%d,"%s")',$tables["messagedata"],$messageid,$exclude));
	  	}
	}
	
	
	
	//TODO : get -> check 1
	private function _check_draft(){
		//if(isRoleSimple()){
  		//if(!isset($_POST['send'])){//baco 
		$sql = "SELECT id,status FROM {$this->table} where id='$id'";
		$check = $this->db->sql_fetch_row_query($sql);
		if($this->db->sql_affected_rows() && @$check[1] != 'draft'){
			$this->_fatal_error("message_send_not_editable", LOG_LEVEL);
		}
	}

	//help get_messages
	private function _load_message_data($msgid){
		$messagedata = array();
  		$msgdata_req = $this->db->sql_query(sprintf('select * from %s where id = %d',
    		$this->db->get_table('messagedata'),$msgid));
  		while ($row = $this->db->sql_fetch_array($msgdata_req)) {
    		$messagedata[$row['name']] = $row['data'];
  		}
	  	return $messagedata;
	}
	
	//help get_messages
	

	//UTILS
	private function _fatal_error($msg, $lvl = 0){
		$msg = is_numeric(strpos($this->_($msg),"<span>" )) ? $msg : $this->_($msg);//TODO : fix this please!
		$this->_flash($lvl,$msg);
		$this->_redirect();
	}


}
