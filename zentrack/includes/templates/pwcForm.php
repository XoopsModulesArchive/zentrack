<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  $user = $zen->getUser($login_id);
  if( $user["passphrase"] == $zen->encval($user["lname"]) ) {
    print "<p class='hot'>".tr("Your passphrase is currently set to the system default.  Please change it.")."</p>\n";
  }
?>

<form method="post" action="<?=$rootUrl?>/misc/pwc.php">
<table width="300" cellpadding="5">
<tr>
  <td colspan="2" class="subTitle" align="center" height="20">
    <b><?=tr("Change User Password")?></b>
  </td>
</tr>
    <?php
  if( $zen->settingOn("check_pwd_simple") ) {
?>
<tr>
  <td colspan="2" class="bars">
    <?=tr("Your passphrase must be at least 6 characters long and contain at least 1 non-letter character.")?>
  </td>
<tr>
        <?php
  }
?>
<tr>
  <td class="bars">
    <b><?=tr("New Password")?></b>
  </td>
  <td class="bars">
    <input type="password" name="newPass1" size="25" maxlength="25">
  </td>
</tr>
<tr>
  <td class="bars">
    <b><?=tr("Retype New Password")?></b>
  </td>
  <td class="bars">
    <input type="password" name="newPass2" size="25" maxlength="25">
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
    <input type="submit" value="<?=tr("Set Password")?>" class="submit">
  </td>
</tr>
</table>

<input type="hidden" name="TODO" value="SET">
</form>


