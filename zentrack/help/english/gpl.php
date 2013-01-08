<?php
  $b = dirname(dirname(__FILE__));
  include_once("$b/help_header.php");

  $page_title = "GPL 2.0 License";
  include("$libDir/nav.php");
?>
<br>
<table width="500" align="center">
<tr>
<td>

<?php print nl2br(join("\n",file("$libDir/misc/LICENSE-GPL-2.0"))); ?>

</td>
</tr>
</table>
<?php
  include("$libDir/footer.php");
?>













