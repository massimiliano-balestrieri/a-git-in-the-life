<?php
/**
 * Project:     deskweb - the dekstop manager for web <br />
 * 
 /*
  $Id: logger.php,v 1.2 2005/10/05 14:51:01 manmachine Exp $
 * +-----------------------------------------------------------------------+
 * |                  osCSS Open Source E-commerce                         |
 * +-----------------------------------------------------------------------+
 * | Copyright (c) 2005 The osCSS developers                               |
 * |                                                                       |
 * | http://www.counteractdesign.com                                       |
 * |                                                                       |
 * | Portions Copyright (c) 2003 osCommerce                                |
 * +-----------------------------------------------------------------------+
 * | This source file is subject to version 2.0 of the GPL license,        |
 * | available at the following url:                                       |
 * | http://www.counteractdesign.com/license/2_0.txt.                      |
 * +-----------------------------------------------------------------------+
 * @package Project
 */

define('STORE_PARSE_DATE_TIME_FORMAT','%d/%m/%Y %H:%M:%S');


class logger {
    var $timer_start, $timer_stop, $timer_total;

// class constructor
    function logger() {
      $this->timer_start();
    }

    function timer_start() {
      if (defined("PAGE_PARSE_START_TIME")) {
        $this->timer_start = PAGE_PARSE_START_TIME;
      } else {
        $this->timer_start = microtime();
      }
    }

    function timer_stop($display = 'false') {
      $this->timer_stop = microtime();

      $time_start = explode(' ', $this->timer_start);
      $time_end = explode(' ', $this->timer_stop);

      $this->timer_total = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);

      $this->write(getenv('REQUEST_URI'), $this->timer_total . 's');

      if ($display == 'true') {
        return $this->timer_display();
      }
    }

    function timer_display() {
      global $body;
      return "Elaborazione: " . $this->timer_total . "s - Memoria: ".$this->getMemUsage()."Kb";
    }
    function timer_display2() {
      $str_tabella = "<tr><td>" . $this->timer_total ."</td><td>" .$this->getMemUsage()."</td></tr>";
      return $str_tabella;
    }

    function write($message, $type) {
      //error_log(strftime(STORE_PARSE_DATE_TIME_FORMAT) . ' [' . $type . '] ' . $message . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }
    
    function getMemUsage()
	{
      
       if (function_exists('memory_get_usage'))
       {
           return round(memory_get_usage()/1024,2);
       }
       else if ( strpos( strtolower($_SERVER["OS"]), 'windows') !== false)
       {
           // Windows workaround
           $output = array();
          
           exec('tasklist /FI "PID eq ' . getmypid() . '" /FO LIST', $output);           
           return substr($output[5], strpos($output[5], ':') + 1);
       }
       else
       {
           return '<b style="color: red;">no value</b>';
       }
	}
  }
?>