<?php
  if( !ZT_DEFINED ) { die("Illegal Access"); } 
  if( is_array($relations) ) {
    $relations = join(',',$relations);
  }
?>

<form method="post" action="<?=$SCRIPT_NAME?>" name='relateTicketForm'>
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="actionComplete" value="1">
<input type="hidden" name="setmode" value="<?=$page_mode?>">

<table width="600" class='formtable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle'>
   <?=tr("Relate Ticket")?>
 </td>
</tr>
<tr>
 <td class="bars">
   <?=$hotkeys->ll("Enter Ticket IDs")?>
 </td>
</tr>
<tr>
 <td class='bars'>
    <textarea cols='20' rows='4' title="<?=$hotkeys->tt("Enter Ticket IDs")?>" 
      name='relations'><?=$zen->ffv($relations)?></textarea>
     &nbsp;<input type='button' class='searchbox' value=' ... ' 
	onClick='popupWindowScrolls("<?=$rootUrl?>/helpers/ticketSearchbox.php?return_form=relateTicketForm&return_field=relations","popupHelper",375,500)'>
     <br><span class='note'> <?=tr("Enter ticket ids, separated by commas")?></span>
  </td>			     
</tr>
<tr>
  <td class="bars">
     <?=$hotkeys->ll("Comments")?> 
	&nbsp;<span class="small">(<?=tr("optional")?>)</span>
  </td>
</tr>
<tr>
  <td class='bars'
    <textarea cols="50" rows="4" name="comments" title="<?=$hotkeys->tt("Comments")?>"><?=
      $zen->ffvText($comments)?></textarea>
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
