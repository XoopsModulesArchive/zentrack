<?
  
  $b = dirname(__FILE__);
  define('ZT_SECTION', 'help');
  include(dirname($b)."/header.php");

  $page_prefix = tr("zenTrack Help | ");
  $page_section = tr("Help Menu");
  $page_name = null;
  
  $tutImageUrl = "$imageUrl/help_screenshots/$helpLang";

  // store our directory links in the global scope
  // for functions and pages
  $GLOBALS['helpDir'] = $helpDir;
  $GLOBALS['helpBase'] = $helpBase;
  $GLOBALS['helpUrl'] = $helpUrl;
  
  /**
   * Generates navigation links showing the previous page, next
   * page, and table of contents link.
   */
  function renderNavbar( $section ) {
    // make a pretty label for the section
    $sectionName = tr( ucwords($section)." Index" );
    
    // collect the correct data array
    $s = "{$section}TOC";
    $list = $GLOBALS[$s];
    $helpUrl = $GLOBALS['helpUrl'];
    $helpBase = $GLOBALS['helpBase'];

    // find out where we are in the list
    $thisPage = basename($_SERVER['SCRIPT_NAME']);
    $keys = array_keys($list);
    $lastPage = null;
    $nextPage = null;
    if( $thisPage == 'index.php' ) {
      // if we are on the index page, the first
      // key is the next to view
      $nextPage = $keys[0];
    }
    else {
      // otherwise, we will look through the keys,
      // find ours, then create our elements from there
      for($i=0; $i<count($keys); $i++) {
        if( $keys[$i] == $thisPage ) {
          // this is our guy
          if( $i > 0 ) {
            // only if we aren't on the first page
            // the index is already shown as a menu choice
            $lastPage = $keys[$i-1];
          }
          if( $i < count($keys)-1 ) {
            // only if this isn't the last page
            $nextPage = $keys[$i+1];
          }
        }
      }
    }

    print "<table width='80%' align='center'><tr>\n";

    // previous link
    print "<td align='left' width='25%'>";
    if( $lastPage ) {       
      $v = $list[$lastPage];
      print "<b><a href='$helpUrl/$section/$lastPage'>&lt;&lt;</a></b>";
      print "&nbsp;<a href='$helpUrl/$section/$lastPage'>$v</a>";
    }
    else {
      print '&nbsp;';
    }
    print "</td>\n";

    // table of contents link
    print "<td align='center' width='50%'>\n";
    print "<a href='$helpUrl/$section/index.php'>$sectionName</a>&nbsp;|&nbsp;";
    print "<a href='$helpBase/index.php'>Help Index</a>";
    print "</td>\n";

    // next link
    print "<td align='right' width='25%'>";
    if( $nextPage ) {
      $v = $list[$nextPage];
      print "<a href='$helpUrl/$section/$nextPage'>$v</a>";
      print "&nbsp;<b><a href='$helpUrl/$section/$nextPage'>&gt;&gt;</a></b>";
    }
    else {
      print '&nbsp;';
    }
    print "</td>\n";

    print "</tr></table>\n";
  }

  function renderTOC( $section, $overview = false ) {
    // determine what language we are speaking and if
    // a translation exists
    $helpUrl = $GLOBALS['helpUrl'];
    
    // collect the correct data array
    $s = "{$section}TOC";
    $list = $GLOBALS[$s];

    // output the list
    //print "<ul>\n";
    //$b = '';
    if( $overview ) {
      print "<p onclick='mClk(this)'><a href='$helpUrl/$section/index.php'>".tr("Overview")."</a></p>\n";
      //$b = '<br>';
    }
    foreach($list as $page=>$v) {
      if( is_array($v) ) {
        list($name,$desc) = $v;
      }
      else {
        $name = $v;
        $desc = false;
      }
      print "<p onclick='mClk(this)'><a href='$helpUrl/$section/$page'>$name</a>";
      if( $desc ) { print "<span class='note'>$desc</span>"; }
      print "</p>\n";
      //if( !$b ) { $b = '<br>'; }
    }
    //print "</ul>\n";
  }

  /**
   * Do not edit these values for translation.  Simply edit the appropriate
   * language files instead.
   */
  $usersTOC = array(
		    "tickets.php"      => tr("Tickets"),
		    "projects.php"     => tr("Projects"),
		    "options.php"      => tr("Personal Options"),
        "contacts.php"     => tr("Contacts")
		    );

  $adminTOC = array(
		    "bins.php"            => array(tr("Bins and Permissions"),tr("Explanation of access controls")),
		    "data_types.php"      => array(tr("Data Types"),     tr("Setting up standard ticket fields")),
		    "data_groups.php"     => tr("Data Groups"),
		    "behaviors.php"       => array(tr("Behaviors"),      tr("Creating dynamic values and choices in fields")),
        "fieldmap.php"        => array(tr("Field Map"),      tr("Configuring fields for various screens")), 
		    "varfields.php"       => array(tr("Variable Fields"),tr("Setting up custom fields for use")),
		    "settings.php"        => tr("System Settings")
		    );

   $GLOBALS['usersTOC'] = $usersTOC;
   $GLOBALS['adminTOC'] = $adminTOC;
        
?>