<?php
  if( !ZT_DEFINED ) { die("Illegal Access"); }
  
  if( !$zen->checkAccess($login_id,$ticket["bin_id"],"edit") ) {
    $errs[] = tr("You cannot edit a ticket in this bin ");
  } else if( !$zen->actionApplicable($id,"edit",$login_id) ) {
    $errs[] = $zen->ptrans("Ticket #? cannot be edited in its current status",array($id));
  }

  $page_title = tr("Commit Edited Ticket");

  // initiate default values
  if( !$tested )
     $tested = 0;
  if( !$approved )
     $approved = 0;
  if( $type == "project" )
     $type_id = $zen->projectTypeID();

  $is_project = $type == 'project' || $zen->inProjectTypeIds($type_id);
  $view = $is_project? 'project_edit' : 'ticket_edit';

//  print "pre ctime: $ctime<br>\n";//debug
  
  include("$libDir/validateFields.php");
  
//  print "post ctime: $ctime<br>\n";//debug
  
  if( !$errs ) {
     $params = array();
     // create an array of existing fields
     foreach(array_keys($fields) as $f) {
       // can't edit the status
       if( $f == 'status' ) { continue; }
       // put the value into the updates array
       $params["$f"] = $$f;
       if( $f == 'title' && strlen($params["$f"]) > 50 ) {
         $params["$f"] = substr($params["$f"],0,50);
       }
     }

     if ( !$varfields )  {
       $varfield_params=null;
     }

     $zen->update_all_ticket_fields($id, $login_id, $bin_id, $params,
                                    $varfield_params, "EDIT", "Ticket edited", $edit_reason);
/*
     // update the ticket info
     $res = $zen->edit_ticket($id,$login_id,$params,$edit_reason);
     // check for errors
     if( !$res ) {
       $errs[] = tr("System Error").": ".tr("Ticket could not be edited.")." ".$zen->db_error;
     }
     else if( $varfields && count($varfield_params) ) {
       $res = $zen->updateVarfieldVals($id, $varfield_params, $login_id, $bin_id);
       if( !$res ) {
         $errs[] = tr("? updated, but variable fields could not be saved", array(tr($x)));
       }
     }
*/
  }
  
  if( !$errs ) {
    $msg[] = tr("Edited ticket #?", array($id));
    //header("Location:$rootUrl/ticket.php?id=$id&setmode=Details");
    $setmode = "";
    if( $is_project ) {
      include("../project.php");
    } else {
      include("../ticket.php");
    }
    exit;
  } else {
    $onLoad[] = "behavior_js.php?formset=ticketForm";
    include_once("$libDir/nav.php");
    $zen->print_errors($errs);
    $TODO = 'EDIT';
    if( $is_project ) {
      $view = "project_edit";
    }
    else {
      $view = "ticket_edit";
    }
    include("$templateDir/newTicketForm.php");
    include("$libDir/footer.php");
  }
?>
