<?  if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?=tr("Tickets")?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?> title='<?=$hotkeys->tt("New Ticket")?>'>
    <a href='<?=$rootUrl?>/newTicket.php' class='leftNavLink'><?=$hotkeys->ll("New Ticket")?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?=$lnav_rollover?>>
    <a href='<?=$rootUrl?>/assignedTickets.php' class='leftNavLink'><?=tr('My Tickets')?></a>
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
    <div class='recentHistory'><?=tr("Recent Tickets")?></div>
    <?
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