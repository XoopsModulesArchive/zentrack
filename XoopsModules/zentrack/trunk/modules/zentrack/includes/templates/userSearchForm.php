<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?php echo $zen->getSetting("color_background"); ?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
    <?php echo tr("Search For Users"); ?>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    <?php echo tr("Show All Users"); ?>
  </td>
</tr>

<form action="<?php echo $SCRIPT_NAME?>">
<input type="hidden" name="TODO" value="ALL">
<input type="hidden" name="return_field" value="<?php echo $zen->ffv($return_field); ?>">

<tr>
  <td class="bars" colspan="2">
   <input type="submit" class="submit" value="<?php echo tr("List All Users"); ?>">
  </td>
</tr>

</form>
<form action="<?php echo $SCRIPT_NAME?>">
<input type="hidden" name="TODO" value="SEARCH">

<tr>
  <td colspan="2" class="subTitle">
    <?php echo tr("By Text"); ?>
  </td>
</tr>
<tr>
  <td class="bars">
     <?php echo ("Containing"); ?>
  </td>
  <td class="bars">
   <input type="text" name="search_text" 
      value="<?php echo $zen->ffv($search_text); ?>" size="25" maxlength="50">
  </td>
</tr>
<tr>
  <td class="bars">
     <?php echo ("In any of these"); ?>
  </td>
  <td class="bars">
  <?php
   $sfl = ((is_array($search_fields) && in_array("lname",$search_fields)) 
	     || 
           !is_array($search_fields));
   $sff = (is_array($search_fields) && in_array("fname",$search_fields));
   $sfn = (is_array($search_fields) && in_array("notes",$search_fields));
   $sfi = (is_array($search_fields) && in_array("initials",$search_fields));
  ?>
  <input type="checkbox" name="search_fields[lname]" value="lname"<?php echo ($sfl)?" checked":""?>>
   &nbsp;<?php echo tr("Last Name"); ?>
  <br>
  <input type="checkbox" name="search_fields[fname]" value="fname"<?php echo ($sff)?" checked":""?>>
   &nbsp;<?php echo tr("First Name"); ?>
  <br>
  <input type="checkbox" name="search_fields[initials]" value="initials"<?php echo ($sfi)?" checked":""?>>
   &nbsp;<?php echo tr("Initials"); ?>
  <br>
  <input type="checkbox" name="search_fields[notes]" value="notes"<?php echo ($sfn)?" checked":""?>>
   &nbsp;<?php echo ("Role"); ?>
  </td>
</tr>

<tr>
  <td colspan="2" class="subTitle">
    <?php echo tr("By Parameters"); ?>
  </td>
</tr>

<tr>
  <td class="bars">
    <?php echo tr("user ID"); ?>
  </td>
  <td class="bars">
    <input type="text" name="search_params[user_id]" value="<?php echo strip_tags($search_params["user_id"]); ?>" size="12" maxlength="12">
  </td>
</tr>
<tr>
  <td class="bars">
    <?php echo tr("Home Bin"); ?>
  </td>
  <td class="bars">
    <select name="search_params[homebin]">
       <option value="">----</option>
<?php
   $userBins = $zen->getUsersBins($login_id);
   if( is_array($userBins) ) {
     print "<option $check value='all'>-All-</option>\n";
     foreach($zen->getBins(1) as $v) {
       $k = $v["bid"];
       if(in_array($k, $userBins)) {
         $check = ( $k == $search_params["homebin"] )? "selected" : "";
         print "<option $check value='$k'>$v[name]</option>\n";
       }
     }
   } else {
     print "<option value=''>--no bins--</option>\n";
   }
?>
    </select>
  </td>
</tr>
<tr>
  <td class="bars">
    <?php echo tr("Status"); ?>
  </td>
  <td class="bars">
    <select name="search_params[active]">
       <option value="">----</option>
       <option value="1" <?php echo ($search_params["active"] == 1)?"selected":""?>><?php echo tr("Active"); ?></option>
       <option value="0" <?php echo 
	 (strlen($search_params["active"]) && $search_params["active"] == 0)?"selected":"";
	 ?>><?php echo tr("Disabled"); ?></option>
    </select>
  </td>
</tr>
<tr>
  <td class="bars">
    <?php echo tr("Default Access Level"); ?>
  </td>
  <td class="bars">
    <select name="search_access_method">
      <option value="gt"<?php echo ($search_access_method=="gt")?" selected":""?>"><?php echo tr("Greater Than"); ?></option>
      <option value="lt"<?php echo ($search_access_method=="lt")?" selected":""?>"><?php echo tr("Less Than"); ?></option>
      <option value="eq"<?php echo ($search_access_method=="eq")?" selected":""?>"><?php echo tr("Equals"); ?></option>
    </select>&nbsp;
    <input type="text" name="search_params[access_level]" 
	value="<?php echo strip_tags($search_params["access_level"]); ?>"
	size="2" maxlength="2">&nbsp;<span class="small">(<?php echo tr("enter a number"); ?>)</span>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    <?php echo tr("Click 'Search' to execute the search"); ?>
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
     <input type="submit" class="submit" value="<?php echo tr("Search"); ?>">
  </td>
</tr>

</table>
  
</form>

