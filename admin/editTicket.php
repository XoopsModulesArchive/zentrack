<?php {
  /*
  **  EDIT TICKET
  **  
  **  Edit the properties for a ticket
  **
  */
  
  
  include("admin_header.php");
  $page_title = tr("Edit Ticket");
  $onLoad = array("behavior_js.php?formset=ticketForm");
  include("$libDir/admin_nav.php");
showTabbedMenu(3);

  include("$templateDir/editTicketForm.php");

  include("$libDir/footer.php");

}?>
