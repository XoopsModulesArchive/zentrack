<?php {if( !ZT_DEFINED ) { die("Illegal Access"); }


  // integrity
  unset($params);
  
  // if there is a user_id, then skip the fancy
  // mumbo-jumbo and get down to business
  // otherwise sort out and determine
  // how to use the parameters given
  if( $search_params["user_id"] ) {
    $params[] = array("user_id","=",$search_params["user_id"]);
  } else {
    // organize the search params
    if( is_array($search_params) ) {
      if( $search_params["access_level"] ) {
	switch($search_access_method) {
	case "gt":
	  $op = ">=";
	  break;
	case "lt":
	  $op = "<=";
	  break;
	default:
	  $op = "=";
	  break;
	}
	$search_params["access_level"] = ereg_replace("[^0-9]", "", $search_params["access_level"]);
      }
      foreach($search_params as $k=>$v) {
	if( strlen($v) ) {
	  switch($k) {
	  case "access_level":
	    $params[] = array($k,$op,$v,1);
	    break;
	  default: 
	    $params[] = array($k,"=",$v,1);
	    break;
	  }
	}
      }
    }
    
    // see if there is a text search and
    // if so, then see what fields are to
    // be searched
    if( $search_text && is_array($search_fields) && count($search_fields)>0 ) {
      unset($sp);
      foreach($search_fields as $k=>$f) {
	$sp[] = array($f,"contains",$search_text);
      }
      $params[] = (count($sp)>1)? array("OR",$sp) : $sp[0];
    }
  }
    
  if( !is_array($params) || !count($params) ) {
    // set an error message if there was no form data
    $errs[] = "No valid fields were provided to conduct a search";
  }

  // if there are any search params
  // then perform the query
  if( !is_array($errs) ) {
    // debug
    unset($dp);
    foreach($params as $v) {
      $dp[] = "'".join("','",$v)."'";
    }
    $zen->addDebug("searchUserResults.php-params[]",join("|",$dp),3);
    // debug
    $users = $zen->search_users($params, "AND");
  }

}?>
