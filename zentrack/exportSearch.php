<?
  include("header.php");
  
  //print "<pre>\n";  //debug
  $nolimit = 1;
  include("$templateDir/searchResults.php");
  
  // some data for testing
  //$tickets = array(
  //   array( "title" => "title 1", "content" => "some content", "number" => 123 ),
  //   array( "title" => "title,2", "content" => "some \"content\"", "number" => 1.25 ),
  //   array( "title" => "title 3", "content" => "some \n more \n content", "number" => null )
  //);

  // creates the csv file header, comment out for debugging
  //header("Content-type: application/vnd.ms-excel");
  header("Content-disposition:  attachment; filename=".date("Y-m-d").".csv");
  
  // creates readable column names
  function prepareColumnNames( $keys ) {
    $fields = $GLOBALS['customFields'];
    $vals = array();
    foreach( $keys as $k ) {
      if( in_array($k, $fields) ) {
        $vals[] = $fields[$k];
      }
      else {
        switch($k) {
          case 'id':
            $vals[] = 'ID';
            break;
          case 'project_id':
            $vals[] = "Project";
            break;
          case 'otime':
            $vals[] = "Opened";
            break;
          case 'ctime':
            $vals[] = "Closed";
            break;
          default:
            $vals[] = ucwords(str_replace('_', ' ',str_replace('_id', '', $k)));
        }
      }
    }
    //print_r($vals);
    return $vals;
  }
  
  // print a readable value in place of database junk
  function humanReadableValue( $key, $val ) {
    global $zen;
    $fields = $GLOBALS['fields'];
    if( array_key_exists($key, $fields) && $fields[$key] && array_key_exists($val, $fields[$key]) ) {
      return $fields[$key][$val];
    }
    else {
      switch( $key ) {
        case 'otime':
        case 'ctime':
        case 'start_date':
        case 'deadline':
          return strlen($val)? $zen->showDate($val) : '';
        case 'tested':
        case 'approved':
          return $val == 1? 'no' : $val == 2? 'yes' : 'n/a';
        default:
          return $val;
      }
    }
  }
  
  // iterate over an array of values and create a row of csv data
  function getCsvRow( $values, $headings = false ) {
    // skip empty rows
    if( !is_array($values) ) { return "\n"; }
    $text = "";
    $i=1;
    foreach($values as $k=>$v) {
      // escape content for each cell
      if( !$headings ) { $v = humanReadableValue($k,$v); }
      $text .= getCsvCell($v);
      if( $i < count($values) ) {
        // print comma if this is not the last cell
        $text .= ",";
      }
      $i++;
    }
    // finish off row and return
    return $text."\n";
  }
  
  // escape content
  function getCsvCell( $text ) {
    // replaces " with ""
    // replaces \n with a space
    // encloses in quotes to fix commas
    return "\"".str_replace('"', '""', str_replace("\n", "|", str_replace("\r", "|", $text)))."\"";
  }
  
  if( is_array($tickets) && count($tickets) ) {
    // we have content
    
    // find out which bins this user can view
    $userBins = $zen->getUsersBins($login_id);
    
    //print "<b>USER BINS</b>\n"; //debug
    //print_r($userBins); //debug
    
    // get names for custom fields
    $customFields = $zen->getCustomFields(1);
    $GLOBALS['customFields'] = $customFields;
    
    // begin by collecting names of all the possible values
    $fields = array();
    foreach( array_keys($tickets[0]) as $k ) {
      if( $k != 'id' && $k != 'ticket_id' ) {
        $fields[$k] = $zen->getValsForTicketField($k, $userBins);
      }
    }
    $GLOBALS['fields'] = $fields;
    
    //print "<b>FIELDS</b>\n"; //debug
    //print_r($fields); //debug

    // print column headings
    print "\n";
    print getCsvRow( prepareColumnNames(array_keys($tickets[0])), true );
    print "\n\n";
    
    // print the ticket contents
    $i=1;
    foreach($tickets as $t) {
      print getCsvRow($t);
    }
  }
  else {
    // we have no content
    print "\n,,,No results for your search\n";
  }
  
  //print "</pre>\n"; //debug
?>