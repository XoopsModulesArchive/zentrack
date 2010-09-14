<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form name='logForm' method="post" action="<?php echo $SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?php echo $id?>">
<input type="hidden" name="actionComplete" value="1">
<input type='hidden' name='setmode' value="<?php echo $zen->ffv($page_mode); ?>">

<table width="600" class='formtable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle'>
   <?php echo tr("Log"); ?>
 </td>
</tr>
<tr>
 <td class="bars">
   <?php echo $hotkeys->ll("Select an Activity"); ?>
 </td>
</tr>
<tr>
 <td class='bars'>
<select name="log_action" title="<?php echo $hotkeys->tt("Select an Activity"); ?>">
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
    <?php echo $hotkeys->ll("Enter Hours Worked"); ?> <span class="small">(<?php echo tr("accepts up to 2 decimal places"); ?>)</span>
  </td>
</tr>
<tr>
  <td>
    <input type="text" name="hours" size="4" maxlength="8"
        title="<?php echo $hotkeys->tt("Enter Hours Worked"); ?>"
        value="<?php echo $zen->ffv($hours); ?>">
  </td>
</tr>
<tr>
  <td class="bars">
     <?php echo $hotkeys->ll("Log Entry / Comments"); ?>
  </td>
</tr>
<tr>
  <td>
    <textarea cols="50" rows="4" name="comments" title="<?php echo $hotkeys->ll("Log Entry / Comments"); ?>"><?php echo 
      $zen->ffvText($comments); ?></textarea>
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
