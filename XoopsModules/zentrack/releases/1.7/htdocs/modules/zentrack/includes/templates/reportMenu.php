<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<table width='300'>
<tr>
  <td class='titleCell' align='center'><?php echo tr("View Reports"); ?></td>
</tr>
<tr>
  <td class='bars' height='40' valign='top'>
   <form action='<?php echo $rootUrl?>/reports/show.php' method='get'>
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
   &nbsp;<input class='submit' type='submit' value='<?php echo tr("View"); ?>'>
       	</form>
  </td>
</tr>
<tr>
  <td class='titleCell' align='center'><?php echo tr("Manage Reports"); ?></td>
</tr>
<tr>
  <td class='subTitle' align='center'><?php echo tr("Modify Reports"); ?></td>
</tr>
<tr>
  <td class='bars' height='40' valign='top'>
    <form method='get' action='custom.php'>
      <select name='repid'><?php
   if( is_array($reps) && count($reps) ) {
     foreach($reps as $r) {
       print "<option value='{$r['report_id']}'>{$r['report_name']}</option>\n";
     }
   } else {
     print "<option value=''>--".tr("none")."--</option>\n";
   } 
?></select>&nbsp;<input type='submit' class='submit' value='<?php echo tr("Modify"); ?>'>
    </form>
  </td>
</tr>
<tr>
  <td class='subTitle'><?php echo tr("Delete Reports"); ?></td>
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
     &nbsp; <input type='submit' class='submit' value='<?php echo tr("Delete"); ?>' 
	onClick='return confirm("<?php echo tr("Are you sure you want to permanently delete this template?"); ?>")'>
    </form>
  </td>
</tr>
<tr>
  <td class='subTitle'><?php echo tr("Create Reports"); ?></td>
</tr>
<tr>
  <td class='bars'>
    <form method='get' action='custom.php'>
      <input type='submit' class='submit' value='<?php echo tr("New Report"); ?>'>
    </form>
  </td>
</tr>
</table>






