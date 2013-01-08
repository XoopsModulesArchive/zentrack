<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }


/*
**
**  zenDate Class
**
**  Version: 1.2
**  Updated: 12/05/01
**
*/

include_once("$libDir/db.class.php");

class zenDate extends DB {
  
  var $nowParts;
  var $now;
  var $currTime;
  
  var $dayOfWeek = array(
  "",
  "Sunday",
  "Monday",
  "Tuesday",
  "Wednesday",
  "Thursday",
  "Friday",
  "Saturday"
  );
  
  var $monthNames = array(
  "",
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December"
  );
  
  var $daysInMonth = array(
  0,
  31,
  28,
  31,
  30,
  31,
  30,
  31,
  31,
  30,
  31,
  30,
  31
  );
  
  var $euroEnabled = false;
  
  function zenDate( $currTime = '' ) {
    $this->nowParts = getdate(time());
    $this->now = time();
    if( $currTime )
    $this->currTime = $currTime;
    else
    $this->currTime = $this->now;
  }
  
  function showDay( $utime = '', $flag = '' ) {
    if( !$utime )
    $utime = $this->currTime;
    $dateParts = $this->dateSplit( $utime );
    $day = $dateParts["mday"];
    
    $mday = (ereg("^[0-9]+$", $flag))? substr($day, 0, $flag) : $day;
    return($mday);
  }
  
  function showWeekday( $utime = '', $flag = '' ) {
    if( !$utime )
    $utime = $this->currTime;
    $dateParts = $this->dateSplit( $utime );
    $day = $dateParts["weekday"];
    
    $weekday = (ereg("^[0-9]+$", $flag))? substr($day, 0, $flag) : $day;
    return($weekday);
  }
	
  function showWeekdayNum( $utime = '' ) {
    if( !$utime )
    $utime = $this->currTime;
    $dateParts = $this->dateSplit( $utime );
    return( $dateParts["wday"]+1 );
  }
	
  function showDayOfYear( $utime = '', $flag = '' ) {
    if( !$utime )
    $utime = $this->currTime;
    $dateParts = $this->dateSplit( $utime );
    $day = $dateParts["yday"];
    
    return($day);
  }
	
  function showWeekNum( $utime = '' ) {
    $day = $this->showDayOfYear( $utime );
    return( intval($day / 7) );
  }
  
  function showMonth( $utime = '', $flag = '' ) {
    if( !$utime )
    $utime = $this->currTime;
    $dateParts = $this->dateSplit( $utime );
    $month = $dateParts["month"];
    
    $m = (ereg("^[0-9]+$", $flag))? substr($month, 0, $flag) : $month;
    return($m);
  }
	
  function showMonthNum( $utime = '' ) {
    if( !$utime )
    $utime = $this->currTime;
    $dateParts = $this->dateSplit( $utime );
    return( $dateParts["mon"] );
  }
  
  function showYear( $utime = '', $flag = '' ) {
    if( !$utime )
    $utime = $this->currTime;
    $dateParts = $this->dateSplit( $utime );
    $day = $dateParts["year"];
    
    $yday = (ereg("^[0-9]+$", $flag))? substr($day, (4-$flag), $flag) : $day;
    return($yday);
  }
  
  function showDate( $utime = '') {
    if( !$utime )
    $utime = $this->currTime;
    return strftime($this->date_fmt_short,$utime);
  }
  
  function showTime( $utime = '', $flag = '' ) {
    if( !$utime )
    $utime = $this->currTime;
    $newtime = (ereg("M",$flag))? strftime("%H:%M", $utime) : strftime("%I:%M %p", $utime);
    return( $newtime );
  }
  
  function showHour( $utime = '', $flag = '' ) {
    if( !$utime )
    $utime = $this->currTime;
    $newtime = (eregi("M",$flag))? date("H", $utime) : date("I p", $utime);
    return $newtime;
  }
  
  function showDateTime( $utime = '', $flag = '' ) {
    if( !$utime )
    $utime = $this->currTime;
    if( ereg("4", $flag ) )
    $newtime = (ereg("M",$flag))? strftime("%m/%d/%Y %R", $utime) : strftime("%m/%d/%y %r", $utime);
    else
    $newtime = (ereg("M", $flag))? strftime("%D %R", $utime) : strftime("%D %r", $utime);
    return( $newtime );
  }
  
  function showLongDate( $utime = '', $flag = '' ) {
    if( !$utime )
    $utime = $this->currTime;
    $newtime = ($flag)? strftime("%a, %b %e, %Y", $utime) : strftime("%A, %B %e, %Y", $utime);
    return( $newtime );
  }
  
  function showLongTime( $utime = '', $flag = '' ) {
    if( !$utime )
    $utime = $this->currTime;
    $newtime = (ereg("M",$flag))? strftime("%H:%M:%S %Z", $utime) : strftime("%I:%M:%S %p %Z", $utime);
    return( $newtime );
  }
  
  function showLongDateTime( $utime = '', $flag = '' ) {
    if( !$utime )
    $utime = $this->currTime;
    if( ereg("M", $flag) )
    $newtime = (ereg("[0-9]",$flag))? strftime("%H:%M:%S %a, %b %e, %Y", $utime) : strftime("%H:%M:%s %A, %B %e, %Y", $utime);
    else
    $newtime = ($flag)? strftime("%I:%M:%S %a, %b %e, %Y", $utime) : strftime("%I:%M:%S %p, %A, %B %e, %Y", $utime);
    return( $newtime );
  }
  
  function get_monthName( $num ) {   
    while( $num > 12 ) { $num -= 12; }
    while( $num < 1 ) { $num += 12; }
    return( $this->monthNames[$num] );
  }
  
  function get_dayOfWeek( $num ) {
    while( $num > 7 ) { $num -= 7; }
    while( $num < 1 ) { $num += 7; }
    return( $this->dayOfWeek[$num] );
  }
  
  function get_daysInMonth( $num, $flag = '' ) {
    while( $num > 12 ) { $num -= 12; }
    while( $num < 1 ) { $num += 12; }
    if( $num == 2 && $flag )
    return(29);
    else
    return( $this->daysInMonth[$num] );     
  }
  
  function daysInMonth($utime) {
    if( !$utime )
    $utime = $this->currTime;
    $flag = ($this->showYear($utime)%4 == 0);
    $month = $this->showMonthNum($utime);
    return ($this->get_daysInMonth( $month, $flag));
  }
  
  function get_WeekdaysInMonth( $weekday, $utime = '' ) {
    if( !$utime )
    $utime = $this->currTime;
    $curr = $this->dateAnchor('month', $utime);
    $daysInMonth = $this->daysInMonth($utime);
    $month = $this->showMonthNum($utime);
    $i = 0;
    while( strtolower(substr($weekday,0,3)) != strtolower(substr($this->showWeekday($curr),0,3)) ) {
      $curr = $this->dateAdjust( 1, 'day', $curr );
      $i++;
      if( $i > 14 ) {
        return; //prevent infinite loop on event that user passes incorrect weekday
      }
    }
    while( $this->showDay($curr) <= $daysInMonth  && $this->showMonthNum($curr) == $month ) {
      $days[] = $this->showDay($curr);
      $curr = $this->dateAdjust( 7, 'days', $curr );
    }
    return($days);
  }
  
  function secondsIn( $measure, $num = 1 ) {
    switch( strtolower(substr($measure,0,3)) ) {
      case "min":
      $conv = 60 * $num;
      break;
      case "hou":
      $conv = 3600 * $num;
      break;
      case "day":
      $conv = 86400 * $num;
      break;
      case "wee":
      $conv = 604800 * $num;
      break;
      case "mon":
      $conv = 365 / 12 * $num;
      break;
      case "yea":
      $conv = 31536000 * $num;
      break;
      default:
      $conv = 1 * $num;
      break;
    }			 
    return $conv;
  }
  
  function dateDiff( $end = '', $start = '', $measure = 'seconds', $marker = '' ) {
    if( !$end ) { $end = $this->currTime; }
    if( !$start ) { $start = $this->now; }
    $val = (( $end - $start ) / $this->secondsIn($measure));
    if( $marker ) {
      global $$marker;
      $$marker = $val;
    }
    return($val);
  }
  
  function dateMake( $vals ) {
    if( $vals[6] && eregi("p", $vals[6]) )
    $vals[3] += 12;
    
    $date = mktime($vals[3], $vals[4], $vals[5], $vals[1], $vals[2], $vals[0]);
    return($date);
  }
  
  function dateParse( $ctime = '' ) {
    // takes almost any date format
    // and returns the unix timestamp for
    // that date
    $ctime = trim($ctime);
    
    //Prevent parsing an already parsed date:
    if( strval(intval($ctime)) == $ctime ) {
      return $ctime;
    }
    
    if( !$ctime )
    $ctime = $this->currTime;
    // separator to parse euro date
    $sep = '[/.,-]';
    // if we have eurodate = true and the date is in the format dd/mm/yy[yy] then parse as euro
    if( $this->euroEnabled && preg_match("#^[0-9]{2}{$sep}[0-9]{2}{$sep}[0-9]{2,4}#", $ctime) ) {
      // split date and time
      list($date, $time) = explode(' ', $ctime);
      // break up date
      list($day, $month, $year) = split($sep, $date);
      // break up time
      list($hours, $mins, $seconds) = split('[.,:-]', $time);
      // create a unix timestamp and return
      return mktime($hours, $mins, $seconds, $month, $day, $year);
    }
    // otherwise it's english to treat it so
    else {
      return strtotime($ctime);
    }
  }
  
  function dateSplit($utime = '') {
    if( !$utime )
    $utime = $this->currTime;
    return( getdate($utime) );
  }
  
  function dateAdjust( $adj, $period = '', $date = '' ) {
    // adjusts a date by a given interval(period)
    // valid $adj values are a positive or negative integer
    // valid periods are things like: "hours", "seconds", "minutes", "days", etc
    // see php.net function: strtotime for more info
    // $date can be any valid date format
    if( $date == '' )
    $date = $this->currTime;
    else if( preg_match("@[^0-9]@", $date) )
    $date = $this->dateParse($date);      
    $newtime = strtotime("$adj $period",$date);
    return($newtime);
  }
  
  function dateAnchor( $period = 'month', $date = '', $end = '' ) {
    if( !$date )
    $date = $this->currTime;
    
    $dateParts = $this->dateSplit($date);
    $year = $dateParts["year"];
    $month = $dateParts["mon"];
    $day = $dateParts["mday"];
    $hour = $dateParts["hours"];
    $min = $dateParts["minutes"];
    $sec = $dateParts["seconds"];
    
    $period = strtolower(substr($period, 0, 2));
    switch($period) {
      case "ce":
      if( $end )
      $year += 100;
      $year = $year - substr($year, 2, 2);
      $month = $day = 1;
      $hour = $min = $sec = 0;
      break;
      case "de":
      if( $end )
      $year += 10;
      $year = $year - substr($year, 3, 1);
      $month = $day = 1;
      $hour = $min = $sec = 0;
      break;
      case "ye":
      if( $end )
      $year++;
      $month = $day = 1;
      $hour = $min = $sec = 0;
      break;
      case "qu":
      if( $end )
      $month += 3;
      $month = $month - floor( $month / 4 ) + 1 ;
      $day = 1;
      $hour = $min = $sec = 0;
      break;
      case "mo":
      if( $end )
      $month++;
      $day = 1;
      $hour = $min = $sec = 0;
      break;
      case "we":
      if( $end )
      $week++;
      $wday = $dateParts["wday"];
      $day = $day - $wday + 1;
      $hour = $min = $sec = 0;
      break;
      case "da":
      if( $end )
      $day++;
      $hour = $min = $sec = 0;
      break;
      case "ho":
      if( $end )
      $hour++;
      $min = $sec = 0;
      break;
      case "mi":
      if( $end )
      $min++;
      $sec = 0;
      break;
    }
    $dateParts = array( $year, $month, $day, $hour, $min, $sec );
    return( $this->dateMake($dateParts) );
  }
  
  function dateSQL( $date = '' ) {
    // creates a SQL formatted date field (currently only does yyyy-mm-dd hh:ii:ss)
    // for mysql db insertion, it sets the time to the beginning of 
    // the day for the given date before formatting
    // incoming date can be any valid date format
    if( !$date )
    $date = $this->currTime;
    else if( preg_match("@[^0-9]@", $date) )
    $date = $this->dateParse($date);
    $date = $this->dateAnchor("day",$date);
    //return $this->dateTimeSQL($date);
    $dateParts = $this->dateSplit( $date );
    extract($dateParts);
    $mon = str_pad($mon,2,"0",STR_PAD_LEFT);
    $day = str_pad($day,2,"0",STR_PAD_LEFT);
    $date = "$year-$mon-$mday";
    return($date);
  }
  
  function dateTimeSQL( $date = '' ) {
    // creates a SQL formatted date field (currently only does yyyy-mm-dd hh:ii:ss)
    // for mysql db insertion
    // incoming date can be any valid date format
    if( !$date )
    $date = $this->currTime;
    else if( preg_match("@[^0-9]@", $date) )
    $date = $this->dateParse($date);
    $dateParts = $this->dateSplit( $date );
    extract($dateParts);
    $mon = str_pad($mon,2,"0",STR_PAD_LEFT);
    $day = str_pad($day,2,"0",STR_PAD_LEFT);
    $hours = str_pad($hours,2,"0",STR_PAD_LEFT);
    $minutes = str_pad($minutes,2,"0",STR_PAD_LEFT);
    $seconds = str_pad($seconds,2,"0",STR_PAD_LEFT);
    $date = "$year-$mon-$mday $hours:$minutes:$seconds";
    return($date);
  }
  
  function dateIsMultiple( $frequency, $start, $date = '', $range = '' ) {
    // STILL EXPERIMENTAL... UNTESTED AS OF YET
    // determines if a date is on the same interval as the $start, over $range
    // $frequency is a string "n xxxx" where n is integer and xxxx is an
    //   interval such as minutes, hours, days, weeks, months, etc
    // $start is the date that the interval will be tested against
    // $date is the date to be tested whether it falls on $frequency interval
    //   of $start
    // $range is an optional override that specifies 
    //   
    // example:  dateIsMultiple( "2 days", "188245", "298454" )
    //   this would test whether or not $date ("298454") falls on an interval
    //   of every 2 days from $start ("188245")
    list($int,$period) = explode(" ", $frequency);
    if( !$start )
    $start = $this->currTime;
    if( $range ) {
      $date = $this->dateAnchor($range, $date);
      $start = $this->dateAnchor($range, $start);
    }
    $startParts = $this->dateSplit( $start );
    $dateParts = $this->dateSplit( $date );		
    switch( strtolower(substr($period, 0, 2)) ) {
      case "se":
      $res = ($dateParts["seconds"] - $startParts["seconds"]) % $int;
      break;
      case "mi":
      $res = ($dateParts["minutes"] - $startParts["minutes"]) % $int;
      break;
      case "ho":
      $res = ($dateParts["hours"] - $startParts["hours"]) % $int;
      break;
      case "da":
      $ydiff = $dateParts["year"] - $startParts["year"];
      $res = ($dateParts["yday"] - $startParts["yday"] + 365 * $ydiff) % $int;
      break;
      case "we":
      $ydiff = $dateParts["year"] = $startParts["year"];
      $res = ($dateParts["yday"] - $startParts["yday"] + 365 * $ydiff) % ($int * 7);
      break;
      case "mo":
      $res = ($dateParts["mon"] - $startParts["mon"]) % $int;
      break;
      case "qu":
      $res = ($dateParts["mon"] - $startParts["mon"]) % ($int * 3);
      break;
      case "ye":
      $res = ($dateParts["year"] - $startParts["year"]) % $int;
      break;
      case "de":
      $res = ($dateParts["year"] - $startParts["year"]) % ($int * 10);
      break;
      case "ce":
      $res = ($dateParts["year"] - $startParts["year"]) % ($int * 100);
      break;
    }
    if( $res ) {
      return false;
    } else {
      return true;
    }
  }
}