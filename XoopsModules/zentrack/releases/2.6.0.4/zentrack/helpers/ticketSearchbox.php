<?
  include("../header.php");
  $table_width = '350';
  if( $set_bins ) {
    $search_param["bin_id"] = $set_bins;
  }
  if( $set_types ) {
    $search_param["type_id"] = $set_types;
  }
  if( $set_priorities ) {
    $search_param["priority"] = $set_priorities;
  }
  if( $set_systems ) {
    $search_param["system_id"] = $set_systems;
  }
  $userBins = $zen->getUsersBins($login_id,"level_view");
  $users = $zen->get_users( $userBins, "level_view" );
  $onechoice = isset($_GET['onechoice']) || isset($_POST['oncchoice']);
  $return_form = $zen->ffv($return_form);
  $return_field = $zen->ffv($return_field);
?><html>
<head>
  <title><?php echo tr("Search Tickets"); ?></title>
  <LINK HREF="<?=$rootUrl?>/styles.php" REL="STYLESHEET" TYPE="text/css">
  <script language="javascript" src="<?=$rootUrl?>/javascript.js"></script>
</head>
<body>

<? if( !isset($dosearch) || !is_array($search_param) ) { ?>
<form method='post' action='<?=$rootUrl?>/helpers/ticketSearchbox.php'>
<input type='hidden' name='return_form' value='<?=$zen->ffv($return_form)?>'>
<input type='hidden' name='return_field' value='<?=$zen->ffv($return_field)?>'>
<? if( $onechoice ) { ?>
  <input type='hidden' name='onechoice' value='1'>
<? } ?>
<table width='<?=$table_width?>' align='center'>
<tr><td class='titleCell' align='center' colspan='2'><?php echo tr("Search Tickets"); ?></td></tr>
<tr>
  <td class='bars'><?php echo tr("Ticket ID"); ?></td>
  <td class='bars'><input type='text' name='search_param[ticket_id]' size='12' 
	maxlength='10' value='<?=$zen->ffv($search_param["ticket_id"])?>'></td>
</tr>
<tr>
  <td class='bars'><?php echo tr("Title"); ?></td>
  <td class='bars'><input type='text' name='search_param[title]' 
	size='22' maxlength='20' value='<?=$zen->ffv($search_param["title"])?>'><td>
</tr>
<tr>
  <td class='bars'><?php echo tr("Description"); ?></td>
  <td class='bars'><input type='text' name='search_param[description]' 
	size='22' maxlength='20' value='<?=$zen->ffv($search_param["description"])?>'></td>
</tr>
<tr>
  <td class='bars'><?php echo tr("Type"); ?></td>
  <td class='bars'>
    <select name="set_types[]" size='5' multiple>
<?
 if( is_array($zen->getTypes()) ) {
   foreach($zen->getTypes(1) as $v) {
     $k = $v["type_id"];
     if( $k != $zen->projectTypeID() ) {
       $check = ( is_array($set_types)&&in_array($k,$set_types) )? 
	 "selected" : "";
       print "<option $check value='$k'>$v[name]</option>\n";
     }
   }
 } else {
   print "<option value=''>--" . tr("no types") . "--</option>\n";
 }
?>
    </select>
    <div class='note'><?php echo tr("Select more than one by using control or shift"); ?></div>
  </td>
</tr>
<tr>
  <td class='bars'><?php echo tr("System"); ?></td>
  <td class='bars'>
    <select name="set_systems[]" size='5' multiple>
<?
  if( is_array($zen->getSystems()) ) {
    foreach($zen->getSystems() as $k=>$v) {
      $check = (is_array($set_systems)&&in_array($k,$set_systems))? 
         "selected" : "";
      print "<option $check value='$k'>$v</option>\n";
    }
  } else {
    print "<option value=''>--" . tr("no systems") . "--</option>\n";
  }
?>
    </select>
    <div class='note'><?php echo tr("Select more than one by using control or shift"); ?></div>
  </td>
</tr>
<tr>
  <td class='bars'><?php echo tr("Bin"); ?></td>
  <td class='bars'>
    <select name="set_bins[]" size='5' multiple>
<?
   if( is_array($userBins) ) {
     foreach($userBins as $v) {
       if( $v ) {
         $check = (is_array($set_bins)&&in_array($v,$set_bins) )? 
	   "selected" : "";
         $n = $zen->bins["$v"];
         print "<option $check value='$v'>$n</option>\n";
       }
     }
   } else {
     print "<option value=''>--" . tr("no bins") . "--</option>\n";
   }
?>
    </select>
    <div class='note'><?php echo tr("Select more than one by using control or shift"); ?></div>
  </td>
</tr>
<tr>
  <td class='bars'><?php echo tr("Priority"); ?></td>
  <td class='bars'>
    <select name="set_priorities[]" size='5' multiple>
<?
    if( is_array($zen->getPriorities()) ) {
      foreach($zen->getPriorities(1) as $v) {
	$k = $v["pid"];
	$v = $v["name"];
	$check = (is_array($set_priorities)&&in_array($k,$set_priorities))? 
	  "selected" : "";
	print "<option $check value='$k'>$v</option>\n";
      }
    } else {
      print "<option value=''>--" . tr("no priorities") . "--</option>\n";
    }
?>
    </select>
    <div class='note'><?php echo tr("Select more than one by using control or shift"); ?></div>
  </td>
</tr>
<tr>
  <td class='bars' colspan='2'>
    <div align='center'><input type='submit' class='submit' name='dosearch'
	 value='<?php echo tr("Search"); ?>'></div>
    <span class='note'><?php echo tr("You may use * for a wildcard in the title or description.. i.e. J* would match anything starting with J"); ?></span>
  </td>
</table>

<? 
  } else { 
    
  $params = array();
  foreach($search_param as $k=>$v) {
    if( (is_array($v) && !count($v)) || (!is_array($v)&&!strlen($v)) )
	continue; 
    $tf = (!($k=="type_id"||$k=="priority"||$k=="bin_id"||$k=="system_id"));
    if( $tf == true ) {
      $v = strip_tags(trim($v));
      $v = preg_replace("@[*]@", "%", $v);
      $k = $zen->checkAlphaNum($k);
      if( !strlen($v) )
	continue;
      if( $k == "ticket_id" ) {
	$params = array();
	$results = array($zen->get_ticket($v));
	break;
      } else {
	$params["$k"] = !(strpos($v,"%")===false)? array($k,"LIKE",$v) : array($k,"=",$v);
      }
    } else {
      $params["$k"] = array($k,"IN",preg_replace("@[^0-9,]@", "",join(",",$v)));
      $params["$k"][2] = preg_replace("@[^0-9]+@", ",",$params["$k"][2]);
    }
  }
  if( count($params)>0 ) {
    if( !$params["type_id"] )
      $params["type_id"] = array("type_id","!IN",
				 join(",",$zen->projectTypeIDs()));
    $results = $zen->search_tickets($params,'AND',0,'title');    
  }

?>
<script language='javascript'>
   var curcheck = false;
   function checkAll() {
     var i;
     for(i=0; i<document.helperForm.elements.length; i++) {
       element = document.helperForm.elements[i];
       if( element.type == "checkbox" ) {
	 if( curcheck == false ) {
	   element.checked = true;
	 }
	 else {
	   element.checked = false;
	 }
       }     
     }
     curcheck = (curcheck == false)? true : false;
   }

   function saveValues() {
     var i;
     var val = "";
     for(i=0; i<document.helperForm.elements.length; i++) {
       element = document.helperForm.elements[i];
       if( element.type == "<?=$onechoice? 'radio' : 'checkbox'?>" 
          && element.checked == true && element.value != "skip" ) {
         if( val == "" )
           val = element.value;
         else
           val += ","+element.value;
       } 
     }
     <? $field = "opener.document.forms['$return_form'].elements['$return_field']"; ?>
     <?=$field?>.value = val;
     if( <?=$field?>.select ) {
       <?=$field?>.select();
     }
     else if( <?=$field?>.focus ) {
       <?=$field?>.focus();
     }
     if( <?=$field?>.onchange ) {
       <?=$field?>.onchange();
     }

     window.self.close();
     return false;
   }
</script>

<form action='<?=$rootUrl?>/helpers/ticketSearchbox.php' method='post' name='helperForm'>
<?
  $zen->hiddenField("return_form",$return_form);
  $zen->hiddenField("return_field",$return_field);

  foreach($search_param as $k=>$v) {
    switch($k) {
      case "priority":
      $k = "set_priorities";
      break;
      case "system_id":
      $k = "set_systems";
      break;
      case "bin_id":
      $k = "set_bins";
      break;
      case "type_id":
      $k = "set_types";
      break;
      default:
       $k = "search_param[$k]";
    }
    $zen->hiddenField($k,$v);
  }
?>
<table width='<?=$table_width?>' align='center'>
<tr>
  <td class='titleCell' align='center' colspan='4'><?php echo tr("Select Tickets"); ?></td>
</tr>
<tr>
  <td class='bars' colspan='4' align='center'>
     <input type='button' 
      class='submit' value='<?php echo tr("Select"); ?>' <?=(is_array($results))?
	"onClick='return saveValues()'":""?>>
   &nbsp;&nbsp;&nbsp;&nbsp;
    <input type='submit' class='submit' value='<?php echo tr("Modify Search"); ?>'>
  </td>
</tr>
<?
 if( is_array($results) && count($results) ) {
?>
<tr>
  <td class='subTitle'>
  <? if( $onechoice ) { print "&nbsp;"; } else { ?>
    <input type='checkbox' name='allcheck' value='skip' onClick='checkAll()' class='searchbox'>
  <? } ?>
  </td>
  <td class='subTitle'>
    <?php echo tr("ID"); ?>
  </td>
  <td class='subTitle'>
    <?php echo tr("Title"); ?>
  </td>
  <td class='subTitle'>
    <?php echo tr("Bin"); ?>
  </td>
<?
   $i=0;
   foreach($results as $r) {
     $row = ($row == "cell")? "bars" : "cell";
     print "<tr>\n";
     if( $onechoice ) {
       print "\t<td class='$row'><input type='radio' name='values' "
       ." value='{$r['id']}'></td>\n";
     }
     else {
       print "\t<td class='$row'><input type='checkbox' name='values[$i]' "
         ." value='{$r['id']}'></td>\n";
     }
     print "\t<td class='$row'>{$r['id']}</td>\n";
     print "\t<td class='$row'>{$r['title']}</td>\n";
     print "\t<td class='$row'>".$zen->getBinName($r["bin_id"])."</td>\n";
     print "</tr>\n";
     $i++;
   }
 } else {
?>
<tr>
<td colspan='4' class='bars'><?php echo tr("There were no results for your search"); ?></td>
</tr>
<?
 }
?>
<tr>
<td>

</table>
</form>

<? } ?>

