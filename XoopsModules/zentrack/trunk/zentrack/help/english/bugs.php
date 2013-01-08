<?  /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */

  /*
  **  HELP SECTION - SUPPORT
  */

  $b = dirname(dirname(__FILE__));
  include_once("$b/help_header.php");

  $page_title = "Reporting Bugs";
  include("$libDir/nav.php");
?>

  <br>
  <p class='bigbold'>Steps to Report a Bug</p>
  
  <b>Reporting Bugs Made Easy</b>
  <blockquote>
    <p><b>1. Turn On Debugging</b>:  open www/header.php and set 
      $Debug_Overview = 1.  This will produce some debugging output
      at the base of the page.
    
    <p><b>2. Click on 'Report a Bug' Button</b>:  Inside the new debugging output
    you will see a button to report a bug.  Click this button and
    submit the form with your comments.
    
  </blockquote>
  
  <b>Report Bug Manually</b>
  <blockquote>
    If you can't get the product to work at all, you can submit your bugs manually
    using the following steps:
    
    <p><b>1. Collect System Info</b>: Provide your operating system, php version,
    zentrack version, database type and version, and apache/server info at a minimum!
    
    <p><b>2. Report Your Bug</b>: Please report bugs <a href="http://sourceforge.net/tracker/?group_id=22724&atid=376336">here</a>.
    
    <p>If Source Forge is not running, then you can report them via our user forum:
    <a href='http://www.zentrack.net/modules/newbb/' target='_blank'>forum link</a>.</p>  
  </blockquote>
<?
  include("$libDir/footer.php");
?>
