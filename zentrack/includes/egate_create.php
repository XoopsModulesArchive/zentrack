#!/usr/bin/php -q
<?{
  /*
  **  EGATE: Email gateway: collects email input from stdin and creates a new ticket
  **  
  **  The subject becomes the title, the body becomes the details.  The rest of the 
  **  fields are set via the default values in egate_congfig.php
  */

  // include the utils and config
  include("egate_utils.php");
  
  // read email from stdin
  $input = join("",file("php://stdin"));  

  // process the email
  create_ticket_from_message($input);

  // clean the log file
  egate_log_write();

}?>
