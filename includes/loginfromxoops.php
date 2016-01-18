<?php
  
  /*
  **  Retrieve USER info (uid)
  **
  */
  
  if ( !$xoopsUser ) {
      header('Location: '.XOOPS_URL.'/user.php');
      exit();
  } elseif ( $xoopsUser ) {
      $login_email = $xoopsUser->getVar('email');
      $logid = $xoopsUser->getVar('uid');
  }
          
  /*
  **  Verify that the user has relevant access to module 
  **
  */
  
  //  First we see if the Xoops user (loginname) exists in Zentrack
//  if( !$zen->check_user_login($login_nm) ) {
  if( !$zen->get_users_by_email($login_email) ) {
      
  //  if not then we check to see if the Xoops userid exists in Zentrack
//	  if( !$zen->check_user_id($logid) ) {
		redirect_header(XOOPS_URL.'/index.php', 1, _NOPERM);
      	exit();
//  	}
//  	else {
//		$zen->user = $zen->getuser($logid);
//	    $login_id = $logid;
//  	}
  }
  else {

//  		$zen->user = $zen->get_user_by_login($xoopsUser->getVar('uname'));
		$temp_array = $zen->get_users_by_email($xoopsUser->getVar('email'));
  		if($temp_array) {
  			$zen->user = $zen->getuser($temp_array[0]);
  		}else {
  			$zen->user = null;
  		}
      	$login_id = $zen->user["user_id"];
  	
  }

      $_SESSION['login_id'] = $login_id;
      $login_level = $zen->user["access_level"];
      $login_name  = $zen->user["login"];
      $login_inits = $zen->user["initials"];
      $login_bin   = $zen->user["homebin"];
      $lang_pref = $zen->get_prefs($login_id, "language");
      if( $lang_pref ) { $login_language = $lang_pref; }
      setcookie("zentrackUsername", $username, time()+2592000);

      $zen->addDebug("login.php:userLogin",
      "User logged in: $login_id,$login_name,$login_level",2);
  $helpUrl = "$helpBase/$helpLang";
  $helpDir = "$rootWWW/help/$helpLang";
     setcookie("zentrackUserId", $login_id, time()+3600);
  
?>
