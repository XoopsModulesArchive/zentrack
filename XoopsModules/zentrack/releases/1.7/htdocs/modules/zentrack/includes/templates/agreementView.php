<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
	<?php
	$sort = "dtime asc";
	$parms = array(array("status", "=", "1"));
	$tickets = $zen->get_contacts($parms,$zen->table_agreement,$sort);
	$img = $image? 
    "&nbsp;<IMG SRC='$imageUrl/".$zen->ffv($image)."' border='0'>" : '';
	
if( is_array($tickets) && count($tickets) ) {
 
   ?>
<table width="100%" cellspacing='1' cellpadding='2' class='formtable'>
<tr><td class='subTitle' align='center' colspan='5'><?php echo tr("Agreements"); ?></td></tr>
<tr>
<td class='headerCell' title="<?php echo tr("ID of the agreement"); ?>">
<?php echo tr("ID") . $img ?>
</td>

<td class='headerCell' title="<?php echo tr("The nr of the agreement"); ?>">
<?php echo tr("Nr") . $img ?>
</td>

<td class='headerCell' title="<?php echo tr("The title of the agreement"); ?>">
<?php echo tr("Title") . $img ?>
</td>

<td class='headerCell' title="<?php echo tr("The company of the agreement"); ?>">
<?php echo tr("Company") . $img ?>
</td>

<td class='headerCell' title="<?php echo tr("The expiration date of the agreement"); ?>">
<?php echo tr("Expires") . $img ?>
</td>

</tr>
<?php      
$link  = "$rootUrl/agreement.php";
$td_ttl = "title='".tr("Click here to view the Agreement")."'";
   	
   foreach($tickets as $t) {    

      ?>
   <tr  class='bars' onclick='ticketClk("<?php echo $link?>?id=<?php echo $t["agree_id"]?>")' 
      <?php echo $row_rollover_eff?>>
   <td height="25" width="5%" valign="middle" <?php echo $td_ttl?>>
    <?php echo $zen->ffv($t["agree_id"]); ?>
   </td>
   <td height="25" width="25%" valign="middle" <?php echo $td_ttl?>>
    <?php echo $zen->ffv($t["contractnr"]); ?>
   </td>
   <td height="25" width="35%" valign="middle" <?php echo $td_ttl?>>
   <?php echo $zen->ffv($t["title"]); ?>
   </td>
      <td height="25" width="25%" valign="middle" <?php echo $td_ttl?>><?php
      if ( !empty($t["company_id"])) {
        $contact = $zen->get_contact($t["company_id"],$zen->table_company,"company_id");
        if( is_array($contact) ) {
          echo strtoupper($contact['title']);
          if($contact['title']){
            print " " .$zen->ffv($contact['office']);
          }
        }	  
      }
   ?>
   </td>
   <td width="20%" valign="middle" <?php echo $td_ttl?>>
   <?php echo ($t["dtime"])?$zen->showDate($t["dtime"]):"n/a";?>
   </td>
   </tr>       
   <?php
   } 
  
?>
</table>
<?php
}
else {
  print "&nbsp;<blockquote>There are no agreements to view.</blockquote>\n";
}
?>