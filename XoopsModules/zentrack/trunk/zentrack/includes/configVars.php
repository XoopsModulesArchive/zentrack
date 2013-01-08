<?php {  if( !ZT_DEFINED ) { die("Illegal Access"); }
  
  /*
  **  ZENTRACK CONFIGURATION SETTINGS
  **
  **  These are probably fine as they are...
  **  We keep them here so that it is possible to
  **  run two copies of zenTrack from the same
  **  code base using different database entries
  **  
  **  You can have a look and change something if
  **  you need to.
  **  
  */

   global $Demo_Mode;
   global $Debug_Mode;
   global $Db_Host;
   global $Db_Type;
   global $Db_Instance;
   global $Db_Login;
   global $Db_Pass;

   $this->demo_mode = $Demo_Mode; 
   $this->debug = $Debug_Mode;
   //$this->sql_debug = true;  //uncommenting this will break everything and produce tons of garbage
   
   $this->database_type      = $Db_Type;
   $this->database_instance  = $Db_Instance;
   $this->database_login     = $Db_Login;   
   $this->database_password  = $Db_Pass;    
   $this->database_host      = $Db_Host;    

   
   $this->table_access           = XOOPS_DB_PREFIX.'_'.'zentrack_access';           //access table
   $this->table_attachments      = XOOPS_DB_PREFIX.'_'.'zentrack_attachments';      //attachments index
   $this->table_bins             = XOOPS_DB_PREFIX.'_'.'zentrack_bins';             //ticket bins
   $this->table_field_map      	 = XOOPS_DB_PREFIX.'_'.'zentrack_field_map';
   $this->table_view_map      	 = XOOPS_DB_PREFIX.'_'.'zentrack_view_map';
   $this->table_logs             = XOOPS_DB_PREFIX.'_'.'zentrack_logs';             //log table
   $this->table_logs_archived    = XOOPS_DB_PREFIX.'_'.'zentrack_logs_archived';    //archived log table
   $this->table_preferences      = XOOPS_DB_PREFIX.'_'.'zentrack_preferences';      //preferences for users
   $this->table_priorities       = XOOPS_DB_PREFIX.'_'.'zentrack_priorities';       //priorities of tickets
   $this->table_reports          = XOOPS_DB_PREFIX.'_'.'zentrack_reports';          //reports table name
   $this->table_reports_temp     = XOOPS_DB_PREFIX.'_'.'zentrack_reports_temp';     //temporary report storage
   $this->table_reports_index    = XOOPS_DB_PREFIX.'_'.'zentrack_reports_index';    //report ownership
   $this->table_settings         = XOOPS_DB_PREFIX.'_'.'zentrack_settings';         //settings table
   $this->table_systems          = XOOPS_DB_PREFIX.'_'.'zentrack_systems';          //ticket systems
   $this->table_tasks            = XOOPS_DB_PREFIX.'_'.'zentrack_tasks';            //task names
   $this->table_tickets          = XOOPS_DB_PREFIX.'_'.'zentrack_tickets';          //data table
   $this->table_tickets_archived = XOOPS_DB_PREFIX.'_'.'zentrack_tickets_archived'; //archived ticket table
   $this->table_types            = XOOPS_DB_PREFIX.'_'.'zentrack_types';            //ticket types
   $this->table_users            = XOOPS_DB_PREFIX.'_'.'zentrack_users';            //users table
   $this->table_notify_list      = XOOPS_DB_PREFIX.'_'.'zentrack_notify_list';
   $this->table_behavior         = XOOPS_DB_PREFIX.'_'.'zentrack_behavior';
   $this->table_behavior_detail  = XOOPS_DB_PREFIX.'_'.'zentrack_behavior_detail';
   $this->table_group            = XOOPS_DB_PREFIX.'_'.'zentrack_group';
   $this->table_group_detail     = XOOPS_DB_PREFIX.'_'.'zentrack_group_detail';
   $this->table_varfield         = XOOPS_DB_PREFIX.'_'.'zentrack_varfield';
   $this->table_varfield_idx     = XOOPS_DB_PREFIX.'_'.'zentrack_varfield_idx';
   $this->table_varfield_multi   = XOOPS_DB_PREFIX.'_'.'zentrack_varfield_multi';

   $this->table_agreement        = XOOPS_DB_PREFIX.'_'.'zentrack_agreement';
   $this->table_agreement_item   = XOOPS_DB_PREFIX.'_'.'zentrack_agreement_item';
   $this->table_company          = XOOPS_DB_PREFIX.'_'.'zentrack_company';
   $this->table_employee         = XOOPS_DB_PREFIX.'_'.'zentrack_employee';
   $this->table_related_contacts = XOOPS_DB_PREFIX.'_'.'zentrack_related_contacts';

   //pre-constructed strings
   $this->table_translation_strings = XOOPS_DB_PREFIX.'_'.'zentrack_translation_strings'; 
   //language dictionary
   $this->table_translation_words   = XOOPS_DB_PREFIX.'_'.'zentrack_translation_words';  

// Xoops User Table
   $this->table_xoops_users         = XOOPS_DB_PREFIX.'_'.'users';

   /*
   **  REPORTS
   */
   $this->cleanTempReports = 7;     // number of days to keep temporary reports
   $this->reportImageWidth = 640;   // width or report image
   $this->reportImageHeight = 540;  // height of report image

   /*
   **  MISC
   */   

   $this->defaultHighlight = array("<span class='highlight'>","</span>");

  /*
   *  DIRECTORY SETTINGS 
  */

   // the root includes folder
   global $libDir;
   $this->libDir = $libDir;   
  
   // the folder under includes holding utility files
   $this->listDir        = $this->libDir."/lists";
   
   // the folder under includes holding templates
   $this->templateDir    = $this->libDir."/templates";
   
   // the attachments folder under includes
   $this->attachmentsDir = $this->libDir."/attachments"; 


  /*
   *  MAIL SETTINGS
  */

  // hostname of the machine zenTrack is installed on
  // may be left blank if you can trust your web server to set up
  // $HOSTNAME correctly (Apache does)
  // $this->hostname = "machine.domain.com";

  // mail server (to whom we can deliver mail via SMTP)
  $this->smtpserver = "localhost";

  // default return path for bounced mails (should be replaced by the
  // email address of the logged-in user)
  $this->fromuser   = "me@domain.com";

  // address to put in from field for bug reports
  $this->bugFrom = 'bot@'.$_SERVER['HTTP_HOST'];
  
  // address to put in to field for bug reports
  $this->bugTo = 'bugs@zentrack.net';
  
  // seperator to use for splitting/joining multifield values
  $this->multisep = '; ';
}?>
