<?
  /*
  **  contact DISPLAY PAGE
  **  
  **  Displays a contact to the screen
  **
  */
  
  // include the header file
  include_once("contact_header.php");

  // security measure
  if( $login_level < $zen->getSetting('level_contacts') ) {
    print "Illegal access.  You do not have permission to access contacts.";
    exit;
  }

  /*
  **  GET TICKET INFORMATION
  */
  $page_title = tr("Agreement") . " #$id";

  /*
  **  GET PARAMS FOR A Contact
  */
  
  $agree = $zen->get_contact($id,$zen->table_agreement,"agree_id");

    
  // place record into history of recently viewed items
  $history =& $zen->getHistoryManager();
  $history->storeItem('agreement', $id, $zen->getDataTypeLabel('zentrack_agreement', $agree));
  
  $page_section = "Agreement $id";
  $expand_agreement = 1;
  
  $hotkeys->loadSection('agreement_view');
  $GLOBALS['zt_hotkeys'] = $hotkeys;
  
  /*
  ** PRINT OUT THE PAGE
  */ 
  include_once("$libDir/nav.php");

    if( is_array($agree) ) {
      extract($agree);
       
	    include("$templateDir/agreement_box.php"); 
			
    } else {
      print "<p class='error'>" . tr("That contact doesn't exist") . "</p>\n";
    }
    
    
   

  include("$libDir/footer.php");
?>
