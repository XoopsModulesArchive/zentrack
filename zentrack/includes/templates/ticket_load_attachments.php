<?php if( !ZT_DEFINED ) { die("Illegal Access"); }

$access = $zen->actionApplicable($id, "upload", $login_id);
$colspan = $access? 5 : 4;
if( $access ) {
  $hotkeys->loadSection('tab_attachments');
  $GLOBALS['zt_hotkeys'] = $hotkeys;
  ?>
  <form method='post' action='<?=$rootUrl?>/actions/dropAttachments.php' name='deleteAttachmentForm'>
  <input type="hidden" name="id" value="<?=$id?>">
  <input type='hidden' name='setmode' value="<?=$zen->ffv($page_mode)?>">
      <?php
}
?>
  <table width="600" class='formtable' cellpadding="2" cellspacing="1">
   <tr>  
     <td class="subTitle indent" colspan='<?=$colspan?>'>
        <?=tr("Attachments")?>
     </td>
  </tr>
      <?php
  // get attachments and display a list
  // of them
  $attachments = $zen->get_attachments($id);
  if( is_array($attachments) && count($attachments) > 0) {
     ?>
       <tr>
         <td class='headerCell'><?=tr("Log ID")?></td>
         <td class='headerCell'><?=tr("Attachment")?></td>
         <td class='headerCell'><?=tr("Type")?></td>
         <td class='headerCell'><?=tr("Description")?></td>
         <?php if( $access ) { ?>
         <td class='headerCell'><?=tr("Delete")?></td>
         <?php } ?>
       </tr>
      <?php
     foreach($attachments as $a) {
       $aid = $a['attachment_id'];
       $clk = "onclick=\"ticketClk('".$zen->getSetting("url_view_attachment")."?aid=$aid');return false;\"";
	?>
	  <tr class='bars' <?=$row_rollover_eff?>>
	  <td <?=$clk?>>
	    <?= ($a["log_id"])?
          $a['log_id']." ".
	         "<a href='".$zen->getSetting("url_view_log")
                    ."?lid=".$zen->ffv($a['log_id'])."' class='rowLink'>"
                    ."<img src='$imageUrl/24x24/magnify.png' width='24' height='24' border='0'>"
                    ."</a>" :
	         "n/a";
	    ?>
	  </td>
	  <td <?=$clk?>>
	    <a href='<?=$zen->getSetting("url_view_attachment")?>?aid=<?=$aid?>' 
	    class='rowLink' target='_blank'><?=$zen->ffv($a['name'])?></a></td>
	  <td <?=$clk?>>
	    <?=$zen->ffv($a["filetype"])?>
	  </td>
	  <td <?=$clk?>>
	    <?=$zen->ffv($a["description"])?>
	  </td>
    <?php if( $access ) { ?>
    <td class='bars' onclick='checkMyBox("drops_<?=$aid?>", event)'>
      <input id='drops_<?=$aid?>' type='checkbox' name='drops[]' value='<?=$aid?>'>
    </td>
    <?php } ?>
	  </tr>
     <?php
     }    
  } else {
     print "<tr><td class='bars' colspan='4'>".tr("No attachments exist for this ?", array($page_type))."</td></tr>";
  }
?>
  <?php if( $access ) { ?>
  <tr> 
     <td class='subTitle' colspan='<?=$colspan?>'>
     <?php if( is_array($attachments) && count($attachments) ) { ?>
       <div style='float:right'>
       <?php renderDivButtonFind('Delete Attachments', 150); ?>
       </div>
     <?php } ?>
       </form>
       <div style='float:left'>
       <form name='addAttachmentForm' action='<?=$rootUrl?>/actions/upload.php'>
       <input type="hidden" name="id" value="<?=$id?>">
       <input type='hidden' name='setmode' value="<?=$zen->ffv($page_mode)?>">
       <?php renderDivButtonFind('Add Attachment', 150); ?>
       </form>
       </div>
     </td>
   </tr>  
   <?php } ?>
</table>
