<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell' align="center">
       D    
     </td>
   </tr>  
   <tr>
     <td valign="top">
         <?php
//echo $ie;
if ($overview=="company") {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "d"),
								2 => array(1 => $title, 2 => "<", 3 => "e"),
);
} else {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "d"),
								2 => array(1 => $title, 2 => "<", 3 => "e"),
									3 => array(1 => "inextern", 2 => "=", 3 => $ie)
);	
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
       E    
     </td>
   </tr>  
   <tr>
     <td valign="top">
         <?php
if ($overview=="company") {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "e"),
								2 => array(1 => $title, 2 => "<", 3 => "f"),
);
} else {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "e"),
								2 => array(1 => $title, 2 => "<", 3 => "f"),
									3 => array(1 => "inextern", 2 => "=", 3 => $ie)
);	
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
       F    
     </td>
   </tr>  
   <tr>
     <td valign="top">
         <?php
if ($overview=="company") {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "f"),
								2 => array(1 => $title, 2 => "<", 3 => "g"),
);
} else {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "f"),
								2 => array(1 => $title, 2 => "<", 3 => "g"),
									3 => array(1 => "inextern", 2 => "=", 3 => $ie)
);	
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

