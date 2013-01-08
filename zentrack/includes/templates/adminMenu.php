<?php if( !ZT_DEFINED ) { die("Illegal Access"); }

	showTabbedMenu(0);

	?>
<!--
<table width='80%' bgcolor="#e7e7e7" border="1"><tr><td>
-->
<tr><td width="100%">

<div class='menuBox'>
    <div><?=tr("User Administration")?></div>
    <p onclick='mClk(this)'>
    <a href='<?=$rootUrl?>/admin/addUser.php'><?=tr("New User")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("Create a new user account")?></span></p>
    <p onclick='mClk(this)'>
    <a href='<?=$rootUrl?>/admin/listUsers.php'><?=tr("Edit Users/Access")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("Edit user accounts and permissions.")?></span></p>
  </div>
      
  <div class='menuBox'>
    <div><?=tr("Ticket Administration")?></div>
<!--
    <p onclick='mClk(this)'>
    <a href='<?=$rootUrl?>/admin/editTicket.php'><?=tr("Edit Tickets")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("Edit ticket information")?></span></p>
-->
    <p onclick='mClk(this)'>
    <a href="<?=$rootUrl?>/admin/fieldMap.php"><?=tr("Edit Field Map")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("View specific display properties for fields")?></span></p>
  </div>

  <div class='menuBox'>
    <div><?=tr("Data Types")?></div>
    <p onclick='mClk(this)'>
    <a href='<?=$rootUrl?>/admin/bins.php'><?=tr("Edit Bins")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("Bins are departments or groups that tickets belong to.")?></span></p>
    <p onclick='mClk(this)'>
    <a href='<?=$rootUrl?>/admin/priorities.php'><?=tr("Edit Priorities")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("Priorities represent the importance of an issue.")?></span></p>
    <p onclick='mClk(this)'>
    <a href='<?=$rootUrl?>/admin/systems.php'><?=tr("Edit Systems")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("Systems represent a component or area the ticket is specific to.")?></span></p>
    <p onclick='mClk(this)'>
    <a href='<?=$rootUrl?>/admin/tasks.php'><?=tr("Edit Tasks")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("Tasks represent types of log entries.")?></span></p>
    <p onclick='mClk(this)'>
    <a href='<?=$rootUrl?>/admin/types.php'><?=tr("Edit Types")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("Types represent the type of ticket activity.")?></span></p>
  </div>
  
  <div class='menuBox'>
    <div><?=tr("Settings Administration")?></div>
    <p onclick='mClk(this)'>
    <a href='<?=$rootUrl?>/admin/groups.php'><?=tr("Edit Data Groups")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("Data groups are a list created from a data type")?></span></p>
    <p onclick='mClk(this)'>
    <a href='<?=$rootUrl?>/admin/behaviors.php'><?=tr("Edit Behaviors")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("Behaviors let you specify how a field modification would affect other field of the current ticket.")?></span></p>
    <p onclick='mClk(this)'>
    <a href='<?=$rootUrl?>/admin/config.php'><?=tr("Configuration Settings")?></a>
    &nbsp;&nbsp;<span class="note"><?=tr("Edit the zenTrack settings.  Consult the documentation before using this feature.")?></span></p>
  </div>

</td></tr></table>
