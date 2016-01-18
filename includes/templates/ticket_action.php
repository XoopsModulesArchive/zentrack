<?php if( !ZT_DEFINED ) { die("Illegal Access"); }
  if( $action && file_exists("$templateDir/actions/$action.php") ) { 
     // if there is an action, include the appropriate window
     // so that the user can input the action data and commit
     include("$templateDir/actions/$action.php");
     print "<p>&nbsp;</p>\n";
  }
  else {
    print "<p class='error'>".tr("Invalid action declared")." (".$zen->ffv($action).")</p>\n";
  }
  
?>
