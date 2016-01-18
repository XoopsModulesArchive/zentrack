<?php
  $b = dirname(__FILE__);
  include("$b/admin_header.php");
?>

<table align='center' width='80%'>
<tr>
  <td class='titleCell'>Description</td>
</tr>
<tr>
  <td class='cell'>
    Data types represent properties of tickets which the administrator is
    allowed to manipulate the list of possible choices for.
    
    <p>A <?=tr('Bin')?> (discussed in the previous section) is an example of
    a data type.
    
    <p>Data types can be maintained by going to 
      <b><?=tr('Admin')?> -&gt; <?=tr('Data Types')?></b> and choosing the appropriate
      data type to edit.
      
    <p>The '<?=tr('Order')?>' column can be used to control the order in which
    items are listed.  The first item in the list will be the default when
    this data type appears in a select menu.</p>
  </td>    
</tr>
<tr>
  <td class='titleCell'>Removing Entries from Data Types</td>
</tr>
<tr>
  <td class='cell'>
    <p class='error'>Once created, entries in the data types tables cannot 
    be destroyed</p>
    
    <p>This is to insure that old data is not compromised by removing a data
    type which is referenced elsewhere in the system.</p>
    
    <p>Luckily, all is not lost.  Disaster can be averted by renaming the
    bin to something more useful or by unchecking the '<?=tr('Active')?>' 
    checkbox, which will prevent the bin from being used in the future.</p>
  </td>
</tr>
<tr>
  <td class='titleCell'>Priorities</td>
</tr>
<tr>
  <td class='cell'>
    <p>The priority entries must all have a sort order.  The orders should be
    consecutive.
    
    <p>Items which are inactive do not need a sort order, they will be ignored.
    
    <p>If the priority colors do not seem to work right, always check the ordering
    for the priority items.
  </td>
</tr>
</table>

<?php
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
