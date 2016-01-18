<?php {
  /**
   **  ADD ENTRIES TO NOTIFY LIST
   **  
   **  Checks for duplicates and adds users/email addresses
   **  to a ticket's notify list
   */
  
  $action = "contacts";
  include_once("action_header.php");
  
    // check to insure that this user has access
  // and this ticket allows the requested action
  // to be completed
  $ticket = $zen->get_ticket($id);
  $tid = $ticket["type_id"];
  $type_id = $tid;
  if( in_array($tid,$zen->projectTypeIDs()) ) {
    $ticket["children"] = $zen->getProjectChildren($id, 
	    array("id,title,status,est_hours,wkd_hours"));
    list($ticket["est_hours"],$ticket["wkd_hours"]) = $zen->getProjectHours($id);
    $page_type = "project";
    $view = 'project_view';
  }  else {
    $page_type = "ticket";
    $view = 'ticket_view';
  }
  
  $page_title = tr("Ticket #?", array($id));
  $page_section = "Ticket #$id";
  
  if( $actionComplete == 1 ) {
    // check user acces
    if( !$zen->checkAccess($login_id,$ticket['bin_id'],$map->getViewProp($setmode,'access_level')) ) {
      $errs[] = tr("You cannot access this area");
    }
    
    // check to make sure the contacts appear on the tab
    $p1 = $map->getViewProp($setmode,'preload');
    $p2 = $map->getViewProp($setmode,'postload');
    if( (!$p1 || !in_array('contacts',$p1)) && (!$p2 || !in_array('contacts',$p2)) ) {
      $errs[] = tr("You cannot access this area");
    }
    
    $priority = 1;
    // clean input vars
    $cp_id = null;
		$type = null;

    if($company_id==0 && $person_id==0) {
      $errs[] = tr("You must select a Company or Person.");
    }
    
    $dups = false;
    $parms = array(array("ticket_id", "=", $id));
    $currentContacts = $zen->get_contacts($parms,$zen->table_related_contacts);
    if( $currentContacts ) {
      foreach($currentContacts as $c) {
        if( !$person_id && $c['type'] == 1 && $company_id && $c['cp_id'] == $company_id ) { 
          $msg[] = tr("Company already in contact list");
          $dups = true;
          break;
        }
        else if( $person_id && $c['type'] != 1 && $c['cp_id'] == $person_id ) { 
          $msg[] = tr("Employee already exists in contact list");
          $dups = true;
          break;
        }
      }
    }
    
    if($company_id) {
      $cp_id = $company_id;
      $type = "1";  
	  }
	  
	  if($person_id) {
      $cp_id = $person_id;
      $type = "2";  
	  }

    if( !$errs && !$dups ) {
      $params = array("type" => $type, "cp_id"  => $cp_id, "ticket_id" => $id);
      $res = $zen->add_contact( $params,$zen->table_related_contact);
      if( $res ) {
        $msg[] = tr("Contact added successfully");
        $action = '';
      }
      else {
        $errs[] = tr("Unable to add contact due to system error");
      }
    }
  }

  
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  if( strtolower($zen->types["$type_id"]) == "project" ) {
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }
  include("$libDir/footer.php");

}?>
