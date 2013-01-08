<?
  if( !ZT_DEFINED ) { die("Illegal access"); }

  /**
   PREREQUISITES:
     (ZenFieldMap)$map - contains properties for fields
     (string)$view - the current view (probably project_list or ticket_list)
     (string)$page_type - (optional) either 'ticket' or 'project'
     (array)$tickets - list of tickets to be displayed, as retrieved from zenTrack::get_tickets()
  **/
  
$right_aligned = '@^(elapsed|est_hours|wkd_hours|custom_number)@';
  
$show_totals = $map->getViewProp($view, 'show_totals');
if( !$page_type )
  $page_type = "ticket";

if( $view == 'contact_list' || $view == 'assigned_list' ) { $fields = $map->getFieldMap('ticket_list'); }
else { $fields = $map->getFieldMap($view); }
if( $view == 'search_list' ) {
  $atc = $total_search_results;
}
else {
  $atc = 0;
}

// creates the $sortby variable describing how columns will be sorted
include_once("$libDir/sorting.php");

// create ticket list using filters (if applicable)
if( $view == 'ticket_list' || $view == 'project_list' ) {
  $sm =& $zen->getSessionManager();
  // creates the $params array specifying how we will filter tickets
  include("$libDir/listFilters.php");
  // retrieves the list of tickets filtered and sorted
  $tickets = $zen->get_tickets($filter_params,$sortstring);
  // total records in list
  $atc = $zen->total_records;
  // create the form for filtering results
  include("$templateDir/listFiltersForm.php");
}

if( $view == 'contact_list' ) { $view = 'ticket_list'; }  //temporary fix
if( $view == 'assigned_list' ) { $view = 'ticket_list'; } //temporary fix

if( $ticket && !$atc ) {
  if( isset($ticket['total_children']) ) {
    $atc = $ticket['total_children'];
  }
}

$locale = localeconv();
$dec = $locale['decimal_point'];
$sep = $locale['thousands_sep'];
$len = $zen->getSetting('worked_hours_decimal');
$cols = 0;
$est_col = 0;
$wkd_col = 0;

if( is_array($tickets) && count($tickets) ) {
  $c = count($tickets);
  foreach($fields as $f=>$field) {
    if ( $field['is_visible'] ) {
      $cols++;
      if( $f == 'est_hours' ) { $est_col = $cols; }
      else if( $f == 'wkd_hours' ) { $wkd_col = $cols; }
    }
  }
  
  if( $show_totals ) { $cols++; }

  $numtoshow = $zen->getSetting('paging_max_rows');
  $pageNumber = array_key_exists('pageNumber', $_GET)?
                $zen->checkNum($_GET['pageNumber']) : 0;

  /***
  $ata = NULL;
  if ( strpos($view,"search_list")===0 ) {
    $ata = $zen->search_tickets($params, "AND", "0", join(',',$orderby), 0) ;
    if (is_array($ata)) {
      $atc = count($ata);
      unset($ata);
    } else {
      $atc= 0;
    }
  } else {
    $atc = $zen->count_tickets($params);
  }
  ***/
  if ( $atc > 0 ) {
    $t_from = $pageNumber*$numtoshow+1;
    $t_to = $t_from + $c -1;
  } else {
    $t_from = 0;
    $t_to = 0;
  }
  
?>
<script type='text/javascript'>
function resortListPage( sortName ) {
<? if( strpos($view, 'search')===0 ) { ?>
  document.searchModifyForm.newsort.value = sortName;
  document.searchModifyForm.TODO.value = 'SEARCH';
  document.searchModifyForm.submit();
  return false;
<? } else { ?>
  var s = window.location.href;
  if( s.indexOf('newsort=') > 0 ) {
    s = s.replace(/newsort=[^&]+/, "newsort="+sortName);
  }
  else {
    s += s.indexOf('?') > 0? '&newsort='+sortName : '?newsort='+sortName;
  }
  window.location = s;
<? } ?>
}
</script>
<table width="100%" class='formTable' cellspacing='1' cellpadding='2'>
<?
$atc_text = $atc > 1? tr("Tickets ?-? of ?",array($t_from,$t_to,$atc)) : "";  
if( $view == 'search_list' ) {
  print "<tr><td colspan='$cols' class='subTitle' align='center'>".tr("Search Results");
  if( $atc_text ) { print " ($atc_text)"; }
  print "</td></tr>";
}
else if( $view == 'project_tasks' ) {
  print "<tr><td colspan='$cols' class='subTitle' align='center'>".tr("Tasks for this project")
    .($atc_text? " ($atc_text)":"")."</td></tr>";
}
else if ($atc_text) {
  print "<tr><td class='subTitle' colspan='$cols' align='center'>$atc_text</td></tr>\n";
}
else {
  print "<tr><td class='subTitle' colspan='$cols' align='center'>".tr("Ticket List")
      .($atc_text? " ($atc_text)":"")."</td></tr>\n";
}
?>
   <tr>
<?
  // print some table headings
  $custom_field_list = array(); //store these for later
  foreach($fields as $f=>$field) {
    // skip hidden fields
    if( !$field['is_visible'] ) { continue; }

    $tf = tr($map->getLabel($view,$f));
    $sn = in_array($f, $orderby)? "$f DESC" : $f;
    print "<td valign='middle' ";
    if( getFmFieldProps($view, $f) ) {
      print "onclick='resortListPage(\"$sn\")' $heading_rollover ";
    }
    print " title='".$zen->ffv($tf)."' class='headerCell'>$tf</td>\n";
    
    // store information about field types
    if( strpos($f, 'custom_') === 0 && $field['is_visible'] ) {
      $custom_field_list[] = $f;
    }
  }
  
  if( $show_totals ) {
    ?>
      <td width="40" height="25" valign="middle" title="<?=tr("Percent completed")?>" class='headerCell'>
        <?=tr("%")?>
      </td>
    <?    
  }
  
  // close the row
  print "</tr>\n";

  // we will now cache a list of users, if needed, to prevent multiple database
  // lookups from being performed
  $user_ids = array();
  $has_user_ids = array_key_exists('user_id', $fields) && $fields['user_id']['is_visible'];
  $has_creator_ids = array_key_exists('creator_id', $fields) && $fields['creator_id']['is_visible'];
  $ticket_ids = array();
  $custom_fields = array();
  if( $has_user_ids or $has_creator_ids || count($custom_field_list) ) {
    foreach($tickets as $t) {
      if( count($custom_field_list) ) { $ticket_ids[] = $t['id']; }
      if( $has_user_ids && $t['user_id'] ) { $user_ids[] = $t['user_id']; }
      if( $has_creator_ids && $t['creator_id'] ) { $user_ids[] = $t['creator_id']; }
    }
    
    // now query for the user ids and map them to keys which we will store
    // for use while rendering all of the rows
    if( count($user_ids) ) {
      $query = "SELECT user_id, initials FROM ".$zen->table_users." WHERE user_id in (".join(',', array_unique($user_ids)).")";
      $vals = $zen->db_query($query);
      if( $vals && count($vals) ) {
        $user_ids = array();
        foreach($vals as $v) {
          $user_ids["{$v[0]}"] = $v[1];
        }
      }
      else {
        // default to no entries
        $user_ids = array();
      }
    }
    
    // now query for variable field content as needed
    if( count($custom_field_list) && count($ticket_ids) ) {
      $custom_fields = $zen->getVarfieldsForTickets($ticket_ids, $custom_field_list);
    }
  }

   $td_ttl = "title='".tr("Click here to view the ?", array(tr(ucfirst($page_type))))."'";
   $ttl_est = 0;
   $ttl_wkd = 0;
   $ttl_ext = "";
   foreach($tickets as $t) {
     $est = null;
     $wkd = null;
     $per = "n/a";
     if( $show_totals ) {
        // calculate the total hours
        // and format the ticket's hours
        list($est,$wkd,$ext) = $zen->getTicketHours($t["id"]);
        $ttl_est += $est;
        $ttl_wkd += $wkd;
        $ttl_ext += $ext;
        if( !strlen($est) )
          $est = "n/a";
        if( $wkd <= 0 ) { $wkd = 0; }
        if( $est > 0 ) {
          $per = round($zen->percentWorked($est,$wkd),1).tr("%");
        }
     }

      // create special url for projects
      if( $zen->inProjectTypeIDs($t["type_id"]) ) {
         $link = $projectUrl;
      } else {
         $link = $ticketUrl;   
      }
      
      // determine the color of the row based on priority or status
      if( $t["status"] == 'CLOSED' ) {
        $classxText = "class='bars' onclick='ticketClk(\"{$link}?id={$t['id']}\"); return false;' $rollover_greytext";
      }
      else if( $zen->getSetting("priority_medium") ) {
        $classxText = "class='priority{$t['priority']}' "
         ."onclick='ticketClk(\"{$link}?id={$t['id']}\"); return false;' "
         ."onMouseOver='if(window.document.body && mClassX){mClassX(this, \"priority{$t['priority']}Over\", true);}' "
         ."onMouseOut='if(window.document.body && mClassX){mClassX(this, \"priority{$t['priority']}\", false);}'";
      }
      else {
        $classxText = "class='cell' onclick='ticketClk(\"{$link}?id={$t['id']}\"); return false;' $rollover_text";
      }
      
      // render the row properties
      print "<tr $classxText>\n";
      
      // render each field in the row
      foreach($fields as $f=>$field) {
        // skip hidden fields
        if( !$field['is_visible'] ) { continue; }
        $align = preg_match($right_aligned, $f)? 'align="right"' : '';
        print "<td height='25' valign='middle' $align $td_ttl>";
        print "<a class='rowLink' href='$link?id={$t['id']}'>";
        if( $f == 'user_id' || $f == 'creator_id' ) {
          $uid = $t["$f"];
          $name = $zen->ffv($user_ids["$uid"], $field['num_cols']);
          print $name? $name : '&nbsp;';
        }
        else if( $f == 'elapsed' ) {
          print $zen->showTimeElapsed($t["otime"],$t["ctime"],1,1);
        }
        else {
          $value = strpos($f, 'custom_')===0? $custom_fields[$t["id"]][$f] : $t[$f];
          $val = $map->getTextValue($view, $f, $value);
          if( $view == 'search_list' && is_array($search_fields) && array_key_exists($f, $search_fields) ) {
            $val = $zen->highlight( $val, $search_text );
          }
          print $val;
        }
        print "</a></td>\n";
      }
      
      if( $show_totals ) {
        print "<td align='right'>$per</td>";
      }
      
      // close the row
      print "</tr>";
   }
   
   if( $show_totals ) {
     $totals_titlebar_txt = !$atc || $atc <= count($tickets)? tr("Grand Total") : tr('Subtotal');
     include("$templateDir/totalsBar.php");
   }
   
   if( $atc && $atc > count($tickets) ) {
     $hotkeys->loadSection('paging');
     $GLOBALS['zt_hotkeys'] = $hotkeys;
     if( $show_totals ) {
       $totals_titlebar_txt = tr("Grand Total");
       list($ttl_est,$ttl_wkd,$ttl_ext) = $zen->getTicketHours($id);
       include("$templateDir/totalsBar.php");
     }
?>

<!--- BEGIN Paging --->
<tr>
   <td  align="right" valign='bottom' colspan='<?=$cols?>' class='subTitle'>
     <?
       $links = $zen->get_links("all", "off", $atc);
       for ($y = 0; $y < count($links); $y++) {
          echo $links[$y] . "&nbsp;&nbsp;";
       }
     ?>
   </td>
</tr>
<!--- END Paging --->

<?
   }


   if( strpos($view, 'search')===0 ) {
?>
   <tr>
       <td colspan="<?= $cols ?>" class="subTitle">
       <nobr>
       <form method="post" action="search.php" name='searchModifyForm' style="display: inline; margin: 0px;">
          <input type="submit" class="smallSubmit" value="<?=tr("Modify Search")?>">
          <input type='hidden' name='TODO' value=''>
          <input type='hidden' name='newsort' value=''>
          <input type="hidden" name="search_text" value="<?=$zen->ffv($search_text)?>">
          <?
          if( is_array($search_params) ) {
           foreach($search_params as $k=>$v) {
             if( is_array($v) ) {
               foreach($v as $val) {
                 print "<input type='hidden' name='search_params[$k][]' value='".$zen->ffv($val)."'>\n";
               }
             }
             else {
               print "<input type='hidden' name='search_params[$k]' value='".$zen->ffv($v)."'>\n";
             }
           }
           foreach($search_dates as $k=>$v) {
             print "<input type='hidden' name='search_dates[$k]' value='".$zen->ffv($v)."'>\n";
           }
           foreach($search_fields as $k=>$v) {
             print "<input type='hidden' name='search_fields[$k]' value='".$zen->ffv($v)."'>\n";
           }
           if( $or_higher ) {
             print "<input type='hidden' name='or_higher' value='1'>\n";
           }
          }
           ?>
     </form>
     <form method="post" action="exportSearch.php" style="display: inline; margin: 0px;">
          <input type="submit" class="smallSubmit" value="<?=tr("Export Results")?>">
          <input type="hidden" name="search_text" value="<?=$zen->ffv($search_text)?>">
          <?
          if( is_array($search_params) ) {
           foreach($search_params as $k=>$v) {
             if( is_array($v) ) {
               foreach($v as $val) {
                 print "<input type='hidden' name='search_params[$k][]' value='".$zen->ffv($val)."'>\n";
               }
             }
             else {
               print "<input type='hidden' name='search_params[$k]' value='".$zen->ffv($v)."'>\n";
             }
           }
         }
         if( is_array($search_dates) ) { 
           foreach($search_dates as $k=>$v) {
             print "<input type='hidden' name='search_dates[$k]' value='".$zen->ffv($v)."'>\n";
           }
         }
         if( is_array($search_fields) ) {
           foreach($search_fields as $k=>$v) {
             print "<input type='hidden' name='search_fields[$k]' value='".$zen->ffv($v)."'>\n";
           }
         }
         if( $or_higher ) {
           print "<input type='hidden' name='or_higher' value='1'>\n";
         }
         ?>
        </nobr>
       </form>
     </td>
   </tr>
<?
   }

   print "</table>\n";
   
} else {
  print "<p>&nbsp;</p><ul><b>".tr("No tickets were found").".</b></ul>";
}
  
?>
