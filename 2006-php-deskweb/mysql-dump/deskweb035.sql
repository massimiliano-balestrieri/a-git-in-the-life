-- phpMyAdmin SQL Dump
-- version 2.8.0.3-Debian-1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generato il: 17 Giu, 2006 at 01:36 PM
-- Versione MySQL: 4.1.15
-- Versione PHP: 4.4.2-1build1
-- 
-- Database: `deskweb033`
-- 

-- --------------------------------------------------------

-- 
-- Struttura della tabella `deskweb033_addressbook`
-- 

CREATE TABLE `deskweb033_addressbook` (
  `id_addressbook` int(11) NOT NULL auto_increment,
  `nome` varchar(250) default NULL,
  `cognome` varchar(250) default NULL,
  `azienda` varchar(50) NOT NULL default '',
  `azienda_titolo` varchar(50) NOT NULL default '',
  `telefono_ufficio` varchar(15) NOT NULL default '',
  `fax_ufficio` varchar(15) NOT NULL default '',
  `telefono_cellulare` varchar(15) NOT NULL default '',
  `telefono_abitazione` varchar(15) NOT NULL default '',
  `fax_abitazione` varchar(15) NOT NULL default '',
  `cercapersone` varchar(15) NOT NULL default '',
  `homepage` varchar(250) NOT NULL default '',
  `email` varchar(250) NOT NULL default '',
  `ufficio_indirizzo` varchar(250) NOT NULL default '',
  `ufficio_cap` varchar(5) NOT NULL default '',
  `ufficio_localita` varchar(50) NOT NULL default '',
  `abitazione_indirizzo` varchar(50) NOT NULL default '',
  `abitazione_cap` varchar(5) NOT NULL default '',
  `abitazione_localita` varchar(50) NOT NULL default '',
  `data_nascita` datetime NOT NULL default '0000-00-00 00:00:00',
  `note` text NOT NULL,
  PRIMARY KEY  (`id_addressbook`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- 
-- Dump dei dati per la tabella `deskweb033_addressbook`
-- 

INSERT INTO `deskweb033_addressbook` (`id_addressbook`, `nome`, `cognome`, `azienda`, `azienda_titolo`, `telefono_ufficio`, `fax_ufficio`, `telefono_cellulare`, `telefono_abitazione`, `fax_abitazione`, `cercapersone`, `homepage`, `email`, `ufficio_indirizzo`, `ufficio_cap`, `ufficio_localita`, `abitazione_indirizzo`, `abitazione_cap`, `abitazione_localita`, `data_nascita`, `note`) VALUES (13, 'massimiliano', 'balestrieri', '', '', '', '', '', '', '', '', 'www.maxb.net', 'max@maxb.net', '', '', '', '', '', '', '1978-08-03 00:00:00', '');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `deskweb033_bug`
-- 

CREATE TABLE `deskweb033_bug` (
  `id_bug` int(11) NOT NULL auto_increment,
  `titolo` varchar(255) default NULL,
  `data` datetime default NULL,
  `risolto` tinyint(1) unsigned default NULL,
  `descrizione` text,
  `fk_user` int(11) unsigned default NULL,
  PRIMARY KEY  (`id_bug`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dump dei dati per la tabella `deskweb033_bug`
-- 

INSERT INTO `deskweb033_bug` (`id_bug`, `titolo`, `data`, `risolto`, `descrizione`, `fk_user`) VALUES (1, 'form stessa app', '2007-02-06 00:00:00', 0, 'quando da un''applicazione si lancia la modalita modifica tutte le applicazioni di quel tipo...', 1),
(2, 'pi&ugrave;  app aperte', '2002-06-20 00:00:00', 0, 'quando da un\\''applicazione si lancia la modalita modifica tutte le applicazioni di quel tipo...', 1),
(4, 'Crypt della Password...', '2007-06-03 00:00:00', 0, '', 0);

-- --------------------------------------------------------

-- 
-- Struttura della tabella `deskweb033_calendar`
-- 

CREATE TABLE `deskweb033_calendar` (
  `id_calendar` int(11) NOT NULL auto_increment,
  `fk_group` int(11) default NULL,
  `fk_user` int(11) default NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `start` int(11) default NULL,
  `duration` int(11) NOT NULL default '0',
  `priority` tinyint(1) default '2',
  `type` tinyint(1) default '0',
  `permissions` varchar(9) default 'rwx------',
  `event` varchar(80) NOT NULL default '',
  `content` text,
  `frequency_type` tinyint(1) default NULL,
  `frequency_mod` tinyint(3) default NULL,
  `frequency_days` varchar(10) default NULL,
  `frequency_end` datetime default NULL,
  PRIMARY KEY  (`id_calendar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dump dei dati per la tabella `deskweb033_calendar`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `deskweb033_groups`
-- 

CREATE TABLE `deskweb033_groups` (
  `id_group` int(11) unsigned NOT NULL default '0',
  `groupname` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id_group`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dump dei dati per la tabella `deskweb033_groups`
-- 

INSERT INTO `deskweb033_groups` (`id_group`, `groupname`) VALUES (0, 'guest'),
(1, 'root'),
(1000, 'users');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `deskweb033_node`
-- 

CREATE TABLE `deskweb033_node` (
  `id_node` int(11) unsigned NOT NULL auto_increment,
  `node` varchar(50) NOT NULL default '0',
  `id_dom` varchar(50) default NULL,
  `type` varchar(10) NOT NULL default '0',
  `application` varchar(255) default NULL,
  `window` varchar(255) default NULL,
  `fk_parent` int(11) unsigned default NULL,
  `icon` varchar(50) default 'icon.png',
  `content` text,
  `fk_menu` tinyint(1) unsigned NOT NULL default '0',
  `order_menu` smallint(3) default '0',
  `last_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `is_sys` tinyint(1) unsigned default '0',
  `have_child` tinyint(1) unsigned NOT NULL default '0',
  `permissions` varchar(9) NOT NULL default 'rwxrwxrwx',
  `fk_user` int(10) unsigned NOT NULL default '0',
  `fk_group` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_node`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=1374 ;

-- 
-- Dump dei dati per la tabella `deskweb033_node`
-- 

INSERT INTO `deskweb033_node` (`id_node`, `node`, `id_dom`, `type`, `application`, `window`, `fk_parent`, `icon`, `content`, `fk_menu`, `order_menu`, `last_date`, `is_sys`, `have_child`, `permissions`, `fk_user`, `fk_group`) VALUES (1, 'Applications', 'Applications', 'dir', 'dwnautilus', NULL, 0, 'cartella.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 1, 'rwxr--r--', 1, 1),
(2, 'Places', 'Places', 'dir', 'dwnautilus', '', 0, 'cartella.png', '', 0, 0, '2006-06-01 00:00:00', 1, 1, 'rwxr--r--', 1, 1),
(3, 'System', 'System', 'dir', 'dwnautilus', '', 0, 'cartella.png', '', 0, 0, '2006-06-01 00:00:00', 1, 1, 'rwxr--r--', 1, 1),
(4, 'Public', '', 'dir', 'dwnautilus', NULL, 2, 'mycomputer.png', NULL, 1, 2, '2006-06-01 00:00:00', 1, 1, 'rwxrwxr--', 1, 1000),
(5, 'Accessori', '', 'dir', 'dwnautilus', NULL, 1, 'package_utilities.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 1, 'rwxr--r--', 1, 1),
(6, 'BookMarks', '', 'dir', 'bookmarks', '', 5, 'keditbookmarks.png', '', 0, 0, '2006-06-14 09:35:39', 1, 1, 'rwxr-----', 1, 1),
(7, 'News', '', 'dir', 'dwnautilus', NULL, 5, 'knewsletter.png', NULL, 2, 1, '2006-06-01 00:00:00', 1, 1, 'rwxr--r--', 1, 1),
(8, 'Notes', '', 'dir', 'dwnautilus', NULL, 5, 'klipper.png', NULL, 2, 2, '2006-06-01 00:00:00', 1, 1, 'rwxr--r--', 1, 1),
(9, 'Calendar', '', 'exe', 'calendar', NULL, 5, 'date.png', NULL, 2, 3, '2006-06-01 00:00:00', 1, 0, 'rwxr-----', 1, 1),
(10, 'Notepad', '', 'exe', 'dwnano', NULL, 5, 'kate.png', NULL, 3, 2, '2006-06-01 00:00:00', 1, 0, 'rwxr--r--', 1, 1),
(11, 'DwEditor', '', 'exe', 'dweditor', '', 5, 'browser.png', '', 3, 3, '2006-06-01 00:00:00', 1, 0, 'rwxr--r--', 1, 1),
(12, 'Todo', '', 'exe', 'dwtodo', '850,470', 5, 'korganizer.png', NULL, 2, 4, '2006-06-01 00:00:00', 1, 0, 'rwxr--r--', 1, 1),
(13, 'Internet', '', 'dir', 'dwnautilus', NULL, 1, 'browser.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 1, 'rwxr--r--', 1, 1),
(14, 'Rubrica', '', 'exe', 'dwaddressbook', '850,470', 13, 'kaddressbook.png', '', 2, 5, '2006-06-05 12:09:26', 1, 0, 'rwxrwxr--', 1, 1000),
(15, 'Mail', '', 'exe', 'mail', NULL, 13, 'email.png', NULL, 3, 4, '2006-06-01 00:00:00', 1, 0, 'rwxr-----', 1, 1),
(16, 'Chat', '', 'exe', 'chat', NULL, 13, 'chat.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 0, 'rwxr-----', 1, 1),
(17, 'Aggregator', '', 'exe', 'aggregator', NULL, 13, 'akregator.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 0, 'rwxr-----', 1, 1),
(18, 'Rss', '', 'exe', 'rss', NULL, 13, 'klipper.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 0, 'rwxr-----', 1, 1),
(19, 'Multimedia', '', 'dir', 'dwnautilus', NULL, 1, 'kmix.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 1, 'rwxr-----', 1, 1),
(20, 'Audio', '', 'exe', 'xmms', NULL, 19, 'juk.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 0, 'rwxr-----', 1, 1),
(21, 'Video', '', 'exe', 'mplayer', NULL, 19, 'kaboodle.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 0, 'rwxr-----', 1, 1),
(22, 'Immagini', '', 'dir', 'dwnautilus', NULL, 19, 'klipper.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 1, 'rwxr-----', 1, 1),
(23, 'Sistema', '', 'dir', 'dwnautilus', '', 1, 'ksysguard.png', '', 0, 0, '2006-06-14 09:45:59', 1, 1, 'rwxr--r--', 1, 1),
(24, 'File Manager', '', 'dir', 'dwnautilus', NULL, 23, 'kfm.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 1, 'rwxr-----', 1, 1),
(25, 'Terminale', '', 'exe', 'xterm', NULL, 23, 'Eterm.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 0, 'rwxr-----', 1, 1),
(26, 'Amministrazione', '', 'dir', 'dwnautilus', NULL, 3, 'kcontrol.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 1, 'rwxr-----', 1, 1),
(27, 'User Manager', '', 'exe', 'dwusersmanager', '850,470', 26, 'users.png', '', 3, 6, '2006-06-05 09:17:46', 1, 0, 'rwxr-----', 1, 1),
(28, 'Preferenze', '', 'dir', 'dwnautilus', NULL, 3, 'kservices.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 1, 'rwxr-----', 1, 1),
(29, 'Wallpaper', '', 'exe', 'wallpaper', NULL, 28, 'background.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 0, 'rwxr-----', 1, 1),
(30, 'Fonts', '', 'exe', 'fonts', NULL, 28, 'fonts.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 0, 'rwxr-----', 1, 1),
(31, 'Localizzazione', '', 'exe', 'locale', NULL, 28, 'keyboard_layout.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 0, 'rwxr-----', 1, 1),
(32, 'Temi', '', 'exe', 'themes', NULL, 28, 'looknfeel.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 0, 'rwxr-----', 1, 1),
(33, 'logout#action:logout=1', '', 'link', '', '', 3, 'logout.png', '', 3, 5, '2006-06-01 00:00:00', 1, 0, 'rwxr--r--', 1, 1),
(34, 'Sharing', '', 'exe', 'amule', NULL, 13, 'amule.png', NULL, 0, 0, '2006-06-01 00:00:00', 1, 0, 'rwxr-----', 1, 1),
(35, 'System', '', 'exe', 'dwsystem', '850,470', 26, 'servizi.png', NULL, 3, 0, '2006-06-01 00:00:00', 1, 0, 'rwxr-----', 1, 1),
(36, 'Group Manager', '', 'exe', 'dwgroupsmanager', '850,470', 26, 'groups.png', '', 3, 7, '2006-06-05 12:04:57', 1, 0, 'rwxr-----', 1, 1),
(37, 'Role Manager', '', 'exe', 'rolesmanager', '850,470', 26, 'roles.png', '', 3, 8, '2006-06-03 07:33:37', 1, 0, 'rwxr-----', 1, 1),
(1363, 'Login', '', 'html', 'dweditor', '', 3, 'login.png', '<table>\r\n    <caption>Login</caption>\r\n    <tbody>\r\n        <tr>\r\n            <th> <label for="user_utente">Username </label> </th>\r\n            <td> <input type="text" id="user_utente" name="user_utente" class="input100" /> </td>\r\n        </tr>\r\n        <tr>\r\n            <th> <label for="p_utente">Password </label> </th>\r\n            <td> <input type="password" id="p_utente" name="p_utente" class="input100" /> </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan="2"><input type="submit" value="Login" name="action" class="subcol" /></td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 1, 4, '2006-06-14 08:43:52', 0, 0, 'rwxr-----', 1, 0),
(1364, 'Register', '', 'html', 'dweditor', '', 3, 'register.png', '<table>\r\n    <caption>Registrazione Utente</caption>\r\n    <tbody>\r\n        <tr>\r\n            <th>  <label for="user_utente">Username <span style="color: red;">*</span> </label> </th>\r\n            <td> <input type="text" class="input100" name="user_utente" id="user_utente" /> </td>\r\n        </tr>\r\n        <tr>\r\n            <th> <label for="p_utente">Password <span style="color: red;">*</span> </label> </th>\r\n            <td>  <input type="password" class="input100" name="p_utente" id="p_utente" /> </td>\r\n        </tr>\r\n        <tr>\r\n            <th> <label for="p2_utente">Ripeti Password <span style="color: red;">*</span> </label> </th>\r\n            <td> <input type="password" class="input100" name="p2_utente" id="p2_utente" /> </td>\r\n        </tr>\r\n        <tr>\r\n            <th> <label for="email">Email <span style="color: red;">*</span> </label> </th>\r\n            <td> <input type="text" class="input100" name="email" id="email" /> </td>\r\n        </tr>\r\n        <tr>\r\n            <th> <label for="color">Color </label> </th>\r\n            <td> <select name="color">\r\n            <option style="background-color: green;" value="green">green</option>\r\n            <option style="background-color: red;" value="red">red</option>\r\n            <option style="background-color: purple;" value="purple">purple</option>\r\n            <option style="background-color: fuchsia;" value="fuchsia">fuchsia</option>\r\n            <option style="background-color: lime;" value="lime">lime</option>\r\n            <option style="background-color: olive;" value="olive">olive</option>\r\n            <option style="background-color: yellow;" value="yellow">yellow</option>\r\n            <option style="background-color: navy;" value="navy">navy</option>\r\n            <option style="background-color: blue;" value="blue">blue</option>\r\n            <option style="background-color: teal;" value="teal">teal</option>\r\n            <option style="background-color: aqua;" value="aqua">aqua</option>\r\n            <option style="background-color: black; color: white;" value="black">black</option>\r\n            </select> </td>\r\n        </tr>\r\n        <tr>\r\n            <td colspan="2"><input type="submit" class="subcol" name="action" value="Register" /></td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p style="color: red;"> *I dati sono obbligatori. </p>', 1, 5, '2006-06-14 08:44:49', 0, 0, 'rwxr-----', 1, 0),
(1366, 'nome_cartella', NULL, 'dir', 'dwnautilus', NULL, 4, 'aa', NULL, 0, 0, '2006-06-13 16:27:23', 0, 1, 'rwx---r--', 1003, 1000),
(1367, 'nome_cartella', '', 'dir', 'dwnautilus', '', 4, 'aa', '', 0, 0, '2006-06-13 16:27:23', 0, 1, 'rwx---r--', 1003, 1000),
(1368, 'aaa', NULL, 'html', 'dweditor', NULL, 4, 'html.png', 'a<a name=\\"1\\"></a>aa', 0, 0, '2006-06-13 16:29:35', 0, 0, 'rwx---rw-', 1003, 1000),
(1370, 'aaaaaa', NULL, 'dir', 'dwnautilus', NULL, 4, 'a', NULL, 0, 0, '2006-06-13 16:40:06', 0, 1, 'rwx---rwx', 1004, 1000),
(1373, 'WishList', '', 'exe', 'dwwishlist', '850,470', 23, 'Ym.png', '', 1, 8, '2006-06-14 09:34:51', 1, 0, 'rwxr--r--', 1, 1),
(1372, 'Bug', '', 'exe', 'dwbug', '850,470', 23, 'bug.png', '', 1, 5, '2006-06-14 08:51:25', 1, 0, 'rwxr--r--', 1, 1);

-- --------------------------------------------------------

-- 
-- Struttura della tabella `deskweb033_partecipants`
-- 

CREATE TABLE `deskweb033_partecipants` (
  `id_partecipant` int(11) NOT NULL auto_increment,
  `fk_user` int(11) default NULL,
  `fk_calendar` int(11) default NULL,
  PRIMARY KEY  (`id_partecipant`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dump dei dati per la tabella `deskweb033_partecipants`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `deskweb033_roles`
-- 

CREATE TABLE `deskweb033_roles` (
  `id_role` int(11) unsigned NOT NULL auto_increment,
  `fk_group` int(11) NOT NULL default '0',
  `fk_user` int(11) NOT NULL default '0',
  `role` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id_role`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dump dei dati per la tabella `deskweb033_roles`
-- 

INSERT INTO `deskweb033_roles` (`id_role`, `fk_group`, `fk_user`, `role`) VALUES (3, 7, 3, '');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `deskweb033_todo`
-- 

CREATE TABLE `deskweb033_todo` (
  `id_todo` int(11) NOT NULL auto_increment,
  `attivita` varchar(255) default NULL,
  `scadenza` datetime default NULL,
  `percentuale` int(3) default NULL,
  `descrizione` text,
  PRIMARY KEY  (`id_todo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- 
-- Dump dei dati per la tabella `deskweb033_todo`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `deskweb033_users`
-- 

CREATE TABLE `deskweb033_users` (
  `id_user` int(10) unsigned NOT NULL default '0',
  `username` varchar(60) NOT NULL default '',
  `pass` varchar(32) NOT NULL default '',
  `mail` varchar(64) default '',
  `note` text,
  `fk_firstgroup` int(10) unsigned default '0',
  `desktop_bg` varchar(20) default 'green',
  PRIMARY KEY  (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dump dei dati per la tabella `deskweb033_users`
-- 

INSERT INTO `deskweb033_users` (`id_user`, `username`, `pass`, `mail`, `note`, `fk_firstgroup`, `desktop_bg`) VALUES (0, 'guest', '', '', NULL, 0, 'green'),
(1, 'root', 'c4ca4238a0b923820dcc509a6f75849b', 'root@deskweb.org', NULL, 1, '#C90000'),
(1000, 'max', 'c4ca4238a0b923820dcc509a6f75849b', '', NULL, 1000, 'green');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `deskweb033_wishlist`
-- 

CREATE TABLE `deskweb033_wishlist` (
  `id_wishlist` int(11) NOT NULL auto_increment,
  `titolo` varchar(255) default NULL,
  `data` datetime default NULL,
  `esaudito` tinyint(1) unsigned default NULL,
  `descrizione` text,
  `fk_user` int(11) unsigned default NULL,
  PRIMARY KEY  (`id_wishlist`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dump dei dati per la tabella `deskweb033_wishlist`
-- 

INSERT INTO `deskweb033_wishlist` (`id_wishlist`, `titolo`, `data`, `esaudito`, `descrizione`, `fk_user`) VALUES (1, 'gestione ruoli', '2006-06-14 00:00:00', 0, '', 1),
(2, 'home utenti', '2006-06-14 00:00:00', 0, '', 0);
