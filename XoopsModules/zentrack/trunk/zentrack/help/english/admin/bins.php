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
    Bins are used to organize tickets into logical groups and to control
    user access to view and edit tickets.
    
    <p>A bin can represent a department, work team, or other organizational
    structure for your business.</p>
    
    <p>Bins are maintained by going to 
      <br><b><?=tr('Admin')?> -&gt;
      <?=tr('Data Types')?> -&gt;
      <?=tr('Bins')?></b></p>
    
    <p>Access to bins is controlled by going to: 
      <br><b><?=tr('Admin')?> -&gt;
      <?=tr('Edit Users')?> -&gt;
      Find User to Edit  -&gt;
      Access Link</b></p>
  </td>
</tr>
<tr>
  <td class='titleCell'>Creating and Editing Bins</td>
</tr>
<tr>
  <td class='cell'>
    Great care should be taken when creating and editing bins.
    
    <p class='error'>Once a bin has been created, it cannot be destroyed.</p>
    
    <p>See the Data Types documentation (
    <a href='<?=$adminUrl?>/data_types.php'>next section</a>) 
    for more info about Removing Old Data Types.</p>
    
  </td>
</tr>
<tr>
  <td class='titleCell'>Setting Up Access: A Case Study</td>
</tr>
<tr>
  <td class='cell'>
    <p>What follows is a simple example of how to create a fairly complex
    set of bins and access priviledges for a small group of users.</p>
    
    <p>Our test company, hereafter called 'Test Company A' (the creativity! the
    pure genius!) contains three distinct groups, represented by the following
    sample of employees:</p>
    
    <table width='80%' align='center'>
    <tr>
      <td colspan='3' class='labelCell' align='center'>User Sample</td>
    </tr>
    <tr>
      <td class='subTitle'>Name</td>
      <td class='subTitle'>Job</td>
      <td class='subTitle'>Notes</td>
    </tr>
    <tr>
      <td class='bars'>Jack</td>
      <td class='bars'>Manager</td>
      <td class='bars'>Manages both John and Mark</td>
    </tr>
    <tr>
      <td class='bars'>John</td>
      <td class='bars'>Salesman</td>
      <td class='bars'>Uses tracking system to monitor customer licenses and contracts.</td>
    </tr>
    <tr>
      <td class='bars'>Mark</td>
      <td class='bars'>Programmer</td>
      <td class='bars'>Develops software, provides high level support for
           customer support group, hates salesmen like demon spawn.</td>
    </tr>
    <tr>
      <td class='bars'>Sue</td>
      <td class='bars'>Customer Support</td>
      <td class='bars'>Takes phone calls and creates issues for Salesmen and Developers</td>
    </tr>
    <tr>
      <td class='bars'>Mary</td>
      <td class='bars'>Accounting</td>
      <td class='bars'>Needs access to all records for billing customers.
          Controls everyone's paycheck, keep her happy.</td>
    </tr>
    </table>
    
    <p>It is apparent that we need three bins, which we will call Sales, Support, 
    and Development.</p>
    
    <p>We can easily derive some ideal access priviledges from this
    simplistic example:</p>
    
    <table width='80%' align='center'>
    <tr>
      <td colspan='3' class='labelCell' align='center'>Ideal Priviledges</td>
    </tr>
    <tr>
      <td class='subTitle'>User</td>
      <td class='subTitle'>Bins to access</td>
      <td class='subTitle'>Notes</td>
    </tr>
    <tr>
      <td class='bars'>Jack</td>
      <td class='bars'>Sales, Development</td>
      <td class='bars'>&nbsp;</td>
    </tr>
    <tr>
      <td class='bars'>John</td>
      <td class='bars'>Sales</td>
      <td class='bars'>&nbsp;</td>
    </tr>
    <tr>
      <td class='bars'>Mark</td>
      <td class='bars'>Support, Development</td>
      <td class='bars'>View only for Support</td>
    </tr>
    <tr>
      <td class='bars'>Sue</td>
      <td class='bars'>Support, Sales, Development</td>
      <td class='bars'>View only for Sales and Development</td>
    </tr>
    <tr>
      <td class='bars'>Mary</td>
      <td class='bars'>All bins</td>
      <td class='bars'>View only</td>
    </tr>
    </table>
    
    <p>Mark only needs to be able to view the tickets in the Support bin, and
    Sue only needs to be able to forward tickets to the Sales and Development
    bins (so she needs view access).</p>
    
    <p>Mary, of course, doesn't really have much use for the system other
    than to view hours worked on various projects.</p>
    
    So here is what we will do to get our access priviledges set up for
    Test Company A.
    
    <p><b>Step 1: Overall Access Levels</b></p>
    
    <p>We start our quest by heading to 
      <b><?=('Admin')?> -&gt;
      <?=('Settings Administration')?> -&gt;
      <?=('Configuration Settings')?></b>.  
      Here we will edit the level_* properties to meet Test Company A's needs.</p>
      
    <table width='80%' align='center'>
    <tr><td colspan='3'  class='labelCell' align='center'>Configuration Settings</td></tr>
    <tr>
      <td class='subTitle'>setting</td>
      <td class='subTitle'>new value</td>
      <td class='subTitle'>reason</td>
    </tr>
    <tr>
      <td class='bars'>level_view</td>
      <td class='bars'>1</td>
      <td class='bars'>Deny view priviledges by default</td>
    </tr>
    <tr>
      <td class='bars'>level_move</td>
      <td class='bars'>1</td>
      <td class='bars'>Anyone with view rights can now move a ticket</td>
    </tr>
    <tr>
      <td class='bars'>level_create</td>
      <td class='bars'>1</td>
      <td class='bars'>Anyone with view rights can now create a ticket</td>
    </tr>
    </table>
    
    <p>Once our overall priviledges are set up, we will now do some user
    administration, setting up our users to look like this:
    
    <table width='80%' align='center'>
    <tr><td colspan='5' class='labelCell' align='center'>Access Rights</td></tr>
    <tr>
      <td class='subTitle'>User</td>
      <td class='subTitle'>Default</td>
      <td class='subTitle'>Sales</td>
      <td class='subTitle'>Support</td>
      <td class='subTitle'>Development</td>
    </tr>
    <tr>
      <td class='bars'>Jack</td>
      <td class='bars'>2</td>
      <td class='bars'>-</td>
      <td class='bars'>-</td>
      <td class='bars'>1</td>
    </tr>
    <tr>
      <td class='bars'>John</td>
      <td class='bars'>0</td>
      <td class='bars'>2</td>
      <td class='bars'>-</td>
      <td class='bars'>-</td>
    </tr>
    <tr>
      <td class='bars'>Mark</td>
      <td class='bars'>0</td>
      <td class='bars'>-</td>
      <td class='bars'>2</td>
      <td class='bars'>1</td>
    </tr>
    <tr>
      <td class='bars'>Sue</td>
      <td class='bars'>1</td>
      <td class='bars'>-</td>
      <td class='bars'>-</td>
      <td class='bars'>2</td>
    </tr>
    <tr>
      <td class='bars'>Mary</td>
      <td class='bars'>1</td>
      <td class='bars'>-</td>
      <td class='bars'>-</td>
      <td class='bars'>-</td>
    </tr>
    </table>
    
    <p>Now we have our users set up correctly and ready to go.  It's too bad
    keeping the sales and the developers apart in real life wouldn't be so
    simple!</p>
    
  </td>    
</tr>
</table>

<?php
  renderNavbar('admin', true);
  include("$libDir/footer.php"); 
?>
