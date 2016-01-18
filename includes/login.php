<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

$autologin = $zen->settingOn('allow_pwd_save');
$user = false;

// log user out of zentrack if $logoff
/*
  logoff action is now handled in includes/session_start.php
if( isset($logoff) && $logoff > 0 ) {
  $login_id = "";
  $login_name = "";
  $login_level = "";
  $_SESSION['data_groups'] = null;
  $autologin = false;
  setcookie("zentrackKey", "", time());
  $_SESSION['login_id'] = null;
}
*/

// auto-login via cookie
if( $autologin && !$login_id && $zentrackUsername && $zentrackKey ) {

  // make sure the user has this feature turned on
  $doauto = false;
  $user = $zen->get_user_by_login($zentrackUsername);
  if( $user ) {
    // try to retrieve the user_id so that we can check this users preferences
    // and determine if their auto-login is enabled.
    $doauto = $zen->get_prefs( $user['user_id'], 'autologin' );
    $zen->addDebug("login.php:auto-login", "Checking autlogin setting for user {$user['user_id']}: $doauto", 3);
  }
  else {
    // delete cookie if user is invalid
    $zen->addDebug("login.php:auto-login", "Invalid username provided(deleting): ".$zen->ffv($zentrackUsername),1);
    setcookie("zentrackUsername", $zentrackUsername, -1);
  }

  if( $doauto ) {
    // automatically log in users based on cookie values
    $login_id = $zen->login_user($zentrackUsername, $zentrackKey, true);
    if( $login_id ) {
      $user = $zen->getUser($login_id);
      $_SESSION['login_id'] = $login_id;
      // user login was valid so set session variables
      $login_level = $user["access_level"];
      $login_name  = $user["fname"]." ".$user["lname"];
      $login_inits = $user["initials"];
      $login_bin   = $user["homebin"];
      $language = $zen->get_prefs($login_id, "language");
      if($language) { $login_language = $language; }
      setcookie("zentrackUsername", $zentrackUsername, time()+2592000);
      setcookie("zentrackKey", $zentrackKey, time()+2592000);
      $skip = 1;
      unset($TODO);
      $zen->addDebug("login.php:auto-login",
      "User logged in: $login_id,$login_name,$login_level",2);
    }
    else {
      // user login was invalid so get rid of the offending cookie
      setcookie("zentrackKey", $zentrackKey, -1);
      $zen->addDebug("login.php:auto-login",
      "Auto-login was invalid: ".$zen->ffv($zentrackUsername)."||".$zen->ffv($zentrackKey), 1);
    }
  }
}

if( !$login_id ) {
  if( $zen->settingOn('use_system_auth') &&
      isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) ) {
    // use htaccess authentication
    $username = $_SERVER['PHP_AUTH_USER'];
    $passphrase = $_SERVER['PHP_AUTH_PW'];
  }
  if( isset($username) && $username && isset($passphrase) ) {
    $login_id = $zen->login_user( $username, $passphrase );
    if( $login_id ) { $user = $zen->getUser($login_id); }
    if( $login_id && $zen->demo_mode != "on"
	  && $user["initials"] != "GUEST"
	  && $zen->encval($user["lname"]) == $zen->encval($passphrase) ) {
      // this will redirect the user
      // to a login screen where they can
      // change their passphrase, since it is
      // set to the default
      $_SESSION['login_id'] = $login_id;
      $login_level = 'first_login';
      $login_name  = $user["fname"]." ".$user["lname"];
      setcookie("zentrackUsername", $username, time()+2592000);
      $login_inits = $user["initials"];
      $login_bin   = $user["homebin"];
      $lang_pref = $zen->get_prefs($login_id,'language');
      if(isset($lang_pref)) { $login_language = $lang_pref; }
      if( $autologin && $save_my_password ) {
        // if the user checks the log me in automagically box, we will set a userpref
        // to do this in the future and create a cookie
        $zen->update_pref($login_id, 'autologin', 1);
        setcookie("zentrackKey", $zen->encval($passphrase), time()+2592000);
      }
      $skip = 1;
    } else if( $login_id ) {
      // this will log the user in successfully
      // and generate session variables, as well
      // as a cookie to save time logging in
      // in the future
      $_SESSION['login_id'] = $login_id;
      $login_level = $user["access_level"];
      $login_name  = $user["fname"]." ".$user["lname"];
      $login_inits = $user["initials"];
      $login_bin   = $user["homebin"];
      $lang_pref = $zen->get_prefs($login_id, "language");
      if( $lang_pref ) { $login_language = $lang_pref; }
      setcookie("zentrackUsername", $username, time()+2592000);
      if( $autologin && $save_my_password ) {
        // if the user checks the log me in automagically box, we will set a userpref
        // to do this in the future and create a cookie
        $zen->update_pref($login_id, 'autologin', 1);
        setcookie("zentrackKey", $zen->encval($passphrase), time()+2592000);
      }
      $skip = 1;
      unset($TODO);
      $zen->addDebug("login.php:userLogin",
      "User logged in: $login_id,$login_name,$login_level",2);
    } else {
      // generate an error message and let them try again
      $msg[] = tr("That passphrase didn't work.");
    }
    if( $login_bin == -1 ) {
      $login_bin = null;
    }
  } else {
    $zen->addDebug("login.php:userLogin",
    "User not logged in, username and passphrase not detected, so creating login form",3);
  }
  
  // user isn't logged in, so show the login form
  if( !isset($skip) || !$skip ) {
    // no login has been recieved, but it's required
    // so generate a login prompt and form
    if( isset($zentrackUsername) )
    $zentrackUsername = strip_tags($zentrackUsername);
    else
    $zentrackUsername = "";
    $page_title = ucwords(tr("Please log on"));
    include("$libDir/nav.php");
    include("$templateDir/loginForm");
    include("$libDir/footer.php");
    exit;
  }

  // if there is no login id then include the form
  // or process the form results
  if( "$login_level" == "first_login" && !ereg("pwc\.php",$SCRIPT_NAME) ) {
    include_once("$libDir/nav.php");
    include_once("$templateDir/pwcForm.php");
    include_once("$libDir/footer.php");
    exit;
  }

}

?>