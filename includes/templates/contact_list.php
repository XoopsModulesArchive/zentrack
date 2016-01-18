<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

/* 
*Show the contacts that are connected to a company
*/

$colspan = $overview == 'extern'? 6 : 5;
?>
<table width='600' cellpadding="0" cellspacing="1" class='formtable'>
<tr><td colspan='<?=$colspan?>' class='subTitle'><?=tr("Employees")?></td></tr>
    <?php
if( is_array($contacts) ) {
   $show_list_options = true;
   include("$templateDir/listContacts2Heading.php");
   
   $link  = "$rootUrl/contact.php";
   foreach($contacts as $t) {
     include("$templateDir/listContacts2.php");
   }
   
} else {
  print "<tr><td colspan='$colspan' class='bars'>".tr('No employees found').".</td></tr>";
}
?>
</table>