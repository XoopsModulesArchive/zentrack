<?{

  /*
  **  EDIT BINS
  **  
  **  Edit/create/delete the bins
  **
  */
  

  include("admin_header.php");

  $vars = array();
  if( $TODO == 'Save' ) {
    if( !is_array($newName) || !count($newName) ) {
      $errs[] = tr("There was nothing provided to update");
    } else if( $zen->demo_mode == "on" ) {
      $msg[] = tr("Process completed successfully.  Bins were not updated since this is a demo site.");
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
      
      // iterate each item and perform updates
      $j = 0;
      $k = 0;
      for( $i=0; $i<count($newName); $i++ ) {
        if( $newName[$i] ) {
          $updateParams = array( 
          "name"     => $newName[$i],
          "active"   => strlen($newActive[$i])? $newActive[$i] : 0,
          "priority" => getPriCount($newPri[$i],$lowestCount)
          );
          $res = ($newID[$i])?
          $zen->update_bin($newID[$i], $updateParams) :
          $zen->add_bin($updateParams);
          if( $res ) { $j++; }
          $k++;
        }
      }
      $msg[] = tr("? of ? bins were saved to the database. Updates complete", array($j,$k));
      $skip = 1;
    }
  }

  $page_title = ($skip)? tr("Admin Section") : tr("Update Bins");
  include("$libDir/admin_nav.php");
showTabbedMenu(5);
  $zen->printErrors($errs);
  $vars = $zen->getBins(1,0);
  $type = "bin";
  $id_type = $zen->getTableId('bins');
  include("$templateDir/configForm.php");
  
  include("$libDir/footer.php");

}?>