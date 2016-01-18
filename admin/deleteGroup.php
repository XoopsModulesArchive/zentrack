<?php
  /*
  **  DELETE GROUP
  **  
  **  Deletes a zenTrack Data Group
  **
  */
  
  
  include("admin_header.php");
  $group_id = $zen->checkNum($group_id);
  $tmpltForm = "$templateDir/groupForm.php";
  if( $group_id && $zen->demo_mode == "on" ) {
    $msg[] = tr("The action completed successfully.  The data group was not actually deleted, because this is a demo site");
  } else if ( $group_id && $TODO != "CANCEL" ) {
    if ( $TODO == "DISABLE" ) {
      $zen->disableReferencesToDataGroup($group_id);
    } else if ( $TODO == "MOVE" ) {
      $new_data_group = $zen->checkNum($new_data_group);
      $zen->moveReferencesToDataGroup($group_id, $new_data_group);
    }
    $qty = $zen->queryReferencesToDataGroup($group_id);
    if ( $qty == 0 ) {
      $res = $zen->removeDataGroup($group_id);
      if ( !$res ) {
        $errs[] = tr("The data group (?) could not be found/deleted successfully", array($group_id));
      } else {
        $msg[] = tr("The data group (?) was successfully removed", array($group_id));
        unset($_SESSION['data_groups']["$group_id"]);
      }
    } else {
     $tmpltForm = "$templateDir/referencedGroupForm.php"; 
    }
  }

  $page_title = tr("Delete Data Group");
  include("$libDir/admin_nav.php");
showTabbedMenu(10);
  $zen->printErrors($errs);
  include($tmpltForm);
  include("$libDir/footer.php");


?>
