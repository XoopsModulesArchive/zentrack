<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form name='pullForm' method="post" action="<?php echo $SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?php echo $id?>">
<input type="hidden" name="actionComplete" value="1">

<table cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle' colspan='2'><?php echo uptr("Pull Ticket"); ?>
   &nbsp;&nbsp;
   <span class="note">(<?php echo tr("Take ticket from the current owner"); ?>)</span>
 </td>
</tr>
<tr>
  <td class="bars">
     <?php echo $hotkeys->ll("Reason"); ?><div class="note">(<?php echo tr("optional"); ?>)</div>
  </td>
  <td>
    <textarea cols="50" rows="4" name="comments"><?php echo 
      $zen->ffvText($comments); ?></textarea>
  </td>
</tr>
<tr>
  <td class="subTitle" colspan='2'>
   <?php renderDivButton($hotkeys->find('Pull'),'window.document.pullForm.submit()'); ?>
  </td>
</tr>
<tr>
</table>

</form>			     
