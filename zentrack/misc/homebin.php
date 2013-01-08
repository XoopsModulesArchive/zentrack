<?php {
  /*
  **  CHANGE DEFAULT BIN
  **  
  **  Change the default bin for the 
  **  logged in user.
  **
  */
  
  include("../header.php");

  $page_title = tr("Change Default Bin");
  $expand_options = 1;
  if( isset($TODO) && $TODO == 'BIN' ) {
    $params = "";
    $homebin = ereg_replace("[^0-9]-", "", $homebin);
    if( !isset($homebin) || (!$zen->bins["$homebin"] && $homebin != "all")) {
      $errs[] = tr("That bin doesn't exist");
    } else {
      $params = array( "homebin"=>$homebin );
      $res = $zen->update_user($login_id, $params);
      if( !$res ) {
         $errs[] = tr("System Error: Unable to update bin.");
      } else {
         $skip = 1;
         $hb = ( $homebin == 'all' )? "-" . tr("All") . "-" : $zen->ffv($zen->bins["$homebin"]);
         $msg[] = tr("Your bin has been changed to ?",$hb);
         $login_bin = $homebin;
      }
    }
  }

  include("$libDir/nav.php");

  if( is_array($errs) ) {
    $zen->printErrors($errs);
  }
  
  if( $skip ) {
    include("$templateDir/optionsMenu.php");
  }
  else {
    include("$templateDir/homebinForm.php");
  }

  include("$libDir/footer.php");

}?>

