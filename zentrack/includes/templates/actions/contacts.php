<?php if( !ZT_DEFINED ) { die("Illegal Access"); }
  /**
   * creates a form for adding entries to the contact list
   */

  // collect contact data
	$companies = $zen->get_contact_all();	
	if (empty($company_id)) {
		$parms = array(array("company_id", "=", "0"));
	} else {
		$parms = array(array("company_id", "=", $company_id));
	}
	$sort = "lname asc";
	$people = $zen->get_contacts($parms,$zen->table_employee,$sort);

  $company_title = $company_id;
  // determine column span
  $colspan = 1;
  if( $companies || $people ) {
    $colspan = 2;
  } 
?>


<script type="text/javascript">
function printpopup(varialbe)
{
location.href ="<?=$_SERVER['SCRIPT_NAME']?>?id=<?=$id?>&company_id="+varialbe+"&setmode=<?=$zen->ffv($setmode)?>";
}
</script>

<form method='post' action='<?=$zen->ffv($SCRIPT_NAME)?>' name='ContactsAddForm'>
<input type='hidden' name='id' value='<?=$id?>'>
<input type='hidden' name='actionComplete' value='1'>
<input type='hidden' name='setmode' value='<?=$zen->ffv($page_mode)?>'>

<table cellpadding="4" width='300' cellspacing="1" border="0">
<tr>
 <td class='subTitle' colspan='<?=$colspan?>'><?=tr("Add a Contact")?></td>
</tr>
 
    <?php
	if (is_array($companies)||count($companies)) {
	?>
<tr>
   <td class='bars'><?=$hotkeys->ll("Field: company_id","Company")?></td>
    <td class='bars'>

		<select name="company_id" 
      title="<?=$hotkeys->tt("Field: company_id")?>"
      onChange="printpopup(document.forms['ContactsAddForm'].company_id.value)">
  	<option value=''>--<?=tr("none")?>--</option>
            <?php
		foreach($companies as $p) {
      if( $p['company_id'] == $company_id ) {
        $sel = " selected";
        $company_title = $p['title'];
      }
      else {
        $sel = ""; 
      }
			$val =($p['office'])? strtoupper($p['title'])." ,".$p['office'] : strtoupper($p['title']);
	  	print "<option value='$p[company_id]' $sel>$val</option>\n";
		}
	?>
	</select>
  
    </td>
</tr>
    <?php
	}
	
	if (is_array($people)||count($people)) {
  ?>
  <tr>
    <td class='bars'><?= $hotkeys->ll("Field: person_id","Person") ?></td>
    <td class='bars'>
		<select name="person_id" title="<?=$hotkeys->tt("Field: person_id")?>">
  	<option value=''>--<?=tr("none")?>--</option>
            <?php
		foreach($people as $p) {
			$val =($p['fname'])?ucfirst($p[lname])." ,".ucfirst($p[fname]):ucfirst($p[lname]);
	  	print "<option value='$p[person_id]' >".$val."</option>\n";
		}
	?>
	  </select>
        <?php
    if( $company_id ) { print '<br>'.tr("(Employees of '?' only)", $company_title); } 
  ?>
    </td>
  </tr>
    <?php
	}
  else if( $company_id ) {
  ?>
  <tr>
    <td class='bars'><?=tr('Person')?></td>
    <td class='bars'>
      <?=tr('There are no employees assigned to this company.')?>  
      <br><a href='<?=$rootUrl?>/actions/contact_employee.php?cid=<?=$company_id?>'>
        <?=tr('Click Here')?></a> 
      <?=tr('to add one')?>.
    </td>
  </tr>
  <?php
  }
  
  if( !$people && !$companies ) {
    print "<tr><td>". tr("There are no contacts to add.") ."</td></tr>";
  }
  else {
	?>
<tr>
  <td class="subTitle" colspan='<?=$colspan?>'>
    <?php renderDivButton($hotkeys->find('Add Contact'), "window.document.forms['ContactsAddForm'].submit()"); ?>
  </td>
</tr>
<?php } ?>
<tr>
</table>
</form>

<p>&nbsp;
<form action='<?=$rootUrl?>/newContact.php' target="_BLANK" name='newContactForm'>
  <?php renderDivButton($hotkeys->find('Create New Contact'), "window.document.forms['newContactForm'].submit()", 150); ?>
</form>
