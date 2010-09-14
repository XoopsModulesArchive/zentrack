<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  // generate some text to display based on whether this
  // is an edit page or an add page
  $td = ($TODO == 'EDIT');
  $blurb = ($td)? "Edit User Account" : "Create New User Account";
  $button = ($td)? "Save Changes" : "Create Account";
  $url = ($td)? "edit" : "add";
?>
<script>
function updateFlds() {
   user_array = new Array();
<?php
           foreach($zen->getXoopsUsers(1) as $v) {
           $k = $v["uid"];
           print "user_array['$k'] = [\"$v[uname]\", \"$v[email]\"];\n";
         }
?>
   w = document.useraddform.xuid.selectedIndex;
   idx = document.useraddform.xuid.options[w].value;
   if (w > 0) {
	   document.useraddform.email.value = user_array[idx][1];
	   document.useraddform.login.value = user_array[idx][0];
	   tmpName = user_array[idx][0];
	   tmpNameArray = tmpName.split(" ");
	   if (tmpNameArray.length > 0){
	   	if (tmpNameArray.length == 1){
	   		document.useraddform.lname.value = tmpNameArray[0];
	   		document.useraddform.fname.value = "";
	   	}
	   		else {
			   		document.useraddform.fname.value = tmpNameArray[0];
			   		document.useraddform.lname.value = tmpNameArray[1];
	   		}
	   }
   }
	else{
		document.useraddform.email.value = "";
   		document.useraddform.fname.value = "";
   		document.useraddform.lname.value = "";
		document.useraddform.login.value = "";
		
	}
	
}
</script>

<form name="useraddform" method="post" action="<?php echo $rootUrl?>/admin/<?php echo $url?>UserSubmit.php">
<?php if( $td ) { print "<input type='hidden' name='user_id' value='".strip_tags($user_id)."'>\n"; } ?>
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?php echo $zen->getSetting("color_background"); ?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
  <?php echo $blurb?>
  </td>
</tr>
<?php
if ($TODO <> 'EDIT') {
?>

<tr>
  <td colspan="2" class="subTitle">
    <?php echo tr("Select XOOPS User"); ?> 
  </td>
</tr>  
<tr>
  <td class="bars">
    <?php echo tr("Xoops User"); ?>
  </td>
  <td class="bars">
    <select name="xuid" onchange="updateFlds()">
      <?php
         print "<option $check value='0'>-Select-</option>\n";
         foreach($zen->getXoopsUsers(1) as $v) {
           $k = $v["uid"];
           print ($k == $xuid)? 
             "<option selected value='$k'>$v[uname]</option>\n" : "<option value='$k'>$v[uname]</option>\n";
         }
      ?>
    </select>
  </td>
</tr>
<?php
}
?>


<tr>
  <td colspan="2" class="subTitle">
    <?php echo tr("User Information"); ?> (<?php echo tr("* = required"); ?>)
  </td>
</tr>  
<tr>
  <td class="bars">
    <?php echo tr("Last Name"); ?>*
  </td>
  <td class="bars">
    <input type="text" name="lname" value="<?php echo strip_tags($lname); ?>" size="40" maxlength="50">
  </td>
</tr>
<tr>
  <td class="bars">
    <?php echo tr("First Name"); ?>
  </td>
  <td class="bars">
    <input type="text" name="fname" value="<?php echo strip_tags($fname); ?>" size="40" maxlength="50">
  </td>
</tr>
<tr>
  <td class="bars">
    <?php echo tr("Initials"); ?>*
  </td>
  <td class="bars">
    <input type="text" name="initials" value="<?php echo strip_tags($initials); ?>" size=5 maxlength="5">
    <br><span class="small">(Letter and numbers only)</span>
  </td>
</tr>
<tr>
  <td class="bars">
    <?php echo tr("Email"); ?>*
  </td>
  <td class="bars">
    <input type="text" name="email" value="<?php echo strip_tags($email); ?>" size="40" maxlength="100">
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    <?php echo tr("Account Settings"); ?>
  </td>
</tr>

<!-- <input type="hidden" name="login" value="<?php echo strip_tags($login); ?>"> -->

<tr>
  <td class="bars">
    <?php echo tr("Login Name"); ?>*
  </td>
  <td class="bars">
    <input type="text"  name="login" value="<?php echo strip_tags($login); ?>" size="20" maxlength="25"> <br><span class="small">
      (<?php echo tr("This should be the same as the Xoops login name."); ?>  <?php echo tr("It will automatically default to the 'uname' value of the selected Xoops User."); ?>)
      </span>
  </td>
</tr>

<tr>
  <td class="bars">
    <?php echo tr("Default Access Level"); ?>
  </td>
  <td class="bars">
    <input type="text" name="access_level" value="<?php echo ($access_level)? strip_tags($access_level) : 0?>" 
           size="3" maxlength="2">
    <br><span class="small">
      (<?php echo tr("This grants the user the specified level of access to all bins not otherwise indicated by 'user access'."); ?>  <?php echo tr("Use zero if unsure."); ?>)
      </span>
  </td>
</tr>
<tr>
  <td class="bars">
    <?php echo tr("Notes"); ?>
  </td>
  <td class="bars">
    <input type="text" name="notes" value="<?php echo strip_tags($notes); ?>" size="50" maxlength="255">
  </td>
</tr>
<tr>
  <td class="bars">
    <?php echo tr("Home Bin"); ?>
  </td>
  <td class="bars">
    <select name="homebin">
      <?php
       if( is_array($zen->bins) ) {
         print "<option $check value='all'>-All-</option>\n";
         foreach($zen->getBins(1) as $v) {
           $k = $v["bid"];
           print ($k == $homebin)? 
             "<option selected value='$k'>$v[name]</option>\n" : "<option value='$k'>$v[name]</option>\n";
         }
       }
      ?>
    </select>
  </td>
</tr>
<tr>
  <td class="bars">
    <?php echo tr("Active"); ?>
  </td>
  <td class="bars">
    <input type="checkbox" name="active" value="1" 
	<?php echo (!strlen($active) || $active)? "checked" : ""?>>
    <br><span class="small">(<?php echo tr("Uncheck to disable this account."); ?>)</span>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    <?php echo tr("Click ? to ?",array($button,$blurb)); ?>.
  </td>
</tr>  
<tr>
  <td colspan="2" class="bars">
   <input type="submit" value="<?php echo $button?>" class="submit">
  </td>
</tr>
</table>

</form>
