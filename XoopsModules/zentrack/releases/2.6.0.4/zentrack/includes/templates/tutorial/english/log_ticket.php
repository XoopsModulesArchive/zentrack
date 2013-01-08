<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<p align='center' class='bigbold'>The Ticket Log</p>

<p><b>Purpose</b></p>

<p>The log is where notes, information, and labor are recorded for
tickets.  

<p>The log is updated whenever the ticket is modified.  The new log entry 
contains the time, the user who made the modification, the action 
performed, and any time worked or comments noted by the user.

<p><b>How to View</b></p>

<p>You can view the existing log entries for a ticket by browsing to it and
then by opening the 'Log' tab in the ticket view.</p>

<img src="<?=$tutImageUrl?>/log_view.gif" 
     alt="An image of the ticket log"
     height="194" width="400" align='center'>

<p>The log can be viewed by anyone with access to the appropriate bin, so this
probably isn't a good place to make fun of customers and managers.

<p><b>Creating Log Entries</b></p>

<p>You can create a log entry (assuming you have sufficient access) by clicking
on the '<?=tr('Log')?>' button in the ticket view.

<p>Code or text you enter will be preserved in format and spacing.  When you place <b>hyperlinks</b>(web urls, such as www.yahoo.com) into the
log, they will become active links that users can click to view that page.
