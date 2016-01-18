<?php {
  /*
  ** Validates input fields for add/edit operations
  **
  ** Depends on the following variables:
  **    (String)$view - the view which will be passed into the field map
  **    (ZenFieldMap)$map - the field map to collect field info from
  **
  ** Creates the following variables:
  **    (Array)$fields - key/value pairs of (String)field => (String)data_type
  **    (Array)$required - array of (String)field names which are required for this view
  **    (Array)$varfield_params - contains the values needed to run $zen->updateVarfieldVals() (if any)
  */
  if( !ZT_DEFINED ) { die("Illegal Access"); }
  
  $fields = array();
  $varfields = array();
  $required = array();
  $customFieldsArray = false;
  $customFieldsArray = $map->getFieldMap($view);
  $fprops = getFmFieldProps($view);
  if(is_array($customFieldsArray)) {
    foreach($customFieldsArray as $f=>$field) {
      // don't include sections
      if( $field['field_type'] == 'section' ) { continue; }
      // parse dates
      if( $fprops["$f"]['data_type'] == 'date' ) {
        $$f = $$f > 0? $zen->dateParse($$f) : null;
      }
      //if( !$field['is_visible'] ) { continue; }
      if( $field['is_required'] || $fprops["$f"]['always_required'] ) {
        $required[] = $f;
      }
      if ( strpos($f,'custom_') === 0 ) { $varfields["$f"] = $field; }
      else { $fields["$f"] = $fprops["$f"]['data_type']; }
    }
  }

  $zen->cleanInput($fields);
  
  // insure that the user/bin combination provided is allowed
  // we aren't worried about user/bin combinations if the user will be stripped
  $c = $view != 'ticket_close' || $zen->settingOn('retain_owner_closed');
  if( $c && $user_id && !$zen->checkAccess($user_id, $bin_id, 'level_user') ) {
    $errs[] = tr('The user assigned to this ticket does not have '.
                 'level_user priviledges for the selected bin (?)', $zen->getBinName($bin_id));
  }
  
  // do not allow self referencing tickets
  if( isset($id) && isset($project_id) && $id && $id == $project_id ) {
    $errs[] = tr("The parent project cannot be set to this project (itself)");
  }
  
  // check for required fields
  foreach($required as $r) {
    if( !strlen($$r) ) {
      $errs[] = tr("Required field missing:") . " " . ucfirst($r);
    }
  }
  
  // parse variable fields which appear in new ticket screen, 
  // store them in $varfield_params
  // insure that all requirements are met before proceeding
  // with the ticket save process
  if( count($varfields) ) {
    include("$libDir/parseVarfields.php");
  }
  
}?>
