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
    Behaviors are a method of placing dynamic values into forms based on what
    the user selects from other fields.
    
    <p>There are two basic ways to use behaviors.  The values loaded by a 
    behavior will come from a <?=tr('Data Group')?> (discussed in the 
    <a href='<?=$adminUrl?>/data_groups.php'>previous section</a>), and can
    be loaded from the database values or from javascript code.
    
    <p><b>Behaviors are not secure.</b>  They should not be relied upon to
    prevent or enforce user interaction with the system. They are only 
    meant as a helpful tool to present useful choices to the user, since
    they can be overcome by disabling javascript from the browser.
    
    <p>It is very IMPORTANT to avoid overlapping the conditions and target
    fields of behaviors in overly complex ways.  See the notes below on
    '<?=tr('Field to change')?>' for more details.
  </td>
</tr>
<tr>
  <td class='titleCell'>Creating a Behavior</td>
</tr>
<tr>
  <td class='cell'>
    Behaviors can be found on the nav menu:  <?=tr('Admin')?> 
    -&gt; <?=tr('Settings Administration')?> 
    -&gt; <?=tr('Edit Behaviors')?>.
    
    <p>Choosing the '<?=tr('New')?>' button will bring up the form to create
    new behaviors.
    
    <p>The fields in the behavior form are detailed below.
  </td>
</tr>
<tr>
  <td class='titleCell'>Behavior Fields</td>
</tr>
<tr>
  <td class='cell'>
    <table align='center' width='80%'>
    <tr>
      <td class='subTitle' align='center'>
      Field
      </td>
      <td class='subTitle' align='center'>
      Purpose
      </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Name')?></td>
      <td class='bars'>A quick description of this behavior, such as "Priority Switcher"</td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Active')?></td>
      <td class='bars'>If unchecked, this behavior will be ignored</td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Data Group')?></td>
      <td class='bars'>This is the group of values that will be switched if this behavior runs.</td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Sort Order')?></td>
      <td class='bars'>
         This controls the order that the behaviors will be run.
         
         <p>It is very important to order these correctly, since two behaviors
         cannot be run on the same field at the same time(more on this below).
       </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Field to change')?></td>
      <td class='bars'>
        This is the ticket field that will be targeted by
        the behavior and recieve the new ticket fields.
        
        <p>Consider your target fields carefully.  The target fields for one
        behavior should be used with great caution as the rules for another
        behavior.
        
        <p>Consider, for instance, if I have one behavior which alters the
        bin each time the priority is updated and another which alters the
        priority each time the bin is updated.  This may not produce a very
        desirable result.
        
        <p>However, they will not produce an infinite loop.  Once the field
        is modified, any other behaviors which attempt to come in and modify
        the value of the same field again will be ignored.  Thus the importance
        of the <?=tr('Sort Order')?>(above)!
        
        <p>If the <?=tr('Field to change')?> is set to a <b>text field</b> (a form field
        which can only hold one entry) the first element of the list created will
        be placed here and the rest will be discarded.
      </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Field is enabled')?></td>
      <td class='bars'>
        This checkbox affects the disabled status of the target form field.
        
        <p>If this box is checked, then the field will be enabled by the behavior
        when it runs.  If the box is not checked, then the form field will
        be disabled by the behavior when it runs.
      </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Match Type')?></td>
      <td class='bars'>
        Used to determine how we will match rules for this behavior.  
        
        <p>If this is set to <b>'<?=tr('Match Any')?>'</b>, then the rules for 
        this behavior are evaluated using an 'OR' condition.  Thus, matching 
        any one rule will trigger the behavior.
        
        <p>If this is set to <b>'<?=tr('Match All')?>'</b>, then the rules for
        this behavior are evaluated using an 'AND' condition.  Thus, all
        rules must be met before the behavior will trigger.
      </td>
    </tr>
    </table>
  </td>
</tr>
<tr>
  <td class='titleCell'>Behavior Rules</td>
</tr>
<tr>
  <td class='cell'>
     The behavior rules specify conditions which must be met before this
     behavior is run.  Once one or all of these conditions are
     true (based on the '<?=tr('Match Type')?>' property), then this behavior
     will be evaluated and the new values loaded.
     
     <p>The rules can match the id or the text values from other menus, so
     it is safe to use the names of Bins, Priorities, and other data types
     in place of their ids as desired.
     
     <p>The '<?=tr('Compare Value')?>' field may be left blank to match empty
     strings or null values.  The '<?=tr('Sort Order')?>' is used to determine
     which order the rules will be evaluated.
   </td>
</tr>
<tr>
  <td class='titleCell'>File Based Behaviors</td>
</tr>
<tr>
  <td class='cell'>
     <p>File based behaviors use columns for a tab delimited file to specify
     the rules (conditions) which must be met, and which values will be used.
     
     <p>Let's assume that we want to create a new behavior that will change the
     priorities which can be selected based on the bin and type of issue.  We
     will call this the 'Priority Behavior' for now.
     
     <p>Consider the following rules in our behavior:
     <table width='80%' align='center'>
      <tr>
        <td colspan='3' class='labelCell' align='center'>Rules</td>
      </tr>
      <tr>
        <td class='subTitle'>Compare Field</td>
        <td class='subTitle'>Column Number</td>
      </tr>
      <tr>
        <td class='bars'>-value column-</td>
        <td class='bars'>3</td>
     </tr>
      <tr>
        <td class='bars'>type_id</td>
        <td class='bars'>1</td>
     </tr>
      <tr>
        <td class='bars'>bin_id</td>
        <td class='bars'>2</td>
     </tr>
     </table>
     
     <p>These rules would tell us that column 1 of our file will be matched against
     the type_id, that column 2 will be matched against the bin_id.  If both of
     these conditions are met, then whatever appears in column 3 will added to 
     the list of values which will appear in the priority dropdown. 
     
     <p>If we have the following data in our tab delimited file:
     <table width='80%' align='center'>
      <tr>
        <td colspan='3' class='labelCell' align='center'>Data</td>
      </tr>
      <tr>
        <td class='subTitle'>Column 1</td>
        <td class='subTitle'>Column 2</td>
        <td class='subTitle'>Column 3</td>
      </tr>
      <tr>
        <td class='bars'>Project</td>
        <td class='bars'>Engineering</td>
        <td class='bars'>First</td>
     </tr>
      <tr>
        <td class='bars'>Project</td>
        <td class='bars'>Engineering</td>
        <td class='bars'>Second</td>
     </tr>
      <tr>
        <td class='bars'>Project</td>
        <td class='bars'>Tech Support</td>
        <td class='bars'>Customer Down</td>
     </tr>
      <tr>
        <td class='bars'>Project</td>
        <td class='bars'>Tech Support</td>
        <td class='bars'>Normal</td>
     </tr>
      <tr>
        <td class='bars'>Bug</td>
        <td class='bars'>Engineering</td>
        <td class='bars'>High</td>
     </tr>
      <tr>
        <td class='bars'>Bug</td>
        <td class='bars'>Engineering</td>
        <td class='bars'>Low</td>
     </tr>
     </table>
     
     <p>This data would produce the list or priorities First and Second any time
     that we create a Project in the Engineering bin.  Alternately, if we move
     this project to the Tech Support team, the priority list would shift to
     Customer Down and Normal.
     
     <p>However, if we change this to a bug, the Engineering team would have
     the priorities High and Low to choose from.
     
     <p>Note that, <b>since our file does not cover all possible combinations, we
     would want to create a 'backup' behavior to handle all other cases</b>.  We
     would give this lower priority (by giving it a higher sort order) and tell
     it to match anything which equals '' or does not equal '' (basically this
     means match anything at all).
     
     <p>If our Priority Behavior fell through, then this behavior would get run
     and would be expected to set the list of priorities to some sort of default set.
  </td>
</tr>
<tr>
  <td class='titleCell'>A Crash Course in Behaviors</td>
</tr>
<tr>
  <td class='cell'>
    What follows is an example of how to set up two behaviors.  One which
    relies on database fields for values and one which generates values using
    javascript.
    
<pre>
What follows is a simple step-by-step example of how to 
create a "Match" behavior and how to create a "Javascript" 
behavior and how to use them together.

<b>Step 1: Enable debugging</b>
  - Open www/header.php
  - Set $Debug_Mode = 3;
  - Save

<b>Step 2: Log in as Administrator</b>

<b>Step 3: Create some variable fields (so we can use them for javascript)</b>
  - Go to Admin -> Ticket Administration -> Edit Variable Fields
  - Find the custom_string1 and custom_string2 fields:
      Change names to "Extra Priority 1" and "Extra Priority 2" respectively
      Check the following boxes:  Tickets, New
      Make sure the default is blank

<b>Step 4: Create a Group</b>
  - Go to Admin -> Settings Administration -> Edit Data Groups
  - Click on New
     Table Name: Priorities
     Group Name: Pri Set 1
     Description: Loads some priorities for fun
     Eval Type:  Matches
	  Eval Script: -blank-
  - Create Group
  - Edit Entries for Group
     Check several entries and save results
     
<b>Step 5: Create another group</b>
  - Go to Admin -> Settings Administration -> Edit Data Groups
  - Click on New
    Table Name: Priorities
    Group Name: Pri Set 2
    Description: Adds custom fields to priority list
    Eval Type: Javascript
    Eval Script:
      // this script adds values placed in custom_string1 
      // and custom_string2 to the priorities dropdown
      
      // create our array which will be used to populate fields
      var x = new Array();
      
      // shortcut to the options in the priority menu
      var options = {form}.priority.options;
      
      // shortcut to value of custom_string fields
      var f1 = {form}.custom_string1.value;
      var f2 = {form}.custom_string2.value;
      
      // recreate menu with existing values
      for( var i=0; i < options.length; i++ ) {
        // insert each value of the existing menu into our new array
        x[ x.length ] = { label:options[i].text, value:options[i].value };
        
        // make sure the menu doesn't already contain our field values, if so,
        // then make sure we don't add them again
        if( options[i].value == f1 ) { f1 = null; }
        if( options[i].value == f2 ) { f2 = null; }
      }
      
      // add values of our custom fields to the array
      if( f1 ) {
        x[ x.length ] = f1;
      }
      if( f2 ) {
        x[ x.length ] = f2;
      }
      
      // now when this is evaluated, the array x will contain 
      // the existing menu values plus anything we have 
      // added via the custom_string fields!  
  - Create Group
  - DO NOT edit entries for the group
  
  
<b>Step 6: Create Behavior for when custom_strings are NOT empty</b>
  - Go to Admin -> Settings Administration -> Edit Behaviors
  - Click on New
    Behavior Name: priority set 2
    Active: checked
    Data Group: Pri Set 2
    Sort Order: 10
    Field to Change: Priority
    Field is Enabled: checked
    Match Type:  	Match ANY Rules
  - Create Behavior
  - Edit Matches
     Row 1
     -----
     Compare Field: Custom String 1
     Operator: Not Equal
     Compare Value: [leave this blank]
     Sort Order: 1
     
     Row 2
     -----
     Compare Field: Custom String 2
     Operator: Not Equal
     Compare Value: [leave this blank]
     Sort Order: 2
   - Save

<b>Step 7: Create Behavior for when custom_strings are empty</b>
  - Go to Admin -> Settings Administration -> Edit Behaviors
  - Click on New
    Behavior Name: priority set 1
    Active: checked
    Data Group: Pri Set 1
    Sort Order: 20
    Field to Change: Priority
    Field is Enabled: checked
    Match Type:  	Match ALL Rules
  - Create Behavior
  - Edit Matches
     Row 1
     -----
     Compare Field: Custom String 1
     Operator: Equals
     Compare Value: [leave this blank]
     Sort Order: 1
     
     Row 2
     -----
     Compare Field: Custom String 2
     Operator: Equals
     Compare Value: [leave this blank]
     Sort Order: 2
   - Save

<b>Step 8: Test results</b>
  - Go to Ticket -> Create New
  - Examine the Priorities Menu
  - Check the behavior output at the base of page 
    (it is updated dynamically each time a behavior runs)
  - Enter text into other_string1
  - Enter text into other_string2
  - Examine the Priorities Menu
  - Check behavior output
  - Change values of other_string1 or 2 as desired 
    and note results
  
<b>Result:</b>
  * You will see that when the page initially loads, the 
    priorities are switched to Pri Set 1 because the 
    custom_string1 is empty  
  * You will note that when the custom_string1 and 
    custom_string2 values are changed, the menu options 
    are updated with these values.
</pre>
  </td>
</tr>
</table>

<?php
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
