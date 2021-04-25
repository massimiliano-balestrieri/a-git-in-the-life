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
 * $Id: attributeform_helper.php 365 2008-01-05 18:32:37Z maxbnet $
 * $LastChangedDate: 2008-01-05 18:32:37 +0000 (Sat, 05 Jan 2008) $
 * $LastChangedRevision: 365 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/app/models/helpers/attributeform_helper.php $
 * 
 * $Author: maxbnet $
 * $Date: 2008-01-05 18:32:37 +0000 (Sat, 05 Jan 2008) $
 */

class AttributeformHelper{
	
	private $_types = false;
	
	private $_fields = false;
	private $_html_required = '&nbsp;&nbsp;&nbsp;<span>*</span>';
	
	private $_values = false;
	private $_items = false;
	private $_errors = false;
	
	public function __construct($types){
		$this->_types = $types;
	}
	
	public function get_form_fields($attributes, $values, $items, $errors){
		$this->_values = $values;
		$this->_items = $items;
		$this->_errors = $errors;
		foreach($attributes as $attr){
			$this->_render_field($attr['type'], $attr['id'], $attr['name'], $attr['required']);
		}
		return $this->_fields;
	}
	
	private function _get_field_hidden($id){
		return sprintf('<input type="text" name="attribute[%d]" id="attribute_%d" value="%s" />' , 
						$id, $id, htmlspecialchars($this->_values[$id]));
	}
	private function _get_field_textline($id){
		$field_err = ' '.$this->_get_error($id,'classname');
  		return sprintf('<input type="text" name="attribute[%d]" id="attribute_%d" value="%s" size="30" class="ml_input_medium%s" />' , 
						$id, $id, htmlspecialchars($this->_values[$id]), $field_err);
	}
	private function _get_field_checkbox($id){
		//print_r($this->_values);
		$checked = $this->_values[$id] == "on" || $this->_values[$id] == 1 ?' checked=checked':'';
		return sprintf('<input type="hidden" name="cbattribute[%d]" id="cbattribute_%d" value="%d" />' .
					   '<input type="checkbox" name="attribute[%d]" id="attribute_%d" value="on" %s/>' , 
					   $id, $id, $this->_values[$id], 
					   $id, $id, $checked);
	}
	private function _get_field_checkboxgroup($id){
		$field_err = ' '.$this->_get_error($id,'classname');
		//class="ml_select%s"$field_err
		return sprintf('<input type="hidden" id="attribute_%d" name="attribute[%d]" value="" />' .
					   '<input type="hidden" id="cbgattribute_%d" name="cbgattribute[%d]" value="%s" /><br />%s' ,
		$id,$id,$id,$id,$this->_values[$id],$this->_get_options_group('checkbox',$id));
	}
	private function _get_field_textarea($id){
		$field_err = ' '.$this->_get_error($id,'classname');
  		return sprintf('<textarea name="attribute[%d]" id="attribute_%d" rows="10" cols="40" class="ml_textarea%s">%s</textarea>' , 
  						$id, $id, $field_err, $this->_values[$id]);
	}
	private function _get_field_radio($id){
		$field_err = ' '.$this->_get_error($id,'classname');
		//class="ml_select%s"$field_err
		return sprintf('<input type="hidden" id="attribute_%d" name="attribute[%d]" value="" />' .
					   '<input type="hidden" id="cbgattribute_%d" name="cbgattribute[%d]" value="%s" /><br />%s' ,
		$id,$id,$id,$id,$this->_values[$id],$this->_get_options_group('radio',$id));
	}
	private function _get_field_select($id){
		$field_err = ' '.$this->_get_error($id,'classname');
		return sprintf('<select name="attribute[%d]" id="attribute_%d" class="ml_select%s">%s</select>' ,
		$id,$id,$field_err,$this->_get_options($id));
  	}
  	private function _get_options($id){
  		if (!isset($this->_items[$id])){
	    	return "(No values available)";
  		}else{
	  		$value = $this->_values[$id];
		 	$items = $this->_items[$id];
	  		//print_r($items);die;
	  		$html = '<option value="">&nbsp;</option>';
		  	foreach($items as $item){
		  		$html .= sprintf('<option value="%d" %s>%s</option>',
			  				$item[0],
			  				$item[1] == $value || $item[0] == $value?' selected="selected"':"",// check sia sulla label che sul valore
			  				htmlentities($item[1]));
		  	}
		  	return $html;
	  	}
  	}
  	private function _get_options_group($type, $id){
  		if (!isset($this->_items[$id])){
	    	return "(No values available)";
  		}else{
	  		$values = split(',' , $this->_values[$id]);
		 	$items = $this->_items[$id];
	  		//print_r($items);die;
	  		$html = '';
		  	foreach($items as $item){
			    $html .= sprintf('<input type="%s" id="cbgroup_%d_%d" name="cbgroup[%d][]" value="%d" %s/>' .
			    				 '<label for="cbgroup_%d_%d">%s</label><br />',
		  					$type,
		  					$id,$item[0],//id
		  					$id,//name
		  					$item[0],//value
						    in_array($item[0],$values) || in_array($item[1],$values) ? 'checked="checked"' : "",//sia la label che il value
						    $id,$item[0],//for
		  					$item[1]);
		  	}
		  	return $html;
  		}
  	}
	private function _get_label($id, $name, $required){
		//TODO: $field_lbl_err, $field_err
		$field_required = $required ?  $this->_html_required : false;
		//print_r($this->_errors);die;
		
		$field_err = $this->_get_error($id);
  		return sprintf('<label for="attribute_%d">%s%s%s</label>', $id, $name, $field_required, $field_err);
		//'<label for="attribute_%d"'.$field_lbl_err.'>%s '.$field_required.$field_err.'</label>',
		//if(isset($_REQUEST[$this->submit]) && $row["required"] && strlen($field_value)==0){$field_err = $html_err; $field_lbl_err = $lbl_err;}
	}
	private function _get_error($id, $key = 'img'){
		$error_id = 'attribute_'.$id;
		if(isset($this->_errors[$error_id])){ 
			return $this->_errors[$error_id][$key];
		}
	}
	private function _render_field($type, $id, $name, $required){
		if(in_array($type, $this->_types)){
			$method = '_render_' .$type; 
			$this->$method($id, $name, $required);
		}else{
			die('<!-- check fields type -->');
		}
	}
	private function _render_hidden($id, $name, $required){
		$this->_fields[] = array('label' => '',
					 			 'field' => $this->_get_field_hidden($id),
					 		);
	}
	private function _render_textline($id, $name, $required){
		$this->_fields[] = array('label' => $this->_get_label($id, $name, $required),
					 			 'field' => $this->_get_field_textline($id),
					 		);
	}
	private function _render_checkbox($id, $name, $required){
		$this->_fields[] = array('label' => $this->_get_label($id, $name, $required),
					 			 'field' => $this->_get_field_checkbox($id),
					 		);
	}
	private function _render_checkboxgroup($id, $name, $required){
		$this->_fields[] = array('label' => $this->_get_label($id, $name, $required),
					 			 'field' => $this->_get_field_checkboxgroup($id),
					 		);
	}
	private function _render_textarea($id, $name, $required){
		$this->_fields[] = array('label' => $this->_get_label($id, $name, $required),
					 			 'field' => $this->_get_field_textarea($id),
					 		);
	}
	private function _render_radio($id, $name, $required){
		$this->_fields[] = array('label' => $this->_get_label($id, $name, $required),
					 			 'field' => $this->_get_field_radio($id),
					 		);
	}
	private function _render_select($id, $name, $required){
		$this->_fields[] = array('label' => $this->_get_label($id, $name, $required),
					 			 'field' => $this->_get_field_select($id),
					 		);
	}

}