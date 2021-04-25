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

class ImportModel extends ModuleModel{
	
	public $table = false;
	public $db = false;
	
	private $_TEST = 1;//0 in production
	
	private $_session = false;
	private $_import_file = false;
	private $_tmp_dir = false;
	
	private $_total = false;
	private $_emails = false;
	
	private $_header = false;
	private $_headers = false;
	
	private $_system_attributes = false;
	private $_attributes = false;
	private $_used_system_attributes = false;
	private $_used_attributes = false;
	
	private $_system_attribute_mapping = false;
	
	private $_count = false;
	private $_some = false;
	
	private $_num_lists = false;
	
	private $_system_values = false;
	
	public function __construct($params){
		global $APP;
		$this->table = $APP->DB->get_table('scaffold');
		$this->db = $APP->DB;
		$this->_params = $params;
		
		$this->_session = new ImportSession();
	}
	
	public function get(){
	
		return;
		if(!checkRole("import"))
			myRedirect();
		
		$role = getRole();
		switch($role){
			case 1://root
			case 2://admin
			$subselect = "";
		  	break;
			case 3://master
		    $subselect = " where owner = ".$_SESSION[VERSION]["logindetails"]["id"];
		 	break;
		}	
		
		$arr_lists = array();
		if (Sql_Table_Exists($APP->DB->get_table["list"])) {
		  $result = $APP->DB->sql_query("SELECT id,name FROM ".$APP->DB->get_table["list"]." $subselect ORDER BY listorder");
		    $x = 0;
		    while ($row = $APP->DB->sql_fetch_array($result)) {
		      $arr_lists[] = array(
									'name'	=> stripslashes($row["name"]),
									'id'	=> $row["id"],
									'checked' => isset($_POST['lists'][$x])?' checked="checked"':'',
									'cnt'	=> $x++,
		      );
			}
		}
	}
	private function _set_tmp_dir($dir){
		$this->_tmp_dir = $dir;	
	}
	private function _check_tmp_dir($dir){
		if (!is_dir($dir) || !is_writable($dir)) {
		  $this->_fatal_error(sprintf($this->_('The temporary directory for uploading (%s) is not writable, so import will fail'),$dir));
		}
		
	}
	public function resetimport(){
		$this->_clear_import();
		$this->_session->delete('result_import');
		$this->_session->delete('import');
		if(!$this->_TEST)
			$this->_redirect();//TODO:remove
	}
	private function _clear_import(){
		$file = $this->_session->get('import_file','import');
		if (is_file($file)) 
    		unlink($file);
  	}
  		
	public function userimport(){
		ignore_user_abort();
		@set_time_limit(500);
		$illegal_cha = array(",", ";", ":", "#","\t");
		
		
		$this->_set_tmp_dir(TMP_REPOSITORY);
		
		$this->_check_tmp_dir($this->_tmp_dir);
		
		//TODO:if (!isset($GLOBALS["assign_invalid_default"]))
		//TODO: $GLOBALS["assign_invalid_default"] = $GLOBALS['I18N']->get('Invalid Email').' [number]';
		
		$this->_session->set('result_import', 0);
		
		$test_import = 0;
		$some = 0;
		
		//TODO: ? this. 
		$test_import = 1;//(isset($_POST["import_test"]) && $_POST["import_test"] == "yes");
		$this->_session->set('test_import', $test_import);
		
		
		$this->_set_import_file();//step 0.1 - sembra ok
		$this->_check_import_file();//step 0.2 - sembra ok
	
		$this->_check_notify();//step 1 - sembra ok
	
		$this->_move_uploaded_file();//step 2
	
		$this->_set_import_record_delimiter();//step 3
		$this->_set_import_field_delimiter();//step 4
		
		$this->_set_params();//step 5
	
		/*if (@$_POST["confirm"]) {
		  $_SESSION["import"]["test_import"] = '';
		}*/
		if($this->_session->get("import_file"))
			$this->_init_import();//7
			
	}
	
	//7
	private function _init_import(){
		//TODO: ? 
		$this->_read_file(); //step 7.1
		$this->_clean_emails(); //step 7.2
		$this->_replace_record_delimiter(); //step 7.3
		$this->_split_emails_from_headers(); //step 7.4
		
		if($this->_TEST){
			$this->_session->set('emails', $this->_emails);
			$this->_session->set('headers', $this->_headers);
		}
		
		$this->_init_system_and_attributes(); //step 7.5 -> DEBUG FINO A QUI
		exit;
		
		$this->_check_systemindex_email(); //step 7.6
		$this->_temp_used_attributes();
		
		if($this->_total > 0){
			$this->_check_max_size(); //step 8.1
			$this->_set_system_attributes(); //step 8.2
			$this->_init_count(); //step 8.3
			
			$this->_init_process();//step 9
			
			$this->_send_report();//step FINAL
		}
	}
	//step 9.1
	private function _check_num_headers(){
		if (sizeof($values) != (sizeof(@$_SESSION["import"]["import_attribute"]) + sizeof(@$_SESSION["import"]["system_attributes"]))
		      && $test_import && @$_POST["show_warnings"])
		      Csi_Warn("Record has more values than header indicated (".
		        sizeof($values). "!=".
		        (sizeof($_SESSION["import"]["import_attribute"]) + sizeof($_SESSION["import"]["system_attributes"]))
		      ."), this may cause trouble: $index");
		      
	}
	private function _init_process(){
		# print "A: ".sizeof($import_attribute);
		// Parse the lines into records
		#  print "<br/>Loading emails .. ";
		//  flush();
		$c = 1;
		$cnt = 0;
		  
		$this->_num_lists = sizeof($this->_session->get("lists"));
		
		$additional_emails = 0;
		$test_html = '';
		 
		foreach ($this->_emails as $line) {
			# print $line.'<br/>';
		    $user = array();
		    # get rid of text delimiters generally added by spreadsheet apps
		    $line = str_replace('"','',$line);
			
		    $values = explode($this->_session->get("import_field_delimiter"),$line);
		
		    reset($this->_system_attribute_mapping);
		    $this->_system_values = array();
		    foreach ($this->_system_attribute_mapping as $column => $index) {
		      #print "$column = ".$values[$index]."<br/>";
		      $this->_system_values[$column] = $values[$index];
		    }
		    $index = clean($this->_system_values["email"]);
		    $invalid = 0;
		    if (!$index) {
		      	if ($this->_session->get("show_warnings"))
		        	$this->_flash(0,$this->_('Record has no email'). ": $c -> $line");
		      	
		      	$index = $GLOBALS['I18N']->get('Invalid Email')." $c";
		      	$this->_system_values["email"] = $this->_session->get("assign_invalid");
		      	$invalid = 1;
		      	$this->_count["invalid_email"]++;
		    }
			
			$this->_check_num_headers();//step 9.1		    
		    
		    if (!$invalid || ($invalid && $this->_session->get("omit_invalid") != "yes")) {
		      	$user["systemvalues"] = $this->_system_values;
		      	$import_attribute = $this->_session->get("import_attribute");
		      	if(is_array($import_attribute)){
			    	reset($import_attribute);
			      	$replace = array();
			      	while (list($key,$val) = each ($import_attribute)) {
			        	$user[$val["index"]] = addslashes($values[$val["index"]]);
			        	$replace[$key] = addslashes($values[$val["index"]]);
			      	}
		      	}
		    } else {
		     # Warn("Omitting invalid one: $email");
		    }
		    
		    $user["systemvalues"]["email"] = parsePlaceHolders($this->_system_values["email"],@array_merge(@$replace,$system_values,array("number" => $c)));
		    $user["systemvalues"]["email"] = clean($user["systemvalues"]["email"]);
		    $c++;
		    
		    if ($_SESSION["import"]["test_import"]) {

		    	//step CONFIRM HTML
			     $this->_prepare_html_confirm();

		    } else {
		      # do import
		      # STEP : ATTRIBUTE create new attributes
		      $this->_add_attribute();//STEP add record
		      $new = 0;
		      $cnt++;
		      #if ($cnt % 25 == 0) {
		      #  print "da vedere";exit;
		      #  print "<br/>\n$cnt/$total";
		      #  flush();
		      #}
		      
		      
		      $this->_check_exists();//STEP check exist
		      $this->_add_record();//STEP add record
		      
		     
		
		      //step TODO: ATTRIBUTES
		      $this->_temp_set_attributes();

		      //step LISTS
		      $this->_set_lists();
		      //step TODO : 
		      $this->_temp_set_groups();
		    } // end else
		    if ($_SESSION["import"]["test_import"] && $c > 50) break;
		  }
	
	}
	//TESTED ?
	//SESSION
	//step 2
	private function _set_import_session($file){
		$this->_session->set("import_file", $file);
	}
	//SESSION
	//step 3
	private function _set_import_record_delimiter(){
		if($param = $this->_params["import_record_delimiter"] != "") {
			$this->_session->set("import_record_delimiter", $param);
		} else {
			$this->_session->set("import_record_delimiter", '\n');
		}
	}
	//SESSION
	//step 4
	private function _set_import_field_delimiter(){
		if($param = $this->_params["import_field_delimiter"] != "") {
			$this->_session->set("import_field_delimiter", $param);
		} else {
		    $this->_session->set("import_field_delimiter", '\n');
		}
	}
	//SESSION
	//step 5
	private function _set_params(){
		$this->_session->set("show_warnings", $this->_params['show_warnings']);
		$this->_session->set("assign_invalid", $this->_params['assign_invalid']);
		$this->_session->set("omit_invalid", $this->_params['omit_invalid']);
		$this->_session->set("lists", $this->_params['lists']);
		$this->_session->set("overwrite", $this->_params['overwrite']);
		$this->_session->set("listname", $this->_params['listname']);
		$this->_session->set("retainold", $this->_params['retainold']);
	}
	
	//step 0.1
	private function _set_import_file(){
		$this->_import_file = isset($_FILES["import_file"]) ? $_FILES["import_file"] : false; 
	}
	//step 0.2
	private function _check_import_file(){
		if(!$this->_import_file || strlen($this->_import_file['name']) == 0)
			$this->_fatal_error(0,$this->_('File is either too large or does not exist.'));
		if(empty($this->_import_file))
			$this->_fatal_error(0,$this->_('No file was specified. Maybe the file is too big?'));
		if(@filesize($this->_import_file['tmp_name']) > 1000000)
			$this->_fatal_error(0,$this->_('File too big, please split it up into smaller ones'));# if we allow more, we will certainly run out of memory
		if(!preg_match("/^[0-9A-Za-z_\.\-\/\s \(\)]+$/", $this->_import_file["name"]))
			$this->_fatal_error(0,$this->_('Use of wrong characters in filename: '.$this->_import_file["name"]));
	}
	//step 1
	private function _check_notify(){
		if (!isset($this->_params["notify"])){ //TODO:&& !$test_import) {
		    $this->_fatal_error('Please choose whether to sign up immediately or to send a notification');
		} else{
		    $this->_session->set("notify",$this->_params["notify"]);
		}
	}
	//step 2
	private function _move_uploaded_file(){
		if ($this->_import_file && $this->_import_file['size'] > 10) {
			$newfile = $this->_tmp_dir . '/' . $this->_import_file['name'].time();
		    move_uploaded_file($this->_import_file['tmp_name'], $newfile);
		    $this->_set_import_session($newfile);
		    if( !($fp = fopen ($newfile, "r"))) {
		      $this->_fatal_error('File is not readable !');
		    }
		    fclose($fp);
		} elseif ($this->_import_file) {
		    $this->_fatal_error('Something went wrong while uploading the file. Empty file received. Maybe the file is too big, or you have no permissions to read it.');
		}	
	}
	

	//7.1
	private function _read_file(){
		# output some stuff to make sure it's not buffered in the browser
		$fp =  fopen ($this->_session->get("import_file"), "r");
		$this->_emails = fread($fp, filesize ($this->_session->get("import_file")));
		fclose($fp);
	}  
	//7.2
	private function _clean_emails(){
		// Clean up email file
		$this->_emails = trim($this->_emails);
		$this->_emails = str_replace("\r","\n",$this->_emails);
		$this->_emails = str_replace("\n\r","\n",$this->_emails);
		$this->_emails = str_replace("\n\n","\n",$this->_emails);
		
	}
	//7.3
	private function _replace_record_delimiter(){
		if ($this->_session->get("import_record_delimiter") != "\n") {
		    $this->_emails = str_replace($this->_session->get("import_record_delimiter"),"\n",$this->_emails);
		}
	}
	//7.4
	private function _split_emails_from_headers(){
		
		  // Split file/emails into array
		$this->_emails = explode("\n",$this->_emails);
		  //printf('..'.$GLOBALS['I18N']->get('ok, %d lines').'</p>',sizeof($email_list));
		$this->_header = array_shift($this->_emails);
		$this->_header = str_replace('"','',$this->_header);
		$this->_total = sizeof($this->_emails);
		$this->_headers = explode($this->_session->get("import_field_delimiter"),$this->_header);
		$this->_headers = array_unique($this->_headers);
		
	}  
	//7.5
	private function _init_system_and_attributes(){
		global $APP;
		# identify system values from the database structure
		$this->_system_attributes = array();
		$schema = $APP->SCHEMA->get("user");
		reset($schema);
		while (list ($key,$val) = each ($schema)) {
			if (!ereg("^sys",$val[1])) {
		    	$this->_system_attributes[strtolower($val[1])] = $key;
		  	} #elseif (ereg("sysexp:(.*)",$val[1],$regs)) {
		    	#$system_attributes[strtolower($regs[1])] = $key;
		  	#}
		}
	    $req = $this->db->sql_query(sprintf('select * from %s order by listorder,name',$this->db->get_table("attribute")));
		while ($row = $this->db->sql_fetch_array($req)) {
		    $this->_attributes[$row["id"]] = $row["name"];
		}
		
		$this->_used_system_attributes = array();
		$this->_used_attributes = array();
		
		for ($i=0;$i<sizeof($this->_headers);$i++) {
		    
		    $column = $this->_clean($this->_headers[$i]);
		    #print $i."<h1>$column</h1>".$_POST['column'.$i].'<br/>';
		    $column = preg_replace('#/#','',$column);
		    
		    if (in_array(strtolower($column),array_keys($this->_system_attributes))) {
			    #print "System $column => $i<br/>";
			    $this->_session->push('systemindex',array(strtolower($column) => $i));
			    array_push($this->_used_system_attributes,strtolower($column));
		    } elseif (strtolower($column) == "list membership" || (isset($this->_params['column'.$i]) && $this->_params['column'.$i] == 'skip')) {
			    # skip this one
		    	$this->_session->push('import_attribute',array($column => array("index"=>$i,"record"=>'skip',"column" => "$column")));
		       	array_push($this->_used_system_attributes,strtolower($column));
		    } else {
		      
		      $import_attribute = $this->_session->get("import_attribute");
		      if (isset($import_attribute[$column]["record"]) && $import_attribute[$column]["record"]) {
		        # mapping has been defined
		      } elseif (isset($this->_params['column'.$i])) {
		        $this->_session->push('import_attribute',array($column => array("index"=>$i,"record"=>$_POST["column$i"],"column" => "$column")));
		      } else {
		      	$sql = ("select id from ".$this->db->get_table("attribute")." where name = \"$column\"");
		        //echo $sql;die();
		        $existing = $this->db->sql_fetch_row_query($sql);
		        $this->_session->push('import_attribute',array($column => array("index"=>$i,"record"=>$existing[0],"column" => $column)));
		        array_push($this->_used_attributes,$existing[0]);
		      }
		    
		    }
		    
		 }
		 
		 //print_r($this->_used_system_attributes);die;
	}
	//7.7
	private function _check_systemindex_email(){
		$systemindex = $this->_session->get("systemindex");
		if (isset($systemindex["email"])) {
		    $this->_fatal_error('Cannot find column with email, please make sure the column is called &quot;email&quot; and not eg e-mail');
		}
	}
	
	//7.8
	private function _temp_used_attributes(){
		//TODO : used_attributes 
		/*
		if(sizeof($used_attributes)>0){
			$unused_systemattr = array_diff(array_keys($system_attributes),$used_systemattr);
			$unused_attributes = array_diff(array_keys($attributes),$used_attributes);
			$options = '<option value="new">-- '.$GLOBALS['I18N']->get('Create new one').'</option>';
			$options .= '<option value="skip">-- '.$GLOBALS['I18N']->get('Skip Column').'</option>';
			foreach ($unused_systemattr as $sysindex) {
			    $options .= sprintf('<option value="%s">%s</option>',$sysindex,substr($system_attributes[$sysindex],0,25));
			}
			foreach ($unused_attributes as $attindex) {
			    $options .= sprintf('<option value="%s">%s</option>',$attindex,substr(stripslashes($attributes[$attindex]),0,25));
			}
			
			$ls = new WebblerListing($GLOBALS['I18N']->get('Import Attributes'));
			$request_mapping = 0;
			foreach ($_SESSION["import"]["import_attribute"] as $column => $rec) {
			    if (trim($column) != '' && !$rec["record"]) {
			      $request_mapping = 1;
			      $ls->addElement($column);
			      $ls->addColumn($column,$GLOBALS['I18N']->get('select'),'<select name="column'.$rec["index"].'">'.$options.'</select>');
			    }
			}
			if ($request_mapping) {
			    $ls->addButton($GLOBALS['I18N']->get('Continue'),'javascript:document.importform.submit()');
			    print '<p>'.$GLOBALS['I18N']->get('Please identify the target of the following unknown columns').'</p>';
			    print '<form name="importform" method="post">';
			    print $ls->display();
			    print '</form>';
			    return;
			}
		}
		*/
		
		/*
		if (isset($_SESSION["import"]["test_import"]) && $_SESSION["import"]["test_import"]) {
			if(isset($_SESSION["import"]["import_attribute"]) && is_array($_SESSION["import"]["import_attribute"])){
				foreach ($_SESSION["import"]["import_attribute"] as $column => $rec) {
			    	if (trim($column) != '') {
			      	//$ls->addElement($column);
			      		if ($rec["record"] == "new") {
			        		//$ls->addColumn($column,$GLOBALS['I18N']->get('maps to'),$GLOBALS['I18N']->get('Create new Attribute'));
			     		} elseif ($rec["record"] == "skip") {
			        		//$ls->addColumn($column,$GLOBALS['I18N']->get('maps to'),$GLOBALS['I18N']->get('Skip Column'));
			      	} else {
			        	//$ls->addColumn($column,$GLOBALS['I18N']->get('maps to'),$attributes[$rec["record"]]);
			      	}
			    }
			}
		}
		 //print $ls->display();
		  
		 */
		
	}
	//step 8.1
	private function _check_max_size(){
		if (sizeof($this->_emails) > 300){//TODO IMPORTANT :  && !$_SESSION["import"]["test_import"]) {
		    print "troppe mail";exit;//TODO: fix this
		    # this is a possibly a time consuming process, so show a progress bar
		    #print '<script language="Javascript" type="text/javascript"> document.write(progressmeter); start();</script>';
		    flush();
		    # increase the memory to make sure we are not running out
		    ini_set("memory_limit","16M");
		}
	}
	//step 8.2
	private function _set_system_attributes(){
		$system_index = $this->_session->get('systemindex');
		reset($this->_system_attributes);
		foreach ($this->_system_attributes as $key => $val) {
		 	#   print "<br/>$key => $val ".$_SESSION["systemindex"][$key];
		    if (isset($system_index[$key]))
		      	$this->_system_attribute_mapping[$key] = $system_index[$key];
		}
	}
	//step 8.3
	private function _init_count(){
		$this->_count = array();
		$this->_count["email_add"] = 0;
		$this->_count["exist"] = 0;
		$this->_count["list_add"] = 0;
		$this->_count["group_add"] = 0;
		$this->_count["invalid_email"] = 0;
		$this->_count["emailmatch"] = 0;
		$this->_count["fkeymatch"] = 0;
		$this->_count["dataupdate"] = 0;
	}
	//step CONFIRM HTML
	private function _prepare_confirm_html(){
		# print "<br/><b>$index</b><br/>";
		$html = '';
		foreach ($user["systemvalues"] as $column => $value) {
				if ($value) {
					$html .= "$column -> $value<br/>\n";
				} else {
					$html .= "$column -> ".$GLOBALS['I18N']->get('clear value')."<br/>\n";
				}
		}
		if(isset($_SESSION["import"]["import_attribute"]) && is_array($_SESSION["import"]["import_attribute"])){
			reset($_SESSION["import"]["import_attribute"]);
			foreach ($_SESSION["import"]["import_attribute"] as $column => $item) {
				if ($user[$item["index"]]) {
					if ($item["record"] == "new") {
						$html .= ' '.$GLOBALS['I18N']->get('New Attribute').': '.$item["column"];
					} elseif ($item["record"] == "skip") {
					# forget about it
						$html .= ' '.$GLOBALS['I18N']->get('Skip value').': ';
					} else {
						$html .= $attributes[$item["record"]];
					}
					$html .= " -> ".$user[$item["index"]]."<br>";
				}
			}
		}
		if ($html) $test_html .= '<blockquote>'.$html.'</blockquote>';
	}
	
	// STEP : ATTRIBUTE create new attributes
	private function _add_attribute(){
	      if(isset($_SESSION["import"]["import_attribute"]) && is_array($_SESSION["import"]["import_attribute"])){
		      foreach ($_SESSION["import"]["import_attribute"] as $column => $item) {
		        if ($item["record"] == "new") {

		          $this->db->sql_query(sprintf('insert into %s (name,type) values("%s","textline")',
		            $tables["attribute"],addslashes($column)));
		          $attid = Sql_Insert_id();

		          $this->db->sql_query(sprintf('update %s set tablename = "attr%d" where id = %d',
		            $tables["attribute"],$attid,$attid));

		          $this->db->sql_query("create table ".$GLOBALS["table_prefix"]."listattr_attr".$attid."
			            (id integer not null primary key auto_increment, name varchar(255) unique,
			            listorder integer default 0)");
			          $_SESSION["import"]["import_attribute"][$column]["record"] = $attid;
		        }
		      }
	      }
	}		      
	
	//STEP check exist
	private function _check_exists(){
		if (isset($user["systemvalues"]["foreign key"])) {
			$result = Sql_query(sprintf('select id,uniqid from %s where foreignkey = "%s"',
			$tables["user"],$user["systemvalues"]["foreign key"]));
			
			# print "<br/>Using foreign key for matching: ".$user["systemvalues"]["foreign key"];
			$count["fkeymatch"]++;
			$exists = Sql_Affected_Rows();
			$existing_user = Sql_fetch_array($result);
			# check whether the email will clash
			$clashcheck = $this->db->sql_fetch_row_query(sprintf('select id from %s
			  where email = "%s"',$tables["user"],$user["systemvalues"]["email"]));
			
			if ($clashcheck[0] != $existing_user["id"]) {
				$duplicatecount++;
			  	$notduplicate = 0;
			  	$c=0;
			  	while (!$notduplicate) {
			    	$c++;
			    	$req = $this->db->sql_query(sprintf('select id from %s where email = "%s"',
			  		$tables["user"],$GLOBALS['I18N']->get('duplicate')."$c ".$user["systemvalues"]["email"]));
			    	$notduplicate = !Sql_Affected_Rows();
			  	}
			  	if (!$_SESSION["import"]["retainold"]) {
					$this->db->sql_query(sprintf('update %s set email = "%s" where email = "%s"',
			  		$tables["user"],"duplicate$c ".$user["systemvalues"]["email"],$user["systemvalues"]["email"]));
					addUserHistory("duplicate$c ".$user["systemvalues"]["email"],"Duplication clash ",' User marked duplicate email after clash with imported record');
			  	} else {
			    	if ($_SESSION["import"]["show_warnings"]) print Warn($GLOBALS['I18N']->get('Duplicate Email').' '.$user["systemvalues"]["email"]. $GLOBALS['I18N']->get(' user imported as ').'&quot;'.$GLOBALS['I18N']->get('duplicate')."$c ".$user["systemvalues"]["email"]."&quot;");
						$user["systemvalues"]["email"] = $GLOBALS['I18N']->get('duplicate')."$c ".$user["systemvalues"]["email"];
			    }
			}
		
		} else {
			$result = Sql_query(sprintf('select id,uniqid from %s where email = "%s"',$tables["user"],$user["systemvalues"]["email"]));
			# print "<br/>Using email for matching: ".$user["systemvalues"]["email"];
			$count["emailmatch"]++;
			$exists = Sql_Affected_Rows();
			$existing_user = Sql_fetch_array($result);
  		}
	}
	
	//STEP add record
	private function _add_record(){
		if ($exists) {
			// User exist, remember some values to add them to the lists
		    $count["exist"]++;
		    $userid = $existing_user["id"];
		    $uniqid = $existing_user["uniqid"];
		} else {
			// user does not exist
		    $new = 1;
		    // Create unique number
		    mt_srand((double)microtime()*1000000);
			$randval = mt_rand();
			# this is very time consuming when importing loads of users as it does a lookup
			# needs speeding up if possible
			$uniqid = getUniqid();
			$confirmed = $_SESSION["import"]["notify"] != "yes" && !preg_match("/Invalid Email/i",$index);
	
			$query = sprintf('INSERT INTO %s (email,entered,modified,confirmed,uniqid)
				values("%s",now(),now(),%d,"%s")',
				$tables["user"],$user["systemvalues"]["email"],$confirmed,$uniqid);
			$result = Sql_query($query,1);
			$userid = Sql_insert_id();
			if (!$userid) {
				# no id returned, so it must have been a duplicate entry
				if ($_SESSION["import"]["show_warnings"]) print Warn($GLOBALS['I18N']->get('Duplicate Email').' '.$user["systemvalues"]["email"]);
					$c = 0;
					while (!$userid) {
						$c++;
						$query = sprintf('INSERT INTO %s (email,entered,modified,confirmed,uniqid)
							values("%s",now(),now(),%d,"%s")',
							$tables["user"],$user["systemvalues"]["email"]." ($c)",0,$uniqid);
						$result = Sql_query($query,1);
						$userid = Sql_insert_id();
					}
					$user["systemvalues"]["email"] = $user["systemvalues"]["email"]." ($c)";
				}
	
			$count["email_add"]++;
			$some = 1;
		}
	}
	
	//STEP TODO : ATTRIBUTES
	private function _temp_set_attributes(){
		return;
		if(isset($_SESSION["import"]["import_attribute"]) && is_array($_SESSION["import"]["import_attribute"])){
			reset($_SESSION["import"]["import_attribute"]);
		  	if ($new || (!$new && $_SESSION["import"]["overwrite"] == "yes")) {
			    $query = "";
			    $count["dataupdate"]++;
			    $old_data = $this->db->sql_fetch_array_query(sprintf('select * from %s where id = %d',$tables["user"],$userid));
			    $old_data = array_merge($old_data,getUserAttributeValues('',$userid));
			    $history_entry = 'http://'.getConfig("website").$GLOBALS["adminpages"].'/?page=user&id='.$userid."\n\n";
			
			    foreach ($user["systemvalues"] as $column => $value) {
			      $query .= sprintf('%s = "%s",',$system_attributes[$column],$value);
			    }
			    if ($query) {
			      $query = substr($query,0,-1);
			      # this may cause a duplicate error on email, so add ignore
			      $this->db->sql_query("update ignore {$tables["user"]} set $query where id = $userid");
			    }
		    
			    foreach ($_SESSION["import"]["import_attribute"] as $item) {
			      if ($user[$item["index"]] && $item['record'] != 'skip') {
			        $attribute_index = $item["record"];
			        $uservalue = $user[$item["index"]];
			        # check whether this is a textline or a selectable item
			        $att = $this->db->sql_fetch_row_query("select type,tablename,name from ".$tables["attribute"]." where id = $attribute_index");
			        switch ($att[0]) {
			          case "select":
			          case "radio":
			            $val = $this->db->sql_query("select id from $table_prefix"."listattr_$att[1] where name = \"$uservalue\"");
			            # if we do not have this value add it
			            if (!Sql_Affected_Rows()) {
			              $this->db->sql_query("insert into $table_prefix"."listattr_$att[1] (name) values(\"$uservalue\")");
			              Warn("Value $uservalue added to attribute $att[2]");
			              $user_att_value = Sql_Insert_Id();
			            } else {
			              $d = Sql_Fetch_Row($val);
			              $user_att_value = $d[0];
			            }
			            break;
			          case "checkbox":
			            if ($uservalue && $uservalue != "off")
			              $user_att_value = "on";
			            else
			              $user_att_value = "off";
			            break;
			          case "date":
			            $user_att_value = parseDate($uservalue);
			            break;
			          default:
			            $user_att_value = $uservalue;
			            break;
			        }
			
			        Sql_query(sprintf('replace into %s (attributeid,userid,value) values(%d,%d,"%s")',
			          $tables["user_attribute"],$attribute_index,$userid,$user_att_value));
			      } else {
			        if ($item["record"] != "skip") {
			          # add an empty entry if none existed
			          $this->db->sql_query(sprintf('insert ignore into %s (attributeid,userid,value) values(%d,%d,"")',
			            $tables["user_attribute"],$item["record"],$userid));
			        }
			      }
			    }
			    
			    $current_data = $this->db->sql_fetch_array_query(sprintf('select * from %s where id = %d',$tables["user"],$userid));
			    $current_data = array_merge($current_data,getUserAttributeValues('',$userid));
			    foreach ($current_data as $key => $val) {
			      if (!is_numeric($key))
			      if ($old_data[$key] != $val && $old_data[$key] && $key != "password" && $key != "modified") {
			        $information_changed = 1;
			        $history_entry .= "$key = $val\n*changed* from $old_data[$key]\n";
			      }
			    }
				    
			    if (!$information_changed) {
			      $history_entry .= "\nNo user details changed";
			    }
		    	
		    	addUserHistory($user["systemvalues"]["email"],"Import by ".adminName(),$history_entry);
		      }
		  }
	}
	//STEP LISTS
	private function _set_lists($userid,$listid, $user){//TODO:$userid,$listid,$user
		global $APP;
		#add this user to the lists identified
		$lists = $this->_session->get("lists");
		$listnames = $this->_session->get("listname");
		if (is_array($lists)) {
			reset($lists);
		    $addition = 0;
		    $listoflists = "";
		    while (list($key,$listid) = each($lists)) {
		    	$query = "replace INTO ".$this->db->get_table("listuser")." (userid,listid,entered) values($userid,$listid,now())";
		        $result = $this->db->sql_query($query);
		        # if the affected rows is 2, the user was already subscribed
		        $addition = $addition || $this->db->sql_affected_rows() == 1;
		        $listoflists .= "  * ".$listnames[$key]."\n";
		   	}
		    if ($addition)
		    	$this->_count["list_add"]++;
			
			if (!TEST && $this->_session->get("notify") == "yes" && $addition) {
		    	$subscribemessage = ereg_replace('\[LISTS\]', $listoflists, $APP->CONF->get("subscribemessage"),$userid);
		        $APP->MAILER->send_mail($user["systemvalues"]["email"], 
		        				   $APP->CONF->get("subscribesubject"), 
		        				   $subscribemessage, 
		       	 				   system_messageHeaders(),
		       	 				   MESSAGE_ENVELOPE);
			}
		}
	}
	//STEP TODO
	private function _temp_set_groups(){
		if (!is_array($this->_session->get("groups"))) {
			$groups = array();
		} else {
			$groups = $_SESSION["import"]["groups"];
		}
		if (isset($everyone_groupid) && !in_array($everyone_groupid,$groups)) {
			array_push($groups,$everyone_groupid);
		}
		if (is_array($groups)) {
		    #add this user to the groups identified
		    reset($groups);
		    $groupaddition = 0;
		    while (list($key,$groupid) = each($groups)) {
			    if ($groupid) {
		    		$query = "replace INTO user_group (userid,groupid) values($userid,$groupid)";
		    		$result = Sql_query($query);
		    		# if the affected rows is 2, the user was already subscribed
		    		$groupaddition = $groupaddition || Sql_Affected_Rows() == 1;
		    	}
		    }
		    if ($groupaddition)
				$this->_count["group_add"]++;
		}
	}
	//STEP FINAL
	private function _send_report(){
		
		if (!$this->_session->get('test_import')) { //TODO: fix IMPORTANT
		    $this->_session->set('result_import', true);
		    $report = "";
		    
		    if(!$this->_some && !$this->count["list_add"]) {
		    	$report .= '<br/>'.$this->_('All the emails already exist in the database and are member of the lists');
		    } else {
		    	$report .= sprintf('<br/>'.$this->_('%s emails succesfully imported to the database and added to %d lists.'),
		    	$this->_count["email_add"],$this->_num_lists);
		      	
		      	$report .= sprintf('<br/>'.$this->_('%d emails subscribed to the lists'),$this->_count["list_add"]);
		      	
		      	if ($this->_count["exist"]) {
		        	$report .= sprintf('<br/>'.$GLOBALS['I18N']->get('%s emails already existed in the database'),$this->_count["exist"]);
		     	}
		    }
		    
		    if ($this->_count["invalid_email"]) {
		    	$report .= sprintf('<br/>'.$this->_('%d Invalid Emails found.'),$this->_count["invalid_email"]);
		     	if (!$this->_session->get('omit_invalid')) {
		        	$report .= sprintf('<br/>'.$this->_('These records were added, but the email has been made up from ').$this->_session->get('assign_invalid'));
		      	} else {
		        	$report .= sprintf('<br/>'.$this->_('These records were deleted. Check your source and reimport the data. Duplicates will be identified.'));
		      	}
		    }
		    
		    if ($this->_session->get('overwrite') == "yes") {
		      	$report .= sprintf('<br/>'.$this->_('User data was updated for %d users'),$this->_count["dataupdate"]);
		    }
		    $report .= sprintf('<br/>'.$this->_('%d users were matched by foreign key, %d by email'),$this->_count["fkeymatch"],$this->_count["emailmatch"]);
		    
		    $this->_flash(LOG_MAIL_LEVEL, $this->_(NAME .' '. VERSION . ': Import Results'), br2nl($report));
		    
		    $this->resetimport();
		} else {
		   	$this->_data['esito'] = $this->_('Test output<br/>If the output looks ok, click %s to submit for real');
		}
	}
	//utils
	private function _fatal_error($msg, $lvl = 0){
		$msg = is_numeric(strpos($this->_($msg),"<span>" )) ? $msg : $this->_($msg);//TODO : fix this please!
		$this->_flash($lvl,$msg);
		$this->resetimport();
		$this->_redirect();
	}
	private function _clean ($value) {
  		$value = trim($value);
		$value = ereg_replace("\r","",$value);
		$value = ereg_replace("\n","",$value);
		$value = ereg_replace('"',"&quot;",$value);
		$value = ereg_replace("'","&rsquo;",$value);
		$value = ereg_replace("`","&lsquo;",$value);
		$value = stripslashes($value);
		return $value;
	}
}