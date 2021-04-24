<?php

require_once("include_project.php");
require_once("include_applications.php");

/**
 * @global logger $logger
 * @name $logger
 */
$logger = new logger();
/**
 * @global SessionApplications $session
 * @name $session
 */
 $session    = new SessionApplications();
/**
 * @global MsgstackApplications $msgstack
 * @name $msgstack
 */
$msgstack = new MsgstackApplications();
/**
 * @global ControllerApplications $controller
 * @name $controller
 */
$controller = new ControllerApplications();
?>