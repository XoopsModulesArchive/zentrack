<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  // create a default date
  if( !$search_date )
    $search_date = 0;

  // create a list of possible actions
  $query = "SELECT DISTINCT action FROM ".$zen->table_logs." ORDER BY action";
  $actions = array();
  $actions = $zen->db_list($query);
?>
<form action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="TODO" value="SEARCH">
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->getSetting("color_background")?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
     <?=tr("Search For Logs")?>
  </td>
</tr>

<tr>
  <td colspan="2" class="subTitle">
    <?=tr("By Text Match")?>
  </td>
</tr>
<tr>
  <td class="bars">
     <?=tr("Containing")?>
  </td>
  <td class="bars">
   <input type="text" name="search_text" 
      value="<?=$zen->ffv($search_text)?>" size="25" maxlength="50">
  </td>
</tr>

<tr>
  <td colspan="2" class="subTitle">
    <?=tr("By Date")?>
  </td>
</tr>
<tr>
  <td class="bars">
     <?=tr("Maximum Age")?>
  </td>
  <td class="bars">
   <input type="text" name="search_date" 
      value="<?=strip_tags($search_date)?>" size="4" maxlength="4">
    &nbsp;<span class='small'>(in days, use zero to disable)</span>
  </td>
</tr>

<tr>
  <td colspan="2" class="subTitle">
    <?=tr("By Parameters")?>
  </td>
</tr>

<tr>
  <td class="bars">
    <?=tr("Action")?>
  </td>
  <td class="bars">
    <select name="search_params[action]">
       <option value="">----</option>
        <?php
    foreach( $actions as $a ) {
       print ($a == $search_params["action"])?
	 "<option selected value='$a'>".ucwords(strtolower($a))."</option>\n" :
         "<option value='$a'>".ucwords(strtolower($a))."</opton>\n";
    }  
?>
    </select>
  </td>
</tr>

<tr>
  <td class="bars">
     <?=tr("User")?>
  </td>
  <td class="bars">
     <select name="search_params[user_id]">
       <option value="">----</option>
         <?php
  $userBins = $zen->getUsersBins($login_id);
  if( is_array($userBins) && $zen->settingOn("allow_assign") ) {
    $users = $zen->get_users($userBins);
    if( is_array($users) ) {
      //asort($users);
      foreach($users as $k=>$v) {
        $check = ( $search_params["user_id"] && $v["user_id"] == $search_params["user_id"] )? 
        "selected" : "";
        print "<option $check value='$v[user_id]'>$v[lname], $v[fname]</option>\n";
      }
    }
  }
?>
     </select>
  </td>
</tr>

<tr>
  <td class="bars">
    <?=tr("Bin")?>
  </td>
  <td class="bars">
    <select name="search_params[bin_id]">
       <option value="">----</option>
        <?php
  if( is_array($userBins) ) {
    foreach($userBins as $v) {
      if( $v ) {
        $check = ( $v == $search_params["bin_id"] )? "selected" : "";
        $n = $zen->bins["$v"];
        print "<option $check value='$v'>$n</option>\n";
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
  <td colspan="2" class="subTitle">
    <?=tr("Click 'Search' to execute the search")?>
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
     <input type="submit" class="submit" value="<?=tr("Search")?>">
  </td>
</tr>

</table>
  
</form>
