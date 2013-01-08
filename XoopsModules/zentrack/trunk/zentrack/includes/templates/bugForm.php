<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form name='bugForm' method='post'>
<table>

<tr>
  <td class='titleCell' colspan='2'><?=tr('Submit a Bug to Zentrack Team')?></td>
</tr>

<tr>
  <td class='labelCell'>
    <?=tr('Name')?>
  </td>
  <td class='bars'>
    <input type='text' name='name' value='<?=$zen->ffv($name)?>' size='40' maxlength='200'> <span class='note'>(optional)</span>
  </td>
</tr>

<tr>
  <td class='labelCell'>
    <?=tr('Email')?>
  </td>
  <td class='bars'>
    <input type='text' name='email' value='<?=$zen->ffv($email)?>' size='40' maxlength='200'> <span class='note'>(optional)</span>
  </td>
</tr>

<tr>
  <td class='labelCell'>
    <?=tr('Page')?>
  </td>
  <td class='bars'>
    <input type='text' name='url' value='<?=$zen->ffv($url)?>' size='40' maxlength='200'> <span class='note'>(domain optional)</span>
  </td>
</tr>

<tr>
  <td class='labelCell'>
    <?=tr('Explanation')?>
  </td>
  <td class='bars'>
    <textarea cols='40' rows='8' name='message'><?=$zen->ffv($message)?></textarea>
  </td>
</tr>

<tr>
  <td class='labelCell'>
    <?=tr('User Info')?>
  </td>
  <td class='bars'>
    <textarea cols='40' rows='2' name='user_info'><?=$zen->ffv(strip_tags($user_info))?></textarea>
  </td>
</tr>

<tr>
  <td class='labelCell'>
    <?=tr('Debug Output')?>
  </td>
  <td class='bars'>
    <textarea cols='40' rows='8' name='debug_output'><?=$zen->ffv(strip_tags($debug_output))?></textarea>
  </td>
</tr>

<tr>
  <td colspan='2' class='subTitle'>
    <input type='submit' class='submit' name='submit' value='<?=tr('Send')?>'>
  </td>
</tr>

</table>
</form>