<?{
   
  /*
  **  ADD GROUP SUBMIT
  **  
  **  Commits new zenTrack data group to db
  **
  */
  
  include("admin_header.php");
  $page_title = tr("New Group Submit");

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

  // insure that group name is unique
  if( !$errs ) {
    $group_id = $zen->getDataGroupId( $NewGroupName );
    if( $group_id ) {
      $errs[] = "The group '{$NewGroupName}' already exists.  The group name must be unique.";
    }
  }

  // add to database (or do demo mode message)
  if( !$errs ) {
    if( $zen->demo_mode == "on" ) {
      $msg[] = tr("Process successful.  Group was not added, because this is a demo site.");
    } else {
      $group_id = $zen->addDataGroup( $NewGroupName, $NewTableName, $NewDescript, 
      $NewEvalType, $NewEvalText, $name_of_file, $include_none, array() );
      if( $group_id ) {
        $vars = $zen->generateDataGroupInfo( array($group_id) );
        $_SESSION['data_groups'][$group_id] = $vars[$group_id];

        // print useful messages for user
        $msg[] = tr("Group '?' was updated successfully.", array($NewGroupName));
      } else {
        $errs[] = tr("System Error: Could not add ? to the system", array($NewGroupName));
      }
    }
  }

  include("$libDir/admin_nav.php");
  if( $errs ) {
    $zen->printErrors($errs);
    $group = array( 'table_name'=>$NewTableName, 'group_name'=>$NewGroupName,
                    'descript'=>$NewDescript, 'eval_type'=>$NewEvalType,
                    'eval_text'=>$NewEvalText, 'name_of_file'=>$name_of_file);
    include("$templateDir/groupAdd.php");
  } else {
    include("$templateDir/groupForm.php");
  }

  include("$libDir/footer.php");

}?>
