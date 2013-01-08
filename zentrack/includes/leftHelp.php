<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <tr>
  <td <?=((isset($expand_help)&&$expand_help))? " class='titleCell'" : $nav_rollover_text?>>
    <a href='<?=$rootUrl?>/help/' class='menuLink'><?=tr("Manual")?></a>
  </td>
  </tr>
