<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <tr>
  <td<?php echo (isset($expand_contacts)&&$expand_contacts)? " class='titleCell'" : " ".$nav_rollover_text?>>
  <a class='menuLink' href="<?php echo $rootUrl?>/contacts.php"><?php echo tr("Contacts"); ?></a>
  </td>
  </tr>
<?php if( isset($expand_contacts)&&$expand_contacts ) { ?>     
  <tr>
  <td <?php echo $nav_rollover_text?>>
  <a class='subMenuLink' href="<?php echo $rootUrl?>/newContact.php">&nbsp;&nbsp;<?php echo tr("Create new"); ?></a>
  </td>
  </tr>  
<?php } ?>

  <tr>
  <td<?php echo (isset($expand_agreement)&&$expand_agreement)? " class='titleCell'" : " ".$nav_rollover_text?>>
  <a class='menuLink' href="<?php echo $rootUrl?>/agreements.php"><?php echo tr("Agreements"); ?></a>
  </td>
  </tr>
<?php if( isset($expand_agreement)&&$expand_agreement ) { ?>
  <tr>
  <td <?php echo $nav_rollover_text?>>
  <a class='subMenuLink' href="<?php echo $rootUrl?>/newAgreement.php">&nbsp;&nbsp;<?php echo tr("Create new"); ?></a>
  </td>
  </tr>
  <?php
 } ?>

	<tr>
  <td<?php echo $nav_rollover_text?>>
  <a class='menuLink' href="<?php echo $rootUrl?>/searchContacts.php"><?php echo tr("Search"); ?></a>
  </td>
  </tr>
