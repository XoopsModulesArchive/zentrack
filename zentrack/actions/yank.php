<?php {
  /*
  **  YANK TICKET
  **  
  **  Pull a ticket from it's owner
  **
  */
  
  $action = "yank";  
  include_once("./action_header.php");
  
  if( $actionComplete == 1 ) {
    $input = array(
    "id"       => "int",
    "comments" => "html"
    );
    $zen->cleanInput($input);
    $required = array("id");
    foreach($required as $r) {
      if( !$$r ) {
        $errs[] = tr(" ? is required", array($r));
      }
    }
    
    if( !$errs ) {
      $res = $zen->yank_ticket($id, $login_id, $comments);
      if( $res ) {
        $msg[] = tr("Ticket pulled from ?",$zen->formatName($ticket["user_id"]));
        $setmode = null;
        $action = null;
        include("../ticket.php");
        exit;
        //header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
      } else {
        $errs[] = tr("System error: Ticket ? could not be yanked.", array($id)) .$zen->db_error;
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