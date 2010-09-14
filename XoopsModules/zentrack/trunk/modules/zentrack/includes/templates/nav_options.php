<?php  if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?php echo tr("Preferences"); ?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hotkeys->tt("Change Home Bin"); ?>'>
    <a href='<?php echo $rootUrl?>/misc/homebin.php' class='leftNavLink'><?php echo $hotkeys->ll("Change Home Bin", tr("Home Bin")); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hotkeys->tt("Set Language"); ?>'>
    <a href='<?php echo $rootUrl?>/misc/language.php' class='leftNavLink'><?php echo $hotkeys->ll("Set Language", tr("Language")); ?></a>
  </td>
</tr>
<tr>
  <td height='100%' valign='top'>
  &nbsp;
  </td>
</tr>
