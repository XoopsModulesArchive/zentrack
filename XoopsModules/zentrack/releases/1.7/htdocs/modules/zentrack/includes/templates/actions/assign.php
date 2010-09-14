<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form name='assignForm' method="post" action="<?php echo $SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?php echo $id?>">
<input type="hidden" name="actionComplete" value="1">

<table class='formTable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle' colspan='2'><?php echo uptr("Assign Ticket"); ?>
   &nbsp;&nbsp;<span class="note">(<?php echo tr("Assign this ticket to a new user"); ?>)</span>
 </td>
</tr>
<tr>
 <td class="bars">
   <?php echo $hotkeys->ll("Recipient"); ?>
 </td>
 <td class='bars'>
<select name="user_id" title="<?php echo $hotkeys->tt("Recipient"); ?>">
<?php
  //$bins = $zen->getUsersBins($login_id,"level_assign");
  // ticket can only be assigned to users who may access
  // the ticket's current bin
  $bins = array($ticket["bin_id"]);
  $users = $zen->get_users($bins,"level_user");
  if( is_array($bins) && is_array($users) ) {
    foreach($users as $v) {
      if( $v["user_id"] != $login_id ) {
        $sel = ($v["user_id"] == $user_id)? "selected" : "";
        print "<option value='$v[user_id]' $sel>".$zen->formatName($v,1)."</option>\n";
      }
    }
  }
  else {
    print "<option value=''>--".tr("none")."--</option>\n";
  }
?>
</select>
  </td>
</tr>
<tr>
  <td class="bars">
     <?php echo $hotkeys->ll("Comments or Instructions"); ?><div class="small">(<?php echo tr("optional"); ?>)</div>
  </td>
  <td class='bars'>
    <textarea cols="50" rows="4" name="comments" title='<?php echo $hotkeys->tt("Comments or Instructions"); ?>'><?php echo 
      $zen->ffvText($comments); ?></textarea>
  </td>
</tr>
<tr>
  <td class="subTitle" colspan='2'>
  <?php renderDivButton($hotkeys->find('Assign'), "window.document.forms['assignForm'].submit()"); ?>
  </td>
</tr>
<tr>
</table>
<p class='note'><?php echo tr("Note").":".tr("Only users who have permission to work on tickets in the current bin are listed."); ?></p>

</form>			     
