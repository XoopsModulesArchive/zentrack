<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

         $elnk="$rootUrl/admin/deleteGroup.php";
?>
      <br>
      <p><b><?=tr("The data group ? is currently being used.",array($group_id))?></b></p>
      <p class='error'><?php
         $str = "<a href='$rootUrl/help/find.php?s=admin&p=data_groups'>".tr('Documentation')."</a>";
         print tr("Please refer to the ? before using this feature", array($str));
       ?></p>      
      <ul>
      <form name='referencedGroupForm' action='<?=$elnk?>' method='post'>
      <input type='hidden' name='TODO' value=''>
      <input type='hidden' name='group_id' value='<?=$group_id?>'>
      <table cellpadding="4" cellspacing="1" class='cell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='2'>
	   <b><?=tr("Choose what to do before data group deletion")?></b>
	 </td>
	 </tr>
	 <tr>
           <td class='bars' align='left'>
             <b><?=tr("Disable all varfields and behaviors that are currently using this data group.")?></b>
             <br><b><?=tr("After that, delete the data group.")?></b>
           </td>
           <td class='bars' align='center'>
             <input type='submit' class='submit' value='<?=tr('Disable')?>' onClick="return setTodo('DISABLE')">
           </td>
	 </tr>
          <?php
  if( isset($_SESSION['data_groups']) && count($_SESSION['data_groups']) > 1 )  {
?>
	 <tr>
           <td class='bars' align='left'>
             <b><?=tr("Move all of it's references to")?></b>
             <select name='new_data_group'>
                 <?php
           $sel_item=" selected";
           foreach( $_SESSION['data_groups'] as $g ) {
             if ( $g['group_id'] != $group_id ) { 
               print "<option value='{$g['group_id']}'$sel_item>{$g['group_name']}</option>\n";
               $sel_item="";
             }
           }
?>
             </select>
             <br><b><?=tr("After that, delete the data group.")?></b>
           </td>
           <td class='bars' align='center'>
             <input type='submit' class='submit' value='<?=tr('Move')?>' onClick="return setTodo('MOVE')">
           </td>
	 </tr>
  <?php
  }
?>    

	 <tr>
           <td class='bars' align='left'>
             <b><?=tr("Cancel the request. DO NOT delete the data group.")?></b>
           </td>
           <td class='bars' align='center'>
             <input type='submit' class='submit' value='<?=tr('Cancel')?>' onClick="return setTodo('CANCEL')">
           </td>
	 </tr>


      </table>
      </ul>

      </form>


      <script language='javascript'>
          function setTodo( val ) {
           document.referencedGroupForm.TODO.value = val;
         }
      </script>
                                                                                                                             

