<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <tr>
  <td<?php echo (isset($expand_search)&&$expand_search)? " class='titleCell'" : " ".$nav_rollover_text?>>
  <a class='menuLink' href="<?php echo $rootUrl?>/search.php"><?php echo tr("Search"); ?></a>
  </td>
  </tr>
  
  <?php if( isset($expand_search)&&$expand_search ) { ?>
  <tr>
  <td <?php echo $nav_rollover_text?>>
  <a class='subMenuLink' href="<?php echo $rootUrl?>/search.php">&nbsp;&nbsp;<?php echo tr("New Search"); ?>
  </td>
  </tr>
  <tr>
  <td <?php echo $nav_rollover_text?>>
  <a class='subMenuLink' href="<?php echo $rootUrl?>/searchLogs.php">&nbsp;&nbsp;<?php echo tr("Search Logs"); ?></a>
  </td>
  </tr>  
       
  <?php } ?>
