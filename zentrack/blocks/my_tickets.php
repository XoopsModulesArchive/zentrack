<?php
if ( file_exists(XOOPS_ROOT_PATH."/modules/zentrack/language/".$xoopsConfig['language']."/modinfo.php") ) {
    include_once XOOPS_ROOT_PATH."/modules/zentrack/language/".$xoopsConfig['language']."/modinfo.php";
} else {
	include_once XOOPS_ROOT_PATH."/modules/zentrack/language/english/modinfo.php";
}

function b_zt_show_mytickets($options)
{
	include_once(XOOPS_ROOT_PATH."/modules/zentrack/includes/functions.php");	

	global $xoopsModule, $xoopsUser, $xoopsDB, $myts, $zt_zen;
	$mydirname = basename( dirname( __FILE__ ) ) ;
	$myts =& MyTextSanitizer::getInstance();
	$block = array();
	if($xoopsUser){
		
		$zen = get_zt_object();
		$login_id = $zen->user["user_id"];

		$params = array("status"  => array('OPEN','PENDING'),
			"user_id" => $login_id,
			"type_id" => $zen->notProjectTypeIDs(),
			"bin_id"  => $zen->getUsersBins($login_id)
		  );
	
//		include_once("$libDir/sorting.php");
		$tickets = $zen->get_tickets($params);
	  
		$block['title'] = _MI_ZENTRACKXOOPS_BNAME_MYTICKETS;

		If ($options[0] <= 0 || $options[0] > 99) {
			$maxcount = 99;
		} else {
			$maxcount = $options[0];
		}
			
		if( is_array($tickets) && count($tickets) ) {
	  		$counter = 0;
			foreach($tickets as $t) {
				$ticket_id = $myts->makeTboxData4Show($t['id']);
				$creator_id = $myts->makeTboxData4Show($t['creator_id']);
				$login = $zen->get_user($creator_id);
				$login = $myts->makeTboxData4Show($login['login']);
				
				$title = $myts->makeTboxData4Show($t['title']);
				$bin_id = $myts->makeTboxData4Show($t['bin_id']);
				$bin = $zen->getBinName($bin_id);
				$opened = $zen->showDateTime($t['otime']);
	
				
		    	$a_item['ticket_id'] = $ticket_id;
		    	$a_item['login'] = $login;
		    	$a_item['opened'] = $opened;
		    	$a_item['bin'] = $bin;
		    	$a_item['link'] = "<a href=\"".XOOPS_URL."/modules/zentrack/ticket.php?id=$ticket_id\">$title</a>";
		    	$block['items'][] = $a_item;
		    	$counter += 1;
		    	if ($counter >= $maxcount) break;
		    }
		}
		return $block;
	}
	
}



function b_zt_edit_mytickets($options)
{
    $form = "" . _MI_ZTOPTION_MYTICKETS_NUMTICKETS . "&nbsp;";
    $form .= "<input type='text' name='options[]' value='" . $options[0] . "' />&nbsp;" . _MI_ZTOPTION_MYTICKETS_TICKETS . "";
    return $form;
} 
?>
