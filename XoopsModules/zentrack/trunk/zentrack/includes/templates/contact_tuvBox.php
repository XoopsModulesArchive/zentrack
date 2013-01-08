<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell' align="center">
       T    
     </td>
   </tr>  
   <tr>
     <td valign="top">
         <?php
//echo $ie;
if ($overview=="company") {
  $parms = array(array($title, ">", "t"),array($title, "<", "u"));
} else {
  $parms = array(array($title, ">", "t"),array($title, "<", "u"),array("inextern", "=", $ie));	
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

 
<table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell' align="center">
       U    
     </td>
   </tr>  
   <tr>
     <td valign="top">
         <?php
if ($overview=="company") {
  $parms = array(array($title, ">", "u"),array($title, "<", "v"));
} else {
  $parms = array(array($title, ">", "u"),array($title, "<", "v"),array("inextern", "=", $ie));	
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
   
<table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell' align="center">
       V    
     </td>
   </tr>  
   <tr>
     <td valign="top">
         <?php
if ($overview=="company") {
  $parms = array(array($title, ">", "v"),array($title, "<", "w"));
} else {
  $parms = array(array($title, ">", "v"),array($title, "<", "w"),array("inextern", "=", $ie));	
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

