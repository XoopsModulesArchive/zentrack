<?php
///////////////////////////////////////////
// RENDER A PERSON CONTACT
///////////////////////////////////////////
  if( !isset($show_list_options) ) { $show_list_options = false; }
  $pid = $zen->ffv($t['person_id']);
?>
<tr  class='bars' onclick='ticketClk("<?=$link?>?pid=<?=$pid?>",event)' 
  <?=$row_rollover_eff?>>
  <td valign="middle" <?=$td_ttl?>>
    <?=$zen->ffv($t["person_id"])?>
  </td>
  <td valign="middle" <?=$td_ttl?>>
    <?=$zen->ffv($t["lname"])?>&nbsp;<?=$zen->ffv($t["fname"])?
      ",".$zen->ffv($t["fname"]):",".$zen->ffv($t["initials"])?>
  </td>
  <?if ($overview=="extern") { ?>
    <td valign="middle" <?=$td_ttl?>><?
    if ( isset($t["company_id"])&& $t["company_id"]>"0") {
      $contact = $zen->get_contact($t["company_id"],$zen->table_company,"company_id");
      if( is_array($contact) ) {
        print $zen->ffv($contact['title']);
        if ($contact['title']){
          print $zen->ffv($contact['office']);
        }
      }	  
    }
  }
  ?>
  </td>
  <td valign="middle" <?=$td_ttl?>>
    <?=$t['email']? $zen->ffv($t["email"]) : '&nbsp;'?>
  </td>
  <td width="20%" valign="middle" <?=$td_ttl?>>
    <?=$t['telephone']? $zen->ffv($t["telephone"]) : '&nbsp;'?>
  </td>
  <?php if( $show_list_options ) { ?>
      <td class='bars small' width='50'>
       <a class='pinIcon' href='<?=$rootUrl?>/actions/contact_edit.php?pid=<?=$pid?>'
          title='<?=tr("Edit Employee")?>'><img src='<?=$imageUrl?>/16x16/pin_green.png'
          width='16' height='16' border='0' alt='<?=tr("Edit Employee")?>'></a>
       <a class='pinIcon' href='<?=$rootUrl?>/actions/contact_delete.php?pid=<?=$pid?>'
          onclick='return confirm("<?=tr("Delete this contact?")?>")'
          title='<?=tr("Delete Contact")?>'><img src='<?=$imageUrl?>/16x16/pin_red.png'
          width='16' height='16' border='0' alt='<?=tr("Delete Contact")?>'></a>
      </td>    
  <?php } ?>
</tr>
