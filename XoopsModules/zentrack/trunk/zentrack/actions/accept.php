<?php {
  /*
  **  ACCEPT TICKET
  **  
  **  Make logged in user the owner
  **  of this ticket
  **
  */

  $action = "accept";  
  include("action_header.php");

   $res = $zen->accept_ticket($id, $login_id);
   if( $res ) {
      $msg[] = tr("Ticket ? was accepted by ?", array($id,$login_name));
   } else {
      $errs[] = tr("System error: Ticket ? could not be accepted", array($id)).$zen->db_error;
   }
  $setmode = null;
  $action = null;
   
   include("$libDir/nav.php");
   $zen->printErrors($errs);
   $ticket = $zen->get_ticket($id);
   if( $zen->inProjectTypeIDs($type_id) ) {
      include("$templateDir/projectView.php");
   } else {
      include("$templateDir/ticketView.php");     
   }

   include("$libDir/footer.php");

}?>
