#!/usr/bin/php -q
<?
/**
 ** EGATE CHECK CREATE - checks a pop3 account for emails, and 
 ** creates tickets from them via the egate_utils.  This script
 ** ONLY creates tickets.  The subject becomes the title of the
 ** ticket, and the body becomes the details.
 ** 
 ** All other settings are determined from the defaults set in 
 ** egate_congif.php
 */
  
  $start_time = time();

  // include utils and config
  include("egate_utils.php");
  
  // check for imap install
  if( !function_exists("imap_open") ) {
    egate_log("Imap functions haven't been installed.  See installation section on email gateway for details",1);
    egate_log_write();
    exit;
  }

  // connect to mailbox
  $mb = imap_open($smtp_string, $smtp_user, $smtp_pass);
  
  // return error if needed
  if( !$mb ) {
    $errs = imap_errors();
    if( is_array($errs) && count($errs) ) {
      egate_log($errs,2);
    } else {
      egate_log("Mailbox was empty",3);
    }
    egate_log_write();
    exit;
  }

  // get the number of messages in the box
  // and log it
  $number_of_messages = imap_num_msg($mb);
  egate_log("Mailbox contains $number_of_messages message".($number_of_messages!=1?"s":""),2);
  
  // collect messages
  for($i=1; $i<=$number_of_messages; $i++) {
    // get the body and header for the message
    $header = imap_fetchheader($mb,$i);
    $body = imap_body($mb,$i);
    // process the message
    create_ticket_from_message($header."\n\r".$body);
    // flag messages for deletion
    imap_delete($mb,$i);
  }
  
  // delete messages from box
  imap_expunge($mb);

  // close the connection
  imap_close($mb);
  
  $exectime = time()-$start_time;
  egate_log("Completed in $exectime seconds",3);
  egate_log_write();
  
?>
