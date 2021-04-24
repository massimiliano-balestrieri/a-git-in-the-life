<?php


/**
 * The container base widget
 */
class ContainerDeskWeb extends WidgetDeskWeb
{
	
	var $style = null;
	
	/**
	 * the Constructor 
	 * istance of this class are simply block container element
	 */
	function ContainerDeskWeb()
	{
		$this->tag = "div";
	}
	function setFloat($float)
	{
		$this->style = "float:".$float.";";	
	}
	function setWidth($width)
	{
		$this->style .= "width:".$width.";";	
	}
	function make()
	{
		$this->open_element .= "<".$this->tag;
		if($this->style != null) $this->open_element .= " style='".$this->style."'";
		$this->open_element .= ">";		
		$this->close_element .= "</".$this->tag.">";
	}

}
?>