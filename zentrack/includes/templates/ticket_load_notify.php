<?php if( !ZT_DEFINED ) { die("Illegal Access"); }

  $on = $zen->actionApplicable($ticket['id'],'notify',$login_id);
  $drop = $on && $zen->checkAccess($login_id,$ticket['bin_id'],'notify_drop');
  $add = $on && $zen->checkAccess($login_id,$ticket["bin_id"],"notify_add");
  $colspan = $drop? 5 : 4;
  $hotkeys->loadSection('tab_notify');
  $GLOBALS['zt_hotkeys'] = $hotkeys;

?>

  <table width="600" cellpadding="0" cellspacing="1" class='formtable'>
  <tr>  
  <td class='subTitle indent' colspan='<?=$colspan?>'>
  <?=tr("Notify Recipients")?>
  </td>
  </tr>  
      <?php
  $notify_list = $zen->get_notify_list($id);
  if( is_array($notify_list) ) {
    ?>
    <form name='dropNotifyForm' action="<?=$rootUrl?>/actions/dropFromNotify.php" method="post">
    <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
    <input type="hidden" name="setmode" value="<?=$zen->ffv($page_mode)?>">
    <tr>
    <td class='headerCell'><?=tr("Name")?></td>
    <td class='headerCell'><?=tr("Email")?></td>
    <?php if($drop) {?> <td class='headerCell'><?=tr("Delete")?></td> <?php } ?>
    </tr>
    <?php
    foreach($notify_list as $n) {
      if( $n["user_id"] ) {
        $u = $zen->get_user($n["user_id"]);
        $name = $zen->formatName($u);
        $email = $u["email"];
      }
      else {
        $email = $n["email"];
        $name = ($n["name"])? $n["name"] : "&nbsp;";
      }
      print "<tr class='bars'";
      print $row_rollover_eff;
      //print " onmouseover='if(window.document.body && mClassX){mClassX(this, \"altBars\", \"hand\");}' ";
      //print " onmouseout='if(window.document.body && mClassX){mClassX(this);}'";
      print " onclick='checkMyBox(\"drops_{$n['notify_id']}\", event)'>\n";
      print "\t<td>$name</td>\n";
      print "\t<td>".eLink($email)."</td>\n";
      if( $drop ) {
        print "\t<td><input id='drops_{$n['notify_id']}' type='checkbox' "
        ."name='drops[]' value='{$n['notify_id']}'></td>\n";
      }
      print "</tr>\n";
    }
    ?>
    <tr> 
    <td class='subTitle' colspan='<?=$colspan?>'>
    <?php if( $drop ) { ?>
    <div style='float:right'>
    <?php renderDivButtonFind('Drop Recipients'); ?>
    </div>
    <?php } ?>
    </form>
    <?php if( $add ) { ?>
      <div style='float:left'>
      <form name='notifyAddForm' action="<?=$rootUrl?>/actions/addToNotify.php">
      <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
      <input type="hidden" name="setmode" value="<?=$zen->ffv($page_mode)?>">
      <?php renderDivButtonFind('Add Recipients'); ?>
      </form>
      </div>
    <?php } ?>
    </td>
    </tr>
  <?php
  }
  else {
    print "<tr><td class='bars bold'>".tr("No recipients on notify list")."</td></tr>";
    if( $add ) { 
    ?>
      <tr><td class='subTitle'>
      <form name='notifyAddForm' action="<?=$rootUrl?>/actions/addToNotify.php">
      <input type="hidden" name="id" value="<?=$zen->checkNum($id)?>">
      <input type="hidden" name="setmode" value="<?=$zen->ffv($page_mode)?>">
      <?php renderDivButtonFind('Add Recipients'); ?>
      </form>
      </td></tr>
    <?php }
  }
  ?>
  </table>
