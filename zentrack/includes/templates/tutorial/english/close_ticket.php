<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<p align='center' class='bigbold'>Closing Tickets</p>

<p><b>Purpose</b></p>

<p>The close feature is used to indicate that work is finished and that a ticket
is no longer active.  This changes the status of a ticket and removes
it from the list of active tickets displayed.

<p><b>Pending Status</b></p>

<p>If a ticket requires testing or manager approval before it can be closed, then
choosing the 'Close' option will change the status to PENDING.  At this time,
the approve and test features will be enabled for users with proper
priveledges.

<p>Once the requirements for testing or approval are met, then the
status will change from PENDING to CLOSED, and the ticket will be considered
inactive.

<p><b>Reopen a Ticket</b></p>

<p>If a ticket is discovered to be incomplete or needs to be reopened, a manager
can view the ticket and choose 'Reopen' to change the status back to an
OPEN state and allow more work to be done.
