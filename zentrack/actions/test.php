<?{
  
  /*
  **  TEST TICKET
  **  
  **  Set testing status to completed for a ticket.
  **
  */
  
  $action = "test";  
  include("action_header.php");
  
  if( $actionComplete == 1 ) {
    $input = array(
    "id"       => "int",
    "hours"    => "num",
    "comments" => "html"
    );
    if( !$errs ) {
      $res = $zen->test_ticket($id, $login_id, $hours, $comments);
      if( $res ) {
        $msg[] = tr("Ticket marked as tested");
        $ticket = $zen->get_ticket($id);
        if( $ticket['status'] == 'CLOSED' ) {
          $msg[] = tr("Ticket status moved to CLOSED");
        }
        $setmode = null;
        $action = null;
        include("../ticket.php");
        exit;
        //header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
      } else {
        $errs[] = tr("System error: Ticket ? could not be tested", array($id)).$zen->db_error;
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