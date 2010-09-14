<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

$hotkeys->loadSection('tab_contacts');
$GLOBALS['zt_hotkeys'] = $hotkeys;

$parms = array(array("ticket_id", "=", $id));
$sort = "ticket_id asc";

$tickets = $zen->get_contacts($parms,$zen->table_related_contacts,$sort);
$editable = $zen->actionApplicable($id, 'contacts', $login_id) &&
   $zen->checkAccess($login_id, $ticket['bin_id'], 'level_contacts');

$colspan = $editable? 5 : 4;
?>
<table width="600" cellpadding="0" class='formtable' cellspacing="1">
	 <tr>  
     <td colspan='<?php echo $colspan?>' class='subTitle indent' width='100%'>
       <?php echo tr("Related Contacts", array($page_type)); ?>    
     </td>
   </tr>
<?php

if ($tickets){
?>
 <form name='dropContactsForm' action="<?php echo $rootUrl?>/actions/dropFromContacts.php" method="post">
 <input type="hidden" name="id" value="<?php echo $zen->checkNum($id); ?>">
 <input type='hidden' name='setmode' value='<?php echo $zen->ffv($page_mode); ?>'>
 <tr>
  <td class='headerCell'><?php echo tr("ID"); ?></td>	
  <td class='headerCell' width='50%'><?php echo tr("Name"); ?></td>
  <td class='headerCell'><?php echo tr("Telephone"); ?></td>
  <td class='headerCell'><?php echo tr("E-mail"); ?></td>
  <?php if( $editable ) { ?>
  <td class='headerCell'><?php echo tr("Delete"); ?></td>
  <?php } ?>
 </tr>
<?php  
//print_r($tickets);
    foreach($tickets as $n) {
	    
	   if ($n["type"]=="1"){
		   $table = $zen->table_company;
		   $col = "company_id";
		   $cpid = $n["cp_id"]; 
		   $c1 = "cid" ;
		   $n1 = "title";
		   $n2 = "office";
	   } else {
	   	 $table = $zen->table_employee;
		 	 $col = "person_id";
		   $cpid = $n["cp_id"];
		 	 $c1 = "pid";
		 	 $n1 = "lname";
		   $n2 = "fname";
		 }
  	$u=$zen->get_contact($n["cp_id"],$table,$col);
    $cpid = $zen->checkNum($cpid);
    $tc = "onclick='checkMyBox(\"drops_".$zen->ffv($n['clist_id'])."\", event)' ";
    $img = "<div style='float:right'><a href='$rootUrl/contact.php?$c1=$cpid'>";
    $img .= "<img src='$imageUrl/24x24/magnify.png' border='0' width='24' height='24'></a></div>";
?>	
    <tr class='bars' <?php echo $row_rollover_eff?>>
    <td <?php echo $tc?>><?php echo $zen->ffv($cpid); ?></td>
    <td <?php echo $tc?>><?php echo  $img." ".$zen->ffv(ucfirst($u[$n1]))." ".$zen->ffv($u[$n2]) ?></td>
    <td <?php echo $tc?>><?php echo  $u['telephone']? $zen->ffv($u["telephone"]) : '&nbsp;' ?></td>
    <td <?php echo $tc?>><?php
      if( $u['email'] ) {
      ?><A id='link_<?php echo $cpid?>' HREF="mailto:<?php echo $zen->ffv($u['email']); ?>"><?php echo $zen->ffv($u["email"]); ?></A>
      <?php } else { ?>&nbsp;<?php } ?></td>
    <?php if( $editable ) { ?>
    <td <?php echo $tc?>><input 
        id='drops_<?php echo $zen->ffv($n['clist_id']); ?>' type='checkbox' name='drops[]' 
        value='<?php echo $zen->ffv($n['clist_id']); ?>'></td>
    </tr>
    <?php } ?>
<?php
    }
?>
<tr>
<td class='subTitle' colspan='<?php echo $colspan?>'>
  </div>
  <div style='float:right'>
  <?php renderDivButton($hotkeys->find('Drop Contacts'), "window.document.forms['dropContactsForm'].submit()"); ?>
  </div>
</form>
  <?php if( $editable ) { ?>
  <div style='float:left'>
  <form action="<?php echo $rootUrl?>/actions/addToContacts.php" name='ContactsAddForm'>
  <input type="hidden" name="id" value="<?php echo $zen->checkNum($id); ?>">
  <?php renderDivButton($hotkeys->find('Add Contact'), "window.document.forms['ContactsAddForm'].submit()"); ?>
  <input type='hidden' name='setmode' value='<?php echo $zen->ffv($page_mode); ?>'>
  </form>
  </div>
  <?php } ?>
</td>
</tr>
<?php } else { ?>
<tr><td valign='top' colspan='<?php echo $colspan?>' class='bars'>
<b><?php echo tr("No contacts found"); ?></b>
</td></tr>
  <?php if( $editable ) { ?>
  <tr>
  <td colspan='<?php echo $colspan?>' class='subTitle'>
    <form action="<?php echo $rootUrl?>/actions/addToContacts.php" name='ContactsAddForm'>
    <input type="hidden" name="id" value="<?php echo $zen->checkNum($id); ?>">
    <?php renderDivButton($hotkeys->find('Add Contact'), "window.document.forms['ContactsAddForm'].submit()"); ?>
    <input type='hidden' name='setmode' value='<?php echo $zen->ffv($page_mode); ?>'>
    </form>
  </td>
  </tr>
  <?php } ?>
<?php } ?>     
</table>
<?php if( $editabe ) { ?>
<p>&nbsp;
<form action='<?php echo $rootUrl?>/newContact.php' target="_BLANK" name='newContactForm'>
  <input type='hidden' name='setmode' value='<?php echo $zen->ffv($page_mode); ?>'>
  <?php renderDivButton($hotkeys->find('Create New Contact'), "window.document.forms['newContactForm'].submit()", 150); ?>
</form>
<?php } ?>