<?php {
  /*
  **  DELETE ATTACHMENTS
  */
  
  $action = "upload";  
  include("action_header.php");
  
  if( !$drops ) {
    $msg[] = tr("No attachments were selected to delete");
  }
  else {
    $possibles = array();
    $vals = $zen->get_attachments($id);
    if( $vals ) {
      foreach($vals as $v) {
        $possibles["{$v['attachment_id']}"] = $v;
      }
    }
    $do = array();
    foreach($drops as $d) {
      if( !$possibles["$d"] ) {
        $errs[] = tr("Attachment ? does not belong to this ticket", $d);
      }
      else {
        $do[] = $zen->checkNum($d);
      }
    }
    if( count($do) ) {
      $c = $zen->delete_attachment($drops);
      $msg[] = tr("? attachments deleted", $c);
    }
  }
  
  include("$libDir/nav.php");
  $action = '';
  $zen->printErrors($errs);  
  if( $page_type == "project" ) {
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }
  include("$libDir/footer.php");
  
}?>