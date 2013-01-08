<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form name='logForm' method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">
<input type='hidden' name='setmode' value="<?=$zen->ffv($page_mode)?>">

<table width="600" class='formtable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle'>
   <?=tr("Log")?>
 </td>
</tr>
<tr>
 <td class="bars">
   <?=$hotkeys->ll("Select an Activity")?>
 </td>
</tr>
<tr>
 <td class='bars'>
<select name="log_action" title="<?=$hotkeys->tt("Select an Activity")?>">
    <?php
    foreach( $log_actions as $a ) {
       print ($a == $log_action || (!$log_action && $a == 'LOG') )?
	 "<option selected>$a</option>\n" :
         "<option>$a</opton>\n";
    }  
  ?>
</select>
  </td>			     
</tr>
<tr>
  <td class="bars">
    <?=$hotkeys->ll("Enter Hours Worked")?> <span class="small">(<?=tr("accepts up to 2 decimal places")?>)</span>
  </td>
</tr>
<tr>
  <td>
    <input type="text" name="hours" size="4" maxlength="8"
        title="<?=$hotkeys->tt("Enter Hours Worked")?>"
        value="<?=$zen->ffv($hours)?>">
  </td>
</tr>
<tr>
  <td class="bars">
     <?=$hotkeys->ll("Log Entry / Comments")?>
  </td>
</tr>
<tr>
  <td>
    <textarea cols="50" rows="4" name="comments" title="<?=$hotkeys->ll("Log Entry / Comments")?>"><?=
      $zen->ffvText($comments)?></textarea>
  </td>
</tr>
<tr>
  <td class="subTitle">
  <?php renderDivButtonFind("Save Log"); ?>
  </td>
</tr>
<tr>
</table>

</form>			     
