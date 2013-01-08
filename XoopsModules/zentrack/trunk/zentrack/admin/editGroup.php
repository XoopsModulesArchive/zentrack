<?
  /*
  **  EDIT DATA GROUP
  **  
  **  Modifies an existing data group
  **
  */
  
  
  include("admin_header.php");
  if( $TODO == 'DONE' ) {
    $skip = 1;
  } else {
    $page_title = ( $TODO == "NEW" )? "New Data Group" : "Edit Data Group";
    if ( $TODO != "NEW" ) {
      $group = $zen->get_data_group($group_id);
      if( is_array($group) ) {
        $TODO = "EDIT";
        extract($group);
      } else {
        $skip=2;
      }
    }
  }


  include("$libDir/admin_nav.php");
  $zen->printErrors($errs);
  if( $skip == 1 ) {
    include("$templateDir/adminMenu.php");
  } else if ( $skip == 2 ) {
    print "<ul><div class='error'>" . tr("That group could not be found") . "</div>";
    print "<a href='$rootUrl/admin/groups.php'>" 
      . tr("Click Here to view available groups") . "</a></ul>\n";
  } else {
showTabbedMenu(10);
    include("$templateDir/groupAdd.php");
  }
                                                                                                                             
  include("$libDir/footer.php");

?>
