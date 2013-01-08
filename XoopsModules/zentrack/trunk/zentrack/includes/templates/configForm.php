<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
      <br>
      <p class='error'><?php
         $str = "<a href='$rootUrl/help/find.php?s=admin&p=data_types'>".tr('Documentation')."</a>";
         print tr("Please refer to the ? before using this feature", array($str));
       ?></p>

<?php if( $type == "type" ) { ?>
      <p><?=tr('There are two special types, which can be set by including either the word <span class="error">project</span> or <span class="error">note</span> in the bin name.')?></p>

     <p><?=tr('Projects act as containers, which can hold multiple tickets as "tasks" which are part of the projects completion requirements.')?></p>
     <p><?=tr('Notes are special tickets which do not require any actions.').'  '.
	       tr('They start their life closed, and do not need to be completed.').'  '. 
	       tr('Use them only for tracking and documentation.')?></p>
         
  <script type='text/javascript'>
    function checkPriType( formObj ) {
      var matched = false;
      for( var i=0; i < formObj.elements.length; i++ ) {
        var e = formObj.elements[i];
        if( e.name && e.type && e.name.indexOf( 'newName' ) == 0 ) {
          if( e.value.toLowerCase().indexOf('project') >= 0 ) {
            matched = true;
            break;
          }
        }
      }
      if( !matched ) {
        return confirm("<?=tr("You have not set a 'Project' type, projects will not work correctly.  Choose 'cancel' to try again.")?>");
      }
      return true;
    }
  </script>
<?php } ?>
      <ul>
      <form name='configForm' action='<?=$SCRIPT_NAME?>' <?=$type=='type'? " onsubmit='return checkPriType(this)'":""?> method='post'>
      <table cellpadding="2" cellspacing="1" class='plainCell'>
	 <tr toofar="toofar">
	 <td class='titleCell' align='center' colspan='5'>
         <?php
       $plural_type = tr($type == 'priority'? 'Priorities' : ucfirst($type)."s");
     ?>
	   <b><?=tr("Edit the Active ?",array($plural_type))?></b>
	 </td>
	 </tr>
	 <tr toofar="toofar">
	 <td width="30" class='cell' align='center'><b><?=tr("ID")?></b></td>
	 <td class='cell' align='center'><b><?=tr("Name")?></b></td>
	 <td width="30" class='cell' align='center'><b><?=tr("Active")?></b></td>
	 <td width="30" class='cell' align='center'><b>&nbsp;</b></td>
	 </tr>
    <?php
   $j = count($vars)-1;
	 if( is_array($vars) ) {
	   $newtext = "-".tr("new")."-";
	   $t = "\t<td class='bars'>";
	   $te = "</td>\n";
	   foreach($vars as $v) {
	     print "<tr id='$j'>\n";
	     $i = ($v["$id_type"])? $v["$id_type"] : $newtext;
	     
       // id cell
       print "$t$i$te";
       
       // name cell
	     print "<input type='hidden' name='newID[$j]' value='".$v[$id_type]."'>\n";
	     print "$t<input type='text' name='newName[$j]' "
         ." value='".$zen->ffv($v["name"])."' size='20' maxlength='25'>$te";
         
       // active cell
       print "$t<input type='checkbox' name='newActive[$j]' onclick='checkVisible(this)' value='1'";
	     print ($v["active"])? " checked" : "";
	     print ">$te";
       
       
       // priority cell
       $txt = $t;
         //$txt .= '['.$v['priority'].':'.$j.']';//debug
        // up arrow
        $txt .= "<a href='#' onClick='moveRowUp(this.parentNode);return false;'";
        $txt .= " border='0' alt='Move Up' title='Move Up'><img src='$rootUrl/images/icon_arrow_up.gif'";
        $txt .= " width='16' height='16' alt='Move Up' title='Move Up' border='0'></a>";
        // down arrow
        $txt .= "<a href='#' onClick='moveRowDown(this.parentNode);return false;'";
        $txt .= " border='0' alt='Move Down' title='Move Down'><img src='$rootUrl/images/icon_arrow_down.gif'";
        $txt .= " width='16' height='16' alt='Move Down' title='Move Down' border='0'></a>";
        // control sort ordering by tracking what order these hidden fields arrive
        $txt .= "<input type='hidden' name='newPri[$j]' value='".($j+1)."'>";
        
        // add new rows
        $txt .= "<a href='#' onClick='addRow(this);return false;'";
        $txt .= " border='0' alt='Add Section' title='Add Section'><img src='$rootUrl/images/icon_add.gif'";
        $txt .= " width='16' height='16' alt='Add Section' title='Add Section' border='0'></a>";
        $txt .= $te;
       print $txt;

	     print "</tr>\n";
	     $j--;
	   }
	 }
   
   // this cannot change from here out, it has to remain as-is
   $sampleRowId = count($vars);
   
    ?>
<tr id='aSampleRow' style="display:none;">
  <td class='bars'><?=$newtext?></td>
  <input type='hidden' name='newID[<?=$sampleRowId?>]' value=''>
  <td class='bars'><input type='text' name='newName[<?=$sampleRowId?>]' value='' size='20' maxlength='25'></td>
  <td class='bars'><input type='checkbox' name='newActive[<?=$sampleRowId?>]' value='1' checked></td>
  <td class='bars'>
    <input type='hidden' name='newPri[<?=$sampleRowId?>]' value='<?=$sampleRowId?>'>
    <a href='#' onClick='moveRowUp(this.parentNode);return false;'
      border='0' alt='Move Up' title='Move Up'><img src='<?=$rootUrl?>/images/icon_arrow_up.gif'
      width='16' height='16' alt='Move Up' title='Move Up' border='0'></a>
    <a href='#' onClick='moveRowDown(this.parentNode);return false;' 
      border='0' alt='Move Down' title='Move Down'><img src='<?=$rootUrl?>/images/icon_arrow_down.gif'
      width='16' height='16' alt='Move Down' title='Move Down' border='0'></a>
    <a href='#' onClick='addRow(this);return false;'
      border='0' alt='Add Section' title='Add Section'><img src='<?=$rootUrl?>/images/icon_add.gif'
      width='16' height='16' alt='Add Section' title='Add Section' border='0'></a>
  </td>
</tr>    
<tr toofar="toofar" id="submitRow">
  <td class="titleCell" colspan="5">
    <?=tr("Press Save to save changes")?>
    <br>
    <?=tr("Press Reset to return to original values")?>
  </td>
</tr>
      <tr toofar="toofar">
	 <td class='cell' colspan='5'>
         <input type='hidden' name='TODO' value=''>
	 <input type='submit' class='submit' value='<?=uptr("Save")?>' onClick='return setToDo("Save")'>
	 &nbsp;
	 <input type='submit' class='submitPlain' value='<?=uptr("Reset")?>' onClick='return setToDo("Reset")'>
         </td>
      </tr>
      </table>
      </ul>

      </form>
<script language='javascript'>
var i;
var ci;
var rowCount = <?=$sampleRowId+1?>;
function setToDo(val) {
  document.configForm.TODO.value = val;
  return true;
}

function addRow( obj ) {
//  alert('obj: '+obj);
  var newName = rowCount++;
  var newSection = document.getElementById("aSampleRow").cloneNode(true);
  newSection.setAttribute("id",newName);
  for(var i=0; i < newSection.childNodes.length; i++) {
    var sect = newSection.childNodes[i];
    if( sect.hasChildNodes() && sect.childNodes.length > 0 ) {
      for(var j=0; j < sect.childNodes.length; j++) {
        var c = sect.childNodes[j];
        if( c.type == 'text' || c.type == 'checkbox' || c.type == 'hidden' ) {
          c.setAttribute('name', c.getAttribute('name').replace('<?=$sampleRowId?>',newName));
          if ( c.name.indexOf('newPri') == 0 ) {
            var v1, v2;
            v1=parseFloat(document.configForm[ "newPri[" + obj.parentNode.parentNode.id + "]" ].value);
            var previousRow = obj.parentNode.parentNode.previousSibling;
            while( previousRow && previousRow.nodeName != "TR" ) {
              previousRow = previousRow.previousSibling;
            }
            if( !previousRow || previousRow.getAttribute("toofar") ) {
              v2=-1.0;
            } else {
              v2=parseFloat(document.configForm[ "newPri[" + previousRow.id + "]" ].value);
            }
            v=(v1 + v2) / 2.0;
            c.setAttribute('value',v);
          }
        }
      }
    }
  }
  obj.parentNode.parentNode.parentNode.insertBefore(newSection, obj.parentNode.parentNode);
  newSection.style.display = "";
}

//function removeRow( obj ) {
//  if( !confirm("Remove this Section?") ) { return; }
//  var thisNode = obj.parentNode.parentNode;
//  thisNode.parentNode.removeChild(thisNode);
//}

function moveRowUp( tdCell ) {
  var v1, v2;
  var thisRow = tdCell.parentNode;
  quickHighlightRow( thisRow, 'subTitle' );
  var previousRow = thisRow.previousSibling;
  var parentNode = thisRow.parentNode;
  while( previousRow && previousRow.nodeName != "TR" ) {
    previousRow = previousRow.previousSibling;
  }
  if( !previousRow || previousRow.getAttribute("toofar") ) {
    parentNode.insertBefore(thisRow, document.getElementById("submitRow"));
    //As this is now the last row, we can get the orderset value of it's new previous row
    previousRow = thisRow.previousSibling;
    while( (previousRow && previousRow.nodeName != "TR") || (previousRow && previousRow.id === "section0") ) {
      previousRow = previousRow.previousSibling;
    }
    //And set the current row's orderset value to it's previous row orderset value - 1
    v1=parseFloat(document.configForm[ "newPri[" + previousRow.id + "]" ].value);
    document.configForm[ "newPri[" + thisRow.id + "]" ].value=v1-1;
    return;
  }
  parentNode.insertBefore(thisRow, previousRow);
  //If it didn't cross the edge of the table, we just swap the orderset values:
  v1=parseFloat(document.configForm[ "newPri[" + thisRow.id + "]" ].value);
  v2=parseFloat(document.configForm[ "newPri[" + previousRow.id + "]" ].value);
  document.configForm[ "newPri[" + thisRow.id + "]" ].value=v2;
  document.configForm[ "newPri[" + previousRow.id + "]" ].value=v1;
}

function quickHighlightRow( parentObj, s ) {
  for(var i=0; i < parentObj.childNodes.length; i++) {
    var obj = parentObj.childNodes[i];
    obj.id = parentObj.id + '-'+i;
    if( obj.nodeName != "TD" ) { continue; }
    objName = obj.id;
    if( obj.className ) {
      obj.className = obj.className + ' ' + s;
      setTimeout("var x = document.getElementById('"+objName+"'); x.className = x.className.substr(0,x.className.indexOf(' "+s+"'));",500);
    }
    else {
      obj.setAttribute('class', obj.getAttribute('class') + ' ' + s);
      setTimeout("var x = document.getElementById('"+objName+"'); x.setAttribute('class', x.getAttribute('class').substr(0,x.getAttribute('class').indexOf(' "+s+"')));",500);
    }

  }
}

function moveRowDown( tdCell ) {
  var v1, v2;
  var thisRow = tdCell.parentNode;
  quickHighlightRow( thisRow, 'subTitle' );
  var nextRow = thisRow.nextSibling;
  var parentNode = thisRow.parentNode;
  //while( nextRow && nextRow.nodeName != "TR" ) {
  while( (nextRow && nextRow.nodeName != "TR") || (nextRow && nextRow.id === "section0") ) {
    nextRow = nextRow.nextSibling;
  }
  if( !nextRow || nextRow.getAttribute("toofar") ) {
    nextRow = thisRow;
    thisRow = parentNode.firstChild;
    while( thisRow.nodeName != "TR" || thisRow.getAttribute("toofar") ) {
      thisRow = thisRow.nextSibling;
    }
    //We set the current row's orderset value to the first row's orderset + 1
    v1=parseFloat(document.configForm[ "newPri[" + thisRow.id + "]" ].value);
    document.configForm[ "newPri[" + nextRow.id + "]" ].value=v1+1;
  } else {
    //We swap the orderset values:
    v1=parseFloat(document.configForm[ "newPri[" + thisRow.id + "]" ].value);
    v2=parseFloat(document.configForm[ "newPri[" + nextRow.id + "]" ].value);
    document.configForm[ "newPri[" + thisRow.id + "]" ].value=v2;
    document.configForm[ "newPri[" + nextRow.id + "]" ].value=v1;
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
    toggleRowColor( obj );
    return true;
  }

  function getNamePrefix( name ) {
    return name.substr(0, name.indexOf('['))
  }
</script>
