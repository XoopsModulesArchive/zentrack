<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <tr>
  <td <?=($expand_admin)? " class='titleCell'" : $nav_rollover_text?>>
   <a href='<?=$rootUrl?>/admin/' class='menuLink'><?=tr("Admin")?></a>
  </td>
  </tr>
  
  <? if( $expand_admin ) { ?>
  
  <tr>
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/addUser.php"><?=tr("New User")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/listUsers.php"><?=tr("Edit Users")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/editTicket.php"><?=tr("Edit Tickets")?></a>
  </td>
  </tr>  
  <tr>
  <!--
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/archive.php"><?=tr("Archive Tickets")?></a>
  </td>
  -->
  </tr>  
  <tr>
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/groups.php"><?=tr("Edit Data Groups")?></a>
  </td>
  </tr>  
  <tr>
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/editCustom.php"><?=tr("Edit Variable Fields")?></a>
  </td>
  </tr>  
  <tr>
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/behaviors.php"><?=tr("Edit Behaviors")?></a>
  </td>
  </tr>  
  <tr>
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/config.php"><?=tr("Settings")?></a>
  </td>
  </tr>  

  <? } ?>
