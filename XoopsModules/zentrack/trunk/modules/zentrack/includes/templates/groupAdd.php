<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }

  // generate some text to display based on whether this
  // is an edit page or an add page
  $td = ($TODO == 'EDIT');
  $blurb = ($td)? "Modify Data Group" : "Create New Data Group";
  $button = ($td)? "Save Changes" : "Create Group";
  $url = ($td)? "edit" : "add";
?>
<form method="post" action="<?php echo $rootUrl?>/admin/<?php echo $url?>GroupSubmit.php" name='groupAddForm'>
<?php if( $td ) { print "<input type='hidden' name='group_id' value='".$zen->ffv($group_id)."'>\n"; } ?>
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?php echo $zen->getSetting("color_background"); ?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
  <?php echo $blurb?>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    <?php echo tr("Group Information"); ?> (<?php echo tr("* = required"); ?>)
  </td>
</tr>  
<tr>
  <td class="bars">
    <?php echo tr("Table Name"); ?>*
  </td>
    <?php
    $t = "\t<td class='bars'>";
    $te = "</td>\n";
    $tables=$zen->getDataGroupTablesArray();
    print "$t<select name='NewTableName'>\n";
    foreach($tables as $tbl_k=>$tbl_v) {
      $sel=($group['table_name']==$tbl_v)? " selected" : "";
      print "<option value='$tbl_v'$sel>$tbl_k</option>\n";
    }
    print "$te";
    ?>
  </td>
</tr>
<tr>
  <td class="bars">
    <?php echo tr("Group Name"); ?>*
  </td>
  <td class="bars">
    <input type="text" name="NewGroupName" value="<?php echo $zen->ffv($group['group_name']); ?>" size="40" maxlength="100">
  </td>
</tr>
<tr>
  <td class="bars">
    <?php echo tr("Description"); ?>
  </td>
  <td class="bars">
    <input type="text" name="NewDescript" value="<?php echo $zen->ffv($group['descript']); ?>" size="40" maxlength="255">
  </td>
</tr>
<tr>
  <td class="bars">
    <?php echo tr("Eval Type"); ?>
  </td>
  <td class="bars">
    <select name='NewEvalType' onChange='toggleFields(this)' onBlur='toggleFields(this)'>
      <option<?php echo $group['eval_type'] == 'Matches'? ' selected':''?>>Matches</option>
      <option<?php echo $group['eval_type'] == 'Javascript'? ' selected':''?>>Javascript</option>
      <option<?php echo $group['eval_type'] == 'File'? ' selected':''?>>File</option>
    </select>
  </td>
</tr>
<tr>
  <td class='bars'>
    <?php echo tr('File Name'); ?>
  </td>
  <td class='bars'>
    <input
       <?php 
       if( $group && $group['eval_type'] == 'File' ) { print "class='input'"; }
       else { print "class='inputDisabled' disabled='disabled'"; }
       ?>
       type='text' name='name_of_file' 
       maxlength='100' value='<?php echo $zen->ffv($group['name_of_file']); ?>'>
       <span class='note'>
       <br>Place file in <?php echo $libDir?>/user_data
       <br>Valid characters: letters, numbers, symbols (_.-)
       <br>Samples: myfile.txt, a_file_name.data, some-file
       </span>
  </td>
</tr>
<tr>
  <td class="bars">
    <?php echo tr("Eval Script"); ?>
  </td>
  <td class="bars">
    <textarea name='NewEvalText' cols='50' rows='4'
      <?php 
       if( $group && $group['eval_type'] == 'Javascript' ) { print "class='input'"; }
       else { print "class='inputDisabled' disabled='disabled'"; }
      ?>><?php echo $zen->ffv($group['eval_text']); ?></textarea>
      <span class='note'>
      <br>Enter valid javascript only, comments are fine.
      <br>Do not enter &lt;script&gt; tags.  The following variables are valid:
      <br>&nbsp;&nbsp;{form} - evaluates to window.document.CurrentFormName
      
      </span>
  </td>
</tr>
<tr>
  <td class='bars'>
    <?php echo tr('Optional'); ?>
  </td>
  <td class='bars'>
    <input type='checkbox' name='include_none' value='1' <?php echo $group['include_none']? ' checked' : ''?>>
    <br><span class='note'>Checking this will create a -none- option in addition
    to the listed items</span>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    <?php echo tr("Click ? to ?",array($button,$blurb)); ?>.
  </td>
</tr>  
<tr>
  <td colspan="2" class="bars">
   <input type="submit" value="<?php echo $button?>" class="submit">
  </td>
</tr>
</table>

</form>
<script language='javascript'>
   function toggleFields( selectObj ) {
     var selectedText = selectObj.options[ selectObj.selectedIndex ].text; 
     toggleField( window.document.groupAddForm.NewEvalText, selectedText != 'Javascript' );
     toggleField( window.document.groupAddForm.name_of_file, selectedText != 'File' );
   }
</script>