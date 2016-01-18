<?php
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

  //$description = nl2br(htmlspecialchars($description));

  $id = $company_id;
  
  $fields = array(
		  "fname"       => "text",
		  "lname"    => "text",
		  "initials" => "text",
		  "jobtitle"       => "text",
		  "department"      => "text",
		  "email"      => "email",
		  "telephone"    => "text",
		  "mobiel"      => "text",
		  "inextern" => "int",
		  "company_id"    => "int",
		  "description"   => "ignore",
		  "create_time" => "int"
		  );
 $required = array(
		   "lname"
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
     $pid = $zen->add_contact($params,$zen->table_employee);
     // check for errors
     if( !$pid ) {
	$errs[] = tr("Could not create contact.") . " " .$zen->db_error;
     }
  }

  if( !$errs ) {
     //$setmode = "tasks";
	if ($company_id) {
	     $cid = $company_id;
	     $pid = NULL;
     } 
     include("contact.php");//test set contact(s)
     exit;
     //header("Location:$rootUrl/project.php?id=$id");
  } else {
     include("$libDir/nav.php");
     $zen->print_errors($errs);
     include("$templateDir/newContacteForm.php");
     include("$libDir/footer.php");
  }
?>
