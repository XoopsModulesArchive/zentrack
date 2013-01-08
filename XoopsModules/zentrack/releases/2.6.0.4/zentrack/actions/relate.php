<?{
  
  /*
  **  RELATE TICKET
  **  
  **  create associations between this ticket and others
  **
  */
  
  $action = "relate";  
  include("action_header.php");
  
  if( $actionComplete == 1 ) {
    $relations = ereg_replace("[^0-9,\n]", "", $relations);
    $relations = split(" *[,\n] *", $relations);
    $input = array(
    "id"        => "int",
    "relations" => "ignore",
    "comments"  => "html"
    );
    $zen->cleanInput($input);
    $required = array("relations","id");
    foreach($required as $r) {
      if( !$$r ) {
        $errs[] = tr(" ? is required", array($r));
      }
    }
    
    if( !$errs ) {
      $res = $zen->relate_ticket($id, $relations, $login_id, $comments);
      if( $res ) {
        $msg[] = tr("Ticket ? related.", $id);
        $action = '';
      } else {
        $errs[] = tr("System error: Ticket ? could not be related, or the entries were the same.", array($id)).$zen->db_error;
      }
    }
  }
  
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  if( is_array($relations) ) {
    $relations = join("\n", $relations);
  } else {
    $relations = ereg_replace(",", "\n", $ticket["relations"]);
  }
  if( $actionComplete == 1 )
    $ticket = $zen->get_ticket($id);
  if( $zen->inProjectTypeIDs($type_id) ) {
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }
  
  include("$libDir/footer.php");
  
}?>