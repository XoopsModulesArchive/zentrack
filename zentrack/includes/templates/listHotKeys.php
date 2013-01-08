
<div class='heading'><?=tr("Hot Key Settings")?></div>

<?php
foreach($hotkeys->listSections() as $sect) {
  print "<div class='menuBox'>\n";
  print "  <div>".ucwords(str_replace('_', ' ',$sect))."</div>\n";
  print "<table width='400' cellpadding='4' cellspacing='1'>\n";
  $c = 'bars';
  foreach($hotkeys->listEntries($sect) as $key=>$val) {
    $c = $c == 'bars'? 'cell' : 'bars';
    print "<tr class='$c'><td width='50'>$key</td><td width='150'>{$val[0]}</td><td class='note' width='200'>";
    if( count($val) > 2 ) { print $val[2]; }
    else { print "&nbsp;"; }
    print "</td></tr>\n";
  }
  print "</table>";
  print "</div>\n";
}
?>