<?php
  /*
  **  MOVE TICKET
  **  
  **  Move ticket to a new bin
  **
  */

  $action = "move";  
  include("action_header.php");

  if( $actionComplete == 1 ) {
    $user_id = $login_id;
    $input = array(
    "id"       => "int",
    "newBin"   => "int",
    "user_id"   => "int",
    "comments" => "html"
    );
    $zen->cleanInput($input);
    $required = array("id","newBin","user_id");
    foreach($required as $r) {
      if( !$$r ) {
        $errs[] = tr(" ? is required", array($r));
      }
    }
    
    if( !$errs ) {
      $res = $zen->move_ticket($id, $newBin, $login_id, $comments);
      if( $res ) {
        $msg[] = tr("Ticket '?' moved to bin '?'", array($id, $zen->bins["$newBin"]));
        $setmode = "";
        $action = '';
        include("$rootWWW/ticket.php");
        exit;
        //header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
      } else {
        $errs[] = tr("System error: Ticket ? could not be moved. ", array($id)).$zen->db_error;
      }
    }
  }

  include("$libDir/nav.php");
  $zen->printErrors($errs);

  // the ticket is retrieved in action_header, don't do that here
  if( $page_type == "project" ) {
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }

  include("$libDir/footer.php");
?>
