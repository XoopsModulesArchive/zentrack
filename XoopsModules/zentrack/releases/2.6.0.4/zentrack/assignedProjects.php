<?
  /*
  **  PROJECTS LIST PAGE
  **  
  **  Lists all current projects
  **
  */  
  
  include("header.php");

  $page_type = "project";
  $view = 'assigned_list';

  $page_title = tr("Projects");
  $page_section = "Projects";
  include("$libDir/nav.php");
  
  $params = array(
		  "type_id"  => $zen->projectTypeIDs(),
		  "status"   => array("OPEN","PENDING"),
		  "user_id"  => $login_id,
      "bin_id"   => $zen->getUsersBins($login_id)
		  );
    
  include_once("$libDir/sorting.php");
  $tickets = $zen->get_tickets($params, $sortstring);
  include("$templateDir/listTickets.php");

  include("$libDir/footer.php");
?>