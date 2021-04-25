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
 * $Id:scaffold_controller.php 264 2007-11-16 19:25:56Z maxbnet $
 * $LastChangedDate:2007-11-16 20:25:56 +0100 (ven, 16 nov 2007) $
 * $LastChangedRevision:264 $
 * $LastChangedBy:maxbnet $
 * $HeadURL:https://maxlist.svn.sourceforge.net/svnroot/maxlist/trunk/maxlist/modules/_scaffold/scaffold_controller.php $
 * 
 * $Author:maxbnet $
 * $Date:2007-11-16 20:25:56 +0100 (ven, 16 nov 2007) $
 */

class AttachmentController extends ModuleController implements IModuleController{
	
	public function __construct(){
		
		//params
		$params = array(
					'do'=> array('in' => '', 'm' => 'post'),//TODO : options in
					'confirm'=>array('m' => 'post')
		);
		$this->_check_params($params);
		
		$this->_model = new AttachmentModel($this->_params);  
		
		$this->_do();
		
		$this->_routing();
	}
	protected function _view(){
		$id = $this->_id();
		if($file = $this->_model->get_attachment($id)){
			//print_r($file);
			if(is_file($file['file']))
			$this->_output_file($file);
		}
		exit;//esci comunque
	}
	//attachment
	private function _output_file($file){
		@ob_end_clean();
		if ($file['data'][1]) {
			header("Content-type: {$file['data'][1]}");
		} else {
			header("Content-type: application/octetstream");
		}
		list($fname,$ext) = explode(".",basename($file['data'][2]));
  		header ('Content-Disposition: attachment; filename="'.basename($file['data'][2]).'"');
  		if ($file['data'][4])
    		$size = $file['data'][4];
  		else
    		$size = filesize($file);
  		if ($size) {
    		header ("Content-Length: " . $size);
    		$fsize = $size;
  		}else{
    		$fsize = 4096;
  		}
  		$fp = fopen($file['file'],"r");
  		while ($buffer = fread($fp,$fsize)) {
    		print $buffer;
  			flush();
  		}
  		fclose ($fp);
	}
}
