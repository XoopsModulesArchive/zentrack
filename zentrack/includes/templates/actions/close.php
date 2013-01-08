<? if( !ZT_DEFINED ) { die("Illegal Access"); }
  /**
   * TEMPLATE FOR CLOSING TICKET
   *
   * This template just wraps a generic form generating tool
   */
  $formview = 'ticket_close';
  $formName = 'ticketForm';
  $actionName = $SCRIPT_NAME;
  $formTitle = 'Close Ticket';
  if( $ticket['tested'] == 1 || $ticket['approved'] == 1 ) {
    $formDesc = "<span class='note'>".tr("Ticket will move to pending status (for testing/approval)")."</span>";
  }
  else {
    $formDesc = "<span class='note'>".tr("Ticket will move to a closed status")."</span>";
  }
  $submitName = 'Close';
  include("$templateDir/ticket_tab_form.php");
?>