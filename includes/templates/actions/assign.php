<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form name='assignForm' method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">

<table class='formTable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle' colspan='2'><?=uptr("Assign Ticket")?>
   &nbsp;&nbsp;<span class="note">(<?=tr("Assign this ticket to a new user")?>)</span>
 </td>
</tr>
<tr>
 <td class="bars">
   <?=$hotkeys->ll("Recipient")?>
 </td>
 <td class='bars'>
<select name="user_id" title="<?=$hotkeys->tt("Recipient")?>">
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
     <?=$hotkeys->ll("Comments or Instructions")?><div class="small">(<?=tr("optional")?>)</div>
  </td>
  <td class='bars'>
    <textarea cols="50" rows="4" name="comments" title='<?=$hotkeys->tt("Comments or Instructions")?>'><?=
      $zen->ffvText($comments)?></textarea>
  </td>
</tr>
<tr>
  <td class="subTitle" colspan='2'>
  <?php renderDivButton($hotkeys->find('Assign'), "window.document.forms['assignForm'].submit()"); ?>
  </td>
</tr>
<tr>
</table>
<p class='note'><?=tr("Note").":".tr("Only users who have permission to work on tickets in the current bin are listed.")?></p>

</form>			     
