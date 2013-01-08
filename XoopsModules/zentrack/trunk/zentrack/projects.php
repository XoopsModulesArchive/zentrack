<?
  /*
  **  PROJECTS LIST PAGE
  **  
  **  Lists all current projects
  **
  */  
  
  include("header.php");
  
  $page_title = "Projects";
  $page_section = "Projects";
  $page_type = 'project';
  $view = 'project_list';
  include("$libDir/nav.php");
  
  $userBins = $zen->getUsersBins($login_id);
  if( !is_array($userBins) || count($userBins) < 1 ) {
    print "<p class='hot'>" . tr("You do not have access to any bins") . "</p>\n";     
  } else {
    include("$templateDir/listTickets.php");
  }
  include("$libDir/footer.php");
?>