<? if( !ZT_DEFINED ) { die("Illegal Access"); }
  if(!isset($cssStyle) ) { $cssStyle = 'subTitle'; }
?><tr>
    <td valign="middle" title="<?=tr("ID of the contact")?>" class="<?=$cssStyle?>" >
      <?=tr("ID")?>
    </td>
    <td valign="middle" title="<?=tr("The title of the contact")?>" class="<?=$cssStyle?>">
      <?=tr("Title")?>
    </td>
    <td valign="middle" title="<?=tr("The email of the contact")?>" class="<?=$cssStyle?>">
      <?=tr("E-mail")?>
    </td>
    <td valign="middle" title="<?=tr("The telephone of the contact")?>" class="<?=$cssStyle?>">
      <?=tr("Telephone Nr.")?>
    </td>
    <td valign="middle" title="<?=tr("The website of the contact")?>" class="<?=$cssStyle?>">
      <?=tr("Website")?>
    </td>
  </tr>

