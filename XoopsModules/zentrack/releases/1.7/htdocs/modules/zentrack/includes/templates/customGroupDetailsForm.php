<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
      <br>
      <p class='error'><?php echo tr("Select the items that will appear in this group and their order."); ?></p>
      <ul>
      <form name='groupDetailsForm' action='<?php echo $SCRIPT_NAME?>' method='post'>
      <input type='hidden' name='TODO' value=''>
      <input type='hidden' name='more' value='<?php echo $more?>'>
      <input type='hidden' name='group_id' value='<?php echo $group_id?>'>
      <table cellpadding="2" cellspacing="1" class='plainCell'>
	 <tr>
	   <td class='titleCell' align='center' colspan='3'>
 	    <b><?php echo tr("Custom Group Details"); ?></b>
	   </td>
	 </tr>
	 <tr>
           <td class='cell' align='center'><b><?php echo tr("Delete"); ?></b></td>
           <td class='cell' align='center'><b><?php echo tr("Value"); ?></b></td>
           <td class='cell' align='center'><b><?php echo tr("Order"); ?></b></td>
	 </tr>
    <?php 
      for($i=0; $i<count($elements); $i++) {
	$e = $elements[$i];
	$val = $zen->ffv($e['field_value']);
	$sort = $zen->ffv($e['sort_order']);
	$checked = isset($e['new_delete']) && $e['new_delete']? " CHECKED" : ""; 
    ?>
      <tr>
        <td class='cell'>
	  <input type='checkbox' name='NewDelete[<?php echo $i?>]' value='1'<?php echo $checked?>>
        </td>
        <td class='cell'>
	  <input type='textbox' name='NewValue[<?php echo $i?>]' value='<?php echo $val?>'> 
        </td>
        <td class='cell'>
	  <input type='textbox' name='NewSortOrder[<?php echo $i?>]' value='<?php echo $sort?>'> 
        </td>
      </tr>
    <?php
       }
    ?>

<tr>
  <td class="titleCell" colspan="3">
    <?php echo tr('Press MORE to create new detail items'); ?>
    <br>
    <?php echo tr('Press LESS to remove blank rows'); ?>
    <br>
    <?php echo tr('Press Save to store your changes'); ?>
    <br>
    <?php echo tr('Press Reset to ignore them'); ?>
  </td>
</tr>
      <tr>
	 <td class='cell' colspan='3'>
	 <input type='submit' value='<?php echo uptr('More'); ?>' onClick="return setTodo('MORE')">
         &nbsp;
         <input type='submit' value='<?php echo uptr('less'); ?>' onClick="return setTodo('LESS')">
	 &nbsp;
         <input type='submit' class='submit' value='<?php echo tr('Save'); ?>' onClick="return setTodo('Save')">
         &nbsp;
         <input type='submit' class='submitPlain' value='<?php echo tr('Reset'); ?>' onClick="return setTodo('Reset')">
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
