<?php
if( !ZT_DEFINED ) { die("Illegal Access"); }


/**
 *  This file contains configuration settings for variable ticket fields
 *  (custom fields which can be controlled by the system administrator)
 *
 * The number of entries in each array must exactly match the number of
 * columns in the ZENTRACK_VARFIELD table.
 *
 * IMPORTANT NOTE:  Once used in a production environment, it is never safe to
 * delete fields which have been added to the varfields set.  Instead, simply
 * disable fields which will not be displayed.
 *
 * The elements of each array are as follows:
 * 0 => (name, active, order, for_ticket, for_project, search_view, list_view, detail_view, custom_view)
 *   name - label for the field (add these to the translation files!)
 *   active - 1=active, 0=disabled
 *   order - order of display on page
 *   for_ticket - used for tickets
 *   for_project - used for projects
 *   search_view - show in search pages
 *   list_view - show in list pages
 *   detail_view - show in detail pane
 *   custom_view - show in the custom pane 
 */
$GLOBALS['varfields'] = 
  array(
    "custom_string" => 
    array(         
	           // name             | active | order | ticket | project | search | list | detail | custom 
	  0 => array( 'Custom String 1', 0,       1,      1,       1,        1,       0,     0,       1 ),
	  0 => array( 'Custom String 2', 0,       1,      1,       1,        1,       0,     0,       1 ),
	  0 => array( 'Custom String 3', 0,       1,      1,       1,        1,       0,     0,       1 ),
	  0 => array( 'Custom String 4', 0,       1,      1,       1,        1,       0,     0,       1 )
    ),

    "custom_number" => 
    array(         
	           // name             | active | order | ticket | project | search | list | detail | custom 
	  0 => array( 'Custom Number 1', 0,       1,      1,       1,        1,       0,     0,       1 ),
	  0 => array( 'Custom Number 2', 0,       1,      1,       1,        1,       0,     0,       1 )
    ),

    "custom_date" => 
    array(         
	           // name             | active | order | ticket | project | search | list | detail | custom 
	  0 => array( 'Custom Date 1', 0,       1,      1,       1,        1,       0,     0,       1 ),
	  0 => array( 'Custom Date 2', 0,       1,      1,       1,        1,       0,     0,       1 )
    ),

    "custom_text" => 
    array(         
	           // name             | active | order | ticket | project | search | list | detail | custom 
	  0 => array( 'Custom Text 1', 0,       1,      1,       1,        1,       0,     0,       1 )
    )

  );

?>