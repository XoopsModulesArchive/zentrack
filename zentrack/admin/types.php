<?{

  /*
  **  EDIT TYPES
  **  
  **  Edit/create/delete the types
  **
  */  

  include("admin_header.php");

  $vars = array();
  if( $TODO == 'Save' ) {
    if( !is_array($newName) || !count($newName) ) {
      $errs[] = tr("There was nothing provided to update");
    } else if( $zen->demo_mode == "on" ) {
      $msg[] = tr("Process completed successfully.  Types were not updated since this is a demo site.");
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
      // specify validation parms
      for( $i=0; $i<count($newName); $i++ ) {
        if( $newName[$i] ) {
          // this line is necessary to insure that magic quotes are handled properly
          $newName[$i] = $zen->cleanValue('html', $newName[$i]);
          // now we will conduct the update
          $updateParams = array( 
            "name"     => $newName[$i],
            "active"   => (strlen($newActive[$i])? 1 : 0),
            "priority" => getPriCount($newPri[$i], $lowestCount)
          );
          $res = ($newID[$i])?
            $zen->update_type($newID[$i], $updateParams) :
            $zen->add_type($updateParams);
          if( $res ) { $j++; }
        }
      }
      $c = $i > 0? $i-1 : 0;
      $msg[] = tr("? of ? types were saved to the database. Updates complete", array($j,$c));
      $skip = 1;
    }
  }

  $page_title = ($skip)? tr("Admin Section") : tr("Update Types");
  include("$libDir/admin_nav.php");
showTabbedMenu(9);
  $zen->printErrors($errs);
  $type = "type";
  $id_type = "type_id";
  $vars = $zen->getTypes(1,0);
  include("$templateDir/configForm.php");
  
  include("$libDir/footer.php");

}?>









