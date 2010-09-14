<?php
  $b = dirname(__FILE__);
  include("$b/user_header.php");
?>

<div class='menuBox'>
  <div><?php echo tr("Where Am I?"); ?></div>
  <p class='note'><?php echo tr("The user's manual contains instructions on how to use\ncommon features of ?",
        $zen->getSetting('system_name')); ?>.</p>
  <p class='note'>
  First time using <?php echo $zen->getSetting('system_name'); ?>?  
  Please try out the 
  <a href='<?php echo $helpUrl?>/tutorial.php'><?php echo tr("Tutorial"); ?></a>!</p>
</div>

<div class='menuBox'>
  <div><?php echo tr("Contents of User's Manual"); ?></div>
<?php
  renderTOC('users', false);
?>
</div>

<div class='menuBox'>
  <div><?php echo tr("What is ??", $zen->getSetting('system_name')); ?></div>

  <p class='note'><?php echo $zen->getSetting('system_name'); ?> stores information about tasks and projects for your company as 
  'tickets'.  It provides an interface for monitoring who is working on 
  a ticket and what the status is.

  <p class='note'><?php echo $zen->getSetting('system_name'); ?> also provides useful information about the ticket for both the
  users who will be doing work and for project managers who must plan and monitor
  current projects.</p>
</div>

<?php 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
