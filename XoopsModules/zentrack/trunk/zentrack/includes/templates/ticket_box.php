<? if( !ZT_DEFINED ) { die("Illegal Access"); }
  $zen->addDebug('ticket_box.php', "Rendering ".$boxview, 3);

 /**
  * A tab or block of information in the ticket view
  *
  * REQUIREMENTS:
  *   $map - instance of ZenFieldMap
  *   $zen - instance of ZenTrack
  *   $boxview - (string)view to be loaded from field map
  *   $ticket - values for all columns in the ticket we are viewing
  */

  $id = $ticket['id'];
  $varfields = $zen->getVarfieldVals($id);

  if( !$zen->checkAccess($login_id, $ticket['bin_id'], $map->getViewProp($boxview,'access_level')) ) {
    print("Illegal access");
    return;
  }

  //////////////////////////////////////////////////
  // render preload items
  //////////////////////////////////////////////////
  $pre = $map->getViewProp($boxview,'preload');
  if( $pre ) {
    foreach($pre as $l) { 
      include("$templateDir/ticket_load_$l.php");
    }
  }

  /////////////////////////////////////////////////
  // print fields
  /////////////////////////////////////////////////
  if( $map->getViewProp($boxview, 'view_only') ) {
    include("$templateDir/ticket_fields_viewable.php");
  }
  else {
    include("$templateDir/ticket_fields_editable.php");
  }
  
  ////////////////////////////////////////////////////
  // postload items
  ////////////////////////////////////////////////////
  $post = $map->getViewProp($boxview,'postload');
  if( $post ) {
    foreach($post as $l) {
      include("$templateDir/ticket_load_$l.php"); 
    }
  }
  
  $zen->addDebug('ticket_box.php', "Completed ".$boxview, 3);
?>
