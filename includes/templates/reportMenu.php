<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<table width='300'>
<tr>
  <td class='titleCell' align='center'><?=tr("View Reports")?></td>
</tr>
<tr>
  <td class='bars' height='40' valign='top'>
   <form action='<?=$rootUrl?>/reports/show.php' method='get'>
   <select name='repid'>
       <?php
$usersBins = $zen->getUsersBins($login_id,'level_reports');
   $reps = $zen->getReportTemplates($usersBins,$login_id);
   if( is_array($reps) && count($reps) ) {
     foreach($reps as $r) {
       print "<option value='{$r['report_id']}'>".$r["report_name"]."</option>\n";
     }
   } else {
     print "<option value=''>--".tr("none")."--</option>\n";
   } 
?>
   </select>
   &nbsp;<input class='submit' type='submit' value='<?=tr("View")?>'>
       	</form>
  </td>
</tr>
<tr>
  <td class='titleCell' align='center'><?=tr("Manage Reports")?></td>
</tr>
<tr>
  <td class='subTitle' align='center'><?=tr("Modify Reports")?></td>
</tr>
<tr>
  <td class='bars' height='40' valign='top'>
    <form method='get' action='custom.php'>
      <select name='repid'><?
   if( is_array($reps) && count($reps) ) {
     foreach($reps as $r) {
       print "<option value='{$r['report_id']}'>{$r['report_name']}</option>\n";
     }
   } else {
     print "<option value=''>--".tr("none")."--</option>\n";
   } 
?></select>&nbsp;<input type='submit' class='submit' value='<?=tr("Modify")?>'>
    </form>
  </td>
</tr>
<tr>
  <td class='subTitle'><?=tr("Delete Reports")?></td>
</tr>
<tr>
  <td class='bars'>
    <form method='get' action='drop.php'>
      <select name='repid'>
          <?php
   if( is_array($reps) && count($reps) ) {
     foreach($reps as $r) {
       print "<option value='{$r['report_id']}'>{$r['report_name']}</option>\n";
     }
   } else {
     print "<option value=''>--".tr("none")."--</option>\n";
   } 
?>
     </select>
     &nbsp; <input type='submit' class='submit' value='<?=tr("Delete")?>' 
	onClick='return confirm("<?=tr("Are you sure you want to permanently delete this template?")?>")'>
    </form>
  </td>
</tr>
<tr>
  <td class='subTitle'><?=tr("Create Reports")?></td>
</tr>
<tr>
  <td class='bars'>
    <form method='get' action='custom.php'>
      <input type='submit' class='submit' value='<?=tr("New Report")?>'>
    </form>
  </td>
</tr>
</table>






