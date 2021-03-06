<?php
/**
 * Project:     deskweb - the dekstop manager for web
 * File:        debug.php 
 * Description: Il file istanzia la classe session di deskweb e manda ad output il valore della sessione
 * 
 * The latest version of deskweb can be obtained from: <br />
 * http://www.deskweb.org/ <br />
 *
 * @link http://www.deskweb.org/
 * @author Massimiliano Balestrieri <io@maxb.net>
 * @version 0.1
 * @copyright 2005-2006 Massimiliano Balestrieri.
 * @package Ajax
 */
 

require_once($_SERVER['DOCUMENT_ROOT'] . "/applications/deskweb-0.3/components/session.php");


$session = new SessionDeskWeb();
print_r($_SESSION);
?>