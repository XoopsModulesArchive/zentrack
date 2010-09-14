<?php if( !ZT_DEFINED ) { die("Illegal Access"); }

  /*
  **  FIELDS EDITABLE
  **
  **  Renders fields in ticket view window for editing
  **
  **  REQUIREMENTS:
  *   $map - instance of ZenFieldMap
  *   $zen - instance of ZenTrack
  *   $boxview - (string)view to be loaded from field map
  *   $ticket - values for all columns in the ticket we are viewing
  */
  
  $hotkeys->loadSection('ticket_fields_editable');
  $GLOBALS['zt_hotkeys'] = $hotkeys;
  $formview = $boxview;
  $formName = 'ticketForm';
  $actionName = $SCRIPT_NAME;
  $formTitle = '&nbsp;';
  $submitName = 'Save';
  include("$templateDir/ticket_tab_form.php");
?>
