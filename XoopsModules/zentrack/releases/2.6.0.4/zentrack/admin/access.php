<?{

  /*
  **  ACCESS
  **  
  **  Add/update custom user access priviledges
  **
  */
  
  
  include("admin_header.php");

  // security
  $user_id = $zen->checkNum($user_id);
  // update database if submitted
  if( $TODO == 'Update' ) {
    $bins = array();
    if( is_array($binLevels) ) {
      foreach($binLevels as $k=>$v) {
        if( $k && (strlen($v) || strlen($binRoles["$k"])) ) {
	  if( strlen($bins["$k"]) ) {
	    $errs[] = tr("Two or more bins were submitted with the same name");
	    break;
	  }
          $bins["$k"] = (strlen($binRoles["$k"]))?
	    array($v,$binRoles["$k"]) : array($v,null);
        }
      }
    }
    for( $i=0; $i<count($newFields); $i++ ) {
      $k = $newFields[$i];
      if( $k && (strlen($newVals[$i]) || strlen($newRoles[$i])) ) {
	if( strlen($bins["$k"]) ) {
	  $errs[] = tr("Two or more bins were submitted with the same name");
	  break;
	}
        $bins["$k"] = (strlen($newRoles[$i]))?
	  array($newVals[$i],$newRoles[$i]):array($newVals[$i],null);
      }
    }
    if( !$errs ) {
      if( $zen->demo_mode == "on" ) {
        $msg[] = tr("Process completed successfully. No privileges were changed, because this is a demo site.");
        $skip = 1;
      } else if( !is_array($bins) || !count($bins) ) {
        $res = $zen->delete_access($user_id);
        if( !$res ) {
          $errs[] = tr("System Error: could not update access &#151; this is most likely because no bins were set, and no bins previously existed (i.e. nothing happened)");
        } else {
          $msg[] = tr("All bins were removed from access for user ?", array($user_id));
          $skip = 1;
        }
      } else {
        $res = $zen->update_access($user_id, $bins);
        if( !$res ) {
          $errs[] = tr("System Error: could not update access for user ?", array($user_id));
        } else {
          $skip = 1;
          $msg[] = tr("Custom Access priviledges updated for user ?", array($user_id));
        }
      }
    }
    if( !$skip )
      $TODO = 'LESS';
  }

  // show the page
  $page_title = tr("Admin Section");
  include("$libDir/admin_nav.php");
  $zen->printErrors($errs);
  if( $user_id && !$skip ) {
    include("$templateDir/accessForm.php");
  } else {
    include("$templateDir/adminMenu.php");
  }

  include("$libDir/footer.php");

}?>