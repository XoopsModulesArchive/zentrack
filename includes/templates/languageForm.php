<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<form method="post" action="<?=$rootUrl?>/misc/language.php">

<table width="300" cellpadding="5">
<tr>
  <td colspan="2" class="subTitle" align="center" height="20">
    <b><?=tr("Change Your Language")?></b>
  </td>
</tr>
<tr>
  <td class="bars">
    <b><?=tr("New Language")?></b>
  </td>
  <td class="bars">
    <select name="newlang">
        <?php
   $languages = get_languages_available();
   foreach($languages as $l) {
     $txt = ucwords($l);
     $sel = ($login_language == $l)? " selected" : "";
     print "<option value='$l'$sel>$txt</option>\n";
   }
?>
    </select>
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
    <input type="submit" value="<?=tr("Update Language")?>" class="submit">
  </td>
</tr>
</table>

<input type="hidden" name="TODO" value="LANG">
</form>


