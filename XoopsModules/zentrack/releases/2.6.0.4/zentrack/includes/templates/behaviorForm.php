<?
if( !ZT_DEFINED ) { die("Illegal Access"); }

  // generate some text to display based on whether this
  // is an edit page or an add page
  $td = ($TODO == 'EDIT');
  $blurb = ($td)? "Modify Behavior" : "Create New Behavior";
  $button = ($td)? "Save Changes" : "Create Behavior";
  $url = ($td)? "edit" : "add";
?>
<form method="post" action="<?=$rootUrl?>/admin/<?=$url?>BehaviorSubmit.php">
<? if( $td ) { print "<input type='hidden' name='behavior_id' value='".strip_tags($behavior_id)."'>\n"; } ?>
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->getSetting("color_background")?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
  <?=$blurb?>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Behavior Information")?> (<?=tr("* = required")?>)
  </td>
</tr>  
<tr>
  <td class="bars" width='125'>
    <?=tr("Behavior Name")?>*
  </td>
  <td class="bars">
    <input type="text" name="NewBehaviorName" value="<?=strip_tags($behavior['behavior_name'])?>" size="40" maxlength="100">
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Active")?>
  </td>
    <?
         $t = "\t<td class='bars'>";
         $te = "</td>\n";
         $sel = !$td || $behavior['is_enabled']? ' checked' : '';
         print "$t<input type='checkbox' name='NewIsEnabled' value='1'$sel>\n";
         print "$te";
    ?>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Data Group")?>*
  </td>
    <?
       $t = "\t<td class='bars'>";
       $te = "</td>\n";
       $groups=$zen->getDataGroups(0);
       print "$t<select name='NewGroupId'>\n";
       foreach($groups as $grp_k=>$grp_v) {
         $sel=($behavior['group_id']==$grp_k)? " selected" : "";
         print "<option value='$grp_k'$sel>$grp_v</option>\n";
       }
       print "$te";
    ?>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Sort Order")?>
  </td>
  <td class="bars">
    <input type="text" name="NewSortOrder" value="<?=strip_tags($behavior['sort_order'])?>" size="40" maxlength="255">
    <div class='note'><?=tr("The sort order is critical.  If two behaviors conflict, the sort order decides which one gets to run and which one is ignored.")?></div>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Field to change")?>*
  </td>
    <?
         $t = "\t<td class='bars'>";
         $te = "</td>\n";
         print "$t<select name='NewFieldName'>\n";
         foreach($field_list as $fl=>$fn) {
           $sel=($behavior['field_name']==$fn)? " selected" : "";
           print "<option value='$fn'$sel>$fl</option>\n";
         }
         print "$te";
    ?>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Field is enabled")?>
  </td>
  <td class='bars'>
  <?
         $sel = !$td || $behavior['field_enabled']? ' checked' : '';
         print "<input type='checkbox' value='1' name='NewFieldEnabled'$sel>\n";
    ?>
    <div class='note'><?=tr("If the behavior runs, the field will be 
    disabled/enabled based on this checkbox")?></div>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Match Type")?>*
  </td>
    <?
         $t = "\t<td class='bars'>";
         $te = "</td>\n";
         print "$t<select name='NewMatchAll'>\n";
         print "<option value='0'";
         print ($behavior['match_all']==1)?"" : " selected";
         print ">".tr("Match Any Rule")."</option>\n";
         print "<option value='1'";
         print ($behavior['match_all']==1)?" selected" : "";
         print ">".tr("Match All Rules")."</option>\n";
         print "$te";
    ?>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Click ? to ?",array($button,$blurb))?>.
  </td>
</tr>  
<tr>
  <td colspan="2" class="bars">
   <input type="submit" value="<?=$button?>" class="submit">
  </td>
</tr>
</table>

</form>
