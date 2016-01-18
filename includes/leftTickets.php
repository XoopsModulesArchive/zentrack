<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <tr>
  <td<?=(isset($expand_projects)&&$expand_projects)? " class='titleCell'" : " ".$nav_rollover_text?>>
  <a class='menuLink' href="<?=$rootUrl?>/projects.php"><?=tr("Projects")?></a>
  </td>
  </tr>
<?php if( isset($expand_projects)&&$expand_projects ) { ?>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/assignedProjects.php">&nbsp;&nbsp;<?=tr("Assigned to")." $login_inits"?></a>
  </td>
  </tr>  
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/newProject.php">&nbsp;&nbsp;<?=tr("Create New")?></a>
  </td>
  </tr>
<?php } ?>
  <tr>
  <td<?=(isset($expand_tickets)&&$expand_tickets)? " class='titleCell'" : " ".$nav_rollover_text?>>
  <a class='menuLink' href="<?=$rootUrl?>/index.php"><?=tr("Tickets")?></a>
  </td>
  </tr>
<?php if( isset($expand_tickets)&&$expand_tickets ) { ?>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/assignedTickets.php">&nbsp;&nbsp;<?=tr("Assigned to")." $login_inits"?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/newTicket.php">&nbsp;&nbsp;<?=tr("Create New")?></a>
  </td>
  </tr>  
<?php } ?>
