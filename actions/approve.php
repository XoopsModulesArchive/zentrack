<?php {
  /*
  **  APPROVE TICKET
  **  
  **  Approve closing of a ticket
  **
  */
  
  $action = "approve";  
  include("action_header.php");
  
  $input = array(
  "id"       => "int",
  "comments" => "html"
  );
  $zen->cleanInput($input);
  
  if( !$errs ) {
    $res = $zen->approve_ticket($id, $login_id, $comments);
    if( $res ) {
      $msg[] = tr("Ticket was approved and closed");
      $setmode = null;
      $action = null;
      include("../ticket.php");
      exit;       
    } else {
      $errs[] = tr("System error: Ticket ? could not be approved", array($id)).$zen->db_error;
    }
  }
  
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  $ticket = $zen->get_ticket($id);
  if( $zen->inProjectTypeIDs($ticket['type_id']) ) {
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }
  
  include("$libDir/footer.php");
  
}?>
