<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }
xoops_cp_header();

  function renderNavTab( $name, $page ) {
    global $keyRegisterEvents;
    global $nav_rollover_text;
    global $hotkeys;
    global $rootUrl;
    global $imageUrl;
    $keyRegisterEvents[] = array($name, $page);

    $key = $hotkeys->find($name);
    $title = $hotkeys->tooltip($key);

    $txt = "<td height='25' title='$title' valign='middle'";
    if( getZtSection() == strtolower($name) ) {
      $class = "navTab navOn";
    }
    else {
      $class = "navTab navOff";
      $txt .= " $nav_rollover_text ";
    }
    $txt .= "class='$class'>";
    $txt .= "<a class='$class' href='$rootUrl/$page'>".$hotkeys->label($key)."</a>\n";
    $txt .= "</td><td width='4'><img src='{$imageUrl}/empty.gif' width='1' height='1' border='0'></td>\n";
    return $txt;
  }

  // number of columns in nav table
  $nav_col_span = 4;

  // height of the separator between nav tabs and main content
  $nav_bar_height = 12;

//  $nav_tabs =  renderNavTab('Projects', 'projects.php');
//  $nav_tabs .= renderNavTab('Tickets', 'index.php');
  if ($login_level != 'first_login' &&
    $login_level >= $zen->getSetting("level_contacts") &&
    $zen->settingOn('allow_contacts') ) {
//    $nav_tabs .= renderNavTab('Contacts','contacts.php');
  }
  if( $login_id ) {
//    $nav_tabs .= renderNavTab('Options','options.php');
  }
//  $nav_tabs .= renderNavTab('Help','help/index.php');
  if( $zen->checkNum($login_level) >= $zen->getSetting("level_settings") ) {
//   $nav_tabs .= renderNavTab('Admin', 'admin/index.php');
  }
/*
  // load hot key selections
  $sect = getZtSection();
  $load_section = $sect != 'undefined' && file_exists("$templateDir/nav_$sect.php");
  if( $load_section ) {
    $hotkeys->loadSection($sect);
    $GLOBALS['zt_hotkeys'] = $hotkeys;
  }
*/


?>



<table width="100%" cellpadding="0" cellspacing="0">

  <link rel="stylesheet" type="text/css" media="screen" href="<?=$rootUrl?>/styles.php"  />

<script type='text/javascript'>
    var imageUrl = <?=$zen->fixJsVal($imageUrl)?>;
    var rootUrl = <?=$zen->fixJsVal($rootUrl)?>;
    var id = <?=$zen->fixJsVal(id)?>;
    var hotkeyHelpDelay = <?=$zen->fixJsVal($zen->getSetting('hotkeys_help_delay'))?>;
    var hotkeyHintDelay = <?=$zen->fixJsVal($zen->getSetting('hotkeys_hint_delay'))?>;
    var loaded = false;
  </script>
  <script language="javascript" src="<?=$rootUrl?>/javascript.js"></script>
  <script language="javascript" src="<?=$rootUrl?>/keyevent.js"></script>
  
<script language="javascript">


	/**
	 * Added on 28.07.2005 in order to make files (.js+.css) included regardless of 
	 * zen action (which are included within a sub /actions/ dir.
	 */

	var zenSubPath = '<?=$ZENTRACK_MODULE_SUB?>'; 		//eg.: '/zentrack/modules'
	var fullURL = window.location.toString();			//eg.: http://some.url/whatever/xoops/zentrack/*
	
	//
	// zenRootURL will contain the fullURL, truncated there zenSubPath ends
	// NOTE: contains no trailling slash as the php var $ZENTRACK_MODULE_SUB should not!
	//
	var zenRootURL = fullURL.substr(0,fullURL.indexOf(zenSubPath)+zenSubPath.length);

	// let's include the calendar path to make things a bit nicer!

	zenRootURL += "/jscalendar";

	// watch the single quotes + script tag break up => s'+'cr

	document.write('<link rel="stylesheet" title="0" type="text/css" media="screen" href="'+zenRootURL+'/calendar-blue.css">');
	document.write('<s'+'cript type="text/javascript" src="'+zenRootURL+'/calendar_stripped.js"></s'+'cript>');
	document.write('<s'+'cript type="text/javascript" src="'+zenRootURL+'/lang/calendar-en.js"></s'+'cript>');
	document.write('<s'+'cript type="text/javascript" src="'+zenRootURL+'/calendar-setup_stripped.js"></s'+'cript>');


</script>  
  
<?php
  for($i=0; $i<count($onLoad); $i++) {
    $s = $onLoad[$i];
    print "<script language='javascript' src='$rootUrl/$s'></script>\n";
  }

///////////////////////////////////////////////////////////


// Code for the page
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';


    // print out any system messages
    // which are queued up for display
    if( $msg && !is_array($msg) ) {
       $msg = array($msg);
    }
    if( is_array($msg) && count($msg) ) {
       foreach($msg as $m) {
          print "<div class='highlight indent'>".$zen->ffv($m)."</div>";
       }
       $msg = array();
    }
?>