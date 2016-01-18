<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>


      <p class='bigBold'><?=tr('Edit Variable Fields')?></p>
      
      <p class='error'><?php
         $str = "<a href='$rootUrl/help/find.php?s=admin&p=varfields'>".tr('Documentation')."</a>";
         print tr("Please refer to the ? before using this feature", array($str));
       ?></p>

      <ul>
      <form name='editCustomsForm' action='<?=$SCRIPT_NAME?>' method='post'>
      <input type='hidden' name='TODO' value=''>
      <table cellpadding="2" cellspacing="1" class='plainCell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='12'>
	   <b><?=tr("Edit the Available Custom Fields")?></b>
	 </td>
	 </tr>
	 <tr>
	 <td width="60" class='subTitle' align='center'><b><?=tr("Field Name")?></b></td>
	 <td class='subTitle' align='center'><b><?=tr("Field Label")?></b></td>
	 <td class='subTitle' align='center'><b><?=tr("Order")?></b></td>
	 <td class='subTitle' align='center'><b><?=tr("Default")?></b></td>
	 <td width="30" class='subTitle' align='center' title="<?=tr("Is this field required?")?>">
	   <b><?=tr("Required")?></b>
         </td>
	 <td width="30" class='subTitle' align='center' title="<?=tr("Used for projects?")?>">
           <b><?=tr("Projects")?></b>
         </td>
	 <td width="30" class='subTitle' align='center' title="<?=tr("Used for tickets?")?>">
	   <b><?=tr("Tickets")?></b>
         </td>
	 <td width="30" class='subTitle' align='center' title="<?=tr("Used for searches?")?>">
	   <b><?=tr("Searches")?></b>
         </td>
	 <td width="30" class='subTitle' align='center' title="<?=tr("Ticket lists?")?>">
	   <b><?=tr("Lists")?></b>
         </td>
	 <td width="30" class='subTitle' align='center' title="<?=tr("Show in custom tab?")?>">
	   <b><?=tr("Custom")?></b>
         </td>
	 <td width="30" class='subTitle' align='center' title="<?=tr("Show in detail tab?")?>">
	   <b><?=tr("Details")?></b>
         </td>
	 <td width="30" class='subTitle' align='center' title="<?=tr("Create new ticket window?")?>">
	   <b><?=tr("New")?></b>
         </td>
       </tr>
          <?php
         $num = count($vars);
	 if( is_array($vars) ) {
	   $j = 0;
	   $t = "\t<td class='bars' align='center'>";
	   $te = "</td>\n";
	   foreach($vars as $v) {
	     print "<tr>\n";
	     $i = $v["field_name"];
	     print "<td class='bars'>$i$te";
	     print "<input type='hidden' name='newFieldName[$j]' value='".$zen->ffv($v['field_name'])."'>\n";
	     print "$t<input type='text' name='newFieldLabel[$j]' "
       ." value='".$zen->ffv($v['field_label'])."' size='20' maxlength='50'>$te";
	     print "$t<input type='text' name='newSortOrder[$j]' "
       ." value='".$zen->ffv($v['sort_order'])."' size='5' maxlength='5'>$te";
	     if( strpos($i, 'menu') > 0 || strpos($i, 'multi') ) {
	       print "$t<select name='newFieldValue[$j]'>\n";
	       if( isset($_SESSION['data_groups']) && count($_SESSION['data_groups']) ) {
           print "<option value=''>-none-</option>\n";
           foreach( $_SESSION['data_groups'] as $g ) {
             if( $g['eval_type'] == 'Matches' ) {
               $sel_item=($v['field_value']==$g['group_id'])?" selected" : "";
               print "<option value='{$g['group_id']}'$sel_item>{$g['group_name']}</option>\n";
             }
           }
	       }
	       else {
           print "<option value=''>-no groups-</option>\n";
	       }
	       print "</select>$te\n";
	     }
	     else {
	       print "$t<input type='text' name='newFieldValue[$j]' "
		 ." value='".$zen->ffv($v['field_value'])."' size='20' maxlength='250'>$te";
	     }
	     print "$t<input type='checkbox' name='newIsRequired[$j]' value='1'";
	     print ($v["is_required"])? " checked" : "";
	     print ">$te";
	     print "$t<input type='checkbox' name='newUseForProject[$j]' value='1'";
	     print ($v["use_for_project"])? " checked" : "";
	     print ">$te";
	     print "$t<input type='checkbox' name='newUseForTicket[$j]' value='1'";
	     print ($v["use_for_ticket"])? " checked" : "";
	     print ">$te";
	     print "$t<input type='checkbox' name='newShowInSearch[$j]' value='1'";
	     print ($v["show_in_search"])? " checked" : "";
	     print ">$te";
	     print "$t<input type='checkbox' name='newShowInList[$j]' value='1'";
	     print ($v["show_in_list"])? " checked" : "";
	     print ">$te";
	     print "$t<input type='checkbox' name='newShowInCustom[$j]' value='1'";
	     print ($v["show_in_custom"])? " checked" : "";
	     print ">$te";
	     print "$t<input type='checkbox' name='newShowInDetail[$j]' value='1'";
	     print ($v["show_in_detail"])? " checked" : "";
	     print ">$te";
	     print "$t<input type='checkbox' name='newShowInNew[$j]' value='1'";
	     print ($v["show_in_new"])? " checked" : "";
	     print ">$te";
	     print "</tr>\n";
	     $j++;
	   }
	 }

    ?>
<tr>
  <td class="titleCell" colspan="12">
    <?=tr('Press Save to save changes')?>
    <br>
    <?=tr('Press Reset to return to original values')?>
  </td>
</tr>
      <tr>
	 <td class='cell' colspan='2'>
	 <input type='submit' class='submit' value='<?=tr('Save')?>' onClick="return setTodo('Save')">
	 &nbsp;
	 <input type='submit' class='submitPlain' value='<?=tr('Reset')?>' onClick="return setTodo('Reset')">
   </td>
</tr>
</table>
</ul>

<p class='note'>The default value for menus can only be a group which is
evaluated from 'Matches'.</p>
<p class='note'>'Javascript' and 'File' menus cannot be loaded as the default.</p>

<input type='hidden' name='more' value='<?=$more?>'>
</form>
<script language='javascript'>
   function setTodo( val ) {
     document.editCustomsForm.TODO.value = val;
   }
</script>
                                                                                                                             

