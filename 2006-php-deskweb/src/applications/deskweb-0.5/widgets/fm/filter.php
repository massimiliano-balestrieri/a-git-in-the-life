<?php
/**
 * Project:     deskweb - the dekstop manager for web <br />
 */

/**
 * The filter widget
 */
class FilterFormDeskWeb extends PanelDeskWeb
{

	/**
	 * string output
	 */
	var $output = null;
	
	/**
	 * the Constructor 
	 * istance of this class are simply label element
	 */
	function FilterFormDeskWeb($id_array, $id_sezione,$id_applicazione,$campi,$default)
	{
		global $request;
		$filter = null;
		$this->id_sezione = $id_sezione;
		if(isset($request->form['filterwhere']))
		$default  =$request->form['filterwhere']; 
		
		if(isset($request->form['filter']))
		$filter  =$request->form['filter']; 
		
		$this->output .= "<input type='text' name='filter' value='".$filter."' />\n";
		$this->output .= "<select name='filterwhere'>\n";
		for($x = 0;$x<=sizeof($campi)-1;$x++)
		{
			$str_campo = ucfirst(str_replace("_"," ",$campi[$x]));
			if($campi[$x] == $default)
			{
				$this->output .= "<option value='".$campi[$x]."' selected='selected'>".$str_campo."</option>\n";
			}else{
				$this->output .= "<option value='".$campi[$x]."'>".$str_campo."</option>\n";
			}	
		}
		$this->output .= "</select>\n";
		$this->output .= "<input type='submit' name='cerca' value='cerca' />\n";
		
		
	}
	function createForm($label,$visible = true)
	{
		$this->PanelDeskWeb($this->id_sezione,$label,$visible);
		if($this->classname) $this->classname = " class='".$this->classname."'";
		$this->open_element .=  "<form class='filter' method='post' action='#'>\n" . $this->output . "</form>\n";	
	}

}
?>