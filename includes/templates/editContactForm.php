<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  $skip = 0;
  $id = NULL;
  
  if( $cid ) {
	  $table=$zen->table_company;
	  $col="company_id";
	  $id = $cid;
  }
  if ($pid ) {
	  $table=$zen->table_employee;
	  $col="person_id";
	  $id = $pid;
	} 
	    
  $contact = $zen->get_contact($id,$table,$col);
  //print_r($contact);
    if( !is_array($contact) ) {
      $errs[] = tr("Contact #? could not be found",array($id));
    } else {
      $skip = 1;
      $TODO = 'EDIT';
      extract($contact);
       
      
      if ($pid) {
			include("$templateDir/newContacteForm.php");
			} else {
			include("$templateDir/newContactForm.php");	
			}
  	} 
  if( !$skip ) {
    $zen->printErrors($errs);
  }

?>

