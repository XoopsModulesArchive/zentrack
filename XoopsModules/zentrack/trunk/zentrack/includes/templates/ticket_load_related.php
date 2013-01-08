<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <table width="600" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='subTitle'>
       <?=tr("Related ?",tr($page_type."s"))?>    
     </td>
   </tr>  
   <tr>
     <td valign="top">
         <?php
  $tickets = false;
  if( $page_type == "ticket" ) {
    $view='ticket_list';
    $ticket = $zen->get_ticket($id);
  } else {
    $view='project_list';
    $ticket = $zen->get_project($id);
  }
  if( $ticket["relations"] ) {
     $tids = explode(",", $ticket["relations"]);
     $tickets = $zen->get_tickets( array("id"=>$tids) );
  }
  $fields=$map->getFieldMap($view);
  if( is_array($tickets) && count($tickets) ) {
     include("$templateDir/listTickets.php");
  } else {
     print tr("No related ?", tr($page_type."s"));
  }
?>
     </td>
   </tr>
   </table>

