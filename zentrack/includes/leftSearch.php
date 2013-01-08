<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <tr>
  <td<?=(isset($expand_search)&&$expand_search)? " class='titleCell'" : " ".$nav_rollover_text?>>
  <a class='menuLink' href="<?=$rootUrl?>/search.php"><?=tr("Search")?></a>
  </td>
  </tr>
  
  <? if( isset($expand_search)&&$expand_search ) { ?>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/search.php">&nbsp;&nbsp;<?=tr("New Search")?>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/searchLogs.php">&nbsp;&nbsp;<?=tr("Search Logs")?></a>
  </td>
  </tr>  
       
  <? } ?>
