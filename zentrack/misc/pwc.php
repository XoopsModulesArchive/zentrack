<?{
  
  /*
  **  CHANGE PASSWORD
  **  
  **  Change the passphrase for the logged in user
  **
  */
  
  include_once("../header.php");
  
  $page_title = tr("Change Password");
  $expand_options = 1;
  
  if( $TODO == 'SET' ) {
    if( !$newPass1 || !$newPass2 ) {
      $errs[] = tr("Please fill in both of the fields");
    } else if( $newPass1 != $newPass2 ) {
      $errs[] = tr("Your passwords did not match");
    } else {
      if( $zen->settingOn("check_pwd_simple") && strlen($newPass1) < 6 ) 
      $errs[] = tr("Your passphrase must be at least 6 digits long");
      if( $zen->settingOn("check_pwd_simple") && !ereg("[^a-zA-Z]", $newPass1) )
      $errs[] = tr("Your new passphrase must contain at least 1 non-letter character");
    }
    $user = $zen->getUser($login_id);
    if( $user["initials"] == "GUEST" ) {
      $errs[] = tr("The Guest Password cannot be changed!");
    }
    
    if( !$errs ) {
      $params = array();
      $params["passphrase"] = $newPass1;
      if( $zen->demo_mode == "on" ) {
        $msg[] = tr("Your request was successful, but this is a demo site, so the passphrase was not altered");
        $skip = 1;
      } else {
        $res = $zen->update_user($login_id,$params);
        if( !$res ) {
          $errs[] = tr("System Error: Unable to change user passphrase.");
        } else {
          $skip = 1;
          $msg[] = tr("Password successfully changed");
        }
      }
      if( $skip ) {
        $_SESSION['login_level'] = $user['access_level'];
        $login_level = $user["access_level"];
      }
    }
  }
  
  include("$libDir/nav.php");

  $zen->printErrors($errs);
  if( $skip ) {
    include("$templateDir/optionsMenu.php");
  } else {
    include("$templateDir/pwcForm.php");
  }

  include("$libDir/footer.php");
}?>

