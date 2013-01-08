<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell' align="center">
       OTHERS    
     </td>
   </tr>  
   <tr>
     <td valign="top">
         <?php
//echo $ie;
if ($overview=="company") {
  $parms = array(array($title, "<", "a"));
} else {
  $parms = array(array($title, "<", "a"),array("inextern", "=", $ie));	
}

$sort = $title." asc";
      
	$tickets = $zen->get_contacts($parms,$tabel,$sort);
  if( is_array($tickets) && count($tickets) ) {
    if ($overview == "company") {
     include("$templateDir/listContacts.php");
   } else {
	   include("$templateDir/listContacts2.php"); 
   }
  } else {
     print tr("No contacts in this section.");
  }
  $tickets = NULL;
?>
     </td>
   </tr>
</table>

<br>  

