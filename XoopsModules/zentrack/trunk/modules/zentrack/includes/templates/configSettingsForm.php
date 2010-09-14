<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
      <br>
      <p><b><?php echo tr("Changing these settings can have a severe impact on the system.  Please consider this before making modifications."); ?></b></p>
      <p class='error'><?php
         $str = "<a href='$rootUrl/help/find.php?s=admin&p=settings'>".tr('Documentation')."</a>";
         print tr("Please refer to the ? before using this feature", array($str));
       ?></p>
      <p><?php echo tr("All entries must contain a value."); ?></p>

      <form name='configSettingsForm' action='<?php echo $SCRIPT_NAME?>' method='post' onSubmit='return confirm("Save system settings?")'>
      <table width="600" cellpadding="2" cellspacing="1" class='plainCell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='4'>
	   <b><?php echo tr("Edit Settings"); ?></b>
	 </td>
	 </tr>
	 <tr>
	 <td width="30" class='cell' align='center'><b><?php echo tr("ID"); ?></b></td>
	 <td width="45" class='cell' align='center'><b><?php echo tr("Name"); ?></b></td>
	 <td class='cell' align='center'><b><?php echo tr("Value"); ?></b></td>
	 <td class='cell' align='center'><b><?php echo tr("Description"); ?></b></td>
	 </tr>
    <?php 

    $on = tr("On");
    $off = tr("Off");
    foreach($settings as $s) {
      if( preg_match("#^url_#",$s["name"]) ) {
	$s["value"] = preg_replace("#^$rootUrl/?#i", "", $s["value"]);
      }
      $k = $s["setting_id"];
      $class = ($class == "bars")? "cell" : "bars";
      $n = preg_replace("@_xx$@", "", $s["name"]);
      print "<tr><td class='$class'>$k</td>\n";
      print "<td class='$class'>$n</td>\n";
      print "<td class='$class'>";
      if( preg_match("@_xx$@", $s["name"]) ) {
	print $s["value"]." [permanent]";
      } else if( $s["value"] == "on" || $s["value"] == "off" ) {
	print "<select name='newSettings[$k]'>";
	print ($s["value"] == "on")? 
	  "<option selected value='on'>$on</option>" : "<option value='on'>$on</option>\n";
	print ($s["value"] == "off")?
	  "<option selected value='off'>$off</option>" : "<option value='off'>$off</option>\n";
	print "</select>\n";
      } else {
	print "<input type='text' style='font-size:"
	   .$zen->getSetting("font_size_small")."px' name='newSettings[$k]' "
           ." size='20' maxlength='100' value='".$zen->ffv($s["value"])."'>";
      }
      print "</td>";
      print "<td class='$class'>$s[description]</td>\n";
      print "</tr>\n";
    }

    ?>
<tr>
  <td class="titleCell" colspan="4">
    <?php echo tr("Press 'Save' when you are sure that the values are correct."); ?>
    <br><?php echo tr("Press 'Reset' to restore the original values."); ?>
  </td>
</tr>
      <tr>
	 <td class='cell' colspan='4'>
          <input type='hidden' name='TODO' value='Save'>
	  <input type='submit' class='submit' value='<?php echo tr("Save"); ?>'>
	  </form>&nbsp;<form method='post' action='<?php echo $SCRIPT_NAME?>'>
	  <input type='submit' class='submitPlain' value='<?php echo tr("Reset"); ?>'>
          </form>
         </td>
      </tr>
      </table>







