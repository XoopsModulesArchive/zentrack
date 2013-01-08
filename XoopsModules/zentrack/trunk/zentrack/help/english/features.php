<?php

  /*
  **  HELP SECTION - FEATURES
  */

  $b = dirname(dirname(__FILE__));
  include("$b/help_header.php");

  $page_title = "About ".$zen->getSetting("system_name");
  include("$libDir/nav.php");
?>
  <br>
  <blockquote>
  <span class='bigBold'>Features of <?=$zen->getSetting("system_name")?></span>

  <p><b>(This page has yet to fully expand into what it should be.  Will be 
	done before the live (2.1) release of zenTrack.)</b></p>
   
  <p>This site, <?=$HTTP_HOST." / ".$zen->getSetting("system_name")?>, is an open source variant of the 
     <a href='http://sourceforge.net/projects/zentrack'>zenTrack project</a>. It
     is protected under the <a href='<?=$helpUrl?>/gpl.php'>GPL 2.0 Liscence</a>.</p>

  <p>The system was originally created by <a href='http://kato.was-here.org'>Michael 
   "Kato" Richardson</a> (<a href='mailto:phpzen@users.sourceforge.net?subject=zenTrack'>phpzen@users.sourceforge.net</a>).  
  It is now maintained by Kato and an small, experienced of developers through the 
  source forge foundry.</p>

  <ul>
    <li><a href='<?=$helpUrl?>/features.php'>Overiew, Capabilities and Limitations</a>
    <li><a href='<?=$helpUrl?>/future.php'>Future Plans for zenTrack Project</a>
  </ul>


  </blockquote>
<?php
  include("$libDir/footer.php");
?>


