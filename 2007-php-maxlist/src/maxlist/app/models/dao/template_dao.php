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

class TemplateDao extends ModuleDao {

	public $table = false;
	public $db = false;
	
	//PRIVATE - help methods update
	private $_baseurl = false;
	private $_check_images_exist = false;
	private $_check_full_images = false;
	private $_check_full_links = false;
 	private $_title = false;
	private $_content = false;
	private $_can_test_remote_images = false;

	public function __construct($params) {
		global $APP;
		$this->db = $APP->DB;
		$this->table = $this->db->get_table('template');
		$this->_params = $params;
	}
	public function get_templates() {
		$res = $this->db->query("select * from {$this->table} order by listorder");
		return $res;
	}
	public function get($id) {
		return $this->db->fetch_query("select * from {$this->table} where id = $id");
	}
	
	//POST
	public function update($id){
		$this->_get_params();
		if($this->_pre_checks() && $id)
			return $this->_edit($id);
		else
			return false;
	}
	public function insert(){
		$this->_get_params();
		$id = false;
		if($this->_pre_checks()){
			$id = $this->db->insert("replace into {$this->table} (title, template) values(\"Untitled Template\", \"[CONTENT]\")");
		}
		if($id){
			//$this->_edit($id);
			return $id;
		}
		return false;
	}
	public function delete($delete){
		# delete the index in delete
		$aff = $this->db->execute("delete from ".$this->table." where id = $delete");
		$aff2 = $this->db->execute("delete from ".$this->db->get_table("templateimage")." where template = $delete");
		return $aff;
	}
	public function set_default(){
		global $APP;
	  	$default = $this->_param_in('template', 'id');
	  	return $APP->get_model2("configure")->save('default_message_template',sprintf('%d',$default));
	}
	//VALIDATE
	public function check_unique_title($title, $id){
		$res = $this->db->fetch_query("select count(*) from {$this->table} where title = \"$title\" and id <> $id");
		return $res[0] == 0 ? true : false;
	}
	//PRIVATE
	//help update e insert
	private function _pre_checks(){
		$templateok = $this->_check_images() && $this->_check_full_links();
		if (!$templateok) {
			$this->_info($this->_('Some errors were found, template NOT saved!'));
		}
		return $templateok;
	}
	//help update e insert
	private function _edit($id){
		$aff = $this->db->execute(sprintf('update %s set title = "%s",template = "%s" where id = %d',
		       							$this->table,
		       							$this->_title,
		       							addslashes($this->_content),
		      							$id));
		//TODO : 
		/***
		$this->db->sql_query(sprintf('select * from %s where filename = "%s" and template = %d',
		    							$this->db->get_table("templateimage"),
										LOGO_IMG,$id));
		*/							
		//TODO : $this->_uploads_image();
		return $aff;
	}
	//help update e insert
	private function _get_params(){
		$this->_baseurl = '';
		$this->_check_images_exist = $this->_param_in('template', 'check_images_exist');
		$this->_check_full_images = $this->_param_in('template', 'check_full_images');
		$this->_check_full_links = $this->_param_in('template', 'check_full_links');
 		$this->_title = $this->_param_in('template', 'title');
		$this->_content = $this->_param_in('template', 'content');
		$this->_can_test_remote_images = ini_get('allow_url_fopen');
		
		$this->_set_content();
	}
	//TODO 
	//prechecks help update e insert
	private function _check_full_links(){
		return true;
		//TODO :
		/***
		if ($check_full_links) {
			$links = $this->_get_template_links($content);
			foreach ($links as $key => $val) {
				if (!preg_match("#^https?://#i",$val) && !preg_match("#^mailto:#i",$val)) {
					$this->_info($this->_("Not a full URL:")." $val");
					$templateok = 0;
				}
			}
		}
		*/
	}
	private function _check_images(){
		return true;
		//TODO :
		/****
		//TODO : $images = $this->_get_template_images($content);
		if (($check_full_images || $check_images_exist) && sizeof($images)) {
			foreach ($images as $key => $val) {
				if (!preg_match("#^https?://#i",$key)) {
					if ($check_full_images) {
						$this->_info($this->_("Image")." $key => ".$this->_("not full URL"));
						$templateok = 0;
					}
				} else {
					if ($check_images_exist) {
						if ($can_test_remote_images) {
							$fp = @fopen($key,"r");
							if (!$fp) {
								$this->_info($this->_("Image")." $key => ".$this->_("does not exist"));
								$templateok = 0;
							}
							@fclose($fp);
						} else {
							$this->_info($this->_("Image")." $key => ".$this->_('cannot check, "allow_url_fopen" disabled in PHP settings'));
						}
					}
				}
			}
		}*/
	}
	private function _temp_addimages(){
		//TODO : addimages
		/****
		 * 
		if (!empty($_POST['action']) && $_POST['action'] == "addimages") {
		  if (!$id)
		    $msg = $GLOBALS['I18N']->get("No such template");
		  else {
		    $content_req = $this->db->sql_fetch_row_query("select template from {$tables["template"]} where id = $id");
		    $images = getTemplateImages($content_req[0]);
		    if (sizeof($images)) {
		      include "class.image.inc";
		      $image = new imageUpload();
		      while (list($key,$val) = each ($images)) {
		       # printf('Image name: <b>%s</b> (%d times used)<br />',$key,$val);
		        $image->uploadImage($key,$id);
		      }
		      $msg = $GLOBALS['I18N']->get("Images stored");
		    } else
		      $msg = $GLOBALS['I18N']->get("No images found");
		  }
		  addPublicInfo($msg);
		  return;
		} elseif (!empty($_POST['save'])) {
			 */
	}
	private function _uploads_image(){
		//TODO:
		/****
  		if (sizeof($images)) {
		    include dirname(__FILE__) . "/class.image.inc";
		    $image = new imageUpload();
		    print "<h3>".$GLOBALS['I18N']->get("Images")."</h3><p>".$GLOBALS['I18N']->get("Below is the list of images used in your template. If an image is currently unavailable, please upload it to the database.")."</p>";
		    print "<p>".$GLOBALS['I18N']->get("This includes all images, also fully referenced ones, so you may choose not to upload some. If you upload images, they will be included in the emails that use this template.")."</p>";
		    print formStart('enctype="multipart/form-data"');
		    print '<input type=hidden name="id" value="'.$id.'">';
		    ksort($images);
		    reset($images);
		    while (list($key,$val) = each ($images)) {
		    printf($GLOBALS['I18N']->get("Image name:").' <b>%s</b> (%d '.$GLOBALS['I18N']->get("times used").')<br/>',$key,$val);
		    print $image->showInput($key,$val,$id);
	    }
		<input type=hidden name="id" value="'.$id.'"><input type=hidden name="action" value="addimages"><input type=submit name="addimages" value="'.$GLOBALS['I18N']->get("Save Images").'"></form>
		else
		$this->_info($this->_("Template does not contain local images"));
			      
		 */
	}
	private function _get_template_images($content){
		//TODO:
	}
	private function _get_template_links($content){
		//TODO:
	}
	private function _set_content(){
		//TODO : file
		/**** 
		if (!empty($_FILES['file_template']) && is_uploaded_file($_FILES['file_template']['tmp_name'])) {
		  $content = file_get_contents($_FILES['file_template']['tmp_name']);
		} elseif (isset($_POST['content'])) {
		  $content = $_POST['content'];
		} else {
		  $this->content = '';
		}*/
	}
}