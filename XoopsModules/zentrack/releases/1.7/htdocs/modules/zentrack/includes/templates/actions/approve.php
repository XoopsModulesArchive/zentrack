<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form name='approveForm' method="post" action="<?php echo $SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?php echo $id?>">
<input type="hidden" name="actionComplete" value="1">

<table class='formTable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td colspan='2' class='subTitle'><?php echo tr("Approve Ticket"); ?>
   &nbsp;&nbsp;
   <span class='note'><?php echo tr("Approve ticket and close"); ?></span>
 </td>
</tr>
<tr>
  <td class="bars">
     <?php echo $hotkeys->ll("Comments"); ?>
	   <div class="note">(<?php echo tr("optional"); ?>)</div>
  </td>
  <td class='bars'>
    <textarea cols="50" rows="4" name="comments" title="<?php echo $hotkeys->tt("Comments or Instructions"); ?>"><?php echo 
      $zen->ffvText($comments); ?></textarea>
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
