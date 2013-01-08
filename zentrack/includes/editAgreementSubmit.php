<?
if( !ZT_DEFINED ) { die("Illegal Access"); }



  // initiate default values

  $change_time = time();  // set time ticket opened
  if( $dtime ) {
    $dtime = $zen->dateParse($dtime);
  }
  if( $stime ) {
     $stime = $zen->dateParse($stime);
  }

  // $description = nl2br(htmlspecialchars($description));

  $fields = array(
		  "contractnr"  => "text",
		  "company_id"  => "int",
		  "description" => "ignore",
		  "title"       => "text",
		  "create_time" => "int",
		  "stime"       => "int",
		  "dtime"       => "int",
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
    $res = $zen->update_contact($id,$params,$zen->table_agreement,"agree_id");
    // check for errors
    if( !$res ) {
      $errs[] = tr("System Error").": ".tr("Contact could not be edited.")." ".$zen->db_error;
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

    include("$rootWWW/agreement.php");//test set contact(s)
    exit;

  } else {
    $page_title = tr("Contacts");
    $page_section = "Contacts";
    $expand_contacts = 1;
    include("$libDir/nav.php");
    $zen->print_errors($errs);
    include("$templateDir/newAgreementForm.php");
    include("$libDir/footer.php");
  }
?>
