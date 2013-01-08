<?php  /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */

  /*
  **  HELP SECTION - SUPPORT
  */

  $b = dirname(dirname(__FILE__));
  include_once("$b/help_header.php");

  $page_title = "Support";
  include("$libDir/nav.php");
?>

  <br>
  <blockquote>
  <span class='bigBold'>Support for <?=$zen->getSetting("system_name")?></span>
  <p>If the solution to your problem is not to be found in the manual, it is worthwhile trying one
  of the following places for some help:</p>
  
  <table border=0 cellspacing=5>
	<tr>
	  <td valign="top"><a href="http://sourceforge.net/mail/?group_id=22724">Mailing List</a></td>
	  <td>zentrack-users is a great place to get help.  Answers usually
          within 12-24 hours.</td>
	</tr>
        <tr valign="top">
	  <td valign="top"><a href="http://www.sourceforge.net/projects/zentrack">Project</a></td>
	  <td>(see the support pages)  This will get you a response, probably in hours, maybe in days, but
           you will get one.</td>
	</tr>
	<tr>
	  <td valign="top"><a href="http://www.zentrack.net/feedback">Contact Page</a></td>
           <td>If you are a registered tester, you can email me directly.  If you are not 
               a registered tester you will have better luck on the  mailing list.
           </td>
	</tr>
  </table>

  <p><a href='<?=$helpUrl?>/bugs.php'>Click here</a> for information about
  reporting bugs!</p>

  </blockquote>
<?php
  include("$libDir/footer.php");
?>
