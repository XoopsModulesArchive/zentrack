<?
if( !ZT_DEFINED ) { die("Illegal Access"); }

  // set a toggle
  if( $report_type )
     $report_type = $zen->checkAlphaNum($report_type,"_ ");
  $tf_type = (isset($report_type) && $report_type != "");
?>
<form method='post' action='<?=$rootUrl?>/reports/custom.php'>
<tr>
  <td colspan="3" width="640" class="<?=(!$tf_type)?"titleCell":"subTitle"?>">
     <?=tr("Report Type")?>
  </td>
</tr>
<tr>
  <td class="bars" width='150'>
    <?=tr("Pick a type")?>
  </td>
  <td class="bars" width='390'>
    <select name='report_type'>
       <option<?=($report_type=="Bin")?" selected":""?>
	  value="Bin"><?=tr("Bin")?></option>
       <option<?=($report_type=="Project ID")?" selected":""?>
	  value="Project ID"><?=tr("Project ID")?></option>
       <option<?=($report_type=="System")?" selected":""?>
	  value="System"><?=tr("System")?></option>
       <option<?=($report_type=="Ticket ID")?" selected":""?>
	  value="Ticket ID"><?=tr("Ticket ID")?></option>
       <option<?=($report_type=="Type")?" selected":""?>
	  value="Type"><?=tr("Type")?></option>
       <option<?=($report_type=="User ID")?" selected":""?>
	  value="User ID"><?=tr("User ID")?></option>
    </select>
  </td>
  <td class='bars' width='100'>
    <input type='hidden' name='action' value='set_report'>
   <? if( $tf_type ) { ?>
    <input type='submit' value=' <?=tr("Change")?> '>
   <? } else { ?>
    <input type='submit' class='submit' value=' <?=tr("Set")?> '>
   <? } ?>
  </td>
</tr>
</form>
