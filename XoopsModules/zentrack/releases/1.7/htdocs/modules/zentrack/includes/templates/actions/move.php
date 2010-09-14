<?php if( !ZT_DEFINED ) { die("Illegal Access"); } 
  $hotkeys->loadSection('move');
  $GLOBALS['zt_hotkeys'] = $hotkeys;
?>

<form method="post" name='moveForm' action="<?php echo $SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?php echo $id?>">
<input type="hidden" name="actionComplete" value="1">

<table width="450" cellpadding="4" cellspacing="1" border="0" class='formTable'>
<tr>
 <td class='subTitle' colspan='2'><?php echo uptr("Move Ticket"); ?>
 &nbsp;&nbsp;<span class='note'>(<?php echo tr("Send ticket to another bin"); ?>)</span>
 </td>
</tr>
<tr>
  <td class="bars">
     <?php echo $hotkeys->ll("New Bin"); ?>
  </td>
  <td class='bars'>
    <select name='newBin' title='<?php echo $hotkeys->tt("New Bin"); ?>'>
     <?php
      $userBins = $zen->getUsersBins($login_id,"level_move");
      if( is_array($userBins) ) {
        foreach($userBins as $v) {
          $n = $zen->getBinName("$v");
          print "<option value='$v'>$n</option>\n";
        }
      } else {
        print "<option value=''>--".tr("none")."--<option>\n";
      }
     ?>
    </select>
  </td>
</tr>
<tr>
  <td class="bars">
     <?php echo $hotkeys->ll("Comments"); ?> <span class="small">(<?php echo tr("optional"); ?>)</span>
  </td>
  <td class='bars' title='<?php echo $hotkeys->tt('Comments'); ?>'>
    <textarea cols="50" rows="4" name="comments"><?php echo 
      $zen->ffvText($comments); ?></textarea>
  </td>
</tr>
<tr>
  <td class="subTitle" colspan='2'>
    <?php renderDivButtonFind('Move'); ?>
  </td>
</tr>
<tr>
</table>

</form>			     
