<?php
/**
 * Project:     deskweb - the dekstop manager for web <br />
 * File:        session.php <br />
 * Description: Il file istanzia la classe session di deskweb <br /> 
 * 
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
 * @package Ajax
 */
 
 
require_once($_SERVER['DOCUMENT_ROOT'] . "/applications/deskweb-0.3/components/session.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/applications/deskweb-0.3/components/request.php");

$session = new SessionDeskWeb();
$request = new RequestDeskWeb();
print_r($_SESSION);
?>