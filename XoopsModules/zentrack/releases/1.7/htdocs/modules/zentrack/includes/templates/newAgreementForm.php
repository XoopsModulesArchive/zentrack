<?php if( !ZT_DEFINED ) { die("Illegal Access"); } 
  $hotkeys->loadSection('agreement_form');
  $GLOBALS['zt_hotkeys'] = $hotkeys;
?>
<script language='javascript' type='text/javascript'>
  function checkMyBox(fieldName, event) {
    if( !event ) { event = window.event; }
    if( document.getElementById ) {
      var elem = document.getElementById(fieldName);
      if( elem ) {
        if( !event || !event.target || event.target.type != 'checkbox' ) {
          elem.checked = elem.checked? false : true;
        }
      }
      if( elem.parentNode ) {
        elem.parentNode.parentNode.oldStyle = elem.checked? 'invalidBars' : 'bars';
      }
    }
  }
</script>

<form method="post" name="agreementForm" action="<?php echo ($skip)? "editAgreementSubmit.php" : "$rootUrl/addAgreementSubmit.php"?>">
<input type="hidden" name="id" value="<?php echo $zen->ffv($id); ?>">
<input type='hidden' name='TODO' value='submit_form'>
<?php
if(isset($creator_id)) { ?>
<input type="hidden" name="creator_id" value="<?php echo $zen->ffv($creator_id); ?>">
<?php
}
if(isset($create_time)) { ?>
<input type="hidden" name="create_time" value="<?php echo $zen->ffv($create_time); ?>">
<?php
}
?>

<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?php echo $zen->getSetting("color_background"); ?>" border="0">
<tr>
  <td colspan="2" width="640" class="subTitle" align="center">
     <?php echo tr("Agreement Information"); ?>
  </td>
</tr>

<tr>
  <td class="bars" >
    <?php echo $hotkeys->ll("Agreement ID"); ?>:
  </td>
  <td class="bars">
    <input title='<?php echo $hotkeys->tt("Agreement ID"); ?>' type="text" 
      name="contractnr" size="20" maxlength="25"
      value="<?php echo $zen->ffv($contractnr); ?>">
  </td>
</tr>
<?php
$company = $zen->get_contact_all();
	if (is_array($company)) {
	?>
		<tr>
  	<td class="bars" >
    <?php echo tr("Company"); ?>:
  	</td>
  	<td class="bars">
		<select name="company_id">
  	<option value=''>--<?php echo tr("none"); ?>--</option>
		<?php
		foreach($company as $p) {
			$sel = ($p["company_id"] == $company_id)? " selected" : "";
			$val =($p['office'])?strtoupper($p[title])." ,".$p[office]:strtoupper($p[title]);
	  	print "<option value='$p[company_id]' $sel>".$val."</option>\n";
		}
	?>
	</select>
	</td>
	</tr>
	<?php
	}
 ?>
<tr>
  <td class="bars" >
    <?php echo tr("Title"); ?>:
  </td>
  <td class="bars">
    <input type="text" name="title" size="30" maxlength="50"
value="<?php echo $zen->ffv($title); ?>">
  </td>
</tr>

<tr>
  <td class="bars" >
    <?php echo tr("Start Date"); ?>:
  </td>
  <td class="bars">
    <input type="text" name="stime" size="12" maxlength="10"
value="<?php echo ($stime)?$zen->showDate($zen->ffv($stime)):""?>">
    <img name="date_button" src='<?php echo $rootUrl?>/images/cal.gif'
  onClick="popUpCalendar(this,document.agreementForm.stime, '<?php echo $zen->popupDateFormat(); ?>')"
  alt="Select a Date">
    &nbsp;(<?php echo tr("optional"); ?>)
  </td>
</tr>

<tr>
  <td class="bars" >
    <?php echo tr("Expiration Date"); ?>:
  </td>
  <td class="bars">
    <input type="text" name="dtime" size="12" maxlength="10"
value="<?php echo ($dtime)?$zen->showDate($dtime):""?>">
    <img name="date_button" src='<?php echo $rootUrl?>/images/cal.gif'
      onClick="popUpCalendar(this,document.agreementForm.dtime, '<?php echo $zen->popupDateFormat(); ?>')"
      alt="Select a Date">
    &nbsp;(<?php echo tr("optional"); ?>)
  </td>
</tr>
<tr>
  <td colspan="2" class="bars">
    <?php echo $hotkeys->ll("Description"); ?>:
  </td>
</tr>

<tr>
  <td colspan="2" class="bars">
    <textarea cols="60" rows="5" name="description" title="<?php echo $hotkeys->tt("Description"); ?>"><?php echo 
	    $zen->ffv($description)
    ?></textarea>
  </td>
</tr>
<tr>
  <td colspan="2" valign='middle' class="headerCell padded" style='text-align:left'>
   <?php renderDivButtonFind("Create", null, ($skip? "Save":null) ); ?>
  </td>
</tr>
<tr><td class='bars' colspan='2'>&nbsp;</td></tr>
<tr>
  <td colspan="2" class="subTitle">
    <?php echo tr("Items"); ?>
  </td>
</tr>
<tr>
  <td colspan="2" class="bars">
  <table cellspacing='1' class='formtable'>
  <?php
  if (!$id){
	  $parms = array(array("agree_id", "=", "0"));
  } else {
	  $parms = array(array("agree_id", "=", $id));
  }

	$sort = "item_id asc";
	$contacts = $zen->get_contacts($parms,$zen->table_agreement_item,$sort);

  if (is_array($contacts)) {
	 //print_r($contacts);

	 foreach($contacts as $t) {
      ?>
   <tr class='bars' <?php echo $row_rollover_eff?>
     onclick='checkMyBox("drops_<?php echo $t['item_id']?>", event)'>
   <td  width="20"><?php echo $t["item_id"]?></td>
   <td width="200">
    <?php echo $zen->ffv($t["name1"]); ?>
   </td>
   <td width="400">
   <?php echo $zen->ffv($t["description1"], 200); ?>
   </td>
   <td><input id='drops_<?php echo $t['item_id']?>'
          type='checkbox' name='drops[]'
          value='<?php echo $zen->ffv($t['item_id']); ?>'></td>
   </tr>
   <?php
   } ?>
   <tr>
	<td class='headerCell' style='text-align:right' colspan='4'>
         <input type="submit"
	  value=" <?php echo tr("Drop Items"); ?> "
          class="actionButton"
          onClick='return rerouteAgreementForm("removeItems")'
         >
	</td>
	</tr>
	<?php
  } else {
	 echo "No items are set" ;
  }

  ?>

   </table>
  </td>
</tr>

<tr>
  <td colspan="2" class="subTitle">
    <?php echo tr("Add Item"); ?>
  </td>
</tr>
<tr>
<td class="bars" colspan="2" valign='top'>
	<?php echo tr("Name"); ?>:
    <input type="text" name="name1" size="30" maxlength="40" value="<?php echo $zen->ffv($name1); ?>">

	<?php echo tr("Description"); ?>:
    <textarea cols="22" rows="2" name="description1"><?php echo $zen->ffv($description1); ?></textarea>

	</td>
</tr>
<tr>
<td class='subTitle' colspan='2'>
<?php renderDivButtonFind('Add Item'); ?>
</td>
</tr>
</form>

</table>

<script language='javascript'>
  function rerouteAgreementForm( action ) {
    window.document.forms['agreementForm'].action = '<?php echo $zen->ffv($SCRIPT_NAME); ?>';
    window.document.forms['agreementForm'].elements['TODO'].value = action;
    window.document.forms['agreementForm'].submit();
  }
</script>
