<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

/* 
*Show the contacts that are connected to a company
*/
$img = null;
$agree_id = $zen->ffv($agree_id);
?>
  <table width='600' cellpadding="0" cellspacing="1" border="0" class='formtable'>
  <tr><td class='subTitle' colspan='6'><?php echo tr("Agreements"); ?></td></tr>
<?php
if( is_array($contacts) ) {
?>
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
<td class='headerCell'><?php echo tr("Options"); ?></td>
</tr>
<?php      
  $link  = "$rootUrl/agreement.php";
   	
  foreach($contacts as $t) {
    $aid = $zen->ffv($t['agree_id']);
    $td_ttl = "title='".tr("Click here to view the Agreement")."' "
             ."onclick='ticketClk(\"$link?id={$t['agree_id']}\",this.event)'";
    ?>
    <tr class='bars' <?php echo $row_rollover_eff?>>
      <td <?php echo $td_ttl?>>
        <?php echo $aid?>
      </td>
      <td <?php echo $td_ttl?>>
        <?php echo $zen->ffv($t["contractnr"]); ?>
      </td>
      <td <?php echo $td_ttl?>>
        <?php echo $zen->ffv($t["title"]); ?>
      </td>
      <td <?php echo $td_ttl?>><?php
        if ( !empty($t["company_id"])) {
          $contact = $zen->get_contact($t["company_id"],$zen->table_company,"company_id");
          if( is_array($contact) ) {
            print $zen->ffv($contact['title']);
            if($contact['title']){
              print " " .$zen->ffv($contact['office']);
            }
          }	  
        }
      ?>
      </td>
      <td <?php echo $td_ttl?>>
        <?php echo ($t["dtime"])?$zen->showDate($t["dtime"]):"n/a";?>
      </td>
      <td class='bars small' width='60'>
       <a class='pinIcon' href='<?php echo $rootUrl?>/actions/agreement_edit.php?id=<?php echo $aid?>'
          title='<?php echo tr("Edit Agreement"); ?>'><img src='<?php echo $imageUrl?>/16x16/pin_green.png'
          width='16' height='16' border='0' alt='<?php echo tr("Edit Agreement"); ?>'></a>
       <a class='pinIcon' href='<?php echo $rootUrl?>/actions/agreement_archive.php?id=<?php echo $aid?>&active=<?php echo $t['status']? 0:1?>'
          onclick='return confirm("<?php echo tr("Archive this agreement?"); ?>")'
          title='<?php echo tr("Archive Agreement"); ?>'><img src='<?php echo $imageUrl?>/16x16/pin_yellow.png'
          width='16' height='16' border='0' alt='<?php echo tr("Archive Agreement"); ?>'></a>
       <a class='pinIcon' href='<?php echo $rootUrl?>/actions/agreement_delete.php?id=<?php echo $aid?>'
          onclick='return confirm("<?php echo tr("Delete this agreement?"); ?>")'
          title='<?php echo tr("Delete Agreement"); ?>'><img src='<?php echo $imageUrl?>/16x16/pin_red.png'
          width='16' height='16' border='0' alt='<?php echo tr("Delete Agreement"); ?>'></a>
      </td>
    </tr>       
    <?php
  }
} else {
    print "<tr><td class='bars' colspan='6'>".tr('No agreements found')."</td></tr>";
} 
?>
</table>