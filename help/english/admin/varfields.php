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
    <p>Variable fields are fields which can be defined by your organization to
    meet special needs.</p>
    
    <p>Variable fields can be boolean (checkboxes), numbers, strings 
    (text fields), large text areas, or dates.</p>
    
    <p>Variable fields can be maintained by going to:
    <br><?=tr('Admin')?> -&gt; <?=tr('Ticket Administration')?> -&gt; <?=tr('Edit Variable Fields')?>.
  </td>
</tr>
<tr>
  <td class='titleCell'>Variable Field Table</td>
</tr>
<tr>
  <td class='cell'>
    <p class='error'>Either Projects or Tickets column must always be checked
    or the variable field will not be visible anywhere.</p>
    
    The following is a description of the fields in the Variable Field maintenance
    page and how to configure them:
     <table width='80%' align='center'>
      <tr>
        <td class='subTitle'>Field</td>
        <td class='subTitle'>Description</td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Field Name')?></td>
        <td class='bars'>
          must match column in database
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Field Label')?></td>
        <td class='bars'>
          text to display to users of the system
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Order')?></td>
        <td class='bars'>
          display order for the variable fields (defaults to label)
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Default')?></td>
        <td class='bars'>
          default value for this field (a valid string)
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Required')?></td>
        <td class='bars'>
          is this field required?
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Projects')?></td>
        <td class='bars'>
          display this field in projects 
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Tickets')?></td>
        <td class='bars'>
          display this field in tickets
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Searches')?></td>
        <td class='bars'>
          show this field in search window
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Lists')?></td>
        <td class='bars'>
          not used (reserved for future use)
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Custom')?></td>
        <td class='bars'>
          show this field in custom tab
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('Details')?></td>
        <td class='bars'>
          show this field in details tab
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('New')?></td>
        <td class='bars'>
          show this field in '<?=tr('Create New')?>' window
        </td>
      </tr>
      <tr>
        <td class='bars'><?=tr('JS Validation')?></td>
        <td class='bars'>
          not used (reserved for future use)
        </td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td class='titleCell'>Adding New Variable Fields</td>
</tr>
<tr>
  <td class='cell'>
    <p class='error'>This task requires a good understanding of Relational
    Databases.  Do not attempt this if you are not experienced.  Instead, 
    contact the project team and ask for assistance.</p>
    
    <p>Columns added to the ZENTRACK_VARFIELD table must be named in the
    format custom_ttttXX where tttt represents the type (menu, string,
    number, boolean, date, or text) and XX represents the consecutive number
    (you cannot skip any numbers).
    
    <p>For our examples here, we will assume we want to create the new field
    <b>custom_menu3</b>.</p>
    
    <p><b>Step 1: BACKUP DATABASE</b></p>
    <p>Create a backup of anything in your database you desire to keep.</p>
    
    <p><b>Step 2: Open SQL Interface of your choice</b></p>
    
    <p><b>Step 3: Create database column</b></p>
    <p>Run the equivalent command for your database:
    <br>alter table ZENTRACK_VARFIELD add column custom_menu3 varchar(255);
    
    <p><b>Step 4: Insert a new row into ZENTRACK_VARFIELD_IDX</b></p>
    <p>Run the following command for your database:
    <br>insert into ZENTRACK_VARFIELD_IDX (field_name, field_label) VALUES('custom_menu3', 'Custom Menu 3');
    
    <p><b>Step 5: Log into zentrack</b></p>
    <p>You must close your browser windows and open a new window.  Login as
    Administrator.
    
    <p><b>Step 6: Edit Varfield Settings</b></p>
    <p>Browse to the Varfield settings and update your new field properties.
  </td>
</tr>
</table>
<?php
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
