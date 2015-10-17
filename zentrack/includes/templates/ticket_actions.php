<?php  if( !ZT_DEFINED ) { die("Illegal Access"); } ?><table><tr><?

$hotkeys->loadSection('actionbar');
$GLOBALS['zt_hotkeys'] = $hotkeys;
$iconDir = "$imageDir/48x48";
$actions = $zen->getActions();
foreach($actions as $k=>$v) {
  if( !$v['button'] ) { continue; }
  
  //actionApplicable( $id, $action, $user_id = '', $noaccess = 0 )
  $use = $zen->actionApplicable($ticket, $k, $login_id);
  
  if( $use ) { 
    print "<td class='icon' onmouseover='if(window.document.body && mClassX){mClassX(this, \"icon iconDown\", true);}'";
    print " title=\"".$hotkeys->tt("Action: {$v['label']}")."\"";
    print " onmouseout='if(window.document.body && mClassX){mClassX(this, \"icon\");}' "
      ."onclick='if(window.document.body && mClk){mClk(this);return false;}'>";
    if( $k == 'print' ) {
      print "<a class='leftNavLink' href='#'";
      print " onclick='popupWindowScrolls(\"$rootUrl/actions/$k.php?id=$id\",\"printWindow\", 700, 500);return false;'>";
    }
    else {
      print "<a class='leftNavLink' href='$rootUrl/actions/$k.php?id=$id&setmode=".$zen->ffv($page_mode)."'>";
    }
    if( $v['img'] ) {
      print "<img src='$imageUrl/24x24/{$v['img']}' border='0' width='24' height='24'>";
    }
    print "<br>".$hotkeys->ll("Action: {$v['label']}", $v['label']);
    print "</a>";
    print "</td>";
  }
  else {
    $hotkeys->disableAction( $hotkeys->find("Action: {$v['label']}") );
    print "<td class='icon iconOff' ";
    print " title=\"".$hotkeys->tt("Action: {$v['label']}")."\">";    
    if( $v['img'] ) {
      print "<img src='$imageUrl/24x24/{$v['img']}' border='0' width='24' height='24'>";
    }
    print "<br>".$hotkeys->ll("Action: {$v['label']}", $v['label']);
    print "</td>";
  }

}

?></tr></table>
