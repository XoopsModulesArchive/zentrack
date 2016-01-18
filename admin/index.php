<?php
  /*
  **  ADMIN INDEX PAGE
  **  
  **  Checks access and shows settings menus for qualified users
  **
  */
  
  
  include("admin_header.php");
  $page_title = tr("Admin Section");
  include("$libDir/admin_nav.php");
  include("$templateDir/adminMenu.php");
  include("$libDir/footer.php");

?>
