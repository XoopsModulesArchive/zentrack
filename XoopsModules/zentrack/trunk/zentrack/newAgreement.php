<?
  /*
  **  NEW CONTACT
  **  
  **  Create a new Contact
  **
  */
  
  
  include("contact_header.php");

  // security measure
  if( $login_level < $zen->getSetting('level_contacts') ) {
    print "Illegal access.  You do not have permission to access contacts.";
    exit;
  }

  

  $page_title = tr("Create a new Agreement");
  $page_section =  tr("Create a new Agreement");
  $expand_agreement = 1;
  include("$libDir/nav.php");

  // add item button
  if ($TODO == "addItems") {
    $agree_id = "0";
    $create_time = time();
    
    $fields = array(
    "agree_id"    => "int",
    "description1" => "ignore",
    "name1"       => "text",
    "create_time" => "int",
    );
    
    foreach(array_keys($fields) as $f) {
      if( strlen($$f) ) {
        $params["$f"] = $$f;
      }
    }
    
    $params["creator_id"] = $login_id;
    if (!$id){
      $idi = $zen->add_contact($params,"ZENTRACK_AGREEMENT_ITEM");
    } else {
      $params["agree_id"] = $id;
      $idi = $zen->add_contact($params,"ZENTRACK_AGREEMENT_ITEM");
    }
    if( !$idi ) {
      $errs[] = tr("Could not create item.") . " " .$zen->db_error;
    }
    
    $description1 = null;
    $name1 = null;
  }
  else if ($TODO == "removeItems" ){
    if( is_array($drops) ) {
      // drop items in list
      for($i=0; $i<count($drops); $i++) {
        // clean up numbers just in case
        $n = $zen->checkNum($drops[$i]);
        
        $res = $zen->delete_contact( $n,"ZENTRACK_AGREEMENT_ITEM","item_id");
      }
    }
  }
  else {
    // clear any temporary items which might be hanging out
    $zen->delete_contact('0', "ZENTRACK_AGREEMENT_ITEM", "agree_id");
  }

  include("$templateDir/newAgreementForm.php");

  include("$libDir/footer.php");
?>
