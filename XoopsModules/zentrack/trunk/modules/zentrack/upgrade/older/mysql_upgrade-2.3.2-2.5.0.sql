## This script updates entrackXoops database from version 2.3.2 to 2.5.0


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

  # changes here must be reflected in the values for zentrack_varfield_idx
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







update zentrack_settings set description = 'the language displayed by default, must match a filename in includes/translations' where name='language_default';
update zentrack_settings set description = 'send email to tester/approver when ticket is pending' where name = 'email_pending';
update zentrack_settings set description = 'comma seperated list.  only these extensions may be uploaded.  set to 0 to allow all (warning:  this is a security risk!)' where name='attachment_types_allowed';



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



# modify the version number
update zentrack_settings set value='2.5.0.2' where setting_id=74;

