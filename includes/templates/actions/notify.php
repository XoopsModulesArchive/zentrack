<?php {if( !ZT_DEFINED ) { die("Illegal Access"); }

  /**
   * creates a form for adding entries to the
   * ticket notify list
   */
}?>
<script type="text/javascript">
function printpopup(variable)
{
  location.href ="<?=$zen->ffv($SCRIPT_NAME)."?id=".$id ?>&company_id="+variable+"&setmode=<?=$zen->ffv($page_mode)?>";
}
</script>

<form method='post' action='<?=$zen->ffv($SCRIPT_NAME)?>' name='notifyAddForm'>
<input type='hidden' name='id' value='<?=$zen->ffv($id)?>'>
<input type='hidden' name='actionComplete' value='1'>
<input type='hidden' name='setmode' value='<?=$zen->ffv($page_mode)?>'>

<table width="600" class='formtable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle' colspan='2'>
   <?=tr("Add Notify Recipients")?>
 </td>
</tr>
<tr>
  <td class="bars bold">
     <?=$hotkeys->ll("Enter Registered Users")?>
  </td>
</tr>
<tr>
  <td class='bars'>
      <?php
  // make a user textarea and search button
  print "<textarea cols='40' rows='1' name='user_accts'>\n";
  print (isset($user_accts))? $zen->ffv($user_accts) : "";
  print "</textarea>\n";
  $onclick = "onClick='return popupWindowScrolls"
    ."(\"$rootUrl/helpers/userSearchbox.php?return_form=notifyAddForm"
    ."&return_field=user_accts\",\"popupHelper\",375,400)'";
  print "&nbsp;<input type='button' class='searchbox' "
    ." value=' ... ' $onclick>\n";
  print "<br><span class='note'>"
	.tr("Type ids separated by commas, or click on the button.")
	."</span>\n";
?>
  </td>
</tr>
<tr>
  <td class="bars bold">
     <?=$hotkeys->ll("Add an Unregistered User")?>
  </td>
</tr>
<tr>
  <td class='bars'>
    <table>
    <tr>
      <td class='bars'>
        <?=tr("Name")?>
      </td>
      <td class='bars'>
        <input type='text' name='unreg_name' size='20' maxlength='255' 
               value='<?=$zen->ffv($unreg_name)?>'>
      </td>
      <td class='bars'>
        <?=tr("Email")?>
      </td>
      <td class='bars'>
        <input type='text' name='unreg_email' size='20' maxlength='255' 
               value='<?=$zen->ffv($unreg_email)?>'>
      </td>
    </tr>
    </table>
  </td>
</tr>
  <?php if( $zen->settingOn('allow_contacts') ) { ?>
<tr>
  <td class="bars bold">
     <?=$hotkeys->ll("Add a Contact")?>
  </td>
</tr>
<tr>
<td class='bars'>
<br>
    <?php
  print tr("Company:");
  $company = $zen->get_contact_all();
  if (is_array($company)||count($company)) {
?>

  <select name="company_id" onChange="printpopup(document.forms['notifyAddForm'].company_id.value)">
    <option value=''>--<?=tr("none")?>--</option>
      <?php
   foreach($company as $p) {
      $sel = ($p["company_id"] == $company_id)? " selected" : "";
      $val =($p['office'])? strtoupper($p['title']) . " ," 
            . $p['office'] : strtoupper($p['title']);
      print "<option value='$p[company_id]' $sel>".$zen->ffv($val)."</option>\n";
    }
?>
  </select>
  <?php
  }
  if (empty($company_id)) {
    $parms = array(array("company_id", "=", "0"));
  } else {
    $parms = array(array("company_id", "=", $company_id));
  }
	
  $sort = "lname asc";
  $company = $zen->get_contacts($parms,$zen->table_employee,$sort);
	
  if (is_array($company)||count($company)) {
    echo "&nbsp;". tr("Or Person:");
?>
    <select name="person_id">
      <option value=''>--<?=tr("none")?>--</option>
        <?php
	  foreach($company as $p) {
            $val =($p['fname'])?ucfirst($p[lname])." ,".ucfirst($p[fname]):ucfirst($p[lname]);
	    print "<option value='$p[person_id]' >".$zen->ffv($val)."</option>\n";
          }
	?>
    </select>
    <br><br>
  <?php
  } //if( is_array($company).. )
  } //if( $zen->getSetting('allow_contacts')... )
?>
	
</td>
</tr>
<tr>
  <td class="subTitle">
  <?php renderDivButtonFind('Add Recipients'); ?>
  </td>
</tr>
<tr>
</table>



</form>
