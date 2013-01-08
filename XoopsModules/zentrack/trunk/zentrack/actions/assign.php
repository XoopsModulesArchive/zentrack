<?{
  
  /*
  **  ASSIGN TICKET
  **  
  **  Make the owner of a ticket the specified user
  **
  */
  
  $action = "assign";  
  include("action_header.php");
  
  if( $actionComplete == 1 ) {
    $input = array(
    "id"       => "int",
    "user_id"   => "int",
    "comments" => "html"
    );
    $zen->cleanInput($input);
    $required = array("user_id","id");
    foreach($required as $r) {
      if( !$$r ) {
        $errs[] = tr(" ? is required", array($r));
      }
    }
    
    if( !$errs ) {
      $res = $zen->assign_ticket($id, $user_id, $login_id, $comments);
      if( $res ) {
        $msg[] = tr("Ticket was assigned to ?",$zen->formatName($user_id));
        $setmode = "";
        $action = "";
        include("../ticket.php");
        exit;
      } else {
        $errs[] = tr("System error: Ticket could not be assigned").$zen->db_error;
      }
    }
  }
  
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  
  $ticket = $zen->get_ticket($id);
  if( $zen->inProjectTypeIds($ticket['type_id']) ) {
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");
  }
  
  include("$libDir/footer.php");
  
}?>
