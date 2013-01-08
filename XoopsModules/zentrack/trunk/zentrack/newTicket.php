<?
  /*
  **  NEW TICKET
  **  
  **  Create a new ticket
  **
  */
  
  define("ZT_SECTION","tickets");
  include("header.php");


  //
  // JSCALENDAR ADDON START
  //
	/*echo '<style type="text/css">@import url(jscalendar/calendar-win2k-cold-2.css);</style>
		<script type="text/javascript" src="jscalendar/calendar.js"></script>
		<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
		<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>';*/
  //
  // JSCALENDAR ADDON START
  //  
  
  $page_title = tr("Create a New Ticket");
  $expand_tickets = 1;
  $onLoad[] = "behavior_js.php?formset=ticketForm&mode=create";

  include("$libDir/nav.php");

  $view = "ticket_create";
  include("$templateDir/newTicketForm.php");

  include("$libDir/footer.php");
?>
