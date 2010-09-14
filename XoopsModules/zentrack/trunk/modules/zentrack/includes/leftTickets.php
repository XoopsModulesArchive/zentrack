<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <tr>
  <td<?php echo (isset($expand_projects)&&$expand_projects)? " class='titleCell'" : " ".$nav_rollover_text?>>
  <a class='menuLink' href="<?php echo $rootUrl?>/projects.php"><?php echo tr("Projects"); ?></a>
  </td>
  </tr>
<?php if( isset($expand_projects)&&$expand_projects ) { ?>     
  <tr>
  <td <?php echo $nav_rollover_text?>>
  <a class='subMenuLink' href="<?php echo $rootUrl?>/assignedProjects.php">&nbsp;&nbsp;<?php echo tr("Assigned to")." $login_inits"?></a>
  </td>
  </tr>  
  <tr>
  <td <?php echo $nav_rollover_text?>>
  <a class='subMenuLink' href="<?php echo $rootUrl?>/newProject.php">&nbsp;&nbsp;<?php echo tr("Create New"); ?></a>
  </td>
  </tr>
<?php } ?>
  <tr>
  <td<?php echo (isset($expand_tickets)&&$expand_tickets)? " class='titleCell'" : " ".$nav_rollover_text?>>
  <a class='menuLink' href="<?php echo $rootUrl?>/index.php"><?php echo tr("Tickets"); ?></a>
  </td>
  </tr>
<?php if( isset($expand_tickets)&&$expand_tickets ) { ?>
  <tr>
  <td <?php echo $nav_rollover_text?>>
  <a class='subMenuLink' href="<?php echo $rootUrl?>/assignedTickets.php">&nbsp;&nbsp;<?php echo tr("Assigned to")." $login_inits"?></a>
  </td>
  </tr>
  <tr>
  <td <?php echo $nav_rollover_text?>>
  <a class='subMenuLink' href="<?php echo $rootUrl?>/newTicket.php">&nbsp;&nbsp;<?php echo tr("Create New"); ?></a>
  </td>
  </tr>  
<?php } ?>
