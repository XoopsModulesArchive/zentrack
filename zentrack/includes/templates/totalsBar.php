<?
 /**
  * GENERATE A TOTALS PRINTOUT
  *
  * REQUIREMENTS
  *    $cols - total number of columns in table
  *    $est_col - est_hours column (or zero)
  *    $wkd_col - wkd_hours column (or zero)
  *    $ttl_est - total of all rows for est_hours
  *    $ttl_wkd - total of all rows for wkd_hours (up to 100% for each row)
  *    $ttl_ext - total of all rows for wkd_hours (can be over 100% for each row)
  *    $totals_titlebar_txt - name of the bar
  */
  
  $ttl_per_txt = "n/a";
  if( $ttl_est ) {
    $ttl_per_txt = $zen->percentWorked($ttl_est,$ttl_wkd).tr('%');
  }
  $ttl_est_txt = strlen($ttl_est)? number_format($ttl_est, $num, $dec, $sep) : '&nbsp;';
  $ttl_ext_txt = strlen($ttl_ext)? number_format($ttl_ext, $num, $dec, $sep) : '&nbsp;';

  $from = 1;
  $to = $cols;
  if( $est_col && $wkd_col ) {
    $l = $est_col < $wkd_col? $est_col : $wkd_col;
    $g = $est_col > $wkd_col? $est_col : $wkd_col;
    if( $l == 1 ) {
      if( $g == 2 ) {
        // if our totals occupy the first two columns, start from
        // the third
        $from = 3;
        $to = $cols;
      }
      else {
        // if one of our totals occupies the first column, start
        // from the second
        $from = 2;
        $to = $g;
      }
    }
    else {
      $to = $l;
    }
  }
  else if( $est_col || $wkd_col ) {
    $l = $est_col? $est_col : $wkd_col;
    if( $l == 1 ) {
      // if our total occupies the first column, then start from the second
      $from = 2;
    }
    else {
      $to = $l;
    }
  }
  
  print "<tr class='headerCell'>\n";
  for($i=1; $i <= $cols; $i++) {
    if( $i == $est_col ) {
      // this is our est total
      print "<td align='right'>$ttl_est_txt</td>\n";
      $next = $i+1;
    }
    else if( $i == $wkd_col ) {
      // this is our wkd total
      print "<td align='right'>$ttl_ext_txt</td>\n";
      $next = $i+1;
    }
    else if( $i == $from ) {
      // this is our totals label cell
      $colspan = $to-$from > 1? "colspan='".($to-$from)."'" : '';
      print "<td $colspan align='right'>{$totals_titlebar_txt}&nbsp;&nbsp;</td>\n";
      $next = $to;
    }
    else if( $i != $cols && $i == $next ) {
      // this is some random column between our values
      // see if we should colspan this and make some empty space
      $n = $cols;
      if( $est_col > $next && $est_col < $n ) { $n = $est_col; }
      if( $wkd_col > $next && $wkd_col < $n ) { $n = $wkd_col; }
      if( $from > $next && $from < $n ) { $n = $from; }
      $colspan = ($n - $next > 1)? "colspan='".($n-$next)."'" : '';
      print "<td $colspan>&nbsp;</td>\n";
    }
    else if( $i == $cols ) {
      // this is our totals column
      print "<td align='right'>$ttl_per_txt</td>\n";         
    }
  }
  print "</tr>\n";
?>