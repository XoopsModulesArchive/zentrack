<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
     <td class='titleCell' align="center">
       P    
     </td>
   </tr>  
   <tr>
     <td valign="top">
<?
//echo $ie;
if ($overview=="company") {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "p"),
								2 => array(1 => $title, 2 => "<", 3 => "q"),
);
} else {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "p"),
								2 => array(1 => $title, 2 => "<", 3 => "q"),
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
       Q    
     </td>
   </tr>  
   <tr>
     <td valign="top">
<?
if ($overview=="company") {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "q"),
								2 => array(1 => $title, 2 => "<", 3 => "r"),
);
} else {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "q"),
								2 => array(1 => $title, 2 => "<", 3 => "r"),
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
       R    
     </td>
   </tr>  
   <tr>
     <td valign="top">
<?
if ($overview=="company") {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "r"),
								2 => array(1 => $title, 2 => "<", 3 => "s"),
);
} else {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "r"),
								2 => array(1 => $title, 2 => "<", 3 => "s"),
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
       S    
     </td>
   </tr>  
   <tr>
     <td valign="top">
<?
if ($overview=="company") {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "s"),
								2 => array(1 => $title, 2 => "<", 3 => "t"),
);
} else {
$parms = array(1 => array(1 => $title, 2 => ">", 3 => "s"),
								2 => array(1 => $title, 2 => "<", 3 => "t"),
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
