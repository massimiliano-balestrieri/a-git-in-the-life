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

class ExportModel{

	public $table = false;
	public $db = false;
	
	
	public function __construct(){
		global $APP;
		$this->table = $APP->DB->get_table('scaffold');
		$this->db = $APP->DB;
	}

	
	public function get(){
		return;
		if(!checkRole("export"))
			myRedirect();
		
		
		include DIRCONF . '/structure.php';
		
		$fromval= !isset($_POST['process']) ? date("d/m/Y", mktime (0,0,0,date("m"),  date("d"),  date("Y")-1)) : $_POST['datefrom'] ;
		$toval= !isset($_POST['process']) ? date("d/m/Y") : $_POST['dateto'];
		
		$list = sprintf('%d',isset($_REQUEST["list"]) ? $_REQUEST['list']:0);
		
		if (isset($_POST['column']) && $_POST['column'] == 'listentered') {
		  $list = sprintf('%d',$_POST['list']);
		}
		
		$role = getRole();
		switch($role){
			case 1://root
			case 2://admin
		    if ($list) {
		      $querytables = $GLOBALS['tables']['user'].' user'.', '.$GLOBALS['tables']['listuser'].' listuser';
		      $subselect = ' and listuser.userid = user.id ';
		    } else {
		      $querytables = $GLOBALS['tables']['user'].' user';
		      $subselect = '';
		    }
		    $listselect_where = '';
		    $listselect_and = '';
			break;
			case 3://master
		    $querytables = $GLOBALS['tables']['list'].' list ,'.$GLOBALS['tables']['user'].' user ,'.$GLOBALS['tables']['listuser'].' listuser ';
		    $subselect = ' and listuser.listid = list.id and listuser.userid = user.id and list.owner = ' . $_SESSION['logindetails']['id'];
		    $listselect_where = ' where owner = ' . $_SESSION['logindetails']['id'];
		    $listselect_and = ' and owner = ' . $_SESSION['logindetails']['id'];
			break;
		}
		
		
		if (isset($_POST['processcsv'])) {
			include_once(DIRACTIONS . "/exportcsv_action.php");
		}
		if (isset($_POST['processxls'])) {
			exit;#include_once(DIRACTIONS . "/exportxls_action.php");
		}
		
		$select_lists = array();
		$sql = sprintf('select * from %s %s',$GLOBALS['tables']['list'],$listselect_where);
		$req = $APP->DB->sql_query($sql);
		while ($row = $APP->DB->sql_fetch_array($req)) {
		  $select_lists[$row['id']] = $row['name'];
		}
		
		//check su utenza master
		if(isRoleMaster() && !array_key_exists($list,$select_lists)){
			myRedirect(getLastPage());
		}
		
		$checkbox_cols = array();
		$no_cols = array("subscribepage","rssfrequency","password","extradata","foreignkey");
		while (list ($key,$val) = each ($DBstruct["user"])) {
		   if(!in_array($key,$no_cols)){
			   if (!ereg("sys",$val[1])) {
			     $checkbox_cols[$key] = $GLOBALS['I18N']->get($val[1]);
			   } elseif (ereg("sysexp:(.*)",$val[1],$regs)) {
			     $checkbox_cols[$key] = $GLOBALS['I18N']->get($regs[1]);
			   }
		   }
		}
		
		$res = $APP->DB->sql_query("select id,name,tablename,type from {$APP->DB->get_table['attribute']} order by listorder");
		$checkbox_attributes = array();
		while ($row = $APP->DB->sql_fetch_array($res)) {
		   $checkbox_attributes[$row["id"]] = stripslashes($row["name"]);
		}
				
	}
	
	private function old(){
		return;
		if(!checkRole("export"))
			myRedirect();
		
		if (isset($_POST['processcsv'])) {
		  $fromval = date("Y-m-d",strtotime(dateItToEn($_POST['datefrom'])));
		  $toval = date("Y-m-d",strtotime(dateItToEn($_POST['dateto'])));
		  $cols = $_POST['cols'];
		  $attrs = @$_POST['attrs'];
		  
		  if ($list)
		    $filename = sprintf($GLOBALS['I18N']->get('ExportOnList'),ListName($list),$fromval,$toval,date("Y-M-d"));
		  else
		    $filename = sprintf($GLOBALS['I18N']->get('ExportFromval'),$fromval,$toval,date("Y-M-d"));
		  @ob_end_clean();
		  $filename = trim(strip_tags($filename));
		
		  #header("Content-type: text/html");
		  header("Content-type: ".$GLOBALS["export_mimetype"]);
		  header("Content-disposition:  attachment; filename=\"$filename\"");
		  $col_delim = "\t";
		  if (EXPORT_EXCEL) {
		    $col_delim = ",";
		  }
		  $row_delim = "\n";
		
		  if (is_array($cols)) {
		    while (list ($key,$val) = each ($DBstruct["user"])) {
		      if (in_array($key,$cols)) {
		        if (!ereg("sys",$val[1])) {
		          print $val[1].$col_delim;
		        } elseif (ereg("sysexp:(.*)",$val[1],$regs)) {
		          print $regs[1].$col_delim;
		        }
		      }
		    }
		   }
		  $attributes = array();
		  if (is_array($attrs)) {
		    $res = $this->db->sql_query("select id,name,type from {$tables['attribute']}");
		    while ($row = Sql_fetch_array($res)) {
		      if (in_array($row["id"],$attrs)) {
		        print trim(stripslashes($row["name"])) .$col_delim;
		        array_push($attributes,array("id"=>$row["id"],"type"=>$row["type"]));
		      }
		    }
		  }
		  print $GLOBALS['I18N']->get('ListMembership').$row_delim;
		  if ($_POST['column'] == 'listentered') {
		    $column = 'listuser.entered';
		  } else {
		    switch ($_POST['column']) {
		      case 'entered':$column = 'user.entered';
		      default: $column = 'user.modified';
		    }
		  }
		  if ($list) {
		    $sql = sprintf('select user.* from
		      %s where user.id = listuser.userid and listuser.listid = %d and %s >= "%s 00:00:00" and %s  <= "%s 23:59:59" %s
		      ',$querytables,$list,$column,$fromval,$column,$toval,$subselect);
		  } else {
		    $sql = sprintf('
		      select * from %s where %s >= "%s 00:00:00" and %s  <= "%s 23:59:59" %s',
		      $querytables,$column,$fromval,$column,$toval,$subselect);
		  }
		  #echo $sql;die();
		  $result = $this->db->sql_query($sql);
		# print Sql_Affected_Rows()." users apply<br/>";
		  while ($user = Sql_fetch_array($result)) {
		    @set_time_limit(500);
		    reset($cols);
		    while (list ($key,$val) = each ($cols))
		      print strtr($user[$val],$col_delim,",").$col_delim;
		    reset($attributes);
		    while (list($key,$val) = each ($attributes)) {
		      $value = UserAttributeValue($user["id"],$val["id"]);
		      $enclose = 0;
		      if (ereg('"',$value)) {
		        $value = ereg_replace('"','""',$value);
		        $enclose = 1;
		      }
		      if (ereg($col_delim,$value)) {
		        $enclose = 1;
		      }
		      if (ereg($row_delim,$value)) {
		        $enclose = 1;
		      }
		      if ($enclose) {
		        $value = '"'.$value .'"';
		      }
		      print $value.$col_delim;
		    }
		    $lists = Sql_query("select listid,name from
		      {$tables['listuser']},{$tables['list']} where userid = ".$user["id"]." and
		      {$tables['listuser']}.listid = {$tables['list']}.id $listselect_and");
		    if (!Sql_Affected_rows($lists))
		      print "No Lists";
		    while ($list = Sql_fetch_array($lists)) {
		      print stripslashes($list["name"])." ";
		    }
		    print $row_delim;
		  }
		  exit;
		}
	}
}
?>