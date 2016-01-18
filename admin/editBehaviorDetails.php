<?php
  /*
  **  EDIT BEHAVIOR DETAILS
  **  
  **  Modifies the details of an existing behavior
  **
  */
  
  
  include_once("admin_header.php");

  if( !isset($more) ) { $more = 3; }
  if( $TODO == 'MORE' ) {
    $more = $more+3;
  } else if( $TODO == 'LESS' ) {
    $more = 0;
  }

  $behavior_id = $zen->checkNum($behavior_id);
  $behavior = $zen->getBehavior( $behavior_id );
  if( !$behavior ) {
    $zen->addDebug('editBehaviorDetails.php', "Behavior id '$behavior_id' could"
        ." not be found, redirecting to menu",1);
    $skip = 1;
    unset($TODO);
  }
  else {
    $group = $zen->getDataGroup($behavior['group_id']);
  }
  $elements=array();

//When the action is MORE or LESS, we fill the elements array with the values from the Form
  if( $TODO == 'MORE' || $TODO == 'LESS' ) {
    for( $i=0; $i<count($NewFieldName); $i++ ) {
      if( $NewFieldName[$i] && strlen($NewFieldName[$i])>0 ) {
        $elements[] = array(
                        "field_name" => $NewFieldName[$i],
                        "field_operator" => $zen->checkAlphaNum($NewComparator[$i]),
                        "field_value"=> $NewMatchValue[$i],
                        "sort_order" => $zen->checkNum($NewSortOrder[$i])
                        );
      }
    }
  } else if( $TODO == 'Save' ) {
//When the action is Save and demo_mode is on, we don't save the changes to the database
    if( $zen->demo_mode == "on" ) {
      $msg[] = tr("Process completed successfully. Behaviors were not updated since this is a demo site.");
      $skip = 1;
    } else {
      $j = 0;
      for( $i=0; $i<count($NewFieldName); $i++ ) {
        if( $NewFieldName[$i] && strlen($NewFieldName[$i])>0 ) {
          $elements[] = array(
                        "field_name" => $NewFieldName[$i],
                        "field_operator" => $zen->checkAlphaNum($NewComparator[$i]),
                        "field_value"=> $NewMatchValue[$i],
                        "sort_order" => $zen->checkNum($NewSortOrder[$i])
                              );
          $j++;
        }
      }
//Last commands for the Save action when demo_mode is not on:
      $zen->updateBehaviorDetails($behavior_id, $elements) ;
      $msg[] = tr("? elements were saved in the selected behavior. Updates complete", array($j));
      $skip = 1;
    }
  } else {
    $behavior_details = $behavior['fields'];
    if ( !is_array($behavior_details) ) {
      $behavior_details = array();
    }
    $TODO = 'EDIT';
    foreach ($behavior_details as $v) {
      if ( $v['field_name'] && strlen($v['field_name'])>0 ) {
        $elements[]=$v;
      }
    }
  }
  $page_title = ($skip)? tr("Admin Section") : tr("Edit Behavior Details");

  $field_list=$zen->getBehaviorDestinationFieldsArray();
  $comp_opers=$zen->getBehaviorOperators();

  include_once("$libDir/admin_nav.php");
showTabbedMenu(11);
  $zen->printErrors($errs);

  if( !$skip ) {
    include("$templateDir/behaviorDetailForm.php");
  } else {
    include("$templateDir/behaviorMenu.php");
  }
  include_once("$libDir/footer.php");


?>