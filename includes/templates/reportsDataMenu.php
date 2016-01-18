<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<!-- DATA MENU -->

<?php
  if( isset($data_set) && strlen($data_set) && !is_array($data_set) ) {
    $data_set = split("[,]+",preg_replace("@[^0-9]+@",",",$data_set));
  }
  if( is_array($data_set) ) {
    for($i=0; $i<count($data_set);$i++) {
      $data_set[$i] = $zen->checkNum($data_set[$i]);
    }
  }

  // set a toggle
  $tf_data = (isset($data_set)&&is_array($data_set)&&count($data_set));

?>
<tr>
  <td class='<?=($tf_type && !$tf_data)?"titleCell":"subTitle"?>' colspan='3'>
    <?=tr("Data Selection")?>
  </td>
</tr>
<?php
  if( $tf_type ) {     
    switch($report_type) {
    case "Bin":
      $type_list = $zen->getBins();
      break;
    case "Type":
      $type_list = $zen->getTypes();
      break;
    case "System":
      $type_list = $zen->getSystems();
      break;
    case "Project ID":
      $searchbox = "projectSearchbox";
      break;
    case "Ticket ID":
      $searchbox = "ticketSearchbox";
      break;
    case "User ID":
      $searchbox = "userSearchbox";
      break;
    default:      
      $zen->addDebug("reports/reportsDataMenu.php",
		     "Invalid report type speicifed: $report_type",1);
      break;
    }
?>
<form method='post' action='<?=$rootUrl?>/reports/custom.php' name='reportDataForm'>
<input type='hidden' name='report_type' value='<?=$zen->ffv($report_type)?>'>
<tr>
  <td class="bars">
    <?=tr("Select ?s",array($zen->ffv($report_type)))?>
  </td>
  <td class="bars">
      <?php
   if( $searchbox ) {
     print "<textarea cols='20' rows='4' name='data_set'>";
     print (is_array($data_set))? join(",",$data_set) : "";
     print "</textarea>\n";
     $onclick = "onClick='return popupWindowScrolls(\"$rootUrl/helpers/$searchbox.php?return_form=reportDataForm&return_field=data_set\",\"popupHelper\",375,400)'";
     print "&nbsp;<input type='button' class='searchbox' value=' ... ' $onclick>\n";
     print "<br><span class='note'>".tr("Type ids separated by commas, or press button to search")."</span>\n";
   } else {
     print "<select name='data_set[]' multiple>\n";
     if( !is_array($type_list) || count($type_list) < 1 ) {
       print "\t<option value=''>".tr("None found")."</option>\n";
     }
     else { 
       foreach($type_list as $k=>$v) {
	 $sel = (is_array($data_set) && in_array($k,$data_set))?
	   " selected" : "";
	 print "<option value='$k'$sel>$v</option>\n";
       }
     }
     print "</select>\n";
     print "<br><span class='note'>".tr("Select multiples using control-click")
	."</span>\n";
   }
?>
  </td>
  <td class='bars'>
    <input type='hidden' name='action' value='set_report'>
   <?php if( $tf_data ) { ?>
    <input type='submit' value=' <?=tr("Change")?> '>
   <?php } else { ?>
    <input type='submit' class='submit' value=' <?=tr("Set")?> '>
   <?php } ?>
  </td>
</tr>
</form>

<?php
  } else { // show the empty set
?>
<tr>
  <td class='bars' colspan='3'>&nbsp;</td>
</tr> 

<?php } ?>


