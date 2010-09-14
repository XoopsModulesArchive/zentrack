<?php if( !ZT_DEFINED ) { die("Illegal Access"); }
  if(!isset($cssStyle) ) { $cssStyle = 'subTitle'; }
?><tr>
    <td valign="middle" title="<?php echo tr("ID of the contact"); ?>" class="<?php echo $cssStyle?>" >
      <?php echo tr("ID"); ?>
    </td>
    <td valign="middle" title="<?php echo tr("The title of the contact"); ?>" class="<?php echo $cssStyle?>">
      <?php echo tr("Title"); ?>
    </td>
    <td valign="middle" title="<?php echo tr("The email of the contact"); ?>" class="<?php echo $cssStyle?>">
      <?php echo tr("E-mail"); ?>
    </td>
    <td valign="middle" title="<?php echo tr("The telephone of the contact"); ?>" class="<?php echo $cssStyle?>">
      <?php echo tr("Telephone Nr."); ?>
    </td>
    <td valign="middle" title="<?php echo tr("The website of the contact"); ?>" class="<?php echo $cssStyle?>">
      <?php echo tr("Website"); ?>
    </td>
  </tr>

