<?php {
  // zenTrack configuration settings
  // it's a good idea to keep a backup
  // of this file somewhere safe when upgrading!

  /* DO NOT PUT ANYTHING, INCLUDING SPACES, OUTSIDE OF THE <?php ?> marks */

  
  /////////////////////////////////////////////////////////////////////////
  //  Section Specific For Xoops2
  //
  /////////////////////////////////////////////////////////////////////////

  // zenTrackXoops configuration settings
  // 


  if( file_exists('../../mainfile.php') ) {
		include_once( '../../mainfile.php');
  }elseif( file_exists('../../../mainfile.php') ) {
		include_once( '../../../mainfile.php');
  }elseif( file_exists('../../../../mainfile.php') ) {
		include_once( '../../../../mainfile.php');
  }elseif( file_exists('../../../../../mainfile.php') ) {
		include_once( '../../../../../mainfile.php');
  }

// $ZENTRACKXOOPS_DB_PREFIX is used in configVars.php to
// define the XOOPS table prefix.  
  $ZENTRACKXOOPS_DB_PREFIX = XOOPS_DB_PREFIX.'_';

	$ZENTRACK_MODULE_SUB = "/modules/zentrack";
	$ZENTRACK_MODULE_ROOT = XOOPS_ROOT_PATH.$ZENTRACK_MODULE_SUB;

	$xoopsOption['template_main'] = 'zentrack_index.html';

include(XOOPS_ROOT_PATH."/header.php");


//collect the zentrack_index template

  if (!isset($zenMainFlag)) {

      ob_start();
      $zenMainFlag = true;
  }

  // the directory where zentrack includes are stored
  // This MUST be a subdirectory under the ZenTrack Module
  // You shouldn't have to modify this!
  $libDir = $ZENTRACK_MODULE_ROOT.'/includes';

  // the base url used to reach zentrack
  $rootUrl =  XOOPS_URL.$ZENTRACK_MODULE_SUB;

  // the directory where the www files are stored
  $rootWWW = $ZENTRACK_MODULE_ROOT;

  /*
  **
  **  ZENTRACKXOOPS DATABASE SETTINGS
  **
  */
  $Db_Type      = XOOPS_DB_TYPE;      //sql type
  $Db_Instance  = XOOPS_DB_NAME;   //db name
  $Db_Login     = XOOPS_DB_USER;       //username
  $Db_Pass      = XOOPS_DB_PASS;       //password
  $Db_Host      = XOOPS_DB_HOST;  //host of database

$login_id = $_SESSION['xoopsUserId'];

  /////////////////////////////////////////////////////////////////////////
  //  END OF XOOPS SPECIFIC ENTRY
  /////////////////////////////////////////////////////////////////////////

  
  
  /*
  ** DEMO MODE AND DEBUG OUTPUT 
  **
  ** This will solve many of your troubles...
  ** please turn it on, and copy and paste
  ** useful portions of the output into any 
  ** support requests
  ** 
  **  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
  **  VERY VERY VERY VERY IMPORTANT!!!!!!!
  **  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
  **
  ** Debugging is not for production use.  Use it during
  ** setup and then be sure to turn it off.  It provides
  ** information about your system that is not for public
  ** consumption.
  */

  //set this from 0=off, 1=errors, 2=warnings, 3=notices(all)
  //$Debug_Mode = 0;

//if ($xoopsUser->isAdmin()) {
//    $Debug_Mode = 3;
//} else {
//    $Debug_Mode = 0;
//}

  //set this to "on" prevents users from doing anything you don't
  //want them doing on a demo site
  $Demo_Mode = "off"; 
  
  /*
  **
  ** MISC SETTINGS
  **
  */

  // the prefix to appear in the browser title
  $page_prefix = "zenTrack | ";

  // the title to appear in the browser title
  $page_title = "Welcome to zenTrack";
  
  // the configuration settings for the zenTrack functions
  $configFile = "$libDir/configVars.php";
  
  // the maximum number of system messages to keep in memory
  $system_message_limit = 20;

   // LOCALE/DATE HELPERS
   // WINDOWS USERS
   //
   // %T and %D will not work on Windows
   // search http://msdn.microsoft.com/ for strftime().
   // 
   // Control Panel->International Settings
   // You can set your locale and customize it
   // And locale-related PHP functions work perfectly
   // IF NEEDED, uncomment the following entry
   // and set it to your location.. use locale -a 
   // to see a list of possibilities
   // see the php manual for more info on setlocale()
   // setlocale(LC_TIME, "C");
   // setlocale(LC_TIME, "POSIX");
   // setlocale(LC_TIME, "en_US");  // U.S.
   // setlocale(LC_TIME, "fr_FR");  // french
   // setlocale(LC_TIME, "de_DE");  // german
   // setlocale(LC_TIME, "es_ES");  // spanish

  /*
  **  LEAVE THIS PART ALONE
  */
  define('ZT_DEFINED', true);
  include_once("$libDir/headerInc.php");
  
}?>
