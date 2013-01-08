<?php {
  /*
   **  EDIT DATA GROUP
   **  
   **  Modifies an existing data group
   **
   */
  
  
  include("admin_header.php");
  
  // get the information for this data group
  $group_id = $zen->checkNum($group_id);
  $group = $zen->get_data_group( $group_id );
  if( !is_array($group) ) {
    include_once("$libDir/admin_nav.php");
    print "<ul><div class='error'>" . tr("That group could not be found") . "</div>";
    print "<a href='$rootUrl/admin/groups.php'>" 
      . tr("Click Here to view available groups") . "</a></ul>\n";
    include("$libDir/footer.php");
    exit;    
  }
    
  if( !$more ) { $more = 3; }
  $elements = array();

  // When the action is MORE or LESS, 
  // we fill the elements array with the values from the Form
  // This only can happen when using a Custom-type group, 
  // because standard table groups cannot trigger these kind of actions
  if( !$TODO ) {
    $elements = $group['details'];
  }
  else if( $TODO == 'MORE' ) {
    for($i=0; $i<count($NewValue); $i++) {
      $elements[] = array(
			  "field_value" => $NewValue[$i],
			  "sort_order"  => $zen->checkNum($NewSortOrder[$i]),
			  "new_delete"  => $NewDelete[$i]? 1 : 0
			  );
    }
    for($i=0; $i < $more; $i++) {
      $elements[] = array("field_value"=>'-new-', 'sort_order'=>0);
    }
    $more += 3;
  } else if( $TODO == 'LESS' ) {
    $more = 3;
    for($i=0; $i < count($NewValue); $i++) {
      if( $NewValue[$i] != '-new-' && !$NewDelete[$i] ) {
	$elements[] = array(
			    "field_value"      => $NewValue[$i],
			    "sort_order" => $zen->checkNum($NewSortOrder[$i])
			    );
      }
    }
    
  } else if( $TODO == 'Save' ) {
    // When the action is Save and demo_mode is on, 
    // we don't save the changes to the database
    $elements = array();
    if( $zen->demo_mode == "on" ) {
      $msg[] = tr("Process completed successfully. Groups were not updated "
		."since this is a demo site.");
      $skip = 1;
    } else {
      // When the action is Save and we are using a standard 
      // table type group we fill the elements array this way:
      if ( $group['table_name'] ) {
	//for( $i=0; $i<count($NewValue); $i++ ) {
	//if( $NewUseInGroup[$i] ) {
	foreach( $NewUseInGroup as $k=>$v ) {
	  if( $v > 0 ) {
	    $elements[] = array(
				"field_value" => $NewValue[$k],
				"sort_order"  => $zen->checkNum($NewSortOrder[$k])
				);
	  }
	}
      } else {
	// When the action is Save and we are using a 
	// custom type group we fill the elements array this way:
	for( $i=0; $i<count($NewValue); $i++ ) {
	  if( $NewValue[$i] != "-new-" && !$NewDelete[$i] ) {
	    $elements[] = array(
				"field_value" => $NewValue[$i],
				"sort_order"  => $zen->checkNum($NewSortOrder[$i])
				);
	  }
	}
      }

      // Last commands for the Save action when demo_mode is not on:
      $num = $zen->updateDataGroupDetails($group_id, $elements) ;

      // update the session info with new changes
      if( $num ) {
	$vars = $zen->generateDataGroupInfo( array($group_id) );
	$_SESSION['data_groups'][$group_id] = $vars["$group_id"];
      }

      // print useful information for user
      $msg[] = tr("? of ? elements were saved in the selected group. Updates complete", 
		array($num, count($elements)));
      $skip = 1;
    }
  }

  // insure that there are at least a few rows shown on page
  if( !$group['table_name'] && count($elements) < 1 ) {
    for($i=0; $i<3; $i++) {
      $elements[] = array("field_value"=>'-new-', 'sort_order'=>0);
    }
  }

  // print out page info
  $page_title = ($skip)? tr("Admin Section") : tr("Edit Data Group");
  include("$libDir/admin_nav.php");
showTabbedMenu(10);
  $zen->printErrors($errs);

  if( !$skip ) {
    $group_details = $zen->get_data_group_details($group_id);
    if ( !is_array($group_details) ) {
      $group_details=array();
    }
    $TODO = 'EDIT';
    // When we are editing a standard table type group 
    // we fill the elements array this way and call
    // the groupDetailsForm template
    if ( $group['table_name'] ) {
      $query     = "SELECT * FROM ".$group['table_name']." WHERE active=1";
      $elements  = $zen->db_query($query);
      include("$templateDir/groupDetailsForm.php");
    }
    else {
      // When we are editing a custom type group we fill 
      // call the customGroupDetailsForm template
      include("$templateDir/customGroupDetailsForm.php");
    }
  } else {
    include("$templateDir/groupForm.php");
  }
  include("$libDir/footer.php");
  
  
}?>