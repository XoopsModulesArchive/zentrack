<?php

require( '../../../mainfile.php' ) ;


echo '<html><head><title>zentrackxoops 2.5.0 to 2.5.5 upgrade</title></head><body>';

if (isset($_POST['submit'])) {


	if (!$xoopsDB->queryFromFile('./mysql_upgrade-2.5.0-2.5.5.sql')) {
		die ('FAILED Executing mysql_upgrade-2.5.0-2.5.5.sql');
	}
	$xoopsDB->query('DROP TABLE IF EXISTS ' . $xoopsDB->prefix('zentrack_translation_strings') ) ;
	$xoopsDB->query('DROP TABLE IF EXISTS ' . $xoopsDB->prefix('zentrack_translation_words') ) ;
# create an entry for each existing ticket in the varfields table 
	$xoopsDB->query('insert into '. $xoopsDB->prefix('zentrack_varfield').' (ticket_id) select id from '.$xoopsDB->prefix('zentrack_tickets').'; ' ) ;

	echo $xoopsLogger->dumpQueries();
	echo 'zentrackxoops 2.5.0 to 2.5.5 upgrade complete<br /><a href='.XOOPS_URL.'/modules/zentrack/>Click here for Zentrack</a>';

} else {


	echo 'Click on Submit button to upgrade zentrackxoops from version 2.5.0 to 2.5.5<br />

<form action="2_5_0-to-2_5_5.php" method="post">
<input type="submit" name="submit" value="'._SUBMIT.'" />
</form>';

}

echo '</body></html>';
?>
