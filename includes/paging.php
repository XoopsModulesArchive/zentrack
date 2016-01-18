<?php if( !ZT_DEFINED ) { die("Illegal Access"); }
   $hotkeys->loadSection('paging');
   $GLOBALS['zt_hotkeys'] = $hotkeys;
?>
<!--- BEGIN Paging --->

<table width='100%'>
<tr>
   <td  align="right" valign='bottom' style="background:<?=$zen->getSetting("color_bars")?>;">
       <?php
       $links = $zen->get_links("all", "off");
       for ($y = 0; $y < count($links); $y++) {
          echo $links[$y] . "&nbsp;&nbsp;";
       }
     ?>
   </td>
</tr>
</table>

<!--- END Paging --->

