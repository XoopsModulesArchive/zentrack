<?
  /*
  **  Action: add an employee to a contact
  */
  include_once("../contact_header.php");
  $page_title = tr("Contact #?", $id);
  $expand_contact = 1;
  
  
  include("$libDir/nav.php");

  include("$templateDir/newContacteForm.php");

  include("$libDir/footer.php");
?>
