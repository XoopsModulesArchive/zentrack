<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<p align='center' class='bigbold'>Contacts</p>

<b>Important Note:</b> If contacts are not useful to your organization, they
may be turned off by your administrator.  If this is the case, this section of
the tutorial is not particularly useful to you... why are you still looking at
this?  Move on already!

<p><b>Purpose</b></p>

<p>The Contact List is essentially an address book.

<p>Contacts represent companies and employees (both internal and external to your
organization) which do not have a login account for <?=$zen->getSetting('system_name')?>.

<p>Contacts may be used simply as a record of the responsible parties or people
associated with a ticket or to add people to the notify lists for tickets.

<p>By going to the contacts section, you can view a list of tickets which
are associated with each contact, providing a means of organizing tickets by
company or customer.

<p><b>Viewing Contacts</b></p>

<p>Assuming contacts are enabled (if not, why won't you go away?), you can
choose '<?=tr('Contacts')?>' from the nav menu on the left to view existing
list of contacts.

<p>Several buttons accross the top will allow you to filter the contact
list to companies, internal contacts, external contacts, or to view all
contacts in a single list.

<p>Choosing a contact from the list will take you to the information for this
contact.  Here you can view tickets associated with the contact or edit information
for the contact.

<p><b>Creating Contacts</b></p>

<p>To create a contact, you can choose '<?=tr('Contacts')?>' from the nav menu
and then in the expanded options select '<?=tr('Create New')?>'.

<p>You must select either Company or Person.  A person can belong to a company
or be used independantly as a contact.

<p><b>Agreements</b></p>

<p>An Agreement represents a contract, support agreement, or other document which
affects how your organization will support or perform work for this contact.

<p>Items are significant points associated with the agreement which can be edited
as time progresses.


