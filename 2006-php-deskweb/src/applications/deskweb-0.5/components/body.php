<?php


/**
 * classe body
 * incapsula gli elementi che andranno nel body
 */
class BodyDeskWeb{
  
  /**
   * oggetto js per le statistiche
   */
  var $stat = null;
  /**
   * oggetto desktop
   */
  var $desktop = null;
  /**
   * oggetto msgstack
   */
  var $msgstack = null;
    
  /**
   * costruttore
   * lega l'oggetto globale $widget_stat al campo della classe
   * istanzia il desktop
   */
  function BodyDeskWeb(){
    
    global $layout_sito,$widget_stat,$msgstack;
    $this->msgstack = $msgstack;
    $this->stat = $widget_stat;
    $this->desktop = new DesktopDeskWeb();
  }
   
  /**
   * manda ad output desktop logger e statistiche
   */
  function output(){
  	  global $logger;
  	  
  	  echo "\n<body>\n";
  	  echo $this->msgstack->output()."\n";
	  echo $this->desktop->output()."\n";
	  echo $this->stat;
	  echo "<div id='logger'>".$logger->timer_stop(true)."</div>";
	  echo "\n</body>\n</html>\n";
  }
  
}


?>