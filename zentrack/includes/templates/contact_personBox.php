<?
if( !ZT_DEFINED ) { die("Illegal Access"); }

/* 
*Show the contacts that are connected to a company
*/

$hotkeys->loadSection('contacts_view_employee');
$GLOBALS['zt_hotkeys'] = $hotkeys;
?>
<table width='620'><tr><td>

   <table class='formtable' width='500' cellpadding="0" cellspacing="1">
    <tr>
	   <td class="subTitle" colspan="4"><p align="center"><?= ucfirst($lname).", "; echo($fname)? ucfirst($fname):ucfirst($initials);?> </p></td>
	  </tr>
	  <tr>
	   <td class="headerCell" colspan="2" ><?=uptr("Info")?></td>
	   <td class="headerCell" colspan="2" width="50%"><?=tr("Phone")?></td>
	  </tr>
	  <tr>
	   <td class="bars small"><?=tr("Title")?>:</td> 
	   <td class="bars small"><?=$zen->fhv($jobtitle)?></td>
	   <td class="bars small"><?=tr("Telephone")?>:</td> 	   
	   <td class="bars small"><?=$zen->fhv($telephone)?></td>
	  </tr>
	  <tr>
	   <td class="bars small"><?=tr("Department")?>:</td> 
	   <td class="bars small"><?=$zen->fhv($t["department"])?></td>  
	   <td class="bars small"><?=tr("Mobile")?>:</td>  
	   <td class="bars small" width='30%'><?=$zen->fhv($mobiel)?></td>
	  </tr>
	  <tr>
	   <td class="bars small"><?=tr("E-mail")?>:</td> 
	   <td class="bars small" width="30%"><?if($email){?>
      <A HREF="mailto:<?=$zen->ffv($email)?>"><?=$zen->ffv($email)?></A>
      <? } else { print '&nbsp;'; } ?>
     </td> 
	   <td class="bars small" colspan='2'>&nbsp;</td> 
	  </tr>
<?
 if(!empty($description)) {
	 
?>	  
	  <tr>
	   <td class="headerCell" colspan="4"><?=tr("Notes")?></td>  
	  </tr>
	  <tr>
	   <td class="bars small" colspan="4"><?= $zen->ffvText($description) ?></td>
	  </tr>
<?
}
?>
</table>

</td><td align='left' valign='top'>
       
<table width="120" cellpadding="0" cellspacing="3" border="0">
<?
    //1=show ADD 0=don't show ADD
    $idi = $person_id ;
    
    print "<tr>\n<form name='edit_form' action='$rootUrl/actions/contact_edit.php'>\n";
    print "<td>\n";
    renderDivButtonFind("Edit");
    print "<input type='hidden' name='pid' value='$idi'>\n";	
    print "</td>\n</form>\n</tr>\n";

    print "<tr>\n<form name='delete_form' action='$rootUrl/actions/contact_delete.php'>\n";
    print "<td>\n";
    renderDivButtonFind("Delete");
    print "<input type='hidden' name='pid' value='$idi'>\n";		
    print "</td>\n</form>\n</tr>\n";
    
    print "<tr>\n<form name='view_form' action='$rootUrl/contact.php'>\n";
    print "<td>\n";
    renderDivButtonFind("View Tickets");
    print "<input type='hidden' name='pid' value='$idi'>\n";
    print "<input type='hidden' name='overview' value='tickets'>\n";	
    print "</td>\n</form>\n</tr>\n";
?>
</table>
</td></tr></table>
<br>
<?
if($company_id) {
  print "<table width='620' class='formtable'>";
  print "<tr><td class='subTitle' colspan='6'>Company</td></tr>";
  $t = $zen->get_contact($company_id,$zen->table_company,"company_id");
  if( is_array($t) ) {
    //extract($contacts);
    //$id = $company_id;
    //include("$templateDir/contact_titleBox.php");
    $cssStyle = 'headerCell';
    include("$templateDir/listContactsHeading.php");
    include("$templateDir/listContacts.php");
  }
  print "</table><br>";
}
?>
