<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  
if( is_array($tickets) ) {
 
      ?>
        <table width="100%" class='formtable' cellspacing='1'>
   <tr bgcolor="<?=$zen->getSetting("color_title_background")?>">
   <td width="32" height="25" valign="middle" title="<?=tr("ID of the ?",array($page_type))?>">
     <div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>"><b><span class="small"><?=tr("ID")?></span></b></span></div>
   </td>
   <td height="25" valign="middle" title="<?=tr("Name of the ?",array($page_type))?>">
     <div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>"><b><span class="small"><?=tr("Title")?></span></b></span></div>
   </td>
   <td width="32" height="25" valign="middle" title="<?=tr("Importance of the ?",array($page_type))?>">
     <div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>"><b><span class="small"><?=tr("Pri")?></span></b></span></div>
   </td>
   <td width="32" height="25" valign="middle" title="<?=tr("The type of ticket")?>">
     <div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>"><b><span class="small"><?=tr("Type")?></span></b></span></div>
   </td>
   <td width="40" height="25" valign="middle" title="<?=tr("Who the ? belongs to",array($page_type))?>">
     <div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>"><b><span class="small"><?=tr("Owner")?></span></b></span></div>
   </td>
        <td width="40" height="25" valign="middle" title="<?=tr("Estimated time to complete")?>">
     <div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>"><b><span class="small"><?=tr("Status")?></span></b></span></div>
        </td>     
        <td width="40" height="25" valign="middle" title="The estimated time to complete this <?=$page_type?>">
     <div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>"><b><span class="small"><?=tr("Est Hrs")?></span></b></span></div>
        </td>
        <td width="40" height="25" valign="middle" title="<?=tr("Amount of time worked")?>">
     <div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>"><b><span class="small"><?=tr("Worked")?></span></b></span></div>     
        </td>     
        <td width="40" height="25" valign="middle" title="<?=tr("Percent completed")?>">
          <div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>"><b><span class="small"><?=tr("%")?></span></b></span></div>     
        </td>
   </tr>
      <?php

   $td_ttl = "title='".tr("Click here to view the ?.",array($page_type))."'";
   $ttl_est = 0;
   $ttl_wkd = 0;
   $ttl_ext = "";
   $ttl_per = "";
   foreach($tickets as $t) {
      unset($txt);
      unset($tx);
      unset($est);
      unset($wkd);
      unset($per);
      
      if( $t["status"] == 'CLOSED' ) {
        $classxText = "class='bars' onclick='ticketClk(\"{$link}?id={$t['id']}\")' $rollover_greytext";
      }
      else if( $zen->getSetting("priority_medium") ) {
        $classxText = "class='priority{$t['priority']}' "
         ."onclick='ticketClk(\"{$link}?id={$t['id']}\")' "
         ."onMouseOver='if(window.document.body && mClassX){mClassX(this, \"priority{$t['priority']}Over\", true);}' "
         ."onMouseOut='if(window.document.body && mClassX){mClassX(this, \"priority{$t['priority']}\", false);}'";
      }
      else {
        $classxText = "class='cell' onclick='ticketClk(\"{$link}?id={$t['id']}\")' $rollover_text";
      }
      
      // calculate the total hours
      // and format the ticket's hours
      list($est,$wkd) = $zen->getTicketHours($t["id"]);
      $ttl_est += $est;
      $ttl_wkd += ($wkd > $est)? $est : $wkd;
      $ttl_ext += ($wkd > $est)? $wkd - $est : 0;
      if( !strlen($est) )
      $est = "n/a";
      if( $wkd <= 0 )
      $wkd = 0;
      if( $zen->inProjectTypeIDs($t["type_id"]) ) {   
        $link = $projectUrl;
      } else {
        $link = $ticketUrl;
      }
      if( $est > 0 )
      $per = round($zen->percentWorked($est,$wkd),1)."%";
   ?>
   <tr <?=$classxText?>>
   <td height="25" valign="middle" <?=$td_ttl?> <?=$txt?>>
    <a class="rowLink" style="color:<?=$text?>" 
      href="<?=$link?>?id=<?=$t["id"]?>"><?=$t["id"]?></a>
   </td>
   <td height="25" valign="middle" <?=$txt?> <?=$td_ttl?>>
    <a class="rowLink" style="color:<?=$text?>" 
      href="<?=$link?>?id=<?=$t["id"]?>"><?=$t["title"]?></a>
   </td>
   <td height="25" <?=$tx?> valign="middle">
     <?=$zen->priorities["$t[priority]"]?>
   </td>
    <td height="25" valign="middle">
      <?=$zen->types["$t[type_id]"]?>
    </td>
    <td width="40" height="25" valign="middle">
      <?=$zen->formatName($t["user_id"],2)?>
    </td>
    <td width="40" height="25" valign="middle">
      <?=$t["status"]?>
    </td>
    <td width="40" height="25" valign="middle" align="right">
      <?=$est?>
    </td>
    <td width="40" height="25" valign="middle" align="right">
      <?=$wkd?>
    </td>
    <td width="40" height="25" valign="middle" align="right">
      <?=($per)? $per : tr("n/a"); ?>
    </td>
    </tr>
   <?php
   }     
   if( $ttl_est ) {
     $ttl_per = $zen->percentWorked($ttl_est,$ttl_wkd);
   } else {
     $ttl_per = tr("n/a");
   }
   
   
   // extra hours summary
   if( $ttl_ext ) {
     $p = $zen->percentWorked( $ttl_per, $ttl_wkd+$ttl_ext );
     $pp = $ttl_per - $p;
     $p = round($p,1);
     $pp = round($pp,1);
     $ttl_per = round($ttl_per,1);
     print "<tr style='background:".$zen->getSetting("color_bars").";color:".$zen->getSetting("color_bar_text").";'>\n";
     print "<td colspan='6' align='right'><b>".tr("Actual Hours").":</b>&nbsp;&nbsp;</td>\n";
     print "<td align='right'><b>$ttl_est</b></td>\n";
     print "<td align='right'><b>".($ttl_ext+$ttl_wkd)."</b></td>\n";
     print "<td align='right'><b>$p%</b></td>\n";
     print "</tr>\n";            
     print "<tr style='background:".$zen->getSetting("color_bars").";color:".$zen->getSetting("color_bar_text").";'>\n";
     print "<td colspan='6' align='right'><b>".tr("Hours over 100%").":</b>&nbsp;&nbsp;</td>\n";
     print "<td align='right'><b>&nbsp;</b></td>\n";
     print "<td align='right'><b>&#150; $ttl_ext</b></td>\n";
     print "<td align='right'><b>$pp%</b></td>\n";
     print "</tr>\n";      
   }
   
   // totals summary
   print "<tr style='background:".$zen->getSetting("color_title_background").";color:".$zen->getSetting("color_title_text").";'>\n";
   print "<td colspan='6' align='right'><b>".tr("Totals").":</b>&nbsp;&nbsp;</td>\n";
   print "<td align='center'><b>$ttl_est</b></td>\n";
   print "<td align='center'><b>$ttl_wkd</b></td>\n";
   print "<td align='center'><b>$ttl_per%</b></td>\n";
   print "</tr>\n";
   
   print "</table>\n";
   
} else {
   if( $login_bin )
     print "<p>&nbsp;</p><ul><b>".tr("No open ?s in ?", array($type_id,$bin_id)).".</b></ul>";
   else
     print "<p>&nbsp;</p><ul><b>".tr("No ?s were found", $type_id).".</b></ul>";
}
  
?>

