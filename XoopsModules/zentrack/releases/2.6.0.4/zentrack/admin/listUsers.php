<?
  /*
  **  LIST USERS FOR ADMINISTRATION
  **  
  **  Creates a list of users for editing
  **
  */
  
  
  include("admin_header.php");
  $page_title = tr("Search for Users");
  include("$libDir/admin_nav.php");
//  include("$libDir/nav.php");

showTabbedMenu(2);

  if( !$TODO ) {
    include("$templateDir/userSearchForm.php");
  } else {
    if( $TODO == 'ALL' ) {
      $users = $zen->get_users(null,0,0,'active desc,lname,fname');
    } else {
      include("$templateDir/userSearchResults.php");
    }
    if( is_array($users) ) {
      include("$templateDir/userSearchList.php");
    } else {
      print "<br><b>" . tr("There were no results for your search") . "</b>\n";
      include("$templateDir/userSearchForm.php");
    }
  }

  include("$libDir/footer.php");

?>
