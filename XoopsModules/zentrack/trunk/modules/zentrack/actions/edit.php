<?php
  /*
  **  Action: edit ticket
  */
  include("action_header.php");
  
  
  $page_title = tr("Edit Ticket");
  include("$libDir/nav.php");
  $onLoad = array("behavior_js.php?formset=ticketForm");

  include("$templateDir/editTicketForm.php");

  include("$libDir/footer.php");
?>
