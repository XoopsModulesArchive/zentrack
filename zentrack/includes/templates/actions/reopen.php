<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form name='reopenForm' method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<table class='formTable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td colspan='2' class='subTitle'><?=tr("Reopen Ticket")?>
   &nbsp;&nbsp;
   <span class="note">(<?=tr("Reopen ticket to continue work")?>)</span>
 </td>
</tr>
<tr>
  <td class="bars">
     <?=$hotkeys->ll("Comments or Instructions")?>
	   <br><span class="note">(<?=tr("required")?>)</span>
  </td>
  <td class='bars'>
    <textarea cols="50" rows="4" name="comments" title="<?=$hotkeys->tt("Comments or Instructions")?>"><?=
      $zen->ffvText($comments)?></textarea>
  </td>
</tr>
<tr>
  <td class="subTitle" colspan='2'>
     <?php renderDivButton($hotkeys->find('Reopen'), "window.document.forms['reopenForm'].submit()"); ?>
  </td>
</tr>
<tr>
</table>

</form>			     
