<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
      <br>
      <p class='error'><?=tr("Select the items that will appear in this group and their order.")?></p>
      <ul>
      <form name='groupDetailsForm' action='<?=$SCRIPT_NAME?>' method='post'>
      <input type='hidden' name='TODO' value=''>
      <input type='hidden' name='group_id' value='<?=$group_id?>'>
      <table cellpadding="2" cellspacing="1" class='plainCell'>
	 <tr>
	   <td class='titleCell' align='center' colspan='3'>
  	     <b><?=tr("Data Group Details")?></b>
	   </td>
	 </tr>
	 <tr>
           <td width="30" class='cell' align='center'><b><?=tr("Show")?></b></td>
           <td class='cell' align='center'><b><?=tr("Item")?></b></td>
           <td class='cell' align='center'><b><?=tr("Order")?></b></td>
	 </tr>
    <?php
    if( is_array($elements) ) {
      $j = 0;
      $t = "\t<td class='bars'>";
      $te = "</td>\n";
      for($i=0; $i<count($elements); $i++) {
        print "<tr>\n";
        print "$t"."<input type='checkbox' name='NewUseInGroup[".$j."]' value='".$elements[$i][0]."'";
        $so=0;
        for($k=0; $k<count($group_details); $k++) {
          if($group_details[$k]['field_value'] == $elements[$i][0]) {
            print " checked ";
            $so=$group_details[$k]['sort_order'];
          }
        }
        print "><input type='hidden' name='NewValue[".$j."]' value='".$elements[$i][0]."'>"."$te";
        print "$t".$zen->ffv($elements[$i][1])."$te";
        print "$t"."<input type='text' name='NewSortOrder[".$j."]' value='".$so."' size='3' maxlength='3'>"."$te";
        print "</tr>\n";
        $j++;
      }
    }
    ?>
<tr>
  <td class="titleCell" colspan="3">
    <?=tr('Press Save to store your changes')?>
    <br>
    <?=tr('Press Reset to ignore them')?>
  </td>
</tr>
      <tr>
	 <td class='cell' colspan='3'>
         <input type='submit' class='submit' value='<?=tr('Save')?>' onClick="return setTodo('Save')">
         &nbsp;
         <input type='submit' class='submitPlain' value='<?=tr('Reset')?>' onClick="return setTodo('Reset')">
         </td>
      </tr>
      </table>
      </ul>

      </form>

      <script language='javascript'>
          function setTodo( val ) {
           document.groupDetailsForm.TODO.value = val;
         }
      </script>




