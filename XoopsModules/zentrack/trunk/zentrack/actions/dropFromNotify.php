<?php {
  /**
  **  ADD ENTRIES TO NOTIFY LIST
  **  
  **  Checks for duplicates and adds users/email addresses
  **  to a ticket's notify list
  */
  
  // get action properties
  $action = "notify";  
  include("./action_header.php");
  
  if( is_array($drops) ) {
    // drop items in list
    $num = 0;
    for($i=0; $i<count($drops); $i++) {
      // clean up numbers just in case
      $n = $zen->checkNum($drops[$i]);
      if( strlen($n) ) {
        // do the drop
        $res = $zen->delete_from_notify_list($n);
        // calculate the number of results
        if( $res ) {
          $num += 1;
        }
      }
    }
    $msg[] = tr("? recipients dropped from the notify list", $num);
    $action = '';
  }
  else {
    // create an error message
    $msg[] = tr("No recipients were selected to drop");
    $action = '';
  }
  
  
  // display the results
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  if( $zen->inProjectTypeIDs($type_id) ) {
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }  
  include("$libDir/footer.php");    
  
}?>