<?php

  /*
  **  HELP SECTION - ABOUT
  */

  $b = dirname(__FILE__);
  include(dirname($b)."/help_header.php");

  $page_title = "About ".$zen->getSetting("system_name");
  include("$libDir/nav.php");
?>
  <br>
  <blockquote>
  <span class='bigBold'>About <?=$zen->getSetting("system_name")?></span>
   
  <p><?=$zen->getSetting("system_name")?> is an open source variant of the 
     <a href='http://sourceforge.net/projects/zentrack'>zenTrack project</a>. It
     is protected under the <a href='<?=$helpUrl?>/gpl.php'>GPL 2.0 License</a>.</p>

  <p>The system was originally written by <a href='http://kato.was-here.org'>Kato Richardson</a> 
  (<script>eLink('phpzen','users.sourceforge.net')</script>).  
  It is now maintained by Kato and an small, experienced group of developers through the 
  source forge foundry.</p>

  <p>Much more information about zenTrack can be found at the home page: <a href='http://www.zentrack.net'>http://www.zentrack.net</a>.</p>

  </blockquote>
<?php
  include("$libDir/footer.php");
?>


