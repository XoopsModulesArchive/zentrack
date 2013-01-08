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
    <p>A Data Group is quite simply a list.</p>
    
    <p>It consists of a list of data type elements loaded from database, 
    a list of values manually typed in, or of a list of values created 
    dynamically by javascript code.</p>
    
    <p>You can view the existing data types and create new ones by browsing to:
    <br><b><?=tr('Admin')?> -&gt; 
           <?=tr('Settings Administration')?> -&gt;
           <?=tr('Edit Data Groups')?></b></p>
  </td>    
</tr>
<tr>
  <td class='titleCell'>Fields for a Data Group</td>
</tr>
<tr>
  <td class='cell'>  
    <table width='80%' align='center'>
    <tr>
      <td class='subTitle'>Field</td>
      <td class='subTitle'>Purpose</td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Table Name')?></td>
      <td class='bars'>
         Name of the data type table to reference.  Set this to custom
         if you will be entering values manually (instead of selecting them
         from the database list) or if you will be using javascript.
      </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Group Name')?></td>
      <td class='bars'>
        A descriptive name for your group, such as 'Priorities for Engineering'
      </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Description')?></td>
      <td class='bars'>
        Any comments or notes you need about this group.
      </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Eval Type')?></td>
      <td class='bars'>
        Use '<?=tr('Matches')?>' to select a list of entries from a database or
        to manually type in choices.
        
        <p>Use <?=tr('Javascript')?> to enter javascript code which will create
        the list of entries.
      </td>
    </tr>
    <tr>
      <td class='bars'><?=tr('Eval Script')?></td>
      <td class='bars'>
        This is only active when the <?=tr('Eval Type')?> is set to <?=tr('Javascript')?>.
        
        <p>Javascript can be pasted into this box directly as it will be evaluated.
        
        <p>See the section below on Javascript Lists for more info on this field.</p>
      </td>
    </tr>
    </table>

  </td>
</tr>
<tr>
  <td class='titleCell'>Data Type Lists</td>
</tr>
<tr>
  <td class='cell'>
    <p>A data type list is created by selecting the name of a table from the
    <?=tr('Table Name')?> field.  Once the data group is created, you may
    click on the <?=tr('Entries')?> link to select items from a list of
    valid entries.</p>
    
    <p>A data type list is the <b>preferred</b> way to use the data group
    feature.</p>
  </td>
</tr>
<tr>
  <td class='titleCell'>Custom (manually entered) Lists</td>
</tr>
<tr>
  <td class='cell'>
    <p>A custom list is created by selecting the '<?=tr('Custom')?>' option
    from the <?=tr('Table Name')?> field and '<?=tr('Matches')?>' from the
    <?=tr('Eval Type')?> field.
    
    <p>Once the data group is created, clicking on the 
    <?=tr('Entries')?> link will produce a menu where you
    can manually type in the choices that will appear.
    </p>
    
    <p>A custom list is <b>not advised</b> for use with any standard ticket
    fields, but is fine for use with the Variable Field values.
    </p>
  </td>
</tr>
<tr>
  <td class='titleCell'>Lists Created from Files</td>
</tr>
<tr>
  <td class='cell'>
    <p>By selecting the Eval Type of 'File', you can use the contents of a
    tab delimited text file to create data groups.  This feature is designed
    to be used with behaviors.
    
    <p>The file to be used should be placed in the zentrack/includes/user_data
    folder.
    
    <p>Once this is completed, the rest of the work is done from the behaviors
    screen.
  </td>
</tr>
<tr>
  <td class='titleCell'>Javascript Lists</td>
</tr>
<tr>
  <td class='cell'>
    <p class='error'>Javascript lists should always be used with a great deal of caution, and
    are not recommended for anyone without extensive programming experience.</p>
    
    <p>Javascript lists are created by selecting the '<?=tr('Custom')?>' option
    from the <?=tr('Table Name')?> field and '<?=tr('Javascript')?>' from the
    <?=tr('Eval Type')?> field.</p>
    
    <p>You will not use the <?=tr('Entries')?> link with Javascript lists.
    
    <p>The special property <b>{form}</b> can be used as a pointer to the current
    form object (it gets translated to window.document.formName during 
    evaluation).  This is useful for pointing to other fields in the form
    using javascript.</p>
    
    <p>The special property <b>{field}</b> can be used as a pointer to the current
    field object (it gets translated to window.document.formName.fieldName).
    This can be useful for using the same javascript in multiple behaviors
    (behaviors are discussed in the next section).
    
    <p>The javascript code is expected to create an array named <b>x</b> which
    will contain a <b>simple array</b> of values or an <b>array of objects</b>
    with two properties:  label and value. 
    
    <p>Here are some examples:</p>
    
    <table width='80%' align='center'>
      <tr>
        <td class='subTitle'>Example 1: Simple Array</td>
      </tr>
      <tr>
        <td class='bars'>
<pre>
<b>This javascript code:</b>
var x = new Array();
for(i=1; i &lt; 4; i++) {
  //each entry is just the value of i
  x[ x.length ] = i;
}

<b>Would create:</b>
  [ 1, 2, 3 ]

<b>Thus, a menu using these values would get:</b>
  &lt;option value='1'&gt;1&lt;/option&gt;
  &lt;option value='2'&gt;2&lt;/option&gt;
  &lt;option value='3'&gt;3&lt;/option&gt;
 
<b>A text field using these values would just get:</b>
  &lt;input type='...' value='1'&gt;
</pre>
        </td>
      </tr>
    </table>

    <p>A more complex example:</p>
    
    <table width='80%' align='center'>
      <tr>
        <td class='subTitle'>Example 2: Object Array</td>
      </tr>
      <tr>
        <td class='bars'>
<pre>
<b>This Code:</b>
var x = new Array();
for(i=1; i &lt; 4; i++) {
  //each value is an object with a label and value
  x[ x.length ] = { label:'item_'+i, value:i };
}

<b>Would create:</b>
[
   [ 'item_1', 1 ],
   [ 'item_2', 2 ],
   [ 'item_3', 3 ]
]

<b>Thus, a menu using these values would get:</b>
  &lt;option value='1'&gt;item_1&lt;/option&gt;
  &lt;option value='2'&gt;item_2&lt;/option&gt;
  &lt;option value='3'&gt;item_3&lt;/option&gt;
 
<b>A text field using these values would just get:</b>
  &lt;input type='...' value='1'&gt;
</pre>
        </td>
      </tr>
    </table>
    
    <p>Using the {form} property:</p>
    
    <table width='80%' align='center'>
      <tr>
        <td class='subTitle'>Example 3: The {form} property</td>
      </tr>
      <tr>
        <td class='bars'>
<pre>
<b>Assuming that:</b>
  &lt;input type='text' name='custom_number1' value='10'&gt;
  
<b>This Code:</b>
var x = new Array();
var x[0] = {form}.custom_number1 + 20;

<b>Would Create:</b>
[ 30 ]

<b>Thus, a menu using these values would get:</b>
  &lt;option value='30'&gt;30&lt;/option&gt;

<b>A text field using these values would just get:</b>
 &lt;input type='...' value='30'&gt;

</pre>
        </td>
      </tr>
    </table>
    
    
    <p>A very complex example:</p>
    
    <table width='80%' align='center'>
      <tr>
        <td class='subTitle'>Example 4: Very complex javascript replace</td>
      </tr>
      <tr>
        <td class='bars'>
<pre>
<b>Assuming that:</b>
  &lt;select name='priority&gt;
    &lt;option value='1'&gt;high&lt;/option&gt;
    &lt;option value='2'&gt;medium&lt;/option&gt;
    &lt;option value='3'&gt;low&lt;/option&gt;
  &lt;/select&gt;
  
  &lt;input type='text' name='custom_string_1' value='aaaa'&gt;
  &lt;input type='text' name='custom_string_2' value='bbbb'&gt;
  
<b>This Code:</b>
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
  for( var i=0; i &lt; options.length; i++ ) {
    // insert each value of the existing menu 
    // into our new array
    x[ x.length ] = 
      { label:options[i].text, value:options[i].value };
  
    // make sure the menu doesn't already contain our field 
    // values, if so, then make sure we don't add them again
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
  
  // now when this is evaluated, the array x will 
  // contain the existing menu values plus anything 
  // we have added via the custom_string fields!  

<b>Would Create:</b>
[
  { label:'high',   value:1 }
  { label:'medium', value:2 }
  { label:'low',    value:3 }
  [ aaaa ]
  [ bbbb ]
]

<b>Thus, a menu using these values would get:</b>
    &lt;option value='1'&gt;high&lt;/option&gt;
    &lt;option value='2'&gt;medium&lt;/option&gt;
    &lt;option value='3'&gt;low&lt;/option&gt;
    &lt;option value='aaaa'&gt;aaaa&lt;/option&gt;
    &lt;option value='bbbb'&gt;bbbb&lt;/option&gt;

<b>A text field using these values would just get:</b>
 &lt;input type='...' value='1'&gt;
 (not really useful here)
</pre>
        </td>
      </tr>
    </table>

    
  </td>
</tr>
</table>

<?php
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
