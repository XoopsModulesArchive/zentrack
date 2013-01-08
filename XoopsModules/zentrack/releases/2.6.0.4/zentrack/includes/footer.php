<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>


   <!-- BEGIN FOOTER -->

  </td></tr></table>
  
  </td>
  </tr>
  <tr>
    <td class="titleCell" height="<?=$nav_bar_height?>" colspan='<?=$nav_col_span?>'><img src="<?=$imageUrl?>/empty.gif" width="1" height="1"></img></td>
</tr>
</table>

<br clear="all"></br>
<? $hotkeys->renderAccessKeys(); ?>
<script type='text/javascript'>
<?=$hotkeys->renderFunctions()?>
function loadRenderKeys() {
  <?=$hotkeys->renderKeys()?>
}
</script>



<!--
<p>&nbsp;</p>
<p align="left">
   <A href="http://sourceforge.net" target="_new">
      <IMG src="http://sourceforge.net/sflogo.php?group_id=22428" 
         width="88" height="31" border="0" alt="SourceForge Logo">
   </A>
</p>
-->

<?

  include_once("$libDir/session_save.php");

  $debug_text = "";
  /*
  **  This is the debugging section... please keep this intact, as
  **  we use it extensively for support questions
  */
  if( $Debug_Mode > 0 ) {
      if( $zen->debug ) {
        $debug_text .= "<tr><td class='mainContent'>\n";
        $debug_text .= "<p><b>MESSAGES</b></p>\n";
        $debug_text .= "<table align='center'><tr>";
        $c = '';//isset($_SESSION['check_error'])? 'checked' : '';
        $debug_text .= "<td><input type='radio' id='debugFilterChoice1' "
                      ."name='debugFilter' $c onclick='toggleDebug(\"error\")'>"
                      ."&nbsp;<label for='debugFilterChoice1'>"
                      .tr("Errors")."</label></td>";
        if( $Debug_Mode > 1 ) {
          $c = '';//isset($_SESSION['check_warning'])? 'checked' : '';
          $debug_text .= "<td><input type='radio' id='debugFilterChoice2' "
                        ."name='debugFilter' $c onclick='toggleDebug(\"warning\")'>"
                        ."&nbsp;<label for='debugFilterChoice2'>"
                        .tr("Warnings")."</label></td>";
        }
        else {
          $debug_text .= "<td><input type='radio' name='debugFilter' disabled='disabled' class='disabled'>&nbsp;<span class='note'>".tr("Warnings")."</span></td>";
        }
        if( $Debug_Mode > 2 ) {
          $c = '';//isset($_SESSION['check_note'])? 'checked' : '';
          $debug_text .= "<td><input type='radio' id='debugFilterChoice3' "
                        ."name='debugFilter' $c onclick='toggleDebug(\"note\")'>"
                        ."&nbsp;<label for='debugFilterChoice3'>"
                        .tr("Notes")."</label></td>";
        }
        else {
          $debug_text .= "<td><input type='radio' name='debugFilter' disabled='disabled' class='disabled'>&nbsp;<span class='note'>".tr("Notes")."</span></td>";
        }
        $c = 'checked';
        $debug_text .= "<td><input type='radio' id='debugFilterChoice4' "
                      ."name='debugFilter' $c onclick='toggleDebug(\"all\")'>"
                      ."&nbsp;<label for='debugFilterChoice4'>"
                      .tr("All")."</label></td>";
        $debug_text .= "</tr></table>";
         $debug_text .= "<div class='note' id='debugContent'>\n";
         ob_start();
         $zen->printDebugMessages();
         $debug_text .= ob_get_contents();
         ob_clean();
         $debug_text .= "</div>\n";
         $debug_text .= "</td></tr>\n";
      }
  
     $debug_text .= "<tr><td class='mainContent'>\n";
     $debug_text .= "<p><b>SETTINGS / SYSTEM INFO</b></p>\n";
     if( preg_match('@'.strtolower(Zen::cleanPath($_SERVER['DOCUMENT_ROOT'])).'@', strtolower(Zen::cleanPath($libDir))) ) {
       $debug_text .= "<b><span class='error'>\$libDir should not be a www viewable directory!</span></b><br/>\n";
     }
     $debug_text .= "<span class='note'>\n";
     $debug_text .= "HTTP_USER_AGENT: $HTTP_USER_AGENT<br/>\n";
     $debug_text .= "SCRIPT_NAME: $SCRIPT_NAME<br/>\n";
     $debug_text .= "QUERY_STRING: $QUERY_STRING<br/>\n";
     $debug_text .= "HTTP_HOST: (".(preg_match("/$HTTP_HOST/",$rootUrl)? 'matches rootUrl' : 
        '<b><span class="error">DOES NOT MATCH $rootUrl!!!</span></b>').")<br/>\n";
     $debug_text .= "HTTP_COOKIE: $HTTP_COOKIE<br/>\n";
     $debug_text .= "SERVER_SOFTWARE: {$_SERVER['SERVER_SOFTWARE']}<br/>\n";
     $debug_text .= "PHP Version: ".phpversion()."<br/>\n";
     $debug_text .= "zenTrack Version: ".$zen->getSetting("version_xx")."<br/>\n";
     $debug_text .= "rootUrl: $rootUrl<br/>\n";
     $debug_text .= "section: ".getZtSection()."<br/>\n";
     $debug_text .= "database: ".$zen->database_type."/".$zen->database_host."<br/>\n";
     $debug_text .= "settings count: ".count($zen->settings)."<br/>\n";
     $debug_text .= "bins: ".(count($zen->bins)? join(",",$zen->bins) : 'NO BINS FOUND, DID YOU RUN THE SEED_YOURDB.SQL SCRIPT?')."<br/>\n";
     $debug_text .= "types: ".(count($zen->types)? join(",",$zen->types) : 'NO TYPES FOUND, DID YOU RUN THE SEED_YOURDB.SQL SCRIPT?')."<br/>\n";
     $debug_text .= "priorities: ".(count($zen->priorities)? join(",",$zen->priorities) : 'NO PRIORITIES FOUND, DID YOU RUN THE SEED_YOURDB.SQL SCRIPT?')."<br/>\n";
     $debug_text .= "systems: ".(count($zen->systems)? join(",",$zen->systems) : 'NO SYSTEMS FOUND, DID YOU RUN THE SEED_YOURDB.SQL SCRIPT?')."<br/>\n";
     $debug_text .= "login_language: $login_language<br/>\n";
     if( $login_id ) {
       $debug_text .= "login_id: $login_id<br/>\n";
       $debug_text .= "login_level: $login_level<br/>\n";
       $debug_text .= "login_name: $login_name<br/>\n";
       $debug_text .= "login_bin: $login_bin<br/>\n";     
       $debug_text .= "userBins: ".join(",",$zen->getUsersBins($login_id))."<br/>\n";
     } else {
       $debug_text .= "Not logged in<br/>\n";
     }
     $debug_text .= "GD Info:\n";
     if( function_exists("gd_info") ) {
       $debug_text .= "<ul>\n";
       foreach(gd_info() as $k=>$v) {
         $debug_text .= "<li>$k: $v</li>\n";
       }
       $debug_text .= "</ul>\n";
     }
     else {
       $debug_text .= "gd_info not available<br/>\n";
     }
     $debug_text .= "</span>\n";
     $debug_text .= "</td></tr>\n";

     $user = $zen->getUser($login_id);
    ?>
    <table cellspacing='2' cellpadding='4' width='500' align='center'>
    <tr><td class='mainContent' align='center'><b>DEBUG LOG</b></td></tr>
    <tr><td class='mainContent'>
    <p class='error'>To disable this output, set $Debug_Mode in header.php to 0.  Never leave this on in a production environment!</p>
    <form action='<?=$rootUrl?>/help/bugs.php' method='post'>
    Report bugs by clicking here: <input type='submit' value='Report A Bug' name='reportButton' class='submit'>
    <input type='hidden' name='name' value='<?=$zen->ffv($login_name)?>'>
    <input type='hidden' name='email' value='<?=$zen->ffv($user['email'])?>'>
    <input type='hidden' name='debug_output' value='<?=urlencode($debug_text)?>'>
    <input type='hidden' name='user_info' value='<?=$zen->ffv($_SERVER['HTTP_USER_AGENT'])?>'>
    </form>
    <p>Please send us <a href='http://www.zentrack.net/feedback/?name=<?=$zen->ffv($login_name)?>&email=<?=$user['email']?>&subject=Feedback'>Feedback</a>!</p>
    <p><a href='<?=$rootUrl?>/phpinfo.php'>click here to view phpinfo</a></p>
    <p><a href='<?=$SCRIPT_NAME?>?clear_session_cache=1'>click here to clear session cache</a></p>
    </td></tr>
    <?
    // for extra security, make sure we don't pass anything sensitive out to
    // the public
    $debug_text = preg_replace('/password=[^"\' ]+/', 'password=xxxx', $debug_text);
    $debug_text = preg_replace('/Db_Pass=[^"\' ]+/', 'Db_Pass=xxxx', $debug_text);
    $debug_text = preg_replace('/database_password=[^"\' ]+/', 'database_password=xxxx', $debug_text);
    $debug_text = preg_replace('/[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+[.][a-zA-Z0-9_.-]+/', 'xxxx@xxxx.xxx',$debug_text);
    $debug_text = preg_replace('@(https?://|www[.])[a-zA-Z0-9_-]+[.]([a-zA-Z]{2,4})@', '\\1xxxx.\\2', $debug_text);
    $debug_text = preg_replace('@(https?://)[0-9]{1,3}[.][0-9]{1,3}[.][0-9]{1,3}[.][0-9]{1,3}@', '\\1xxx.xxx.xxx.xxx', $debug_text);
    $debug_text = preg_replace('/zentrackKey=([^, "\']+)/', 'zentrackKey=xxxxx', $debug_text);
    print $debug_text;
    
    // used by behavior_js.php
    ?>
      <tr><td class='mainContent'>
      <div id='behaviorDebugDiv'></div>
      </td></tr></table>
    <?
  }

?>



<div id='hotKeyHelp'  class='hotKeyHelp invisible'><?=$hotkeys->renderHelp()?></div>


<meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="-1" />

  
<?php
		if( ZT_SECTION != "admin")  {
     
			  $zenTrackContent = ob_get_contents();
			  ob_end_clean();
			  $xoopsTpl->assign('zenTrackContent', $zenTrackContent);
			
			/////////////////////////////////////////////////////////////////////////
			// XOOPS_ROOT_PATH should be set in the xoops_header.php file
			/////////////////////////////////////////////////////////////////////////
			if( file_exists(XOOPS_ROOT_PATH."/footer.php") ) {
			include_once(XOOPS_ROOT_PATH."/footer.php");
			}
       } else {
       	xoops_cp_footer();

       }

?>
