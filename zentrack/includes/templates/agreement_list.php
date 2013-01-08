<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

/* 
*Show the contacts that are connected to a company
*/
$img = null;
$agree_id = $zen->ffv($agree_id);
?>
  <table width='600' cellpadding="0" cellspacing="1" border="0" class='formtable'>
  <tr><td class='subTitle' colspan='6'><?=tr("Agreements")?></td></tr>
      <?php
if( is_array($contacts) ) {
?>
<tr>
<td class='headerCell' title="<?=tr("ID of the agreement")?>">
<?=tr("ID") . $img ?>
</td>
<td class='headerCell' title="<?=tr("The nr of the agreement")?>">
<?=tr("Nr") . $img ?>
</td>
<td class='headerCell' title="<?=tr("The title of the agreement")?>">
<?=tr("Title") . $img ?>
</td>
<td class='headerCell' title="<?=tr("The company of the agreement")?>">
<?=tr("Company") . $img ?>
</td>
<td class='headerCell' title="<?=tr("The expiration date of the agreement")?>">
<?=tr("Expires") . $img ?>
</td>
<td class='headerCell'><?=tr("Options")?></td>
</tr>
<?php
  $link  = "$rootUrl/agreement.php";
   	
  foreach($contacts as $t) {
    $aid = $zen->ffv($t['agree_id']);
    $td_ttl = "title='".tr("Click here to view the Agreement")."' "
             ."onclick='ticketClk(\"$link?id={$t['agree_id']}\",this.event)'";
    ?>
    <tr class='bars' <?=$row_rollover_eff?>>
      <td <?=$td_ttl?>>
        <?=$aid?>
      </td>
      <td <?=$td_ttl?>>
        <?=$zen->ffv($t["contractnr"])?>
      </td>
      <td <?=$td_ttl?>>
        <?=$zen->ffv($t["title"])?>
      </td>
      <td <?=$td_ttl?>><?
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
      <td <?=$td_ttl?>>
        <?=($t["dtime"])?$zen->showDate($t["dtime"]):"n/a";?>
      </td>
      <td class='bars small' width='60'>
       <a class='pinIcon' href='<?=$rootUrl?>/actions/agreement_edit.php?id=<?=$aid?>'
          title='<?=tr("Edit Agreement")?>'><img src='<?=$imageUrl?>/16x16/pin_green.png'
          width='16' height='16' border='0' alt='<?=tr("Edit Agreement")?>'></a>
       <a class='pinIcon' href='<?=$rootUrl?>/actions/agreement_archive.php?id=<?=$aid?>&active=<?=$t['status']? 0:1?>'
          onclick='return confirm("<?=tr("Archive this agreement?")?>")'
          title='<?=tr("Archive Agreement")?>'><img src='<?=$imageUrl?>/16x16/pin_yellow.png'
          width='16' height='16' border='0' alt='<?=tr("Archive Agreement")?>'></a>
       <a class='pinIcon' href='<?=$rootUrl?>/actions/agreement_delete.php?id=<?=$aid?>'
          onclick='return confirm("<?=tr("Delete this agreement?")?>")'
          title='<?=tr("Delete Agreement")?>'><img src='<?=$imageUrl?>/16x16/pin_red.png'
          width='16' height='16' border='0' alt='<?=tr("Delete Agreement")?>'></a>
      </td>
    </tr>       
  <?php
  }
} else {
    print "<tr><td class='bars' colspan='6'>".tr('No agreements found')."</td></tr>";
} 
?>
</table>