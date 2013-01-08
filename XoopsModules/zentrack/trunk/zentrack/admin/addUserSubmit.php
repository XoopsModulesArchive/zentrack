<?{
   
  /*
  **  NEW USER SUBMIT
  **  
  **  Commits a new zenTrack user to db
  **
  */
  
  include("admin_header.php");
  $page_title = "New User Submit";
  
  if( !$active ) { $active = 0; }
  $zen->cleanInput($user_fields);
  foreach($user_required as $u) {
    if( !strlen($$u) ) {
      $errs[] = tr("? is required", array(ucfirst($u)));
    }
  }
  if( !$access_level ) {
    $access_level = 0;
  }
  if( $zen->check_user_login($login) > 0 ) {
    $errs[] = tr("That login name already exists.  Please choose another.");
  }

  if( !$errs ) {
    $params = array();
    foreach(array_keys($user_fields) as $k) {
      if( strlen($$k) ) {
        $params["$k"] = $$k;
      }
    }
    if( $zen->demo_mode == "on" ) {
      $msg[] = tr("Process completed successfully.  Account not added, because this is a demo site");
    } else {
      $user_id = $zen->add_user($params);
      if( $user_id ) {
        $msg[] = tr("User ? was added successfully.",$user_id);
      } else {
        $errs[] = tr("System Error: Could not add ?, ? to the system", array($lname, $fname));
      }
    }
  }

  include("$libDir/admin_nav.php");
  if( $errs ) {
    $zen->printErrors($errs);
    include("$templateDir/userAdd.php");
  } else {
    include("$templateDir/adminMenu.php");
//    include("$templateDir/userAdd.php");
  }

  include("$libDir/footer.php");

}?>
