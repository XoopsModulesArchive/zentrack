<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell' align="center">
       G    
     </td>
   </tr>  
   <tr>
     <td valign="top">
         <?php
//echo $ie;
if ($overview=="company") {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "g"),
								2 => array(1 => $title, 2 => "<", 3 => "h"),
);
} else {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "g"),
								2 => array(1 => $title, 2 => "<", 3 => "h"),
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
       H    
     </td>
   </tr>  
   <tr>
     <td valign="top">
         <?php
if ($overview=="company") {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "h"),
								2 => array(1 => $title, 2 => "<", 3 => "i"),
);
} else {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "h"),
								2 => array(1 => $title, 2 => "<", 3 => "i"),
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
       I    
     </td>
   </tr>  
   <tr>
     <td valign="top">
         <?php
if ($overview=="company") {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "i"),
								2 => array(1 => $title, 2 => "<", 3 => "j"),
);
} else {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "i"),
								2 => array(1 => $title, 2 => "<", 3 => "j"),
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

