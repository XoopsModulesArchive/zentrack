<? if( !ZT_DEFINED ) { die("Illegal Access"); }
  if(!isset($cssStyle) ) { $cssStyle = 'subTitle'; }
?>
 <tr>
		<td valign="middle" title="<?=tr("ID of the contact")?>" class="<?=$cssStyle?>" >
		  <?=tr("ID")?>
		</td>
		<td valign="middle" title="<?=tr("The name of the contact")?>" class="<?=$cssStyle?>">
		  <?=tr("Name")?>
		</td>
		<?if ($overview=="extern") { ?>
		<td valign="middle" title="<?=tr("The company of the contact")?>" class="<?=$cssStyle?>">
		  <?=tr("Company")?>
		</td>
		<?}?>
		<td valign="middle" title="<?=tr("The e-mail of the contact")?>" class="<?=$cssStyle?>">
		  <?=tr("E-mail")?>
		</td>
		<td valign="middle" title="<?=tr("The telephone of the contact")?>" class="<?=$cssStyle?>">
		  <?=tr("Telephone Nr.")?>
		</td>
    <? if( isset($show_list_options) && $show_list_options ) { ?>
		<td valign="middle" class="<?=$cssStyle?>" width='50'>
		  <?=tr("Options")?>
		</td>
    <? } ?>
 </tr>