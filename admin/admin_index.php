<?php

/**
* $Id: index.php,v 1.12 2004/09/24 14:41:09 malanciault Exp $
* Module: SmartFAQ
* Author: marcan <marcan@smartfactory.ca>
* Licence: GNU
*/

include_once("admin_header.php");

$myts = & MyTextSanitizer::getInstance();



// Code for the page
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';



//xoops_cp_header();
global $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule;

include("$libDir/admin_nav.php");

include("$templateDir/adminMenu.php");

include("$libDir/footer.php");

//xoops_cp_footer();