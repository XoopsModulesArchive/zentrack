<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

         $elnk="$rootUrl/admin/editBehavior.php";
         $llnk="$rootUrl/admin/editBehaviorDetails.php";
         $dlnk="$rootUrl/admin/deleteBehavior.php";
?>
      <br>
      <p><b><?=tr("Edit existing behaviors or create a new one.")?></b></p>
      <p>Note that behaviors are meant to provide suggested values to
         the user.  They are not meant to be used as a security mechanism
         and could be circumvented by creative users.</p>
      <p class='error'><?php
         $str = "<a href='$rootUrl/help/find.php?s=admin&p=behaviors'>".tr('Documentation')."</a>";
         print tr("Please refer to the ? before using this feature", array($str));
       ?></p>
      <ul>
      <form name='behaviorForm' action='<?=$elnk?>' method='post'>
      <input type='hidden' name='TODO' value=''>
      <table cellpadding="4" cellspacing="1" class='cell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='9'>
	   <b><?=tr("Edit the Behaviors")?></b>
	 </td>
	 </tr>
<tr>
  <td class='subTitle' width='30' align='center'><b><?=tr("ID")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Enabled")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Sort Order")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Behavior Name")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Match Type")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Field Name")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Group to apply")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Field State")?></b></td>
  <td class='subTitle' align='center'><b><?=tr("Actions")?></b></td>
</tr>

<?php
   $behaviors = $zen->getBehaviorList(0);
   $groups=$zen->getDataGroups(0);
   $num = count($behaviors);
	 if( is_array($behaviors) ) {
	   $j = 0;
	   $t = "\t<td class='bars'>";
	   $te = "</td>\n";
	   foreach($behaviors as $k => $v) {
	     print "<tr>\n";
	     print $t.$k.$te;
	     print $t.$zen->ffv(($v['is_enabled'])?tr("Yes") : tr("No")).$te;
	     print $t.$v['sort_order'].$te;
	     print $t.$zen->ffv($v['behavior_name']).$te;
	     print $t.$zen->ffv(($v['match_all'])?
          tr("All rules") : tr("Any rule")).$te;
	     print $t.$zen->ffv($v['field_name']).$te;
       if( $tf_file ) {
         print $t."<b>".$groups[$v['group_id']]."</b>".$te;
       }
       else {
         print $t.$groups[$v['group_id']].$te;    
       }
	     print $t.$zen->ffv(($v['field_enabled'])?
          tr("Normal") : tr("Read-only")).$te;
       print $t;
       
       print "\n<span class='small'>"
          . "[<a href='".$elnk."?behavior_id=".$v['behavior_id']."'>"
          . uptr('properties')."</a>]</span>";
       print "<br>";
       //if( !$tf_file ) {
         print "\n<span class='small'>"
            . "[<a href='".$llnk."?behavior_id=".$v['behavior_id']."'>"
            . uptr('rules')."</a>]</span>";
       //}
       //else {
       //  print "\n<span class='smallGrey'>[".uptr('rules')."]</a></span>"; 
       //}
       print "<br>";
       print "\n<span class='small'><span class='error'>"
           . "[<a href='".$dlnk."?behavior_id=".$v['behavior_id']."'"
           . "onClick='return confirm(\""
           . tr("Permanently remove behavior ??",array($v['behavior_id']))."\");'>"
           . uptr("delete")."</a>]</span></span>";
       
       print $te;
       
	     print "</tr>\n";
	     $j++;
	   }
	 }
    ?>
<tr>
  <td class="titleCell" colspan="9">
    <?=tr('Press NEW to create new behaviors')?>
    <br>
    <?=tr('Press DONE when you are finished')?>
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
           document.behaviorForm.TODO.value = val;
         }
      </script>
                                                                                                                             

