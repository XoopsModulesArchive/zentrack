<?
  /*
  **  SEARCH LOGS
  **  
  **  Filter logs by a list of parameters and return
  **  only those logs matching the result set
  **
  */
  include("header.php");
  define('ZT_SECTION','tickets');

  $page_title = tr("Search Logs");
  $page_section = $page_title;
  $log_search_res = false;

  include("$libDir/nav.php");

  if( $TODO == 'SEARCH' ) {
    include("$templateDir/searchLogResults.php");
    if( is_array($logs) ) {
      $log_search_res = true;
    } else if( count($errs) ) {
      $zen->printErrors($errs);
    } else {
      $msg = tr("There were no logs matching your search.");
    }
  }
  
  if( $log_search_res ) {
    include("$templateDir/searchLogList.php");
    include("$libDir/paging.php"); //Addition for paging
  } else {
    include("$templateDir/searchLogForm.php");
  }
  include("$libDir/footer.php");
?>
