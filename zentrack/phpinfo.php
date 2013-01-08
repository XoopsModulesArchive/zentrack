<?
  
  /*
  **  THIS IS FOR DEBUGGING ONLY, YOU CAN REMOVE FROM PRODUCTION
  **  SERVER IF DESIRED (it exists here because it's occationally useful for debugging)
  */
  
  include("header.php");
  
  if( $login_level > 0 ) {
     phpinfo();     
  } else {
     header("Location: $rootUrl/index.php");
  }
  
?>
