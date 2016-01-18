<?php
/*
**  EDIT BEHAVIOR
**  
**  Modifies an existing behavior
**
*/


include_once("admin_header.php");

$behavior_id = $zen->checkNum($behavior_id);

if( $TODO == 'DONE' ) {
  $skip = 1;
} else {
  $page_title = ( $TODO == "NEW" )? "New Behavior" : "Edit Behavior";
  if ( $TODO != "NEW" ) {
    $behavior = $zen->getBehavior( $behavior_id );
    if( !$behavior ) {
      $msg[] = "That behavior could not be found, please select a behavior.";
      $skip = 1;
    }
    else {
      $TODO = "EDIT";
      extract($behavior);
    }
  }
}

$field_list=$zen->getBehaviorDestinationFieldsArray();

include("$libDir/admin_nav.php");
showTabbedMenu(11);
//$zen->printErrors($errs);
if( $skip == 1 ) {
  include("$templateDir/behaviorMenu.php");
} else if ( $skip == 2 ) {
  print "<ul><b>" . tr("That behavior could not be found") . "</b>";
  print "<br><a href='$rootUrl/admin/behaviors.php'>" . tr("Click Here to view available behaviors") . "</a></ul>\n";
} else {
  include("$templateDir/behaviorForm.php");
}

include_once("$libDir/footer.php");

?>