<?php

if($_SERVER['REMOTE_ADDR']=="127.0.0.1" || $_SERVER['REMOTE_ADDR']=="10.0.0.10" || $_SERVER['REMOTE_ADDR']=="10.0.0.1")
{
	error_reporting(E_ALL);
}else{
	error_reporting(E_NONE);
}

//  ini_set('display_errors', 1);
//  ini_set('display_startup_errors', 1);
//  error_reporting(E_ALL);


require_once("./project/deskweb-0.5/index.php");
?>