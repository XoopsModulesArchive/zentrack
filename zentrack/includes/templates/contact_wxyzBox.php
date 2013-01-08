<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell' align="center">
       W    
     </td>
   </tr>  
   <tr>
     <td valign="top">
         <?php
//echo $ie;
if ($overview=="company") {
  $parms = array(array($title, ">", "w"),array($title, "<", "x"));
} else {
  $parms = array(array($title, ">", "w"),array($title, "<", "x"),array("inextern", "=", $ie));	
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
       X    
     </td>
   </tr>  
   <tr>
     <td valign="top">
         <?php
if ($overview=="company") {
  $parms = array(array($title, ">", "x"),array($title, "<", "y"));
} else {
  $parms = array(array($title, ">", "x"),array($title, "<", "y"),array("inextern", "=", $ie));
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
       Y    
     </td>
   </tr>  
   <tr>
     <td valign="top">
         <?php
if ($overview=="company") {
  $parms = array(array($title, ">", "y"),array($title, "<", "z"));
} else {
  $parms = array(array($title, ">", "y"),array($title, "<", "z"),array("inextern", "=", $ie));	
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
       Z    
     </td>
   </tr>  
   <tr>
     <td valign="top">
         <?php
if ($overview=="company") {
  $parms = array(array($title, ">", "z"));
} else {
  $parms = array(array($title, ">", "z"), array("inextern", "=", $ie));	
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
