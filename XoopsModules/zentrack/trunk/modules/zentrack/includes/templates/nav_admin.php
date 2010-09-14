<?php
  if( !ZT_DEFINED ) { die("Illegal Access"); }
  //shortcut
  $hk = $hotkeys 
?>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?php echo tr("Users"); ?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hk->tt('New User'); ?>'>
    <a href='<?php echo $rootUrl?>/admin/addUser.php' class='leftNavLink'><?php echo $hk->ll("New User"); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hk->tt('Edit Users'); ?>'>
    <a href='<?php echo $rootUrl?>/admin/listUsers.php' class='leftNavLink'><?php echo $hk->ll('Edit Users'); ?></a>
  </td>
</tr>
<tr><td class='note'>&nbsp;</td></tr>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?php echo tr("Tickets"); ?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hk->tt('Edit Tickets'); ?>'>
    <a href='<?php echo $rootUrl?>/admin/editTicket.php' class='leftNavLink'><?php echo $hk->ll('Edit Tickets'); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hk->tt('Edit Field Map'); ?>'>
    <a href='<?php echo $rootUrl?>/admin/fieldMap.php' class='leftNavLink'><?php echo $hk->ll('Edit Field Map'); ?></a>
  </td>
</tr>
<tr><td class='note'>&nbsp;</td></tr>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?php echo tr("Data Types"); ?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hk->tt('Bins'); ?>'>
    <a href='<?php echo $rootUrl?>/admin/bins.php' class='leftNavLink'><?php echo $hk->ll('Bins'); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hk->tt('Priorities'); ?>'>
    <a href='<?php echo $rootUrl?>/admin/priorities.php' class='leftNavLink'><?php echo $hk->ll('Priorities'); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hk->tt('Systems'); ?>'>
    <a href='<?php echo $rootUrl?>/admin/systems.php' class='leftNavLink'><?php echo $hk->ll('Systems'); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hk->tt('Tasks'); ?>'>
    <a href='<?php echo $rootUrl?>/admin/tasks.php' class='leftNavLink'><?php echo $hk->ll('Tasks'); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hk->tt('Types'); ?>'>
    <a href='<?php echo $rootUrl?>/admin/types.php' class='leftNavLink'><?php echo $hk->ll('Types'); ?></a>
  </td>
</tr>
<tr><td class='note'>&nbsp;</td></tr>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?php echo tr("Settings"); ?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hk->tt('Data Groups'); ?>'>
    <a href='<?php echo $rootUrl?>/admin/groups.php' class='leftNavLink'><?php echo $hk->ll('Data Groups'); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hk->tt('Behaviors'); ?>'>
    <a href='<?php echo $rootUrl?>/admin/behaviors.php' class='leftNavLink'><?php echo $hk->ll('Behaviors'); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hk->tt('Configuration'); ?>'>
    <a href='<?php echo $rootUrl?>/admin/config.php' class='leftNavLink'><?php echo $hk->ll('Configuration'); ?></a>
  </td>
</tr>
<tr><td height='100%'>&nbsp;</td></tr>
