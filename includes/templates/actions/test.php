<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form name='testForm' method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<table class='formTable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td colspan='2' class='subTitle'><?=tr("Test Ticket")?>
   &nbsp;&nbsp;
     <?php
   print "<span class='note'>";
   if( $ticket['approved'] == 1 ) {
     print tr("Ticket will be sent for approval");
   }
   else {
     print tr("Ticket status will be changed to closed");
   }
   print "</span>";
   ?>
 </td>
</tr>
<tr>
 <td class="bars">
   <?=$hotkeys->ll("Hours Worked")?>
 </td>
 <td class='bars'>
   <input type="text" name="hours" size="4" maxlength="8" value="<?=$zen->ffv($hours)?>"
    title="<?=$hotkeys->tt("Hours Worked")?>">
  </td>			     
</tr>
<tr>
  <td class="bars">
     <?=$hotkeys->ll("Comments or Instructions")?>
	   <div class="note">(<?=tr("optional")?>)</div>
  </td>
  <td class='bars'>
    <textarea cols="50" rows="4" name="comments" title="<?=$hotkeys->tt("Comments or Instructions")?>"><?=
      $zen->ffvText($comments)?></textarea>
  </td>
</tr>
<tr>
  <td class="subTitle" colspan='2'>
  <?php renderDivButton($hotkeys->find('Testing Complete'), "window.document.testForm.submit()", 150); ?>
  </td>
</tr>
<tr>
</table>

</form>			     
