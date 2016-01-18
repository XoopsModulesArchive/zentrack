<?php
  ///////////////////////////////////////////
  // RENDER A COMPANY CONTACT
  ///////////////////////////////////////////
?>
<tr class='bars' onclick='ticketClk("<?=$link?>?cid=<?=$zen->ffv($t['company_id'])?>")' 
  onMouseOver='if(window.document.body && mClassX){mClassX(this, "altBars", "hand");}' 
  onMouseOut='if(window.document.body && mClassX){mClassX(this);}'>
  <td height="25" width="5%" valign="middle" <?=$td_ttl?>>
    <?=$zen->ffv($t["company_id"])?>
  </td>
  <td height="25" width="25%" valign="middle" <?=$td_ttl?>>
    <?=$zen->ffv($t["title"])?>&nbsp;<?=$zen->ffv($t["office"])?>
  </td>
  <td height="25" width="25%" valign="middle" <?=$td_ttl?>>
    <?=$zen->ffv($t["email"])?>
  </td>
  <td height="25" width="15%" valign="middle" <?=$td_ttl?>>
    <?=$zen->ffv($t["telephone"])?>
  </td>
  <td  width="30%" valign="middle" <?=$td_ttl?>>
    <?=$zen->ffv($t["website"])?>
  </td>
</tr>       
