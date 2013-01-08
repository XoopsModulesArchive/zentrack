#!/usr/bin/php -q
<?{
  /*
  **  EGATE: Email gateway: collects email input from stdin and modifies tickets
  */

  // include the utils and config
  include("egate_utils.php");
  //include("egate_utils_relaxed.php"); //less strict rules about input to egate system
  
  // read email from stdin
  $input = join("",file("php://stdin"));  

  // process the email
  process_message($input);

  // clean the log file
  egate_log_write();

}?>
