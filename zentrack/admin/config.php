<?php {
  /*
  **  ADMIN SETTINGS PAGE
  **  
  **  Change zenTrack system settings
  **
  */
  
  
  include("admin_header.php");
  $page_title = tr("Configuration Settings");
  
  $settings = $zen->getSettings(1);
  if( $TODO ) {
    unset($newparams);
    if( !is_array($newSettings) ) {
      $errs[] = tr("No settings were recieved");
    } else {
      foreach($settings as $s) {
        // don't error check, or change things ending in _xx
        if( preg_match("@_xx$@", $s["name"]) )
        continue;
        $k = $s["setting_id"];
        $n = $s['name'];
        $newSettings["$k"] = $zen->stripPHP($newSettings["$k"]);
        if( strlen($newSettings["$k"]) < 1 ) {
          $errs[] = tr("? must have a value, use zero instead of a blank", array($n));
        } else if( ($s["value"] == "on" || $s["value"] == "off") 
        &&
        ($newSettings["$k"] != "on" && $newSettings["$k"] != "off") 
        ) {
          $errs[] = tr("? must be set to 'on' or 'off'", array($k)); 
        } else if( preg_match("#^url_#", $s["name"]) ) {
          $newSettings["$k"] = preg_replace("#^$rootUrl/?#i", "", $newSettings["$k"]);
          $v = preg_replace("#^$rootUrl/?#i", "", $s["value"]);
          if( $v != $newSettings["$k"] ) {
            $newparams["$k"] = $newSettings["$k"];
          }
        } else if( $newSettings["$k"] != $s["value"] ) {
          $newparams["$k"] = $newSettings["$k"];
        }
      }
      if( !is_array($newparams) ) {
        $errs[] = tr("There were no changes to save.");
      }
      
      if( !$errs ) {
        $j = 0;
        if( $zen->demo_mode == "on" ) {
          $msg[] = tr("Process completed successfully.  No changes were made, because this is a demo site.");
          $skip = 1;
        } else {
          foreach($newparams as $k=>$v) {
            if( strlen($v) ) {
              $res = $zen->update_setting($k, array("value"=>$v));
              if( $res )
              $j++;
            }
          }
          if( $j )
          $zen->settings = $zen->getSettings();
          $msg[] = tr("? of ? settings changed were successfully updated", array($j, count($newparams)));
          $skip = 1;
        }
      }
    }
  }
  
  if( !$skip ) {
    $page_title = tr("? Settings", array($zen->getSetting("system_name")));
    include("$libDir/admin_nav.php");
    $zen->printErrors($errs);
showTabbedMenu(12);
    print "<blockquote>\n";
    include("$templateDir/configSettingsForm.php");
    print "</blockquote>\n";
  } else {
    $page_title = "Admin Menu";
    include("$libDir/admin_nav.php");
    include("$templateDir/adminMenu.php");
  }
  
  include("$libDir/footer.php");
  
}?>










