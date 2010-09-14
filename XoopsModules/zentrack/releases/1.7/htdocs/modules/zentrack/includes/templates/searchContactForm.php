<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>


<form action="<?php echo ($SCRIPT_NAME); ?>" name="searchCompany">
<table>
<tr>
  <td colspan="3" class="subTitle" width="600">
    <?php echo tr("Search in company"); ?>
  </td>
</tr>
<tr>
	<td class="bars">
		<input type="hidden" name="TODO" value="SEARCH">
		<input type="hidden" name="table" value="company">
	</td>
	<td class="bars">
		<input type="text" name="search_text" 
      value="<?php echo $zen->ffv($search_text); ?>" size="25" maxlength="50">
	</td>
  <td class="bars">
     <input type="submit" class="submit" value="<?php echo tr("Search"); ?>">
  </td>
</tr>
</table>
</form>

<br>
<form action="<?php echo ($SCRIPT_NAME); ?>" name="searchEmployee">
<table>
<tr>
  <td colspan="3" class="subTitle" width="600">
    <?php echo tr("Search in persons"); ?>
  </td>
</tr>
<tr>
	<td class="bars">
		<input type="hidden" name="TODO" value="SEARCH">
		<input type="hidden" name="table" value="employee">
	</td>
	<td class="bars">
		<input type="text" name="search_text" 
      value="<?php echo $zen->ffv($search_text); ?>" size="25" maxlength="50">
	</td>
  <td class="bars">
     <input type="submit" class="submit" value="<?php echo tr("Search"); ?>">
  </td>
</tr>
</table>
</form>

<br>
<form action="<?php echo ($SCRIPT_NAME); ?>" name="searchAgreement">
<table>
<tr>
  <td colspan="3" class="subTitle" width="600">
    <?php echo tr("Search in agreements"); ?>
  </td>
</tr>
<tr>
	<td class="bars">
		<input type="hidden" name="TODO" value="SEARCH">
		<input type="hidden" name="table" value="agreement">
	</td>
	<td class="bars">
		<input type="text" name="search_text" 
      value="<?php echo $zen->ffv($search_text); ?>" size="25" maxlength="50">
	</td>
  <td class="bars">
     <input type="submit" class="submit" value="<?php echo tr("Search"); ?>">
  </td>
</tr>
</table>
</form>

<br>
<form action="<?php echo ($SCRIPT_NAME); ?>" name="searchItem">
<table>
<tr>
  <td colspan="3" class="subTitle" width="600">
    <?php echo tr("Search in items"); ?>
  </td>
</tr>
<tr>
	<td class="bars">
		<input type="hidden" name="TODO" value="SEARCH">
		<input type="hidden" name="table" value="item">
	</td>
	<td class="bars">
		<input type="text" name="search_text" 
      value="<?php echo $zen->ffv($search_text); ?>" size="25" maxlength="50">
	</td>
  <td class="bars">
     <input type="submit" class="submit" value="<?php echo tr("Search"); ?>">
  </td>
  
</tr>
</table>
</form>

