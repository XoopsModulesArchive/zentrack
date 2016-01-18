<?php {
  /*
  **  REOPEN TICKET
  **  
  **  Open a ticket which was closed in error
  **
  */
  
  $action = "reopen";  
  include("action_header.php");
  
  if( $actionComplete == 1 ) {
    if( !$tested ) {
      $tested = 0;
    }
    if( !$approved ) {
      $approved = 0;
    }
    $input = array(
    "id"       => "int",
    "comments" => "html"
    );
    $zen->cleanInput($input);
    $required = array("id","comments");
    foreach($required as $r) {
      if( !strlen($$r) ) {
        $errs[] = tr(" ? is required", array($r));
      }
    }
    
    if( !$errs ) {
      $res = $zen->reopen_ticket($id, $login_id, $comments);
      if( $res ) {
        $msg[] = tr("Ticket reopened, status moved to OPEN");
        $setmode = null;
        $action = null;
        include("../ticket.php");
        exit;
      } else {
        $errs[] = tr("System error: Ticket ? could not be reopened.", array($id)) .$zen->db_error;
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
