<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  $user = $zen->getUser($login_id);
  if( $user["passphrase"] == $zen->encval($user["lname"]) ) {
    print "<p class='hot'>".tr("Your passphrase is currently set to the system default.  Please change it.")."</p>\n";
  }
?>

<form method="post" action="<?php echo $rootUrl?>/misc/pwc.php">
<table width="300" cellpadding="5">
<tr>
  <td colspan="2" class="subTitle" align="center" height="20">
    <b><?php echo tr("Change User Password"); ?></b>
  </td>
</tr>
<?php
  if( $zen->settingOn("check_pwd_simple") ) {
?>
<tr>
  <td colspan="2" class="bars">
    <?php echo tr("Your passphrase must be at least 6 characters long and contain at least 1 non-letter character."); ?>
  </td>
<tr>
<?php
  }
?>
<tr>
  <td class="bars">
    <b><?php echo tr("New Password"); ?></b>
  </td>
  <td class="bars">
    <input type="password" name="newPass1" size="25" maxlength="25">
  </td>
</tr>
<tr>
  <td class="bars">
    <b><?php echo tr("Retype New Password"); ?></b>
  </td>
  <td class="bars">
    <input type="password" name="newPass2" size="25" maxlength="25">
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
    <input type="submit" value="<?php echo tr("Set Password"); ?>" class="submit">
  </td>
</tr>
</table>

<input type="hidden" name="TODO" value="SET">
</form>


