<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

/*
*Show the contacts that are connected to a company
*/
//echo($company_id);
$company_id = $zen->checkNum($company_id);
$agree_id = $zen->checkNum($agree_id);
if ($company_id > 0) {
  $company = $zen->get_contact($company_id,$zen->table_company,"company_id");
}

if (is_array($company)) {
  $name ="<A HREF='".$rootUrl."/contact.php?cid=".$zen->checkNum($company['company_id'])."'>".$zen->ffv(ucfirst($company["title"]))." ".$zen->ffv(ucfirst($company["office"]))."</A>";
}

?>
<table width='60%' class='formtable' cellpadding='2' cellspacing='1'>
  <tr>
   <td class="subTitle" colspan="4"><p align="center"><?=$zen->ffv($contractnr)?></p></td>
  </tr>
  <tr>
   <td class="headerCell" colspan="2" ><?=tr("Info")?></td>
   <td class="headerCell"  colspan="2" width="50%"><?=tr("Dates")?></td>
  </tr>
  <tr>
   <td class="bars small" width="20%"><?=tr("Title")?>:</td>
   <td class="bars small" width="30%"><?=$zen->ffv($title)?></td>
   <td class="bars small" width="20%"><?=tr("Start Date")?>:</td>
   <td class="bars small" width="30%"><?if($stime){echo $zen->showDate($stime);}?></td>
  </tr>
  <tr>
   <td class="bars small" width="20%"><?=tr("Company")?>:</td>
   <td class="bars small" width="30%"><?=$name?></td>
   <td class="bars small" width="20%"><?=tr("Expiration Date")?>:</td>
   <td class="bars small" width="30%"><?if($dtime){echo $zen->showDate($dtime);}?></td>
  </tr>
    <?php
 if(!empty($description)) {
?>
	  <tr>
	   <td class="headerCell" colspan="4"><?=tr("Description")?></td>
	  </tr>
	  <tr>
	   <td class="bars small" colspan="4"><?=$zen->ffvText($description)?></td>
	  </tr>
 <?php
}

  print "<tr><td class='subTitle' colspan='4'><table width='100%' cellpadding='0' cellspacing='0'><tr>";
  
  print "<td>";
  print "<form name='editAgreementForm' action='$rootUrl/actions/agreement_edit.php'>\n";
  renderDivButtonFind("Edit");
  print "<input type='hidden' name='id' value='$agree_id'>\n";
  print "</form>\n";
  print "</td>";
  
  if ($status=="1") {
    $active = "0";
    $value = "ARCHIVE";
  } else {
    $active = "1";
    $value = "ACTIVATE";
  }
  
  print "<td width='100%' align='center'>";
  print "<form name='archiveAgreementForm' action='$rootUrl/actions/agreement_archive.php'>\n";
  renderDivButtonFind('Archive');
  print "<input type='hidden' name='id' value='$agree_id'>\n";
  print "<input type='hidden' name='active' value='".$zen->ffv($active)."'>\n";
  print "</form>\n";
  print "</td>";
  
  print "<td>";
  print "<form name='deleteAgreementForm' action='$rootUrl/actions/agreement_delete.php'>\n";
  renderDivButtonFind("Delete");
  print "<input type='hidden' name='id' value='$agree_id'>\n";
  print "</form>\n";
  print "</td>";
  
  print "</tr></table></td></tr>";
?>
</table>
<?php
//show items
$parms = array(array("agree_id", "=", $agree_id));
$sort = "item_id asc";
$items = $zen->get_contacts($parms,$zen->table_agreement_item,$sort);

if (is_array($items) && count($items)) {
?>
<br>
<table width='60%' class='formtable' cellspacing='1' cellpadding='2'>
<tr>
	   <td class="subTitle" colspan="3"><?=tr("Items")?></td>
</tr>
<tr>
  <td class='headerCell'><?=tr("ID")?></td>
  <td class='headerCell'><?=tr("Name")?></td>
  <td class='headerCell'><?=tr("Description")?></td>
</tr>
    <?php
  foreach($items as $t) {
    ?>
    <tr class='bars'>
    <td><?=$t["item_id"]?></td>
    <td><?=$zen->ffv($t["name1"])?></td>
    <td><?=$zen->ffv($t["description1"])?></td>
    </tr>
  <?php
  }
}

?>
</table>