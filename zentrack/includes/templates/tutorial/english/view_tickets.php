<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<p align='center' class='bigbold'>Viewing Tickets</p>

<img src="<?=$tutImageUrl?>/nav_tickets.gif" 
     alt="An image of the ticket link on the nav"
     height="235" width="157" align='left'>

<p><b>Finding a Ticket</b></p>

<p>Clicking on the '<?=tr("Tickets")?>' link in the nav bar (shown on the left) 
brings up the ticket list. 

<p>There may be multiple pages, which will be noted by next/previous 
links and page numbers at the bottom right.

<p>The tickets will be sorted by the priority (importance) of the ticket
and color coded as well.  Note that if you are filtering the tickets based on the bin
or those assigned to you (explained below) that column will not be shown.

<p>The <b>Opened</b> column lists the date when this ticket was originally
created.

<p>The <b>Time</b> column shows how long this ticket has been opened.  If your
time column looks like the one in our screenshot, then I suggest you put
away this tutorial and get to work.

<p align='center'><img src="<?=$tutImageUrl?>/ticket_list.gif" 
     alt="An image of the list tickets screen"
     height="115" width="401" align='center'></p>

<p>If your organization is like the Zentrack Project, you may not be able to
find anything in the ever growing list of tickets shown here.  In this case, 
you can also <b>search</b> for tickets by going to the 
'<?=tr("Search")?>' link on the left-hand menu.  We won't cover the search
feature in this tutorial, but it is worth mentioning.

<p><b>Filtering the List</b></p>

<p>Select the link to only view tickets which are assigned to you will remove
any tickets from the list on the right which do not list you as the current
owner.

<img src="<?=$tutImageUrl?>/current_bin.gif" 
     alt="An image of the current bin pulldown"
     height="291" width="212" align='right'>

<p>You can also filter the list of tickets using the '<?=tr("Current Bin")?>' pulldown
in the navigation menu.  This will reduce the list to show only the tickets which
are within the <?=tr("Bin")?> you have picked.

<p>A Bin is a way to group tickets.  Some companies use a <?=tr("Bins")?> to describe
departments or teams.  Others use the bin to group tickets according to customers
or types of customers.  You will have to decide within your organization what
the groups will be.

<p>Alternately, if you know the id of a particular ticket, you can bring it
up quickly by typing the id into the box at the top right of the 
screen and hitting enter.

<p><b>Making Sense of the Ticket View</b></p>

<p>Once you have selected a ticket, you will be presented with the ticket view.
This screen contains several important elements: 

<ul>
  <b>(1)</b> Critical information about the ticket
  <br><b>(2)</b> the actions which you may take to alter the ticket 
    (these may be enabled or disabled based on the condition of the ticket)
  <br><b>(3)</b> tabs containing more components of the ticket such as
  the details, log, attachments, and system messages
</ul>
<img src="<?=$tutImageUrl?>/ticket_view.gif" 
     alt="An image of the ticket view screen"
     height="141" width="450" align='center'>

<p>This screen is where you will conduct most of your work and most of the
tutorial covers this section.