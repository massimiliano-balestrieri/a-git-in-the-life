<?php
/**
 * Project:     deskweb - the desktop manager for web <br />
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * You may contact the authors of Deskweb by emial at: <br />
 * io@maxb.net <br />
 *
 * Or, write to: <br />
 * Massimiliano Balestrieri <br />
 * Via Casalis 9 <br />
 * 10143 Torino <br />
 * Italy <br />
 *
 * The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package Deskweb
 */
 
/**
 * Class Base Widget
 */
class WidgetDeskWeb{

	  /**
 	  * Stack dei componenti
 	  */	
	  var $components = array();
	  /**
 	  * The container : prefix of element
 	  */	
	  var $open_element = null;
	  /**
 	  * The container : suffix of element
 	  */	
	  var $close_element = null;
	  /**
 	  * The Dom's Id of the component
 	  */	
	  var $id = null;
	  /**
 	  * classname
 	  */	
	  var $classname = null;
	  /**
 	  * href
 	  */	
	  var $href = false;
	  /**
 	  * tag
 	  */	
	  var $tag = false;
	  /**
 	  * body
 	  */	
	  var $body = false;
	  
	  /**
 	  * output of the components
 	  */	
	  function output(){
	  	echo $this->open_element;
	    while($array_cell = each($this->components)){
	     eval ('$this->components['.$array_cell['key'].']->output();');
	    }
	    echo $this->close_element;
	  }
	 
	  /**
 	  * add element into stack of components
 	  */	
	  function add_element($object){
	    array_push($this->components,$object);
	  }
	  
	  /**
 	  * set class of the component
 	  */	
	  function set_classname($name){
		$this->classname = $name;
	  }
	  /**
 	  * set id of the component
 	  */	
	  function set_id($name){
		$this->id = $name;
	  }
	  /**
 	  * set the body of the component
 	  */	
	  function set_text($text)
	  {
		$this->body = $text;
	  }
	  function append_element($element)
	  {
	  	$this->close_element .= $element->open_element . $element->close_element;
	  }
	  function append_child($element)
	  {
	  	$this->body .= $element->open_element . $element->close_element;
	  }
	  function set_action($action,$param = null)
	  {
	  	global $session;
	  	//if($session->getAjax() == 1)
	  	//{
	  		
	  	//}else{
	  		if($param == null)
	  		{
	  			$this->href = true;
	  			$this->url = "action=".$action;
	  		}else{
	  			$this->href = true;
	  			$this->url = $action . "=". $param;
	  		}	
	  	//}
	  }
	  /**
	   * compose the tag
	   */
	  function crea_tag()
	  {
		if($this->href) 
		{
			if($this->onclick)
			{	
				$this->open_element .= "<a href='#'>\n";
			}else{
				$this->open_element .= "<a href='?".$this->url."'>\n";
			}
		}
		$this->open_element .= "<".$this->tag;
		if($this->id) $this->open_element .= " id='".$this->id."'";
		if($this->classname) $this->open_element .= " class='".$this->classname."'";
		if($this->body) $this->open_element .= ">". $this->body . "</".$this->tag.">\n";
		if(!$this->body) $this->open_element .= " />\n";
		if($this->href) $this->open_element .= "</a>\n";
		
	  }
}
?>