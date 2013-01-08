<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
      <br>
      <p class='error'><?=tr("Select the items that will appear in this group and their order.")?></p>
      <ul>
      <form name='groupDetailsForm' action='<?=$SCRIPT_NAME?>' method='post'>
      <input type='hidden' name='TODO' value=''>
      <input type='hidden' name='more' value='<?=$more?>'>
      <input type='hidden' name='group_id' value='<?=$group_id?>'>
      <table cellpadding="2" cellspacing="1" class='plainCell'>
	 <tr>
	   <td class='titleCell' align='center' colspan='3'>
 	    <b><?=tr("Custom Group Details")?></b>
	   </td>
	 </tr>
	 <tr>
           <td class='cell' align='center'><b><?=tr("Delete")?></b></td>
           <td class='cell' align='center'><b><?=tr("Value")?></b></td>
           <td class='cell' align='center'><b><?=tr("Order")?></b></td>
	 </tr>
    <? 
      for($i=0; $i<count($elements); $i++) {
	$e = $elements[$i];
	$val = $zen->ffv($e['field_value']);
	$sort = $zen->ffv($e['sort_order']);
	$checked = isset($e['new_delete']) && $e['new_delete']? " CHECKED" : ""; 
    ?>
      <tr>
        <td class='cell'>
	  <input type='checkbox' name='NewDelete[<?=$i?>]' value='1'<?=$checked?>>
        </td>
        <td class='cell'>
	  <input type='textbox' name='NewValue[<?=$i?>]' value='<?=$val?>'> 
        </td>
        <td class='cell'>
	  <input type='textbox' name='NewSortOrder[<?=$i?>]' value='<?=$sort?>'> 
        </td>
      </tr>
    <?
       }
    ?>

<tr>
  <td class="titleCell" colspan="3">
    <?=tr('Press MORE to create new detail items')?>
    <br>
    <?=tr('Press LESS to remove blank rows')?>
    <br>
    <?=tr('Press Save to store your changes')?>
    <br>
    <?=tr('Press Reset to ignore them')?>
  </td>
</tr>
      <tr>
	 <td class='cell' colspan='3'>
	 <input type='submit' value='<?=uptr('More')?>' onClick="return setTodo('MORE')">
         &nbsp;
         <input type='submit' value='<?=uptr('less')?>' onClick="return setTodo('LESS')">
	 &nbsp;
         <input type='submit' class='submit' value='<?=tr('Save')?>' onClick="return setTodo('Save')">
         &nbsp;
         <input type='submit' class='submitPlain' value='<?=tr('Reset')?>' onClick="return setTodo('Reset')">
         </td>
      </tr>
      </table>
      </ul>

      </form>

	 <div class='note'>You can enter a blank field by entering <b>-blank-</b></div>

      <script language='javascript'>
          function setTodo( val ) {
           document.groupDetailsForm.TODO.value = val;
         }
      </script>
