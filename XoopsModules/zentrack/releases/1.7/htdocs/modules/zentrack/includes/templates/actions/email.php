<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>


<script language="javascript">
<!--
  
  function checkAbox(fieldName) {
     fieldName.checked = true;
  }

//-->
</script>

<form method="post" name="emailForm" action="<?php echo $SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?php echo $id?>">
<input type="hidden" name="actionComplete" value="1">

<table width="450" class='formtable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle'><?php echo tr("Email Ticket"); ?>
   &nbsp;&nbsp;<span class='note'>(<?php echo tr("Send ticket to specified recipients"); ?>)</span>
 </td>
</tr>
<tr>
 <td class="bars">
   <input type='radio' name='emethod' value='1' 
   <?php echo (!isset($emethod) || $emethod == 1)? 'CHECKED' : ''?>
   > <?php echo $hotkeys->ll("Select a User"); ?>
 </td>
</tr>
<tr>
 <td class='bars'>
<select name="users_to_email[]" multiple size=4
  title="<?php echo $hotkeys->tt("Select a User"); ?>"
  onFocus="checkAbox(document.emailForm.emethod[0])"
  >
<?php
  $bins = array_keys($zen->getAccess($login_id));
  foreach($zen->get_users($bins) as $v) {
    if( $v["user_id"] != $login_id ) {
      if( is_array($users_to_email) ) {
	 $sel = (in_array($v["user_id"],$users_to_email))? "selected" : "";
      } else {
	 $sel = "";
      }
      print "<option value='$v[user_id]' $sel>".$zen->formatName($v,1)."</option>\n";
    }
  }
?>
</select><span class='small'>(<?php echo tr("hold control or shift to select multiple users"); ?>)</span>
  </td>			     
</tr>
<tr>
 <td class="bars">
   <input type='radio' name='emethod' value='2' <?php echo ($emethod == 2)? 'CHECKED' : ''?>>
   <?php echo $hotkeys->ll("Manually Enter Addresses", "OR manually enter email addresses, seperated by commas"); ?>
 </td>
</tr>
<tr>
 <td class='bars'>
   <input type="text" onFocus="checkAbox(document.emailForm.emethod[1])"
   name="custom_email_addresses" value="<?php echo $zen->ffv($custom_email_addresses); ?>" 
   size="50" maxlength="500" title="<?php echo $hotkeys->tt("Manually Enter Addresses"); ?>">
  </td>			     
</tr>
<tr>
  <td class="bars">
   <?php echo $hotkeys->ll("Comments or Instructions"); ?>
    &nbsp;<span class="small">(<?php echo tr("optional"); ?>)</span>
  </td>
</tr>
<tr>
  <td class='bars'>
    <textarea cols="50" rows="4" name="comments" title="<?php echo $hotkeys->tt('Comments or Instructions'); ?>"><?php echo 
      $zen->ffvText($comments); ?></textarea>
  </td>
</tr>
<tr>
  <td class="bars">
    <?php echo tr("Choose one of the following options"); ?>
  </td>
</tr>
<tr>
  <td class='bars'
   <input type="radio" name="method" value="1" <?php echo ($method == 1)? "checked" : "";?>>
   &nbsp;<?php echo $hotkeys->ll('send option: link', "Send a link to this ticket only"); ?><br>
   <input type="radio" name="method" value="2" <?php echo ($method == 2 || !isset($method))? "checked" : "";?>>
   &nbsp;<?php echo $hotkeys->ll('send option: summary', "Send a summary of the ticket"); ?><br>
   <input type="radio" name="method" value="3" <?php echo ($method == 3)? "checked" : "";?>>
   &nbsp;<?php echo $hotkeys->ll('send option: log', "Send a summary, and the ticket's log"); ?>
  </td>
</tr>
<tr>
  <td class="subTitle">
  <?php renderDivButton($hotkeys->find('Send Email'), "window.document.forms['emailForm'].submit()"); ?>
  </td>
</tr>
<tr>
</table>

</form>			     
