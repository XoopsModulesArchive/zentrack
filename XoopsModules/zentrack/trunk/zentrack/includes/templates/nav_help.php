<?  if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Help")?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?>>
    <a href='<?=$helpUrl?>/tutorial.php' class='leftNavLink'><?=tr("Tutorial")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?>>
    <a href='<?=$helpUrl?>/users/index.php' class='leftNavLink'><?=tr("User's Guide")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?>>
    <a href='<?=$helpUrl?>/admin/index.php' class='leftNavLink'><?=tr("Admin Guide")?></a>
  </td>
</tr>
<tr><td class='note'>&nbsp;</td></tr>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("About Us")?></td>
</tr>
<tr>
  <td class='leftNavCell' height='25%' valign='top'>
      <a href='<?=$helpUrl?>/about.php'>About <?=$zen->getSetting("system_name")?></a>
      <br><a href='<?=$helpUrl?>/gpl.php'>License</a>
      <br><a href='http://www.zentrack.net'>Website</a>
    </td>
</tr>
<tr><td class='note'>&nbsp;</td></tr>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Support")?></td>
</tr>
<tr>
  <td class='leftNavCell' height='100%' valign='top'>
      <a href='http://www.zentrack.net/modules/support/'>Community</a>
      <br><a href='http://www.zentrack.net/modules/newbb/'>Forums</a>
      <br><a href='<?=$helpUrl?>/bugs.php'>Reporting Bugs</a>
      <br><a href='http://www.zentrack.net/feedback/'>Feedback</a>
    </td>
</tr>
