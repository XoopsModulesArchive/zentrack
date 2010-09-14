<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form method="post" name='rejectForm' action="<?php echo $SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?php echo $id?>">
<input type="hidden" name="actionComplete" value="1">

<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle' colspan='2'><?php echo tr("Reject Ticket"); ?>
   &nbsp;&nbsp;
   <span class="note">(<?php echo tr("Return ticket to sender"); ?>)</span>
 </td>
</tr>
<tr>
  <td class="bars">
     <?php echo $hotkeys->ll("Reason"); ?> <span class="highlight">(<?php echo tr("required"); ?>)</span>
  </td>
  <td class='bars'>
    <textarea cols="50" rows="4" name="comments" title="<?php echo $hotkeys->tt("Reason"); ?>"><?php echo 
      $zen->ffvText($comments); ?></textarea>
  </td>
</tr>
<tr>
  <td class="subTitle" colspan='2'>
    <?php renderDivButton($hotkeys->find("Reject"),"window.document.forms['rejectForm'].submit()"); ?>
  </td>
</tr>
<tr>
</table>

</form>			     
