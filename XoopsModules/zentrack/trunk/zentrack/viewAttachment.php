<?
  /*
  **  VIEW ATTACHMENT
  **  
  **  Safely print an attachment out for user to view
  **
  */
  
  include_once("./header.php");

  // find the attachment
  $aid = ereg_replace("[^0-9]", "", $aid);  
  $att = $zen->get_attachment($aid);

  // redirect if it doesn't exist
  if( !$aid || !is_array($att) ) {
    include("index.php");
    exit;
    //header("Location: $rootUrl/index.php\n");
  }

  // set the title
  $page_title = $att["name"];
 
  // if it's an app, then attach it, otherwise just show it
  if( eregi("^application",$att["filetype"]) ) {
     $cd = "attachment;";
  } else {
     unset($cd);
  }
  //header("Content-type: text/plain");
  //print("Content-type: $att[filetype]\nContent-Disposition: $cd filename=$att[name]");
  //Zen::printArray($att);
  header("Content-type: $att[filetype]\nContent-Disposition: $cd filename=$att[name]");

  readfile($zen->attachmentsDir."/$att[filename]");

?>
