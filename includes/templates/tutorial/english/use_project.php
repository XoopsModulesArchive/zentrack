<?php if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<p align='center' class='bigbold'>Projects</p>

<p><b>Purpose</b></p>

<p>Projects are designed to represent a collection of tickets or tasks that will
be completed together to accomplish a common goal.  A project can contain tickets
or other sub-projects (to futher break down the work involved).

<p>For example, cleaning the house might be a project (hopefully one you can
assign to someone else).  Each room of the house could then be a ticket which
would belong to the project.  

<p>Perhaps if the kitchen were particularly dirty, 
it could be placed in a sub-project, and then individual tickets could be
placed into this project for cleaning the dishes and defrosting the refridgerator.

<p><b>Viewing a Project</b></p>

<p>Projects are very similar to tickets in structure and use.  Simply click on 
the '<?=tr('Project')?>' link in the nav bar to pull up the list, and select
the project you wish to view.

<p>The view for a project is very similar to the ticket view.  There is an
additional tab called the <b>'<?=tr('Tasks')?>'</b> tab, which you can use
to view all of the tickets or sub-projects which have been assigned to this
project.

<p>You can search for projects under the '<?=tr('Search')?>' link on the nav
menu just as you would for tickets.  Simply select the type <?=tr('Project')?>
to filter your list to projects only.

<p><b>Creating A Project</b></p>

<p>Create a project by choosing the '<?=tr('Project')?>' link from the nav menu
and then choosing the expanded option for '<?=tr('Create New')?>'.

<p>To make the new project a sub-project, simply select the parent project
from the pulldown.
