<?php {
  /*
  **  ESTIMATE TICKET HOURS
  **  
  **  set the number of hours this ticket is expected
  **  to take to complete
  */

  $action = "estimate";  
  include("action_header.php");

  if( $actionComplete == 1 ) {
     $input = array(
		    "id"       => "int",
		    "hours"    => "num"
		    );
     $zen->cleanInput($input);
     $required = array_keys($input);
     foreach($required as $r) {
	if( !$$r ) {
	   $errs[] = tr(" ? is required", array($r));
	}
     }
     
     if( !$errs ) {
	$params = array("est_hours"=>$hours);
	$res = $zen->update_ticket($id, $params);
	if( $res ) {
	   add_system_messages(tr("Ticket ? hours set to ?", array($id, $hours)));
	   $setmode = "details";
	   include("../ticket.php");
	   exit;
	   //header("Location:$rootUrl/ticket.php?id=$id&setmode=details");
	} else {
	   $errs[] = tr("System error: Ticket ? hours could not be set", array($id)).$zen->db_error;
	}
     }
     if( $errs )
       add_system_messages( $errs, 'Error' );     
  }

  include("$libDir/nav.php");

  if( strtolower($zen->types["$type_id"]) == "project" ) {
     include("$templateDir/projectView.php");
  } else {
     include("$templateDir/ticketView.php");     
  }

  include("$libDir/footer.php");

}?>
