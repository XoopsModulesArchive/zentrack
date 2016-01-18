<?php
  
  /*
  **  ACTION HEADER
  **
  **  global to all ticket action pages
  **
  **  Prepare some variables for the
  **  action pages, and include the main
  **  page header
  */

  include_once("../header.php");

  // set the ticket mode to system
  //$page_mode = 'system';
  //$setmode = 'system';

  // check to insure a ticket id was passed
  $id = ereg_replace("[^0-9]", "", $id);

  if( !$id ) {
    $zen->addDebug("action_header","No ticket id, redirecting",1);
    include("$rootWWW/index.php");
    exit;
  }
  
  // check to insure that this user has access
  // and this ticket allows the requested action
  // to be completed
  $ticket = $zen->get_ticket($id);
  $tid = $ticket["type_id"];
  if( in_array($tid,$zen->projectTypeIDs()) ) {
    $ticket["children"] = $zen->getProjectChildren($id, 
	    array("id,title,status,est_hours,wkd_hours"));
    list($ticket["est_hours"],$ticket["wkd_hours"]) = $zen->getProjectHours($id);
    $page_type = "project";
    $view = 'project_view';
  }  else {
    $page_type = "ticket";
    $view = 'ticket_view';
  }
  
  // use the filename to 
  // determine the action
  $basename = strtolower(preg_replace("@.*/([a-zA-Z0-9_-]+)\.php@", "\\1", $SCRIPT_NAME));
  if( in_array($basename,array_keys($zen->getActions())) ) {
    $action = $basename;
  }
  //else if( $basename == 'editcustomsubmit' ) {
  //  $action = 'varfield_edit';
  //}
  else if( $basename == "editticketsubmit" || $basename == "editsubmit" ) {
    $action = "edit";
  }
  else if( $basename == "addtonotify" || $basename == "dropfromnotify" ) {
    $action = "notify";
  }
  else if( $basename == 'addtocontacts' || $basename == 'dropfromcontacts' ) {
    $action = 'contacts';
  }
  else if( $basename == 'dropattachments' ) {
    $action = 'upload';
  }
  else if( !$action ) {
    $action = "view";
  }
  
  // find out if this is the ticket's creator (special conditions apply)
  $tf_creator = (($action=="view"||$action == "print"||$action == "email")
	&&$zen->settingOn("allow_cview")
	&&$zen->checkCreator($login_id,$tid));


  // find out if user can do this action, if not, redirect them
  if( !$zen->actionApplicable( $id, $action, $login_id ) && !$tf_creator ) {
    $zen->addDebug("action_header.php","Action ($action) was not applicable, redirecting",1);
    $action = '';
    $ticketTabAction = false;
    include("$rootWWW/ticket.php");
    exit;
  }

  // set up page paremeters
  $page_title = $page_type == "project"? tr("Project #?", array($id)) : tr("Ticket #?", array($id));
  $page_section = "Ticket #$id";
  $page_mode = $setmode? $setmode : $action;
  $hotkeys->loadSection($view);
  $hotkeys->loadSection("action_$action");
  $GLOBALS['zt_hotkeys'] = $hotkeys;

?>
