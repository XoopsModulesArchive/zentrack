<?php {
  /*
  **  EDIT GROUP SUBMIT
  **  
  **  Commits zenTrack data group modifications to db
  **
  */
  
  include("admin_header.php");
  $page_title = tr("Edit Group Submit");

  if( !$active )
    $active = 0;

  $data_group_fields = array(
                            "NewTableName"       => "alphanum",
                            "NewGroupName"       => "html",
                            "NewDescript"        => "html",
                            "NewEvalType"        => "alphanum",
                            "NewEvalText"        => "html",
                            "name_of_file"       => "filename",
                            'include_none'       => 'int'
                            );
  
  $data_group_required = array("NewGroupName", "NewEvalType");
  
  $zen->cleanInput($data_group_fields);
  
  if( $NewEvalType == 'Javascript' ) {
    $data_group_required[] = 'NewEvalText';
  }
  else if( $NewEvalType == 'File' ) {
    $data_group_required[] = 'name_of_file';
  }
  
  foreach($data_group_required as $d) {
    if( !strlen($$d) ) {
      $d = preg_replace('/^New/', '', $d);
      $d = preg_replace('/([A-Z])/', ' \\1', $d);
      $d = str_replace('_', ' ', $d);
      $d = ucwords($d);
      $errs[] = tr("? is required",array($d));
    }
  }
  
  // insure group name is unique
  if( !$errs ) {
    $oldGroup = $zen->get_data_group($group_id);
    if( $oldGroup['group_name'] != $NewGroupName ) {
      if( $zen->getDataGroupId($NewGroupName) ) {
        $errs[] = "The group '{$NewGroupName}' already exists.  The group name must be unique.";	
      }
    }
  }
  
  // add to database (or show demo mode message)
  if( !$errs ) {
    if( $zen->demo_mode == "on" ) {
      $msg[] = tr("Process successful.  Group was not updated, because this is a demo site.");
    } else {
      $res = $zen->updateDataGroup($group_id,$NewGroupName,$NewTableName,
      $NewEvalType,$NewEvalText,
      ( strlen($NewDescript) )?$NewDescript : "NULL", $name_of_file, $include_none);
      if( $res ) {
        // update session info with changes
        $vars = $zen->generateDataGroupInfo( array($group_id) );
        $_SESSION['data_groups'][$group_id] = $vars[$group_id];
        
        // print useful messages for user
        $msg[] = tr("Group '?' was updated successfully.", array($NewGroupName));
      } else {
        $errs[] = tr("System Error: Could not update ?", array($NewGroupName));
      }
    }
  }
  
  include("$libDir/admin_nav.php");
showTabbedMenu(10);
  if( $errs ) {
    $zen->printErrors($errs);
    $TODO = 'EDIT';
    include("$templateDir/groupAdd.php");
  } else {
    include("$templateDir/groupForm.php");
  }

  include("$libDir/footer.php");

}?>
