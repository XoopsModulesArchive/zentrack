<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }


if( is_array($logs) && count($logs) ) {
  
  $link = $zen->getSetting("url_view_ticket");
  $c = count($logs);
  $pageNumber = array_key_exists('pageNumber', $_GET)?
  $zen->checkNum($_GET['pageNumber']) : 0;
  $first = ($zen->getSetting('paging_max_rows') * $pageNumber) + 1; //added line
  $last = $c + $ll - 1; //added line
  if( $last > $zen->total_records ) { $last = $zen->total_records; }
  $c = tr("Matches ?-? of ?", array($first,$last,$zen->total_records)); //added line
  ?>
  <table width="100%" cellspacing='1' cellpadding='2' bgcolor='<?=$zen->getSetting("color_alt_background")?>'>
  <tr><td class='titleCell' colspan="8" align='center'><?=$c?></td></tr>
  <tr bgcolor="<?=$zen->getSetting("color_title_background")?>">
  <td width="32" height="25" valign="middle" title="<?=tr("ID of the ticket")?>">
  <div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>"><b><span class="small"><?=tr("ID")?></span></b></span></div>
  </td>
  <td width="32" height="25" valign="middle" title="<?=tr("Date log was created")?>">
  <div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>">
  <b><span class="small"><?=tr("Date")?></span></b></span>
  </div>
  </td>
  <?php if( !$search_params["action"] || is_array($search_params["action"]) ) { ?>
    <td width="32" height="25" valign="middle" title="<?=tr("Action Taken")?>">
    <div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>">
    <b><span class="small"><?=tr("Action")?></span></b></span></div>
    </td>
  <?php } ?>
  <?php if( !$search_params["user_id"] || is_array($search_params["user_id"]) ) { ?>
    <td width="32" height="25" valign="middle" title="<?=tr("Person ticket is assigned to")?>">
    <div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>">
    <b><span class="small"><?=tr("User")?></span></b></span></div>
    </td>
  <?php } ?>
  <?php if( !$search_params["bin_id"] || is_array($search_params["bin_id"]) ) { ?>
    <td width="32" height="25" valign="middle" title="<?=tr("Bin ticket is located in")?>">
    <div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>">
    <b><span class="small"><?=tr("Bin")?></span></b></span></div>
    </td>
  <?php } ?>
  </tr>
  <?php
  
  $td_ttl = "title='".tr("Click here to view this ticket.")."'";
  foreach($logs as $t) {
    unset($txt);
    unset($est);
    
    if( $row == $zen->getSetting("color_background") ) {
      $row = $zen->getSetting("color_bars");
      $txt = $hotrollover_greytext;
      $text = $zen->getSetting("color_bar_text"); 
    } else {
      $row = $zen->getSetting("color_background");
      $txt = $hotrollover_text;
      $text = $zen->getSetting("color_text");
    }
    ?>
    <tr style="background:<?=$row?>;color:<?=$text?>" 
        onClick='ticketClk("<?=$link?>?id=<?=$t["ticket_id"]?>")'
        <?=$txt?>
        <?=$td_ttl?>>
    <td height="25" valign="middle">
        <?=$t["ticket_id"]?>
    </td>
    <td height="25" valign="middle">
    <a class="rowLink" style="color:<?=$text?>" 
    href="<?=$link?>?id=<?=$t["ticket_id"]?>"><?=$zen->showDate($t["created"])?></a>
    </td>
    <?php if( !$search_params["action"] || is_array($search_params["action"]) ) { ?>
      <td height="25" valign="middle">
      <?=$t["action"]?>
      </td>
    <?php } ?>
    <?php if( !$search_params["user_id"] || is_array($search_params["user_id"]) ) { ?>
      <td height="25" valign="middle">
      <?=$zen->formatName($t["user_id"])?>
      </td>
    <?php } ?>
    <?php if( !$search_params["bin_id"] || is_array($search_params["bin_id"]) ) { ?>
      <td height="25"  valign="middle">
      <?=$zen->bins["$t[bin_id]"]?>
      </td>
    <?php } ?>
    </tr>       
    <?php if( trim($t["entry"]) ) { ?>
      <tr style="background:<?=$row?>;color:<?=$text?>">
      <td height="25" colspan="8" <?=$td_ttl?> <?=$txt?>>
      <a class="rowLink" href='<?=$link?>?id=<?=$t["ticket_id"]?>'>
          <?php
      $t["entry"] = $zen->ffv($t["entry"]);
      $parts = explode("\n",$t["entry"]);
      if( $search_text ) {
        unset($pt);
        for($i=0; $i<count($parts); $i++) {
          $p = $parts[$i];
          if( eregi($search_text, stripslashes($p)) ) {
            $pt .= ($pt)? "<br>\n" : ""; 
            $pt .= $zen->highlight(stripslashes($p),$search_text);
          }
        }
      } else {
        $pt = substr($t["entry"],0,100);
      }
      print $pt;        
      ?>
      </a>
      </td>
      </tr>
      <?php
    }
  }
  ?>
  <tr>
  <form method="post" action="<?=$SCRIPT_NAME?>">
  <td colspan="8" class="titleCell">
  <input type="submit" class="smallSubmit" value="<?=tr("Modify Search")?>">
  <input type="hidden" name="search_text" value="<?=strip_tags($search_text)?>">
  <input type="hidden" name="search_fields[title]" value="<?=strip_tags($search_fields["title"])?>">
  <input type="hidden" name="search_fields[entry]" value="<?=strip_tags($search_fields["entry"])?>">
      <?php
  foreach($search_params as $k=>$v) {
    print "<input type='hidden' name='search_params[$k]' value='".strip_tags($v)."'>\n";
  }
  ?>
  </td>
  </form>
  </tr>
  </table>
  <?php
}

?>
