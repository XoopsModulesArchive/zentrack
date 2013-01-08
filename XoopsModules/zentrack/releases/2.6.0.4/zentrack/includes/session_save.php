<?
if( !ZT_DEFINED ) { die("Illegal Access"); }


  /*
  ** Returns variables extracted to the $_SESSION array
  ** this avoids having to have lengthly, and ugly $_SESSION
  ** in every place that we call one of these values
  */

  $skips = array('ztDataCache', 'ztVarfields', 'ztMiscCache', 'ztDataTypes');
  
  $vals = array();
  if( is_array($_SESSION) ) {
    foreach($session_vars as $s) {
      $vals[$s] = $$s;
    }
    if( $vals ) {
      foreach($vals as $k=>$v) {
        $_SESSION[$k] = $v;
      }
    }
  }
  else if( is_array($HTTP_SESSION_VARS) ) {
    foreach($session_vars as $s) {
      $vals[$s] = $$s;
    }
    if( $vals ) {
      foreach($vals as $k=>$v) {
        $_SESSION[$k] = $v;
      }
    }
  }

?>