<?php
/**
 * Project:     deskweb - the dekstop manager for web <br />
 * File:        msgstack.php <br />
 * Description: Msgstack di applicazioni<br />
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
 * @package Project
 */

/**
 * Classe per la gestione dei messaggi a livello di applicazioni
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @package Project
 */
class MsgstackApplications{
  
  	
 	var $errors = array();
    
    /**
	* Class constructor.
	*/  
	function MsgstackApplications(){
	    $this->config();  
		if(isset($_SESSION['errors']) && is_array($_SESSION['errors']))
		{
			$this->errors = $_SESSION['errors'];
			session_start();
			unset($_SESSION['errors']);
	    	session_write_close();
		}
	}
	/**
	* Add message in the session.
	*/  
	function addSession($message, $type = 'error') 
	{
	  if ($type == 'error') {
        $_SESSION['errors'][] = array('params' => 'class=\'messageStackError\'', 'icon' => ICON_ERROR , 'text' => $message);
      } elseif ($type == 'warning') {
        $_SESSION['errors'][] = array('params' => 'class=\'messageStackWarning\'', 'icon' => ICON_WARNING , 'text' => $message);
      } elseif ($type == 'success') {
        $_SESSION['errors'][] = array('params' => 'class=\'messageStackSuccess\'', 'icon' => ICON_SUCCESS , 'text' =>  $message);
      }
        
	}
	/**
	* Add message in the stack.
	*/  
	function add($message, $type = 'error') 
	{
	  if ($type == 'error') {
        $this->errors[] = array('params' => 'class=\'messageStackError\'', 'icon' => ICON_ERROR , 'text' => $message);
      } elseif ($type == 'warning') {
        $this->errors[] = array('params' => 'class=\'messageStackWarning\'', 'icon' => ICON_WARNING , 'text' => $message);
      } elseif ($type == 'success') {
        $this->errors[] = array('params' => 'class=\'messageStackSuccess\'', 'icon' => ICON_SUCCESS , 'text' =>  $message);
      }

	}
	function addID($id,$message) 
	{
	    $this->errors[] = array('params' => 'class=\'messageStackWarning\' id=\''.$id.'\'', 'icon' => null , 'text' => $message);
      
	}	
	/**
	* Reset the stack.
	*/  
	function reset() {
      $this->errors = array();
    }
    /**
	* Output the stack.
	*/  
	function output()
	{
		$output = null;
		for($x=0;$x<=count($this->errors)-1;$x++)
		{
			$output .= "<div ".$this->errors[$x]['params'].">";
			
			if($this->errors[$x]['icon'] != null)
			$output .= "<img src='".$this->errors[$x]['icon']."' alt='' class='iconmsg' /> ";
			$output .= $this->errors[$x]['text']."</div>\n";
		}
		return $output;
		/**
		 * if (count($msgstack->errors) > 0) {
			$msgstack_txt = "<div id='msgstack'>"."<div class='bordo_dialog'>\n"."<div class='dialog'>\n"."<div class='dialog_barra_titolo'>ATTENZIONE</div>\n"."<form method='post' action='".$_SERVER['REQUEST_URI']."'>\n".$msgstack->output()."<p style='text-align:center;margin:auto;width:30%;'><input class='submsg' type='submit' name='ok' id='ok' value='Ok' />"."</form>\n"."</div>\n"."</div>\n"."</div>\n";

		}
		 */
	}
  	/**
	* Config the object.
	*/  
	function config()
    {
	  	define('ICON_ERROR','/public/icons/error.gif');
		define('ICON_SUCCESS','/public/icons/success.gif');
		define('ICON_WARNING','/public/icons/warning.gif');
    }
}
?>