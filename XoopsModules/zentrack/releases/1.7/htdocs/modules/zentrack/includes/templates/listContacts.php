<?php
  ///////////////////////////////////////////
  // RENDER A COMPANY CONTACT
  ///////////////////////////////////////////
?>
<tr class='bars' onclick='ticketClk("<?php echo $link?>?cid=<?php echo $zen->ffv($t['company_id']); ?>")' 
  onMouseOver='if(window.document.body && mClassX){mClassX(this, "altBars", "hand");}' 
  onMouseOut='if(window.document.body && mClassX){mClassX(this);}'>
  <td height="25" width="5%" valign="middle" <?php echo $td_ttl?>>
    <?php echo $zen->ffv($t["company_id"]); ?>
  </td>
  <td height="25" width="25%" valign="middle" <?php echo $td_ttl?>>
    <?php echo $zen->ffv($t["title"]); ?>&nbsp;<?php echo $zen->ffv($t["office"]); ?>
  </td>
  <td height="25" width="25%" valign="middle" <?php echo $td_ttl?>>
    <?php echo $zen->ffv($t["email"]); ?>
  </td>
  <td height="25" width="15%" valign="middle" <?php echo $td_ttl?>>
    <?php echo $zen->ffv($t["telephone"]); ?>
  </td>
  <td  width="30%" valign="middle" <?php echo $td_ttl?>>
    <?php echo $zen->ffv($t["website"]); ?>
  </td>
</tr>       
