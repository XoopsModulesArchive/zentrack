<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  
  if( $action ) {   
     
     if( $actionComplete == 1 ) {
       print_system_messages(1);
     }

     // if there is an action, include the appropriate window
     // so that the user can input the action data and commit

     if( file_exists("$templateDir/actions/$action.php") ) {
       include("$templateDir/actions/$action.php");
     }
     else {
       print "<p class='error'>".tr("Invalid action declared")." (".$zen->ffv($action).")</p>\n";
     }
  
     print "<p>&nbsp;</p>\n";
  } else {
     
?>
       
  <table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>
    <td class='titleCell' align='center'><?=tr("System History")?></td>
   </tr>
   <tr>  
    <td height="250" valign="top">
      <?php print_system_messages(); ?>
    </td>
   </tr>  
   </table>

<?php } ?>
