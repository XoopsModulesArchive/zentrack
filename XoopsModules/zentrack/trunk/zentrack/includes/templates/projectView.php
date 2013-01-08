<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  /*
  **  PROJECT VIEW
  **
  **  Framework for the project viewing screen
  **  Includes ticket_actionBar (the buttons)
  **  ticket_titleBox (the important details)
  **  and ticket_box (which is the tabbed section below the buttons)
  */
  
  $page_type = 'project';
  include("$templateDir/ticketView.php");
?>