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
  <table width="100%" cellspacing='1' cellpadding='2' bgcolor='<?php echo $zen->getSetting("color_alt_background"); ?>'>
  <tr><td class='titleCell' colspan="8" align='center'><?php echo $c?></td></tr>
  <tr bgcolor="<?php echo $zen->getSetting("color_title_background"); ?>">
  <td width="32" height="25" valign="middle" title="<?php echo tr("ID of the ticket"); ?>">
  <div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>"><b><span class="small"><?php echo tr("ID"); ?></span></b></span></div>
  </td>
  <td width="32" height="25" valign="middle" title="<?php echo tr("Date log was created"); ?>">
  <div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>">
  <b><span class="small"><?php echo tr("Date"); ?></span></b></span>
  </div>
  </td>
  <?php if( !$search_params["action"] || is_array($search_params["action"]) ) { ?>
    <td width="32" height="25" valign="middle" title="<?php echo tr("Action Taken"); ?>">
    <div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>">
    <b><span class="small"><?php echo tr("Action"); ?></span></b></span></div>
    </td>
  <?php } ?>
  <?php if( !$search_params["user_id"] || is_array($search_params["user_id"]) ) { ?>
    <td width="32" height="25" valign="middle" title="<?php echo tr("Person ticket is assigned to"); ?>">
    <div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>">
    <b><span class="small"><?php echo tr("User"); ?></span></b></span></div>
    </td>
  <?php } ?>
  <?php if( !$search_params["bin_id"] || is_array($search_params["bin_id"]) ) { ?>
    <td width="32" height="25" valign="middle" title="<?php echo tr("Bin ticket is located in"); ?>">
    <div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>">
    <b><span class="small"><?php echo tr("Bin"); ?></span></b></span></div>
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
    <tr style="background:<?php echo $row?>;color:<?php echo $text?>" 
        onClick='ticketClk("<?php echo $link?>?id=<?php echo $t["ticket_id"]?>")'
        <?php echo $txt?>
        <?php echo $td_ttl?>>
    <td height="25" valign="middle">
        <?php echo $t["ticket_id"]?>
    </td>
    <td height="25" valign="middle">
    <a class="rowLink" style="color:<?php echo $text?>" 
    href="<?php echo $link?>?id=<?php echo $t["ticket_id"]?>"><?php echo $zen->showDate($t["created"]); ?></a>
    </td>
    <?php if( !$search_params["action"] || is_array($search_params["action"]) ) { ?>
      <td height="25" valign="middle">
      <?php echo $t["action"]?>
      </td>
    <?php } ?>
    <?php if( !$search_params["user_id"] || is_array($search_params["user_id"]) ) { ?>
      <td height="25" valign="middle">
      <?php echo $zen->formatName($t["user_id"]); ?>
      </td>
    <?php } ?>
    <?php if( !$search_params["bin_id"] || is_array($search_params["bin_id"]) ) { ?>
      <td height="25"  valign="middle">
      <?php echo $zen->bins["$t[bin_id]"]?>
      </td>
    <?php } ?>
    </tr>       
    <?php if( trim($t["entry"]) ) { ?>
      <tr style="background:<?php echo $row?>;color:<?php echo $text?>">
      <td height="25" colspan="8" <?php echo $td_ttl?> <?php echo $txt?>>
      <a class="rowLink" href='<?php echo $link?>?id=<?php echo $t["ticket_id"]?>'>
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
  <form method="post" action="<?php echo $SCRIPT_NAME?>">
  <td colspan="8" class="titleCell">
  <input type="submit" class="smallSubmit" value="<?php echo tr("Modify Search"); ?>">
  <input type="hidden" name="search_text" value="<?php echo strip_tags($search_text); ?>">
  <input type="hidden" name="search_fields[title]" value="<?php echo strip_tags($search_fields["title"]); ?>">
  <input type="hidden" name="search_fields[entry]" value="<?php echo strip_tags($search_fields["entry"]); ?>">
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
