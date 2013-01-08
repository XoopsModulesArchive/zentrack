<?php if( !ZT_DEFINED ) { die("Illegal Access"); }

$hotkeys->loadSection('log');
$GLOBALS['zt_hotkeys'] = $hotkeys;
$total_hours = 0;
$logs = $zen->get_logs($id);
$num_logs=0;
if( is_array($logs) && count($logs) > 0) {
  $att = $zen->get_attachments($id,null,1);
  $sep = ",&nbsp;";
  $syslogs = array();
  foreach($logs as $l) {
    $total_hours += $l['hours'];
    $num_logs ++;

    $lid = $l["lid"];
    $style = ($style == 'cell')? 'bars' : 'cell';
    $thing = " style=''";
    if( !$l['user_id'] ) {
      $thing = " style='display:none'";
      $syslogs[] = $lid;
    }
    
    // the details
    $log_text .= "<div id='log_{$lid}' class='bars' $thing>";
    $log_text .= "<b>".$zen->showDateTime($l["created"])." - ".uptr($l["action"])."</b>";
    $log_text .= "<div class='tiny'>";
    $log_text .= tr("Bin: ").$zen->getBinName($l["bin_id"]);
    $log_text .= $sep.tr("User: ").$zen->formatName($l["user_id"],2);
    $log_text .= (strlen($l["hours"]))? $sep.tr("Hours: ").$l['hours']:"";
    $log_text .= "</div>";
    $log_text .= "</div>";

    // the log and attachments
    if( $l["entry"] ) {
      $log_text .= "<div id='log_{$lid}_entry' class='cell' $thing>";
      $l["entry"] = $zen->ffvText($l["entry"]);
      //$l["entry"] = preg_replace("#\&amp;#", "&", $l["entry"]);
      //	$l["entry"] = preg_replace("#(https?://[a-zA-Z0-9_/.-]+[a-zA-Z0-9\-_]+\.[a-z]{2,3}(/[a-zA-Z/\._\?=&0-9-]+))#", "<a href='\\1' target='_blank'>\\1</a>", $l["entry"]);
      $l["entry"] = preg_replace("|(https?://[a-zA-Z0-9_/.-]+(/[a-zA-Z0-9/\.,_\?=&;:#+$!~*%'()-]+[a-zA-Z0-9_=&#+~%-]))|",
      "<a href='\\1' target='_blank'>\\1</a>", $l["entry"]);
      $l["entry"] = preg_replace("#([^/])(www\.)([a-zA-Z_/.-]+[a-zA-Z])#", 
	    "\\1<a href='http://www.\\3' target='_blank'>www.\\3</a>", $l["entry"]);
      $l["entry"] = preg_replace("#^(www\.)([a-zA-Z_/.-]+[a-zA-Z])#", 
      "<a href='http://www.\\2' target='_blank'>www.\\2</a>", $l["entry"]);
      $log_text .= $l["entry"];
      $log_text .= "</div>\n";
    }
    else if( !is_array($att["$id"]["$lid"]) ) {
      $log_text .= "&nbsp;";
    }
    if( is_array($att["$id"]["$lid"]) ) {
      $log_text .= "<div id='log_{$lid}_att' class='cell' $thing>";
      $log_text .= "<b>".uptr("Attachments").":</b><br>";
      foreach( $att["$id"]["$lid"] as $a ) {
        $log_text .= "<a href='".$zen->getSetting("url_view_attachment")."?aid={$a['attachment_id']}' ";
        $log_text .= "target='_blank'>{$a['name']}</a>";
        $log_text .= "<span class='small'>{$a['description']}</span><br>\n";
      }
      $log_text .= "</div>\n";
    }
  }	    
} else {
  $log_text .= "<div>".tr("The log is empty")."</div>\n";
}

?>
<div class='borderBox'>
  <div class='borderLabel'><span><?=uptr("Log History")?></span></div>
  <form>
  <input type='checkbox' id='systemLogFilterCheckbox' value='1' onclick='toggleLogs(this.checked);'>
  <label for="systemLogFilterCheckbox" title="<?=$hotkeys->tt("Show All Logs")?>"><?=$hotkeys->ll("Show All Logs");?></label>
  <span class='note'>
  &nbsp;&nbsp;&nbsp;&nbsp;<?=tr("Log Entries: ").$num_logs?>
  &nbsp;&nbsp;&nbsp;&nbsp;<?=tr("Hours Worked: ").$total_hours?>
  </span></form>
  <div id='logSet' class='borderContent'><?=$log_text?></div>
</div>
<br>
<?php if( is_array($logs) && count($logs) > 0) { ?>
<script type='text/javascript'>
var sysLogIds = [<?

  $sep = '';
  foreach($syslogs as $s) {
    print "$sep 'log_$s'";
    if( !$sep ) { $sep = ','; }
  }

?>];

function toggleLogs(b) {
  var s = b? '' : 'none';
  var n;
  for(var i=0; i < sysLogIds.length; i++) {
    n = sysLogIds[i];
    toggleLogNode( window.document.getElementById(n), s );
    toggleLogNode( window.document.getElementById(n+'_entry'), s );
    toggleLogNode( window.document.getElementById(n+'_att'), s);
  }
}

function toggleLogNode( node, s ) {
  if( node ) { node.style.display = s; }  
}

</script>
<?php } ?>
