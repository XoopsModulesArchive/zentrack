<?{
  if( !ZT_DEFINED ) { die("Illegal Access"); }
  
  /**
  * Parses form input and creates an array called $varfield_params which contains the values needed
  * to run $zen->updateVarfieldVals()
  *
  * Depends on the following variables to determine which custom fields are used:
  *   $varfields - the variable fields that will be tested and parsed
  */
  
  $varfield_fields = array();
  foreach($varfields as $f) {
    $k = $f['field_name'];
    $v = $f['field_label'];
    $r = $f['is_required'];
    $varfield_type = getVarfieldDataType($k);
    switch($varfield_type) {
      case "number":
      if( !strlen($$k) ) {
        $cfv = 'NULL';
        $cft = 'ignore';
      } else {
        $cfv = $$k;
        $cft = "int";
      }
      break;
      case "date":
      if( !strlen($$k) ) {
        $cfv = 'NULL';
        $cft = "ignore";
      }
      else {
        $cfv = $zen->dateParse($$k);
        $cft = "int";
      }
      break;
      default:
      $cfv = $$k;
      $cft = "text";
      break;
    }
    $varfield_fields[$k] = $cft;
    $$k = $cfv;
    // check for required fields
    if ($r && !$$k) {
      $errs[] = tr("? is required", array(ucfirst(tr($v))));
    }
  }
  
  $varfield_params = array();
  if( !$errs ) {
    $zen->cleanInput($varfield_fields);
    // create an array of existing fields
    foreach(array_keys($varfield_fields) as $f) {
      $varfield_params["$f"] = $$f;
    }    
  }
  
}?>