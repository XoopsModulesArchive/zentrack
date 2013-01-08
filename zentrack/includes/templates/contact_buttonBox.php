<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<table cellpadding="0" cellspacing="0" border="0">
<tr>
    <?php
  $hotkeys->loadSection('contacts_list');
  $GLOBALS['zt_hotkeys'] = $hotkeys;
      
      $actions = array(
			"company",			
			"external",		     
			"internal"
			//"all"
			);	

			$st=($setmode =="all")?"abc":$zen->ffv($setmode);
			
	foreach($actions as $a) {
		
			$value = uptr($a);
			$ien = ($a == "intern")? 2         : 1;
			$st  = ($a == "all"   )? "all"     : $st;
			$ov  = ($a == "all"   )? $overview : $a;
				
			print "\n<form name='".$a."_form' action='$rootUrl/contacts.php'>\n";
			print "<td width='120' align='center'>\n";
			renderDivButtonFind(ucfirst($a));
			print "<input type='hidden' name='ie' value='$ien'>\n";
			print "<input type='hidden' name='setmode' value='$st'>\n";
			print "<input type='hidden' name='overview' value='$ov'>\n";
			print "</td>\n</form>\n\n";
  }
?>
</tr>
</table>
