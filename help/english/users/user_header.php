<?php
  $b = dirname(dirname(dirname(__FILE__)));
  include_once("$b/help_header.php");
  
  $page_section = tr("User's Manual");  
  include("$libDir/nav.php");

  renderNavbar('users', $usersTOC);  
?>
<p class='bigBold' align='center'>
<?=
  basename($_SERVER['SCRIPT_NAME']) == 'index.php'?
     'Overview' : 
     ucwords(str_replace('_', ' ', str_replace('.php','',basename($_SERVER['SCRIPT_NAME']))));
?>
</p>
