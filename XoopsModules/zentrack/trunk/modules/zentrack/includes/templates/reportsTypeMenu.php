<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  // set a toggle
  if( $report_type )
     $report_type = $zen->checkAlphaNum($report_type,"_ ");
  $tf_type = (isset($report_type) && $report_type != "");
?>
<form method='post' action='<?php echo $rootUrl?>/reports/custom.php'>
<tr>
  <td colspan="3" width="640" class="<?php echo (!$tf_type)?"titleCell":"subTitle"?>">
     <?php echo tr("Report Type"); ?>
  </td>
</tr>
<tr>
  <td class="bars" width='150'>
    <?php echo tr("Pick a type"); ?>
  </td>
  <td class="bars" width='390'>
    <select name='report_type'>
       <option<?php echo ($report_type=="Bin")?" selected":""?>
	  value="Bin"><?php echo tr("Bin"); ?></option>
       <option<?php echo ($report_type=="Project ID")?" selected":""?>
	  value="Project ID"><?php echo tr("Project ID"); ?></option>
       <option<?php echo ($report_type=="System")?" selected":""?>
	  value="System"><?php echo tr("System"); ?></option>
       <option<?php echo ($report_type=="Ticket ID")?" selected":""?>
	  value="Ticket ID"><?php echo tr("Ticket ID"); ?></option>
       <option<?php echo ($report_type=="Type")?" selected":""?>
	  value="Type"><?php echo tr("Type"); ?></option>
       <option<?php echo ($report_type=="User ID")?" selected":""?>
	  value="User ID"><?php echo tr("User ID"); ?></option>
    </select>
  </td>
  <td class='bars' width='100'>
    <input type='hidden' name='action' value='set_report'>
   <?php if( $tf_type ) { ?>
    <input type='submit' value=' <?php echo tr("Change"); ?> '>
   <?php } else { ?>
    <input type='submit' class='submit' value=' <?php echo tr("Set"); ?> '>
   <?php } ?>
  </td>
</tr>
</form>
