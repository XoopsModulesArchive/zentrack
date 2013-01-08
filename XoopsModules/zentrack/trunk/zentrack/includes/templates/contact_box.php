<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<table width="100%" cellspacing='1' class='formtable'>
    <?php
if( $overview == 'company' ) {
  include("$templateDir/listContactsHeading.php");
}
else {
  include("$templateDir/listContacts2Heading.php");
}

  /*
  ** DETERMINE WHICH SCREEN TO SHOW AND SHOW IT
  */
  for($i=0; $i<strlen($page_mode); $i++) {
    $l = substr($page_mode,$i,1);
    $letter = strtoupper($l);
    $n = strpos($letters,$l)+1;
    if( $page_mode == '!19' ) {
      $parms = array(array($title, "<", "a"));
    }
    else {
      $parms = array();
      $parms[] = array($title, ">=", $l);
      if( $n < strlen($letters) ) {
        $parms[] = array($title, "<", $letters{$n});
      }
    }
    $sort = $title." asc";
    if( $overview != 'company' ) {
      $parms[] = array("inextern", "=", $ie);
    }
    $tickets = $zen->get_contacts($parms,$tabel,$sort);
    ?>
      <tr>
       <td class='headerCell' align="center" colspan='5'>
         <?=$letter?>
       </td>
      </tr>
      <?php
    if( is_array($tickets) ) {
      $link  = "$rootUrl/contact.php";
      $td_ttl = "title='".tr("Click here to view the Contact")."'";

     foreach($tickets as $t) {
       if( $overview == 'company' ) {
         include("$templateDir/listContacts.php");
       }
       else {
         include("$templateDir/listContacts2.php");
       }
     }
    } else {
      print "<tr><td class='bars note' colspan='5'>".tr('No contacts for section ?', $letter)."</td></tr>";
    }
  }

?>
</table>