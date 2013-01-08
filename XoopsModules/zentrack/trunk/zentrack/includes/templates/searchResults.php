<?{
if( !ZT_DEFINED ) { die("Illegal Access"); }

  include_once("$libDir/sorting.php");
  
  function searchResultsMaxPri( $a, $b ) {
    if( $a > $b ) { return $a; }
    return $b;
  }
  
  // integrity
  $params = array();
  $errs = array();
  
  //#####################################################
  //organize the date
  //#####################################################
  
  $search_dates = array();
  $view = 'search_form';
    
  // determine which bins user can view
  $userBins = $zen->getUsersBins($login_id);
  
  // organize the search params
  if( is_array($search_params) ) {
    foreach($search_params as $k=>$v) {
      if( !strlen($v) || (is_array($v) && count($v) == 0) ) { continue; }
      if( is_array($v) && count($v) == 1 && !strlen($v[0]) ) { continue; }
      
      $props = getFmFieldProps($view, $k);
      if( !$props && preg_match('/^([a-zA-Z0-9_]+)_(begin|end)$/', $k, $matches) ) {
        $props = getFmFieldProps($view, $matches[1]);
      }
      $type = $props['data_type'];
      $zen->addDebug('searchResults.php', "Including search_param[$k] ($type)", 3);
      if( $type == 'boolean' && $field['num_rows'] == 1 ) {
        $params[] = array($k, ($v? "=":"<"), 1, 1);
        continue;
      }
      else if( $type == 'date' ) {
        // we process on the _begin dates, so skip _end
        if( strpos($k, '_end') > 0 ) { continue; }
        
        // determine the field name, sans the begin/end suffix
        $base = substr($k, 0, -6);

        // calculate the name of the end field
        $re = "{$base}_end";

        // check for bugs in the form contents... dates must all have an
        // _begin and _end field
        if( !preg_match('/_begin$/', $k) ) {
          $zen->addDebug('searchResults.php', "$k is a date, must have a {$k}_begin and {$k}_end", 1);
          continue;
        }
        
        // convert the user's string to a date integer
        $d1 = $zen->dateParse($v);
        // add to the search parms
        $params[] = array($base, ">=", $d1, 1);
        
        if( empty($search_params["$re"]) ) { 
          $zen->addDebug('searchResults.php', "$re not found, defaulting to $d1+86400", 3);
          $d2 = strtotime("+1 year", $d1); 
        }
        else { $d2 = $zen->dateParse($search_params["$re"]); }
        $params[] = array($base, "<=", $d2, 1);

        $search_dates[$k] = $d1;
        $search_dates[$re] = $d2;
      }
      else {
        $field = $map->getFieldFromMap($view, $k);
        $op = '=';
        if( $field['field_type'] == 'searchbox' ) {
          $v = split(' *, *', $v);
          $op = 'IN';
        }
        else if( is_array($v) ) {
          $op = 'IN';
        }
        switch($k) {
          case "priority":
            if( $or_higher ) {
              if( is_array($v) ) {
                $v = array_reduce($v, "searchResultsMaxPri");
              }
              $params[] = array($zen->table_tickets.".$k",'<=',$v,1);
            }
            else {
              $params[] = array($zen->table_tickets.".$k",$op,$v,1);
            }
            break;
          case "bin_id":
            if( is_array($v) ) {
              $binvals = array();
              foreach($v as $val) {
                if( in_array($val, $userBins) ) {
                  $binvals[] = $val;
                }
              }
              $params[] = array($k, 'IN', $binvals, 1);
            }
            else if( in_array($v, $userBins) ) {
              $params[] = array($k, '=', $v, 1);
            }
            else {
              $errs[] = tr('You do not have permission to search this bin'); 
            }
            break;
          default:
            if ( !ZenFieldMap::isMultiField($k) ) {
              $params[] = array($k, $op, $v, 1);
            } else {
              $qry = "SELECT ticket_id, count(*) FROM $zen->table_varfield_multi "
                    ."WHERE field_name = '$k' AND field_value IN ('" . implode("','",$v) . "') "
                    ."GROUP BY ticket_id ";
              switch ($srch_opt[$k]) {
                case "EXACT":
                case "AND":
                  $qry.="HAVING count(*)=".count($v);
                  break;
              }
              $zen->addDebug("searchResults.php", "Query for multi field: $qry", 3);
              $vals = $zen->db_queryIndexed($qry);
              $tids = array('0');
              for($i=0; $i<count($vals); $i++) {
                $tids[] = $vals[$i][ticket_id];
              }
              if ($srch_opt[$k] == "EXACT") {
                $qry = "SELECT ticket_id FROM $zen->table_varfield_multi "
                      ."WHERE field_name = '$k' AND field_value NOT IN ('" . implode("','",$v) . "') ";
                $zen->addDebug("searchResults.php", "Query for multi field exclusion: $qry", 3);
                $tids_not = $zen->db_list($qry);
                $tids = array_diff($tids, $tids_not);
              }
              $params[] = array($zen->table_tickets.".id", 'IN', $tids, 1);
            }
            break;
        }
      }
    }
  }
  
  // see if there is a text search and
  // if so, then see what fields are to
  // be searched
  if( isset($search_text) && strlen($search_text) && is_array($search_fields) && count($search_fields) > 0 ) {
    unset($sp);
    foreach($search_fields as $k=>$f) {
      $zen->addDebug("searchResults.php", "Adding text search for $k", 3);
      $c = !(strpos($k, 'custom_text')===false && strpos($k,'description') === false);
      $sp[] = array($k,"contains",$search_text, $c);
    }
    $params[] = (count($sp)>1)? array("OR",$sp) : $sp[0];
  }
  
  if( !array_key_exists("bin_id", $params) ) {
    if( is_array($userBins) && count($userBins) ) {
      $params[] = array("bin_id","in",$userBins,1);
    } else {
      $errs[] = tr("You do not have access to any bins.")." ".tr("A search was not authorized");
    }
  }
  
  if( !is_array($params) || !count($params) ) {
    // set an error message if there was no form data
    $errs[] = tr("No valid fields were provided to conduct a search");
  }
  
  $tickets = null;
  
  // if there are any search params
  // then perform the query
  if( !count($errs) ) {
    if( $Debug_Mode > 2 ) {
      // don't wast processor time if debug mode is not set
      $db = array();
      foreach($params as $v) {
        $val = is_array($v[2])? "(".join(',',$v[2]).")" : $v2;
        $dp[] = "$v[0] $v[1] $val [$v[3]]";
      }
      $zen->addDebug("searchResults.php-params[]",join("||",$dp),3);
    }
    
    $limit = $nolimit? -1 : false;
    $tickets = $zen->search_tickets($params, "AND", "0", join(',',$orderby), $limit);//"status DESC, priority DESC"
    $total_search_results = $zen->total_records;
  }
  
}?>
