<?
  // forward to correct help section based on language in use
  $b = realpath(dirname(__FILE__));
  include_once("$b/help_header.php");
  include("$helpDir/index.php");
?>