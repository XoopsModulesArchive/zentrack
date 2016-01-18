<?php {  /*
  **  TICKET DISPLAY PAGE
  **  
  **  Displays a ticket to the screen
  **
  */
  
  // include the header file
  if( file_exists("header.php") ) {
    include_once("header.php");
  }
  else if( file_exists("../header.php") ) {
    include_once("../header.php");
  }

  
  // determine if we are viewing a project or a ticket
  if( !isset($view) || $view != 'project_view' ) {
    $view = 'ticket_view';
  }
  
  // redirect to somewhere user can pick a ticket if no id was recieved
  if( !$id ) {
    $pt = $view == 'project_view'? 'projects.php' : 'index.php';
    include("$rootWWW/$pt");
    exit;
    //header("Location: $rootUrl/index.php\n");
  }

  
  // load the ticket info, validate it, and switch 
  // to the project view if needed
  if( $view == "project_view" ) {
    $ticket = $zen->get_project($id, true);
    $page_type = 'project';
  } else {
    $ticket = $zen->get_ticket($id, true);
    $page_type = 'ticket';
    if( $ticket ) {
      if( $zen->inProjectTypeIDs($ticket["type_id"]) ) {
        $ticket = $zen->get_project($id, true);
        $view = 'project_view';
        $page_type = 'project';
      }
    }
  }
  
  // if there is no ticket for this id, then load the list and
  // inform the user of the bad choice
  if( !is_array($ticket) || !count($ticket) ) {
    $pt = $page_type == 'project'? 'projects.php' : 'index.php';
    $msg[] = tr("Invalid ? id requested", array(tr($page_type)));
    include("$rootWWW/$pt");
    exit;
  }  
  
  // load hot keys for page
  $hotkeys->loadSection($view);
  $GLOBALS['zt_hotkeys'] = $hotkeys;
  
  // place record into history of recently viewed items
  $history =& $zen->getHistoryManager();
  $history->storeItem($page_type, $id, $ticket['title']);  

  /*
  **  Collect information for displaying nav and UI elements
  */
  $page_title = $zen->getTypeName($ticket['type_id'])." #$id";
  
  // allow creator of ticket to view (if setting is on) even if no access
  $is_creator = $zen->checkCreator($login_id, $id);
  
  if( !$is_creator && !$zen->checkAccess($login_id,$ticket["bin_id"]) ) {
    include_once("$libDir/nav.php");
    print "<p class='hot'>" . tr("You are not allowed to view ? in this bin", array(tr($page_type."s"))) ."</p>";
    include_once("$libDir/footer.php");
    exit;
  }

  if( $ticketTabAction == 1 ) {
    $setmode = $_POST['currentMode'];
    
    // check access and make sure user is allowed to make this edit
    if( $map->getViewProp($setmode, 'view_only') ) {
      $errs[] = "Fields cannot be edited in this view";
    }
    else if( !$zen->checkAccess($login_id, $ticket['bin_id'], 
    $map->getViewProp($setmode, 'access_level')) ) {
      $errs[] = "You do not have sufficient access for this area";
    }
    
    // we have to switch the view temporarily to call validateFields,
    // unfortunately, so we hack it here
    // we validate the input fields here
    if( !$errs ) {
      $OV = $view;
      $view = $setmode;
      include("$libDir/validateFields.php");
      $view = $OV;
    }
    
    if( !$errs ) {
      $params = array();
      // create an array of existing fields
      foreach(array_keys($fields) as $f) {
        // can't edit the status
        if( $f == 'status' ) { continue; }
        // put the value into the updates array
        $params["$f"] = $$f;
        if( $f == 'title' && strlen($params["$f"]) > 50 ) {
          $params["$f"] = substr($params["$f"],0,50);
        }
      }
      // update the ticket info
      $action_name="UPDATE";
      $label = $map->getViewProp($setmode,'label');
      $log_init=tr("Updated ticket in ?",array(tr("? tab",array($label))));

      $errs = $zen->update_all_ticket_fields($id, $login_id, $bin_id, $params,
                                    $varfield_params, $action_name, $log_init, $edit_reason);
/*
      if (count($params)>0) {
        $res = $zen->edit_ticket($id,$login_id,$params,$edit_reason);
        // check for errors
        if( !$res ) {
          $errs[] = tr("System Error").": ".tr("Ticket could not be edited.")." ".$zen->db_error;
        }
      }
      if( !$errs && count($varfield_params) ) {
        $res = $zen->updateVarfieldVals($id, $varfield_params, $login_id, $bin_id);
        if( !$res ) {
          $errs[] = tr("? updated, but variable fields could not be saved", array(tr($x)));
        }
      }
*/      
      // update the variable field entries for this ticket
      if( $errs ) {
        $errs[] = tr("Unable to edit ticket due to system error"). " ".$zen->db_error;
      }
      else {
        if( in_array($params["type_id"],$zen->noteTypeIDs()) && $ticket['status'] == 'OPEN' ) {
          $zen->close_ticket($id,null,null,tr('Notes closed automatically'));
        }
/*
        $ticket = $zen->get_ticket($id);
        if( $varfields && count($varfield_params) ) {
          $vp = array();
          foreach($varfield_params as $k=>$v) {
            if( $map->getFieldProp($setmode,$k,'is_visible') ) {
              $vp[$k] = $v;
            }
          }
          $res = $zen->updateVarfieldVals($id, $vp);
          if( !$res ) {
            $errs[] = tr("? created, but variable fields could not be saved due to system error", array(tr('Ticket')));
          }
          else {
            $msg[] = tr('All fields updated successfully');
          }
        }
        else {
*/
          $msg[] = tr('All fields updated successfully');          
/*
        }
*/
      }
    }
    $ticket = $zen->get_ticket($id);

    if( $errs ) {
      foreach($params as $k=>$v) {
        $ticket[$k] = $v;
      }
      $varfields = $varfield_params;
    }
  }  // if( $ticketTabAction == 1 )
  
  // determine which page we will view
  $page_mode = "{$page_type}_tab_1";
  if( $setmode ) {
    $page_mode = preg_replace('@[^0-9a-zA-Z_]@', '', $setmode);
  }
  
  // load behavior js if needed
  if( preg_match("@^{$page_type}_tab_[0-9]$@", $page_mode) ) {
    $tabs = $map->getTabs($page_type, $login_id, $ticket['bin_id']);
    if( !array_key_exists($page_mode, $tabs) ) {
      $zen->addDebug('ticket.php', "Invalid tab requested: $page_mode... defaulting", 1);
      $page_mode = key($tabs);
    }

    while( !$tabs[$page_mode]['visible'] || 
      !$zen->checkAccess($login_id,$ticket['bin_id'],
        $tabs[$page_mode]['access_level']) ) {
      next($tabs);
      $page_mode = key($tabs);
    }
    reset($tabs);
    if( !$map->getViewProp($page_mode, 'view_only') ) {
      $onLoad[] = "behavior_js.php?formset=".$zen->ffv($page_mode);
    }
  }
  
  /*
  ** PRINT OUT THE PAGE
  */ 
  include_once("$libDir/nav.php");
  $zen->printErrors($errs);
  include("$templateDir/ticketView.php");
  include("$libDir/footer.php");
}?>
