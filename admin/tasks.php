<?php {
  /*
  **  EDIT TASKS
  **  
  **  Edit/create/delete the tasks
  **
  */  

  include("admin_header.php");

  $vars = array();
  if( $TODO == 'Save' ) {
    if( !is_array($newName) || !count($newName) ) {
      $errs[] = tr("There was nothing provided to update");
    } else if( $zen->demo_mode == "on" ) {
      $msg[] = tr("Process completed successfully.  Tasks were not updated since this is a demo site.");
      $skip = 1;
    } else {
      // find out the lowest count, so we can renumber all priorities
      // from 1
      $lowestCount = null;
      $highestCount = null;
      for($i=0; $i<count($newPri); $i++) {
        if( !strlen($lowestCount) || $newPri[$i] < $lowestCount ) {
          $lowestCount = $newPri[$i];
        }
        if( !strlen($highestCount) || $newPri[$i] > $highestCount ) {
          $highestCount = $newPri[$i];
        }
      }
      
      $j = 0;
      for( $i=0; $i<count($newName); $i++ ) {
        if( $newName[$i] ) {
          $updateParams = array( 
          "name"     => $newName[$i],
          "active"   => (strlen($newActive[$i])? $newActive[$i]:0),
          "priority" => getPriCount($newPri[$i], $lowestCount)
          );
          $res = ($newID[$i])?
          $zen->update_task($newID[$i], $updateParams) :
          $zen->add_task($updateParams);
          if( $res )
          $j++;
        }
      }
      $msg[] = tr("? tasks were saved to the database. Updates complete", array($j));
      $skip = 1;
    }
  }
  
  $page_title = ($skip)? tr("Admin Section") : tr("Update Tasks");
  include("$libDir/admin_nav.php");
showTabbedMenu(8);
  $zen->printErrors($errs);
  $type = "task";
  $id_type = "task_id";
  $vars = $zen->getTasks(1,0);
  include("$templateDir/configForm.php");
  
  include("$libDir/footer.php");

}?>









