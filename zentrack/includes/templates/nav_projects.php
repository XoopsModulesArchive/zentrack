<?php  if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Projects")?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?>>
    <a href='<?=$rootUrl?>/assignedProjects.php' class='leftNavLink'><?=tr('My Projects')?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hotkeys->tt("New Project")?>'>
    <a href='<?=$rootUrl?>/newProject.php' class='leftNavLink'><?=$hotkeys->ll("New Project")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title="<?=$hotkeys->tt("Advanced Search")?>">
    <a href='<?=$rootUrl?>/search.php' class='leftNavLink'><?=$hotkeys->ll("Advanced Search", "Search")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?>>
    <a href='<?=$rootUrl?>/searchLogs.php' class='leftNavLink'><?=tr('Search Logs')?></a>
  </td>
</tr>
<tr>
  <td class='leftNavCell' height='100%' valign='top'>
    <div class='recentHistory'><?=tr("Recent Projects")?></div>
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