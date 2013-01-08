<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->getSetting("color_background")?>">

<?php
   include("$templateDir/reportsTypeMenu.php");
   include("$templateDir/reportsDataMenu.php"); 
   include("$templateDir/reportsDateMenu.php"); 
   include("$templateDir/reportsOptionsMenu.php"); 
   include("$templateDir/reportsSubmit.php"); 
?>

</table>
</form>
