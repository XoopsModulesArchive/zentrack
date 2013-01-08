<?
if( !ZT_DEFINED ) { die("Illegal Access"); }



  // initiate default values
     
  $change_time = time();  // set time ticket opened
  
  if($website=="http://") {
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
		  "create_time" => "int",
		  "creator_id" => "int",
		  "change_time" => "int"
		  );
 $required = array(
		   "title"
		   );
		   //print_r($fields);
  $zen->cleanInput($fields);
  // check for required fields
  foreach($required as $r) {
     if( !$$r ) {
   $errs[] = ucfirst($r)." ".tr("is a required field");
     }
  }
  if( !$errs ) {
     $params = array();
     // create an array of existing fields
     foreach(array_keys($fields) as $f) {
         $params["$f"] = $$f;
     }
     //add changer
     $params["change_id"] = $login_id;
     // update the ticket info
     $res = $zen->update_contact($id,$params,$zen->table_company,"company_id");
     // check for errors
     if( !$res ) {
   $errs[] = tr("System Error").": ".tr("Contact could not be edited.")." ".$zen->db_error;
     }
  }

  if( !$errs ) {
     //$setmode = "tasks";
     $cid = $id;
     include("../contact.php");//test set contact(s)
     exit;
     
  } else {
	    $page_title = tr("Contacts");
  		$page_section = "Contacts";
  		$expand_contacts = 1;
     include("$libDir/nav.php");
     $zen->print_errors($errs);
     include("$templateDir/newContactForm.php");
     include("$libDir/footer.php");
  }
?>
