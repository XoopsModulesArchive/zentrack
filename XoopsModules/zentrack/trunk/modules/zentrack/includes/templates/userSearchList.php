<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  
if( is_array($users) && count($users) ) {
 
   $c = count($users);
      ?>
        <table width="100%" cellspacing='1' cellpadding='2' bgcolor='<?php echo $zen->getSetting("color_alt_background"); ?>'>
        <tr><td class='titleCell' colspan="8" align='center'><?php echo ($c>1)? "$c ".tr("matches") : "1 ".tr("match");?></td></tr>
   <tr bgcolor="<?php echo $zen->getSetting("color_title_background"); ?>">
   <td width="32" height="25" valign="middle" title="<?php echo tr("Users System ID"); ?>">
     <div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>"><b><span class="small"><?php echo tr("ID"); ?></span></b></span></div>
   </td>
   <td height="25" valign="middle" title="<?php echo tr("The name of the user"); ?>">
     <div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>">
        <b><span class="small"><?php echo tr("Name"); ?></span></b></span></div>
   </td>
   <td height="25" valign="middle" title="<?php echo tr("Users Initials"); ?>">
     <div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>">
        <b><span class="small"><?php echo tr("Initials"); ?></span></b></span></div>
   </td>
   <td width="32" height="25" valign="middle" title="<?php echo tr("Default Access Level"); ?>">
     <div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>"><b><span class="small"><?php echo tr("Access"); ?></span></b></span></div>
   </td>
   <td height="25" valign="middle" title="<?php echo tr("Users email address"); ?>">
     <div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>">
        <b><span class="small"><?php echo tr("Email"); ?></span></b></span></div>
   </td>
     <td width="32" height="25" valign="middle" title="<?php echo tr("Account is Active"); ?>">
     <div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>">
             <b><span class="small"><?php echo tr("Active"); ?></span></b></span></div>
     </td>
     <td width="32" height="25" valign="middle" title="<?php echo tr("Users Default Bin"); ?>">
     <div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>">
             <b><span class="small"><?php echo tr("Home"); ?></span></b></span></div>
     </td>
     <td width="32" height="25" valign="middle" title="<?php echo tr("Administrative Options"); ?>">
     <div align="center"><span style="color:<?php echo $zen->getSetting("color_title_txt"); ?>">
             <b><span class="small"><?php echo tr("Options"); ?></span></b></span></div>
     </td>
   </tr>
      <?php      

   $text = $zen->getSetting("color_bar_text");
   $elnk = "$rootUrl/admin/editUser.php";
   $dlnk = "$rootUrl/admin/deleteUser.php";
   $alnk = "$rootUrl/admin/access.php";
//   $plnk = "$rootUrl/admin/resetPassword.php";

   foreach($users as $u) {
      unset($txt);
      unset($tx);
      unset($est);
      $row = ($row == $zen->getSetting("color_bars"))?
   $zen->getSetting("color_background") : $zen->getSetting("color_bars");
      $name = $zen->formatName($u,1);
      if( $search_text && ($search_fields["lname"] || $search_fields["fname"] ) ) {
   $name = $zen->highlight($name,$search_text);
      }
      $inits = $zen->formatName($u,2);
      if( $search_text && $search_fields["initials"] )
         $inits = $zen->highlight($inits,$search_text);
      if( $u["notes"] && $search_text && $search_fields["notes"] )
         $u["notes"] = $zen->highlight($u["notes"],$search_text);
      ?>

   <tr style="background:<?php echo $row?>;color:<?php echo $text?>">
   <td height="25" valign="middle">
     <?php echo $u["user_id"]?>
   </td>
   <td height="25" valign="middle">
     <?php echo $name?>
   </td>
   <td height="25" valign="middle">
     <?php echo $inits?>
        </td>
   <td height="25" valign="middle">
     <?php echo $u["access_level"]?>
        </td>
   <td height="25" valign="middle">
     <?php echo $u["email"]?>
        </td>
   <td height="25" valign="middle">
     <?php echo ($u["active"])? uptr("yes") : uptr("no"); ?>
        </td>
   <td height="25" valign="middle">
     <?php echo $zen->bins["$u[homebin]"]?>
        </td>  
   <td <?php echo ($u["notes"])? "rowspan='2'" : ""?> valign="middle">
     <span class="small">
     [<a href='<?php echo $elnk?>?user_id=<?php echo $u["user_id"]?>'><?php echo uptr("edit"); ?></a>]
     <br>
     [<a href='<?php echo $alnk?>?user_id=<?php echo $u["user_id"]?>'><?php echo uptr("access"); ?></a>]
     <br>
          [<a href='<?php echo $dlnk?>?user_id=<?php echo $u["user_id"]?>'
      onClick='return confirm("<?php echo tr("Permanently remove user ??",array($u["user_id"])); ?>");'
           ><span class='error'><?php echo uptr("delete"); ?></span></a>]
        </td>
        </tr>
   <?php 
   if( $u["notes"] ) {
   ?>
   <tr style="background:<?php echo $row?>;color:<?php echo $text?>">
        <td colspan="7" class="small">
      <?php echo $u["notes"]?>
   </td>
        </tr>
        <?php
      }
   }
  
   if( count($search_params) ) {
   ?>
    <tr>
     <form method="post" action="<?php echo $SCRIPT_NAME?>">
     <td colspan="8" class="titleCell">
   <input type="submit" class="smallSubmit" value="Modify Search">
   <input type="hidden" name="search_text" value="<?php echo strip_tags($search_text); ?>">
   <input type="hidden" name="search_fields[lname]" 
           value="<?php echo strip_tags($search_fields["lname"]); ?>">
   <input type="hidden" name="search_fields[fname]" 
           value="<?php echo strip_tags($search_fields["fname"]); ?>">
   <input type="hidden" name="search_fields[initials]" 
           value="<?php echo strip_tags($search_fields["initials"]); ?>">
   <input type="hidden" name="search_fields[notes]" 
           value="<?php echo strip_tags($search_fields["notes"]); ?>">
   <input type="hidden" name="search_access_method" 
           value="<?php echo strip_tags($search_access_method); ?>">      
        <?php
     foreach($search_params as $k=>$v) {
       print "<input type='hidden' name='search_params[$k]' value='".strip_tags($v)."'>\n";
          }
        ?>
     </td>
     </form>
    </tr>
  <?php } ?>
    </table>
   <?php   
}
?>
