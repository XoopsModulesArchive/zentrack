<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<p align='center' class='bigbold'>Notify Lists</p>

<p><b>Purpose</b></p>

<p>Notify lists can be used to alert people when changes are made to a ticket.

<p>The notify list is located in the ticket view, under the '<?=tr('Notify')?>' tab.

<p><b>Adding Users to Notify List</b></p>

<p>Some users will be automatically added to a notify list by the system.  For
instance, when the ticket's owner changes, the old owner can be automatically
removed from the notify list and the new owner added.  The same can be done
for managers and testers when a ticket enters a state that is important to
them.

<p>The auto-add feature is configured by your administrator.

<p>To add a new user, simply view the ticket and choose the '<?=tr('Notify')?>'
tab.  Then click on '<?=tr('Add Recipient')?>'.

<p>This will bring up some choices for adding recipients to the notify list.  You
may select recipients from system users, contacts (if contacts are enabled) or by
adding a custom name and email address.

<p>When the user is added, they will receive a notice telling them that they are
on the notify list and providing instructions on how to remove their address
if needed.