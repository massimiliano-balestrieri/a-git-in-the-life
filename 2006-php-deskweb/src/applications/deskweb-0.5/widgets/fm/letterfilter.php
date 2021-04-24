<?php
/**
 * Project:     deskweb - the dekstop manager for web <br />
 */

/**
 * The letterfilter widget
 */
class LetterFilterFormDeskWeb extends FormDeskWeb
{

	/**
	 * string output
	 */
	var $output = null;
	
	/**
	 * the Constructor 
	 * istance of this class are simply label element
	 */
	function LetterFilterFormDeskWeb($id_array, $id_sezione,$id_applicazione,$campi,$default)
	{
		global $request;
		$this->id_sezione = $id_sezione;
		$this->id_array = $id_array;
		$this->id_applicazione = $id_applicazione;
		
		if(isset($request->form['firstletterwhere']))
		$default  =$request->form['firstletterwhere']; 
		$str_letter = "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,X,Y,W,Z";
		$arr_letter = split(",",$str_letter);
		
		for($x = 0;$x<=sizeof($arr_letter)-1;$x++)
		{
			if(isset($request->form['firstletter']) && $request->form['firstletter'] == $arr_letter[$x])
			$this->output .= "<input type='submit' name='firstletter' value='".$arr_letter[$x]."' disabled='disabled' />\n";
			else
			$this->output .= "<input type='submit' name='firstletter' value='".$arr_letter[$x]."' />\n";	
		}
		if(isset($request->form['firstletter']) && ($request->form['firstletter'] == "TUTTI" || $request->form['firstletter'] == "%"))
		$this->output .= "<input type='submit' name='firstletter' value='TUTTI' disabled='disabled' />\n";	
		else
		$this->output .= "<input type='submit' name='firstletter' value='TUTTI' />\n";	
		
		$this->output .= "<select name='firstletterwhere'>\n";
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
		
	}
	function createForm($label,$visible = true)
	{
		$this->addFieldsPersistentToOutput();
		$this->PanelDeskWeb($this->id_sezione,$label,$visible);
		if($this->classname) $this->classname = " class='".$this->classname."'";
		$this->open_element .=  "<form class='filtroaz' method='post' action='#'>\n" . $this->output;
		$this->open_element .= $this->statefull . "</form>\n";
	}

}
?>