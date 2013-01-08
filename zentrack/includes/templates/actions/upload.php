<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form name='addAttachmentForm' enctype="multipart/form-data" action="<?=$SCRIPT_NAME?>" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="<?=$zen->getSetting("attachment_max_size")?>">
  <input type="hidden" name="id" value="<?=$id?>">
  <input type="hidden" name="log_id" value="<?=$zen->checkNum($log_id)?>">
  <input type="hidden" name="actionComplete" value="1">
  <input type='hidden' name='setmode' value='<?=$zen->ffv($page_mode)?>'>

<ul>
<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle'>
   <?=uptr("Upload Attachment")?>
 </td>
</tr>
<tr>
 <td class="bars">
   <?=$hotkeys->ll("Select a File to Upload")?>
 </td>
</tr>
<tr>
 <td class='bars'>
   <input type="file" name="userfile" size="40" title="<?=$hotkeys->tt("Select a File to Upload")?>">
 </td>
</tr>
<tr>
  <td class="bars">
     <?=$hotkeys->ll("Description of Attachment")?>
     &nbsp;<span class="small">(<?=tr("optional")?>)</span>
  </td>
</tr>
<tr>
  <td class='bars'>
    <textarea cols="50" rows="4" name="comments"
        title="<?=$hotkeys->tt("Description of Attachment")?>"><?=$zen->ffv($comments)?></textarea>
  </td>
</tr>
<tr>
  <td class="subTitle">
    <? renderDivButtonFind('Add Attachment'); ?>
  </td>
</tr>
<tr>
</table>
</ul>

</form>
