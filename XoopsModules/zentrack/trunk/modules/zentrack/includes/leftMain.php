<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<div class="small" align="center"><b><?php echo $zen->showLongDate(); ?></b></div>
<div class="small" align='center'><?php echo tr("version"); ?> <?php echo $zen->getSetting("version_xx"); ?></div>
<?php
  if( $zen->demo_mode == 'on' ) { print "<div class='small' align='center'>(demo mode)</div>"; }

  $num = 0;
  $num = $zen->getTicketCount('OPEN');
  print "<p align='center' class='small'>";
  print $zen->ptrans("? open tickets in ? bins",array($num,count($zen->bins)));
  print "</p>\n";
  
  if( $login_id ) {
     if( ereg("/help/",$SCRIPT_NAME) ) {
   $expand_help = 1;
     } else if( ereg("/admin/",$SCRIPT_NAME) ) {
   $expand_admin = 1;;
     }
  } else {
     if( ereg("/help/",$SCRIPT_NAME) ) {
   $expand_help = 1;
     }
  }

?>
  
  
<table width="100%" border=1 cellspacing=0 cellpadding=2 bgcolor='<?php echo $zen->getSetting("color_title_background"); ?>'>
  <?php if( $login_id ) { include("$libDir/leftBins.php"); } ?>
  <tr>
  <td class="altCell" align=center>
  <b><?php echo tr("Tracker"); ?></b>
  </td>
  </tr>
  <?php include("$libDir/leftTickets.php"); ?>
  <?php include("$libDir/leftSearch.php"); ?>
  <?php

  if ($login_level=="first_login" ) $err = 1;
	  
  if ($login_level != 'first_login' &&
      $login_level >= $zen->getSetting("level_contacts") &&
      $zen->settingOn('allow_contacts') ) {
  ?>
    <tr>
      <td class="altCell" align=center>
        <b><?php echo tr("Contacts"); ?></b>
      </td>
    </tr>
  <?php 
    include("$libDir/leftContacts.php"); 
  }
  ?>
  <tr>
  <td class="altCell" align=center>
  <b><?php echo tr("System"); ?></b>
  </td>
  </tr>  
<?php if( $login_id ) { ?>
  <tr>
  <td <?php echo $nav_rollover_text?>>
  <a class='menuLink' 
     href="<?php echo $rootUrl?>/index.php?logoff=1"
     onClick='return confirm("<?php echo tr("Really log out of zenTrack?"); ?>")'><?php echo tr("Log Off"); ?></a>
  </td>
  </tr>       
<?php } else { ?>
  <tr>
  <td <?php echo $nav_rollover_text?>>
  <a class='menuLink' href="<?php echo $rootUrl?>/index.php"><?php echo tr("Log On"); ?></a>
  </td>
  </tr>                
<?php } ?>
<?php include("$libDir/leftHelp.php"); ?>
  <tr>
  <td <?php echo $nav_rollover_text?>>
  <a class='menuLink' href="<?php echo $rootUrl?>/options.php"><?php echo tr("Options"); ?></a>
  </td>
  </tr>  
  <?php 
//we check also if login_level is a number because in first login it will be 'first_login' what would give access to all.
     if( $zen->checkNum($login_level) >= $zen->getSetting("level_reports") ) {
   include("$libDir/leftReports.php");
      } 
  ?>
  <?php 
     if( $zen->checkNum($login_level) >= $zen->getSetting("level_settings") ) {
   include("$libDir/leftAdmin.php");
      } 
  ?>
</table>

