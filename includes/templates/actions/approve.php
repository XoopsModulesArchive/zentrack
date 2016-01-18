<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form name='approveForm' method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<table class='formTable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td colspan='2' class='subTitle'><?=tr("Approve Ticket")?>
   &nbsp;&nbsp;
   <span class='note'><?=tr("Approve ticket and close")?></span>
 </td>
</tr>
<tr>
  <td class="bars">
     <?=$hotkeys->ll("Comments")?>
	   <div class="note">(<?=tr("optional")?>)</div>
  </td>
  <td class='bars'>
    <textarea cols="50" rows="4" name="comments" title="<?=$hotkeys->tt("Comments or Instructions")?>"><?=
      $zen->ffvText($comments)?></textarea>
  </td>
</tr>
<tr>
  <td class="subTitle" colspan='2'>
  <?php renderDivButton($hotkeys->find('Approve'), "window.document.approveForm.submit()", 150); ?>
  </td>
</tr>
<tr>
</table>

</form>			     
