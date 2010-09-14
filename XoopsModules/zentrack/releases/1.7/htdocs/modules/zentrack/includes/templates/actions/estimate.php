<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form method="post" action="<?php echo $SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?php echo $id?>">
<input type="hidden" name="actionComplete" value="1">

<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold"><?php echo uptr("Estimate Ticket Hours"); ?></span>
   <br>
   <span class="small">(<?php echo tr("Set the expected hours this ticket will take to complete"); ?>)</span>
 </td>
</tr>
<tr>
  <td class="titleCell">
    <?php echo tr("Enter the number of hours (can contain up to 2 decimal places)"); ?>
  </td>
<tr>
<tr>
  <td>
    <input type="text" name="hours" value="<?php echo strip_tags($hours); ?>" size="4" maxlength="10">
  </td>
</tr>
<tr>
  <td class="titleCell">
    <?php echo tr("Click button to set estimated hours to completion"); ?>
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" <?php echo uptr("Set"); ?> " class="submit">
  </td>
</tr>
<tr>
</table>

</form>			     
