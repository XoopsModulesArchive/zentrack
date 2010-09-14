<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <tr>
  <td <?php echo ($expand_admin)? " class='titleCell'" : $nav_rollover_text?>>
   <a href='<?php echo $rootUrl?>/admin/' class='menuLink'><?php echo tr("Admin"); ?></a>
  </td>
  </tr>
  
  <?php if( $expand_admin ) { ?>
  
  <tr>
  <td <?php echo $nav_rollover_text?>>
    <a class="subMenuLink" href="<?php echo $rootUrl?>/admin/addUser.php"><?php echo tr("New User"); ?></a>
  </td>
  </tr>
  <tr>
  <td <?php echo $nav_rollover_text?>>
    <a class="subMenuLink" href="<?php echo $rootUrl?>/admin/listUsers.php"><?php echo tr("Edit Users"); ?></a>
  </td>
  </tr>
  <tr>
  <td <?php echo $nav_rollover_text?>>
    <a class="subMenuLink" href="<?php echo $rootUrl?>/admin/editTicket.php"><?php echo tr("Edit Tickets"); ?></a>
  </td>
  </tr>  
  <tr>
  <!--
  <td <?php echo $nav_rollover_text?>>
    <a class="subMenuLink" href="<?php echo $rootUrl?>/admin/archive.php"><?php echo tr("Archive Tickets"); ?></a>
  </td>
  -->
  </tr>  
  <tr>
  <td <?php echo $nav_rollover_text?>>
    <a class="subMenuLink" href="<?php echo $rootUrl?>/admin/groups.php"><?php echo tr("Edit Data Groups"); ?></a>
  </td>
  </tr>  
  <tr>
  <td <?php echo $nav_rollover_text?>>
    <a class="subMenuLink" href="<?php echo $rootUrl?>/admin/editCustom.php"><?php echo tr("Edit Variable Fields"); ?></a>
  </td>
  </tr>  
  <tr>
  <td <?php echo $nav_rollover_text?>>
    <a class="subMenuLink" href="<?php echo $rootUrl?>/admin/behaviors.php"><?php echo tr("Edit Behaviors"); ?></a>
  </td>
  </tr>  
  <tr>
  <td <?php echo $nav_rollover_text?>>
    <a class="subMenuLink" href="<?php echo $rootUrl?>/admin/config.php"><?php echo tr("Settings"); ?></a>
  </td>
  </tr>  

  <?php } ?>
