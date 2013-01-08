<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

if( is_array($tickets) && count($tickets) ) {
 
   $link = $zen->getSetting("url_view_ticket");   
   $c = count($tickets);
   
?>
<table width="100%" cellspacing='1' cellpadding='2' bgcolor='<?=$zen->getSetting("color_alt_background")?>'>
<tr>
<td class='titleCell' colspan="9" align='center'><?=($c>1)? tr("? Matches",array($c)) : tr("1 Match");?></td></tr>
<tr bgcolor="<?=$zen->getSetting("color_title_background")?>" >

<td width="32" height="25" valign="middle" title="<?=tr("ID of the contact")?>">
<div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>"><b><span class="small"><?=tr("ID")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</td>

<td height="25" valign="middle" title="<?=tr("The name of the contact")?>">
<div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>"><b><span class="small"><?=tr("Name")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</td>

<td height="25" valign="middle" title="<?=tr("The company where the contact works")?>">
<div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>"><b><span class="small"><?=tr("Company")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</td>

<td height="25" valign="middle" title="<?=tr("The E-mail address of the contact")?>">
<div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>"><b><span class="small"><?=tr("E-mail")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</td>

<td height="25" valign="middle" title="<?=tr("The telephone number of the contact")?>">
<div align="center"><span style="color:<?=$zen->getSetting("color_title_txt")?>"><b><span class="small"><?=tr("Telephone")?><?if (!empty($image)) {?>&nbsp;<IMG SRC="<?echo $imageUrl,$image ;?>" border="0"><?}?></span></b></span></div>
</td>

</tr>
<?php
$link  = "$rootUrl/contact.php";
   	$td_ttl = "title='".tr("Click here to view the Contact")."'";
   
   
   	
   foreach($tickets as $t) {    

      ?>
   <tr  class='priority1' onclick='ticketClk("<?=$link?>?pid=<?=$t["person_id"]?>")' 
      onMouseOver='if(window.document.body && mClassX){mClassX(this, "priority1Over", true);}' 
      onMouseOut='if(window.document.body && mClassX){mClassX(this, "priority1", false);}'>
   <td height="25" width="5%" valign="middle" <?=$td_ttl?>>
    <?=$t["person_id"]?>
   </td>
   <td height="25" width="25%" valign="middle" <?=$td_ttl?>>
    <?=ucfirst($t["lname"])?>&nbsp;<?=($t["fname"])?",".ucfirst($t["fname"]):",".ucfirst($t["initials"])?>
   </td>
   <td height="25" width="25%" valign="middle" <?=$td_ttl?>><?
   	 if ( isset($t["company_id"])) {
	 $contact = $zen->get_contact($t["company_id"],$zen->table_company,"company_id");
	  if( is_array($contact) ) {
      echo strtoupper($contact['title']);
      if ($contact['title']){
	      echo " " .strtolower($contact['office']);
      }
    }	  
  }
   ?>
   </td>
   <td height="25" width="25%" valign="middle" <?=$td_ttl?>>
   <?=$t["email"]?>
   </td>
   <td width="20%" valign="middle" <?=$td_ttl?>>
   <?=strtolower($t["telephone"])?>
   </td>
   </tr>       
   <?php
   } 
   unset($contact);  
?>
   <tr>
     <form method="post" action="<?=$SCRIPT_NAME?>">
       <td colspan="9" class="titleCell">
          <input type="submit" class="smallSubmit" value="<?=tr("Modify Search")?>">
          <input type="hidden" name="search_text" value="<?=strip_tags($search_text)?>">
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
