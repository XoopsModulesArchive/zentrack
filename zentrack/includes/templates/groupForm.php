<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

         $elnk="$rootUrl/admin/editGroup.php";
         $llnk="$rootUrl/admin/editGroupDetails.php";
         $dlnk="$rootUrl/admin/deleteGroup.php";
?>
      <br>
      <p><b><?=tr("Edit existing groups or create a new group.")?></b></p>
      <p class='error'><?php
         $str = "<a href='$rootUrl/help/find.php?s=admin&p=data_groups'>".tr('Documentation')."</a>";
         print tr("Please refer to the ? before using this feature", array($str));
       ?></p>      
      <ul>
      <form name='groupForm' action='<?=$elnk?>' method='post'>
      <input type='hidden' name='TODO' value=''>
      <table cellpadding="4" cellspacing="1" class='cell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='7'>
	   <b><?=tr("Data Groups")?></b>
	 </td>
	 </tr>
	 <tr>
           <td width="30" class='cell' align='center'><b><?=uptr("id")?></b></td>
           <td class='cell' align='center'><b><?=tr("Group Name")?></b></td>
           <td class='cell' align='center'><b><?=tr("Table Name")?></b></td>
           <td class='cell' align='center'><b><?=tr("Type")?></b></td>
           <td class='cell' align='center'><b><?=tr("Entries")?></b></td>
           <td class='cell' align='center'><b><?=tr("Description")?></b></td>
           <td class='cell' align='center'><b><?=tr("Actions")?></b></td>
	 </tr>
    <?php
         $tables=$zen->getDataGroupTablesArray();
         $vars = $_SESSION['data_groups'];
         $num = count($vars);
	 if( is_array($vars) ) {
	   $j = 0;
	   $t = "\t<td class='bars'>";
	   $te = "</td>\n";
	   foreach($vars as $v) {
	     $key = $v['group_id'];
	     print "<tr>\n";

	     // the id for the row
	     print $t.$key.$te;

	     // the group's name
	     print $t.$zen->ffv($v['group_name']).$te;

	     // the table for this group
             print $t;
             foreach($tables as $tbl_k=>$tbl_v) {
               if ($v['table_name']==$tbl_v) {
                 print $tbl_k;
               }
             }

	     // the eval type
	     print $t.$zen->ffv($v['eval_type']).$te;

	     // the number of details for this row
             print "$te\n";
	     if( $v['eval_type'] != 'Matches' ) {
	       $c = 'n/a';
	     }
	     else {
	       $c = count($v['fields']) > 0? count($v['fields']) : 0;
         if( $v['include_none'] ) {
           $c--; 
         }
	     }
	     print $t.$c.$te;

	     // description for the row
	     print $t.$zen->ffv($v['descript']).$te;

	     // the action links
             print $t;
             print "<span class='small'>"
	       . "[<a href='".$elnk."?group_id=".$v['group_id']."'>"
	       .uptr('properties')."</a>]";
             print "<br>";
	     if( $v['eval_type'] != 'Matches' ) {
	       print "<span class='smallGrey'>[".uptr("entries")."]</span>\n";
	     }
	     else {
	       print "<span class='small'>"
		 . "[<a href='".$llnk."?group_id=".$v['group_id']."'>"
		 .uptr('entries')."</a>]";
	     }
             print "<br>";
	     print "<span class='small'>"
		 . "[<a href='".$dlnk."?group_id=".$v['group_id']."' onclick='return confirm(\"Delete this group permanently?\")'>"
		 .uptr('delete')."</a>]";
	     print $te;
	       
	     print "</tr>\n";
	     $j++;
	   }
	 }
    ?>
<tr>
  <td class="titleCell" colspan="7">
    <?=tr('Press NEW to create new data groups')?>
    <br>
    <?=tr('Press DONE when you have finished with the edition')?>
  </td>
</tr>
      <tr>
         <td class='cell' colspan='3'>
         <input type='submit' class='submit' value='<?=tr('New')?>' onClick="return setTodo('NEW')">
         &nbsp;
         <input type='submit' class='submit' value='<?=tr('Done')?>' onClick="return setTodo('DONE')">
         </td>
      </tr>
      </table>
      </ul>

      </form>


      <script language='javascript'>
          function setTodo( val ) {
           document.groupForm.TODO.value = val;
         }
      </script>
                                                                                                                             

