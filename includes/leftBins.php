<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <tr>
  <td class="altCell" align=center>
  <b><?=tr("Current Bin")?></b>
  </td>
  </tr>
  <tr>
  <form name="newbin" action="<?
    
    print $rootUrl.'/';
    print $expand_projects? 'projects' : 'index';
    print '.php';
      
  ?>">
  <td>
    <select name="newbin" onChange="document.newbin.submit()">
      <option <?=($login_bin == -1)?"selected ":"" ?>value='all'>-<?=tr("All")?>-</option>
        <?php
  $bins = $zen->getBins(1);
  for($i=0; $i<count($bins); $i++) {
    $v = $bins[$i];
    $k = $v["bid"];
    $zen->getAccess($login_id);
    if( $zen->checkAccess($login_id,$k,"level_view") ) {
      if( strlen($v["name"]) > 18 )
      $v["name"] = substr($v["name"],0,16)."...";
      print ($k == $login_bin)? 
      "<option selected value='$k'>{$v['name']}</option>" 
      : "<option value='$k'>{$v['name']}</option>\n";
    }
  }
  ?>
    </select>
  </td>
  </form>
  </tr>
