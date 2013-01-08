<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

   // some elements of page are presented slightly different, although
   // data structure remains the same, when we plan to deal with groups
   // created from files
   $groupIsFile = $group && $group['eval_type'] == 'File';
   $colspan = $groupIsFile? 2:4;
?>
      <br>
<?php
        print "<p class='bold'>";
        if( $groupIsFile ) {
          print tr("Enter the names of fields and the corresponding column"
            ." numbers in the data file here:");
          print "<ul>";
          print "<li>".tr("You must have an entry for the '?'!", array(tr('Value Column')));
          print "<li>".tr("The first column in the data file would be numbered 1");
          print "</ul>\n";
        }
        else {
          print tr("This screen will let you list, add, edit and delete behavior rules.");
        }
        print "</p><p class='bold'>";
        $lnk = "<a href='$helpUrl/admin/behaviors.php'>".tr('Documentation')."</a>";
        print tr("Please refer to the ? for more information.", array($lnk));
        print "</p>\n";
      ?>
      <ul>
      <form name='behaviorDetailForm' action='<?=$SCRIPT_NAME?>' onsubmit='return checkForValueColumn(this)' method='post'>
      <input type='hidden' name='TODO' value=''>
      <input type='hidden' name='behavior_id' value='<?=$zen->checkNum($behavior_id)?>'>
      <table cellpadding="2" cellspacing="1" class='plainCell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='<?=$colspan?>'>
	   <b>Edit the Behavior Rules</b>
	 </td>
	 </tr>
	 <tr>
	 <td class='cell' align='center'><b><?=tr("Compare Field")?></b></td>

   <?php if( !$groupIsFile ) { ?>
	 <td class='cell' align='center'><b><?=tr("Operator")?></b></td>
   <?php } ?>
	 
   <td class='cell' align='center'><b><?=
      $groupIsFile? tr('Column Number') : tr("Compare Value")?></b></td>

   <?php if( !$groupIsFile ) { ?>
	 <td class='cell' align='center'><b><?=tr("Sort Order")?></b></td>
   <?php } ?>

	 </tr>
    <?php
    $num = count($elements) + $more;
    if( is_array($elements) ) {
      $j = 0;
      $t = "\t<td class='bars'>";
      $te = "</td>\n";
      foreach ($elements as $item) {
        if (isset($item['field_name'])) {
          print "<tr>\n";
          // name of the field
          print "$t<select name='NewFieldName[{$j}]'>\n";
          print "<option value=''>".tr('-new/delete-')."</option>\n";
          if( $groupIsFile ) {
            $sel = $item['field_name'] == 'value_column'? ' selected' : '';
            print "<option value='value_column'$sel>".tr('-value column-')."</option>\n";
          }
          foreach($field_list as $fl=>$fn) {
            $sel=($item['field_name']==$fn)? " selected" : "";
            print "<option value='{$fn}'{$sel}>{$fl}</option>\n";
          }
          print "$te";
          
          // comparator and value are not valid if this is a File type
          // so we will just show a hidden field and set them ourselves
          if( !$groupIsFile ) {
            print "$t<select name='NewComparator[{$j}]'>\n";
            foreach($comp_opers as $key=>$label) {
              $sel=($item['field_operator']==$key)? " selected" : "";
              print "<option value='{$key}'{$sel}>{$label}</option>\n";
            }
            print "$te";
          }
          else {
            print "<input type='hidden' name='NewComparator[{$j}]' value='eq'>";
          }
          $item['field_value'] = $zen->ffv($item['field_value']);
          $x = $groupIsFile? 3 : 20;
          print "{$t}<input type='text' name='NewMatchValue[{$j}]' "
              ." value='{$item['field_value']}' size='$x' maxlength='255'>{$te}";
            
          // the sort order, normally.  In the case of groups coming from
          // files, this is used as the column index
          if( !$groupIsFile ) {
            print "{$t}<input type='text' name='NewSortOrder[{$j}]' "
                ." value='{$item['sort_order']}' size='3' maxlength='3'>{$te}";
          }
          else {
            print "{$t}<input type='hidden' name='NewSortOrder[{$j}]' "
                ." value='{$j}'>{$te}\n";
          }
          print "</tr>\n";
          $j++;
        }
      }
    }
    for( $i=0; $i<$more; $i++ ) {
      print "<tr>\n";
      
      // new detail name
      print "$t<select name='NewFieldName[{$j}]'>\n";
      print "<option value='' selected>".tr('-new/delete-')."</option>\n";
      if( $groupIsFile ) {
        print "<option value='value_column'>".tr('-value column-')."</option>\n";
      }
      foreach($field_list as $fl=>$fn) {
        print "<option value='$fn'>$fl</option>\n";
      }
      print "$te";
      
      // new detail comparator and value only appear if this is not
      // referencing a group created from a file
      if( !$groupIsFile ) {
        print "$t<select name='NewComparator[{$j}]'>\n";
        foreach($comp_opers as $key=>$val) {
          $sel = ($key == 'eq')? " selected" : "";
          print "<option value='{$key}'{$sel}>{$val}</option>\n";
        }
        print "$te";
        print "{$t}<input type='text' name='NewMatchValue[{$j}]' "
        ." value='' size='20' maxlength='255'>{$te}";
        // the sort order or the column index
        print "$t"."<input type='text' name='NewSortOrder[{$j}]' "
        ." value='' size='3' maxlength='3'>{$te}";
      }
      else {
        print $t;
        print "<input type='hidden' name='NewComparator[{$j}]' value='eq'>";
        print "<input type='text' name='NewMatchValue[{$j}]' value='' size='3' maxlength='20'>";
        // the sort order or the column index
        print "<input type='hidden' name='NewSortOrder[{$j}]' value='' size='3' maxlength='3'>";
        print $te;
      }
      
      print "</tr>\n";
      $j++;
    }

    ?>
<tr>
  <td class="titleCell" colspan="<?=$colspan?>">
    <?=tr('Press MORE to create new detail items')?>
    <br>
    <?=tr('Press LESS to remove blank rows')?>
    <br>
    <?=tr('Press Save to save changes')?>
    <br>
    <?=tr('Press Reset to return to original values')?>
  </td>
</tr>
      <tr>
	 <td class='cell' colspan='<?=$colspan?>'>
	 <input type='submit' value='<?=uptr('More')?>' onClick="return setTodo('MORE')">
         &nbsp;
         <input type='submit' value='<?=uptr('less')?>' onClick="return setTodo('LESS')">
	 &nbsp;
	 <input type='submit' class='submit' value='<?=tr('Save')?>' onClick="setTodo('Save')">
	 &nbsp;
	 <input type='submit' class='submitPlain' value='<?=tr('Reset')?>' onClick="return setTodo('Reset')">
         </td>
      </tr>
      </table>
      </ul>

      <input type='hidden' name='more' value='<?=$more?>'>
      </form>
      <script language='javascript'>
	 function setTodo( val ) {
	   document.behaviorDetailForm.TODO.value = val;
	 }

   function checkForValueColumn(formObj) {
     for( var i=0; i < formObj.elements.length; i++ ) {
       var f = formObj.elements[i];
       if( f.type.indexOf('select') >= 0 ) {
         if( f.value == 'value_column' ) {
           return true;
         }
       }
     }
     alert("<?=tr("You must supply a value_column before this behavior will function.")?>");
     return false;
   }
      </script> 

