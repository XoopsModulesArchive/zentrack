<?
  /*
  **  NEW TICKET (add submit)
  **  
  **  Commit new ticket to database
  **
  */
  
  
  include_once("./header.php");

  
  
  
  if( !$zen->checkAccess($login_id,$bin_id,"create") ) {
    $page_title = tr("Access Error");
    $msg[] = tr("You do not have permission to create tickets in this bin."); 
    include("$libDir/nav.php");     
    include("$libDir/footer.php");
    exit;
  }
  
  $page_type = 'ticket';
  $view = 'ticket_create';
  
  $page_title = tr("Commit New Ticket");
  $expand_tickets = 1;
  
  // initiate default values
  $otime = time();  // set time ticket opened

  include("$libDir/validateFields.php");

  if( !$errs ) {
    // create an array of existing fields
    // to be inserted for the ticket
    foreach(array_keys($fields) as $f) {
      if( strlen($$f) ) {
        $params["$f"] = $$f;
        if( $f == 'title' && strlen($params["$f"]) > 50 ) {
          $params["$f"] = substr($params["$f"],0,50);
        }
        else if( $f == 'project_id' ) {
          $vs = isset($$f)? (is_array($$f)? $$f : explode(',',$$f)) : array();
          if( in_array($id, $vs) ) {
            $errs[] = "A ticket cannot belong to itself, project id is invalid";
          }
        }
      }
    }
    $params["creator_id"] = $login_id;
    
    if( !$errs ) {
      // add the ticket to database
/*
      $id = $zen->add_ticket($params);
      // update the variable field entries for this ticket
      if( $id && $varfields && count($varfield_params) ) {
        $res = $zen->updateVarfieldVals($id, $varfield_params);
        if( !$res ) {
          $errs[] = tr("? created, but variable fields could not be saved", array(tr('Ticket')));
        }      
      }
*/
      $errs = $zen->add_new_ticket($id,$params,$varfield_params);
      
      // check for errors
      if( !$id ) {
        $errs[] = tr("Could not create ticket."). " ".$zen->db_error;
      }
      else if( in_array($params["type_id"],$zen->noteTypeIDs()) ) {
        $zen->close_ticket($id,null,null,'Notes closed automatically');
      }
    } // if( !$errs )
    
  } // if( !$errs )
  
  if( !$errs ) {
    $setmode = null;
    $action = null;
    $ticketTabAction = 0;
    include("ticket.php");
    exit;
    //header("Location:$rootUrl/ticket.php?id=$id");
  } else {
    $onLoad[] = "behavior_js.php?formset=ticketForm";
    include("$libDir/nav.php");
    $zen->print_errors($errs);
    $view = "ticket_create";
    include("$templateDir/newTicketForm.php");
    include("$libDir/footer.php");
  }
?>
