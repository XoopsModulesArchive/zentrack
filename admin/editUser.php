<?php
  /*
  **  EDIT USER
  **  
  **  Modifies an existing user account
  **
  */
  
  
  include("admin_header.php");

  $page_title = "Edit User";
  include("$libDir/admin_nav.php");
//  include("$libDir/nav.php");


  $user = $zen->get_user($user_id);
  
  if( $user_id == 1 && $login_id != 1 ) {
    print "<ul><b>" . tr("The Root Admin Account can only be modified by the Root Administrator") . "</b></ul>\n";    
  } else if( is_array($user) ) {
    $TODO = 'EDIT';
    extract($user);
    include("$templateDir/userAdd.php");
  } else {
    print "<ul><b>" . tr("That user could not be found") . "</b>";
    print "<br><a href='$rootUrl/admin/listUsers.php'>" . tr("Click Here to search for users") . "</a></ul>\n";
  }

  include("$libDir/footer.php");

?>
