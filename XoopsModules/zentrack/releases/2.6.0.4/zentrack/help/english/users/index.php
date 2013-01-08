<?
  $b = dirname(__FILE__);
  include("$b/user_header.php");
?>

<div class='menuBox'>
  <div><?=tr("Where Am I?")?></div>
  <p class='note'><?=tr("The user's manual contains instructions on how to use\ncommon features of ?",
        $zen->getSetting('system_name'))?>.</p>
  <p class='note'>
  First time using <?=$zen->getSetting('system_name')?>?  
  Please try out the 
  <a href='<?=$helpUrl?>/tutorial.php'><?=tr("Tutorial")?></a>!</p>
</div>

<div class='menuBox'>
  <div><?=tr("Contents of User's Manual")?></div>
<?
  renderTOC('users', false);
?>
</div>

<div class='menuBox'>
  <div><?=tr("What is ??", $zen->getSetting('system_name'))?></div>

  <p class='note'><?=$zen->getSetting('system_name')?> stores information about tasks and projects for your company as 
  'tickets'.  It provides an interface for monitoring who is working on 
  a ticket and what the status is.

  <p class='note'><?=$zen->getSetting('system_name')?> also provides useful information about the ticket for both the
  users who will be doing work and for project managers who must plan and monitor
  current projects.</p>
</div>

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
