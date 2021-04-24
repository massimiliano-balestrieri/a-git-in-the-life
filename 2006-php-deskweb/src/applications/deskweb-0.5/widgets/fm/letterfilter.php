<?php
/**
 * Project:     deskweb - the dekstop manager for web <br />
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