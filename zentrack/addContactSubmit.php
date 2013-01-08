<?
  /*
  **  NEW PROJECT (add submit)
  **  
  **  Commit new project to database
  **
  */
    
  include("contact_header.php");

  // security measure
  if( $login_level < $zen->getSetting('level_contacts') ) {
    print "Illegal access.  You do not have permission to access contacts.";
    exit;
  }

  $page_title = tr("Commit New Project");
  $expand_contacts = 1;

  // initiate default values
  $create_time = time();  // set time ticket opened
  
  if($website == "http://") {
  $website = NULL;
	}

  //$description = nl2br(htmlspecialchars($description));

  $fields = array(
		  "title"       => "text",
		  "office"    => "text",
		  "description" => "ignore",
		  "address1"       => "text",
		  "address2"      => "text",
		  "address3"      => "text",
		  "postcode"    => "text",
		  "postcode2"    => "text",
		  "pobox"    => "text",
		  "place"      => "text",
		  "telephone"    => "text",
		  "fax"   => "text",
		  "country"   => "text",
		  "email"    => "email",
		  "website"  => "text",
		  "create_time" => "int"
		  );
 $required = array(
		   "title"
		   );
  $zen->cleanInput($fields);
  // check for required fields
  foreach($required as $r) {
     if( !$$r ) {
	$errs[] = tr("required field missing:") . " " . ucfirst($r);
     }
  }
  if( !$errs ) {
     // create an array of existing fields
     foreach(array_keys($fields) as $f) {
	if( strlen($$f) ) {
	   $params["$f"] = $$f;
	}
     }
     $params["creator_id"] = $login_id;
     // add the ticket to db
     $cid = $zen->add_contact($params,$zen->table_company);
     // check for errors
     if( !$cid ) {
	$errs[] = tr("Could not create contact.") . " " .$zen->db_error;
     }
  }

  if( !$errs ) {
     //$setmode = "tasks";
     include("contact.php");//test set contact(s)
     exit;
     //header("Location:$rootUrl/project.php?id=$id");
  } else {
     include("$libDir/nav.php");
     $zen->print_errors($errs);
     include("$templateDir/newContactForm.php");
     include("$libDir/footer.php");
  }
?>
