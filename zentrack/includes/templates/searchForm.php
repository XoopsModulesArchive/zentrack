<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  /**
   PREREQUISITES:
     (ZenFieldMap)$map - contains properties for fields
     (string)$view - the current view (probably project_list or ticket_list)
  **/  
  
  $view = 'search_form';
  $hotkeys->loadSection('search_form');
  $GLOBALS['zt_hotkeys'] = $hotkeys;
  $fields = $map->getFieldMap($view);
  $text_fields = array();
  $other_fields = array();
  $hidden_fields = array();
  $date_fields = array();
  foreach($fields as $f=>$field) {
    if( $field['field_type'] == 'hidden' ) {
      $hidden_fields[$f] = $field;
    }
    else if( !$field['is_visible'] ) { continue; }
    
    if( $field['field_type'] == 'text' || $field['field_type'] == 'textarea' ) {
      $text_fields[$f] = $field; }
    else if( $field['field_type'] == 'date' ) {
      $date_fields[$f] = $field;
    }
    else { $other_fields[$f] = $field; }
  }
?>
<form action="<?=$SCRIPT_NAME?>" name="searchForm" method='POST'>
<input type="hidden" name="TODO" value="SEARCH">
    <?php
$context = new ZenFieldMapRenderContext(
  array('view' => $view, 'form' => 'searchForm')
);
foreach($hidden_fields as $f=>$field) {
  $context->set('field', $f);
  $context->set('value', $$f);
  $map->renderTicketField($context);
}
?>
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->getSetting("color_background")?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
     <?=tr("Search For Tickets")?>
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
     <input type="submit" class="submit" value="<?=tr("Search")?>">
  </td>
</tr>

    <?php
if( count($text_fields) ) {
?>
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Containing Text")?>
  </td>
</tr>
<tr>
  <td class="bars">
     <?=$hotkeys->ll("Containing")?>
  </td>
  <td class="bars">
   <input type="text" name="search_text" 
      value="<?=$zen->ffv($search_text)?>" size="25" maxlength="50">
  </td>
</tr>
<tr>
  <td class="bars">
     <?=tr("In any of these")?>
  </td>
  <td class="bars">
    <table><tr><td valign='top'>
                <?php
  $c = 0;
  if( !is_array($search_fields) ) 
      { $search_fields = array('title'=>1,'description'=>1); }
    foreach($text_fields as $t=>$field) {
      if( $c > 0 && !$switch) { print "<br>"; }
      $switch = false;
      $checked = is_array($search_fields) && array_key_exists($t, $search_fields) && $search_fields["$t"] > 0? " checked" : "";
      $label = ( $t == 'title' || $t == 'description' )?
        $hotkeys->ll($t=='title'?'Summary':'Description') : $map->getLabel($view, $t);
      print "<input type='checkbox' name='search_fields[$t]' value='1'$checked>&nbsp;$label\n";
      if( count($text_fields) > 3 && ++$c == ceil(count($text_fields)/2) ) {
        $switch = true;
        print "</td><td valign='top'>\n";
      }
    }
}
?>
    </td></tr></table>
  </td>
</tr>
    <?php

if( count($date_fields) ) {
?>
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Date Matches")?>
  </td>
</tr>
    <?php
  $context = new ZenFieldMapRenderContext(
    array('view' => $view, 'form' => 'searchForm')
  );
  foreach( $date_fields as $f=>$field ) {
      print "<tr><td class='bars'>";
      print $map->getLabel($view, $f);
      print "</td><td class='bars'>";
      print "<span class='note'>between ";
      $name = "{$f}_begin";
      $context->set('field', $f);
      $context->set('value', $search_params["$name"]);
      $context->set('name',  "search_params[$name]");
      print $map->renderTicketField($context);
      print " and ";
      $name = "{$f}_end";
      $context->set('field', $f);
      $context->set('value', $search_params["$name"]);
      $context->set('name',  "search_params[$name]");
      print $map->renderTicketField($context);
      print "</span>";
      print "</td></tr>\n";
  }
}


if( count($other_fields) ) {
?>
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Other Fields")?>
  </td>
</tr>
    <?php
  $context = new ZenFieldMapRenderContext(
    array('view' => $view, 'form' => 'searchForm')
  );
  foreach( $other_fields as $f=>$field ) {
    print "<tr><td class='bars'>";
    print $map->getLabel($view,$f);
    print "</td><td class='bars'>";
    $context->set('field', $f);
    $context->set('value', $search_params["$f"]);
    $context->set('name',  "search_params[$f]");
    print $map->renderTicketField($context);
    if( $f == 'priority' ) {
      print "&nbsp;<input type='checkbox' name='or_higher' checked value='1'> or higher";
    } else if( strpos($f, "multi")>0 ) {
      print "&nbsp;<select name='srch_opt[$f]'>";
      print "<option value='EXACT' selected='selected'>".tr("Exact Match")."</option>";
      print "<option value='AND'>".tr("Match All")."</option>";
      print "<option value='OR'>".tr("Match Any")."</option>";
      print "</selected>";
    }
    print "</td></tr>\n";
  }
}
?>
<tr>
  <td colspan="2" class="subTitle">
	<?=tr("Click 'Search' to find results")?>
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
     <input type="submit" class="submit" value="<?=tr("Search")?>">
  </td>
</tr>

</table>
  
</form>
