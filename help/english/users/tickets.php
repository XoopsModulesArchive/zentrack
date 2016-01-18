<?php
  $b = dirname(__FILE__);
  include("$b/user_header.php");
?>

<table align='center' width='80%'>
<tr>
  <td class='titleCell'>Description</td>
</tr>
<tr><td class='cell'>
  Tickets represent work or tasks that need to be performed.  The ticket is
  essentially a container for tracking all information related to each task, and
  organizing these tasks into a logical structure.
</td></tr>

<tr>
  <td class='titleCell'>Ticket Fields</td>
</tr>
<tr><td class='cell'>

<p>Explanations for the fields which appear in the ticket view:</p>

<ul>
  <p><b>Main Window</b></p>
  <li><b><?=tr('ID')?></b> - system tracking number for the ticket
  <li><b><?=tr('Title')?></b> - a quick summary of the ticket's purpose and description
  <li><b><?=tr('Elapsed')?></b> - the amount of time that has passed since the ticket
      was opened.
  <li><b><?=tr('Opened')?></b> - when the ticket was opened (created).
  <li><b><?=tr('Deadline')?></b> - when the ticket must be completed.
  <li><b><?=tr('Priority')?></b> - the relative importance of the ticket
  <li><b><?=tr('Owner')?></b> - the person currently responsible for the ticket.
  
  <p><b><?=tr('Details')?> Tab</b></p>
  <li><b><?=tr('Bin')?></b> - the bin where ticket is located
  <li><b><?=tr('Type')?></b> - the type of work involved in completion of this ticket.
  <li><b><?=tr('System')?></b> - related system or component where the work will be completed.
  <li><b><?=tr('Closed')?></b> - when ticket was closed (if applicable)
  <li><b><?=tr('Testing')?></b> - indicates if testing will be required before
      ticket can be closed.
  <li><b><?=tr('Approval')?></b> - indicates if approval will be required before
      ticket can be closed.
</ul>

 </td>
</tr>
<tr>
  <td class='titleCell'>Ticket Tabs</td>
</tr>
  <tr><td class='cell'>
    <p>Explanation of the ticket tabs:</p>
    <ul>
      <li><b><?=$tabs['details']?></b> - properties and detailed information about the ticket
      <li><b><?=$tabs['custom']?></b>(Variable Fields) - Fields added by your organization
      <li><b><?=$tabs['log']?></b> - the log used to record activity and hours
      <li><b><?=$tabs['notify']?></b> - the list of people who recieve notifications for this ticket
      <li><b><?=$tabs['contacts']?></b> - the list of contacts associated with this ticket
      <li><b><?=$tabs['related']?></b> - a list of tickets related to this one
      <li><b><?=$tabs['attachments']?></b> - a list of attachments for this ticket
      <li><b><?=$tabs['system']?></b> - the system log (contains errors and 
          information about commands executed).  The system tab is also used to present
          forms for completing actions.
    </ul>
  </td>
</tr>
<tr>
  <td class='titleCell'>Ticket Actions</td>
</tr>
<tr><td class='cell'>
  <p>Explanation of the action buttons which appear on tickets:</p>
  
  <ul>
  <li><b><?=tr('Accept')?></b> -  Take ownership of a ticket.  This makes it possible to manipulate the
  ticket and indicates who is currently responsible for it.
  
  <li><b><?=tr('Approve')?></b> -  Represents a manger or supervisor's signoff that work has
  been completed satisfactory.
  
  <li><b><?=tr('Assign')?></b> -  Give ownership of a ticket to a user who can access the bin where
  it is stored.  This action is only available with appropriate rights.
  
  <li><b><?=tr('Close')?></b> -  Indicates that work is completed on the ticket.  If the
  ticket is closed and testing or approval are required, it will be moved
  to a PENDING status until this work is complete.  When all testing and
  approval requirements are met, the ticket will move to a CLOSED state.
  
  <li><b><?=tr('Edit')?></b> -  Change the properties of a ticket.  This action is only available to
  users with appropriate rights.
  
  <li><b><?=tr('Email')?></b> -  Allows the contents, or a brief summary of a ticket to be 
  emailed to a selected recipient, or list of recipients.
  
  <li><b><?=tr('Log')?></b> -  Allows for personnel to log various activities 
  to the ticket. This log tracks hours worked as well. Questions, 
  solutions, notes, and general information about the task can 
  all be entered using this feature.
  
  <li><b><?=tr('Move')?></b> -  Changes the bin of a ticket and releases ownership.
  
  <li><b><?=tr('Print')?></b> -  Generate a print friendly view of the ticket.
  
  <li><b><?=tr('Reject')?></b> -  Return ticket to sender.  This is designed to be used if a ticket
  is sent to the wrong person or bin, or work is not possible due to
  conditions that the sender must correct.
  <br>&nbsp;<br>If no sender can be determined, then the system will attempt to 
  return the ticket to the creator. If this cannot be determined, 
  then the ticket will return to the bin where it was assigned from.
  
  <li><b><?=tr('Relate')?></b> -  Indicates a relationship between two tickets.  This indicates a
  "see also" condition exists between the tickets.
  
  <li><b><?=tr('Test')?></b> -  Indicates that testing has been completed and that the
  work is satisfactory.  This action is only available to users with 
  appropriate access.
  
  <li><b><?=tr('Yank')?></b> -  Take ownership of a ticket while it is owned by another user.  This
  action is only available to users with appropriate access.
  </ul>
  </td>
</tr>
</table>
<?php
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
