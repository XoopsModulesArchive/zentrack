<?php

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
<?php print join("",file("$libDir/misc/TODO")); ?>
</pre>

  </blockquote>
<?php
  include("$libDir/footer.php");
?>


