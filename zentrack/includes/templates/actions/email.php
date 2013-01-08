<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>


<script language="javascript">
<!--
  
  function checkAbox(fieldName) {
     fieldName.checked = true;
  }

//-->
</script>

<form method="post" name="emailForm" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<table width="450" class='formtable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle'><?=tr("Email Ticket")?>
   &nbsp;&nbsp;<span class='note'>(<?=tr("Send ticket to specified recipients")?>)</span>
 </td>
</tr>
<tr>
 <td class="bars">
   <input type='radio' name='emethod' value='1' 
   <?=(!isset($emethod) || $emethod == 1)? 'CHECKED' : ''?>
   > <?=$hotkeys->ll("Select a User")?>
 </td>
</tr>
<tr>
 <td class='bars'>
<select name="users_to_email[]" multiple size=4
  title="<?=$hotkeys->tt("Select a User")?>"
  onFocus="checkAbox(document.emailForm.emethod[0])"
  >
<?
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
</select><span class='small'>(<?=tr("hold control or shift to select multiple users")?>)</span>
  </td>			     
</tr>
<tr>
 <td class="bars">
   <input type='radio' name='emethod' value='2' <?=($emethod == 2)? 'CHECKED' : ''?>>
   <?=$hotkeys->ll("Manually Enter Addresses", "OR manually enter email addresses, seperated by commas")?>
 </td>
</tr>
<tr>
 <td class='bars'>
   <input type="text" onFocus="checkAbox(document.emailForm.emethod[1])"
   name="custom_email_addresses" value="<?=$zen->ffv($custom_email_addresses)?>" 
   size="50" maxlength="500" title="<?=$hotkeys->tt("Manually Enter Addresses")?>">
  </td>			     
</tr>
<tr>
  <td class="bars">
   <?=$hotkeys->ll("Comments or Instructions")?>
    &nbsp;<span class="small">(<?=tr("optional")?>)</span>
  </td>
</tr>
<tr>
  <td class='bars'>
    <textarea cols="50" rows="4" name="comments" title="<?=$hotkeys->tt('Comments or Instructions')?>"><?=
      $zen->ffvText($comments)?></textarea>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Choose one of the following options")?>
  </td>
</tr>
<tr>
  <td class='bars'
   <input type="radio" name="method" value="1" <?=($method == 1)? "checked" : "";?>>
   &nbsp;<?=$hotkeys->ll('send option: link', "Send a link to this ticket only")?><br>
   <input type="radio" name="method" value="2" <?=($method == 2 || !isset($method))? "checked" : "";?>>
   &nbsp;<?=$hotkeys->ll('send option: summary', "Send a summary of the ticket")?><br>
   <input type="radio" name="method" value="3" <?=($method == 3)? "checked" : "";?>>
   &nbsp;<?=$hotkeys->ll('send option: log', "Send a summary, and the ticket's log")?>
  </td>
</tr>
<tr>
  <td class="subTitle">
  <? renderDivButton($hotkeys->find('Send Email'), "window.document.forms['emailForm'].submit()"); ?>
  </td>
</tr>
<tr>
</table>

</form>			     
