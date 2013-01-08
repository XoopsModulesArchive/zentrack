<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<p align='center' class='bigbold'>Ownership of Tickets</p>

<p><b>You must own a ticket for most actions</b></p>

<p>Most actions can only be performed by the ticket's owner.  There are several ways to gain ownership:
<ul>
  <li>It can be assigned to you when it is created
  <li>A manager can assign it to you
  <li>You can accept it (if allowed by your administrator)
  <li>Managers can also take away ownership if needed using the '<?=tr("Yank")?>' feature.
</ul>

<p><b>Some actions do not require ownership</b></p>

<p>Some actions can be performed by a supervisor, even if they are not the owner.
  This often includes things like moving a ticket to a new bin or closing 
  a ticket.  
  
<p>A few actions can be performed by anyone with permissions, regardless 
  of ownership.  This includes things like adding a log entry or testing a ticket.

<p><b>Accepting a ticket</b></p>

<p>Accepting a ticket is done simply by clicking on the '<?=tr("Accept")?>' button in
the ticket view.  This feature isn't useful for all organizations and may
not appear in your ticket view if an administrator has disabled it.

<p><b>Assigning a Ticket</b></p>

<p>Assigning a ticket requires higher access rights than accepting, and is
performed by clicking on the '<?=tr('Assign')?>' button in the ticket view.  
This is covered in the Administrator's manual. 
