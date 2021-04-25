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

class AttributeModel extends ModuleModel{
	
	public $table = false;
	public $db = false;
	
	
	public function __construct($params = false){
		global $APP;
		$this->user_table = $APP->DB->get_table('attribute');
		$this->db = $APP->DB;
		$this->_params = $params;
	}
	public function get_user_attributes_array(){
		$res = $this->db->sql_query("select id,name,tablename,type from {$this->user_table} order by listorder");
		$ret = array();
		while ($row = $this->db->sql_fetch_array($res)) {
   			$ret[$row["id"]] = stripslashes($row["name"]);
		}
		return $ret;
	}
	public function get_userattribute($id){
		$res = $this->db->sql_query("select * from {$this->user_table} where id = $id");
		$data = $this->db->sql_fetch_array($res);
		$table = TABLE_PREFIX ."listattr_".$data["tablename"];
		switch ($data['type']) {
		  case 'checkboxgroup':
		  case 'select':
		  case 'radio':
		    break;
		  default:
		    $APP->MSG->session_info($APP->I18N->_('This datatype does not have editable values'));
		    $APP->REQUEST->redirect('attribute');
		}
		$result = $this->db->sql_query("SELECT * FROM $table order by listorder,name");
		$num = $this->db->sql_affected_rows();
		$list_values = array();
		while ($row = $this->db->sql_fetch_array($result)) {
		    $list_values[] = array(
		    					'id'			=>	$row['id'],
		    					'listorder' 	=>	$row['listorder'],
		    					'name'			=>	$row['name'],
		    					'default_value'	=>	$data['default_value'] == $row['name'] ? 1 : 0,
							);
		}
		return array('data'=>$data, 'list_values' => $list_values);
	}
	public function get_userattributes(){
		global $APP;
		$res = $this->db->sql_query("select * from {$this->user_table} order by listorder");
		if (!$this->db->sql_affected_rows()) {
		  $APP->MSG->info('no_attributes');
		  return false;
		}
		
		$c= 0;
		
		$lists_attributes = array();
		while ($row = $this->db->sql_fetch_array($res)) {
		  $c++;
		  $lists_attributes[] = array(
		  								'id'=>$row["id"],
		  								'tag'=>$c,
		  								'name'=>htmlspecialchars(stripslashes($row["name"])),
										'type'=>$row["type"],
										'default'=>htmlspecialchars(stripslashes($row["default_value"])),
										'listorder'=>$row["listorder"],
										'required'=>$row["required"],
										'container' => "attribute_".$row["id"]
		  );
		  
		}
		return $lists_attributes; 
	}
	
	public function admin($params){
		
		$res = $APP->DB->sql_query("select * from {$APP->DB->get_table['adminattribute']} order by listorder");
		if (!Sql_Num_Rows($res)) {
		  addPublicInfo($GLOBALS['I18N']->get('NoAttrYet'));
		}
		$lists_attributes = array();
		while ($row = Sql_Fetch_array($res)) {
		  $lists_attributes[] = array(
		  								'id'=>$row["id"],
		  								'name'=>htmlspecialchars(stripslashes($row["name"])),
										'type'=>$row["type"],
										'default'=>htmlspecialchars(stripslashes($row["default_value"])),
										'listorder'=>$row["listorder"],  								
		  								'required'=>$row["required"],
		  );
		  
		}
	}
	private function old_editusers(){
		return;
				 
		if(!checkRole("editattributes"))
			myRedirect();
		
		if(isSuperUser() || isRoleAdmin()){	
			if (isset($_POST["addnew"])) {
			  $items = explode("\n", $_POST["itemlist"]);
			  $data = getTableAttribute($id);
			  $table = $table_prefix ."listattr_".$data["tablename"];
			  $list = $this->db->sql_fetch_array_query("select listorder from $table order by listorder desc");
			  $lastorder = @$list[0] + 1;
			  while (list($key,$val) = each($items)) {
				$val = clean($val);
			  	if ($val != "") {
			   		$query = sprintf('INSERT into %s (name,listorder) values("%s","%d")',$table,$val,$lastorder++);
			   		$result = Sql_query($query);
			   	}
			  }
		      logEvent(adminName() . " ha aggiunto un valore all'attributo ". $data["tablename"]);
		      addPublicSessionInfo("I valori sono stati aggiunti");
			  myRedirect("view=editattributes&id=".$id);
			}
			if (isset($_POST['action']) && $_POST['action'] != $GLOBALS['I18N']->get('DelAll') && isset($_POST["listorder"]) && is_array($_POST["listorder"])) {
			  if(sizeof(array_unique($_POST["listorder"])) != sizeof($_POST["listorder"])){
			  	addPublicInfo("L'ordinamento dei valori non &egrave; corretto");
			  	return;
			  }
			  $data = getTableAttribute($id);
			  $table = $table_prefix ."listattr_".$data["tablename"];
			  foreach ($_POST["listorder"] as $key => $val) {
			   	$this->db->sql_query("update $table set listorder = $val where id = $key");
			  }
			  logEvent(adminName() . " ha cambiato l'ordine dei valori all'attributo ". $data["tablename"]);
		      addPublicSessionInfo("L'ordine dei valori &egrave; stato cambiato");
		      myRedirect("view=editattributes&id=".$id);
			}
			
			if (isset($_GET["delete"])) {
				if(isset($_POST["confirm"]) && $_POST["confirm"] == $GLOBALS['I18N']->get('yes')){
					$data = getTableAttribute($id);
			  		$table = $table_prefix ."listattr_".$data["tablename"];
					deleteItem($table,$id,$_GET["delete"]);
				    logEvent(adminName() . " ha eliminato un valore all'attributo ". $data["tablename"]);
		            addPublicSessionInfo("Il valore &egrave; stato eliminato.");
		            myRedirect("view=editattributes&id=".$id);
		      	}elseif(isset($_POST["confirm"]) && $_POST["confirm"] == $GLOBALS['I18N']->get('no')){
		   			myRedirect("view=editattributes&id=".$id);
		   		}
			} 
			if(isset($_POST['delete']) && $_POST['delete'] == $GLOBALS['I18N']->get('DelAll')) {
			  if(isset($_POST["confirm"]) && $_POST["confirm"] == $GLOBALS['I18N']->get('yes')){
				  $data = getTableAttribute($id);
			  	  $table = $table_prefix ."listattr_".$data["tablename"];
				  $count = 0;
				  $errcount = 0;
				  $res = $this->db->sql_query("select id from $table");
				  while ($row = Sql_Fetch_Row($res)) {
				    if (deleteItem($table,$id,$row[0])) {
				      $count++;
				    } else {
				      $errcount++;
				      if ($errcount > 10) {
				        print $GLOBALS['I18N']->get('TooManyErrors')."<br /><br /><br />\n";
				        break;
				      }
				    }
				  }
		   		  logEvent(adminName() . " ha eliminato tutti i valori all'attributo ". $data["tablename"]);
		          addPublicSessionInfo("Tutti i valori sono stati eliminati.");
		          myRedirect("view=editattributes&id=".$id);
			  }elseif(isset($_POST["confirm"]) && $_POST["confirm"] == $GLOBALS['I18N']->get('no')){
		   	  	myRedirect("view=editattributes&id=".$id);
			  }
			}
		}
	}
	private function old_users(){
		return;
				 
		if(!checkRole("attributes"))
			myRedirect();
		
		if(isSuperUser() || isRoleAdmin()){	
			if (isset($_POST["save"])) {
			  if (isset($_POST["name"])) {
			    while (list($id,$val) = each ($_POST["name"])) {
			      if (!$id && isset($_POST["name"][0]) && $_POST["name"][0] != "") {
			      	//echo "qui quando sono nuovo";die();
			        # it is a new one
			       //_new()
			      } elseif ($_POST["name"][$id] != "") {
			        //echo "qui quando cambio qualcosa";die();
			        //disabilitato il cambio di tipo: troppo pericoloso!
			        # it is a change
			        if(isset($_POST["save"][$id])){
			        	isset($_POST["required"][$id]) ? $required = 1 : $required = 0; 
			        	$query = sprintf('update %s set name = "%s" ,listorder = %d,default_value = "%s" ,required = %d where id = %d',
			        	$tables["attribute"],addslashes($_POST["name"][$id]),$_POST["listorder"][$id],$_POST["default"][$id],$required,$id);
			        	$this->db->sql_query($query);
			        }
			        
			        addPublicSessionInfo("Attributo modificato");
			  		logEvent("Attributo ".addslashes($_POST["name"][$id])." modificato da ".adminName());
			    	myRedirect("view=attributes");
			        
			      }
			    }
			    //myRedirect("view=attributes");
			  }
			} 
		}
	}
	private function old_admins(){
		return;
		
		if(!checkRole("adminattributes"))
			myRedirect();
		
		if(isSuperUser() || isRoleAdmin()){
			if (isset($_POST["save"])) {
			  if (isset($_POST["name"])) {
			    while (list($id,$val) = each ($_POST["name"])) {
			      if (!$id && isset($_POST["name"][0]) && $_POST["name"][0] != "") {
			        # it is a new one
			        $lc_name = substr(preg_replace("/\W/","", strtolower($_POST["name"][0])),0,10);
			        $this->db->sql_query("select * from {$tables['adminattribute']} where tablename = \"$lc_name\"");
			        if (Sql_Affected_Rows()) Csi_Fatal_Error($GLOBALS['I18N']->get('NameNotUnique'));
					
					isset($_POST["required"][0]) ? $required = 1 : $required = 0; 
			        
			        $query = sprintf('insert into %s
			        (name,type,listorder,default_value,required,tablename)
			        values("%s","%s",%d,"%s",%d,"%s")',
			        $tables["adminattribute"],
			        addslashes($_POST["name"][0]),
			        $_POST["type"][0],
			        $_POST["listorder"][0],
			        addslashes($_POST["default"][0]),
			        $required,
			        $lc_name);
			        $this->db->sql_query($query);
			        $insertid = Sql_Insert_id();
			
			        # text boxes and hidden fields do not have their own table
			        if ($_POST["type"][$id] != "textline" && $_POST["type"][$id] != "hidden" && $_POST["type"][$id] != "checkbox"  && $_POST["type"][$id] != "textarea" ) {
			          $query = "create table $table_prefix"."adminattr_$lc_name
			          (id integer not null primary key auto_increment,
			          name varchar(255) unique,listorder integer default 0)";
			          $this->db->sql_query($query);
			        } else {
			          # and they cannot currently be required, changed 29/08/01,
			          # insert javascript to require them, except for hidden ones :-)
			          if (!empty($_POST["type"]["id"]) && $_POST["type"]["id"] == "hidden")
			            $this->db->sql_query("update {$tables['attribute']} set required = 0 where id = $insertid");
			        }
			 /*       if ($_POST["type"][$id] == "checkbox") {
			          # with a checkbox we know the values
			          $this->db->sql_query'insert into '.$table_prefix.'adminattr_'.$lc_name.' (name) values("Checked")');
			          $this->db->sql_query'insert into '.$table_prefix.'adminattr_'.$lc_name.' (name) values("Unchecked")');
			          # we cannot "require" checkboxes, that does not make sense
			          $this->db->sql_query("update {$tables['adminattribute']} set required = 0 where id = $insertid");
			        }
			*/
					addPublicSessionInfo("Attributo Inserito.");
					logEvent("Attributo amministrativo ".$_POST["name"][0]." inserito da ".adminName());
					myRedirect("view=adminattributes");
			      } elseif (!empty($_POST["name"][$id])) {
			      	isset(
			      	$_POST["required"][$id]) ? $required = 1 : $required = 0;
			      	# it is a change
			        $query = sprintf('update %s set name = "%s" ,listorder = %d,default_value = "%s" ,required = %d where id = %d',
			        $tables["adminattribute"],addslashes($_POST["name"][$id]),
			        $_POST["listorder"][$id],$_POST["default"][$id],$required,$id);
			        $this->db->sql_query($query);
			        addPublicSessionInfo("Attributo Modificato.");
			        logEvent("Attributo amministrativo ".addslashes($_POST["name"][$id])." modificato da ".adminName());
					myRedirect("view=adminattributes");
			      }
			    }
			  }
			} elseif (isset($_POST["delete"])) {
			    if(isset($_POST["confirm"]) && $_POST["confirm"] == $GLOBALS['I18N']->get('yes')){
				    while (list($id,$val) = each ($_POST["delete"])) {
				      $res = $this->db->sql_query("select tablename,type,name from {$tables['adminattribute']} where id = $id");
				      $row = Sql_Fetch_Row($res);
				      if ($row[1] != "hidden" && $row[1] != "textline" && $row[1] != "checkbox" && $row[1] != "textarea")
				        $this->db->sql_query("drop table $table_prefix"."adminattr_$row[0]");
				      $this->db->sql_query("delete from {$tables['adminattribute']} where id = $id");
				      # delete all admin attributes as well
				      $this->db->sql_query("delete from {$tables['admin_attribute']} where adminattributeid = $id");
				      
				      addPublicSessionInfo("Attributo Eliminato.");
					  logEvent("Attributo amministrativo ".addslashes($row[2])." eliminato da ".adminName());
					  myRedirect("view=adminattributes");
				   }
			   }elseif(isset($_POST["confirm"]) && $_POST["confirm"] == $GLOBALS['I18N']->get('no')){
			   		myRedirect("view=adminattributes");
			   }
			}
		}
	}
}