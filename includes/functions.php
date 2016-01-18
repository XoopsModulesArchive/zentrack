<?php

/**
* $Id: functions.php
* Module: ZentrackXoops
* Author: dkeir
* Special Thanks: marcan <marcan@smartfactory.ca> - The tabbed menu is from marcan's SmartFAQ modules
* 					and modified especially for the Admin Menu and Blocks stuff in ZentrackXoops
* Licence: GNU
*/

  
  function get_zt_object(){
  define('ZT_DEFINED', true);
  	global $xoopsUser, $Db_Type, $Db_Instance, $Db_Login, $Db_Pass, $Db_Host;

  $libDir = XOOPS_ROOT_PATH."/modules/zentrack/includes";
	$rootUrl =  XOOPS_URL."/modules/zentrack";

    
  
  $Db_Type      = XOOPS_DB_TYPE;      //sql type
  $Db_Instance  = XOOPS_DB_NAME;   //db name
  $Db_Login     = XOOPS_DB_USER;       //username
  $Db_Pass      = XOOPS_DB_PASS;       //password
  $Db_Host      = XOOPS_DB_HOST;  //host of database

  	include_once("$libDir/zenTrack.class.php");
	$zen = new zenTrack( "$libDir/configVars.php" );
	

	
if ( $xoopsUser ) {
      $login_email = $xoopsUser->getVar('email');
      $logid = $xoopsUser->getVar('uid');
	          

	  
	  //  First we see if the Xoops user (loginname) exists in Zentrack
	//  if( !$zen->check_user_login($login_nm) ) {
	  if( $zen->get_users_by_email($login_email) ) {
	
			$temp_array = $zen->get_users_by_email($login_email);
	  		if($temp_array) {
	  			$zen->user = $zen->getuser($temp_array[0]);
	  		}else {
	  			$zen->user = null;
	  		}
	      	$login_id = $zen->user["user_id"];
	  	
	  }
	
	      $_SESSION['login_id'] = $login_id;

	      return $zen;
	  }
	  else {
	  	return null;
	  }
  }
  
  
function showTabbedMenu ($currentoption = 0)
{
	
	/* Nice buttons styles */
	echo "
    	<style type='text/css'>
    	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/zentrack/images/bg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
    	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		#buttonbar li { display:inline; margin:0; padding:0; }
		#buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/zentrack/images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
		#buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/zentrack/images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#buttonbar a span {float:none;}
		/* End IE5-Mac hack */
		#buttonbar a:hover span { color:#333; }
		#buttonbar #current a { background-position:0 -150px; border-width:0; }
		#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		#buttonbar a:hover { background-position:0% -150px; }
		#buttonbar a:hover span { background-position:100% -150px; }
		</style>
    ";
	
	// global $xoopsDB, $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
	global $xoopsModule, $xoopsConfig;
	$myts = &MyTextSanitizer::getInstance();
	
	$tblColors = Array();
	$tblColors[0] = $tblColors[1] = $tblColors[2] = $tblColors[3] = $tblColors[4] = $tblColors[5] = $tblColors[6] = $tblColors[7] = $tblColors[8] = $tblColors[9] = $tblColors[10] = $tblColors[11] = $tblColors[12] = '';
	$tblColors[$currentoption] = 'current';

	
//	echo "<div id='buttontop'>";
//	echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
//	echo "<td style='width: 100%'></td>";
//	echo "</tr></table>";
//	echo "</div>";

echo "<tr><td style='width: 100%'>";

	echo "<div id='buttontop'>";
	echo "<tr>";
	echo "<td style='width: 100%'></td>";
	echo "</tr>";
	echo "</div>";

	echo "<tr>";
	echo "<td style='width: 100%'>";

	echo "<div id='buttonbar'>";
	echo "<ul>";
	echo "<li id='" . $tblColors[0] . "'><a href=\"" . XOOPS_URL . "/modules/zentrack/admin/admin_index.php\"><span>" . tr("Index") . "</span></a></li>";
	echo "<li id='" . $tblColors[1] . "'><a href=\"" . XOOPS_URL . "/modules/zentrack/admin/addUser.php\"><span>" . tr("New User") . "</span></a></li>";
	echo "<li id='" . $tblColors[2] . "'><a href=\"" . XOOPS_URL . "/modules/zentrack/admin/listUsers.php\"><span>" . tr("Edit User") . "</span></a></li>";
//	echo "<li id='" . $tblColors[3] . "'><a href=\"" . XOOPS_URL . "/modules/zentrack/admin/editTicket.php\"><span>" . tr("Tickets") . "</span></a></li>";
	echo "<li id='" . $tblColors[4] . "'><a href=\"" . XOOPS_URL . "/modules/zentrack/admin/fieldMap.php\"><span>" . tr("Field Map") . "</span></a></li>";
	echo "<li id='" . $tblColors[5] . "'><a href=\"" . XOOPS_URL . "/modules/zentrack/admin/bins.php\"><span>" . tr("Bins") . "</span></a></li>";
	echo "<li id='" . $tblColors[6] . "'><a href=\"" . XOOPS_URL . "/modules/zentrack/admin/priorities.php\"><span>" . tr("Priorities") . "</span></a></li>";
	echo "<li id='" . $tblColors[7] . "'><a href=\"" . XOOPS_URL . "/modules/zentrack/admin/systems.php\"><span>" . tr("Systems") . "</span></a></li>";
	echo "<li id='" . $tblColors[8] . "'><a href=\"" . XOOPS_URL . "/modules/zentrack/admin/tasks.php\"><span>" . tr("Tasks") . "</span></a></li>";
	echo "<li id='" . $tblColors[9] . "'><a href=\"" . XOOPS_URL . "/modules/zentrack/admin/types.php\"><span>" . tr("Types") . "</span></a></li>";
	echo "<li id='" . $tblColors[10] . "'><a href=\"" . XOOPS_URL . "/modules/zentrack/admin/groups.php\"><span>" . tr("Groups") . "</span></a></li>";
	echo "<li id='" . $tblColors[11] . "'><a href=\"" . XOOPS_URL . "/modules/zentrack/admin/behaviors.php\"><span>" . tr("Behaviors") . "</span></a></li>";
	echo "<li id='" . $tblColors[12] . "'><a href=\"" . XOOPS_URL . "/modules/zentrack/admin/config.php\"><span>" . tr("Settings") . "</span></a></li>";

	echo "</ul></div>";
	
	echo "</td>";
	echo "</tr>";
}




function createBinsSelect($selectedbin=0, $bins)
{
	$myts = &MyTextSanitizer::getInstance();

	$ret = "" . _MI_ZTOPTION_QKTICKET_BINS . "&nbsp;<select name='options[]'>";

	
	foreach($bins as $bin) {
		$bin_id = $myts->makeTboxData4Show($bin['bid']);
		$bin_name = $myts->makeTboxData4Show($bin['name']);
		$ret .= "<option value='" . $bin_id . "'";
		if ($selectedbin == $bin_id) {
			$ret .= " selected='selected'";
		}
		$ret .= ">". $bin_name . "</option>\n";
	}
	$ret .= "</select>\n";
	return $ret;
}



function createPrioritiesSelect($selectedpriority=0, $priorities)
{
	$myts = &MyTextSanitizer::getInstance();

	$ret = "" . _MI_ZTOPTION_QKTICKET_PRIORITY . "&nbsp;<select name='options[]'>";

	
	foreach($priorities as $priority) {
		$priority_id = $myts->makeTboxData4Show($priority['pid']);
		$priority_name = $myts->makeTboxData4Show($priority['name']);
		$ret .= "<option value='" . $priority_id . "'";
		if ($selectedpriority == $priority_id) {
			$ret .= " selected='selected'";
		}
		$ret .= ">". $priority_name . "</option>\n";
	}
	$ret .= "</select>\n";
	return $ret;
}

function createSystemsSelect($selectedsystem=0, $systems)
{
	$myts = &MyTextSanitizer::getInstance();

	$ret = "" . _MI_ZTOPTION_QKTICKET_SYSTEM . "&nbsp;<select name='options[]'>";

	
	foreach($systems as $system) {
		$system_id = $myts->makeTboxData4Show($system['sid']);
		$system_name = $myts->makeTboxData4Show($system['name']);
		$ret .= "<option value='" . $system_id . "'";
		if ($selectedsystem == $system_id) {
			$ret .= " selected='selected'";
		}
		$ret .= ">". $system_name . "</option>\n";
	}
	$ret .= "</select>\n";
	return $ret;
}

function createTypesSelect($selectedtype=0, $types)
{
	$myts = &MyTextSanitizer::getInstance();

	$ret = "" . _MI_ZTOPTION_QKTICKET_TYPE . "&nbsp;<select name='options[]'>";

	
	foreach($types as $type) {
		$type_id = $myts->makeTboxData4Show($type['type_id']);
		$type_name = $myts->makeTboxData4Show($type['name']);
		$ret .= "<option value='" . $type_id . "'";
		if ($selectedtype == $type_id) {
			$ret .= " selected='selected'";
		}
		$ret .= ">". $type_name . "</option>\n";
	}
	$ret .= "</select>\n";
	return $ret;
}


  
?>