<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form name='bugForm' method='post'>
<table>

<tr>
  <td class='titleCell' colspan='2'><?php echo tr('Submit a Bug to Zentrack Team'); ?></td>
</tr>

<tr>
  <td class='labelCell'>
    <?php echo tr('Name'); ?>
  </td>
  <td class='bars'>
    <input type='text' name='name' value='<?php echo $zen->ffv($name); ?>' size='40' maxlength='200'> <span class='note'>(optional)</span>
  </td>
</tr>

<tr>
  <td class='labelCell'>
    <?php echo tr('Email'); ?>
  </td>
  <td class='bars'>
    <input type='text' name='email' value='<?php echo $zen->ffv($email); ?>' size='40' maxlength='200'> <span class='note'>(optional)</span>
  </td>
</tr>

<tr>
  <td class='labelCell'>
    <?php echo tr('Page'); ?>
  </td>
  <td class='bars'>
    <input type='text' name='url' value='<?php echo $zen->ffv($url); ?>' size='40' maxlength='200'> <span class='note'>(domain optional)</span>
  </td>
</tr>

<tr>
  <td class='labelCell'>
    <?php echo tr('Explanation'); ?>
  </td>
  <td class='bars'>
    <textarea cols='40' rows='8' name='message'><?php echo $zen->ffv($message); ?></textarea>
  </td>
</tr>

<tr>
  <td class='labelCell'>
    <?php echo tr('User Info'); ?>
  </td>
  <td class='bars'>
    <textarea cols='40' rows='2' name='user_info'><?php echo $zen->ffv(strip_tags($user_info)); ?></textarea>
  </td>
</tr>

<tr>
  <td class='labelCell'>
    <?php echo tr('Debug Output'); ?>
  </td>
  <td class='bars'>
    <textarea cols='40' rows='8' name='debug_output'><?php echo $zen->ffv(strip_tags($debug_output)); ?></textarea>
  </td>
</tr>

<tr>
  <td colspan='2' class='subTitle'>
    <input type='submit' class='submit' name='submit' value='<?php echo tr('Send'); ?>'>
  </td>
</tr>

</table>
</form>