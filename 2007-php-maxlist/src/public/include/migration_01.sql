ALTER TABLE `default_eventlog` ADD `admin` VARCHAR( 50 ) NOT NULL AFTER `entry` ,
ADD `stack` TEXT NOT NULL AFTER `admin` ;
