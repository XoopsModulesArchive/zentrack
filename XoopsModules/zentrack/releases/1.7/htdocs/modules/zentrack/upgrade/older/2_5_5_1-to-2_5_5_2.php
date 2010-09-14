<?php

require( '../../../mainfile.php' ) ;


echo '<html><head><title>zentrackxoops 2.5.5.1 to 2.5.5.2 upgrade</title></head><body>';

if (isset($_POST['submit'])) {


	if (!$GLOBALS['xoopsDB']->queryFromFile('./mysql_upgrade-2.5.5.1-2.5.5.2.sql')) {
		die ('FAILED Executing mysql_upgrade-2.5.5.1-2.5.5.2.sql');
	}
	$GLOBALS['xoopsDB']->query('DROP TABLE IF EXISTS ' . $GLOBALS['xoopsDB']->prefix('zentrack_translation_strings') ) ;
	$GLOBALS['xoopsDB']->query('DROP TABLE IF EXISTS ' . $GLOBALS['xoopsDB']->prefix('zentrack_translation_words') ) ;
# create an entry for each existing ticket in the varfields table 
	$GLOBALS['xoopsDB']->query('insert into '. $GLOBALS['xoopsDB']->prefix('zentrack_varfield').' (ticket_id) select id from '.$GLOBALS['xoopsDB']->prefix('zentrack_tickets').'; ' ) ;

	echo $xoopsLogger->dumpQueries();
	echo 'zentrackxoops 2.5.5.1 to 2.5.5.2 upgrade complete<br /><a href='.XOOPS_URL.'/modules/zentrack/>Click here for Zentrack</a>';

} else {


	echo 'Click on Submit button to upgrade zentrackxoops from version 2.5.5.1 to 2.5.5.2<br />

<form action="2_5_5_1-to-2_5_5_2.php" method="post">
<input type="submit" name="submit" value="'._SUBMIT.'" />
</form>';

}

echo '</body></html>';
?>
