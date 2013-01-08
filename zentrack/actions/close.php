<?php {
  /*
  **  CLOSE TICKET
  **  
  **  Close a ticket, or set the status to pending if approval and testing are 
  **  required.
  **
  */

  $action = "close";  
  include("action_header.php");
  
  if( $actionComplete == 1 ) {
/*
    $ticket = $zen->get_ticket($id);
    $varfields = $zen->getVarfieldVals($id);
    extract($varfields);
    extract($ticket);
*/
    if (!isset($hours)) $hours=0;
    if (!isset($comments)) $comments="";

    $view = 'ticket_close';
    include("$libDir/validateFields.php");
    
    $typ = $zen->getTypeName($ticket['type_id']);
    
    if( !$errs ) {
      if( $zen->inProjectTypeIDs($ticket["type_id"]) ) {
        $children = $zen->getProjectChildren($id,'id,type,status');
        if( is_array($children) ) {
          foreach($children as $c) {
            if( $c["status"] != "CLOSED" ) {
              $errs[] = tr("? #? must be closed before this project may close", array($zen->getTypeName($c['type_id']), $c['id']));
            }
          }
        }
      }
    }
    if( !$errs ) {
     $params = array();
     // create an array of existing fields
     foreach(array_keys($fields) as $f) {
       $params["$f"] = $$f;
     }

      $res = $zen->close_ticket($id, $login_id, $hours, $comments);
      if( !$res ) {
        $errs[] = tr("Could not close ticket."). " ".$zen->db_error;
      } else if( $varfields && count($varfield_params) ) {
        // update the variable field entries for this ticket
        $res = $zen->updateVarfieldVals($id, $varfield_params);
        if( !$res ) {
          $msg[] = tr("? #? closed, but variable fields could not be saved", array($typ,$id));
        } else {
          $ticket = $zen->get_ticket($id);
          if( $ticket['status'] == 'PENDING' ) {
            $msg[] = tr("? #? is now pending", array($typ,$id));
          }
          else {
            $msg[] = tr("? #? has been closed", array($typ,$id));
          }
        }
      }
      $setmode = null;
      $action = null;
      $ticketTabAction = false;
      include("$rootWWW/ticket.php");
      exit;
    }
  }

  $onLoad[] = "behavior_js.php?formset=ticketTabForm";
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
