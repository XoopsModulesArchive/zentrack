<?
if( !ZT_DEFINED ) { die("Illegal Access"); }



  // initiate default values
     
  $change_time = time();  // set time ticket opened
  
  if($website=="http://") {
	  $website = NULL;
  }

      
  //$description = nl2br(htmlspecialchars($description));

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
		  "create_time" => "int",
		  "creator_id" => "int",
		  "change_time" => "int"
		  );
 $required = array(
		   "lname"
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
     //print_r($params);
     // update the ticket info
     $res = $zen->update_contact($id,$params,$zen->table_employee,"person_id");
     // check for errors
     if( !$res ) {
   $errs[] = tr("System Error").": ".tr("Contact could not be edited.")." ".$zen->db_error;
     }
  }

  if( !$errs ) {
     //$setmode = "tasks";
     if ($company_id > 0){
     $cid = $company_id;//set company for contacts
   		} else {
	   	$pid = $id;
   		}
     include("../contact.php");//test set contact(s)
     exit;
     
  } else {
	    $page_title = tr("Contacts");
  		$page_section = "Contacts";
  		$expand_contacts = 1;
     include("$libDir/nav.php");
     $zen->print_errors($errs);
     include("$templateDir/newContacteForm.php");
     include("$libDir/footer.php");
  }
?>
