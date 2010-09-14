<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form name='addAttachmentForm' enctype="multipart/form-data" action="<?php echo $SCRIPT_NAME?>" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $zen->getSetting("attachment_max_size"); ?>">
  <input type="hidden" name="id" value="<?php echo $id?>">
  <input type="hidden" name="log_id" value="<?php echo $zen->checkNum($log_id); ?>">
  <input type="hidden" name="actionComplete" value="1">
  <input type='hidden' name='setmode' value='<?php echo $zen->ffv($page_mode); ?>'>

<ul>
<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle'>
   <?php echo uptr("Upload Attachment"); ?>
 </td>
</tr>
<tr>
 <td class="bars">
   <?php echo $hotkeys->ll("Select a File to Upload"); ?>
 </td>
</tr>
<tr>
 <td class='bars'>
   <input type="file" name="userfile" size="40" title="<?php echo $hotkeys->tt("Select a File to Upload"); ?>">
 </td>
</tr>
<tr>
  <td class="bars">
     <?php echo $hotkeys->ll("Description of Attachment"); ?>
     &nbsp;<span class="small">(<?php echo tr("optional"); ?>)</span>
  </td>
</tr>
<tr>
  <td class='bars'>
    <textarea cols="50" rows="4" name="comments"
        title="<?php echo $hotkeys->tt("Description of Attachment"); ?>"><?php echo $zen->ffv($comments); ?></textarea>
  </td>
</tr>
<tr>
  <td class="subTitle">
    <?php renderDivButtonFind('Add Attachment'); ?>
  </td>
</tr>
<tr>
</table>
</ul>

</form>
