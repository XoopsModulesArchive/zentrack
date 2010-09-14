<?php  if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?php echo tr("Projects"); ?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?>>
    <a href='<?php echo $rootUrl?>/assignedProjects.php' class='leftNavLink'><?php echo tr('My Projects'); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hotkeys->tt("New Project"); ?>'>
    <a href='<?php echo $rootUrl?>/newProject.php' class='leftNavLink'><?php echo $hotkeys->ll("New Project"); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title="<?php echo $hotkeys->tt("Advanced Search"); ?>">
    <a href='<?php echo $rootUrl?>/search.php' class='leftNavLink'><?php echo $hotkeys->ll("Advanced Search", "Search"); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?>>
    <a href='<?php echo $rootUrl?>/searchLogs.php' class='leftNavLink'><?php echo tr('Search Logs'); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavCell' height='100%' valign='top'>
    <div class='recentHistory'><?php echo tr("Recent Projects"); ?></div>
    <?php
      $history =& $zen->getHistoryManager();
      $list = $history->getList('project');
      if( count($list) ) {
        foreach($list as $k=>$v) {
          print "<br><a href='$rootUrl/project.php?id=$k' title='".$zen->ffv($v)."'>$k".tr("-").substr($zen->ffv($v),0,12)."</a>\n";
        }
      }
      else {
        print "-none-";
      }
    ?>
  </td>
</tr>