<?php

define('ZT_SECTION', 'admin');
//  include_once("../header.php");
//  include_once("xoops_admin_header.php");


include_once "../../../mainfile.php";
include_once "../../../include/cp_header.php";

include_once XOOPS_ROOT_PATH.'/modules/zentrack/includes/functions.php';


$myts = & MyTextSanitizer::getInstance();


// 
	define('ZT_DEFINED', true);

	$ZENTRACK_MODULE_SUB = "/modules/zentrack";
	$ZENTRACK_MODULE_ROOT = XOOPS_ROOT_PATH.$ZENTRACK_MODULE_SUB;

	$xoopsOption['template_main'] = 'zentrack_index.html';


  $libDir = $ZENTRACK_MODULE_ROOT.'/includes';

  // the base url used to reach zentrack
	$rootUrl =  XOOPS_URL.$ZENTRACK_MODULE_SUB;

  // the directory where the www files are stored
	$rootWWW = $ZENTRACK_MODULE_ROOT;
	$Db_Type      = XOOPS_DB_TYPE;      //sql type
	$Db_Instance  = XOOPS_DB_NAME;   //db name
	$Db_Login     = XOOPS_DB_USER;       //username
	$Db_Pass      = XOOPS_DB_PASS;       //password
	$Db_Host      = XOOPS_DB_HOST;  //host of database

	define('ZT_SECTION', 'admin');

	$configFile = "$libDir/configVars.php";
	include_once("$libDir/headerInc.php");


  $section = "Admin";
  $page_title = tr("Administration");

  $system_name = $zen->getSetting("system_name");
  
 

  
  /*
  ** USER ADMINISTRATION COMMON FIELDS
  */
  $user_fields = array(
		       "login"    =>   "alphanum",
		       "access_level"   =>   "int",
		       "lname"    =>   "text",
		       "fname"    =>   "text",
		       "initials" =>   "alphanum",
		       "email"    =>   "email",
		       "notes"    =>   "text",
		       "homebin"  =>   "int",
		       "active"   =>   "int"
		       );
  $user_required = array("login","lname","initials");

  $access_fields = array(
			 "user_id"  =>  "int",
			 "bin_id"   =>  "int",
			 "lvl"     =>  "int",
			 "notes"   =>  "text"
			 );
  $access_required = array("user_id","bin_id");


  /*
  ** NUMBER PULLDOWN FUNCTION
  */

  function admin_number_pulldown( $max = '', $sel = '' ) {
    static $cache_pulldown;
    if( is_array($cache_pulldown) 
        && $cache_pulldown[0] == $max
          && $cache_pulldown[1] == $sel ) {
      return $cache_pulldown[2];
    }
    if( !$max )
    $max = 1;
    $text = "<option value=''>---</option>\n";
    for( $i=1; $i<=$max; $i++ ) {
      $s = ($i == $sel)? " selected" : "";
      $text .= "<option$s>$i</option>\n";
    }
    $cache_pulldown = array($max,$sel,$text);
    return $text;
  }
  
  function getPriCount( $current, $lowest ) {
    return 1 + ($current - $lowest);
  }
  
  
  /*
  ** SETTINGS ADMINISTRATION COMMON FIELDS
  */

  $settings_fields = array(
                          "name"        => "alphanum",
                          "value"       => "html",
                          "description" => "html"
                          );
  $settings_required = array("name","value");
  
  if( !isset($TODO) ) { $TODO = null; }

?>