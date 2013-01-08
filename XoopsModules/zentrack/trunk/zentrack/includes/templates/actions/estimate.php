<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold"><?=uptr("Estimate Ticket Hours")?></span>
   <br>
   <span class="small">(<?=tr("Set the expected hours this ticket will take to complete")?>)</span>
 </td>
</tr>
<tr>
  <td class="titleCell">
    <?=tr("Enter the number of hours (can contain up to 2 decimal places)")?>
  </td>
<tr>
<tr>
  <td>
    <input type="text" name="hours" value="<?=strip_tags($hours)?>" size="4" maxlength="10">
  </td>
</tr>
<tr>
  <td class="titleCell">
    <?=tr("Click button to set estimated hours to completion")?>
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" <?=uptr("Set")?> " class="submit">
  </td>
</tr>
<tr>
</table>

</form>			     
