<?
  /*
  **  SEARCH TICKETS
  **  
  **  Filter tickets by a list of parameters and return
  **  only those tickets matching the result set
  **
  */
  
  include("contact_header.php");

  // security measure
  if( $login_level < $zen->getSetting('level_contacts') ) {
    print "Illegal access.  You do not have permission to access contacts.";
    exit;
  }

  $page_title = tr("Search Contacts");
  $page_section = $page_title;
  $expand_contactsearch = 1;
  include("$libDir/nav.php");

  if( $TODO == 'SEARCH' ) {
     include("$templateDir/searchContactResults.php");
     if( is_array($tickets) ) {
	     
	     //check to show the correct list
				if($table=="company") {
	     		include("$templateDir/searchContactList.php");
   			} elseif($table=="employee") {
	     		include("$templateDir/searchContact2List.php");
	     	} elseif($table=="agreement") {
	     		include("$templateDir/searchContact3List.php");
	     	} elseif($table=="item") {
	     		include("$templateDir/searchContact4List.php");
   			} else {
	   			$errs[] = tr("No valid fields were provided to conduct a search");
   			}
   			
		} else {
       if( $errs ) {
	 				$zen->printErrors($errs);
       } else {
	 				print "<p><b>" . tr("There were no results for your search.") . "</b></p>\n";
       }
       include("$templateDir/searchContactForm.php");
     }
  } else {
     include("$templateDir/searchContactForm.php");
  }

  include("$libDir/footer.php");
?>
