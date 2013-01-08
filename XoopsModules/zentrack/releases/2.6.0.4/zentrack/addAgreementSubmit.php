<?
  /*
  **  NEW PROJECT (add submit)
  **  
  **  Commit new project to database
  **
  */
  
  include_once("contact_header.php");
  
  // security measure
  if( $login_level < $zen->getSetting('level_contacts') ) {
    print "Illegal access.  You do not have permission to access contacts.";
    exit;
  }
  
  $page_title = tr("Commit New Agreement");
  $expand_agreements = 1;
  
  // initiate default values
  $create_time = time();  // set time ticket opened
  
  if( $dtime ) {
    $dtime = $zen->dateParse($dtime);
  }
  if( $stime ) {
    $stime = $zen->dateParse($stime);
  }
  
  if (!empty($dtime) && !empty($stime)){	  
    if ($dtime < $stime) {
      $errs[] = tr("incorrect date values"); 
    }
  }
  
  //$description = nl2br(htmlspecialchars($description));
  
  $fields = array(
    "contractnr"       => "text",
    "company_id"    => "int",
    "description" => "ignore",
    "title"       => "text",
    "create_time" => "int",
    "stime" => "int",
    "dtime" => "int"
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
    $id = $zen->add_contact($params,$zen->table_agreement);
    // check for errors
    if( !$id ) {
      $errs[] = tr("Could not create agreement.") . " " .$zen->db_error;
    } else {
      
      $agree_id = $id ;    
      $fields = array(
        "agree_id"    => "int",
      );
      
      $params = array();
      // create an array of existing fields
      foreach(array_keys($fields) as $f) {
        $params["$f"] = $$f;
      }
      // update the ticket info
      $res = $zen->update_contact("0",$params,$zen->table_agreement_item,"agree_id");
      // check for errors
      if( !$res ) {
        $errs[] = tr("System Error").": ".tr("Contact could not be edited.")." ".$zen->db_error;
      }
      
    }
  }
  
  if( !$errs ) {
    //$setmode = "tasks";
    include("agreement.php");//test set contact(s)
    exit;
    //header("Location:$rootUrl/project.php?id=$id");
  } else {
    include("$libDir/nav.php");
    $zen->print_errors($errs);
    include("$templateDir/newAgreementForm.php");
    include("$libDir/footer.php");
  }
?>