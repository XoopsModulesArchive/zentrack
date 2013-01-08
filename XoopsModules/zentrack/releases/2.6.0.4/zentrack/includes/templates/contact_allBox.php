<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<table width="100%" cellspacing='1' class='formtable'>
<?
if( $overview == 'company' ) {
  include("$templateDir/listContactsHeading.php");
}
else {
  include("$templateDir/listContacts2Heading.php");
}
//echo $ie;


$sort = $title." asc";
$ie=($overview=="internal")?2:1;
$letter = 'ALL';
  
  if ($overview=="company") {  
		$tickets = $zen->get_contacts("",$tabel,$sort);
  } else {
	  $parms = array(array("inextern", "=", $ie));	
	  $tickets = $zen->get_contacts($parms,$tabel,$sort);
  }
  ?>
    <tr>
     <td class='headerCell' align="center" colspan='5'>
       ALL
     </td>
    </tr>
  <?  
  if( is_array($tickets) && count($tickets) ) {
    $link  = "$rootUrl/contact.php";
    $td_ttl = "title='".tr("Click here to view the Contact")."'";    
	  
   foreach($tickets as $t) {
      if ($overview=="company"){
       include("$templateDir/listContacts.php");
      } else {
       include("$templateDir/listContacts2.php"); 
      }
   }
  } else {
      print "<tr><td class='bars' colspan='5'>".tr('No contacts found')."</td></tr>";
  }

?>
</table>