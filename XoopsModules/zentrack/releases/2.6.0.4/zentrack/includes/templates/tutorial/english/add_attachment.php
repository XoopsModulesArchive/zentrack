<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<p align='center' class='bigbold'>Attachments</p>

<p><b>Purpose</b></p>

Attachments are used to upload important documents related to a ticket, such
as spreadsheets or pdf forms.

<p><b>What attachments are allowed</b></p>

<p>The type of items which can be attached to a ticket are determined by
your administrator.  Currently, the system is configured to accept the 
following attachments: <?=$zen->getSetting('attachment_types_allowed')?>

<p><b>Viewing Attachments</b></p>

<p>Attachments which are configured as text documents will generally open
in the browser window.  Others will attempt to launch an appropriate application
on your computer to open the attachment.

<p><b>Saving Attachments</b></p>

<p>You may also save an attachment to your computer rather than opening it.
This is done by right clicking on the attachment name and choosing 
'Save target as' or 'Save Link to Disk' in the menu.
