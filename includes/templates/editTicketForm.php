<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  // if there is an ID, open it up
  // otherwise, ask for the ticket ID
  $skip = 0;
  if( $id ) {
    // run a whole bunch of error checks before
    // letting the user edit the ticket
    $ticket = $zen->get_ticket($id);
    if( !is_array($ticket) ) {
      $errs[] = tr("Ticket #? could not be found",array($id));
    } else if( !$zen->checkAccess($login_id,$ticket["bin_id"],"edit") ) {
      $errs[] = tr("You cannot edit a ticket in this bin");
    } else if( !$zen->actionApplicable($id,"edit",$login_id) ) {
      $errs[] = tr("Ticket #? cannot be edited in its current status",array($id));
    } else {      
      $skip = 1;
      $TODO = 'EDIT';
      $varfields = $zen->getVarfieldVals($id);
      extract($varfields);
      extract($ticket);
      $description = preg_replace("@<br ?/?>@","\n",$description); 
      if( $zen->inProjectTypeIDs($ticket["type_id"]) ) {
        $view = "project_edit";
      } else {
        $view = "ticket_edit";
      }
      include("$templateDir/newTicketForm.php");
    }
  } 
  if( !$skip ) {
    $zen->printErrors($errs);
   ?>
   <br><blockquote>
      <b><?=tr("Please enter a ticket ID")?></b>
   <form action='<?=$SCRIPT_NAME?>'>
    <input type="text" name="id" size="8" maxlength="12">
   </form> 
    <?php
  }
?>

