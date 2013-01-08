<?php {
  /*
  **  EDIT PRIORITIES
  **  
  **  Edit/create/delete the priorities
  **
  */  

  include("admin_header.php");

  $vars = array();
  if( $TODO == 'Save' ) {
    
    if( !is_array($newName) || !count($newName) ) {
      $errs[] = tr("There was nothing provided to update");
    } else if( $zen->demo_mode == "on" ) {
      $msg[] = tr("Process completed successfully.  Priorities were not updated since this is a demo site.");
      $skip = 1;
    } else {
      // It is critical that priorities are numbered sequentially, so we will
      // index, sort, and renumber them to be sure they are accurate and correct
      $priVals = array();
      for($i=0; $i<count($newPri); $i++) {
        $n = $newName[$i];
        // this little doozie sets all inactive priorities to an impossible
        // negative number so that we can tell them apart after sorting
        $priVals[$n] = isset($newActive[$i])? $newPri[$i] : 0-count($newPri)-100;
      }
      asort( $priVals );
      
      // now that we know the order of the priorities, we will assign
      // sequential numbers to them
      $newCount = 1;
      foreach($priVals as $k=>$v) {
        if( $v == 0-count($newPri)-100 ) {
          // inactive items get set to 0
          $priVals[$k] = 0;
        }
        else {
          $priVals[$k] = $newCount++;
        }
      }
      
      $j = 0;
      for( $i=0; $i<count($newName); $i++ ) {
        if( $newName[$i] ) {
          $n = $newName[$i];
          $updateParams = array( 
          "name"     => $n,
          "active"   => isset($newActive[$i])? $newActive[$i] : 0,
          "priority" => $priVals[$n]
          );
          $res = ($newID[$i])?
          $zen->update_priority($newID[$i], $updateParams) :
          $zen->add_priority($updateParams);
          if( $res )
          $j++;
        }
      }
      $msg[] = tr("? priorities were saved to the database. Updates complete", array($j));
      $skip = 1;
    }
  }

  $page_title = ($skip)? tr("Admin Section") : tr("Update Priorities");
  include("$libDir/admin_nav.php");
showTabbedMenu(6);
  $zen->printErrors($errs);
  $type = "priority";
  $id_type = "pid";
  $vars = $zen->getPriorities(1,0);
  include("$templateDir/configForm.php");
  
  include("$libDir/footer.php");

}?>









