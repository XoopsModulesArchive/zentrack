
#
# table structure for `zentrack_agreement`
#

create table zentrack_agreement (
  agree_id int(12) not null auto_increment,
  company_id int(12) default null,
  contractnr varchar(50) default null,
  title varchar(50) default null,
  description text,
  stime int(12) default null,
  dtime int(12) default null,
  status int(2) default '1',
  create_time int(12) default null,
  change_time int(12) default null,
  creator_id int(12) default null,
  change_id int(12) default null,
  primary key  (agree_id)
);

#
# table structure for `zentrack_agreement_item`
#

create table zentrack_agreement_item (
  item_id int(12) not null auto_increment,
  agree_id int(12) default null,
  name1 varchar(50) default null,
  description1 varchar(50) default null,
  odate int(12) default null,
  create_time int(12) default null,
  change_time int(12) default null,
  creator_id int(12) default null,
  change_id int(12) default null,
  primary key  (item_id)
);

#
# table structure for `zentrack_company`
#

create table zentrack_company (
  company_id int(12) not null auto_increment,
  title varchar(50) default null,
  office varchar(50) default null,
  address1 varchar(50) default null,
  address2 varchar(50) default null,
  address3 varchar(50) default null,
  postcode varchar(50) default null,
  postcode2 varchar(50) default null,
  pobox varchar(50) default null,
  place varchar(50) default null,
  telephone varchar(20) default null,
  fax varchar(20) default null,
  country varchar(100) default null,
  email varchar(100) default null,
  website varchar(100) default null,
  description text,
  create_time int(12) default null,
  change_time int(12) default null,
  creator_id int(12) default null,
  change_id int(12) default null,
  primary key  (company_id)
);

#
# table structure for `zentrack_employee`
#

create table zentrack_employee (
  person_id int(12) not null auto_increment,
  company_id int(12) default null,
  fname varchar(50) default null,
  lname varchar(50) default null,
  initials varchar(15) default null,
  jobtitle varchar(50) default null,
  department varchar(50) default null,
  email varchar(100) default null,
  telephone varchar(20) default null,
  mobiel varchar(20) default null,
  inextern int(2) default null,
  description text,
  create_time int(12) default null,
  change_time int(12) default null,
  creator_id int(12) default null,
  change_id int(12) default null,
  primary key  (person_id)
);

CREATE TABLE zentrack_field_map (
   field_map_id INT(12) NOT NULL auto_increment,
   field_name   VARCHAR(25) NOT NULL,
   field_label  VARCHAR(255) default '',
   is_visible   INT(1) default 0,
   which_view   VARCHAR(50) default 0,
   default_val  VARCHAR(255),
   sort_order   INT(4) default 0,
   field_type   VARCHAR(50),
   num_cols     INT(4) default 0,
   num_rows     INT(2) default 0,
   is_required  INT(1) default 0,
   PRIMARY KEY (field_map_id),
   INDEX fldmap_sort (sort_order),
   INDEX fldmap_label (field_label),
   INDEX fldmap_both (sort_order,field_label)
);


#
# table structure for `zentrack_related_contacts`
#

create table zentrack_related_contacts (
  clist_id int(12) not null auto_increment,
  ticket_id int(12) not null default '0',
  cp_id int(12) default null,
  type int(12) default null,
  primary key  (clist_id)
);

#
# table structure for table 'zentrack_notify_list'
#
create table zentrack_notify_list (
   notify_id int(12) not null auto_increment,
   ticket_id int(12) not null,
   user_id int(12) default null,
   name varchar(100) default null,
   email varchar(150) default null,
   priority int(12) default null,
   notes varchar(255) default null,
   primary key (notify_id)
);

#
# table structure for table 'zentrack_access'
#

create table zentrack_access (
  access_id int(12) not null auto_increment,
  user_id int(12) default null,
  bin_id int(12) default null,
  lvl int(2) default null,
  notes varchar(25) default null,
  primary key (access_id)
) ENGINE=MyISAM;

#
# table structure for table 'zentrack_attachments'
#

create table zentrack_attachments (
  attachment_id int(12) not null auto_increment,
  log_id int(12) default null,
  ticket_id int(12) default null,
  name varchar(25) default null,
  filename varchar(250) default null,
  filetype varchar(250) default null,
  description varchar(100) default null,
  primary key (attachment_id)
) ENGINE=MyISAM;

#
# table structure for table 'zentrack_bins'
#

create table zentrack_bins (
  bid int(12) not null auto_increment,
  name varchar(25) not null default '',
  priority int(4) default null,
  active int(1) default '1',
  primary key (bid)
) ENGINE=MyISAM;

#
# table structure for table 'zentrack_logs'
#

create table zentrack_logs (
  lid int(12) not null auto_increment,
  ticket_id int(12) not null default '0',
  user_id int(12) not null default '0',
  bin_id int(12) not null default '0',
  created int(12) default null,
  action varchar(25) default null,
  hours decimal(10,2) default null,
  entry text,
  primary key (lid)
) ENGINE=MyISAM;

#
# table structure for table 'zentrack_preferences'
#

create table zentrack_preferences (
  user_id  int(12) not null default '0',
  prefname varchar(25),
  prefval  varchar(50),
  index (user_id)
) ENGINE=MyISAM;

#
# table structure for table 'zentrack_priorities'
#

create table zentrack_priorities (
  pid int(12) not null auto_increment,
  name varchar(25) not null default '',
  priority int(4) default null,
  active int(1) default null,
  primary key (pid)
) ENGINE=MyISAM;

#
# table structure for table 'zentrack_settings'
#

create table zentrack_settings (
  setting_id int(12) not null auto_increment,
  name varchar(25) default null,
  value varchar(100) default null,
  description varchar(200) default null,
  primary key (setting_id)
) ENGINE=MyISAM;

#
# table structure for table 'zentrack_systems'
#

create table zentrack_systems (
  sid int(12) not null auto_increment,
  name varchar(25) not null default '',
  priority int(4) default null,
  active int(1) default null,
  primary key (sid)
) ENGINE=MyISAM;

#
# table structure for table 'zentrack_tasks'
#

create table zentrack_tasks (
  task_id int(12) not null auto_increment,
  name varchar(25) not null default '',
  priority int(4) default null,
  active int(1) default null,
  primary key (task_id)
) ENGINE=MyISAM;

#
# table structure for table 'zentrack_tickets'
#

create table zentrack_tickets (
  id int(12) not null auto_increment,
  title varchar(50) not null default 'untitled',
  priority int(2) not null default '0',
  status varchar(25) not null default 'OPEN',
  description text,
  otime int(12) default null,
  ctime int(12) default null,
  bin_id int(12) default null,
  type_id int(12) default null,
  user_id int(12) default null,
  system_id int(12) default null,
  creator_id int(12) default null,
  tested int(1) default '0',
  approved int(1) default '0',
  relations varchar(255) default null,
  project_id int(12) default null,
  est_hours decimal(10,2) default '0.00',
  deadline int(12) default null,
  start_date int(12) default null,
  wkd_hours decimal(10,2) default '0.00',
  primary key (id)
) ENGINE=MyISAM;

#
# table structure for table 'zentrack_types'
#

create table zentrack_types (
  type_id int(12) not null auto_increment,
  name varchar(25) not null default '',
  priority int(4) default null,
  active int(1) default null,
  primary key (type_id)
) ENGINE=MyISAM;

#
# table structure for table 'zentrack_users'
#

create table zentrack_users (
  user_id int(12) not null auto_increment,
  login varchar(25) default null,
  access_level int(2) default null,
  passphrase varchar(32) default null,
  lname varchar(50) default null,
  fname varchar(50) default null,
  initials varchar(5) default null,
  email varchar(100) default null,
  notes varchar(255) default null,
  homebin int(12) default null,
  active int(1) default '1',
  primary key (user_id)
) ENGINE=MyISAM;

# 
# table structure for table 'zentrack_reports' 
# 

create table zentrack_reports ( 
   report_id int(12) not null auto_increment, 
   report_name varchar(100) default null, 
   report_type varchar(25) default null, 
   date_selector varchar(25) default null, 
   date_value int(3) default null, 
   date_range varchar(12) default null, 
   date_low int(12) default null, 
   chart_title varchar(255) default null, 
   chart_subtitle varchar(255) default null, 
   chart_add_ttl int(1) default null, 
   chart_add_avg int(1) default null, 
   chart_type varchar(25) default null, 
   chart_options text, 
   data_set text, 
   chart_combine int(1) default null, 
   text_output int(1) default null, 
   show_data_vals int(1) default null, 
   primary key (report_id) 
);

# 
# table structure for table 'zentrack_reports_index' 
# 

create table zentrack_reports_index ( 
   report_id int(12) default null, 
   bid int(12) default null, 
   user_id int(12) default null 
);

# 
# table structure for table 'zentrack_reports_temp' 
# 

create table zentrack_reports_temp ( 
   report_id int(12) not null auto_increment, 
   report_name varchar(100) default null, 
   report_type varchar(25) default null, 
   date_selector varchar(25) default null, 
   date_value int(3) default null, 
   date_range varchar(12) default null, 
   date_low int(12) default null, 
   chart_title varchar(255) default null, 
   chart_subtitle varchar(255) default null, 
   chart_add_ttl int(1) default null, 
   chart_add_avg int(1) default null, 
   chart_type varchar(25) default null, 
   chart_options text, 
   data_set text, 
   created datetime not null default '0000-00-00 00:00:00', 
   chart_combine int(1) default null, 
   text_output int(1) default null, 
   show_data_vals int(1) default null, 
   primary key (report_id), 
   key tempreports_created(created) 
);

#
# release 2.5 new tables
#

create table zentrack_behavior (
  behavior_id int(12) not null auto_increment,
  behavior_name varchar(100),
  group_id int(12) not null,
  is_enabled int(1),
  sort_order int(3),
  field_name varchar(100),
  field_enabled int(1),
  match_all int(1),
  primary key (behavior_id),
  index (is_enabled)
);

create table zentrack_behavior_detail (
  behavior_id int(12) not null,
  field_name varchar(50),
  field_operator varchar(2),
  field_value varchar(255),
  sort_order int(3)
);

create table zentrack_group (
  group_id int(12) not null auto_increment,
  table_name varchar(50),
  group_name varchar(100),
  descript varchar(255),
  eval_type varchar(10),
  eval_text text,
  name_of_file varchar(100),
  include_none int(1),
  primary key (group_id),
  index (group_name)
);

create table zentrack_group_detail (
  group_id int(12) not null,
  field_value varchar(255),
  sort_order int(3),
  index (group_id, sort_order)
);

create table zentrack_varfield (
  ticket_id int(12) not null,

  /* changes here must be reflected in the values for zentrack_varfield_idx */
  custom_menu1 varchar(255),
  custom_menu2 varchar(255),

  custom_string1 varchar(255),
  custom_string2 varchar(255),

  custom_number1 int(20),
  custom_number2 int(20),

  custom_boolean1 int(1),
  custom_boolean2 int(1),

  custom_date1 int(12),
  custom_date2 int(12),

  custom_text1 text,

  index (ticket_id)
);

create table zentrack_varfield_idx (
  field_name varchar(25) not null,
  field_label varchar(50),
  field_value varchar(100),
  sort_order int(3),
  is_required int(1) default 0,
  use_for_project int(1) default 0, 
  use_for_ticket int(1) default 0,
  show_in_search int(1) default 0,
  show_in_list int(1) default 0,
  show_in_custom int(1) default 0,
  show_in_detail int(1) default 0,
  show_in_new    int(1) default 0,
  js_validation text,
  index (sort_order, field_name)
);

# ADDED IN VERSION 2.6

create table zentrack_view_map (
  view_map_id INT(12) NOT NULL auto_increment,
  vm_name VARCHAR(25) NOT NULL,
  vm_val  VARCHAR(50) default '',
  vm_type VARCHAR(12) NOT NULL,
  vm_order INT(4) default 0,
  which_view VARCHAR(50) NOT NULL,
  PRIMARY KEY (view_map_id),
  INDEX view_map_idx (which_view,vm_order)
);
create table zentrack_varfield_multi (
  multi_id int(12) NOT NULL auto_increment,
  ticket_id int(12) NOT NULL default '0',
  field_name varchar(25) NOT NULL default '',
  field_value varchar(255) default NULL,
  PRIMARY KEY  (multi_id),
  INDEX vf_multi_idx (ticket_id)
);




#
# load data for table 'zentrack_access'
#

insert into zentrack_access (access_id, user_id, bin_id, lvl, notes) values (1,65532,2,1,null);
insert into zentrack_access (access_id, user_id, bin_id, lvl, notes) values (2,65532,3,1,null);
insert into zentrack_access (access_id, user_id, bin_id, lvl, notes) values (3,65532,3,2,null);
insert into zentrack_access (access_id, user_id, bin_id, lvl, notes) values (4,65532,4,1,null);
insert into zentrack_access (access_id, user_id, bin_id, lvl, notes) values (5,65532,3,1,null);

#
# load data for table 'zentrack_bins'
#

insert into zentrack_bins (bid, name, priority, active) values (1,'accounting',0,1);
insert into zentrack_bins (bid, name, priority, active) values (2,'engineering',0,1);
insert into zentrack_bins (bid, name, priority, active) values (3,'marketing',0,1);
insert into zentrack_bins (bid, name, priority, active) values (4,'it',0,1);
insert into zentrack_bins (bid, name, priority, active) values (5,'tech support',0,1);
insert into zentrack_bins (bid, name, priority, active) values (6,'human resources',0,1);
insert into zentrack_bins (bid, name, priority, active) values (7,'test bin',0,0);

#
# load data for table 'zentrack_logs'
#

insert into zentrack_logs (lid, ticket_id, user_id, bin_id, created, action, hours, entry) values (1,2,1,2,1019621210,'accepted',null,null);

#
# load data for table 'zentrack_priorities'
#

insert into zentrack_priorities (pid, name, priority, active) values (1,'critical',5,1);
insert into zentrack_priorities (pid, name, priority, active) values (2,'high',4,1);
insert into zentrack_priorities (pid, name, priority, active) values (3,'medium',3,1);
insert into zentrack_priorities (pid, name, priority, active) values (4,'low',2,1);
insert into zentrack_priorities (pid, name, priority, active) values (6,'none',1,1);

#
# load data for table 'zentrack_settings'
#

insert into zentrack_settings (setting_id, name, value, description) values (1,'admin_email','root@localhost','the email address of the zentrack administrator');
insert into zentrack_settings (setting_id, name, value, description) values (2,'bot_name','zenbot','the system bots name');
insert into zentrack_settings (setting_id, name, value, description) values (3,'allow_cview','on','allow ticket creator to view the ticket, regardless of access');
insert into zentrack_settings (setting_id, name, value, description) values (4,'allow_reject','on','allow tickets to be rejected');
insert into zentrack_settings (setting_id, name, value, description) values (5,'allow_yank','on','allow tickets to be yanked');
insert into zentrack_settings (setting_id, name, value, description) values (6,'allow_assign','on','allow tickets to be assigned');
insert into zentrack_settings (setting_id, name, value, description) values (7,'allow_accept','on','allow tickets to be accepted');
insert into zentrack_settings (setting_id, name, value, description) values (8,'allow_relate','on','allow tickets to be related to one another');
insert into zentrack_settings (setting_id, name, value, description) values (9,'attachment_max_size','20000','the maximum file size of an attachment (in bytes)');
insert into zentrack_settings (setting_id, name, value, description) values (10,'attachment_text_types','php,txt,pl,cgi,asp,jsp,java,class,inc','files with this extention will be displayed as text by the browser');
insert into zentrack_settings (setting_id, name, value, description) values (11,'attachment_types_allowed','txt,html,xls,pdf,jpg,gif,png,doc,wpd,php','comma seperated list.  only these extensions may be uploaded.  set to 0 to allow all (warning:  this is a security risk!)');
insert into zentrack_settings (setting_id, name, value, description) values (12,'color_links','#006633','color of links on the page');
insert into zentrack_settings (setting_id, name, value, description) values (13,'color_grey','#666666','greyed text color');
insert into zentrack_settings (setting_id, name, value, description) values (14,'color_background','#ffffff','color of normal bg');
insert into zentrack_settings (setting_id, name, value, description) values (15,'color_text','#000000','color of normal text');
insert into zentrack_settings (setting_id, name, value, description) values (16,'color_alt_background','#99cccc','color of alternate bg');
insert into zentrack_settings (setting_id, name, value, description) values (17,'color_alt_text','#000066','color of alternate text');
insert into zentrack_settings (setting_id, name, value, description) values (18,'color_title_background','#669999','color of title cell bg');
insert into zentrack_settings (setting_id, name, value, description) values (19,'color_title_text','#ffffff','color of title cell text');
insert into zentrack_settings (setting_id, name, value, description) values (20,'color_bars','#eaeaea','color of background in rows of data');
insert into zentrack_settings (setting_id, name, value, description) values (21,'color_bar_text','#006666','color of text in rows of data');
insert into zentrack_settings (setting_id, name, value, description) values (22,'color_hot','#990000','color of text when hot(critical/errors)');
insert into zentrack_settings (setting_id, name, value, description) values (23,'color_highlight','#ccffcc','color of background to highlight text');
insert into zentrack_settings (setting_id, name, value, description) values (24,'color_hover','#00ff33','color of links on mouseover (hover)');
insert into zentrack_settings (setting_id, name, value, description) values (25,'default_test_checked','on','testing required defaults to yes');
insert into zentrack_settings (setting_id, name, value, description) values (26,'default_aprv_checked','off','approval required defaults to yes');
insert into zentrack_settings (setting_id, name, value, description) values (27,'email_pending','on','send email to tester/approver when ticket is pending');
insert into zentrack_settings (setting_id, name, value, description) values (28,'email_reject','on','send email to sender/creator when ticket is rejected');
insert into zentrack_settings (setting_id, name, value, description) values (29,'email_assign','on','send email to recipient when ticket is assigned');
insert into zentrack_settings (setting_id, name, value, description) values (30,'email_arrival','on','send email to bin owner when ticket arrives in bin');
insert into zentrack_settings (setting_id, name, value, description) values (31,'email_created','on','send email to bin owner when ticket is created');
insert into zentrack_settings (setting_id, name, value, description) values (32,'email_closed','on','send email to bin owner when ticket is closed');
insert into zentrack_settings (setting_id, name, value, description) values (33,'email_completed','on','send email to bin owner when ticket is completed');
insert into zentrack_settings (setting_id, name, value, description) values (34,'email_max_logs','40','maximum logs to send via email.  set to blank for unlimited');
insert into zentrack_settings (setting_id, name, value, description) values (35,'font_size','12','font size on pages, in pixels');
insert into zentrack_settings (setting_id, name, value, description) values (36,'font_face','arial, helvetica','font face to appear on pages, comma seperated list');
insert into zentrack_settings (setting_id, name, value, description) values (37,'level_create','2','level required to create a ticket');
insert into zentrack_settings (setting_id, name, value, description) values (38,'level_hot','1','priority level to consider hot(highest is 1)');
insert into zentrack_settings (setting_id, name, value, description) values (39,'level_highlight','2','priority level to highlight(highest is 1)');
insert into zentrack_settings (setting_id, name, value, description) values (40,'level_user','2','level required to perform worker/user tasks');
insert into zentrack_settings (setting_id, name, value, description) values (41,'level_super','3','level required to perform supervisor tasks');
insert into zentrack_settings (setting_id, name, value, description) values (42,'level_settings','5','level required to edit system settings');
insert into zentrack_settings (setting_id, name, value, description) values (43,'level_accept','2','level required to accept a ticket');
insert into zentrack_settings (setting_id, name, value, description) values (44,'level_assign','3','level required to assign a ticket');
insert into zentrack_settings (setting_id, name, value, description) values (45,'level_yank','3','level required to yank a ticket');
insert into zentrack_settings (setting_id, name, value, description) values (46,'level_test','3','level required to test a ticket');
insert into zentrack_settings (setting_id, name, value, description) values (47,'level_approve','3','level required to approve a ticket');
insert into zentrack_settings (setting_id, name, value, description) values (48,'level_move','2','level required to move a ticket');
insert into zentrack_settings (setting_id, name, value, description) values (49,'level_view','0','level required to view a bin');
insert into zentrack_settings (setting_id, name, value, description) values (50,'level_edit','3','level required to edit a ticket');
insert into zentrack_settings (setting_id, name, value, description) values (51,'log_show_bins','on','display current bin in log view');
insert into zentrack_settings (setting_id, name, value, description) values (52,'log_show_time','on','display time created in the log view');
insert into zentrack_settings (setting_id, name, value, description) values (53,'log_show_user','on','display creator in the log view');
insert into zentrack_settings (setting_id, name, value, description) values (54,'log_show_att','on','display attachments in the log view');
insert into zentrack_settings (setting_id, name, value, description) values (55,'log_edit','on','create a log when ticket is edited');
insert into zentrack_settings (setting_id, name, value, description) values (56,'log_assign','on','create a log when ticket is assigned');
insert into zentrack_settings (setting_id, name, value, description) values (57,'log_accept','on','create a log when ticket is accepted');
insert into zentrack_settings (setting_id, name, value, description) values (58,'log_relate','on','create a log when ticket is related');
insert into zentrack_settings (setting_id, name, value, description) values (59,'log_reject','on','create a log when ticket is rejected');
insert into zentrack_settings (setting_id, name, value, description) values (60,'log_approve','on','create a log when ticket is approved');
insert into zentrack_settings (setting_id, name, value, description) values (61,'log_close','on','create a log when ticket is closed');
insert into zentrack_settings (setting_id, name, value, description) values (62,'log_test','on','create a log when ticket is tested');
insert into zentrack_settings (setting_id, name, value, description) values (63,'log_move','on','create a log when ticket is moved');
insert into zentrack_settings (setting_id, name, value, description) values (64,'log_yank','on','create a log when ticket is yanked');
insert into zentrack_settings (setting_id, name, value, description) values (65,'log_pending','on','create a log when status is set to pending');
insert into zentrack_settings (setting_id, name, value, description) values (66,'log_attachment','on','create a log entry when an attachment is added.');
insert into zentrack_settings (setting_id, name, value, description) values (67,'system_name','zentrack','name of the zentrack ticketing system displayed to users');
insert into zentrack_settings (setting_id, name, value, description) values (68,'url_view_attachment','viewattachment.php','link to script which displays attachments in a secure manner (for server integrity), no leading slash');
insert into zentrack_settings (setting_id, name, value, description) values (70,'url_view_ticket','ticket.php','link to script which displays ticket information, no leading slash');
insert into zentrack_settings (setting_id, name, value, description) values (71,'allow_pwd_save','off','allows user to save passphrase (not implemented yet)');
insert into zentrack_settings (setting_id, name, value, description) values (72,'check_pwd_simple','on','system will refuse lazy passwords');
insert into zentrack_settings (setting_id, name, value, description) values (73,'level_reports','1','level required to access and view reports');
insert into zentrack_settings (setting_id, name, value, description) values (74,'version_xx','2.6.0.4','the version of zentrack, this cannot be edited');
insert into zentrack_settings (setting_id, name, value, description) values (75,'date_fmt_long','%a %d, %b %y','long date format');
insert into zentrack_settings (setting_id, name, value, description) values (76,'date_fmt_short','%m/%d/%y','short date format');
insert into zentrack_settings (setting_id, name, value, description) values (77,'date_fmt_time','%H:%M','time format');
insert into zentrack_settings (setting_id, name, value, description) values (78,'time_elapsed_unit','hours','use hours, days, months, years, seconds, or weeks');
insert into zentrack_settings (setting_id, name, value, description) values (79,'language_default','english','this is the language to display pages in, must match one of the filenames in includes/translations/');
insert into zentrack_settings (setting_id, name, value, description) values (80,'default_deadline','+1 month','format: [+-]nn [minutes|hours|days|weeks|months], or use 0 for none');
insert into zentrack_settings (setting_id, name, value, description) values (81,'default_start_date','+1 day','format: [+-]nn [minutes|hours|days|weeks|months], or use 0 for none');
insert into zentrack_settings (setting_id, name, value, description) values (82,'email_interface_enabled','off', 'use the email gateway');
insert into zentrack_settings (setting_id, name, value, description) values (83,'default_notify_manager','on','add bin manager to notify list by default.');
insert into zentrack_settings (setting_id, name, value, description) values (84,'default_notify_tester','on','add bin tester to notify list by default.');
insert into zentrack_settings (setting_id, name, value, description) values (85,'default_notify_creator','on','add ticket creator to notify list by default.');
insert into zentrack_settings (setting_id, name, value, description) values (86,'default_notify_owner','on','add ticket owner to notify list by default.');
insert into zentrack_settings (setting_id, name, value, description) values (87,'sql_cache_time',0,'number of seconds to cache db results, set to 0 to disable sql caching');
insert into zentrack_settings (setting_id, name, value, description) values (88,'email_log','on','send email when a log entry is created');
insert into zentrack_settings (setting_id, name, value, description) values (89,'priority_medium','2','median priority, pick number around 1/2 total priorities, set to 0 to disable coloring');
insert into zentrack_settings (setting_id, name, value, description) values (90,'color_priority_low','#ffffff','base color for low priority items');
insert into zentrack_settings (setting_id, name, value, description) values (91,'color_priority_med','#ffffcc','base color for medium priority items');
insert into zentrack_settings (setting_id, name, value, description) values (92,'color_priority_hi','#ff9999','base color for high priority items');
insert into zentrack_settings (setting_id, name, value, description) values (93,'log_email','on','create a log entry when tickets are emailed.');
insert into zentrack_settings (setting_id, name, value, description) values (94,'level_create_proj','2','access level required to create projects.');
insert into zentrack_settings (setting_id, name, value, description) values (95,'use_euro_date','off','on if using european format(dd/mm/yyyy) instead of american(mm/dd/yyyy)');
insert into zentrack_settings (setting_id, name, value, description) values (96,'level_edit_varfields','2','access level required to edit fields on the "custom" tab.');
insert into zentrack_settings (setting_id, name, value, description) values (97,'varfield_tab_name', 'custom', 'name to appear on the variable fields tab');
insert into zentrack_settings (setting_id, name, value, description) values (98,'allow_htaccess', 'on', 'if on, will attempt to authenticate users based on apache htaccess (username and password must match zt)');
insert into zentrack_settings (setting_id, name, value, description) values (99,'allow_contacts', 'on', 'specify whether contacts will be used or not');
insert into zentrack_settings (setting_id, name, value, description) values (100,'level_contacts','3','level required to view the contacts');
insert into zentrack_settings (setting_id, name, value, description) values (101,'paging_max_rows','20','number of rows to display at a time');
insert into zentrack_settings (setting_id, name, value, description) values (102,'retain_owner_move','on','keep owner data on tickets after a ticket is moved between bins');
insert into zentrack_settings (setting_id, name, value, description) values (103,'retain_owner_pending','on','keep owner data on tickets after a ticket is set to pending');
insert into zentrack_settings (setting_id, name, value, description) values (104,'retain_owner_closed','on','keep owner data on tickets after a ticket is set to closed');
insert into zentrack_settings (setting_id, name, value, description) values (105,'character_set','iso-8859-15','character set to be used');

insert into zentrack_settings (setting_id, name, value, description) VALUES (106,'default_start_date_hours','on','Include hours in default start date for new tickets');
insert into zentrack_settings (setting_id, name, value, description) VALUES (107,'default_deadline_hours','on','Include hours in default deadline for new tickets');

insert into zentrack_settings (setting_id, name, value, description) VALUES (108,'edit_reason_required', 'off', 'Show a mandatory edit field to explain why the ticket is being edited');
insert into zentrack_settings (setting_id, name, value, description) VALUES (109,'email_accept', 'on', 'Send email to users in the notify list when ticket is accepted');
insert into zentrack_settings (setting_id, name, value, description) VALUES (110, 'ctime_on_pending', 'off', 'Set this to on if you want tickets to set ctime when changed to pending');

#
# load data for table 'zentrack_systems'
#

insert into zentrack_systems (sid, name, priority, active) values (1,'apache',0,1);
insert into zentrack_systems (sid, name, priority, active) values (2,'email',0,1);
insert into zentrack_systems (sid, name, priority, active) values (3,'database',0,1);
insert into zentrack_systems (sid, name, priority, active) values (4,'network',0,1);
insert into zentrack_systems (sid, name, priority, active) values (5,'pc',0,1);
insert into zentrack_systems (sid, name, priority, active) values (6,'printer',0,1);
insert into zentrack_systems (sid, name, priority, active) values (7,'website',0,1);

#
# load data for table 'zentrack_tasks'
#

insert into zentrack_tasks (task_id, name, priority, active) values (1,'action taken',0,1);
insert into zentrack_tasks (task_id, name, priority, active) values (2,'debugging',0,1);
insert into zentrack_tasks (task_id, name, priority, active) values (3,'implementation',0,1);
insert into zentrack_tasks (task_id, name, priority, active) values (4,'note',0,1);
insert into zentrack_tasks (task_id, name, priority, active) values (5,'planning',0,1);
insert into zentrack_tasks (task_id, name, priority, active) values (6,'question',0,1);
insert into zentrack_tasks (task_id, name, priority, active) values (7,'research',0,1);
insert into zentrack_tasks (task_id, name, priority, active) values (8,'review',0,1);
insert into zentrack_tasks (task_id, name, priority, active) values (9,'solution',0,1);
insert into zentrack_tasks (task_id, name, priority, active) values (10,'testing',0,1);
insert into zentrack_tasks (task_id, name, priority, active) values (11,'work',0,1);

#
# load data for table 'zentrack_tickets'
#

insert into zentrack_tickets (id, title, priority, status, description, otime, ctime, bin_id, type_id, user_id, system_id, creator_id, tested, approved, relations, project_id, est_hours, deadline, start_date, wkd_hours) values (1,'welcome to zentrack!!',2,'OPEN','welcome to the zentrack system!\r<br />\n\r<br />\ncongratulations, your install was successful.\r<br />\n\r<br />\nyou can find more help in the help section on this site, and online at http://zentrack.phpzen.net.\r<br />\n\r<br />\nyou can find support for your product at the sourceforge project: http://www.sourceforge.net/projects/zentrack',1019621097,null,2,5,null,7,1,0,0,null,null,0.00,null,null,0.10);
insert into zentrack_tickets (id, title, priority, status, description, otime, ctime, bin_id, type_id, user_id, system_id, creator_id, tested, approved, relations, project_id, est_hours, deadline, start_date, wkd_hours) values (2,'change admin password',1,'OPEN','you need to change the admin passphrase right away.\r<br />\n\r<br />\nin addition, two other accounts, user, and guest were created.  you will want to modify those or delete them as your system security and preferences determine.',1019621197,null,2,8,null,7,1,0,0,null,null,0.01,1022137200,null,1.00);

#
# load data for table 'zentrack_types'
#

insert into zentrack_types (type_id, name, priority, active) values (1,'project',0,1);
insert into zentrack_types (type_id, name, priority, active) values (2,'support request',0,1);
insert into zentrack_types (type_id, name, priority, active) values (3,'bug',0,1);
insert into zentrack_types (type_id, name, priority, active) values (4,'enhancement',0,1);
insert into zentrack_types (type_id, name, priority, active) values (5,'event log',0,1);
insert into zentrack_types (type_id, name, priority, active) values (6,'feature request',0,1);
insert into zentrack_types (type_id, name, priority, active) values (7,'service',0,1);
insert into zentrack_types (type_id, name, priority, active) values (8,'task',0,1);
insert into zentrack_types (type_id, name, priority, active) values (9,'note',0,1);

#
# load data for table 'zentrack_users'
#

insert into zentrack_users (user_id, login, access_level, passphrase, lname, fname, initials, email, notes, homebin, active) values (65532,'guest',0,'adb831a7fdd83dd1e2a309ce7591dff8','visitor','guest','guest',null,null,2,1);
insert into zentrack_users (user_id, login, access_level, passphrase, lname, fname, initials, email, notes, homebin, active) values (65533,'user',3,'8f9bfe9d1345237cb3b2b205864da075','user','default','user',null,'default user account',2,1);
insert into zentrack_users (user_id, login, access_level, passphrase, lname, fname, initials, email, notes, homebin, active) values (65534,'egate',2,null,'gateway','email','egate','zentrack@localhost','email gateway account',1,0);


#
# load data for table 'zentrack_varfield_idx'
#


insert into zentrack_varfield_idx (field_name,       field_label,       sort_order) 
                           values ('custom_menu1', 'custom menu 1', 1         );
insert into zentrack_varfield_idx (field_name,       field_label,       sort_order) 
                           values ('custom_menu2', 'custom menu 2', 1         );
insert into zentrack_varfield_idx (field_name,       field_label,       sort_order) 
                           values ('custom_string1', 'custom string 1', 1         );
insert into zentrack_varfield_idx (field_name,       field_label,       sort_order) 
                           values ('custom_string2', 'custom string 2', 1         );
insert into zentrack_varfield_idx (field_name,       field_label,       sort_order) 
                           values ('custom_number1', 'custom number 1', 1         );
insert into zentrack_varfield_idx (field_name,       field_label,       sort_order) 
                           values ('custom_number2', 'custom number 2', 1         );
insert into zentrack_varfield_idx (field_name,       field_label,       sort_order) 
                           values ('custom_boolean1', 'custom boolean 1', 1         );
insert into zentrack_varfield_idx (field_name,       field_label,       sort_order) 
                           values ('custom_boolean2', 'custom boolean 2', 1         );
insert into zentrack_varfield_idx (field_name,       field_label,       sort_order) 
                           values ('custom_date1', 'custom date 1', 1         );
insert into zentrack_varfield_idx (field_name,       field_label,       sort_order) 
                           values ('custom_date2', 'custom date 2', 1         );
insert into zentrack_varfield_idx (field_name,       field_label,       sort_order) 
                           values ('custom_text1', 'custom text 1', 1         );


insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('2','title','Title','1','ticket_create',NULL,'2','text','200','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('3','priority','Priority','1','ticket_create',NULL,'4','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('5','description','Description','1','ticket_create',NULL,'24','text','60','10','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('6','otime','Open Time','0','ticket_create',NULL,'13','label','20','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('7','ctime','Close Time','0','ticket_create',NULL,'14','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('8','bin_id','Bin','1','ticket_create',NULL,'5','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('9','type_id','Type','1','ticket_create',NULL,'6','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('10','system_id','System','1','ticket_create',NULL,'7','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('11','user_id','Owner','1','ticket_create',NULL,'8','searchbox','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('13','tested','Testing','1','ticket_create',NULL,'9','checkbox','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('14','approved','Approval','1','ticket_create',NULL,'10','checkbox','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('15','relations','Related','0','ticket_create',NULL,'11','searchbox','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('16','project_id','Project','1','ticket_create',NULL,'1','searchbox','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('17','est_hours','Estimated Hours','1','ticket_create',NULL,'17','text','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('18','start_date','Start Date','1','ticket_create','+1 day','15','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('19','deadline','Deadline','1','ticket_create','+1 month','16','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('20','wkd_hours','Hours Worked','0','ticket_create','0','18','text','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('21','custom_string1',NULL,'0','ticket_create',NULL,'19','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('22','custom_string2',NULL,'0','ticket_create',NULL,'20','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('23','custom_text1',NULL,'0','ticket_create',NULL,'21','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('24','custom_number1',NULL,'0','ticket_create','0','22','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('25','custom_number2',NULL,'0','ticket_create','0','25','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('26','custom_boolean1',NULL,'0','ticket_create',NULL,'26','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('27','custom_boolean2',NULL,'0','ticket_create',NULL,'27','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('28','custom_menu1',NULL,'0','ticket_create',NULL,'28','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('29','custom_menu2',NULL,'0','ticket_create',NULL,'29','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('30','section1','Properties','1','ticket_create',NULL,'3','section',NULL,'1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('31','section2','Time Table','1','ticket_create',NULL,'12','section',NULL,'1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('33','section3','Description','1','ticket_create',NULL,'23','section',NULL,'1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('34','id','ID','1','ticket_edit',NULL,'1','label','8','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('35','title','Title','1','ticket_edit',NULL,'3','text','200','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('36','priority','Priority','1','ticket_edit',NULL,'6','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('37','status','Status','1','ticket_edit',NULL,'4','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('38','description','Description','1','ticket_edit',NULL,'27','text','60','10','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('39','otime','Open Time','1','ticket_edit',NULL,'16','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('40','ctime','Close Time','0','ticket_edit',NULL,'17','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('41','bin_id','Bin','1','ticket_edit',NULL,'7','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('42','type_id','Type','1','ticket_edit',NULL,'8','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('43','system_id','System','1','ticket_edit',NULL,'9','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('44','user_id','Owner','1','ticket_edit',NULL,'10','searchbox','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('45','creator_id','Creator','1','ticket_edit',NULL,'11','searchbox','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('46','tested','Testing','1','ticket_edit',NULL,'12','menu','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('47','approved','Approval','0','ticket_edit',NULL,'13','menu','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('48','relations','Related','1','ticket_edit',NULL,'14','searchbox','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('49','project_id','Project','1','ticket_edit',NULL,'2','searchbox','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('50','est_hours','Estimated Hours','1','ticket_edit',NULL,'18','text','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('51','start_date','Start Date','1','ticket_edit',NULL,'19','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('52','deadline','Deadline','1','ticket_edit',NULL,'20','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('53','wkd_hours','Hours Worked','0','ticket_edit','0','21','text','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('54','custom_string1',NULL,'0','ticket_edit',NULL,'22','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('55','custom_string2',NULL,'0','ticket_edit',NULL,'23','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('56','custom_text1',NULL,'0','ticket_edit',NULL,'24','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('57','custom_number1',NULL,'0','ticket_edit','0','25','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('58','custom_number2',NULL,'0','ticket_edit','0','28','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('59','custom_boolean1',NULL,'0','ticket_edit',NULL,'29','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('60','custom_boolean2',NULL,'0','ticket_edit',NULL,'30','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('61','custom_menu1',NULL,'0','ticket_edit',NULL,'31','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('62','custom_menu2',NULL,'0','ticket_edit',NULL,'32','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('63','section1','Properties','1','ticket_edit',NULL,'5','section',NULL,'1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('64','section2','Time Table','1','ticket_edit',NULL,'15','section',NULL,'1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('65','section3','Description','1','ticket_edit',NULL,'26','section',NULL,'1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('67','title','Title','1','project_create',NULL,'3','text','200','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('68','priority','Priority','1','project_create',NULL,'4','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('70','description','Description','1','project_create',NULL,'24','text','60','10','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('71','otime','Open Time','1','project_create',NULL,'13','label','20','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('72','ctime','Close Time','0','project_create',NULL,'14','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('73','bin_id','Bin','1','project_create',NULL,'5','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('74','type_id','Type','0','project_create',NULL,'6','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('75','system_id','System','1','project_create',NULL,'7','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('76','user_id','Owner','1','project_create',NULL,'8','searchbox','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('78','tested','Testing','0','project_create',NULL,'9','checkbox','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('79','approved','Approval','0','project_create',NULL,'10','checkbox','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('80','relations','Related','0','project_create',NULL,'11','searchbox','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('81','project_id','Parent Project','1','project_create',NULL,'2','searchbox','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('82','est_hours','Estimated Hours','0','project_create',NULL,'15','text','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('83','start_date','Start Date','1','project_create','+1 day','16','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('84','deadline','Deadline','1','project_create','+1 month','17','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('85','wkd_hours','Hours Worked','0','project_create','0','18','text','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('86','custom_string1',NULL,'0','project_create',NULL,'19','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('87','custom_string2',NULL,'0','project_create',NULL,'20','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('88','custom_text1',NULL,'0','project_create',NULL,'21','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('89','custom_number1',NULL,'0','project_create','0','22','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('90','custom_number2',NULL,'0','project_create','0','25','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('91','custom_boolean1',NULL,'0','project_create',NULL,'26','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('92','custom_boolean2',NULL,'0','project_create',NULL,'27','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('93','custom_menu1',NULL,'0','project_create',NULL,'28','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('94','custom_menu2',NULL,'0','project_create',NULL,'29','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('95','section1','Properties','1','project_create',NULL,'1','section',NULL,'1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('96','section2','Time Table','1','project_create',NULL,'12','section',NULL,'1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('97','section3','Description','1','project_create',NULL,'23','section',NULL,'1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('98','id','ID','1','project_edit',NULL,'1','label','8','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('99','title','Title','1','project_edit',NULL,'4','text','200','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('100','priority','Priority','1','project_edit',NULL,'6','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('101','status','Status','0','project_edit',NULL,'2','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('102','description','Description','1','project_edit',NULL,'27','text','60','10','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('103','otime','Open Time','0','project_edit',NULL,'16','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('104','ctime','Close Time','0','project_edit',NULL,'17','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('105','bin_id','Bin','1','project_edit',NULL,'7','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('106','type_id','Type','1','project_edit',NULL,'8','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('107','system_id','System','1','project_edit',NULL,'9','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('108','user_id','Owner','1','project_edit',NULL,'10','searchbox','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('109','creator_id','Creator','0','project_edit',NULL,'11','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('110','tested','Testing','0','project_edit',NULL,'12','menu','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('111','approved','Approval','1','project_edit',NULL,'13','menu','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('112','relations','Related','1','project_edit',NULL,'14','searchbox','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('113','project_id','Project','1','project_edit',NULL,'3','searchbox','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('114','est_hours','Estimated Hours','0','project_edit',NULL,'18','text','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('115','start_date','Start Date','1','project_edit','+1 day','19','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('116','deadline','Deadline','1','project_edit','+1 month','20','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('117','wkd_hours','Hours Worked','0','project_edit','0','21','text','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('118','custom_string1',NULL,'0','project_edit',NULL,'22','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('119','custom_string2',NULL,'0','project_edit',NULL,'23','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('120','custom_text1',NULL,'0','project_edit',NULL,'24','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('121','custom_number1',NULL,'0','project_edit','0','25','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('122','custom_number2',NULL,'0','project_edit','0','28','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('123','custom_boolean1',NULL,'0','project_edit',NULL,'29','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('124','custom_boolean2',NULL,'0','project_edit',NULL,'30','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('125','custom_menu1',NULL,'0','project_edit',NULL,'31','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('126','custom_menu2',NULL,'0','project_edit',NULL,'32','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('127','section1','Properties','1','project_edit',NULL,'5','section',NULL,'1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('128','section2','Time Table','1','project_edit',NULL,'15','section',NULL,'1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('129','section3','Description','1','project_edit',NULL,'26','section',NULL,'1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('130','id','ID','1','ticket_list',NULL,'1','label','8','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('131','title','Title','1','ticket_list',NULL,'20','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('132','priority','Priority','1','ticket_list',NULL,'30','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('133','status','Status','0','ticket_list',NULL,'2','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('134','description','Description','0','ticket_list',NULL,'199','label','60','10','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('135','otime','Open Time','0','ticket_list',NULL,'115','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('136','ctime','Close Time','0','ticket_list',NULL,'3','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('137','bin_id','Bin','1','ticket_list',NULL,'40','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('138','type_id','Type','1','ticket_list',NULL,'50','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('139','system_id','System','0','ticket_list',NULL,'60','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('140','user_id','Owner','1','ticket_list',NULL,'70','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('141','creator_id','Creator','0','ticket_list',NULL,'80','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('142','tested','Testing','0','ticket_list',NULL,'90','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('143','approved','Approval','0','ticket_list',NULL,'94','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('144','relations','Related','0','ticket_list',NULL,'98','label','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('145','project_id','Project','0','ticket_list',NULL,'10','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('146','est_hours','Estimated Hours','0','ticket_list',NULL,'120','label','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('147','start_date','Start Date','0','ticket_list','+1 day','130','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('148','deadline','Deadline','0','ticket_list','+1 month','140','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('149','wkd_hours','Hours Worked','0','ticket_list','0','150','label','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('150','custom_string1',NULL,'0','ticket_list',NULL,'160','label','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('151','custom_string2',NULL,'0','ticket_list',NULL,'170','label','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('152','custom_text1',NULL,'0','ticket_list',NULL,'180','label','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('153','custom_number1',NULL,'0','ticket_list','0','190','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('154','custom_number2',NULL,'0','ticket_list','0','200','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('155','custom_boolean1',NULL,'0','ticket_list','0','210','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('156','custom_boolean2',NULL,'0','ticket_list','0','220','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('157','custom_menu1',NULL,'0','ticket_list',NULL,'230','label','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('158','custom_menu2',NULL,'0','ticket_list',NULL,'240','label','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('160','elapsed','Time','1','ticket_list',NULL,'250','section','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('161','id','ID','1','project_list',NULL,'1','label','8','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('162','title','Title','1','project_list',NULL,'5','label','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('163','priority','Priority','1','project_list',NULL,'6','label','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('164','status','Status','0','project_list',NULL,'2','label','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('165','description','Description','0','project_list',NULL,'24','label','60','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('166','otime','Open Time','0','project_list',NULL,'15','label','20','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('167','ctime','Close Time','0','project_list',NULL,'3','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('168','bin_id','Bin','1','project_list',NULL,'7','label','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('169','type_id','Type','0','project_list',NULL,'8','label','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('170','system_id','System','0','project_list',NULL,'9','label','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('171','user_id','Owner','0','project_list',NULL,'10','label','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('172','creator_id','Creator','0','project_list',NULL,'11','label','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('173','tested','Testing','0','project_list',NULL,'12','label','1','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('174','approved','Approval','0','project_list',NULL,'13','label','1','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('175','relations','Related','0','project_list',NULL,'14','label','200','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('176','project_id','Project','0','project_list',NULL,'4','label','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('177','est_hours','Estimated Hours','0','project_list',NULL,'16','label','6','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('178','start_date','Start Date','1','project_list','+1 day','17','label','20','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('179','deadline','Deadline','1','project_list','+1 month','18','label','20','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('180','wkd_hours','Hours Worked','0','project_list','0','19','label','6','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('181','custom_string1',NULL,'0','project_list',NULL,'20','label','200','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('182','custom_string2',NULL,'0','project_list',NULL,'21','label','200','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('183','custom_text1',NULL,'0','project_list',NULL,'22','label','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('184','custom_number1',NULL,'0','project_list','0','23','label','10','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('185','custom_number2',NULL,'0','project_list','0','25','label','10','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('186','custom_boolean1',NULL,'0','project_list','0','26','label','1','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('187','custom_boolean2',NULL,'0','project_list','0','27','label','1','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('188','custom_menu1',NULL,'0','project_list',NULL,'28','label','100','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('189','custom_menu2',NULL,'0','project_list',NULL,'29','label','100','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('191','elapsed','Time','0','project_list',NULL,'30','section',NULL,'1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('192','id','ID','1','search_list',NULL,'1','label','8','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('193','title','Title','1','search_list',NULL,'20','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('194','priority','Priority','1','search_list',NULL,'30','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('195','status','Status','0','search_list',NULL,'2','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('196','description','Description','0','search_list',NULL,'199','label','60','10','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('197','otime','Open Time','0','search_list',NULL,'115','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('198','ctime','Close Time','0','search_list',NULL,'3','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('199','bin_id','Bin','1','search_list',NULL,'40','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('200','type_id','Type','1','search_list',NULL,'50','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('201','system_id','System','0','search_list',NULL,'60','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('202','user_id','Owner','1','search_list',NULL,'70','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('203','creator_id','Creator','0','search_list',NULL,'80','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('204','tested','Testing','0','search_list',NULL,'90','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('205','approved','Approval','0','search_list',NULL,'94','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('206','relations','Related','0','search_list',NULL,'98','label','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('207','project_id','Project','0','search_list',NULL,'10','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('208','est_hours','Estimated Hours','0','search_list',NULL,'120','label','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('209','start_date','Start Date','0','search_list','+1 day','130','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('210','deadline','Deadline','0','search_list','+1 month','140','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('211','wkd_hours','Hours Worked','0','search_list','0','150','label','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('212','custom_string1',NULL,'0','search_list',NULL,'160','label','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('213','custom_string2',NULL,'0','search_list',NULL,'170','label','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('214','custom_text1',NULL,'0','search_list',NULL,'180','label','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('215','custom_number1',NULL,'0','search_list','0','190','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('216','custom_number2',NULL,'0','search_list','0','200','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('217','custom_boolean1',NULL,'0','search_list','0','210','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('218','custom_boolean2',NULL,'0','search_list','0','220','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('219','custom_menu1',NULL,'0','search_list',NULL,'230','label','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('220','custom_menu2',NULL,'0','search_list',NULL,'240','label','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('221','elapsed','Time','1','search_list',NULL,'250','section','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('223','title','Title','1','search_form',NULL,'1','text','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('224','priority','Priority','1','search_form',NULL,'9','menu','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('225','status','Status','1','search_form',NULL,'10','menu','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('226','description','Description','1','search_form',NULL,'2','text','60','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('227','otime','Open Time','1','search_form',NULL,'15','date','20',NULL,NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('228','ctime','Close Time','1','search_form',NULL,'16','date','20',NULL,NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('229','bin_id','Bin','1','search_form',NULL,'8','menu','50','4',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('230','type_id','Type','1','search_form',NULL,'11','menu','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('231','system_id','System','1','search_form',NULL,'12','menu','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('232','user_id','Owner','1','search_form',NULL,'13','searchbox','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('233','creator_id','Creator','1','search_form',NULL,'14','searchbox','20','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('234','tested','Testing','1','search_form',NULL,'22','radio','1','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('235','approved','Approval','1','search_form',NULL,'21','menu','1','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('236','relations','Related','0','search_form',NULL,'24','searchbox','200','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('237','project_id','Project','0','search_form',NULL,'23','searchbox','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('238','est_hours','Estimated Hours','0','search_form',NULL,'19','text','6','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('239','start_date','Start Date','1','search_form',NULL,'17','date','20',NULL,NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('240','deadline','Deadline','1','search_form',NULL,'18','date','20',NULL,NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('241','wkd_hours','Hours Worked','0','search_form','0','20','text','6','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('242','custom_string1',NULL,'0','search_form',NULL,'3','text','200','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('243','custom_string2','22','1','search_form','aa','4','text','4','2',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('244','custom_text1',NULL,'0','search_form',NULL,'5','text','50','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('245','custom_number1',NULL,'0','search_form','0','6','text','10','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('246','custom_number2',NULL,'0','search_form','0','7','text','10','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('247','custom_boolean1','true or false','1','search_form','0','25','menu','1','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('248','custom_boolean2',NULL,'0','search_form','0','26','menu','1','1',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('249','custom_menu1',NULL,'0','search_form',NULL,'27','menu','100','4',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('250','custom_menu2',NULL,'0','search_form',NULL,'28','menu','100','4',NULL);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('251','id','ID','0','ticket_close',NULL,'1','label','8','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('252','title','Title','0','ticket_close',NULL,'5','text','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('253','priority','Priority','0','ticket_close',NULL,'6','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('254','status','Status','0','ticket_close',NULL,'2','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('255','description','Description','0','ticket_close',NULL,'20','text','60','10','0');
## insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('256','otime','Open Time','0','ticket_close',NULL,'15','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('257','ctime','Close Time','0','ticket_close',NULL,'3','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('258','bin_id','Bin','0','ticket_close',NULL,'7','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('259','type_id','Type','0','ticket_close',NULL,'8','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('260','system_id','System','0','ticket_close',NULL,'9','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('261','user_id','Owner','0','ticket_close',NULL,'10','searchbox','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('262','creator_id','Creator','0','ticket_close',NULL,'11','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('263','tested','Testing','0','ticket_close',NULL,'12','checkbox','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('264','approved','Approval','0','ticket_close',NULL,'13','checkbox','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('265','relations','Related','0','ticket_close',NULL,'14','searchbox','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('266','project_id','Project','0','ticket_close',NULL,'4','searchbox','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('267','est_hours','Estimated Hours','0','ticket_close',NULL,'16','text','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('268','start_date','Start Date','0','ticket_close','+1 day','17','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('269','deadline','Deadline','0','ticket_close','+1 month','18','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('270','wkd_hours','Hours Worked','0','ticket_close','0','19','text','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('271','custom_string1',NULL,'0','ticket_close',NULL,'21','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('272','custom_string2',NULL,'0','ticket_close',NULL,'22','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('273','custom_text1',NULL,'0','ticket_close',NULL,'23','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('274','custom_number1',NULL,'0','ticket_close','0','24','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('275','custom_number2',NULL,'0','ticket_close','0','25','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('276','custom_boolean1',NULL,'0','ticket_close',NULL,'26','checkbox','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('277','custom_boolean2',NULL,'0','ticket_close',NULL,'27','checkbox','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('278','custom_menu1',NULL,'0','ticket_close',NULL,'28','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('279','custom_menu2',NULL,'0','ticket_close',NULL,'29','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('280','hours','Hours','1','ticket_close',NULL,'30','text','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES('281','comments','Comments','1','ticket_close',NULL,'31','text','60','10','1');


# ADDED IN VERSION 2.6

insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(282,'custom_date1','date 1','0','project_create',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(283,'custom_date2','date 2','0','project_create',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(284, 'custom_multi1', null, 0, 'project_create', null, 100, 'menu', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(285, 'custom_multi2', null, 0, 'project_create', null, 100, 'menu', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(286, 'custom_multi1', null, 0, 'project_custom', null, 100, 'menu', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(287, 'custom_multi2', null, 0, 'project_custom', null, 100, 'menu', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(288,'custom_date1','date 1','0','project_edit',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(289,'custom_date2','date 2','0','project_edit',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(290, 'custom_multi1', null, 0, 'project_edit', null, 100, 'menu', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(291, 'custom_multi2', null, 0, 'project_edit', null, 100, 'menu', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(292,'custom_date1','date 1','0','project_list',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(293,'custom_date2','date 2','0','project_list',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(294, 'custom_multi1', null, 0, 'project_list', null, 100, 'menu', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(295, 'custom_multi2', null, 0, 'project_list', null, 100, 'menu', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(296,'bin_id','bin','1','project_list_filters',null,'10','menu','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(297,'creator_id','creator','0','project_list_filters',null,'50','menu','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(298,'custom_menu1',null,'0','project_list_filters',null,'100','menu','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(299,'custom_menu2',null,'0','project_list_filters',null,'100','menu','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(300,'priority','priority','1','project_list_filters',null,'30','menu','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(301,'status','status','1','project_list_filters','OPEN,PENDING','20','menu','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(302,'system_id','system','0','project_list_filters',null,'60','menu','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(303,'user_id','owner','1','project_list_filters',null,'40','menu','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(304,'approved','approval','0','project_tab_1',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(305,'bin_id','bin','0','project_tab_1',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(306,'creator_id','creator','0','project_tab_1',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(307,'ctime','close time','0','project_tab_1',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(308,'custom_boolean1',null,'0','project_tab_1',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(309,'custom_boolean2',null,'0','project_tab_1',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(310,'custom_date1','date 1','0','project_tab_1',null,'52','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(311,'custom_date2','date 2','0','project_tab_1',null,'50','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(312,'custom_menu1',null,'0','project_tab_1',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(313,'custom_menu2',null,'0','project_tab_1',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(314, 'custom_multi1', null, 0, 'project_tab_1', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(315, 'custom_multi2', null, 0, 'project_tab_1', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(316,'custom_number1',null,'0','project_tab_1',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(317,'custom_number2',null,'0','project_tab_1',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(318,'custom_string1',null,'0','project_tab_1',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(319,'custom_string2',null,'0','project_tab_1',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(320,'custom_text1',null,'0','project_tab_1',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(321,'deadline','deadline','0','project_tab_1',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(322,'elapsed','elapsed','0','project_tab_1',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(323,'est_hours','estimated hours','0','project_tab_1',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(324,'otime','open time','0','project_tab_1',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(325,'priority','priority','0','project_tab_1',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(326,'project_id','project','0','project_tab_1',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(327,'start_date','start date','0','project_tab_1',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(328,'status','status','0','project_tab_1',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(329,'system_id','system','0','project_tab_1',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(330,'tested','testing','0','project_tab_1',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(331,'type_id','type','0','project_tab_1',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(332,'user_id','owner','0','project_tab_1',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(333,'wkd_hours','hours worked','0','project_tab_1',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(334,'approved','approval','1','project_tab_2',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(335,'bin_id','bin','1','project_tab_2',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(336,'creator_id','creator','0','project_tab_2',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(337,'ctime','close time','0','project_tab_2',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(338,'custom_boolean1',null,'0','project_tab_2',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(339,'custom_boolean2',null,'0','project_tab_2',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(340,'custom_date1','date 1','0','project_tab_2',null,'52','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(341,'custom_date2','date 2','0','project_tab_2',null,'50','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(342,'custom_menu1',null,'0','project_tab_2',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(343,'custom_menu2',null,'0','project_tab_2',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(344, 'custom_multi1', null, 0, 'project_tab_2', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(345, 'custom_multi2', null, 0, 'project_tab_2', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(346,'custom_number1',null,'0','project_tab_2',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(347,'custom_number2',null,'0','project_tab_2',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(348,'custom_string1',null,'0','project_tab_2',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(349,'custom_string2',null,'0','project_tab_2',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(350,'custom_text1',null,'0','project_tab_2',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(351,'deadline','deadline','0','project_tab_2',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(352,'elapsed','elapsed','0','project_tab_2',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(353,'est_hours','estimated hours','0','project_tab_2',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(354,'otime','open time','0','project_tab_2',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(355,'priority','priority','0','project_tab_2',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(356,'project_id','project','0','project_tab_2',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(357,'start_date','start date','0','project_tab_2',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(358,'status','status','0','project_tab_2',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(359,'system_id','system','1','project_tab_2',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(360,'tested','testing','1','project_tab_2',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(361,'type_id','type','1','project_tab_2',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(362,'user_id','owner','0','project_tab_2',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(363,'wkd_hours','hours worked','0','project_tab_2',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(364,'approved','approval','0','project_tab_3',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(365,'bin_id','bin','0','project_tab_3',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(366,'creator_id','creator','0','project_tab_3',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(367,'ctime','close time','0','project_tab_3',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(368,'custom_boolean1',null,'0','project_tab_3',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(369,'custom_boolean2',null,'0','project_tab_3',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(370,'custom_date1','date 1','0','project_tab_3',null,'52','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(371,'custom_date2','date 2','0','project_tab_3',null,'50','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(372,'custom_menu1',null,'0','project_tab_3',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(373,'custom_menu2',null,'0','project_tab_3',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(374, 'custom_multi1', null, 0, 'project_tab_3', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(375, 'custom_multi2', null, 0, 'project_tab_3', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(376,'custom_number1',null,'0','project_tab_3',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(377,'custom_number2',null,'0','project_tab_3',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(378,'custom_string1',null,'0','project_tab_3',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(379,'custom_string2',null,'0','project_tab_3',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(380,'custom_text1',null,'0','project_tab_3',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(381,'deadline','deadline','0','project_tab_3',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(382,'elapsed','elapsed','0','project_tab_3',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(383,'est_hours','estimated hours','0','project_tab_3',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(384,'otime','open time','0','project_tab_3',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(385,'priority','priority','0','project_tab_3',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(386,'project_id','project','0','project_tab_3',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(387,'start_date','start date','0','project_tab_3',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(388,'status','status','0','project_tab_3',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(389,'system_id','system','0','project_tab_3',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(390,'tested','testing','0','project_tab_3',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(391,'type_id','type','0','project_tab_3',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(392,'user_id','owner','0','project_tab_3',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(393,'wkd_hours','hours worked','0','project_tab_3',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(394,'approved','approval','0','project_tab_4',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(395,'bin_id','bin','0','project_tab_4',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(396,'creator_id','creator','0','project_tab_4',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(397,'ctime','close time','0','project_tab_4',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(398,'custom_boolean1',null,'0','project_tab_4',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(399,'custom_boolean2',null,'0','project_tab_4',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(400,'custom_date1','date 1','0','project_tab_4',null,'52','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(401,'custom_date2','date 2','0','project_tab_4',null,'50','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(402,'custom_menu1',null,'0','project_tab_4',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(403,'custom_menu2',null,'0','project_tab_4',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(404, 'custom_multi1', null, 0, 'project_tab_4', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(405, 'custom_multi2', null, 0, 'project_tab_4', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(406,'custom_number1',null,'0','project_tab_4',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(407,'custom_number2',null,'0','project_tab_4',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(408,'custom_string1',null,'0','project_tab_4',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(409,'custom_string2',null,'0','project_tab_4',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(410,'custom_text1',null,'0','project_tab_4',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(411,'deadline','deadline','0','project_tab_4',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(412,'elapsed','elapsed','0','project_tab_4',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(413,'est_hours','estimated hours','0','project_tab_4',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(414,'otime','open time','0','project_tab_4',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(415,'priority','priority','0','project_tab_4',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(416,'project_id','project','0','project_tab_4',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(417,'start_date','start date','0','project_tab_4',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(418,'status','status','0','project_tab_4',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(419,'system_id','system','0','project_tab_4',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(420,'tested','testing','0','project_tab_4',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(421,'type_id','type','0','project_tab_4',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(422,'user_id','owner','0','project_tab_4',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(423,'wkd_hours','hours worked','0','project_tab_4',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(424,'approved','approval','0','project_tab_5',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(425,'bin_id','bin','0','project_tab_5',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(426,'creator_id','creator','0','project_tab_5',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(427,'ctime','close time','0','project_tab_5',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(428,'custom_boolean1',null,'0','project_tab_5',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(429,'custom_boolean2',null,'0','project_tab_5',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(430,'custom_date1','date 1','0','project_tab_5',null,'52','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(431,'custom_date2','date 2','0','project_tab_5',null,'50','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(432,'custom_menu1',null,'0','project_tab_5',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(433,'custom_menu2',null,'0','project_tab_5',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(434, 'custom_multi1', null, 0, 'project_tab_5', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(435, 'custom_multi2', null, 0, 'project_tab_5', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(436,'custom_number1',null,'0','project_tab_5',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(437,'custom_number2',null,'0','project_tab_5',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(438,'custom_string1',null,'0','project_tab_5',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(439,'custom_string2',null,'0','project_tab_5',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(440,'custom_text1',null,'0','project_tab_5',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(441,'deadline','deadline','0','project_tab_5',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(442,'elapsed','elapsed','0','project_tab_5',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(443,'est_hours','estimated hours','0','project_tab_5',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(444,'otime','open time','0','project_tab_5',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(445,'priority','priority','0','project_tab_5',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(446,'project_id','project','0','project_tab_5',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(447,'start_date','start date','0','project_tab_5',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(448,'status','status','0','project_tab_5',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(449,'system_id','system','0','project_tab_5',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(450,'tested','testing','0','project_tab_5',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(451,'type_id','type','0','project_tab_5',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(452,'user_id','owner','0','project_tab_5',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(453,'wkd_hours','hours worked','0','project_tab_5',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(454,'approved','approval','0','project_tab_6',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(455,'bin_id','bin','0','project_tab_6',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(456,'creator_id','creator','0','project_tab_6',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(457,'ctime','close time','0','project_tab_6',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(458,'custom_boolean1',null,'0','project_tab_6',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(459,'custom_boolean2',null,'0','project_tab_6',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(460,'custom_date1','date 1','0','project_tab_6',null,'52','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(461,'custom_date2','date 2','0','project_tab_6',null,'50','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(462,'custom_menu1',null,'0','project_tab_6',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(463,'custom_menu2',null,'0','project_tab_6',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(464, 'custom_multi1', null, 0, 'project_tab_6', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(465, 'custom_multi2', null, 0, 'project_tab_6', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(466,'custom_number1',null,'0','project_tab_6',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(467,'custom_number2',null,'0','project_tab_6',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(468,'custom_string1',null,'0','project_tab_6',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(469,'custom_string2',null,'0','project_tab_6',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(470,'custom_text1',null,'0','project_tab_6',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(471,'deadline','deadline','0','project_tab_6',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(472,'elapsed','elapsed','0','project_tab_6',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(473,'est_hours','estimated hours','0','project_tab_6',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(474,'otime','open time','0','project_tab_6',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(475,'priority','priority','0','project_tab_6',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(476,'project_id','project','0','project_tab_6',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(477,'start_date','start date','0','project_tab_6',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(478,'status','status','0','project_tab_6',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(479,'system_id','system','0','project_tab_6',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(480,'tested','testing','0','project_tab_6',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(481,'type_id','type','0','project_tab_6',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(482,'user_id','owner','0','project_tab_6',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(483,'wkd_hours','hours worked','0','project_tab_6',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(484,'approved','approval','0','project_tab_7',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(485,'bin_id','bin','0','project_tab_7',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(486,'creator_id','creator','0','project_tab_7',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(487,'ctime','close time','0','project_tab_7',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(488,'custom_boolean1',null,'0','project_tab_7',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(489,'custom_boolean2',null,'0','project_tab_7',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(490,'custom_date1','date 1','0','project_tab_7',null,'52','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(491,'custom_date2','date 2','0','project_tab_7',null,'50','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(492,'custom_menu1',null,'0','project_tab_7',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(493,'custom_menu2',null,'0','project_tab_7',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(494, 'custom_multi1', null, 0, 'project_tab_7', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(495, 'custom_multi2', null, 0, 'project_tab_7', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(496,'custom_number1',null,'0','project_tab_7',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(497,'custom_number2',null,'0','project_tab_7',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(498,'custom_string1',null,'0','project_tab_7',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(499,'custom_string2',null,'0','project_tab_7',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(500,'custom_text1',null,'0','project_tab_7',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(501,'deadline','deadline','0','project_tab_7',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(502,'elapsed','elapsed','0','project_tab_7',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(503,'est_hours','estimated hours','0','project_tab_7',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(504,'otime','open time','0','project_tab_7',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(505,'priority','priority','0','project_tab_7',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(506,'project_id','project','0','project_tab_7',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(507,'start_date','start date','0','project_tab_7',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(508,'status','status','0','project_tab_7',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(509,'system_id','system','0','project_tab_7',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(510,'tested','testing','0','project_tab_7',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(511,'type_id','type','0','project_tab_7',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(512,'user_id','owner','0','project_tab_7',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(513,'wkd_hours','hours worked','0','project_tab_7',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(514,'approved','approval','0','project_tab_8',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(515,'bin_id','bin','0','project_tab_8',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(516,'creator_id','creator','0','project_tab_8',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(517,'ctime','close time','0','project_tab_8',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(518,'custom_boolean1',null,'0','project_tab_8',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(519,'custom_boolean2',null,'0','project_tab_8',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(520,'custom_date1','date 1','0','project_tab_8',null,'52','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(521,'custom_date2','date 2','0','project_tab_8',null,'50','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(522,'custom_menu1',null,'0','project_tab_8',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(523,'custom_menu2',null,'0','project_tab_8',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(524, 'custom_multi1', null, 0, 'project_tab_8', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(525, 'custom_multi2', null, 0, 'project_tab_8', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(526,'custom_number1',null,'0','project_tab_8',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(527,'custom_number2',null,'0','project_tab_8',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(528,'custom_string1',null,'0','project_tab_8',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(529,'custom_string2',null,'0','project_tab_8',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(530,'custom_text1',null,'0','project_tab_8',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(531,'deadline','deadline','0','project_tab_8',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(532,'elapsed','elapsed','0','project_tab_8',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(533,'est_hours','estimated hours','0','project_tab_8',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(534,'otime','open time','0','project_tab_8',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(535,'priority','priority','0','project_tab_8',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(536,'project_id','project','0','project_tab_8',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(537,'start_date','start date','0','project_tab_8',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(538,'status','status','0','project_tab_8',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(539,'system_id','system','0','project_tab_8',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(540,'tested','testing','0','project_tab_8',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(541,'type_id','type','0','project_tab_8',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(542,'user_id','owner','0','project_tab_8',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(543,'wkd_hours','hours worked','0','project_tab_8',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(544,'approved','approval','0','project_tasks',null,'13','label','1','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(545,'bin_id','bin','0','project_tasks',null,'7','label','50','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(546,'creator_id','creator','0','project_tasks',null,'11','label','50','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(547,'ctime','close time','0','project_tasks',null,'3','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(548,'custom_boolean1',null,'0','project_tasks',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(549,'custom_boolean2',null,'0','project_tasks',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(550,'custom_date1','date 1','0','project_tasks',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(551,'custom_date2','date 2','0','project_tasks',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(552,'custom_menu1',null,'0','project_tasks',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(553,'custom_menu2',null,'0','project_tasks',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(554,'custom_number1',null,'0','project_tasks',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(555,'custom_number2',null,'0','project_tasks',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(556,'custom_string1',null,'0','project_tasks',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(557,'custom_string2',null,'0','project_tasks',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(558,'custom_text1',null,'0','project_tasks',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(559,'deadline','deadline','0','project_tasks','+1 month','18','label','20','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(560,'description','details','0','project_tasks',null,'24','label','60','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(561,'elapsed','time','0','project_tasks',null,'30','section',null,'1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(562,'est_hours','estimated hours','1','project_tasks',null,'16','label','6','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(563,'id','id','1','project_tasks',null,'1','label','8','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(564,'otime','open time','0','project_tasks',null,'15','label','20','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(565,'priority','priority','1','project_tasks',null,'6','label','50','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(566,'project_id','project','0','project_tasks',null,'4','label','50','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(567,'relations','related','0','project_tasks',null,'14','label','200','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(568,'start_date','start date','0','project_tasks','+1 day','17','label','20','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(569,'status','status','1','project_tasks',null,'2','label','50','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(570,'system_id','system','0','project_tasks',null,'9','label','50','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(571,'tested','testing','0','project_tasks',null,'12','label','1','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(572,'title','summary','1','project_tasks',null,'5','label','50','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(573,'type_id','type','1','project_tasks',null,'8','label','50','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(574,'user_id','owner','0','project_tasks',null,'10','label','50','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(575,'wkd_hours','hours worked','1','project_tasks','0','19','label','6','1',null);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(576,'custom_date1','date 1','0','search_form',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(577,'custom_date2','date 2','0','search_form',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(578, 'custom_multi1',  null, 0, 'search_form', null, 100, 'menu', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(579, 'custom_multi2',  null, 0, 'search_form', null, 100, 'menu', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(580,'custom_date1','date 1','0','search_list',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(581,'custom_date2','date 2','0','search_list',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(582, 'custom_multi1', null, 0, 'search_list', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(583, 'custom_multi2', null, 0, 'search_list', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(584,'custom_date1','date 1','0','ticket_close',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(585,'custom_date2','date 2','0','ticket_close',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(586, 'custom_multi1', null, 0, 'ticket_close', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(587, 'custom_multi2', null, 0, 'ticket_close', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(588,'custom_date1','date 1','0','ticket_create',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(589,'custom_date2','date 2','0','ticket_create',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(590, 'custom_multi1', null, 0, 'ticket_create', null, 100, 'menu', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(591, 'custom_multi2', null, 0, 'ticket_create', null, 100, 'menu', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(592, 'custom_multi1', null, 0, 'ticket_custom', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(593, 'custom_multi2', null, 0, 'ticket_custom', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(594,'custom_date1','date 1','0','ticket_edit',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(595,'custom_date2','date 2','0','ticket_edit',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(596, 'custom_multi1', null, 0, 'ticket_edit', null, 100, 'menu', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(597, 'custom_multi2', null, 0, 'ticket_edit', null, 100, 'menu', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(598,'custom_date1','date 1','0','ticket_list',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(599,'custom_date2','date 2','0','ticket_list',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(600, 'custom_multi1', null, 0, 'ticket_list', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(601, 'custom_multi2', null, 0, 'ticket_list', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(602,'bin_id','bin','1','ticket_list_filters',null,'10','menu','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(603,'creator_id','creator','0','ticket_list_filters',null,'70','menu','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(604,'custom_menu1',null,'0','ticket_list_filters',null,'100','menu','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(605,'custom_menu2',null,'0','ticket_list_filters',null,'100','menu','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(606,'priority','priority','1','ticket_list_filters',null,'20','menu','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(607,'status','status','1','ticket_list_filters','OPEN,PENDING','30','menu','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(608,'system_id','system','0','ticket_list_filters',null,'60','menu','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(609,'type_id','type','1','ticket_list_filters',null,'50','menu','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(610,'user_id','owner','1','ticket_list_filters',null,'40','menu','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(611,'approved','approval','0','ticket_tab_1',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(612,'bin_id','bin','0','ticket_tab_1',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(613,'creator_id','creator','0','ticket_tab_1',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(614,'ctime','close time','0','ticket_tab_1',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(615,'custom_boolean1',null,'0','ticket_tab_1',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(616,'custom_boolean2',null,'0','ticket_tab_1',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(617,'custom_date1','date 1','0','ticket_tab_1',null,'52','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(618,'custom_date2','date 2','0','ticket_tab_1',null,'50','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(619,'custom_menu1',null,'0','ticket_tab_1',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(620,'custom_menu2',null,'0','ticket_tab_1',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(621, 'custom_multi1', null, 0, 'ticket_tab_1', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(622, 'custom_multi2', null, 0, 'ticket_tab_1', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(623,'custom_number1',null,'0','ticket_tab_1',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(624,'custom_number2',null,'0','ticket_tab_1',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(625,'custom_string1',null,'0','ticket_tab_1',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(626,'custom_string2',null,'0','ticket_tab_1',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(627,'custom_text1',null,'0','ticket_tab_1',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(628,'deadline','deadline','0','ticket_tab_1',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(629,'elapsed','elapsed','0','ticket_tab_1',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(630,'est_hours','estimated hours','0','ticket_tab_1',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(631,'otime','open time','0','ticket_tab_1',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(632,'priority','priority','0','ticket_tab_1',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(633,'project_id','project','0','ticket_tab_1',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(634,'start_date','start date','0','ticket_tab_1',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(635,'status','status','0','ticket_tab_1',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(636,'system_id','system','0','ticket_tab_1',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(637,'tested','testing','0','ticket_tab_1',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(638,'type_id','type','0','ticket_tab_1',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(639,'user_id','owner','0','ticket_tab_1',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(640,'wkd_hours','hours worked','0','ticket_tab_1',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(641,'approved','approval','1','ticket_tab_2',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(642,'bin_id','bin','1','ticket_tab_2',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(643,'creator_id','creator','0','ticket_tab_2',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(644,'ctime','close time','0','ticket_tab_2',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(645,'custom_boolean1',null,'0','ticket_tab_2',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(646,'custom_boolean2',null,'0','ticket_tab_2',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(647,'custom_date1','date 1','0','ticket_tab_2',null,'52','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(648,'custom_date2','date 2','0','ticket_tab_2',null,'50','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(649,'custom_menu1',null,'0','ticket_tab_2',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(650,'custom_menu2',null,'0','ticket_tab_2',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(651, 'custom_multi1', null, 0, 'ticket_tab_2', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(652, 'custom_multi2', null, 0, 'ticket_tab_2', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(653,'custom_number1',null,'0','ticket_tab_2',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(654,'custom_number2',null,'0','ticket_tab_2',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(655,'custom_string1',null,'0','ticket_tab_2',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(656,'custom_string2',null,'0','ticket_tab_2',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(657,'custom_text1',null,'0','ticket_tab_2',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(658,'deadline','deadline','0','ticket_tab_2',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(659,'elapsed','elapsed','0','ticket_tab_2',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(660,'est_hours','estimated hours','0','ticket_tab_2',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(661,'otime','open time','0','ticket_tab_2',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(662,'priority','priority','0','ticket_tab_2',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(663,'project_id','project','0','ticket_tab_2',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(664,'start_date','start date','0','ticket_tab_2',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(665,'status','status','0','ticket_tab_2',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(666,'system_id','system','1','ticket_tab_2',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(667,'tested','testing','1','ticket_tab_2',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(668,'type_id','type','1','ticket_tab_2',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(669,'user_id','owner','0','ticket_tab_2',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(670,'wkd_hours','hours worked','0','ticket_tab_2',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(671,'approved','approval','0','ticket_tab_3',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(672,'bin_id','bin','0','ticket_tab_3',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(673,'creator_id','creator','0','ticket_tab_3',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(674,'ctime','close time','0','ticket_tab_3',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(675,'custom_boolean1',null,'1','ticket_tab_3',null,'100','checkbox','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(676,'custom_boolean2',null,'1','ticket_tab_3',null,'100','checkbox','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(677,'custom_date1','date 1','1','ticket_tab_3',null,'52','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(678,'custom_date2','date 2','1','ticket_tab_3',null,'50','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(679,'custom_menu1',null,'1','ticket_tab_3',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(680,'custom_menu2',null,'1','ticket_tab_3',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(681, 'custom_multi1', null, 0, 'ticket_tab_3', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(682, 'custom_multi2', null, 0, 'ticket_tab_3', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(683,'custom_number1',null,'1','ticket_tab_3',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(684,'custom_number2',null,'1','ticket_tab_3',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(685,'custom_string1',null,'1','ticket_tab_3',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(686,'custom_string2',null,'1','ticket_tab_3',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(687,'custom_text1',null,'0','ticket_tab_3',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(688,'deadline','deadline','0','ticket_tab_3',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(689,'elapsed','elapsed','0','ticket_tab_3',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(690,'est_hours','estimated hours','0','ticket_tab_3',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(691,'otime','open time','0','ticket_tab_3',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(692,'priority','priority','0','ticket_tab_3',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(693,'project_id','project','0','ticket_tab_3',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(694,'start_date','start date','0','ticket_tab_3',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(695,'status','status','0','ticket_tab_3',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(696,'system_id','system','0','ticket_tab_3',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(697,'tested','testing','0','ticket_tab_3',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(698,'type_id','type','0','ticket_tab_3',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(699,'user_id','owner','0','ticket_tab_3',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(700,'wkd_hours','hours worked','0','ticket_tab_3',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(701,'approved','approval','0','ticket_tab_4',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(702,'bin_id','bin','0','ticket_tab_4',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(703,'creator_id','creator','0','ticket_tab_4',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(704,'ctime','close time','0','ticket_tab_4',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(705,'custom_boolean1',null,'0','ticket_tab_4',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(706,'custom_boolean2',null,'0','ticket_tab_4',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(707,'custom_date1','date 1','0','ticket_tab_4',null,'52','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(708,'custom_date2','date 2','0','ticket_tab_4',null,'50','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(709,'custom_menu1',null,'0','ticket_tab_4',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(710,'custom_menu2',null,'0','ticket_tab_4',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(711, 'custom_multi1', null, 0, 'ticket_tab_4', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(712, 'custom_multi2', null, 0, 'ticket_tab_4', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(713,'custom_number1',null,'0','ticket_tab_4',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(714,'custom_number2',null,'0','ticket_tab_4',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(715,'custom_string1',null,'0','ticket_tab_4',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(716,'custom_string2',null,'0','ticket_tab_4',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(717,'custom_text1',null,'0','ticket_tab_4',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(718,'deadline','deadline','0','ticket_tab_4',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(719,'elapsed','elapsed','0','ticket_tab_4',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(720,'est_hours','estimated hours','0','ticket_tab_4',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(721,'otime','open time','0','ticket_tab_4',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(722,'priority','priority','0','ticket_tab_4',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(723,'project_id','project','0','ticket_tab_4',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(724,'start_date','start date','0','ticket_tab_4',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(725,'status','status','0','ticket_tab_4',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(726,'system_id','system','0','ticket_tab_4',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(727,'tested','testing','0','ticket_tab_4',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(728,'type_id','type','0','ticket_tab_4',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(729,'user_id','owner','0','ticket_tab_4',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(730,'wkd_hours','hours worked','0','ticket_tab_4',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(731,'approved','approval','0','ticket_tab_5',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(732,'bin_id','bin','0','ticket_tab_5',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(733,'creator_id','creator','0','ticket_tab_5',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(734,'ctime','close time','0','ticket_tab_5',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(735,'custom_boolean1',null,'0','ticket_tab_5',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(736,'custom_boolean2',null,'0','ticket_tab_5',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(737,'custom_date1','date 1','0','ticket_tab_5',null,'52','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(738,'custom_date2','date 2','0','ticket_tab_5',null,'50','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(739,'custom_menu1',null,'0','ticket_tab_5',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(740,'custom_menu2',null,'0','ticket_tab_5',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(741, 'custom_multi1', null, 0, 'ticket_tab_5', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(742, 'custom_multi2', null, 0, 'ticket_tab_5', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(743,'custom_number1',null,'0','ticket_tab_5',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(744,'custom_number2',null,'0','ticket_tab_5',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(745,'custom_string1',null,'0','ticket_tab_5',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(746,'custom_string2',null,'0','ticket_tab_5',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(747,'custom_text1',null,'0','ticket_tab_5',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(748,'deadline','deadline','0','ticket_tab_5',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(749,'elapsed','elapsed','0','ticket_tab_5',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(750,'est_hours','estimated hours','0','ticket_tab_5',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(751,'otime','open time','0','ticket_tab_5',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(752,'priority','priority','0','ticket_tab_5',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(753,'project_id','project','0','ticket_tab_5',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(754,'start_date','start date','0','ticket_tab_5',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(755,'status','status','0','ticket_tab_5',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(756,'system_id','system','0','ticket_tab_5',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(757,'tested','testing','0','ticket_tab_5',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(758,'type_id','type','0','ticket_tab_5',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(759,'user_id','owner','0','ticket_tab_5',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(760,'wkd_hours','hours worked','0','ticket_tab_5',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(761,'approved','approval','0','ticket_tab_6',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(762,'bin_id','bin','0','ticket_tab_6',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(763,'creator_id','creator','0','ticket_tab_6',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(764,'ctime','close time','0','ticket_tab_6',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(765,'custom_boolean1',null,'0','ticket_tab_6',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(766,'custom_boolean2',null,'0','ticket_tab_6',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(767,'custom_date1','date 1','0','ticket_tab_6',null,'52','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(768,'custom_date2','date 2','0','ticket_tab_6',null,'50','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(769,'custom_menu1',null,'0','ticket_tab_6',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(770,'custom_menu2',null,'0','ticket_tab_6',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(771, 'custom_multi1', null, 0, 'ticket_tab_6', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(772, 'custom_multi2', null, 0, 'ticket_tab_6', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(773,'custom_number1',null,'0','ticket_tab_6',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(774,'custom_number2',null,'0','ticket_tab_6',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(775,'custom_string1',null,'0','ticket_tab_6',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(776,'custom_string2',null,'0','ticket_tab_6',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(777,'custom_text1',null,'0','ticket_tab_6',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(778,'deadline','deadline','0','ticket_tab_6',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(779,'elapsed','elapsed','0','ticket_tab_6',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(780,'est_hours','estimated hours','0','ticket_tab_6',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(781,'otime','open time','0','ticket_tab_6',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(782,'priority','priority','0','ticket_tab_6',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(783,'project_id','project','0','ticket_tab_6',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(784,'start_date','start date','0','ticket_tab_6',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(785,'status','status','0','ticket_tab_6',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(786,'system_id','system','0','ticket_tab_6',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(787,'tested','testing','0','ticket_tab_6',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(788,'type_id','type','0','ticket_tab_6',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(789,'user_id','owner','0','ticket_tab_6',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(790,'wkd_hours','hours worked','0','ticket_tab_6',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(791,'approved','approval','0','ticket_tab_7',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(792,'bin_id','bin','0','ticket_tab_7',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(793,'creator_id','creator','0','ticket_tab_7',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(794,'ctime','close time','0','ticket_tab_7',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(795,'custom_boolean1',null,'0','ticket_tab_7',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(796,'custom_boolean2',null,'0','ticket_tab_7',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(797,'custom_date1','date 1','0','ticket_tab_7',null,'52','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(798,'custom_date2','date 2','0','ticket_tab_7',null,'50','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(799,'custom_menu1',null,'0','ticket_tab_7',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(800,'custom_menu2',null,'0','ticket_tab_7',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(801, 'custom_multi1', null, 0, 'ticket_tab_7', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(802, 'custom_multi2', null, 0, 'ticket_tab_7', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(803,'custom_number1',null,'0','ticket_tab_7',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(804,'custom_number2',null,'0','ticket_tab_7',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(805,'custom_string1',null,'0','ticket_tab_7',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(806,'custom_string2',null,'0','ticket_tab_7',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(807,'custom_text1',null,'0','ticket_tab_7',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(808,'deadline','deadline','0','ticket_tab_7',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(809,'elapsed','elapsed','0','ticket_tab_7',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(810,'est_hours','estimated hours','0','ticket_tab_7',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(811,'otime','open time','0','ticket_tab_7',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(812,'priority','priority','0','ticket_tab_7',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(813,'project_id','project','0','ticket_tab_7',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(814,'start_date','start date','0','ticket_tab_7',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(815,'status','status','0','ticket_tab_7',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(816,'system_id','system','0','ticket_tab_7',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(817,'tested','testing','0','ticket_tab_7',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(818,'type_id','type','0','ticket_tab_7',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(819,'user_id','owner','0','ticket_tab_7',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(820,'wkd_hours','hours worked','0','ticket_tab_7',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(821,'approved','approval','0','ticket_tab_8',null,'30','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(822,'bin_id','bin','0','ticket_tab_8',null,'22','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(823,'creator_id','creator','0','ticket_tab_8',null,'56','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(824,'ctime','close time','0','ticket_tab_8',null,'20','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(825,'custom_boolean1',null,'0','ticket_tab_8',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(826,'custom_boolean2',null,'0','ticket_tab_8',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(827,'custom_date1','date 1','0','ticket_tab_8',null,'52','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(828,'custom_date2','date 2','0','ticket_tab_8',null,'50','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(829,'custom_menu1',null,'0','ticket_tab_8',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(830,'custom_menu2',null,'0','ticket_tab_8',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(831, 'custom_multi1', null, 0, 'ticket_tab_8', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(832, 'custom_multi2', null, 0, 'ticket_tab_8', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(833,'custom_number1',null,'0','ticket_tab_8',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(834,'custom_number2',null,'0','ticket_tab_8',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(835,'custom_string1',null,'0','ticket_tab_8',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(836,'custom_string2',null,'0','ticket_tab_8',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(837,'custom_text1',null,'0','ticket_tab_8',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(838,'deadline','deadline','0','ticket_tab_8',null,'12','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(839,'elapsed','elapsed','0','ticket_tab_8',null,'14','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(840,'est_hours','estimated hours','0','ticket_tab_8',null,'16','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(841,'otime','open time','0','ticket_tab_8',null,'8','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(842,'priority','priority','0','ticket_tab_8',null,'2','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(843,'project_id','project','0','ticket_tab_8',null,'32','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(844,'start_date','start date','0','ticket_tab_8',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(845,'status','status','0','ticket_tab_8',null,'4','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(846,'system_id','system','0','ticket_tab_8',null,'26','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(847,'tested','testing','0','ticket_tab_8',null,'28','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(848,'type_id','type','0','ticket_tab_8',null,'24','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(849,'user_id','owner','0','ticket_tab_8',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(850,'wkd_hours','hours worked','0','ticket_tab_8',null,'18','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(851,'approved','approval','0','ticket_view_top',null,'15','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(852,'bin_id','bin','0','ticket_view_top',null,'11','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(853,'ctime','close time','0','ticket_view_top',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(854,'custom_boolean1',null,'0','ticket_view_top',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(855,'custom_boolean2',null,'0','ticket_view_top',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(856,'custom_date1','date 1','0','ticket_view_top',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(857,'custom_date2','date 2','0','ticket_view_top',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(858,'custom_menu1',null,'0','ticket_view_top',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(859,'custom_menu2',null,'0','ticket_view_top',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(860,'custom_number1',null,'0','ticket_view_top',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(861,'custom_number2',null,'0','ticket_view_top',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(862,'custom_string1',null,'0','ticket_view_top',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(863,'custom_string2',null,'0','ticket_view_top',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(864,'custom_text1',null,'0','ticket_view_top',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(865,'deadline','deadline','1','ticket_view_top',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(866,'elapsed','elapsed','0','ticket_view_top',null,'7','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(867,'est_hours','estimated hours','1','ticket_view_top',null,'8','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(868,'otime','open time','1','ticket_view_top',null,'4','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(869,'priority','priority','1','ticket_view_top',null,'1','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(870,'project_id','project','0','ticket_view_top',null,'16','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(871,'start_date','start date','1','ticket_view_top',null,'5','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(872,'status','status','1','ticket_view_top',null,'2','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(873,'system_id','system','0','ticket_view_top',null,'13','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(874,'tested','testing','0','ticket_view_top',null,'14','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(875,'type_id','type','0','ticket_view_top',null,'12','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(876,'user_id','owner','1','ticket_view_top',null,'3','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(877,'wkd_hours','hours worked','1','ticket_view_top',null,'9','label','10','1','0');

# project_close
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(878,'approved','approval','0','project_close',null,'13','checkbox','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(879,'bin_id','bin','0','project_close',null,'7','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(880,'comments','comments','1','project_close',null,'31','text','60','10','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(881,'creator_id','creator','0','project_close',null,'11','label','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(882,'ctime','close time','0','project_close',null,'3','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(883,'custom_boolean1',null,'0','project_close',null,'26','checkbox','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(884,'custom_boolean2',null,'0','project_close',null,'27','checkbox','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(885,'custom_menu1',null,'0','project_close',null,'28','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(886,'custom_menu2',null,'0','project_close',null,'29','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(887,'custom_number1',null,'0','project_close','0','24','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(888,'custom_number2',null,'0','project_close','0','25','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(889,'custom_string1',null,'0','project_close',null,'21','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(890,'custom_string2',null,'0','project_close',null,'22','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(891,'custom_text1',null,'0','project_close',null,'23','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(892,'deadline','deadline','0','project_close','+1 month','18','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(893,'description','details','0','project_close',null,'20','text','60','10','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(894,'est_hours','estimated hours','0','project_close',null,'16','text','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(895,'hours','hours','1','project_close',null,'30','text','6','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(896,'id','id','0','project_close',null,'1','label','8','1','1');
## insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(897,'otime','open time','0','project_close',null,'15','label','20','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(898,'priority','priority','0','project_close',null,'6','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(899,'project_id','project','0','project_close',null,'4','searchbox','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(900,'relations','related','0','project_close',null,'14','searchbox','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(901,'start_date','start date','0','project_close','+1 day','17','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(902,'status','status','0','project_close',null,'2','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(903,'system_id','system','0','project_close',null,'9','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(904,'tested','testing','0','project_close',null,'12','checkbox','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(905,'title','summary','0','project_close',null,'5','text','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(906,'type_id','type','0','project_close',null,'8','menu','50','1','1');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(907,'user_id','owner','0','project_close',null,'10','searchbox','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(908,'wkd_hours','hours worked','0','project_close','0','19','text','6','1','0');

# project_view_top
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(909, 'approved','approval','0','project_view_top',null,'15','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(910, 'bin_id','bin','0','project_view_top',null,'11','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(911, 'ctime','close time','0','project_view_top',null,'10','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(912, 'custom_boolean1',null,'0','project_view_top',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(913, 'custom_boolean2',null,'0','project_view_top',null,'100','label','1','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(914, 'custom_date1','date 1','0','project_view_top',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(915, 'custom_date2','date 2','0','project_view_top',null,'31','date','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(916, 'custom_menu1',null,'0','project_view_top',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(917, 'custom_menu2',null,'0','project_view_top',null,'100','menu','100','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(918, 'custom_multi1', null, 0, 'project_view_top', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(919, 'custom_multi2', null, 0, 'project_view_top', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(920, 'custom_number1',null,'0','project_view_top',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(921, 'custom_number2',null,'0','project_view_top',null,'100','text','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(922, 'custom_string1',null,'0','project_view_top',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(923, 'custom_string2',null,'0','project_view_top',null,'100','text','200','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(924, 'custom_text1',null,'0','project_view_top',null,'100','text','50','4','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(925, 'deadline','deadline','1','project_view_top',null,'6','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(926, 'elapsed','elapsed','0','project_view_top',null,'7','section','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(927, 'est_hours','estimated hours','1','project_view_top',null,'8','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(928, 'otime','open time','1','project_view_top',null,'4','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(929, 'priority','priority','1','project_view_top',null,'1','label','50','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(930, 'project_id','project','0','project_view_top',null,'16','label','30','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(931, 'start_date','start date','1','project_view_top',null,'5','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(932, 'status','status','1','project_view_top',null,'2','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(933, 'system_id','system','0','project_view_top',null,'13','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(934, 'tested','testing','0','project_view_top',null,'14','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(935, 'type_id','type','0','project_view_top',null,'12','label','10','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(936, 'user_id','owner','1','project_view_top',null,'3','label','20','1','0');
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(937, 'wkd_hours','hours worked','1','project_view_top',null,'9','label','10','1','0');

# ticket_view_top
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(938, 'custom_multi1', null, 0, 'ticket_view_top', null, 100, 'label', 50, 8, 0);
insert into zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) values(939, 'custom_multi2', null, 0, 'ticket_view_top', null, 100, 'label', 50, 8, 0);

insert into zentrack_settings (setting_id, name, value, description) values (111, 'use_system_auth', 'off', 'if on, this setting will check for an apache login (.htaccess) or windows system authentication and attempt an auto-login');
insert into zentrack_settings (setting_id, name, value, description) values (112, 'color_bar_darker', '#d3d3d3', 'a contrast area for bars');
insert into zentrack_settings (setting_id, name, value, description) values (113, 'color_bar_darkest', '#cccccc', 'a higher contrast offset for bars');
insert into zentrack_settings (setting_id, name, value, description) values (114, 'color_bar_border', '#999999', 'outline for the bar areas');
insert into zentrack_settings (setting_id, name, value, description) values (115, 'recently_viewed_max', '5', 'max items in recently viewed list');
insert into zentrack_settings (setting_id, name, value, description) values (116, 'allow_upload', 'on', 'if off, attachments will be disabled');
insert into zentrack_settings (setting_id, name, value, description) values (117, 'hotkeys_alternate_hints', 0, 'if hot key help (when alt is held down) boxes overlap because they are too long, set this to on');
insert into zentrack_settings (setting_id, name, value, description) values (118, 'hotkeys_hint_delay', 1200, 'delay before showing hotkey hint boxes(0 = off)');
insert into zentrack_settings (setting_id, name, value, description) values (119, 'hotkeys_help_delay', 8000, 'delay before showing hotkey help window (0 = off)');
insert into zentrack_settings (setting_id, name, value, description) values (120, 'worked_hours_decimal', 2, 'number of decimal places to show for hours worked/estimated');

insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(1, 'project_close', 'access_level', 'level_user', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(2, 'project_close', 'has_behaviors', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(3, 'project_close', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(4, 'project_create', 'access_level', 'level_create_proj', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(5, 'project_create', 'has_behaviors', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(6, 'project_create', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(7, 'project_edit', 'access_level', 'level_edit', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(8, 'project_edit', 'admin_view', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(9, 'project_edit', 'has_behaviors', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(10, 'project_edit', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(11, 'project_list', 'access_level', 'level_view', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(12, 'project_list', 'show_totals', '0', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(13, 'project_list', 'view_only', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(14, 'project_list_filters', 'access_level', 'level_view', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(15, 'project_list_filters', 'any_option', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(16, 'project_list_filters', 'multiple', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(17, 'project_list_filters', 'view_only', '0', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(18, 'project_tab_1', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(19, 'project_tab_1', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(20, 'project_tab_1', 'label', 'tasks', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(21, 'project_tab_1', 'postload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(22, 'project_tab_1', 'preload', 'tasks', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(23, 'project_tab_1', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(24, 'project_tab_1', 'view_only', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(25, 'project_tab_1', 'visible', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(26, 'project_tab_1', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(27, 'project_tab_2', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(28, 'project_tab_2', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(29, 'project_tab_2', 'label', 'details', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(30, 'project_tab_2', 'postload', 'details,log', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(31, 'project_tab_2', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(32, 'project_tab_2', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(33, 'project_tab_2', 'view_only', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(34, 'project_tab_2', 'visible', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(35, 'project_tab_2', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(36, 'project_tab_3', 'access_level', 'level_edit', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(37, 'project_tab_3', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(38, 'project_tab_3', 'label', 'props', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(39, 'project_tab_3', 'postload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(40, 'project_tab_3', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(41, 'project_tab_3', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(42, 'project_tab_3', 'view_only', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(43, 'project_tab_3', 'visible', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(44, 'project_tab_3', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(45, 'project_tab_4', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(46, 'project_tab_4', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(47, 'project_tab_4', 'label', 'contacts', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(48, 'project_tab_4', 'postload', 'contacts', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(49, 'project_tab_4', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(50, 'project_tab_4', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(51, 'project_tab_4', 'view_only', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(52, 'project_tab_4', 'visible', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(53, 'project_tab_4', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(54, 'project_tab_5', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(55, 'project_tab_5', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(56, 'project_tab_5', 'label', 'notify', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(57, 'project_tab_5', 'postload', 'notify', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(58, 'project_tab_5', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(59, 'project_tab_5', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(60, 'project_tab_5', 'view_only', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(61, 'project_tab_5', 'visible', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(62, 'project_tab_5', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(63, 'project_tab_6', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(64, 'project_tab_6', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(65, 'project_tab_6', 'label', 'attachments', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(66, 'project_tab_6', 'postload', 'attachments', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(67, 'project_tab_6', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(68, 'project_tab_6', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(69, 'project_tab_6', 'view_only', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(70, 'project_tab_6', 'visible', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(71, 'project_tab_6', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(72, 'project_tab_7', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(73, 'project_tab_7', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(74, 'project_tab_7', 'label', 'related', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(75, 'project_tab_7', 'postload', 'related', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(76, 'project_tab_7', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(77, 'project_tab_7', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(78, 'project_tab_7', 'view_only', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(79, 'project_tab_7', 'visible', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(80, 'project_tab_7', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(81, 'project_tab_8', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(82, 'project_tab_8', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(83, 'project_tab_8', 'label', 'other', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(84, 'project_tab_8', 'postload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(85, 'project_tab_8', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(86, 'project_tab_8', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(87, 'project_tab_8', 'view_only', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(88, 'project_tab_8', 'visible', '0', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(89, 'project_tab_8', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(90, 'project_tasks', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(91, 'project_tasks', 'sections', '0', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(92, 'project_tasks', 'show_totals', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(93, 'project_tasks', 'view_only', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(94, 'project_view_top', 'access_level', 'level_view', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(95, 'project_view_top', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(96, 'project_view_top', 'move_actions_up', '0', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(97, 'project_view_top', 'postload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(98, 'project_view_top', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(99, 'project_view_top', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(100, 'project_view_top', 'show_summary_inline', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(101, 'project_view_top', 'view_only', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(102, 'project_view_top', 'visible', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(103, 'project_view_top', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(104, 'search_form', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(105, 'search_form', 'admin_view', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(106, 'search_form', 'any_option', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(107, 'search_form', 'has_behaviors', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(108, 'search_form', 'multiple', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(109, 'search_form', 'sections', '0', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(110, 'search_list', 'sections', '0', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(111, 'search_list', 'show_totals', '0', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(112, 'search_list', 'view_only', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(113, 'ticket_close', 'access_level', 'level_user', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(114, 'ticket_close', 'has_behaviors', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(115, 'ticket_close', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(116, 'ticket_create', 'access_level', 'level_create', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(117, 'ticket_create', 'has_behaviors', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(118, 'ticket_create', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(119, 'ticket_edit', 'access_level', 'level_edit', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(120, 'ticket_edit', 'admin_view', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(121, 'ticket_edit', 'has_behaviors', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(122, 'ticket_edit', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(123, 'ticket_list', 'access_level', 'level_view', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(124, 'ticket_list', 'show_totals', '0', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(125, 'ticket_list', 'view_only', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(126, 'ticket_list_filters', 'access_level', 'level_view', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(127, 'ticket_list_filters', 'any_option', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(128, 'ticket_list_filters', 'multiple', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(129, 'ticket_list_filters', 'view_only', '0', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(130, 'ticket_tab_1', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(131, 'ticket_tab_1', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(132, 'ticket_tab_1', 'label', 'details', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(133, 'ticket_tab_1', 'postload', 'details,log', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(134, 'ticket_tab_1', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(135, 'ticket_tab_1', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(136, 'ticket_tab_1', 'view_only', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(137, 'ticket_tab_1', 'visible', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(138, 'ticket_tab_1', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(139, 'ticket_tab_2', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(140, 'ticket_tab_2', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(141, 'ticket_tab_2', 'label', 'props', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(142, 'ticket_tab_2', 'postload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(143, 'ticket_tab_2', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(144, 'ticket_tab_2', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(145, 'ticket_tab_2', 'view_only', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(146, 'ticket_tab_2', 'visible', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(147, 'ticket_tab_2', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(148, 'ticket_tab_3', 'access_level', 'level_edit', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(149, 'ticket_tab_3', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(150, 'ticket_tab_3', 'label', 'edit', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(151, 'ticket_tab_3', 'postload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(152, 'ticket_tab_3', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(153, 'ticket_tab_3', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(154, 'ticket_tab_3', 'view_only', '0', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(155, 'ticket_tab_3', 'visible', '0', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(156, 'ticket_tab_3', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(157, 'ticket_tab_4', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(158, 'ticket_tab_4', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(159, 'ticket_tab_4', 'label', 'contacts', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(160, 'ticket_tab_4', 'postload', 'contacts', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(161, 'ticket_tab_4', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(162, 'ticket_tab_4', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(163, 'ticket_tab_4', 'view_only', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(164, 'ticket_tab_4', 'visible', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(165, 'ticket_tab_4', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(166, 'ticket_tab_5', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(167, 'ticket_tab_5', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(168, 'ticket_tab_5', 'label', 'notify', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(169, 'ticket_tab_5', 'postload', 'notify', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(170, 'ticket_tab_5', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(171, 'ticket_tab_5', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(172, 'ticket_tab_5', 'view_only', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(173, 'ticket_tab_5', 'visible', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(174, 'ticket_tab_5', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(175, 'ticket_tab_6', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(176, 'ticket_tab_6', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(177, 'ticket_tab_6', 'label', 'attachments', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(178, 'ticket_tab_6', 'postload', 'attachments', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(179, 'ticket_tab_6', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(180, 'ticket_tab_6', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(181, 'ticket_tab_6', 'view_only', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(182, 'ticket_tab_6', 'visible', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(183, 'ticket_tab_6', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(184, 'ticket_tab_7', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(185, 'ticket_tab_7', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(186, 'ticket_tab_7', 'label', 'related', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(187, 'ticket_tab_7', 'postload', 'related', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(188, 'ticket_tab_7', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(189, 'ticket_tab_7', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(190, 'ticket_tab_7', 'view_only', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(191, 'ticket_tab_7', 'visible', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(192, 'ticket_tab_7', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(193, 'ticket_tab_8', 'access_level', 'level_view', 'access', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(194, 'ticket_tab_8', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(195, 'ticket_tab_8', 'label', 'other', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(196, 'ticket_tab_8', 'postload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(197, 'ticket_tab_8', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(198, 'ticket_tab_8', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(199, 'ticket_tab_8', 'view_only', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(200, 'ticket_tab_8', 'visible', '0', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(201, 'ticket_tab_8', 'width', '50', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(202, 'ticket_view_top', 'access_level', 'level_view', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(203, 'ticket_view_top', 'columns', '10', 'text', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(204, 'ticket_view_top', 'move_actions_up', '0', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(205, 'ticket_view_top', 'postload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(206, 'ticket_view_top', 'preload', '', 'load', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(207, 'ticket_view_top', 'sections', '1', 'hidden', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(208, 'ticket_view_top', 'show_summary_inline', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(209, 'ticket_view_top', 'view_only', '1', 'label', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(210, 'ticket_view_top', 'visible', '1', 'checkbox', 0);
insert into zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) values(211, 'ticket_view_top', 'width', '50', 'text', 0);


