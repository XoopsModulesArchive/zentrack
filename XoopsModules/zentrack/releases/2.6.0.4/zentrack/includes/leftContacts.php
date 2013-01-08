<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <tr>
  <td<?=(isset($expand_contacts)&&$expand_contacts)? " class='titleCell'" : " ".$nav_rollover_text?>>
  <a class='menuLink' href="<?=$rootUrl?>/contacts.php"><?=tr("Contacts")?></a>
  </td>
  </tr>
<? if( isset($expand_contacts)&&$expand_contacts ) { ?>     
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/newContact.php">&nbsp;&nbsp;<?=tr("Create new")?></a>
  </td>
  </tr>  
<? } ?>

  <tr>
  <td<?=(isset($expand_agreement)&&$expand_agreement)? " class='titleCell'" : " ".$nav_rollover_text?>>
  <a class='menuLink' href="<?=$rootUrl?>/agreements.php"><?=tr("Agreements")?></a>
  </td>
  </tr>
<? if( isset($expand_agreement)&&$expand_agreement ) { ?>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/newAgreement.php">&nbsp;&nbsp;<?=tr("Create new")?></a>
  </td>
  </tr>
  <?
 } ?>

	<tr>
  <td<?=$nav_rollover_text?>>
  <a class='menuLink' href="<?=$rootUrl?>/searchContacts.php"><?=tr("Search")?></a>
  </td>
  </tr>
