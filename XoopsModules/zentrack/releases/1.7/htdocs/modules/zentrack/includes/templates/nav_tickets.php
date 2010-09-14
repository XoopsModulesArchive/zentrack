<?php  if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?php echo tr("Tickets"); ?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hotkeys->tt("New Ticket"); ?>'>
    <a href='<?php echo $rootUrl?>/newTicket.php' class='leftNavLink'><?php echo $hotkeys->ll("New Ticket"); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?>>
    <a href='<?php echo $rootUrl?>/assignedTickets.php' class='leftNavLink'><?php echo tr('My Tickets'); ?></a>
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
    <div class='recentHistory'><?php echo tr("Recent Tickets"); ?></div>
    <?php
      $history =& $zen->getHistoryManager();
      $list = $history->getList('ticket');
      if( count($list) ) {
        foreach($list as $k=>$v) {
          print "<br><a href='$rootUrl/ticket.php?id=$k' title='".$zen->ffv($v)."'>$k".tr("-").substr($zen->ffv($v),0,12)."</a>\n";
        }
      }
      else {
        print "-none-";
      }    
    ?>
  </td>
</tr>