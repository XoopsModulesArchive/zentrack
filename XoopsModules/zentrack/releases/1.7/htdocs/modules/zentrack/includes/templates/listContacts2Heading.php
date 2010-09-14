<?php if( !ZT_DEFINED ) { die("Illegal Access"); }
  if(!isset($cssStyle) ) { $cssStyle = 'subTitle'; }
?>
 <tr>
		<td valign="middle" title="<?php echo tr("ID of the contact"); ?>" class="<?php echo $cssStyle?>" >
		  <?php echo tr("ID"); ?>
		</td>
		<td valign="middle" title="<?php echo tr("The name of the contact"); ?>" class="<?php echo $cssStyle?>">
		  <?php echo tr("Name"); ?>
		</td>
		<?if ($overview=="extern") { ?>
		<td valign="middle" title="<?php echo tr("The company of the contact"); ?>" class="<?php echo $cssStyle?>">
		  <?php echo tr("Company"); ?>
		</td>
		<?}?>
		<td valign="middle" title="<?php echo tr("The e-mail of the contact"); ?>" class="<?php echo $cssStyle?>">
		  <?php echo tr("E-mail"); ?>
		</td>
		<td valign="middle" title="<?php echo tr("The telephone of the contact"); ?>" class="<?php echo $cssStyle?>">
		  <?php echo tr("Telephone Nr."); ?>
		</td>
    <?php if( isset($show_list_options) && $show_list_options ) { ?>
		<td valign="middle" class="<?php echo $cssStyle?>" width='50'>
		  <?php echo tr("Options"); ?>
		</td>
    <?php } ?>
 </tr>