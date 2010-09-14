<?php

  /*
  **  HELP SECTION
  */

  $b = realpath(dirname(dirname(__FILE__)));
  include_once("$b/help_header.php");
  $page_title = tr("Main Menu");
  include("$libDir/nav.php");

?>
  <div class='heading'><?php echo tr("Welcome to ? Help!",$zen->getSetting('system_name')); ?></div>

  <div class='menuBox'>
    <div><?php echo tr("Tutorial"); ?></div>
    <p onclick='mClk(this)'>
    <a href='<?php echo $helpUrl?>/tutorial.php'><?php echo tr("View the Tutorial"); ?></a>
    <span class='note'>
    <?php echo tr("New to ??  Try out the tutorial, which will explain everything you "
      ."need to know... except for the stuff it doesn't.", $zen->getSetting('system_name'));?>
    </span></p>
  </div>
    
  <div class='menuBox'>
    <div><?php echo tr("User's Manual");?></div>
    <?php
      // prints out an index of the user's manual
      // do not try to manually replace the values here, just
      // edit the labels in the appropriate language file!    
      renderTOC( 'users', true ); 
    ?>
    <p onclick='mClk(this)'><a href='<?php echo $rootUrl?>/misc/hotkeys.php'><?php echo tr("Hot Key Settings"); ?></a></p>
  </div>

  <div class='menuBox'>
    <div><?php echo tr("Administrator's Manual"); ?></div>
    <?php
      // prints out an index of the administrator's manual
      // do not try to manually replace the values here, just
      // edit the labels in the appropriate language file!    
      renderTOC( 'admin', true ); 
    ?>
  </div>
    
  <div class='menuBox'>
    <div><?php echo tr("Help and Support"); ?></div>
    <p onclick='mClk(this)'><a href='http://www.zentrack.net/modules/support/'><?php echo tr("Community"); ?></a></p>
    <p onclick='mClk(this)'><a href='http://www.zentrack.net/modules/newbb/'><?php echo tr("Forums"); ?></a></p>
    <p onclick='mClk(this)'><a href='<?php echo $helpUrl?>/bugs.php'><?php echo tr("Reporting Bugs"); ?></a></p>
  </div>
    
  <div class='menuBox'>
    <div>About Us</div>
    <p onclick='mClk(this)'><a href='<?php echo $helpUrl?>/about.php'>
      About <?php echo $zen->getSetting('system_name');?></a></p>
    <p onclick='mClk(this)'><a href='<?php echo $helpUrl?>/gpl.php'><?php echo tr("License"); ?></a></p>
    <p onclick='mClk(this)'><a href='http://www.zentrack.net'><?php echo tr("Website"); ?></a></p>
    <p onclick='mClk(this)'><a href='http://www.zentrack.net/feedback/?subject=Feedback' 
      target='_blank'><?php echo tr("Feedback"); ?></a>
      <span class='note'><?php echo tr("Give us Feedback!")." ".tr("Tell us about the latest ?", 
        "<a href='http://kato.was-here.org/funnies/catattack.mpeg' 
          target='_blank'>".tr("cat attack")."</a>"); ?></span>
    </p>
  </div>
  
  <p>&nbsp;</p>
  
<?php
  include("$libDir/footer.php");
?>