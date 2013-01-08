<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form method="post" name='rejectForm' action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle' colspan='2'><?=tr("Reject Ticket")?>
   &nbsp;&nbsp;
   <span class="note">(<?=tr("Return ticket to sender")?>)</span>
 </td>
</tr>
<tr>
  <td class="bars">
     <?=$hotkeys->ll("Reason")?> <span class="highlight">(<?=tr("required")?>)</span>
  </td>
  <td class='bars'>
    <textarea cols="50" rows="4" name="comments" title="<?=$hotkeys->tt("Reason")?>"><?=
      $zen->ffvText($comments)?></textarea>
  </td>
</tr>
<tr>
  <td class="subTitle" colspan='2'>
    <? renderDivButton($hotkeys->find("Reject"),"window.document.forms['rejectForm'].submit()"); ?>
  </td>
</tr>
<tr>
</table>

</form>			     
