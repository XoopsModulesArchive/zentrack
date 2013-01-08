<?php
  $b = dirname(__FILE__);
  include("$b/admin_header.php");
?>

<div class='menuBox'>
  <div><?=tr("Where Am I?")?></div>
  <p class='note'>The administrator's manual contains instructions on how 
  set up advanced features of <?=$zen->getSetting('system_name')?>.</p>
  <p class='note'>First time using <?=$zen->getSetting('system_name')?>?  
  Please try out the <a href='<?=$helpUrl?>/tutorial.php'><?=tr("Tutorial")?></a>!</p>
</div>

<div class='menuBox'>
  <div><?=tr("Contents of Administrator's Manual")?></div>
    <?php
  renderTOC('admin', false);
?>
</div>

<?php
  renderNavbar('admin');
  include("$libDir/footer.php"); 
?>
