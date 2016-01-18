<?php
  $hotkeys->loadSection('auto_login');
  print "<p>";
  if( $zen->get_prefs($login_id,'autologin') ) {
    $txt = tr("Turn Off");
    $val = "off";
  }
  else {
    $txt = tr("Turn On");
    $val = "on";
  } 
  
  $current = "<b>".($val == "on"? tr("OFF") : tr("ON"))."</b>";
?>

<div class='heading'><?=tr("Change Auto-Login Setting")?></div>

<p><?= tr("The auto-login feature can remember your username and password when you return to ? in the future.", $zen->getSetting('system_name')) ?></p>

<p><?= tr("The auto-login is currently ? for your account.", $current) ?></p>

<form method="get" name='autoForm' action="<?=$rootUrl?>/misc/autologin.php">
  <table width="300" cellpadding="5">
  <tr>
    <td colspan="2" class="subTitle" align="center" height="20">
      <b><?=tr("Change Setting")?></b>
    </td>
  </tr>
  <tr>
    <td class="bars" colspan="2">
      <?php renderDivButton('ALT+O', false, 100, $txt); ?>
    </td>
  </tr>
  </table>
  <input type="hidden" name="setauto" value="<?=$val?>">
</form>
