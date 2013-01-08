<?php
  /*
  **  NEW USER
  **  
  **  Creates a new zenTrack user
  **
  */
  
  
  include("admin_header.php");

  $page_title = tr("New User");

  include("$libDir/admin_nav.php");
//  include("$libDir/nav.php");


showTabbedMenu(1);

  include("$templateDir/userAdd.php");

  include("$libDir/footer.php");

?>
