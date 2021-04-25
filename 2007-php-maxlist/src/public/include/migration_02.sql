 CREATE TABLE `default_group` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL
) ENGINE = MYISAM 


CREATE TABLE `default_group_usecases` (
  `group_id` int(11) NOT NULL,
  `usecase` varchar(100) NOT NULL,
  `value` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`group_id`,`usecase`)
) ENGINE=MyISAM;

 CREATE TABLE `default_admingroup` (
`admin_id` INT NOT NULL ,
`group_id` INT NOT NULL ,
PRIMARY KEY ( `admin_id` , `group_id` )
) ENGINE = MYISAM 
