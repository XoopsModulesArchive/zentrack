<?
  /*
  **  Action: edit ticket
  */
  include_once("../contact_header.php");
  $expand_agreement = 1;
  
  
  include("$libDir/nav.php");

  if(isset($cid)) {
	 $company_id = $cid; 
  }
  
  $_SERVER['PHP_SELF']= $rootUrl."/newAgreement.php";
  
  include("$templateDir/newAgreementForm.php");

  include("$libDir/footer.php");
?>


