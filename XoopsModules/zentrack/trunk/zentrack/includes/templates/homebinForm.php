<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form method="post" action="<?=$rootUrl?>/misc/homebin.php">

<table width="300" cellpadding="5">
<tr>
  <td colspan="2" class="subTitle" align="center" height="20">
    <b><?=tr("Change Your Default Bin")?></b>
  </td>
</tr>
<tr>
  <td class="bars">
    <b><?=tr("New Default Bin")?></b>
  </td>
  <td class="bars">
    <select name="homebin">
        <?php
  $userBins = $zen->getUsersBins($login_id);
  $user = $zen->getUser($login_id);
  $homebin= $user["homebin"];
  $check = ($homebin == -1)?"selected":"";
  
  print "<option $check value='all'>-".tr("All")."-</option>\n";
  if( is_array($userBins) ) {
    foreach($zen->getBins(1) as $v) {
      $k = $v["bid"];
      
      if(in_array($k, $userBins)) {
        $check = ( $k == $homebin )? "selected" : "";
        print "<option $check value='$k'>$v[name]</option>\n";
      }
    }
  }
?>
    </select>
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
    <input type="submit" value="<?=tr("Update Bin")?>" class="submit">
  </td>
</tr>
</table>

<input type="hidden" name="TODO" value="BIN">
</form>


