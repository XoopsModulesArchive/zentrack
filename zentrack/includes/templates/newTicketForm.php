<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  /**
   PREREQUISITES:
     (ZenFieldMap)$map - contains properties for fields
     (string)$view - the current view (probably project_create or ticket_create)
     (string)$page_type - (optional) either 'ticket' or 'project'
     (array)$ticket - the ticket to be displayed (if any)
  **/


  ///////////////////////////////////////////////////
  // determine which page we are looking at and
  // validate access priviledges
  //////////////////////////////////////////////////
  unset($users);
  $td = ($TODO == 'EDIT' || $TODO == 'EDIT_CUSTOM');
  
  // determine what type of page we are looking at and create some useful labels
  if( !isset($page_type) ) { 
    $page_type = strpos($view,'project')===0? 'project' : 'ticket'; 
  }
  $plural = $page_type == 'project'? 'projects' : 'tickets';
  tr( $plural );
  $ucfirst = ucfirst($page_type);
  
  if( !$td ) {
    $ticket = array();
    $ticket['id'] = 0;
    $ticket['creator_id'] = $login_id;
    $ticket['status'] = 'OPEN';
    if( $project_id ) { $ticket['project_id'] = $zen->checkNum($project_id); }
  }
  
  $id = $ticket['id'];

  // set the form name and the override as label if appropriate
  $form_name = "ticketForm";
  
  // blow up if this user does not have proper access to any bins
  $userBins = $zen->getUsersBins($login_id, $map->getViewProp($view,'access_level'));
  if( !is_array($userBins) || !count($userBins) ) {
    print "<span class='error'>";
    if( $td ) {
      print tr("You do not have permission to edit ? in at least 1 bin.", array($plural));
    }
    else {
      print tr("You do not have permission to create ? in at least 1 bin.", array($plural));
    }
    print "</span>\n";
    include("$libDir/footer.php");
    exit;
  }
  
  
  ///////////////////////////////////////////////////
  // set default values as needed
  ///////////////////////////////////////////////////
  
  // set deadline and start date on create screens
  if( !$ticket['deadline'] && !$td )
     $ticket['deadline'] = $zen->getDefaultValue("default_deadline");
  if( !$ticket['start_date'] && !$td )
     $ticket['start_date'] = $zen->getDefaultValue("default_start_date");
     
  if( !$td ) { $otime = time(); }
     
  // calculate the destination of our form results
  if( $td ) {
    if (strpos($view,"custom")!== false) {
      $formDest = "actions/editCustomSubmit.php";
    } else {
      $formDest = $page_type == 'project'? 'editProjectSubmit.php' : 'editTicketSubmit.php';
    }
  }
  else {
    $formDest = $page_type == 'project'? 'addProjectSubmit.php' : 'addSubmit.php';
  }
?>
<table width="640" align="left" cellpadding="2" cellspacing="2" class='formTable'>
<form method="post" name="<?=$form_name?>" action="<?=$formDest?>" onSubmit='return validateTicketForm(this)'>
<tr>
  <td colspan="2" width="640" class="subTitle" align="center">
     <?=tr("$ucfirst Information")?>
  </td>
</tr>
    <?php
  ///////////////////////////////////////
  // print the ticket fields
  ///////////////////////////////////////
  $formview = $view;
  include("$templateDir/form_fields.php");
  
  ////////////////////////////////////////
  // include the reason required box
  ////////////////////////////////////////
  if ($TODO == 'EDIT' && $zen->settingOn('edit_reason_required') && $zen->settingOn('log_edit') ) {
?>
<tr>
  <td class="bars">
    <?=tr("Edit Reason")?><br>
    <span class='note'>(<?=tr("Required")?>)</note>
  </td>
  <td class="bars">
      <?php
    $er_vals=array('field_cols'   => '60',
                   'field_rows'   => '5',
                   'field_name'   => 'edit_reason',
                   'field_events' => '',
                   'field_value'  => '');
    $er_template=new zenTemplate("$templateDir/fields/textarea.template");
    $er_template->values($er_vals);
    print $er_template->process();
?>
  </td>
</tr>
  <?php
  }
?>
<tr>
  <td colspan="2" class="subTitle">
   <input type="submit" value=" <?=tr(($td)?"Save":"Create")?> " class="submit">
  </td>
</tr>
</table>
</form>
<?php
  $formview = $view;
  include_once("$libDir/templates/validateTicketForm.php");
?>