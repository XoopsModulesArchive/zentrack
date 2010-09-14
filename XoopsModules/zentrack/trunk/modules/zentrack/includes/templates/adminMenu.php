<?php if( !ZT_DEFINED ) { die("Illegal Access"); } 

	showTabbedMenu(0);

	?>
<!--
<table width='80%' bgcolor="#e7e7e7" border="1"><tr><td>
-->
<tr><td width="100%">

<div class='menuBox'>
    <div><?php echo tr("User Administration"); ?></div>
    <p onclick='mClk(this)'>
    <a href='<?php echo $rootUrl?>/admin/addUser.php'><?php echo tr("New User"); ?></a>
    &nbsp;&nbsp;<span class="note"><?php echo tr("Create a new user account"); ?></span></p>
    <p onclick='mClk(this)'>
    <a href='<?php echo $rootUrl?>/admin/listUsers.php'><?php echo tr("Edit Users/Access"); ?></a>
    &nbsp;&nbsp;<span class="note"><?php echo tr("Edit user accounts and permissions."); ?></span></p>
  </div>
      
  <div class='menuBox'>
    <div><?php echo tr("Ticket Administration"); ?></div>
<!--
    <p onclick='mClk(this)'>
    <a href='<?php echo $rootUrl?>/admin/editTicket.php'><?php echo tr("Edit Tickets"); ?></a>
    &nbsp;&nbsp;<span class="note"><?php echo tr("Edit ticket information"); ?></span></p>
-->
    <p onclick='mClk(this)'>
    <a href="<?php echo $rootUrl?>/admin/fieldMap.php"><?php echo tr("Edit Field Map"); ?></a>
    &nbsp;&nbsp;<span class="note"><?php echo tr("View specific display properties for fields"); ?></span></p>
  </div>

  <div class='menuBox'>
    <div><?php echo tr("Data Types"); ?></div>
    <p onclick='mClk(this)'>
    <a href='<?php echo $rootUrl?>/admin/bins.php'><?php echo tr("Edit Bins"); ?></a>
    &nbsp;&nbsp;<span class="note"><?php echo tr("Bins are departments or groups that tickets belong to."); ?></span></p>
    <p onclick='mClk(this)'>
    <a href='<?php echo $rootUrl?>/admin/priorities.php'><?php echo tr("Edit Priorities"); ?></a>
    &nbsp;&nbsp;<span class="note"><?php echo tr("Priorities represent the importance of an issue."); ?></span></p>
    <p onclick='mClk(this)'>
    <a href='<?php echo $rootUrl?>/admin/systems.php'><?php echo tr("Edit Systems"); ?></a>
    &nbsp;&nbsp;<span class="note"><?php echo tr("Systems represent a component or area the ticket is specific to."); ?></span></p>
    <p onclick='mClk(this)'>
    <a href='<?php echo $rootUrl?>/admin/tasks.php'><?php echo tr("Edit Tasks"); ?></a>
    &nbsp;&nbsp;<span class="note"><?php echo tr("Tasks represent types of log entries."); ?></span></p>
    <p onclick='mClk(this)'>
    <a href='<?php echo $rootUrl?>/admin/types.php'><?php echo tr("Edit Types"); ?></a>
    &nbsp;&nbsp;<span class="note"><?php echo tr("Types represent the type of ticket activity."); ?></span></p>
  </div>
  
  <div class='menuBox'>
    <div><?php echo tr("Settings Administration"); ?></div>
    <p onclick='mClk(this)'>
    <a href='<?php echo $rootUrl?>/admin/groups.php'><?php echo tr("Edit Data Groups"); ?></a>
    &nbsp;&nbsp;<span class="note"><?php echo tr("Data groups are a list created from a data type"); ?></span></p>
    <p onclick='mClk(this)'>
    <a href='<?php echo $rootUrl?>/admin/behaviors.php'><?php echo tr("Edit Behaviors"); ?></a>
    &nbsp;&nbsp;<span class="note"><?php echo tr("Behaviors let you specify how a field modification would affect other field of the current ticket."); ?></span></p>
    <p onclick='mClk(this)'>
    <a href='<?php echo $rootUrl?>/admin/config.php'><?php echo tr("Configuration Settings"); ?></a>
    &nbsp;&nbsp;<span class="note"><?php echo tr("Edit the zenTrack settings.  Consult the documentation before using this feature."); ?></span></p>
  </div>

</td></tr></table>
