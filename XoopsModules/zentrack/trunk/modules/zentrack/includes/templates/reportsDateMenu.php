<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<!-- DATE MENU -->
<?php
  // validate data
  if( $date_value ) {
    $date_value = $zen->checkNum($date_value);
  }
  if( $date_start ) {
    $date_low = $zen->dateParse($date_start);
  }
  if( $date_low ) {
    $date_start = strftime($zen->date_fmt_short,$date_low);
  } else if( !$date_selector ) {
    $date_selector = "range";
  }
  if( $date_range ) {
    $date_range = $zen->checkAlphaNum($date_range);  // just chars
  }
  // set a toggle for date info entered
  $tf_date = ($date_value&&$date_range
	      &&($date_selector=="range"||$date_low > 0));


?>
<tr>
  <td class='<?php echo ($tf_data && !$tf_date)?"titleCell":"subTitle"?>' colspan='3'>
    <?php echo tr("Date Range"); ?>
  </td>
</tr>

<?php if( !$tf_data ) { ?>

<tr>
  <td class='bars' colspan='3'>&nbsp;</td>
</tr>

<?php } else { ?>
 
<form method='post' action='<?php echo $rootUrl?>/reports/custom.php' name='reportDateForm'>
<input type='hidden' name='report_type' value='<?php echo $zen->ffv($report_type); ?>'>
<?php 
  for($i=0; $i<count($data_set); $i++) {
     print "<input type='hidden' name='data_set[$i]' value='".$zen->ffv($data_set[$i])."'>\n";
  } 
?>
<tr>
  <td class="bars">
    <?php echo tr("Range"); ?>
  </td>
  <td class="bars">
    <select name='date_value'>
    <?php
      for($i=1; $i<21; $i++) {
	$sel = ($date_value == $i)? " selected" : "";
	print "\t<option$sel>$i</option>\n";
      }
    ?>
    </select>
    &nbsp;
    <select name='date_range'>
       <option value='hours'<?php echo ($date_range == "hours")?" selected":""?>
	  value="Hours"><?php echo tr("Hours"); ?></option>
       <option value='days'<?php echo ($date_range == "days")?" selected":""?>
	  value="Days"><?php echo tr("Days"); ?></option>
       <option value='weeks'<?php echo ($date_range == "weeks")?" selected":""?>
	  value="Weeks"><?php echo tr("Weeks"); ?></option>
       <option value='months'<?php echo ($date_range == "months")?" selected":""?>
	  value="Months"><?php echo tr("Months"); ?></option>
       <option value='years'<?php echo ($date_range == "years")?" selected":""?>
	  value="Years"><?php echo tr("Years"); ?></option>
    </select>
  </td>
  <td rowspan='3' class='bars'>
   <?php if( $tf_date ) { ?>
    <input type='submit' value=' <?php echo tr("Change"); ?> '>
   <?php } else { ?>
    <input type='submit' class='submit' value=' <?php echo tr("Set"); ?> '>
   <?php } ?>
  </td>
</tr>
<tr>
  <td class="bars" colspan='2'>
    <?php $chkd = (!strlen($date_selector)||$date_selector == "range")? " checked" : ""; ?>
    <input type='radio' name='date_selector' value='range'<?php echo $chkd?>>
	&nbsp; <?php echo tr("Most Current"); ?>
  </td>
</tr>
<tr>
  <td class="bars">
    <?php $chkd = ($date_selector == "value")? " checked" : ""; ?>
    <input type='radio' name='date_selector' value='value'<?php echo $chkd?>>
	&nbsp;<?php echo tr("Start From Date"); ?>
  </td>
  <td class="bars">
    <input type='text' onFocus="moveReportSelector()" name='date_start' maxlength='12' size='14' value='<?php echo $zen->ffv($date_start); ?>'>
    <span class='note'>(<?php echo tr("Any valid date format"); ?> <?php echo tr("use 4 digit year, time is optional"); ?>)</note>
  </td>
</tr>
</form>

<script language='javascript'>
  function moveReportSelector() {
     document.reportDateForm.date_selector[1].checked = true;
  }
</script>

<?php } ?>









