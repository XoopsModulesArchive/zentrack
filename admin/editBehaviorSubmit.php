<?php {
  /*
  **  EDIT BEHAVIOR SUBMIT
  **  
  **  Commits zenTrack behavior modifications to db
  **
  */
  
  include("admin_header.php");
  $page_title = tr("Edit Behavior Submit");

  if( !$active )
    $active = 0;

  $behavior_fields = array(
                             "NewBehaviorName"       => "string",
                             "NewGroupId"            => "int",
                             "NewIsEnabled"          => "int",
                             "NewSortOrder"          => "int",
                             "NewFieldName"          => "alphanum",
                             "NewMatchAll"           => "int",
                             "NewFieldEnabled"       => "int"
                             );

  $behavior_required = array("NewBehaviorName",
                             "NewGroupId",
                             //"NewIsEnabled",
                             //"NewSortOrder",
                             "NewFieldName",
                             //"NewFieldEnabled",
                             "NewMatchAll");


  $zen->cleanInput($behavior_fields);
  foreach($behavior_required as $d) {
    if( !strlen($$d) ) {
      $errs[] = tr("All the fields are required");
    }
  }


  if( !$errs ) {
    if( $zen->demo_mode == "on" ) {
      $msg[] = tr("Process successful.  Behavior was not updated, because this is a demo site.");
    } else {
      $updflds = array(
      "behavior_name" => $NewBehaviorName,
      "group_id"      => $NewGroupId,
      "is_enabled"    => $NewIsEnabled,
      "sort_order"    => $NewSortOrder,
      "field_name"    => $NewFieldName,
      "field_enabled" => $NewFieldEnabled,
      "match_all"     => $NewMatchAll
      );
      $res = $zen->updateBehavior($behavior_id,$updflds);
      if( $res ) {
        $msg[] = tr("Behavior ? was updated successfully.",$NewBehaviorName);
      } else {
        $errs[] = tr("System Error: Could not update ?", array($NewBehaviorName));
      }
    }
  }

  include("$libDir/admin_nav.php");
showTabbedMenu(11);
  if( $errs ) {
    $zen->printErrors($errs);
    $TODO = 'EDIT';
    include("$templateDir/behaviorForm.php");
  } else {
    include("$templateDir/behaviorMenu.php");
  }

  include("$libDir/footer.php");

}?>
