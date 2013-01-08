<?
  /*
  **  USER OPTIONS
  **  
  **  Provide user specific options such as passphrase changing
  **  and preferences
  **
  */
  
  include("header.php");

  $page_title = tr("User Options");
  $expand_options = 1;
  include("$libDir/nav.php");
  include("$templateDir/optionsMenu.php");
  include("$libDir/footer.php");
?>
