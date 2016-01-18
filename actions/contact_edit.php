<?php
  /*
  **  Action: edit ticket
  */
  include_once("../contact_header.php");
  $page_title = tr("Contact #?", array($id));
  $expand_contact = 1;
  
  
  include("$libDir/nav.php");

  include("$templateDir/editContactForm.php");

  include("$libDir/footer.php");
?>
