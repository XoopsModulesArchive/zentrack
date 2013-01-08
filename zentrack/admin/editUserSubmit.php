<?php {
  /*
  **  EDIT USER SUBMIT
  **  
  **  Commits zenTrack user modifications to db
  **
  */
  
  include("admin_header.php");
  $page_title = tr("Edit User Submit");
  
  if( !$active )
  $active = 0;
  $zen->cleanInput($user_fields);
  foreach($user_required as $u) {
    if( !strlen($$u) ) {
      $errs[] = tr("? is required", array(ucfirst($u)));
    }
  }
  $check = $zen->check_user_login($login);
  if( $check && $check != $user_id  ) {
    $errs[] = tr("That login name is in use by another account");
  }
  if( !$access_level ) {
    $access_level = 0;
  }
  
  // security checks for the root administrator account
  if( $user_id == 1 && $access_level < 5 ) {
    $errs[] = tr("The root admin account must have access of 5 or greater");
  }
  if( $user_id == 1 && $access_level < $zen->getSetting("level_settings") ) {
    $errs[] = tr("The root admin access cannot be less than the level_settings parameter");
  }
  if( $user_id == 1 && !$active ) {
    $errs[] = tr("The root admin account cannot be deactivated");
  } else if( $user_id == 1 ) {
    $active = 2;
  }
  
  if( !$errs ) {
    $params = array();
    foreach(array_keys($user_fields) as $k) {
      if( strlen($$k) ) {
        $params["$k"] = $$k;
      }
      else {
        $params["$k"] = "NULL";
      }
    }
    if( $zen->demo_mode == "on" ) {
      $msg[] = tr("Process successful.  User was not updated, because this is a demo site.");
    } else {
      $res = $zen->update_user($user_id, $params);
      if( $res ) {
        $msg[] = tr("User ? was updated successfully",array($user_id));
      } else {
        $errs[] = tr("System Error: Could not update ?, ?", array($lname, $fname));
      }
    }
  }
  
  include("$libDir/admin_nav.php");
  if( $errs ) {
    $zen->printErrors($errs);
    $TODO = 'EDIT';
    include("$templateDir/userAdd.php");
  } else {
    include("$templateDir/adminMenu.php");
//	showTabbedMenu(2);
//    include("$templateDir/userSearchForm.php");
  }
  
  include("$libDir/footer.php");
  
}?>
