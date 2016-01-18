<?php {
  /*
  **  REJECT TICKET
  **  
  **  Return a ticket to the sender
  **
  */

  $action = "reject";  
  include("action_header.php");
  
  if( $actionComplete == 1 ) {
    $input = array(
    "id"       => "int",
    "comments" => "html"
    );
    $zen->cleanInput($input);
    $required = array_keys($input);
    foreach($required as $r) {
      if( !$$r ) {
        $errs[] = " $r is required";
      }
    }
    
    if( !$errs ) {
      $res = $zen->reject_ticket($id, $login_id, $comments);
      if( $res ) {
        $ticket = $zen->get_ticket($id);
        $to = $ticket['user_id']? $zen->formatName($ticket['user_id']) : '';
        if( $ticket['bin_id'] ) {
          $to = $ticket['user_id']? $to . '(' . $zen->getBinName($ticket['bin_id']) . ')' :
             $zen->getBinName($ticket['bin_id']);
        }
        $msg[] = tr("Ticket was rejected to ?", array($to));
        $setmode = null;
        $action = null;
        include("../ticket.php");
        exit;
      } else {
        $errs[] = tr("System error: Ticket ? could not be rejected", array($id)).$zen->db_error;
      }
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