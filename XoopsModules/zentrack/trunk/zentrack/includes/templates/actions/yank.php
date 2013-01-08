<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form name='pullForm' method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<table cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle' colspan='2'><?=uptr("Pull Ticket")?>
   &nbsp;&nbsp;
   <span class="note">(<?=tr("Take ticket from the current owner")?>)</span>
 </td>
</tr>
<tr>
  <td class="bars">
     <?=$hotkeys->ll("Reason")?><div class="note">(<?=tr("optional")?>)</div>
  </td>
  <td>
    <textarea cols="50" rows="4" name="comments"><?=
      $zen->ffvText($comments)?></textarea>
  </td>
</tr>
<tr>
  <td class="subTitle" colspan='2'>
   <? renderDivButton($hotkeys->find('Pull'),'window.document.pullForm.submit()'); ?>
  </td>
</tr>
<tr>
</table>

</form>			     
