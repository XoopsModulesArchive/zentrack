<?php {
  /*
  **  LOG TICKET
  **  
  **  Create a log entry
  **
  */
  
  $action = "log";  
  include("action_header.php");
  
  if( $actionComplete == 1 ) {
    $input = array(
    "id"       => "int",
    "comments" => "text",
    "hours"    => "num",
    "log_action"   => "text"
    );
    $zen->cleanInput($input);
    $required = array("id","action");
    foreach($required as $r) {
      if( !$$r ) {
        $errs[] = tr(" ? is required", array($r));
      }
    }     
    if( $log_action == 'LABOR' ) {
      if( !$hours )
      $errs[] = tr("Hours must be entered if the activity is 'LABOR'");
    } else if( !$comments ) {
      $errs[] = tr("No comments were entered.");
    }
    
    
    if( !$errs ) {
      $res = $zen->log_ticket($id, $login_id, $log_action, $hours, $comments);
      if( $res ) {
        $msg[] = tr("Log entry has been added");
      } else {
        $errs[] = tr("System error: Activity could not be logged.").$zen->db_error;
      }
    }

    if( !$errs ) { 
      $action = null;
      $tabs = $map->getTabs($page_type, $login_id, $ticket['bin_id']);
      foreach($tabs as $k=>$v) {
        if( $v['preload'] && in_array('log',$v['preload']) ) {
          $setmode = $k;
          break;
        }
        else if( $v['postload'] && in_array('log',$v['postload']) ) {
          $setmode = $k;
          break;
        }
      }
    }
  }

  include("$libDir/nav.php");
  $zen->printErrors($errs);  
  $page_mode = $setmode;
  if( $page_type == "project" ) {
    include("$templateDir/projectView.php");
  } else {
    include("$templateDir/ticketView.php");     
  }
  include("$libDir/footer.php");
  
}?>