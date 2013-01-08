<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  // fetch a list of bins for new bins
  $userBins = $zen->getBins();

  // determine what bins we are working with
  // and create a list of bins and their
  // access levels
  $bins = array();
  if( $TODO == 'MORE' || $TODO == 'LESS' ) {
    $n = ($more < 4)? 2 : 4;
    $more += ($TODO == 'MORE')? $n : -$n;
    if( is_array($binLevels) ) {
      ksort($binLevels);
      foreach($binLevels as $k=>$v) {
	if( $k && (strlen($v) || $binRoles["$k"]) ) {
	  // drop this from the pulldown for new bins
	  unset($userBins["$k"]);
	  // add this to the current list
	  $bins["$k"] = array($v,$binRoles["$k"]);
	}
      }
    }
    for( $i=0; $i<count($newFields); $i++ ) {
      if( strlen($newFields[$i]) ) {
	$k = $newFields[$i];
	if( $k && (strlen($newVals[$i]) || $newRoles[$i]) )
	  $bins["$k"] = array($newVals[$i],$newRoles[$i]);
      }
    }
  } else {
    $vals = $zen->get_access($user_id);
    if( is_array($vals) ) {
      foreach($vals as $k=>$v) {
	$bins["$k"] = array($v,"");
      }
    }

    $roles = $zen->fetch_user_roles($user_id);
    for($i=0; $i<count($roles); $i++) {
      $r = $roles[$i];
      $n = $r["bin_id"];	
      if( is_array($bins["$n"]) ) {
	$bins["$n"][1] = $r["notes"];
      } else {
	$bins["$n"] = array("",$r["notes"]);
      }
    }
  }

  if( $TODO == 'RESET' || !isset($more) )
     $more = 0;

  // set up the more links
  if( $more >= 12 )
    $more = 12;
  if( $more < 0 )
    $more = 0;

  // option tags for the access levels
  function opt_lvls( $selected = '' ) {
    print "<option value=''>---</option>\n";
    for( $i=0; $i<11; $i++ ) {
      $sel = (strlen($selected) && $i==$selected)? 
	" selected" : "";
      print "<option$sel>$i</option>\n";
    }
  }
  function opt_roles( $selected = '' ) {
    print "<option value=''>--".tr("none")."--</option>\n";
    // fetch the roles which can be picked from
    if( isset($GLOBALS) ) { $zen = $GLOBALS["zen"]; }
    else { global $zen; }
    $roles = $zen->getRoles();    
    // loop through the roles and print option tags
    foreach($roles as $r) {
      $sel = (strlen($selected) && $r["role_id"]==$selected)?
	" selected" : "";
      print "<option value='{$r['role_id']}'$sel>{$r['name']}</option>\n";
    }
  }

?>
<script language='javascript'>
  function setTodo( val ) {
    document.accessForm.TODO.value = val;
    return true;
  }
</script>

<form method="post" action="<?=$SCRIPT_NAME?>" name="accessForm">
<input type="hidden" name="more" value="<?= strip_tags($more) ?>">
<input type="hidden" name="user_id" value="<?= strip_tags($user_id) ?>">
<input type="hidden" name="TODO" value="">
<blockquote>
<table width="300" cellpadding="5">
<tr>
  <td colspan="3" class="titleCell" align="center" height="20">
    <b><?=tr("Set Access for ?",array($zen->formatName($user_id)))?></b>
  </td>
</tr>
<tr>
  <td class='subTitle'><?=tr("Bin Name")?></td>
  <td class='subTitle'><?=tr("Level")?></td>
  <td class='subTitle'><?=tr("Role")?></td>
</tr>

    <?php
  if( is_array($bins) && count($bins) ) {
    foreach($bins as $k=>$v) {
      print "<tr><td><b>".$zen->bins["$k"]."</b></td>";
      print "<td><select name='binLevels[$k]'>\n";
      opt_lvls($v[0]);
      print "</select></td>\n";
      print "<td><select name=\"binRoles[$k]\">\n";
      opt_roles($bins["$k"][1]);
      print "</select></td>\n";
      print "</tr>\n";
    }
  }
  for( $i=0; $i<$more; $i++ ) {
    print "<tr><td><select name='newFields[]'>\n";
    print "<option value=''>-------</option>\n";
    foreach($userBins as $k=>$v) {
      print "<option value='$k'>$v</option>\n";
    }
    print "</select></td>\n";
    print "<td><select name='newVals[]'>\n";
    opt_lvls();
    print "</select></td>\n";
    print "<td><select name='newRoles[]'>\n";
    opt_roles();
    print "</select></td>\n";
    print "</tr>\n";
  }
  if( ( !is_array($bins)||!count($bins) ) && !$more ) {
    print "<tr><td colspan='3'>"
      .tr("There are no custom defined bins for this user.")." "
      .tr("Choose 'more' to add some.")."</td></tr>\n";
  }
?>
<tr>
  <td class="titleCell" colspan="3">
<?php if( is_array($userBins) && count($userBins) ) { ?>
   <?=tr("Press MORE to add more custom fields")?>
    <br>
<?php } ?>
    <?=tr("Press LESS to remove blank fields")?>
    <br>
    <?=tr("Press Update to save changes")?>
    <br>
    <?=tr("Press Reset to return to users existing values")?>
  </td>
</tr>
<tr>
  <td class="bars" colspan="3">
    <input type="submit" value="<?=uptr("More")?>" onClick="return setTodo('MORE')">
   &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="<?=uptr("less")?>" onClick="return setTodo('LESS')">
   &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="<?=tr("Update")?>" class="submit" onClick="return setTodo('Update')">
    &nbsp;&nbsp;&nbsp;&nbsp;
   <input type="submit" value="<?=tr("Reset")?>" class="submit" onClick="return setTodo('RESET')">
  </td>
</tr>
</table>
</blockquote>

</form>
