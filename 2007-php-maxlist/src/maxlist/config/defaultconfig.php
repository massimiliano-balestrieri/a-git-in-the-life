<?php

/***
 * Project: Maxlist <br />
 * Copyright (C) 2007 Massimiliano Balestrieri
 * 
 * Software based on : 
 * PHPlist, Mailinglist system using PHP and Mysql
 * Copyright (C) 2000,2001,2002,2003,2004,2005 Michiel Dethmers, tincan ltd
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 *
 * Maxlist is a fork of PhpList, a newsletter manager. 
 * The code was deeply changed so there are features of the original phpList and new ones. 
 * It uses smarty, generates XHTML strict, uses an AJAX layer, italian language ,
 * multi-istance, and use case based.
 *
 * 
 * $Id: defaultconfig.php 335 2007-12-01 17:59:29Z maxbnet $
 * $LastChangedDate: 2007-12-01 17:59:29 +0000 (Sat, 01 Dec 2007) $
 * $LastChangedRevision: 335 $
 * $LastChangedBy: maxbnet $
 * $HeadURL: file:///svn/p/maxlist/code/trunk/maxlist/config/defaultconfig.php $
 * 
 * $Author: maxbnet $
 * $Date: 2007-12-01 17:59:29 +0000 (Sat, 01 Dec 2007) $
 */
 
//TODO : remove globals
//IMPORTANT: key must URL VALID 
$GLOBALS['default_config'] = array (
 
"website" => array($D_website,
    "Website address (without http://)","text",1),
 
"domain" =>  array($D_domain,
    "Domain Name of your server (for email)","text",1),

"admin_address" => array('webmaster@[DOMAIN]',
    "Person in charge of this system (one email address)","text",1),

"admin_addresses" => array('',
    "List of people to CC in system emails (separate by commas)","text",1),
    
 # report address is the person who gets the reports
"report_address" => array('reports@[DOMAIN]',
    "Who gets the reports (email address, separate multiple emails with a comma)","text",1),

# where will messages appear to come from
"message_from_address" => array("noreply@[DOMAIN]",
  "From email address for system messages","text",1),

"message_from_name" => array("Webmaster",
  "What name do system messages appear to come from","text",1),
  
# what is the reply-to on messages?
"message_replyto_address" => array("noreply@[DOMAIN]",
  "Reply-to email address for system messages","text",1),

# mailer
"html_charset" => array("iso-8859-1","Charset for HTML messages","text",1),
"text_charset" => array("iso-8859-1","Charset for Text messages","text",1),

# the default template for sending an html message
"default_message_template" => array(0,
"The default HTML template to use when sending a message","text",1),

# urls

# subscribe
"subscribeurl" => array("subscribe","URL where users can subscribe","text",1),//TODO:ISTANCE
# unsubscribe
"unsubscribeurl" => array("subscribe/unsubscribe/","URL where users can unsubscribe","text",1),
# confirm
"confirmationurl" => array("subscribe/confirm/", "URL where users have to confirm their subscription","text",1),
# preferences
"preferencesurl" => array("subscribe/preferences/", "URL where users can update their details","text",1),

#subscribe
"subscribesubject" => array("Newsletter [ISTANCE] - Richiesta di conferma iscrizione",
  "Subject of the message users receive when they subscribe","text",1),
  
# message that is sent when people sign up to a list
# [LISTS] will be replaced with the list of lists they have signed up to
# [CONFIRMATIONURL] will be replaced with the URL where a user has to confirm
# their subscription
"subscribemessage" => array('
  Benvenuto nella newsletter [ISTANCE]
    
  Hai scelto le seguenti categorie:
  [LISTS]

  Per confermare l\'iscrizione vai all\'indirizzo
  [CONFIRMATIONURL]  
  
  Grazie.
  ',
  "Message users receive when they subscribe","textarea",2),

# subject of the message when they unsubscribe
"unsubscribesubject" => array( "Newsletter [ISTANCE] - Cancellazione iscrizione",
  "Subject of the message users receive when they unsubscribe","text",1),

# message that is sent when they unsubscribe
"unsubscribemessage" => array('

  Hai revocato l\'iscrizione alla Newsletter [ISTANCE].
  Non riceverai piu\' e-mail della Newsletter. 

  Arrivederci e grazie.
',
  "Message users receive when they unsubscribe","textarea",2),

# the subject of the message sent when changing the user details
"updatesubject" => array("Newsletter [ISTANCE] - Aggiornamento iscrizione",
  "Subject of the message users receive when they have changed their details","text",1),
  
# the message that is sent when a user updates their information.
# just to make sure they approve of it.
# confirmationinfo is replaced by one of the options below
# userdata is replaced by the information in the database
"updatemessage" => array('

  Hai modificato i dati relativi alla newsletter [ISTANCE].

  Sei attualmente iscritto alle seguenti categorie:
  [LISTS]
  [CONFIRMATIONINFO]
  
  Hai modificato i seguenti dati:
  [USERDATA]
  
  Per visualizzare i dati modificati e le tue preferenze:
  [PREFERENCESURL]

  Grazie.
',
  "Message that is sent when users change their information","textarea",2),
  
# confirmation of subscription
"confirmationsubject" => array("Newsletter [ISTANCE] - Conferma iscrizione",
  "Subject of the message users receive after confirming their email address","text",1),

# message that is sent to confirm subscription
"confirmationmessage" => array('
  
  Benvenuto nella newsletter [ISTANCE]

  Hai scelto le seguenti categorie:
  [LISTS]


  Per modificare i tuoi dati e le tue preferenze:
  [PREFERENCESURL]
  	
  Per cancellarti e non ricevere piu\' messaggi:
  [UNSUBSCRIBEURL]
  	

  Grazie.

',
  "Message users receive after confirming their email address","textarea",2),
  

# this is the text that is placed in the [!-- confirmation --] location of the above
# message, in case the email is sent to their new email address and they have changed
# their email address
"emailchanged_text" => array('
  When updating your details, your email address has changed.
  Please confirm your new email address by visiting this webpage:

[CONFIRMATIONURL]

',
  "Part of the message that is sent to their new email address when users change their information,
    and the email address has changed","textarea",1),

# this is the text that is placed in the [!-- confirmation --] location of the above
# message, in case the email is sent to their old email address and they have changed
# their email address
"emailchanged_text_oldaddress" => array('
  Please Note: when updating your details, your email address has changed.

  A message has been sent to your new email address with a URL
  to confirm this change. Please visit this website to activate
  your membership.
',
  "Part of the message that is sent to their old email address when users change their information,
    and the email address has changed","textarea",1), 

# footer
 
 "messagefooter" => array("--\n \n[STR_TO_UNSUBSCRIBE]\n\n[UNSUBSCRIBE]\n\n[STR_TO_UPDATE]\n\n[PREFERENCES]\n",
  "Default footer for sending a message","textarea"),
 
 );