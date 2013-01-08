<?php
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

$id = NULL;
  
  if($pid){
    $ctype = 'employee';
		$table = $zen->table_employee;
		$col = "person_id";
		$id = $pid;
	} elseif($cid) {
    $ctype = 'company';
		$table = $zen->table_company;
		$col = "company_id";
		$id = $cid;
	} else {
		include("contacts.php");
    exit;
	}

  /*
  **  GET TICKET INFORMATION
  */
  $page_title = tr("Contact") . " #$id";

  /*
  **  GET PARAMS FOR A Contact
  */
  
  $contacts = $zen->get_contact($id,$table,$col);
  $history =& $zen->getHistoryManager();
  
  // place record into history of recently viewed items
  $history->storeItem($ctype, $id, $zen->getDataTypeLabel($table, $contacts));

  
  $page_section = "Contact $id";
  $expand_contacts = 1;
  
  /*
  ** PRINT OUT THE PAGE
  */ 
  include_once("$libDir/nav.php");

    if( is_array($contacts) ) {
      extract($contacts);
      
      if($pid){
	    	include("$templateDir/contact_personBox.php"); 
	    	if($overview=="tickets") {
          //collect field map info
          $view = 'contact_list';
          
          // creates the $sortby variable describing how columns will be sorted
          include_once("$libDir/sorting.php");
          
          // collect open tickets
          $tickets = $zen->getTicketsByPerson($id, $sortstring);
					
          //$tickets = $zen->get_open_tickets($id,"2");
          include("$templateDir/listTickets.php");
	    	}
	    	
      } else {
				include("$templateDir/contact_titleBox.php");
			
				if ($overview=="agreement"){
					//show the related agreements
					$parms = array(array("company_id","=",$id),
													array("status","=","1") );
					$contacts = $zen->get_contacts($parms,$zen->table_agreement,"contractnr asc");	
          include("$templateDir/agreement_list.php");
				} elseif ($overview=="tickets") {
          //collect field map info
          $view = 'contact_list';

          // sort tickets
          include("$libDir/sorting.php");
					//show open tickets
					//$tickets = $zen->get_open_tickets($id,"1");
          $tickets = $zen->getTicketsByCompany($id,join(',',$orderby));
          include("$templateDir/listTickets.php");
				} else {
					//show the related contacts
					$parms = array(array("company_id","=",$id));
					$contacts = $zen->get_contacts($parms,$zen->table_employee,"lname asc");	
          include("$templateDir/contact_list.php"); 
		  	}
		  }
	   
    } else {
      print "<p class='error'>" . tr("That contact doesn't exist") . "</p>\n";
    }
    
    
   

  include("$libDir/footer.php");
?>
