<?php {
  /*
  **  STORE PASSWORD IN COOKIE
  */
  
  include_once("../header.php");
  
  $page_title = tr("Toggle Auto-Login Feature");
  $expand_options = 1;
  
  $on = array_key_exists('setauto', $_GET) && $_GET['setauto'] == 'on';
  
  if( !$zen->settingOn('allow_pwd_save') ) {
    $msg[] = tr("This feature has been disabled by the administrator.");
  }
  else if( $zen->demo_mode == 'on' ) {
    $msg[] = tr("Your request was successful, but this is a demo site, so the autologin was not altered");
  }
  else if( isset($_GET['setauto']) ) {
    $res = $zen->update_pref($login_id, 'autologin', $_GET['setauto'] == 'on'? 1 : 0);
    if( $res ) {
      $msg[] = $on? tr("Your auto-login feature has been turned on.  It will become active after your next login attempt.") : 
                 tr("Your auto-login feature has been turned off.");
    }
    else {
      $errs[] = tr("Unable to update your user preferences due to a system error.");
    }
  }
  
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  if( $zen->settingOn('allow_pwd_save') ) {
    include("$templateDir/autoLoginForm.php"); 
  }
  else { 
    include("$templateDir/optionsMenu.php"); 
  }
  
  include("$libDir/footer.php");
  
}?>