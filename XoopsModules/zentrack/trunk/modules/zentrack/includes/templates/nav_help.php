<?php  if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?php echo tr("Help"); ?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?>>
    <a href='<?php echo $helpUrl?>/tutorial.php' class='leftNavLink'><?php echo tr("Tutorial"); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?>>
    <a href='<?php echo $helpUrl?>/users/index.php' class='leftNavLink'><?php echo tr("User's Guide"); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?>>
    <a href='<?php echo $helpUrl?>/admin/index.php' class='leftNavLink'><?php echo tr("Admin Guide"); ?></a>
  </td>
</tr>
<tr><td class='note'>&nbsp;</td></tr>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?php echo tr("About Us"); ?></td>
</tr>
<tr>
  <td class='leftNavCell' height='25%' valign='top'>
      <a href='<?php echo $helpUrl?>/about.php'>About <?php echo $zen->getSetting("system_name"); ?></a>
      <br><a href='<?php echo $helpUrl?>/gpl.php'>License</a>
      <br><a href='http://www.zentrack.net'>Website</a>
    </td>
</tr>
<tr><td class='note'>&nbsp;</td></tr>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?php echo tr("Support"); ?></td>
</tr>
<tr>
  <td class='leftNavCell' height='100%' valign='top'>
      <a href='http://www.zentrack.net/modules/support/'>Community</a>
      <br><a href='http://www.zentrack.net/modules/newbb/'>Forums</a>
      <br><a href='<?php echo $helpUrl?>/bugs.php'>Reporting Bugs</a>
      <br><a href='http://www.zentrack.net/feedback/'>Feedback</a>
    </td>
</tr>
