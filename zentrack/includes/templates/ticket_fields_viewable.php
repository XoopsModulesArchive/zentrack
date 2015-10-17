<?php if( !ZT_DEFINED ) { die("Illegal Access"); }

  /*
  **  FIELDS VIEW
  **
  **  Renders fields in ticket view window.
  **
  **  REQUIREMENTS:
  *   $map - instance of ZenFieldMap
  *   $zen - instance of ZenTrack
  *   $boxview - (string)view to be loaded from field map
  *   $ticket - values for all columns in the ticket we are viewing
  */

  $columns = $map->getViewProp($boxview,'columns');
  $width = $map->getViewProp($boxview,'width');
  $fields = $map->listFieldsForView($boxview);
  
  if( !$columns ) { print "No columns specified for view."; $fields = array(); }
  
  $i = 0;
  while( $i < count($fields) ) {
    // collect items for this row
    $vals = array();
    for($j = 0; $j < $columns && $i < count($fields); ) {
      // collect field info
      $f = $fields[$i];
      $field = $map->getFieldFromMap($boxview, $f);
      
      // skip hidden fields but don't add a column
      if( !$field['is_visible'] ) { $i++; continue; }

      if( $field['field_type'] == 'section' && $f != 'elapsed' ) {
        // sections become gaps here
        $label = '';
        $value = '';
      }
      else if( $f == 'elapsed' ) {
        $label = $map->getLabel($boxview, $f);
        $value = $zen->showTimeElapsed($otime,$ctime,1,0);
      }
      else {
        $label = $map->getLabel($boxview, $f);
        $val = array_key_exists($f, $varfields)? $varfields[$f] : $ticket[$f];
        $value = $map->getTextValue($boxview, $f, $val);
      }
      $vals[] = array('label'=>$label, 'value'=>$value);

      // increment values if we make it this far
      $j++;
      $i++;
    }
    
    // open row
    print "<table cellpadding='0' cellspacing='0'>\n";
    
    // print headings
    print "<tr>";
    foreach($vals as $v) {
      if( $v['label'] == '' && $v['value'] == '' ) {
        // this is a gap
        print "<td rowspan='2' class='propSpace'>&nbsp;</td>\n";
      }
      else {
        $w = $width? "width=$width" : "";
        print "<td class='propLabel' $w><nobr>".$zen->ffv($v['label'])."</nobr></td>\n";
        print "<td width='2'><img src='$imageUrl/empty.gif' width='2' height='1'></td>\n";
      }
    }
    print "</tr>";
    
    // print cells
    print "<tr>";
    foreach($vals as $v) {
      if( $v['label'] == '' && $v['value'] == '' ) {
        // this is a gap
        continue;
      }
      else {
        print "<td class='propContent'>{$v['value']}</td>";
        print "<td width='2'><img src='$imageUrl/empty.gif' width='2' height='1'></td>\n";
      }
    }
    print "</tr>";
    
    // close row
    print "</table>&nbsp;\n";
  }

?>
