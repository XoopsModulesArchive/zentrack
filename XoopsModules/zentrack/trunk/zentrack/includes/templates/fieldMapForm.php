<? if( !ZT_DEFINED ) { die("Illegal Access"); }

/**
  PREREQUISITES:
    $map - (ZenFieldMap) map object which can be used to retrieve default values
    $zen - (ZenTrack)
**/
 
 $loads = ZenFieldMap::getLoadOptions($templateDir);
 $fields = $map->getFieldMap($view);
 
/**
 * Generate a pulldown menu containing valid choices for pre/post load options
 */
 function renderViewPropField( $view, $vals ) {
   global $libDir;
   global $zen;
   global $loads;
   global $map;
   $field = $vals['vm_name'];
   $val = $map->getViewProp($view, $field);
   $type = $vals['vm_type'];
   switch( $type ) {
     case "load":
       print "<select name='{$field}[]' multiple size=5>";
       foreach($loads as $o) {
         $c = $val && in_array($o,$val)? ' selected' : '';
         print "<option value='$o'$c>".tr(ucfirst($o))."</option>";
       }
       print "</select>";
       break;       
     case "access":
       print "<select name='$field'>";
       foreach( array('level_view','level_user','level_edit',
                      'level_edit_varfields','level_test','level_approve',
                      'level_super','level_contacts') as $l ) {
         $c = $l == $val? ' selected' : '';
         print "<option value='$l'$c>$l</option>";
       }
       print "</select>";
       break;
     case "text":
       print "<input type='text' name='$field' value='".$zen->ffv($val)."' size='20'>";
       break;
     case "label":
       if( $val == 1 || $val === 0 ) { $val = $val? 'Yes' : 'No'; }
       print $zen->ffv($val);
       break;
     case "checkbox":
       print "<input type='checkbox' name='$field' value='1'";
       if( $val ) { print " checked"; }
       print ">";
       break;
     default:
       print "&nbsp;";
   }
 }

?>
<form method='post' action='<?=$SCRIPT_NAME?>' name='viewPickForm'>
<input type='hidden' name='view' value='<?=$zen->ffv($view)?>'>
<table class='microTable'><tr><td width='150' valign='top'>
<p class='heading'><?=tr("Edit Field Map")?></p>
<p class='note'><?
   $str = "<a href='$rootUrl/help/find.php?s=admin&p=fieldmap'>".tr('Documentation')."</a>";
   print tr("Please refer to the ? before using this feature", array($str));
 ?></p>

<div class='bold'>Screen to Edit:</div>
<select name='view' size=20
  onchange="window.document.forms['viewPickForm'].submit()">
<?
$vp = $map->getViewProps();
foreach( $vp as $k=>$v ) {
  $sel = $view == $k? " selected" : "";
  $l = $map->getViewProp($k,'label')? $k." (".tr($map->getViewProp($k,'label')).")" : $k;
  print "<option value='$k'$sel>".$zen->ffv($l)."</option>\n";
}
?>
</select>

<p class='note'><?=tr("Do not switch views without saving changes!")?></p>


</form>
<form method='post' action='<?=$SCRIPT_NAME?>' name='fieldMapForm'>
<?
$fcount = 0;
foreach($fields as $f=>$field) {
  print "<input type='hidden' name='orderset[$f]' value='$fcount'>\n";
  $fcount++;
}
?>
<input type='hidden' name='TODO' value='save'>
<input type='hidden' name='view' value='<?=$zen->ffv($view)?>'>

<? if( $view ) { ?>
<input type='submit' value='<?=uptr('save')?>' onClick="return setTodo('save');">
&nbsp;
<input type='submit' class='submitPlain' value='<?=tr('Reset')?>' onClick="return setTodo('reset');">
<? } ?>

</td><td>&nbsp;</td><td valign='top'>
&nbsp;


<?
if( !$view ) {
  print "<div class='heading'>Please choose a view to edit</div>";
  if( $page_browser == 'mz' ) {
    print "<p class='hot'>".tr("You are using a Mozilla/Firefox Browser");
    print "<br>".tr("Sorting and editing fields simultaneously has produced unreliable results in Mozilla.");
    print "<br>".tr("Until a fix is implemented, please sort rows and edit fields seperately.")."</p>\n";
  }
}
else {
?>
<table cellpadding='4' cellspacing='1' class='cell' border='0'>
  <tr toofar="toofar"><td colspan='10' align='center' class='subTitle'><?=tr("Properties for ?", $view)?></td></tr>
<?
foreach($map->getViewProps($view) as $v) {
  if( $v['vm_type'] == 'hidden' ) { continue; }
  print "<tr class='bars'><td colspan='2'>".$zen->ffv($v['vm_name'])."</td><td colspan='8'>";
  renderViewPropField($view, $v);
  print "</td></tr>\n";
}
?>
<tr toofar="toofar">
  <td class='subTitle' align='center' colspan='10'>
    <b><?=tr("Fields for ?", $view)?></b>
  </td>
</tr>
<?
if( !is_array($fields) || !count($fields) || !$map || !$view ){
  print "<tr><td colspan='10' class='bars'>".
     tr("This view has no fields")."</td></tr>\n";
}
else {
?>
<tr toofar="toofar" id="beforeFirstRow">
  <td class='headerCell' align='center'><b><?=tr("Options")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Name")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Label")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Show")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Required")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Default")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Type")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Columns")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Rows")?></b></td>
</tr>
<?
function fmfRow( $text, $class ) {
  print "<td class='$class'>{$text}</td>";
}

function fmfName( $field_name, $key ) {
  return " name='{$field_name}[$key]' ";
}

function fmfVal( $field, $key ) {
  global $zen;
  return $zen->ffv($field[$key]);
}

$prevSection = false;
$typeprops = getFmTypeProps();
foreach($fields as $f=>$field) {
  // retrive configurable settings from database
  //$field = $map->getFieldFromMap($view, $f);

  // convert varfield names using fieldName() method
  // and get special properties for fields
  $fprops = getFmFieldProps($view, ZenFieldMap::fieldName($f));
  $tprops = $typeprops[$field['field_type']];

  // generate row of information
  $s = $field['is_visible']? 'bold' : 'disabled';
  $class = $field['field_type'] == 'section'? "altBars $s" : "bars $s";
  print "<tr id='$f'>";

  // create options row
  $txt = '';
  // up arrow
  $txt .= "<a href='#' onClick='moveRowUp(this.parentNode);return false;'";
  $txt .= " border='0' alt='Move Up' title='Move Up'><img src='$rootUrl/images/icon_arrow_up.gif'";
  $txt .= " width='16' height='16' alt='Move Up' title='Move Up' border='0'></a>";
  // down arrow
  $txt .= "<a href='#' onClick='moveRowDown(this.parentNode);return false;'";
  $txt .= " border='0' alt='Move Down' title='Move Down'><img src='$rootUrl/images/icon_arrow_down.gif'";
  $txt .= " width='16' height='16' alt='Move Down' title='Move Down' border='0'></a>";
  // control sort ordering by tracking what order these hidden fields arrive
  if( $map->getViewProp($view, 'sections') ) {
    if( $field['field_type'] == 'section' && $field['field_name'] != 'elapsed' ) {
      // remove sections
      $txt .= "<a href='#' onClick='removeRow(this);return false;'";
      $txt .= " border='0' alt='Remove Section' title='Remove Section'><img src='$rootUrl/images/icon_trash.gif'";
      $txt .= " width='16' height='16' alt='Remove Section' title='Remove Section' border='0'></a>";
    }
    else {
      // add new sections
      $txt .= "<a href='#' onClick='addRow(this);return false;'";
      $txt .= " border='0' alt='Add Section' title='Add Section'><img src='$rootUrl/images/icon_add.gif'";
      $txt .= " width='16' height='16' alt='Add Section' title='Add Section' border='0'></a>";
    }
  }
  fmfRow($txt,$class);

  // the field name (read only)
  fmfRow($field['field_name'],$class);
  // the label (text)
  if( $field['field_type'] == 'section' && 
      ($view == 'ticket_view_top' || preg_match('@^(ticket|project)_tab_@', $view)) ) {
    fmfRow(fmfVal($field,'field_label'),$class);
  }
  else {
    fmfRow("<input type='text' ".fmfName($f,'field_label')
          ."value='".fmfVal($field,'field_label')."' size=15 maxlength=200>",$class);
  }
  // visibility (checkbox)
  $sel = $field['is_visible']? ' checked' : '';
  fmfRow("<input type='checkbox' ".fmfName($f, 'is_visible')
         ."value='1' onclick='return checkVisible(this)'$sel>",$class);
  // required, always required if this is a system based field
  if( $field['field_type'] == 'section' ) {
    $s = $field['is_visible']? 'bold' : 'disabled';
    print "<td class='altBars $s' colspan='5'>&nbsp;</td>";
  }
  else {
    if( $map->getViewProp($view,'view_only') ) {
      fmfRow(tr('n/a'),$class);
    }
    else if( $view == 'search_form' ) {
      fmfRow(tr('n/a'), $class);
    }
    else if( $fprops['always_required'] ) {
      fmfRow(tr('yes'),$class);
    }
    else {
      $sel = $field['is_required']? ' checked' : '';
      fmfRow("<input type='checkbox' ".fmfName($f, 'is_required')." value='1'$sel>",$class);
    }
    // default value (text)
    $txt = "n/a";
    if( ($fprops['default']||preg_match('@(project|ticket)_list_filters@',$view)) && !$map->getViewProp($view,'view_only') ) {
      // find out about our field and how we will render the defaults
      $is_status = $f == 'status';
      $is_custom_menu = (strpos($f,'custom_menu')===0 || strpos($f,'custom_multi')===0);
      $is_menu = $fprops['multiple'];
      if( !$is_menu ) {
        $vals = array(ZTFIELD_MENU, ZTFIELD_SEARCHBOX, ZTFIELD_RADIO);
        foreach($fprops['types'] as $typ) {
          if( in_array(ZenFieldMap::getTypeInt($typ), $vals) ) {
            $is_menu = true;
            break;
          }
        }
      }
      $has_choices = $is_status || $is_custom_menu || $is_menu;
      
      //if( $f == 'custom_menu1' ) { Zen::printArray($choices); }
      if( $has_choices ) {
        if( $is_status ) {
          $choices = array(''             => tr("-any-"),
                           'OPEN,PENDING' => tr("Open")." ".tr("or")." ".tr("Pending"),
                           'OPEN'         => tr("Open"),
                           'PENDING'      => tr("Pending"),
                           'CLOSED'       => tr("Closed"));
        }
        else if( $is_custom_menu ) {
          // custom menus use the data groups as a selector, not a list of values
          $choices = $zen->getDataGroups();
        }
        else if( $is_menu ) {
          $choices = $map->getChoices($view, $f);
        }
        
        //if( $field['multiple'] ) { 
        //  $txt = "<select name='{$f}[default_val][]' size='3' multiple>";
        //}
        //else {
          $txt = "<select ".fmfName($f,'default_val')."$m>";
        //}
        foreach($choices as $k=>$v) {
          if( is_array($field['default_val']) ) {
            $sel = in_array($sel, $field['default_val'])&&strlen($sel)? ' selected' : '';
          }
          else {
            $sel = $field['default_val'] == $k && strlen($field['default_val']) == strlen($k)? " selected" : "";
          }
          $txt .= "<option value='".$zen->ffv($k)."'{$sel}>".$zen->ffv($v)."</option>";
        }
        $txt .= "</select>";
      }
      else {
        $txt = "<input type='text' ".fmfName($f, 'default_val')
               ."value='".$zen->ffv($field['default_val'])."' size=10 maxlength=200>";
      }
    }
    fmfRow($txt,$class);

    // field type, not useful for fields which only have label as type
    // or for sections
    if( $map->getViewProp($view,'view_only') || count($fprops['types']) == 1 && $fprops['types'][0] == 'label' ) {
      fmfRow(fmfVal($field,'field_type'),$class);
    }
    else {
      $txt = "<select style='width:80px;' ".fmfName($f, 'field_type').">";
      if (count($fprops['types'])>0) {
        foreach($fprops['types'] as $t) {
          if( $view == 'search_form' && $t == 'checkbox' ) { continue; }
          $sel = ( $field['field_type'] == $t )? ' selected':'';
          $txt .= "<option value='$t'$sel>$t</option>\n";
        }
      }
      $txt .= "</select>";
      fmfRow($txt,$class);
    }
    // number of columns
    fmfRow("<input type='text' ".fmfName($f, 'num_cols')
        ." value='".fmfVal($field,'num_cols')."' size='5' maxlength='4'>",$class);
    // number of rows
    $dorows = false;
    if( $fprops['types'] ) {
      foreach($fprops['types'] as $t) {
        if( $typeprops[$t]['multiple'] ) { $dorows = true; break; }
      }
    }
    if( $dorows ) {
      fmfRow("<input type='text' ".fmfName($f, 'num_rows')
          ." value='".fmfVal($field,'num_rows')."' size='3' maxlength='2'>",$class);
    }
    else { fmfRow('1',$class); }
  }

  print "</tr>\n";
  $prevSection = $field['field_type'] == 'section';
}
?>
<tr id='section0' style="display:none;">
  <td class='highlight'><input type='hidden' name='orderset[section0]' value='3'><a href='#' onClick='moveRowUp(this.parentNode);return false;' border='0' alt='Move Up' title='Move Up'><img src='<?=$imageUrl?>/icon_arrow_up.gif' width='16' height='16' alt='Move Up' title='Move Up' border='0'></a><a href='#' onClick='moveRowDown(this.parentNode);return false;' border='0' alt='Move Down' title='Move Down'><img src='<?=$imageUrl?>/icon_arrow_down.gif' width='16' height='16' alt='Move Up' title='Move Up' border='0'></a><a href='#' onClick='removeRow(this);return false;' border='0' alt='Remove Section' title='Remove Section'><img src='<?=$imageUrl?>/icon_trash.gif' width='16' height='16' alt='Remove Section' title='Remove Section' border='0'></a></td>
  <td class='highlight' islabel="islabel">section0</td>
  <td class='highlight'><input type='text' name='section0[field_label]' value='' size=15 maxlength=200></td>
  <td class='highlight'><input type='checkbox'  name='section0[is_visible]' value='1' onclick='return checkVisible(this)' checked></td>
  <td class='highlight' colspan='5'>&nbsp;</td>
</tr>
<tr id="afterLastRow" toofar="toofar">
  <td class='headerCell' align='center'><b><?=tr("Options")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Name")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Label")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Show")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Required")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Default")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Type")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Columns")?></b></td>
  <td class='headerCell' align='center'><b><?=tr("Rows")?></b></td>
</tr>
<tr toofar="toofar">
  <td class='subTitle' colspan='10'>
    <input type='submit' value='<?=uptr('save')?>' onClick="return setTodo('save');">
    &nbsp;
    <input type='submit' class='submitPlain' value='<?=tr('Reset')?>' onClick="return setTodo('reset');">
  </td>
</tr>

<? } ?>

</table>
<? 
  } //end if( !$view ) { ... } else { ...
?>
</form>

</td></tr></table>

<script type='text/javascript'>

function setTodo( txt ) {
  window.document.fieldMapForm.TODO.value = txt;
  return true;
}

function addRow( obj ) {
  if( !confirm("Add a Section Here?") ) { return; }
  // determine what the next available section number is
  var x = 1;
  while( window.document.getElementById("section"+x) ) { x++; }
  var newName = "section"+x;
  var newSection = window.document.getElementById("section0").cloneNode(true);
  newSection.setAttribute("id",newName);
  for(var i=0; i < newSection.childNodes.length; i++) {
    var sect = newSection.childNodes[i];
    if( sect.getAttribute && sect.getAttribute("isLabel") ) {
      s += "set innerhtml for "+sect+"\n";
      sect.innerHTML = newName;
    }
    else if( sect.hasChildNodes() && sect.childNodes[0] ) {
      var c = sect.childNodes[0];
      if( c.type == 'text' || c.type == 'checkbox' || c.type == 'hidden' ) {
        c.setAttribute('name', c.getAttribute('name').replace('section0',newName));
        s += " - new name: "+c.name+"\n";
        if ( c.type == 'hidden' ) {
          var v1, v2;
          v1=parseFloat(window.document.fieldMapForm[ "orderset[" + obj.parentNode.parentNode.id + "]" ].value);
          var previousRow = obj.parentNode.parentNode.previousSibling;
          while( previousRow && previousRow.nodeName != "TR" ) {
            previousRow = previousRow.previousSibling;
          }
          if( !previousRow || previousRow.getAttribute("toofar") ) {
            v2=-1.0;
          } else {
            v2=parseFloat(window.document.fieldMapForm[ "orderset[" + previousRow.id + "]" ].value);
          }
          v=(v1 + v2) / 2.0;
          c.setAttribute('value',v);
        }
      }
    }
  }
  obj.parentNode.parentNode.parentNode.insertBefore(newSection, obj.parentNode.parentNode);
  newSection.style.display = "";
}

function removeRow( obj ) {
  if( !confirm("Remove this Section?") ) { return; }
  var thisNode = obj.parentNode.parentNode;
  thisNode.parentNode.removeChild(thisNode);
}

function moveRowUp( tdCell ) {
  var v1, v2;
  var f = window.document.forms['fieldMapForm'];
  var thisRow = tdCell.parentNode;
  quickHighlightRow( thisRow, 'mark' );
  var previousRow = thisRow.previousSibling;
  var parentNode = thisRow.parentNode;
  while( previousRow && previousRow.nodeName != "TR" ) {
    previousRow = previousRow.previousSibling;
  }
  if( !previousRow || previousRow.getAttribute("toofar") ) {
    parentNode.insertBefore(thisRow, window.document.getElementById("afterLastRow"));
    //As this is now the last row, we can get the orderset value of it's new previous row
    previousRow = thisRow.previousSibling;
    while( (previousRow && previousRow.nodeName != "TR") || (previousRow && previousRow.id === "section0") ) {
      previousRow = previousRow.previousSibling;
    }
    //And set the current row's orderset value to it's previous row orderset value + 1
    v1=parseFloat(f.elements[ "orderset[" + previousRow.id + "]" ].value);
    f.elements[ "orderset[" + thisRow.id + "]" ].value=v1+1;
    return;
  }
  //If it didn't cross the edge of the table, we just swap the orderset values:
  v1=parseFloat(f.elements[ "orderset[" + thisRow.id + "]" ].value);
  v2=parseFloat(f.elements[ "orderset[" + previousRow.id + "]" ].value);
  f.elements[ "orderset[" + thisRow.id + "]" ].value=v2;
  f.elements[ "orderset[" + previousRow.id + "]" ].value=v1;
  parentNode.insertBefore(thisRow, previousRow);
}

var quickHighlightedRows = new Object();
function quickHighlightRow( parentObj, s ) {
  for(var i=0; i < parentObj.childNodes.length; i++) {
    var obj = parentObj.childNodes[i];
    obj.id = parentObj.id + '-'+i;
    if( obj.nodeName != "TD" ) { continue; }
    objName = obj.id;
    if( quickHighlightedRows[objName] ) {
      // if the row is already highlighted, just remove the timeout
      // we will reset the timeout below to a later time
      clearTimeout( quickHighlightedRows[objName] );
      quickHighlightedRows[objName] = false;
    }
    else if( obj.className ) {
      // if this is IE then use className
      obj.className = obj.className + ' ' + s;
    }
    else {
      // otherwise use setAttribute
      obj.setAttribute('class', obj.getAttribute('class') + ' ' + s);
    }
    // set a timeout to clear the effect
    quickHighlightedRows[objName] = setTimeout("unHighlightRow('"+objName+"','"+s+"');",500);
  }
}

function unHighlightRow( objName, s ) {
  quickHighlightedRows[objName] = false;
  var obj = window.document.getElementById(objName);
  if( obj.className ) {
    // see if our object contains the highlight style
    var idx = obj.className.indexOf(' '+s);
    // if it does, then we remove it
    if( idx >= 0 ) {
      obj.className = obj.className.substr(0,idx);
    }
  }
  else {
    // see if our object contains the highlight style
    var idx = obj.getAttribute('class').indexOf(' '+s);
    // if it does then we remove it
    if( idx >= 0 ) {
      obj.setAttribute('class', obj.getAttribute('class').substr(0,idx));
    }
  }
}

function moveRowDown( tdCell ) {
  var v1, v2;
  var f = window.document.forms['fieldMapForm'];
  var thisRow = tdCell.parentNode;
  quickHighlightRow( thisRow, 'mark' );
  var nextRow = thisRow.nextSibling;
  var parentNode = thisRow.parentNode;
  //while( nextRow && nextRow.nodeName != "TR" ) {
  while( (nextRow && nextRow.nodeName != "TR") || (nextRow && nextRow.id === "section0") ) {
    nextRow = nextRow.nextSibling;
  }
  if( !nextRow || nextRow.getAttribute("toofar") ) {
    nextRow = thisRow;
    thisRow = window.document.getElementById("beforeFirstRow");
    while( thisRow.nodeName != "TR" || thisRow.getAttribute("toofar") ) {
      thisRow = thisRow.nextSibling;
    }
    //We set the current row's orderset value to the first row's orderset -1
    v1=parseFloat(f.elements[ "orderset[" + thisRow.id + "]" ].value);
    f.elements[ "orderset[" + nextRow.id + "]" ].value=v1-1;
  } else {
    //We swap the orderset values:
    v1=parseFloat(f.elements[ "orderset[" + thisRow.id + "]" ].value);
    v2=parseFloat(f.elements[ "orderset[" + nextRow.id + "]" ].value);
    f.elements[ "orderset[" + thisRow.id + "]" ].value=v2;
    f.elements[ "orderset[" + nextRow.id + "]" ].value=v1;
  }
  parentNode.insertBefore(nextRow, thisRow);
}

function toggleRowColor( checkBox ) {
    // navigate to the TR tag for this row
    var trTag = checkBox.parentNode.parentNode;

    for(var i=0; i < trTag.childNodes.length; i++) {
      var obj = trTag.childNodes[i];
      if( obj.nodeName != "TD" ) { continue; }
      // perform the class switch
      if( obj.className ) {
        // determine what we are setting the style to based on checkbox
        obj.className = checkBox.checked?
          obj.className.substr(0, obj.className.indexOf(" ")) + " bold" :
          obj.className.substr(0, obj.className.indexOf(" ")) + " disabled";
      }
      else {
        // determine what we are setting the style to based on checkbox
        var oldStyle = obj.getAttribute('class');
        obj.setAttribute('class', checkBox.checked?
          oldStyle.substr(0, oldStyle.indexOf(" "))+" bold" :
          oldStyle.substr(0, oldStyle.indexOf(" "))+" disabled" );
      }
    }
}

  function checkVisible( obj ) {
    var namePrefix = getNamePrefix(obj.name);
    var defName = namePrefix+'[default_val]';
    var reqName = namePrefix+'[is_required]';
    var defObj = window.document.fieldMapForm[defName];
    var reqObj = window.document.fieldMapForm[reqName];
    toggleRowColor( window.document.fieldMapForm[namePrefix+"[is_visible]"] );
    if( defObj && defObj.value == null && reqObj.checked ) {
      alert("You cannot hide a required field unless it has a default value.");
      return false;
    }
    return true;
  }

  function getNamePrefix( name ) {
    return name.substr(0, name.indexOf('['))
  }
</script>