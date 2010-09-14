<?php  
if( !ZT_DEFINED ) { die("Illegal Access"); }

if( is_array($tickets) && count($tickets) ) {
 
   $link = $zen->getSetting("url_view_ticket");   
   $c = count($tickets);
   
?>
<table width="100%" cellspacing='1' cellpadding='2' bgcolor='<?php echo $zen->getSetting("color_alt_background"); ?>'>
<tr>
<td class='titleCell' colspan="9" align='center'><?php echo ($c>1)? tr("? Matches",array($c)) : tr("1 Match");?></td></tr>
<tr bgcolor="<?php echo $zen->getSetting("color_title_background"); ?>" >

<td width="32" height="25" valign="middle" title="<?php echo tr("ID of the contact"); ?>">
<div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>"><b><span class="small"><?php echo tr("ID"); ?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</td>

<td height="25" valign="middle" title="<?php echo tr("The name of the contact"); ?>">
<div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>"><b><span class="small"><?php echo tr("Title"); ?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</td>

<td height="25" valign="middle" title="<?php echo tr("The E-mail address of the contact"); ?>">
<div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>"><b><span class="small"><?php echo tr("E-mail"); ?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</td>

<td height="25" valign="middle" title="<?php echo tr("The telephone number of the contact"); ?>">
<div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>"><b><span class="small"><?php echo tr("Telephone"); ?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</td>

<td height="25" valign="middle" title="<?php echo tr("The website of the contact"); ?>">
<div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>"><b><span class="small"><?php echo tr("Website"); ?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</td>

</tr>
<?php      
$link  = "$rootUrl/contact.php";
$td_ttl = "title='".tr("Click here to view the Contact")."'";

   foreach($tickets as $t) {      
      ?>
   <tr  class='priority1' onclick='ticketClk("<?php echo $link?>?cid=<?php echo $t['company_id']?>")' 
     onMouseOver='if(window.document.body && mClassX){mClassX(this, "priority1Over", true);}' 
     onMouseOut='if(window.document.body && mClassX){mClassX(this, "priority1", false);}'>
   <td height="25" width="5%" valign="middle" <?php echo $td_ttl?>>
    <?php echo $t["company_id"]?>
   </td>
   <td height="25" width="25%" valign="middle" <?php echo $td_ttl?>>
    <?php echo strtoupper($t["title"]); ?>&nbsp;<?php echo strtolower($t["office"]); ?>
   </td>
   <td height="25" width="25%" valign="middle" <?php echo $td_ttl?>>
   <?php echo strtolower($t["email"]); ?>
   </td>
   <td height="25" width="15%" valign="middle" <?php echo $td_ttl?>>
   <?php echo $t["telephone"]?>
   </td>
   <td  width="30%" valign="middle" <?php echo $td_ttl?>>
   <?php echo strtolower($t["website"]); ?>
   </td>
   </tr>      
<?php
   } 
   ?>

   <tr>
     <form method="post" action="<?php echo $SCRIPT_NAME?>">
       <td colspan="9" class="titleCell">
          <input type="submit" class="smallSubmit" value="<?php echo tr("Modify Search"); ?>">
          <input type="hidden" name="search_text" value="<?php echo strip_tags($search_text); ?>">
          <?php
           foreach($search_fields as $k=>$v) {
               print "<input type='hidden' name='search_params[$k]' value='".strip_tags($v)."'>\n";
           }
           ?>
       </td>
     </form>
   </tr>
  </table>
<?php  
  
}
?>
