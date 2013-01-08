<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form method="post" name="contactForm" action="<?=($skip)? "editContactSubmit.php" : "$rootUrl/addContactSubmit.php"?>">
<input type="hidden" name="id" value="<?=strip_tags($id)?>">
<?
if(isset($creator_id)) { ?>
<input type="hidden" name="creator_id" value="<?=strip_tags($creator_id)?>">	
<?
}
if(isset($create_time)) { ?>
<input type="hidden" name="create_time" value="<?=strip_tags($create_time)?>">	
<?
}
?>
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->getSetting("color_background")?>">
<tr>
  <td colspan="2" width="640" class="subTitle" align="center">
     <?=tr("Contact Information")?>
  </td>
</tr>
  
<tr>
  <td colspan="2" class="headerCell">
    <?=tr("Details")?>
  </td>
</tr>
  

<tr>
  <td class="bars">
    <?=tr("Title")?>:
  </td>
  <td class="bars">
    <input type="text" name="title" size="20" maxlength="50"
      value="<?=strip_tags($title)?>">
  </td>
</tr>            
    
<tr>
  <td class="bars">
    <?=tr("Office")?>:
  </td>
  <td class="bars">
    <input type="text" name="office" size="20" maxlength="50"
value="<?=strip_tags($office)?>">
  </td>
</tr>          
    
<tr>
  <td class="bars">
    <?=tr("Address line ")?>1:
  </td>
  <td class="bars">
    <input type="text" name="address1" size="30" maxlength="50"
value="<?=strip_tags($address1)?>">
  </td>
</tr>  
    
<tr>
  <td class="bars">
    <?=tr("Address line ")?>2:
  </td>
  <td class="bars">
    <input type="text" name="address2" size="30" maxlength="50"
value="<?=strip_tags($address2)?>">
  </td>
</tr> 

<tr>
  <td class="bars">
    <?=tr("Address line ")?>3:
  </td>
  <td class="bars">
    <input type="text" name="address3" size="30" maxlength="50"
value="<?=strip_tags($address3)?>">
  </td>
</tr> 

<tr>
  <td class="bars">
    <?=tr("P.O. Box")?>:
  </td>
  <td class="bars">
    <input type="text" name="pobox" size="20" maxlength="50"
value="<?=strip_tags($pobox)?>">
  </td>
</tr> 

<tr>
  <td class="bars">
    <?=tr("Postal Code(Zip)")?>:
  </td>
  <td class="bars">
    <input type="text" name="postcode" size="20" maxlength="50"
value="<?=strip_tags($postcode)?>">
  </td>
</tr> 

<tr>
  <td class="bars">
    <?=tr("Location")?>:
  </td>
  <td class="bars">
    <input type="text" name="postcode2" size="20" maxlength="50"
      value="<?=strip_tags($postcode2)?>">
  </td>
</tr>   

<tr>
  <td class="bars">
    <?=tr("Country")?>:
  </td>
  <td class="bars">
    <input type="text" name="country" size="20" maxlength="50"
      value="<?=strip_tags($country)?>">
  </td>
</tr>   

<tr>
  <td class="bars">
    <?=tr("County / State")?>:
  </td>
  <td class="bars">
    <input type="text" name="place" size="20" maxlength="50"
      value="<?=strip_tags($place)?>">
  </td>
</tr>   

<tr>
  <td class="bars">
    <?=tr("Telephone no")?>:
  </td>
  <td class="bars">
    <input type="text" name="telephone" size="20" maxlength="20"
      value="<?=strip_tags($telephone)?>">
  </td>
</tr>   

<tr>
  <td class="bars">
    <?=tr("Fax no")?>:
  </td>
  <td class="bars">
    <input type="text" name="fax" size="20" maxlength="50"
      value="<?=strip_tags($fax)?>">
  </td>
</tr>  

<tr>
  <td class="bars">
    <?=tr("Email")?>:
  </td>
  <td class="bars">
    <input type="text" name="email" size="20" maxlength="50"
      value="<?=strip_tags($email)?>">
  </td>
</tr>   

<tr>
  <td class="bars">
    <?=tr("Website")?>:
  </td>
  <td class="bars">
    <input type="text" name="website" size="20" maxlength="50"
      value="<?=($website)?strip_tags($website):"http://"?>">
  </td>
</tr>   

<tr>
  <td colspan="2" class="bars">
    <?=tr("Description")?>:
  </td>
</tr>
  
<tr>
  <td colspan="2" class="bars">
    <textarea cols="60" rows="5" name="description"><?= 
   ereg_replace("&","&amp;",stripslashes($description)); 
    ?></textarea>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle indent">
   <input type="submit" value=" <?=($skip)?"Save":"Create"?> " class="submit">
  </td>
</tr>
</table>
</form>
