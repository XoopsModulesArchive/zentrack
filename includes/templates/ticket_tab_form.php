<?php if( !ZT_DEFINED ) { die("Illegal Access"); }

  /**
   * TICKET TAB FORM
   *
   * Generates a form for editing a given list of fields in a ticket tab
   *
   * $formview - (String) the field map view to use for deciding which fields to show
   * $map - (ZenFieldMap)
   * $actionName - where to send post data (defaults to $SCRIPT_NAME)
   * $submitName - name of submit button (defaults to 'Save')
   * $formTitle - title of the form
   * $formDesc - descriptive text for this form (optional)
   * $id - id of the ticket to display
   * $ticket - current contents of the ticket to display
   * $varfields - current varfield values for the ticket
   */
  $fields = $map->getFieldMap($formview);
  if( !isset($actionName) ) { $actionName = $SCRIPT_NAME; }
  if( !isset($submitName) ) { $submitName = 'Save'; }
  $hidden_fields = array();
  $visible_fields = array();
  foreach($fields as $f=>$field) {
    if( !$field['is_visible'] ) { $hidden_fields["$f"] = $field; }
    else {
      $visible_fields["$f"] = $field;
    }
  }
?>

<form method="post" name="ticketTabForm" action="<?=$actionName?>" onSubmit='return validateTicketForm(this)'>
    <?php
$context = new ZenFieldMapRenderContext(
  array("view" => $formview, "form" => 'ticketForm')
);
foreach($hidden_fields as $f=>$field) {
  $context->set('field', $f);
  $context->set('value', ZenFieldMap::isVariableField($f)? $varfields[$f] : $ticket[$f]);
  print $map->renderTicketField($context);
}
?>
<input type="hidden" name="id" value="<?=$zen->ffv($id)?>">
<input type="hidden" name="actionComplete" value="1">
<input type='hidden' name='ticketTabAction' value='1'>
<input type='hidden' name='currentMode' value='<?=$zen->ffv($page_mode)?>'>

<table class='formtable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td colspan='2' class='subTitle'><?=tr($formTitle)?>
 <?php if( isset($formDesc) ) { print "&nbsp;&nbsp;<span class='note'>".tr($formDesc)."</span>"; } ?>
 </td>
</tr>
    <?php

foreach($visible_fields as $f=>$field) {
  $context->set('field', $f);
  $context->set('value', ZenFieldMap::isVariableField($f)? $varfields[$f] : $ticket[$f]);
  $context->set('force_label', $f == 'status');
  if( $field['field_type'] == 'section' ) {
    print "<tr><td colspan='2' class='subTitle'>";
    print $map->renderTicketField($context);
    print "</td></tr>\n";
  }
  else {
    print "<tr><td class='bars' width='150'>";
    $key = $hotkeys->find("Field: $f");
    if( $key ) {
      print $hotkeys->label($key, $map->getLabel($formview,$f));
    }
    else {
      print $map->getLabel($formview,$f);
    }
    if( $field['is_required'] ) {
      print "&nbsp;<span class='error bigBold'>*</span>";
    }
    print "</td><td class='bars'>";
    print $map->renderTicketField($context);
    print "</td></tr>\n";
  }
}

?>

<tr>
  <td class="subTitle" colspan='2'>
  <?php renderDivButton($hotkeys->find($submitName), "if( validateTicketForm(window.document.forms['ticketTabForm']) ) { window.document.forms['ticketTabForm'].submit(); }"); ?>
  </td>
</tr>
<tr>
</table>
<div class='error'><?=tr("Fields marked with ? are required", "<span class='bigBold'>*</span>")?></div>
</form>			     
<?php
  include_once("$libDir/templates/validateTicketForm.php");
?>
