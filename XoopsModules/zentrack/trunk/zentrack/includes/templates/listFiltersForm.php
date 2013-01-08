<?php
  /**
   ** APPLY FILTERS TO TICKET LISTS
   **
   ** This file is designed to be used with includes/listFilters.php
   **
   ** REQUIREMENTS
   **    $view - the current view name
   **    $page_type - 'ticket' or 'project'
   **    $zen - zenTrack object
   **    $map - ZenFieldMap object
   **    $filter_params_withnulls - default values for form fields
   **/

  $filterview = "{$view}_filters";
  $filtercols = $map->getFieldMap($filterview);
  if( $filtercols && count($filtercols) > 0 ) {
    print "<form name='ticketFilterForm'>";
    print "<input type='hidden' name='ticketFilterForm' value='1'>";
    print "<table width='100%'><tr>";
    $context = new ZenFieldMapRenderContext(
       array('form' => 'ticketFilterForm', 'view' => $filterview,
             'events' => "onchange='window.document.ticketFilterForm.submit()'")
    );
    foreach($filtercols as $c=>$field) {
      if( !$field['is_visible'] ) { continue; }
      $v = array_key_exists($c,$filter_params_withnulls) && 
            !is_array($filter_params_withnulls[$c])? 
              $filter_params_withnulls[$c] : null;
      print "<td class='small'>";
      print $map->getLabel($filterview, $c);
      print "&nbsp;";
      if( $c == 'status' ) {
        print "<select name='filterForm_status' onchange='window.document.ticketFilterForm.submit()'>";
        $sel = !array_key_exists($c, $filter_params_withnulls) || !$filter_params_withnulls[$c]?
          ' selected' : '';
        print "<option value=''{$sel}>".tr("-any-")."</option>";
        $sel = array_key_exists($c, $filter_params_withnulls) && $filter_params_withnulls[$c] == 'OPEN,PENDING'?
          ' selected' : '';
        print "<option value='OPEN,PENDING'{$sel}>".tr("Open")." ".tr("or")." ".tr("Pending")."</option>";
        $sel = array_key_exists($c, $filter_params_withnulls) && $filter_params_withnulls[$c] == 'OPEN'?
          ' selected' : '';
        print "<option value='OPEN'{$sel}>".tr("Open")."</option>";
        $sel = array_key_exists($c, $filter_params_withnulls) && $filter_params_withnulls[$c] == 'PENDING'?
          ' selected' : '';
        print "<option value='PENDING'{$sel}>".tr("Pending")."</option>";
        $sel = array_key_exists($c, $filter_params_withnulls) && $filter_params_withnulls[$c] == 'CLOSED'?
          ' selected' : '';
        print "<option value='CLOSED'{$sel}>".tr("Closed")."</option>";
        print "</select>\n";
      }
      else {
        $context->set('page_type', $page_type);
        $context->set('field', $c);
        $context->set('name',  "filterForm_{$c}");
        $context->set('value', $v);
        print $map->renderTicketField($context);
      }
      print "</td>";
    }
    print "</tr></table>\n";
    print "</form>";
  }
?>