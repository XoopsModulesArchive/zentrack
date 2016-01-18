<?php
  /*
  **  NEW USER
  **  
  **  Creates a new zenTrack user
  **
  */
  
  
  include("admin_header.php");

  $user_id = $zen->checkNum($user_id);
  
    if( $zen->demo_mode == "on" ) {
      $msg[] = tr("The action completed successfully.  The account was not actually deleted, because this is a demo site");
    } else {
      $res = $zen->delete_user($user_id);
      if( !$res ) {
        $errs[] = tr("The account (?) could not be found/deleted successfully", array($user_id));
      } else {
        $msg[] = tr("The account(?) was successfully removed", array($user_id));
      }
    }

  $page_title = tr("Delete User");
  include("$libDir/admin_nav.php");
  $zen->printErrors($errs);
  include("$templateDir/adminMenu.php");
  include("$libDir/footer.php");

?>
