<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <tr>
  <td <?php echo ((isset($expand_help)&&$expand_help))? " class='titleCell'" : $nav_rollover_text?>>
    <a href='<?php echo $rootUrl?>/help/' class='menuLink'><?php echo tr("Manual"); ?></a>
  </td>
  </tr>
