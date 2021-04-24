<?php

/**
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @package Project
 */
class ControllerApplications{
  
  	/**
	* Constructor. Lancia il controller dell'applicazione presente nell'indice 
	* DEFAULT_APPLICATION della sessione
	* @access public
  	*/
  	function ControllerApplications()
  	{
  	  global $msgstack;
  	  if(isset($_SESSION['DEFAULT_APPLICATION']))
  	  {
	      switch ($_SESSION['DEFAULT_APPLICATION']){
	        case "deskweb";
	          $controller = new ControllerDeskWeb();
	        break;
	        default:
	          $controller = new ControllerDeskWeb();
	        break;
	      }
  	  }else{
  	  	echo "Applicazione non inizializzata";
  	  }
  	}
}
?>