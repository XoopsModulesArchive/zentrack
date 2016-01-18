<?php if( !ZT_DEFINED ) { die("Illegal Access"); }
  include_once("$libDir/sorting.php");
  $parms = array('project_id'=>$id, 'bin_id'=>$zen->getUsersBins($login_id));
  $tickets = $zen->get_tickets($parms,$sortstring);
  $total_children = $zen->total_records;
  $hotkeys->loadSection('project_tasks');
  $GLOBALS['zt_hotkeys'] = $hotkeys;

  if( is_array($tickets) && count($tickets) > 0) {
    $master_view = $view;
    $view = 'project_tasks';
    include("$templateDir/listTickets.php");
    $view = $master_view;
  } else {
     print tr("No tickets have been added to this Project.");
  }
?>
  <table width="100%" cellpadding="2" cellspacing="2">
  <tr>
     <td width='100%'>&nbsp;</td>
     <td align="right">
     <form style='display:inline' name='newTicketHotkey' action="<?=$rootUrl?>/newTicket.php">
     <input type="hidden" name="project_id" value="<?=$zen->checkNum($id)?>">
     <?php renderDivButtonFind('Add Ticket to Project', 150); ?>
     </form>
     </td>
     <td align='left'>
     <form style='display:inline' name='newProjectHotkey' action="<?=$rootUrl?>/newProject.php">
     <input type="hidden" name="project_id" value="<?=$zen->checkNum($id)?>">
     <?php renderDivButtonFind('Create Sub-Project', 150); ?>
     </form>
     </td>
   </tr>    
   </table>





