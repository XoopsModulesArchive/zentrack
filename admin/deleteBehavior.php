<?php
  /*
  **  DELETE BEHAVIOR
  **  
  **  Deletes a zenTrack behavior
  **
  */
  
  
  include("admin_header.php");

  $behavior_id = $zen->checkNum($behavior_id);

  if( $zen->demo_mode == "on" ) {
    $msg[] = tr("The action completed successfully.  The account was not actually deleted, because this is a demo site");
  } else {
    $res = $zen->removeBehavior($behavior_id);
    if( !$res ) {
      $errs[] = tr("The behavior (?) could not be found/deleted successfully", array($behavior_id));
    } else {
      $msg[] = tr("The behavior (?) was successfully removed", array($behavior_id));
    }
  }

  $page_title = tr("Delete Behavior");
  include("$libDir/admin_nav.php");
showTabbedMenu(11);
  $zen->printErrors($errs);
  include("$templateDir/behaviorMenu.php");
  include("$libDir/footer.php");

?>