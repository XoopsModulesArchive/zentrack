<?php

if ( file_exists(XOOPS_ROOT_PATH."/modules/zentrack/language/".$xoopsConfig['language']."/modinfo.php") ) {
    include_once XOOPS_ROOT_PATH."/modules/zentrack/language/".$xoopsConfig['language']."/modinfo.php";
} else {
	include_once XOOPS_ROOT_PATH."/modules/zentrack/language/english/modinfo.php";
}

function b_zt_show_quickticket($options)
{
	include_once(XOOPS_ROOT_PATH."/modules/zentrack/includes/functions.php");	

	global $xoopsModule, $xoopsUser, $xoopsDB, $myts, $zt_zen;
	$mydirname = basename( dirname( __FILE__ ) ) ;
	$myts =& MyTextSanitizer::getInstance();
	$block = array();
	if($xoopsUser){
		
		$zen = get_zt_object();
		$login_id = $zen->user["user_id"];
	  
		$block['title'] = _MI_ZENTRACKXOOPS_BNAME_QKTICKETS;

		$a_item['input'] = "<input type='hidden' name='bin_id' value='" . $options[0] . "'>";
    	$block['items'][] = $a_item;
		$a_item['input'] = "<input type='hidden' name='priority' value='" . $options[1] . "'>";
    	$block['items'][] = $a_item;
		$a_item['input'] = "<input type='hidden' name='system_id' value='" . $options[2] . "'>";
    	$block['items'][] = $a_item;
		$a_item['input'] = "<input type='hidden' name='type_id' value='" . $options[3] . "'>";
    	$block['items'][] = $a_item;

    	$block['bin'] = "Default Bin: " . $zen->getBinName($options[0]) ;
	}

	return $block;
	
}



function b_zt_edit_quickticket($options)
{
	include_once(XOOPS_ROOT_PATH."/modules/zentrack/includes/functions.php");	

	$zen = get_zt_object();
	$priorities = $zen->getPriorities(1);
	$bins = $zen->getBins(1);
	$types = $zen->getTypes(1);
	$systems = $zen->getSystems(1);
	$form = createBinsSelect($options[0], $bins);
	$form .= "&nbsp; &nbsp;";
	$form .= createPrioritiesSelect($options[1], $priorities);
	$form .= "&nbsp;<br>";
	$form .= createSystemsSelect($options[2], $systems);
	$form .= "&nbsp; &nbsp;";
	$form .= createTypesSelect($options[3], $types);

	return $form;
	
	
} 
?>
