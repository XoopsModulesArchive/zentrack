<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<!-- SUBMIT MENU -->
<tr>
  <td class='<?=($tf_options)? "titleCell" : "subTitle" ?>' colspan='3'>
    <?=tr("Submit Results")?>
  </td>
</tr>
<?
  if( $tf_type && $tf_data && $tf_date && $tf_options ) {
    // show the submit form
    print "<form method='post' action='$rootUrl/reports/view.php' name='reportSubmitForm'>\n";
    $zen->hiddenField("report_type",$report_type);
    $zen->hiddenField("data_set",$data_set);
    if( $date_selector == "value" ) {
	$zen->hiddenField( "date_low", $date_low );
    }
    $zen->hiddenField( array("date_selector" => $date_selector,
			       "date_value"  => $date_value,
			       "date_range"  => $date_range) );
    $zen->hiddenField("chart_title", $chart_title);
    $zen->hiddenField("chart_subtitle", $chart_subtitle);
    $zen->hiddenField("chart_add_ttl", $chart_add_ttl );
    $zen->hiddenField("chart_add_avg", $chart_add_avg );
    $zen->hiddenField("chart_combine",$chart_combine);
    $zen->hiddenField("text_output",$text_output);
    if( $chart_type == "Pie Chart" ) {
      $zen->hiddenField("chart_type", "pie" );			     
    }
    else if( $chart_type == "Line Chart" ) {
      $zen->hiddenField("chart_type", "line");
    }
    else if( $chart_type == "Bar Chart" ) {
      $zen->hiddenField("chart_type", "column" );
    } else if( $chart_type == "Scatter Chart" ) {
      $zen->hiddenField("chart_type", "scatter");
    }
    else if( $chart_type == "Stack Chart" ) {
      $zen->hiddenField("chart_type","stack");
    }
    if( is_array($chart_options) ) {
      $zen->hiddenField("chart_options",$chart_options);
    }
    $zen->hiddenField("show_data_vals",$show_data_vals);
?>
<tr>
  <td class='bars' colspan='3'><input type='submit' class='submit' value=' <?=tr("View Chart")?> '></td>
</tr>  
</form>
<?
  } else {
    // show the default text
?>
<tr>
  <td class='bars' colspan='3'>&nbsp;</td>
</tr>
<?					 
  }
?>

