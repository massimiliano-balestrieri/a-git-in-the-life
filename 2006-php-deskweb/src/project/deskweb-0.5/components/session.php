<?php

/**
 * Classe per la gestione della sessione a livello di applicazioni
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @package Project
 */
class SessionApplications{
  
   
  /**
   * Class constructor
   */    
  function SessionApplications(){
        session_start();
        $_SESSION['DEFAULT_APPLICATION'] = DEFAULT_APPLICATION;
        session_write_close();      
  }
  
}
?>