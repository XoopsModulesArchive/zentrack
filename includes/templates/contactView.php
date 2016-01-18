<?php if( !ZT_DEFINED ) { die("Illegal Access"); }

  /*
  **  CONTACT VIEW
  **
  **  Framework for the contact viewing screen
  **  Includes contact_buttonBox (the buttons)
  **  contact_box (the tabs)
  */
?>
 
<table width="100%" class='barborder' cellspacing="0" cellpadding='0'>
 <tr><td class='subTitle' align='center'>Contacts<?=$overview? " (".$zen->ffv(tr($overview)).")" : ''?></td></tr>
  <tr>
    <td class='indent padded' valign="top" align='center'><?php include("$templateDir/contact_buttonBox.php"); ?></td>
  </tr>
<tr>
<td class='tbar indent tabpad lip'>
    <?php
  /*
  ** SHOW THE NAVIGATION TABS
  */
  
  print "<table cellpadding='0' cellspacing='0'><tr>\n";
  print "<td width='3'><img src='$rootUrl/images/empty.gif' width='3' height='1'></td>\n";
  
   $tabs = array(
      "all",
      "abc",
      "def",
      "ghi",     
      "jkl",
			"mno",
			"pqrs",
			"tuv",
 			"wxyz",
			"!19" 
      );
      
   $letters ="abcdefghijklmnopqrstuvwxyz";
  
  // set the page mode, for viewing tickets
  if( $setmode && in_array($setmode, $tabs) || $setmode == 'all' ) {    
    $page_mode = strtolower($setmode); 
 	} else {
	  $page_mode = "abc";	
 	}

  $i = 1;   
  foreach( $tabs as $t ) {
    $lt = strtolower($t);
    if( $page_mode == $lt ) {
      $class = 'class="tab on"';
      $lclass = "tabsOn";
    } else {
      $class = "class='tab off' $nav_rollover_text";
      $lclass = 'tabsOff';
    }
    
    $ttl = $hotkeys->tt($t);
    $label = $hotkeys->ll($t);
    print "<td $class height='16' width='60' align='center' title='$ttl'>";
    print "<a href='$rootUrl/contacts.php?setmode=$t&overview=$overview&ie=$ie' class='$lclass'>$label</a>";
    print "</td>\n";
    if( $i < count($tabs) ) {
      print "<td width='3'><img src='$rootUrl/images/empty.gif' width='3' height='1'></td>\n";
    }
     $i++;
  }
  print "<td width='3'><img src='$rootUrl/images/empty.gif' width='3' height='1'></td>\n";
?>
</tr></table>
</td>
</tr>
  <tr>
    <td valign="top" class='indent boxpad bottom'>
        <?php
  		if ($setmode==all) {
	  		include("$templateDir/contact_allBox.php");
  		} else {
	  		include("$templateDir/contact_box.php");
  		}
  	 ?>
    </td>
  </tr>
</table>
