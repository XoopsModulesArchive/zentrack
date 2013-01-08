<?

  /*
  **  QUICK SEARCH PAGE
  **  
  **  Examines searchText and performs lookups of ticket ids or searches
  **  of ticket summaries and details.
  **
  */
  
  // include the header file
  include_once("header.php");
  
  $idText = $_GET['idText'];
  
  // redirect to somewhere user can pick a ticket if no id was recieved
  if( !$idText ) {
    include("$rootWWW/index.php");
    exit;
    //header("Location: $rootUrl/index.php\n");
  }
  
  if( preg_match('@^[0-9]+$@', $idText) ) {
    // this is a ticket id, so try to pull it up
    $id = $idText;
    $ticket = $zen->get_ticket($id);
    if( is_array($ticket) ) {
      $page_type = $zen->inProjectTypeIDs($ticket['type_id'])? 'project' : 'ticket';
      $view = "{$page_type}_view";
      include("$rootWWW/ticket.php");
      exit;
    }
  }

  // if it is not a ticket id, then it is a search term
  $search_text = $idText;
  $TODO = 'SEARCH';
  $search_fields = array('title'=>1);
  include("$rootWWW/search.php");
  
?>