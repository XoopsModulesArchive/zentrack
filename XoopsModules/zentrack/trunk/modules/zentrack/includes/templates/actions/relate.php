<?php 
  if( !ZT_DEFINED ) { die("Illegal Access"); } 
  if( is_array($relations) ) {
    $relations = join(',',$relations);
  }
?>

<form method="post" action="<?php echo $SCRIPT_NAME?>" name='relateTicketForm'>
<input type="hidden" name="id" value="<?php echo $id?>">
<input type="hidden" name="actionComplete" value="1">
<input type="hidden" name="setmode" value="<?php echo $page_mode?>">

<table width="600" class='formtable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle'>
   <?php echo tr("Relate Ticket"); ?>
 </td>
</tr>
<tr>
 <td class="bars">
   <?php echo $hotkeys->ll("Enter Ticket IDs"); ?>
 </td>
</tr>
<tr>
 <td class='bars'>
    <textarea cols='20' rows='4' title="<?php echo $hotkeys->tt("Enter Ticket IDs"); ?>" 
      name='relations'><?php echo $zen->ffv($relations); ?></textarea>
     &nbsp;<input type='button' class='searchbox' value=' ... ' 
	onClick='popupWindowScrolls("<?php echo $rootUrl?>/helpers/ticketSearchbox.php?return_form=relateTicketForm&return_field=relations","popupHelper",375,500)'>
     <br><span class='note'> <?php echo tr("Enter ticket ids, separated by commas"); ?></span>
  </td>			     
</tr>
<tr>
  <td class="bars">
     <?php echo $hotkeys->ll("Comments"); ?> 
	&nbsp;<span class="small">(<?php echo tr("optional"); ?>)</span>
  </td>
</tr>
<tr>
  <td class='bars'
    <textarea cols="50" rows="4" name="comments" title="<?php echo $hotkeys->tt("Comments"); ?>"><?php echo 
      $zen->ffvText($comments); ?></textarea>
  </td>
</tr>
<tr>
  <td class="subTitle">
  <?php renderDivButtonFind('Relate'); ?>
  </td>
</tr>
<tr>
</table>

</form>
