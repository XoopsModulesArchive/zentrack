<?
  /*
  **  SEARCH TICKETS
  **  
  **  Filter tickets by a list of parameters and return
  **  only those tickets matching the result set
  **
  */

  define('ZT_SECTION','tickets');
  include("header.php");
  
  $page_title = tr("Search Tickets");
  $page_section = $page_title;
  
  $inc = "$templateDir/searchForm.php";
  
  if( $TODO == 'SEARCH' ) {
    include("$templateDir/searchResults.php");
    if( is_array($tickets) ) {
      $view = "search_list";
      $inc = "$templateDir/listTickets.php";
    } else if( !$errs ) { 
      $msg[] = tr("There were no results for your search."); 
    }
  }
  
  include("$libDir/nav.php");
  $zen->printErrors($errs);
  include($inc);
  include("$libDir/footer.php");
?>
