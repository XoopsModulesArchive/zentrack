<?php
{
if( !ZT_DEFINED ) { die("Illegal Access"); }

  /*
  ** headerInc.php
  **
  ** THIS PAGE SHOULD NOT BE EDITED
  **
  ** THE ONLY CONFIGURATION SET THAT SHOULD BE EDITED BY USERS
  ** IS THE header.php FILE IN THE www VIEWABLE DIRECTORY
  ** AND THE configVars.php FILE IN THE includes DIRECTORY
  **
  ** abstracts advanced header functions from the
  ** configuration portion, for easier upgrades and
  ** less headaches
  **
  ** This page contains functions and variables which are universal
  ** to the site
  */

  /**
  * ERROR REPORTING (security)
  */
  error_reporting(E_ALL ^ E_NOTICE);
  ini_set("display_errors", $Debug_Mode > 0);

  // fix problems with array indices and case of table columns
  define('ADODB_ASSOC_CASE',0);

  /*
  ** SESSION MANAGEMENT
  */
  include_once("$libDir/session_start.php");

  /*
  **  URL DETERMINATIONS
  */

  $templateDir = "$libDir/templates";
  $listDir     = "$libDir/lists";
  $imageUrl    = "$rootUrl/images";
  $ticketUrl   = "$rootUrl/ticket.php";
  $projectUrl  = "$rootUrl/project.php";

  /*
  **  BROWSER DETERMINATIONS
  */

  $page_browser = 'unkown';
  if( preg_match("/msie/i", $HTTP_USER_AGENT) ) {
    $page_browser = "ie";
  } else if( preg_match("/(\[en\]|netscape)/i", $HTTP_USER_AGENT) ) {
    $page_browser = "ns";
  } else if( preg_match("/Mozilla/i", $HTTP_USER_AGENT) ) {
    $page_browser = "mz";
  }


  /*
  **  CLASS OBJECTS
  */

  // if these change, they will need to be changed
  // in egate_utils.php as well!
  include_once("$libDir/translator.class.php");
  include_once("$libDir/zenTrack.class.php");
  include_once("$libDir/ZenFieldMap.class.php");
  include_once("$libDir/zenTemplate.class.php");
  
  $zen = new zenTrack( $configFile );
  $map = new ZenFieldMap($zen);
  
  $GLOBALS['zt_zen'] = $zen;
  $GLOBALS['zt_map'] = $map;

  /**
  * Translator Object Initialization (mlively)
  */
  // set language to default if unspecified
  if( !$login_language ) {
    $login_language = $zen->getSetting("language_default");
  }

  //Create the initialization array for the translator object
  //this data set also appears in the egate_utils.php script
  $translator_init = array(
  'domain' => 'translator',
  'path' => "$libDir/translations",
  'locale' => $login_language
  );
  $translator_init['zen'] =& $zen;
  tr($translator_init);
  //save a bit on memory
  unset($translator_init);
  
  // this must be initialized after the translator is started
  include_once("$libDir/ZenHotKeys.class.php");
  $hotkeys = new ZenHotKeys($zen);
  $GLOBALS['zt_hotkeys'] = $hotkeys;

  function uptr($string, $vals = '') {
    $specials = array(
    '&AACUTE;' => '&Aacute;',
    '&EACUTE;' => '&Eacute;',
    '&IACUTE;' => '&Iacute;',
    '&OACUTE;' => '&Oacute;',
    '&OACUTE;' => '&Uacute;',
    '&NTILDE;' => '&Ntilde;'
    );
    $trad=strtoupper(tr($string,$vals));
    $trad = strtr($trad, $specials);
    return $trad;
  }

  /*
  **  SOME FUNCTIONS FOR USE IN
  **  PAGE CONTENT
  **
  **  These are functions for tracking
  **  sessions and for system screen
  **  in the ticket viewing mode
  */

  function add_system_messages( $msg, $code = 'Bold' ) {
    // stores the system messages
    // in a session variable so that they
    // can be viewed later
    // $msg can be an array
    // if $code is set to Error, Highlight, or Bold
    // then the message will be formatted
    // according to the stylesheet .small[Error|Highlight|Bold] entries

    if( !is_array($msg) )
    $msg = array($msg);
    global $login_messages;
    global $system_message_limit;

    if( count($msg) >= $system_message_limit ) {
      unset($login_messages);
    }
    if( !is_array($login_messages) )
    $login_messages = array();
    if( count($login_messages)+count($msg) > $system_message_limit ) {
      $login_messages = array_slice( $login_messages,0,
      ($system_message_limit - count($msg)) );
    }
    foreach( $msg as $m ) {
      array_unshift($login_messages, array($m,time(),$code) );
    }
  }

  function print_system_messages($flag = '') {
    // prints all the system messages to
    // the screen
    // if $flag is given, then it only prints
    // up until the first greyed entry (only print new entries)
    global $login_messages;
    global $zen;

    if( is_array($login_messages) ) {
      $i = 0;
      foreach( $login_messages as $v ) {
        if( $style != "smallGrey" && $v[2] ) {
          $style = "small$v[2]";
        } else if( $style != "smallGrey" ) {
          $style = "smallBold";
        }
        $login_messages[$i][2] = "Grey";
        if( $style == "smallGrey" && $flag )
        break;
        print "<br><span class='$style'>";
        print "[".$zen->showTime($v[1])."] ";
        print $v[0]."</span>\n";
      }
    } else {
      print "<span class='smallGrey'>No system messages</span>";
    }
  }

  function clear_system_messages() {
    // deletes all system messages
    global $login_messages;
    unset($login_messages);
  }

  function getVarfieldDataType( $varfieldName ) {
    $varfieldName = strtolower($varfieldName);
    if( preg_match('/^custom_([a-z]+)[0-9]+$/', $varfieldName, $matches) ) {
      return isset($matches[1])? $matches[1] : null;
    }
  }

  function genVarfield( $formName, $varfield, $value = '' ) {
    // generates html form element to represent
    // the variable field array
    global $zen;
    global $rootUrl;

    // clean data
    $value = $zen->ffv($value);

    // determine the data type
    $type = getVarfieldDataType($varfield['field_name']);

    $onblur = "";
    if( $varfield['js_validation'] ) {
      $onblur = " onblur='{$varfield['js_validation']}'";
    }

    $key = $varfield['field_name'];

    $zen->addDebug('headerInc', "genVarfield( '$formName', "
       +"'$varfield', '$value' ) using type=$type and key=$key", 3);

    switch( $type ) {
      case "boolean":
        $inp = "<input type='checkbox' name='{$key}' "
        ." value='1'";
        $inp .= $value? " checked>\n" : ">\n";
        break;
      case "string":
        $inp = "<input type='text' name='{$key}' "
        ." value='{$value}' size='20' maxlength='250'{$onblur}>\n";
        break;
      case "text":
        $inp = "<textarea name='{$key}' cols='50' "
        ." rows='4'{$onblur}>{$value}</textarea>";
        break;
      case "date":
        // format for use in date
        if( $value == 'NULL' ) { $value = ''; }
        if( $value == 0 ) { $value = ""; }
        if( strlen($value) && preg_match("/^[0-9]+$/", $value) ) {
          $value = $zen->showDateTime($value);
        }
        // create input field and date picker
        $inp = "<input type='text' name='{$key}' "
          ." value='{$value}' size='20' maxlength='250'{$onblur} "
          ." hascalendar='".$varfield['field_name']."-calendar_icon'>\n"
          ." <img name='date_button' src='{$rootUrl}/images/cal.gif' "
          ."  onClick=\"popUpCalendar(this, document.{$formName}.{$varfield['field_name']}, '"
          .$zen->popupDateFormat()." 00:00')\"\n"
          ."  alt='".tr("Select a Date")."' id='".$varfield['field_name']."-calendar_icon'>\n";
          break;
      case "number":
        if( $value == 'NULL' ) { $value = ''; }
        $inp = "<input type='text' name='{$key}' "
        ." value='{$value}' size='10' maxlength='100'{$onblur}>\n";
        break;
      case "menu":
        $opts = genDataGroupChoices($varfield['field_value']);
        $inp = "<select name='{$key}'{$onblur}>\n";
        if( !$varfield['is_required'] && (count($opts)!=1 || strlen($opts[0]['field_value'])) ) {
          $inp .= "<option value=''>---</option>\n";
        }
        $val_picked = false;
        foreach($opts as $o) {
          if( strlen($value) && !$val_picked && $o['field_value'] == $value ) {
            $val_picked = true;
            $sel = " selected";
          }
          else { $sel = ""; }
          $inp .= "<option value='{$o['field_value']}'$sel>{$o['label']}</option>\n";
        }
        if( !$val_picked && strlen($value) ) {
          $inp .= "<option value='".$zen->fixJsVal($value)."' selected>$value(invalid)</option>\n";
        }
        $inp .= "</select>\n";
        break;
      default:
        $inp = "-invalid_field_type($type)-";
        break;
    }
    return $inp;
  }

  function genDataGroupChoices( $group_id, $use_default = true ) {
    if( isset($_SESSION['data_groups']["$group_id"]) ) {
      // get the fields for our group
      $group = $_SESSION['data_groups']["$group_id"];
      if( $group['eval_type'] == 'Matches' ) {
        if( count($group['fields']) ) {
          return $group['fields'];
        }
      }
    }

    // generate a mock field
    if( $use_default ) {
      return array( array('field_value'=>'', 'label'=>'---') );
    }
    else {
      return array();
    }
  }

  if( isset($newbin) && $newbin == 'all' ) {
    unset($login_bin);
  } else if( isset($newbin) && $newbin && $zen->bins["$newbin"] && $zen->checkAccess($login_id,$newbin) ) {
    $login_bin = $newbin;
  }

  // security
  $onLoad = array();
  $vars = array();
  $msg = array();
  $errs = "";
  $mode = "";
  if( isset($id) ) {
    $id = ereg_replace("[^0-9]", "", $id);
  }

  // used to set table cell padding (since netscape cant handle padding-top/bottom)
  $height_num = $zen->getSetting("font_size") + 4;

  // function to retrieve the available languages from the translations/ dir
  function get_languages_available() {
    global $libDir;
    $dir = opendir("$libDir/translations");
    $vals = array();
    while( false !== ($file = readdir($dir)) ) {
      if( preg_match("/\.trans$/",$file) ) {
        $vals[] = basename($file, ".trans");
      }
    }
    closedir($dir);
    return $vals;
  }
  
  /**
   * Generate a div layer that imitates a submit button, but can have
   * a hot key affect applied to it.
   */
   function renderDivButton($key, $onclick = false, $width=100, $label = null) {
     // if we are passed an empty key for some reason
     // then just try to render something sensible instead
     if( !$key ) {
       // if there is no key, we can't look up the label, so we need
       // to have a default
       if( !$label ) { $label = 'Submit'; }
       
       // render a simple submit button
       print "<input type='submit' class='actionButtonDiv' value=\"$label\">";
       return;
     }

     // create the click event for our button
     // the default is to just submit the current form
     if( !$onclick ) { $onclick = 'submitThisForm(this)'; }
     $clickmouse = " onclick=\"{$onclick};\"\n";
     
     // the hotkeys object is stored globally
     $hotkeys = $GLOBALS['hotkeys'];
     
     // render the div layers
     print "<div style='width: {$width}px;' class='actionButtonDiv'\n"; 
     print " $clickmouse";
     print " onmouseover='mClassX(this, \"actionButtonDiv abdDown\", true)'\n";
     print " onmouseout='mClassX(this, \"actionButtonDiv\")'\n";
     print " title='".$hotkeys->tooltip($key)."'>\n";
     print "<a href='#' $clickmouse\n";
     print " onfocus='mClassX(this.parentNode, \"actionButtonDiv abdDown\", true)'\n";
     print " onblur='mClassX(this.parentNode, \"actionButtonDiv\")'\n";
     print ">".$hotkeys->label($key, $label, true)."</a>\n";
     print "</div>\n";
     
     // create a default button (which is not visible on the page) so that
     // our form will still submit if the user hits enter
     print "<input type='submit' class='nodisplay'>\n";
     
     // generate our accesskey if one exists
     if( $key ) {
       print $hotkeys->renderAccessKey($key);
     }
   }
   
   function renderDivButtonFind( $label, $width=100, $override_label = null ) {
     // search for our label in the hotkeys registry
     $hotkeys = $GLOBALS['hotkeys'];
     $key = $hotkeys->find($label);
     
     // if there is no key for this item then we need to explicitly pass the
     // label (so we have something to show)
     if( !$key && !$override_label ) { $override_label = $label; }
     
     // get the onclick event we will use (if it has not been specified)
     if( $key && !$onclick ) { $onclick = $hotkeys->getFxnName($key); }
     
     // genreate the div button now
     return renderDivButton($key,$onclick,$width,$override_label);
   }

  /**
   * Determines the current section based on the page being viewed:
   * <ul>
   *  <li>projects - in projects section
   *  <li>tickets - in tickets section
   *  <li>contacts - a contact related page
   *  <li>help - in help section
   *  <li>admin - in admin section
   *  <li>options - in options section
   *  <li>css - this is a css script
   *  <li>js - this is a javascript
   * </ul>
   */
   function getZtSection() {
     if( !defined('ZT_SECTION') ) {
       $section = null;
        // check for the page_type variable
        global $page_type;
        if( isset($page_type) ) { $section = $page_type."s"; }
        else {
          // try to decipher the url for clues
          global $SCRIPT_NAME;
          global $rootUrl;
          $ext = preg_replace("@^$rootUrl@", '', $SCRIPT_NAME);
          $base = basename($SCRIPT_NAME);
          if( preg_match('@styles[.]php@', $ext) ) {
            $section = 'css';
          }
          else if( preg_match('@javascript[.]php@', $ext) ) {
            $section = 'js';
          }
          else if( preg_match('@/help/@', $ext) ) {
            $section = 'help';
          }
          else if( preg_match('@options.php@', $ext) || preg_match('@/misc/@', $ext) ) {
            $section = 'options';
          }
          else if( preg_match('@(tickets?|index)[.]php@', $ext) ) {
            $section = 'tickets';
          }
          else if( preg_match('@projects?[.]php@', $ext) ) {
            $section = 'projects';
          }
          else if( preg_match('@options[.]php@', $ext) ) {
            $section = 'options';
          }
        }
       if( $section ) {
         define('ZT_SECTION',$section);
       }
     }
     return ZT_SECTION;
   }

  /*
  **  ROLLOVER EFFECTS
  */

  $rollover_text = " onclick=\"if(window.document.body && mClk){mClk(this);return false;}\" "
    ."onmouseout=\"if(window.document.body && mOut){mOut(this,'"
    .$zen->getSetting("color_background")."', '');}\" "
    ."onmouseover=\"if(window.document.body && mOvr){mOvr(this,'"
    .$zen->getSetting("color_bars")."', '');}\"";

  $rollover_greytext = " onclick=\"if(window.document.body && mClk){mClk(this);return false;}\" "
    ."onmouseout=\"if(window.document.body && mOut){mOut(this,'"
    .$zen->getSetting("color_bars")."', '');}\" "
    ."onmouseover=\"if(window.document.body && mOvr){mOvr(this,'"
    .$zen->getSetting("color_background")."', '');}\"";

  $hotrollover_greytext = " onclick=\"if(window.document.body && mClk){mClk(this);return false;}\" "
    ."onmouseout=\"if(window.document.body && mOut){mOut(this,'"
    .$zen->getSetting("color_bars")."', '');}\" "
    ."onmouseover=\"if(window.document.body && mOvr){mOvr(this,'"
    .$zen->getSetting("color_highlight")."', '');}\"";

  $hotrollover_text = "onclick=\"if(window.document.body && mClk){mClk(this);return false;}\" "
    ."onmouseout=\"if(window.document.body && mOut){mOut(this,'"
    .$zen->getSetting("color_background")."', '');}\" "
    ."onmouseover=\"if(window.document.body && mOvr){mOvr(this,'"
    .$zen->getSetting("color_highlight")."', '');}\"";

  $heading_rollover = " onmouseout=\"if(window.document.body && mOut){mOut(this,'"
    .$zen->getSetting("color_bar_darker")."','"
    .$zen->getSetting("color_alt_text")."');}\" "
    ."onmouseover=\"if(window.document.body && mOvr){mOvr(this,'"
    .$zen->getSetting("color_alt_background")."','"
    .$zen->getSetting("color_alt_text")."');}\" ";


  $nav_rollover_eff = " onmouseout=\"if(window.document.body && mOut){mOut(this,'"
    .$zen->getSetting("color_bar_darkest")."');}\" "
    ."onmouseover=\"if(window.document.body && mOvr){mOvr(this,'"
    .$zen->getSetting("color_alt_background")."');}\" ";

  $nav_rollover_text = " onclick=\"if(window.document.body && mClk){mClk(this);return false;}\" ".$nav_rollover_eff;

  $lnav_rollover = " onmouseout=\"if(window.document.body && mOut){mOut(this,'"
    .$zen->getSetting("color_bars")."');}\" "
    ."onmouseover=\"if(window.document.body && mOvr){mOvr(this,'"
    .$zen->getSetting("color_alt_background")."');}\" "
    ." onclick=\"if(window.document.body && mClk){mClk(this);return false;}\" ";
    
  $row_rollover_eff = 'onmouseout="if(window.document.body && mClassX){mClassX(this);}" 
      onmouseover="if(window.document.body && mClassX){mClassX(this,\'altBars\',true);}"';

  /**
   * Returns true if a login is required to view the current page.
   *
   * Currently this returns false under the following conditions:
   * <ul>
   *  <li>ZT_HELP is defined
   *  <li>$SCRIPT_NAME matches styles.php or behavior_js.php
   * </ul>
   */
  function ztLoginRequired() {
    $section = getZtSection();
    return $section  != 'admin' && $section != 'help' && $section != 'js' && $section != 'css';
  }
  
  function eLink($email) {
    $zen = $GLOBALS['zen'];
    if( !$email ) { return '&nbsp;'; }
    if( !strpos($email,'@') ) { return $zen->ffv($email); }
    list($name,$dom) = explode('@',$email);
    return '<script>eLink('.$zen->fixJsVal($name).','.$zen->fixJsVal($dom).')</script>';
  }

  /*
  **  USER AUTHENTICATION
  **
  **  determine if a login is required
  */

  if( ztLoginRequired() ) {
	  include("$libDir/loginfromxoops.php");
  }     

/*  if( ztLoginRequired() ) {
    include_once("$libDir/login.php");
  }
*/

  /**
  * Generate group info, since it takes several queries
  * This array is reset when a logoff occurs, so make sure this
  * is after the login include
  */
  if( !array_key_exists('data_groups', $_SESSION) || !$_SESSION['data_groups'] ) {
    $_SESSION['data_groups'] = $zen->generateDataGroupInfo();
  }

  /**
  * The list of valid log action types
  */
  $log_actions = $zen->getActivities();

  // help links
  // determine which directory contains
  // our current translation (if one exists)
  $helpBase = $rootUrl."/help";
  $helpLang = $_SESSION['login_language'];
  if( !@is_dir("$rootWWW/help/$helpLang") ) {
    // it may be that we have languages which are not
    // translated to the help section yet, so switch
    // these back to english, which is better than nothing
    $helpLang = 'english';
  }
  $helpUrl = "$helpBase/$helpLang";
  $helpDir = "$rootWWW/help/$helpLang";

  // you can't have any spaces after this closing tag!
}?>
