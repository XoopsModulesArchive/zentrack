<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<p align='center' class='bigbold'>Creating a New Ticket</p>

<p><b>Purpose</b></p>

<p>Users with proper access can add new tickets to the system using this feature.

<p><b>Finding the New Ticket screen</b></p>

<p>The New Ticket screen can be found by clicking on <?=tr('Tickets')?> in the
nav menu.  This will expand to show the '<?=tr('Create new')?>' link.  Click on
this link to bring up the ticket view.

<p><b>The Form Fields</b></p>

<p>This section only covers important fields displayed on the New Ticket 
screen.  They are discussed in detail in the 
<a href='<?=$helpUrl?>/users/tickets.php'><?=$usersTOC['tickets.php']?></a>
section of the User's Manual</p>

<ul>
<p><b><?=tr('Project')?></b>: Allows you to assign this ticket to an
existing project.  <?=tr('Projects')?> are discussed at length in the next 
section of the tutorial.

<p><b><?=tr('Title')?></b>: The name of this ticket.  It is best to try and
make this a one sentence summary of the task or issue.  It is important that
other users be able to identify the content of the ticket from this entry.

<p><b><?=tr('Type')?></b>: The type of issue this ticket represents.  This
is used to identify the type of work or task that will be done to complete
the issue.

<p><b><?=tr('Priority')?></b>: The level of importance given to this issue.  It
is important to discuss these with your organization and to understand what
each entry represents to utilize them effectively.  It does no good for
every issue to be listed as 'Highest' priority.  (It's always highest priority
to the person creating it, right?)

<p><b><?=tr('Start Date')?> and <?=tr('Deadline')?></b>: The start date and deadline
fields are used to indicate when work should commence on an issue and what
the target date for completion is.

<p><b><?=tr('Estimated Hours to Complete')?></b>: The length of time expected
to complete this project.  This can be set later if it is not known yet.

<p><b><?=tr('Testing Required')?> and <?=tr('Approval Required')?></b>:  If checked,
then this issue will be moved to a PENDING status when the close button is
pressed.  Once the appropriate testing or approval is recieved, then the issue
will be moved to a CLOSED status.

<p><b><?=tr('Description')?></b>:  Probably the single most important element
of the ticket other than the title, this details the exact needs and conditions
of the ticket.  It should be thorough, and include steps to reproduce or other
important instructions.

<p>When writing the description, approach it as if you were sending an email to
the person who will do the work, which must explain fully what is needed and
maybe even how to accomplish the work (if known).
</ul>




