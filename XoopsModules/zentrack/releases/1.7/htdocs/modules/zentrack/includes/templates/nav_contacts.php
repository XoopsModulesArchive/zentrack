<?php  if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?php echo tr("Contacts"); ?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hotkeys->tt("Contacts","Browse"); ?>'>
    <a href='<?php echo $rootUrl?>/contacts.php' class='leftNavLink'><?php echo $hotkeys->ll("Contacts","Browse"); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title='<?php echo $hotkeys->tt("New Contact"); ?>'>
    <a href='<?php echo $rootUrl?>/newContact.php' class='leftNavLink'><?php echo $hotkeys->ll("New Contact"); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title="<?php echo $hotkeys->tt('Find'); ?>">
    <a href='<?php echo $rootUrl?>/searchContacts.php' class='leftNavLink'><?php echo $hotkeys->ll("Find"); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavCell' height='25%' valign='top'>
    <div class='recentHistory'><?php echo tr("Recent Companies"); ?></div>
    <?php
      $history =& $zen->getHistoryManager();
      $list = $history->getList('company');
      if( count($list) ) {
        foreach($list as $k=>$v) {
          print "<div><a href='$rootUrl/contact.php?cid=$k'>".$zen->ffv(substr($v,0,15))."</a></div>\n";
        }
      }
      else {
        print "-none-";
      }
    ?>
    <P>
    <div class='recentHistory'><?php echo tr("Recent Employees"); ?></div>
    <?php
      $history =& $zen->getHistoryManager();
      $list = $history->getList('employee');
      if( count($list) ) {
        foreach($list as $k=>$v) {
          print "<div><a href='$rootUrl/contact.php?pid=$k'>".$zen->ffv(substr($v,0,15))."</a></div>\n";
        }
      }
      else {
        print tr("-none-");
      }
    ?>
  </td>
</tr>
<tr><td class='note'>&nbsp;</td></tr>
<tr>
  <td class='leftNavTitle' height='25' valign='middle'><?php echo tr("Agreements"); ?></td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title="<?php echo $hotkeys->tt('Browse'); ?>">
    <a href='<?php echo $rootUrl?>/agreements.php' class='leftNavLink'><?php echo $hotkeys->ll("Browse"); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavMenu' <?php echo $lnav_rollover?> title="<?php echo $hotkeys->tt('New Agreement'); ?>">
    <a href='<?php echo $rootUrl?>/newAgreement.php' class='leftNavLink'><?php echo $hotkeys->ll("New Agreement"); ?></a>
  </td>
</tr>
<tr>
  <td class='leftNavCell' height='100%' valign='top'>
    <div class='recentHistory'><?php echo tr("Recent Agreements"); ?></div>
    <?php
      $history =& $zen->getHistoryManager();
      $list = $history->getList('agreement');
      if( count($list) ) {
        foreach($list as $k=>$v) {
          print "<br><a href='$rootUrl/contacts.php?pid=$k'>".$zen->ffv(substr($v,0,15))."</a>\n";
        }
      }
      else {
        print "-none-";
      }
    ?>
  </td>
</tr>