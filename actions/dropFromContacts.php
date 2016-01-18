<?php {

  // get action properties
  $action = "contacts";  
  include("action_header.php");
  
  // check to insure that this user has access
  // and this ticket allows the requested action
  // to be completed
  $ticket = $zen->get_ticket($id);
  $tid = $ticket["type_id"];
  if( in_array($tid,$zen->projectTypeIDs()) ) {
    $ticket["children"] = $zen->getProjectChildren($id, 
	    array("id,title,status,est_hours,wkd_hours"));
    list($ticket["est_hours"],$ticket["wkd_hours"]) = $zen->getProjectHours($id);
    $page_type = "project";
  }  else {
    $page_type = "ticket";
  }
  $page_mode = $setmode;

  
  $page_title = tr("Ticket #?", array($id));
  $page_section = "Ticket #$id";
  
  if( is_array($drops) ) {
    // drop items in list
    $num = 0;
    for($i=0; $i<count($drops); $i++) {
      // clean up numbers just in case
      $n = $zen->checkNum($drops[$i]);
      if( strlen($n) ) {
        // do the drop
        $res = $zen->delete_contact( $n,$zen->table_related_contacts,"clist_id");
        // calculate the number of results
        if( $res ) {
          $num++;
        }
        else {
          $errs[] = tr("Contact #? could not be removed",$n);
        }
      }
    }
    if( !$errs ) { 
      $action = ''; 
      $msg[] = $num > 1?
        tr("? contacts were removed", array($num)) :
        tr("One contact was removed");
    }
  }
  else {
    // create an error message
    $errs[] = tr("No contacts were selected to drop");
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