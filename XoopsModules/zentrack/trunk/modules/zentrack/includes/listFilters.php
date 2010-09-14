<?php
  /**
   ** APPLY FILTERS TO TICKET LISTS
   **
   ** This file is designed to be used with includes/templates/listFiltersForm.php
   **
   ** REQUIREMENTS
   **    $view - the current view name
   **    $page_type - 'ticket' or 'project'
   **    $zen - zenTrack object
   **    $map - ZenFieldMap object
   **
   ** RESULTS
   **    $filter_params - indexed array of column->value to be passed into get_tickets()
   **    $filter_params_withnulls - same as filter_params, but contains nulls (for use in form)
   **/
   
   /////////////////////////
   // PREPARE
   /////////////////////////

  // determine which filter set we should be using
  $filter = "session_filters_{$page_type}";
  $filterview = "{$view}_filters";

  // first we try to load the params from the session
  $params = $sm->find($filter);
  
  // used to determine if we will update the session after calculations
  $updated = false;

  /////////////////////////
  // CONSTRUCT
  /////////////////////////
  
  // then we construct filters from user settings and field map defaults
  if( !$params || !count($params) ) {
    // get field map which describes the filter values
    $filtercols = $map->getFieldMap($filterview);
    
    $params = array();
    $dt = '';
    if( $filtercols && count($filtercols) > 0 ) {
      // set our params using the filter values (if they have a default value)
      foreach($filtercols as $k=>$v) {
        if( $v['is_visible'] && !empty($v['default_val']) ) {
          if( $k == 'priority' ) {
            $params[$k] = is_array($v['default_val'])?
               join(',',$v['default_val']) : $v['default_val'];
          }
          else {
            $params[$k] = $v['default_val'];
            $dt .= "|::$k = {$v['default_val']}::|";
          }
        }
      }
    }
    
    // if there is no default bin specified, we will try to use the current
    // user's home bin
    if( (!array_key_exists('bin_id', $params) || !isset($params['bin_id'])) && $login_bin > 0 ) {
      $params['bin_id'] = $login_bin;
      $dt .= "bin_id = $login_bin";
    }
    $updated = true;
    $zen->addDebug('listFilters.php', "[$filter|$filterview]Constructing new filter parms: {$dt}", 2);
  }
  
  /////////////////////////
  // UPDATE FROM FORM
  /////////////////////////
  
  // if there have been updates by the user, we will apply those to the session
  if( $_GET['ticketFilterForm'] == 1 ) {
    
    // get field map which describes the filter values
    $filtercols = $map->getFieldMap($filterview);
    $dt = '';
    if( $filtercols && count($filtercols) > 0 ) {
      // set our params using the form results
      foreach($filtercols as $k=>$v) {
        $pn = "filterForm_{$k}";
        if( array_key_exists($pn, $_GET) ) {
          $params[$k] = $_GET[$pn];
          $dt .= "|::$k = ".$_GET[$pn]."::|";
          $updated = true;
        }
      }
    }
    $zen->addDebug('listFilters.php', "[$filter|$filterview]Updating filter parms from form data: {$dt}", 2);
  }
  
  /////////////////////////
  // SAVE TO SESSION
  /////////////////////////
  if( $updated ) { $sm->store($filter, $params); }
  
  /////////////////////////
  // VALIDATE AND CLEAN UP
  /////////////////////////
  if( $page_type == 'project' ) {
    // if this is a project type, make sure we only show types of projects
    if( !array_key_exists('type_id',$params) || empty($params['type_id']) ||
        !$zen->inProjectTypeIDs($params['type_id']) ) {
      $zen->addDebug('listFilters.php', "[$filter|$filterview]Using default project types", 3);
      $params['type_id'] = $zen->projectTypeIDs();
    }
  }
  else {
    // if it is not a project type, hide projects
    if( !array_key_exists('type_id', $params) || empty($params['type_id']) ||
        $zen->inProjectTypeIDs($params['type_id']) ) {
      $zen->addDebug('listFilters.php', "[$filter|$filterview]Using default ticket types", 3);
      $params['type_id'] = $zen->notProjectTypeIDs();
    }
  }

  if( array_key_exists('bin_id',$params) && !empty($params['bin_id']) ) {
    // validate the bins to make sure this user can view them
    $userBins = $zen->getUsersBins($login_id);
    $vals = is_array($params['bin_id'])? $params['bin_id'] : array($params['bin_id']);
    foreach($vals as $v) {
      if( strlen($v) && !in_array($v, $userBins) ) {
        $zen->addDebug('listFilters.php', "[$filter|$filterview]Invalid bin_id $v, resetting filter parms", 1);
        $params['bin_id'] = $userBins;
        break;
      }
    }
  }
  else {
    // set the bins to the default set for this user
    $zen->addDebug('listFilters.php', "[$filter|$filterview]Using default bins", 3);
    $params['bin_id'] = $zen->getUsersBins($login_id);
  }
  
  /////////////////////////
  // GENERATE FINALIZED VALS
  /////////////////////////
  $filter_params_withnulls = $params;
  $filter_params = array();
  foreach($params as $k=>$v) {
    if( (is_array($v) && count($v)) || (!is_array($v) && strlen($v)) ) {
      if( strpos($v,',') > 0 ) {
        if( $k == 'status' || $map->getFieldProp($filterview,$k,'field_type') == 'searchbox' ) {
          $filter_params[$k] = explode(',',$v);
        }
      }
      else {
        $filter_params[$k] = $v;
      }
    }
  }
  
?>