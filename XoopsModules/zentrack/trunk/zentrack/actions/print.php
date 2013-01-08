<?
  
  $action = "print";
  include("action_header.php");

  if( !is_array($ticket) ) {
	  die("Ticket not found.  Unable to load");
  }

  $tid = $ticket["type_id"];
  $user_id = $ticket["user_id"];
  $title = ($zen->types["$tid"] == "Project")? strtoupper($zen->getSetting("system_name")). " PROJECT REPORT" : strtoupper($zen->getSetting("system_name"))." ".strtoupper($zen->types["$tid"]). " REPORT";
  $ticketroj = ($zen->types["$tid"] == "Project")? 1 : '';
  if( $ticket["project_id"] ) {
     $parent = $zen->get_ticket($ticket["project_id"] );
  }

?>
<html>
<head>
<title><?=$title?></title>
</head>

<body onLoad="window.print()">
<table width=500 cellpadding=2 cellspacing=0 border=0>
<tr>
  <td colspan=4>
    <b><?=$title?></b>
  </td>
</tr>
<tr>
  <td colspan=4 height=10>&nbsp;</td>
</tr>
<tr>
  <td colspan=4>
    <b><?=$id?> - <?=$ticket["title"]?>
  </td>
</tr>
<? if( is_array($parent) ) { ?>
<tr>
  <td colspan=4 height=10>&nbsp;</td>
</tr>
<tr>
  <td>
	  <b><?php echo tr("Project"); ?>:</b>
  </td>
  <td colspan=3>
    <b><?=$parent["id"]?> - <?=$parent["title"]?>
  </td>
</tr>	  
<? } ?>
  
<tr>
  <td colspan=4 height=10>&nbsp;</td>
</tr>
<hr>  
<? if( $ticketroj ) { ?>

<tr>
  <td colspan=4>
	  <b><?php echo tr("TASKS FOR COMPLETION"); ?>:</b>
     <ul>
<? if( is_array($ticket["children"]) ) { ?>     
     <table width=400 cellpadding=2 cellspacing=0 border=1>
     <tr>
     <td>
     <b><?php echo tr("ID"); ?></b>
     </td>
     <td>
     <b><?php echo tr("Title"); ?></b>
     </td>
     <td>
     <b><?php echo tr("Status"); ?></b>
     </td>
     <td>
     <b><?php echo tr("ETC"); ?></b>
     </td>
     <td>
     <b><?php echo tr("ATC"); ?></b>
     </td>
     </tr>
     <?
       $total_etc = $total_wkd = 0;
       foreach($ticket["children"] as $a) {
	  if( $zen->types["$a[type_id]"] == "Project" ) {
	     list($a["est_hours"],$a["wkd_hours"]) = $zen->getProjectHours($a["id"]);
	  }
	  $total_etc += $a["est_hours"];
	  $total_wkd += $a["wkd_hours"];
	  $percent = $zen->percentWorked( $a["est_hours"], $a["wkd_hours"] );
	  if( strlen($percent) ) {
	     $percent = " ($percent%)";
	  }
	  print "<tr>\n";
	  print "\t<td>$a[id]</td>\n";
	  print "\t<td>$a[title]</td>\n";
	  print "\t<td>$a[status]</td>\n";
	  print ($a["est_hours"] > 0)? "\t<td>$a[est_hours]</td>\n" : "<td>&nbsp;</td>\n";
	  print ($a["wkd_hours"] > 0)? "\t<td>$a[wkd_hours]$percent</td>\n" : "<td>&nbsp;</td>\n";
	  print "</tr>\n";
       }
   ?>
     <tr>
     <td  colspan=3 align=right><b><?php echo tr("Totals"); ?></b></td>
     <td ><b><?=$total_etc?></b></td>
     <td ><b><?=$total_wkd?></b></td>
     </tr>
     </table>
     <?
     
  } else {
	 print tr("No Tasks Assigned to this Project");  
  }
?>
     </ul>
     </td>
     </tr>	  
<? } ?>
<tr>
  <td  width=50>
    <b><?=tr("Status")?>:</b>
  </td>
  <td  width=150>
  <?=($ticket["status"])? $ticket["status"] : "ARCHIVED"; ?>
  </td>
  <td  width=50>
    <b><?=tr("Bin")?>:</b>
  </td>
  <td  width=250>
    <?=$zen->bins["$ticket[bin_id]"]?>
  </td>
</tr>
<tr>
  <td >
    <b><?=tr("Priority")?>:</b>
  </td>
  <td>
  <?=($ticket["priority"])? $zen->priorities["$ticket[priority]"] : "none"; ?>
  </td>
  <td >
    <b><?=tr("Type")?>:</b>
  </td>
  <td >
    <?=$zen->types["$ticket[type_id]"]?>
  </td>
</tr>
<tr>
  <td >
    <b><?=tr("Created")?>:</b>
  </td>
  <td>
  <?=($ticket["otime"])? $zen->showDateTime($ticket["otime"],'M') : "n/a"?>
  </td>
  <td >
    <b><?=tr("System")?>:</b>
  </td>
  <td >
    <?=$zen->systems["$ticket[system_id]"]?>
  </td>
</tr>
<tr>
  <td >
    <b><?=tr("Elapsed")?>:</b>
  </td>
  <td>
  <?=round($zen->dateDiff($ticket["ctime"],$ticket["otime"],'hours'),1)?> hours
  </td>
  <td >
    <b><?=tr("Est Hrs")?>:</b>
  </td>
  <td >
    <?=($ticket["est_hours"] > 0)? "$ticket[est_hours]" : "n/a"; ?>
  </td>
</tr>
<tr>
  <td>
    <b><?=tr("Worked")?>:</b></td>
  </td>
  <td>
    <?=($ticket["wkd_hours"]> 0)? "$ticket[wkd_hours]" : "n/a"; ?>
  </td>
  <td>
    <b>% <?=tr("Est Hrs")?>:</b>
  </td>
  <td>
    <?=$zen->percentWorked($ticket["est_hours"],$ticket["wkd_hours"])."% complete"; ?>
  </td>
</tr>
<tr>
  <td colspan=4 height=10>&nbsp;</td>
</tr>  
  
<tr>
  <td  colspan=4>
    <hr>
    <b><?php echo tr("DESCRIPTION"); ?></b>
    <ul>
      <?
        $d = $ticket["description"];
        if (get_magic_quotes_runtime()) {
           $d = stripslashes($d);
        }
        $d = nl2br($zen->ffv($d));
        
        echo $d;
      ?>
    </ul>
  </td>
</tr>
  
<tr>
  <td colspan=4>
	<hr>
	  <b><?php echo tr("RELATED TICKETS"); ?>:</b>
     <ul>
<?
  if( $ticket["related"] ) {
     $rel = explode(",",$ticket["related"]);
     foreach($rel as $r) {
	$t = $zen->get_ticket($r);
	print "$t[id] - $t[title] ($rootUrl/ticket.php?id=$t[id])<br>\n";
     }
  } else {
     print tr("No Related Tickets");  
  }
?>
	  </ul>
  </td>
</tr>	  

<tr>
  <td >
    <b><?php echo tr("Testing"); ?>:</b>
  </td>
  <td  colspan=3>
    <?
      if( !$ticket["tested"] ) {
	 print tr("Not Required");
      } else {
	 print ($ticket["tested"] == 1)? tr("Required") : tr("Completed");	
      }
    ?>
  </td>
</tr>

<tr>
  <td >
    <b><?php echo tr("Approval"); ?>:</b>
  </td>
  <td  colspan=3>
  <?
    if( !$ticket["approved"] ) {
       print tr("Not Required");
    } else {
       print ($ticket["approved"] == 1)? tr("Required") : tr("Completed");	
    }
  ?>
  </td>
</tr>

<tr>
  <td colspan=4 height=10>&nbsp;</td>
</tr>  
  
<tr>
  <td colspan=4>
    <b><?php echo tr("LOG"); ?></b>
    <ul>
<?
  $logs = $zen->get_logs($id);
  if( !is_array($logs) ) {
     print tr("No Log Entries");	  
  } else {
     foreach( $logs as $l ) {
	$e = $l["entry"];
   if (get_magic_quotes_runtime()) {
       $e = stripslashes($e);
   }
   $e = nl2br($zen->ffv($e));
   print ($l["entry"])? 
	  $zen->showDateTime($l["created"])."  "
	  .$l["action"]."-"
	  .$zen->formatName($l["user_id"])
	  ."-".$zen->bins["$l[bin_id]"]
	  .":<br><i>".$e."</i><P>"
	  : 
	  $zen->showDateTime($l["created"])."  "
	  .$l["action"]."-"
	  .$zen->formatName($l["user_id"])
	  ."-".$zen->bins["$l[bin_id]"]."<P>";
     }                 
  }
?>
    </ul>
  </td>
</tr>
</table>
  
</body>
</html>
