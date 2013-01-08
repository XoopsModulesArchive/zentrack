<?

  /*
  **  HELP SECTION - FUTURE
  */

  $b = dirname(dirname(__FILE__));
  include("$b/help_header.php");

  $page_title = "Future Plans";
  include("$libDir/nav.php");
?>
  <br>
  <blockquote>

<pre>
<? print join("",file("$libDir/misc/TODO")); ?>
</pre>

  </blockquote>
<?
  include("$libDir/footer.php");
?>


