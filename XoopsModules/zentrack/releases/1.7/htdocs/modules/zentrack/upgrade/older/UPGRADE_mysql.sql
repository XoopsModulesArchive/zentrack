
DELETE FROM xoops_zentrack_field_map where which_view = 'ticket_custom' OR which_view = 'project_custom';
DELETE FROM xoops_zentrack_settings WHERE name = 'varfield_tab_name';

-- new entries for custom_date in field map

-- PROJECT_CREATE
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(282,'custom_date1','Date 1','0','project_create',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(283,'custom_date2','Date 2','0','project_create',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(284, 'custom_multi1', NULL, 0, 'project_create', NULL, 100, 'menu', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(285, 'custom_multi2', NULL, 0, 'project_create', NULL, 100, 'menu', 50, 8, 0);

-- PROJECT_CUSTOM
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(286, 'custom_multi1', NULL, 0, 'project_custom', NULL, 100, 'menu', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(287, 'custom_multi2', NULL, 0, 'project_custom', NULL, 100, 'menu', 50, 8, 0);

-- PROJECT_EDIT
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(288,'custom_date1','Date 1','0','project_edit',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(289,'custom_date2','Date 2','0','project_edit',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(290, 'custom_multi1', NULL, 0, 'project_edit', NULL, 100, 'menu', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(291, 'custom_multi2', NULL, 0, 'project_edit', NULL, 100, 'menu', 50, 8, 0);

-- PROJECT_LIST
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(292,'custom_date1','Date 1','0','project_list',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(293,'custom_date2','Date 2','0','project_list',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(294, 'custom_multi1', NULL, 0, 'project_list', NULL, 100, 'menu', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(295, 'custom_multi2', NULL, 0, 'project_list', NULL, 100, 'menu', 50, 8, 0);

-- PROJECT_LIST_FILTERS
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(296,'bin_id','Bin','1','project_list_filters',NULL,'10','menu','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(297,'creator_id','Creator','0','project_list_filters',NULL,'50','menu','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(298,'custom_menu1',NULL,'0','project_list_filters',NULL,'100','menu','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(299,'custom_menu2',NULL,'0','project_list_filters',NULL,'100','menu','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(300,'priority','Priority','1','project_list_filters',NULL,'30','menu','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(301,'status','Status','1','project_list_filters','OPEN,PENDING','20','menu','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(302,'system_id','System','0','project_list_filters',NULL,'60','menu','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(303,'user_id','Owner','1','project_list_filters',NULL,'40','menu','20','1','0');

-- PROJECT_TAB_1
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(304,'approved','Approval','0','project_tab_1',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(305,'bin_id','Bin','0','project_tab_1',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(306,'creator_id','Creator','0','project_tab_1',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(307,'ctime','Close Time','0','project_tab_1',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(308,'custom_boolean1',NULL,'0','project_tab_1',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(309,'custom_boolean2',NULL,'0','project_tab_1',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(310,'custom_date1','Date 1','0','project_tab_1',NULL,'52','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(311,'custom_date2','Date 2','0','project_tab_1',NULL,'50','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(312,'custom_menu1',NULL,'0','project_tab_1',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(313,'custom_menu2',NULL,'0','project_tab_1',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(314, 'custom_multi1', NULL, 0, 'project_tab_1', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(315, 'custom_multi2', NULL, 0, 'project_tab_1', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(316,'custom_number1',NULL,'0','project_tab_1',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(317,'custom_number2',NULL,'0','project_tab_1',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(318,'custom_string1',NULL,'0','project_tab_1',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(319,'custom_string2',NULL,'0','project_tab_1',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(320,'custom_text1',NULL,'0','project_tab_1',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(321,'deadline','Deadline','0','project_tab_1',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(322,'elapsed','Elapsed','0','project_tab_1',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(323,'est_hours','Estimated Hours','0','project_tab_1',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(324,'otime','Open Time','0','project_tab_1',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(325,'priority','Priority','0','project_tab_1',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(326,'project_id','Project','0','project_tab_1',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(327,'start_date','Start Date','0','project_tab_1',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(328,'status','Status','0','project_tab_1',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(329,'system_id','System','0','project_tab_1',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(330,'tested','Testing','0','project_tab_1',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(331,'type_id','Type','0','project_tab_1',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(332,'user_id','Owner','0','project_tab_1',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(333,'wkd_hours','Hours Worked','0','project_tab_1',NULL,'18','label','10','1','0');

-- PROJECT_TAB_2
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(334,'approved','Approval','1','project_tab_2',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(335,'bin_id','Bin','1','project_tab_2',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(336,'creator_id','Creator','0','project_tab_2',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(337,'ctime','Close Time','0','project_tab_2',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(338,'custom_boolean1',NULL,'0','project_tab_2',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(339,'custom_boolean2',NULL,'0','project_tab_2',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(340,'custom_date1','Date 1','0','project_tab_2',NULL,'52','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(341,'custom_date2','Date 2','0','project_tab_2',NULL,'50','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(342,'custom_menu1',NULL,'0','project_tab_2',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(343,'custom_menu2',NULL,'0','project_tab_2',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(344, 'custom_multi1', NULL, 0, 'project_tab_2', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(345, 'custom_multi2', NULL, 0, 'project_tab_2', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(346,'custom_number1',NULL,'0','project_tab_2',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(347,'custom_number2',NULL,'0','project_tab_2',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(348,'custom_string1',NULL,'0','project_tab_2',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(349,'custom_string2',NULL,'0','project_tab_2',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(350,'custom_text1',NULL,'0','project_tab_2',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(351,'deadline','Deadline','0','project_tab_2',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(352,'elapsed','Elapsed','0','project_tab_2',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(353,'est_hours','Estimated Hours','0','project_tab_2',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(354,'otime','Open Time','0','project_tab_2',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(355,'priority','Priority','0','project_tab_2',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(356,'project_id','Project','0','project_tab_2',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(357,'start_date','Start Date','0','project_tab_2',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(358,'status','Status','0','project_tab_2',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(359,'system_id','System','1','project_tab_2',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(360,'tested','Testing','1','project_tab_2',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(361,'type_id','Type','1','project_tab_2',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(362,'user_id','Owner','0','project_tab_2',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(363,'wkd_hours','Hours Worked','0','project_tab_2',NULL,'18','label','10','1','0');

-- PROJECT_TAB_3
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(364,'approved','Approval','0','project_tab_3',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(365,'bin_id','Bin','0','project_tab_3',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(366,'creator_id','Creator','0','project_tab_3',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(367,'ctime','Close Time','0','project_tab_3',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(368,'custom_boolean1',NULL,'0','project_tab_3',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(369,'custom_boolean2',NULL,'0','project_tab_3',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(370,'custom_date1','Date 1','0','project_tab_3',NULL,'52','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(371,'custom_date2','Date 2','0','project_tab_3',NULL,'50','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(372,'custom_menu1',NULL,'0','project_tab_3',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(373,'custom_menu2',NULL,'0','project_tab_3',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(374, 'custom_multi1', NULL, 0, 'project_tab_3', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(375, 'custom_multi2', NULL, 0, 'project_tab_3', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(376,'custom_number1',NULL,'0','project_tab_3',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(377,'custom_number2',NULL,'0','project_tab_3',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(378,'custom_string1',NULL,'0','project_tab_3',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(379,'custom_string2',NULL,'0','project_tab_3',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(380,'custom_text1',NULL,'0','project_tab_3',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(381,'deadline','Deadline','0','project_tab_3',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(382,'elapsed','Elapsed','0','project_tab_3',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(383,'est_hours','Estimated Hours','0','project_tab_3',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(384,'otime','Open Time','0','project_tab_3',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(385,'priority','Priority','0','project_tab_3',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(386,'project_id','Project','0','project_tab_3',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(387,'start_date','Start Date','0','project_tab_3',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(388,'status','Status','0','project_tab_3',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(389,'system_id','System','0','project_tab_3',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(390,'tested','Testing','0','project_tab_3',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(391,'type_id','Type','0','project_tab_3',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(392,'user_id','Owner','0','project_tab_3',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(393,'wkd_hours','Hours Worked','0','project_tab_3',NULL,'18','label','10','1','0');

-- PROJECT_TAB_4
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(394,'approved','Approval','0','project_tab_4',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(395,'bin_id','Bin','0','project_tab_4',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(396,'creator_id','Creator','0','project_tab_4',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(397,'ctime','Close Time','0','project_tab_4',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(398,'custom_boolean1',NULL,'0','project_tab_4',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(399,'custom_boolean2',NULL,'0','project_tab_4',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(400,'custom_date1','Date 1','0','project_tab_4',NULL,'52','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(401,'custom_date2','Date 2','0','project_tab_4',NULL,'50','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(402,'custom_menu1',NULL,'0','project_tab_4',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(403,'custom_menu2',NULL,'0','project_tab_4',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(404, 'custom_multi1', NULL, 0, 'project_tab_4', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(405, 'custom_multi2', NULL, 0, 'project_tab_4', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(406,'custom_number1',NULL,'0','project_tab_4',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(407,'custom_number2',NULL,'0','project_tab_4',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(408,'custom_string1',NULL,'0','project_tab_4',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(409,'custom_string2',NULL,'0','project_tab_4',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(410,'custom_text1',NULL,'0','project_tab_4',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(411,'deadline','Deadline','0','project_tab_4',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(412,'elapsed','Elapsed','0','project_tab_4',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(413,'est_hours','Estimated Hours','0','project_tab_4',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(414,'otime','Open Time','0','project_tab_4',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(415,'priority','Priority','0','project_tab_4',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(416,'project_id','Project','0','project_tab_4',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(417,'start_date','Start Date','0','project_tab_4',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(418,'status','Status','0','project_tab_4',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(419,'system_id','System','0','project_tab_4',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(420,'tested','Testing','0','project_tab_4',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(421,'type_id','Type','0','project_tab_4',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(422,'user_id','Owner','0','project_tab_4',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(423,'wkd_hours','Hours Worked','0','project_tab_4',NULL,'18','label','10','1','0');

-- PROJECT_TAB_5
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(424,'approved','Approval','0','project_tab_5',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(425,'bin_id','Bin','0','project_tab_5',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(426,'creator_id','Creator','0','project_tab_5',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(427,'ctime','Close Time','0','project_tab_5',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(428,'custom_boolean1',NULL,'0','project_tab_5',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(429,'custom_boolean2',NULL,'0','project_tab_5',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(430,'custom_date1','Date 1','0','project_tab_5',NULL,'52','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(431,'custom_date2','Date 2','0','project_tab_5',NULL,'50','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(432,'custom_menu1',NULL,'0','project_tab_5',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(433,'custom_menu2',NULL,'0','project_tab_5',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(434, 'custom_multi1', NULL, 0, 'project_tab_5', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(435, 'custom_multi2', NULL, 0, 'project_tab_5', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(436,'custom_number1',NULL,'0','project_tab_5',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(437,'custom_number2',NULL,'0','project_tab_5',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(438,'custom_string1',NULL,'0','project_tab_5',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(439,'custom_string2',NULL,'0','project_tab_5',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(440,'custom_text1',NULL,'0','project_tab_5',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(441,'deadline','Deadline','0','project_tab_5',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(442,'elapsed','Elapsed','0','project_tab_5',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(443,'est_hours','Estimated Hours','0','project_tab_5',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(444,'otime','Open Time','0','project_tab_5',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(445,'priority','Priority','0','project_tab_5',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(446,'project_id','Project','0','project_tab_5',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(447,'start_date','Start Date','0','project_tab_5',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(448,'status','Status','0','project_tab_5',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(449,'system_id','System','0','project_tab_5',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(450,'tested','Testing','0','project_tab_5',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(451,'type_id','Type','0','project_tab_5',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(452,'user_id','Owner','0','project_tab_5',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(453,'wkd_hours','Hours Worked','0','project_tab_5',NULL,'18','label','10','1','0');

-- PROJECT_TAB_6
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(454,'approved','Approval','0','project_tab_6',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(455,'bin_id','Bin','0','project_tab_6',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(456,'creator_id','Creator','0','project_tab_6',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(457,'ctime','Close Time','0','project_tab_6',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(458,'custom_boolean1',NULL,'0','project_tab_6',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(459,'custom_boolean2',NULL,'0','project_tab_6',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(460,'custom_date1','Date 1','0','project_tab_6',NULL,'52','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(461,'custom_date2','Date 2','0','project_tab_6',NULL,'50','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(462,'custom_menu1',NULL,'0','project_tab_6',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(463,'custom_menu2',NULL,'0','project_tab_6',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(464, 'custom_multi1', NULL, 0, 'project_tab_6', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(465, 'custom_multi2', NULL, 0, 'project_tab_6', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(466,'custom_number1',NULL,'0','project_tab_6',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(467,'custom_number2',NULL,'0','project_tab_6',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(468,'custom_string1',NULL,'0','project_tab_6',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(469,'custom_string2',NULL,'0','project_tab_6',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(470,'custom_text1',NULL,'0','project_tab_6',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(471,'deadline','Deadline','0','project_tab_6',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(472,'elapsed','Elapsed','0','project_tab_6',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(473,'est_hours','Estimated Hours','0','project_tab_6',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(474,'otime','Open Time','0','project_tab_6',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(475,'priority','Priority','0','project_tab_6',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(476,'project_id','Project','0','project_tab_6',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(477,'start_date','Start Date','0','project_tab_6',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(478,'status','Status','0','project_tab_6',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(479,'system_id','System','0','project_tab_6',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(480,'tested','Testing','0','project_tab_6',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(481,'type_id','Type','0','project_tab_6',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(482,'user_id','Owner','0','project_tab_6',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(483,'wkd_hours','Hours Worked','0','project_tab_6',NULL,'18','label','10','1','0');

-- PROJECT_TAB_7
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(484,'approved','Approval','0','project_tab_7',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(485,'bin_id','Bin','0','project_tab_7',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(486,'creator_id','Creator','0','project_tab_7',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(487,'ctime','Close Time','0','project_tab_7',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(488,'custom_boolean1',NULL,'0','project_tab_7',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(489,'custom_boolean2',NULL,'0','project_tab_7',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(490,'custom_date1','Date 1','0','project_tab_7',NULL,'52','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(491,'custom_date2','Date 2','0','project_tab_7',NULL,'50','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(492,'custom_menu1',NULL,'0','project_tab_7',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(493,'custom_menu2',NULL,'0','project_tab_7',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(494, 'custom_multi1', NULL, 0, 'project_tab_7', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(495, 'custom_multi2', NULL, 0, 'project_tab_7', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(496,'custom_number1',NULL,'0','project_tab_7',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(497,'custom_number2',NULL,'0','project_tab_7',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(498,'custom_string1',NULL,'0','project_tab_7',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(499,'custom_string2',NULL,'0','project_tab_7',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(500,'custom_text1',NULL,'0','project_tab_7',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(501,'deadline','Deadline','0','project_tab_7',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(502,'elapsed','Elapsed','0','project_tab_7',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(503,'est_hours','Estimated Hours','0','project_tab_7',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(504,'otime','Open Time','0','project_tab_7',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(505,'priority','Priority','0','project_tab_7',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(506,'project_id','Project','0','project_tab_7',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(507,'start_date','Start Date','0','project_tab_7',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(508,'status','Status','0','project_tab_7',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(509,'system_id','System','0','project_tab_7',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(510,'tested','Testing','0','project_tab_7',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(511,'type_id','Type','0','project_tab_7',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(512,'user_id','Owner','0','project_tab_7',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(513,'wkd_hours','Hours Worked','0','project_tab_7',NULL,'18','label','10','1','0');

-- PROJECT_TAB_8
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(514,'approved','Approval','0','project_tab_8',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(515,'bin_id','Bin','0','project_tab_8',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(516,'creator_id','Creator','0','project_tab_8',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(517,'ctime','Close Time','0','project_tab_8',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(518,'custom_boolean1',NULL,'0','project_tab_8',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(519,'custom_boolean2',NULL,'0','project_tab_8',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(520,'custom_date1','Date 1','0','project_tab_8',NULL,'52','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(521,'custom_date2','Date 2','0','project_tab_8',NULL,'50','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(522,'custom_menu1',NULL,'0','project_tab_8',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(523,'custom_menu2',NULL,'0','project_tab_8',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(524, 'custom_multi1', NULL, 0, 'project_tab_8', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(525, 'custom_multi2', NULL, 0, 'project_tab_8', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(526,'custom_number1',NULL,'0','project_tab_8',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(527,'custom_number2',NULL,'0','project_tab_8',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(528,'custom_string1',NULL,'0','project_tab_8',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(529,'custom_string2',NULL,'0','project_tab_8',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(530,'custom_text1',NULL,'0','project_tab_8',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(531,'deadline','Deadline','0','project_tab_8',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(532,'elapsed','Elapsed','0','project_tab_8',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(533,'est_hours','Estimated Hours','0','project_tab_8',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(534,'otime','Open Time','0','project_tab_8',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(535,'priority','Priority','0','project_tab_8',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(536,'project_id','Project','0','project_tab_8',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(537,'start_date','Start Date','0','project_tab_8',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(538,'status','Status','0','project_tab_8',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(539,'system_id','System','0','project_tab_8',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(540,'tested','Testing','0','project_tab_8',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(541,'type_id','Type','0','project_tab_8',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(542,'user_id','Owner','0','project_tab_8',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(543,'wkd_hours','Hours Worked','0','project_tab_8',NULL,'18','label','10','1','0');

-- PROJECT_TASKS
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(544,'approved','Approval','0','project_tasks',NULL,'13','label','1','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(545,'bin_id','Bin','0','project_tasks',NULL,'7','label','50','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(546,'creator_id','Creator','0','project_tasks',NULL,'11','label','50','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(547,'ctime','Close Time','0','project_tasks',NULL,'3','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(548,'custom_boolean1',NULL,'0','project_tasks',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(549,'custom_boolean2',NULL,'0','project_tasks',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(550,'custom_date1','Date 1','0','project_tasks',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(551,'custom_date2','Date 2','0','project_tasks',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(552,'custom_menu1',NULL,'0','project_tasks',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(553,'custom_menu2',NULL,'0','project_tasks',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(554,'custom_number1',NULL,'0','project_tasks',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(555,'custom_number2',NULL,'0','project_tasks',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(556,'custom_string1',NULL,'0','project_tasks',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(557,'custom_string2',NULL,'0','project_tasks',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(558,'custom_text1',NULL,'0','project_tasks',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(559,'deadline','Deadline','0','project_tasks','+1 month','18','label','20','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(560,'description','Details','0','project_tasks',NULL,'24','label','60','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(561,'elapsed','Time','0','project_tasks',NULL,'30','section',NULL,'1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(562,'est_hours','Estimated Hours','1','project_tasks',NULL,'16','label','6','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(563,'id','ID','1','project_tasks',NULL,'1','label','8','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(564,'otime','Open Time','0','project_tasks',NULL,'15','label','20','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(565,'priority','Priority','1','project_tasks',NULL,'6','label','50','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(566,'project_id','Project','0','project_tasks',NULL,'4','label','50','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(567,'relations','Related','0','project_tasks',NULL,'14','label','200','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(568,'start_date','Start Date','0','project_tasks','+1 day','17','label','20','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(569,'status','Status','1','project_tasks',NULL,'2','label','50','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(570,'system_id','System','0','project_tasks',NULL,'9','label','50','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(571,'tested','Testing','0','project_tasks',NULL,'12','label','1','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(572,'title','Summary','1','project_tasks',NULL,'5','label','50','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(573,'type_id','Type','1','project_tasks',NULL,'8','label','50','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(574,'user_id','Owner','0','project_tasks',NULL,'10','label','50','1',NULL);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(575,'wkd_hours','Hours Worked','1','project_tasks','0','19','label','6','1',NULL);

-- SEARCH_FORM
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(576,'custom_date1','Date 1','0','search_form',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(577,'custom_date2','Date 2','0','search_form',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(578, 'custom_multi1', NULL, 0, 'search_form', NULL, 100, 'menu', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(579, 'custom_multi2', NULL, 0, 'search_form', NULL, 100, 'menu', 50, 8, 0);

-- SEARCH_LIST
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(580,'custom_date1','Date 1','0','search_list',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(581,'custom_date2','Date 2','0','search_list',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(582, 'custom_multi1', NULL, 0, 'search_list', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(583, 'custom_multi2', NULL, 0, 'search_list', NULL, 100, 'label', 50, 8, 0);

-- TICKET_CLOSE
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(584,'custom_date1','Date 1','0','ticket_close',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(585,'custom_date2','Date 2','0','ticket_close',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(586, 'custom_multi1', NULL, 0, 'ticket_close', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(587, 'custom_multi2', NULL, 0, 'ticket_close', NULL, 100, 'label', 50, 8, 0);

-- TICKET_CREATE
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(588,'custom_date1','Date 1','0','ticket_create',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(589,'custom_date2','Date 2','0','ticket_create',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(590, 'custom_multi1', NULL, 0, 'ticket_create', NULL, 100, 'menu', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(591, 'custom_multi2', NULL, 0, 'ticket_create', NULL, 100, 'menu', 50, 8, 0);

-- TICKET_CUSTOM
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(592, 'custom_multi1', NULL, 0, 'ticket_custom', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(593, 'custom_multi2', NULL, 0, 'ticket_custom', NULL, 100, 'label', 50, 8, 0);

-- TICKET_EDIT
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(594,'custom_date1','Date 1','0','ticket_edit',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(595,'custom_date2','Date 2','0','ticket_edit',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(596, 'custom_multi1', NULL, 0, 'ticket_edit', NULL, 100, 'menu', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(597, 'custom_multi2', NULL, 0, 'ticket_edit', NULL, 100, 'menu', 50, 8, 0);

-- TICKET_LIST
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(598,'custom_date1','Date 1','0','ticket_list',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(599,'custom_date2','Date 2','0','ticket_list',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(600, 'custom_multi1', NULL, 0, 'ticket_list', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(601, 'custom_multi2', NULL, 0, 'ticket_list', NULL, 100, 'label', 50, 8, 0);

-- TICKET_LIST_FILTERS
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(602,'bin_id','Bin','1','ticket_list_filters',NULL,'10','menu','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(603,'creator_id','Creator','0','ticket_list_filters',NULL,'70','menu','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(604,'custom_menu1',NULL,'0','ticket_list_filters',NULL,'100','menu','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(605,'custom_menu2',NULL,'0','ticket_list_filters',NULL,'100','menu','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(606,'priority','Priority','1','ticket_list_filters',NULL,'20','menu','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(607,'status','Status','1','ticket_list_filters','OPEN,PENDING','30','menu','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(608,'system_id','System','0','ticket_list_filters',NULL,'60','menu','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(609,'type_id','Type','1','ticket_list_filters',NULL,'50','menu','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(610,'user_id','Owner','1','ticket_list_filters',NULL,'40','menu','20','1','0');

-- TICKET_TAB_1
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(611,'approved','Approval','0','ticket_tab_1',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(612,'bin_id','Bin','0','ticket_tab_1',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(613,'creator_id','Creator','0','ticket_tab_1',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(614,'ctime','Close Time','0','ticket_tab_1',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(615,'custom_boolean1',NULL,'0','ticket_tab_1',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(616,'custom_boolean2',NULL,'0','ticket_tab_1',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(617,'custom_date1','Date 1','0','ticket_tab_1',NULL,'52','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(618,'custom_date2','Date 2','0','ticket_tab_1',NULL,'50','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(619,'custom_menu1',NULL,'0','ticket_tab_1',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(620,'custom_menu2',NULL,'0','ticket_tab_1',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(621, 'custom_multi1', NULL, 0, 'ticket_tab_1', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(622, 'custom_multi2', NULL, 0, 'ticket_tab_1', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(623,'custom_number1',NULL,'0','ticket_tab_1',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(624,'custom_number2',NULL,'0','ticket_tab_1',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(625,'custom_string1',NULL,'0','ticket_tab_1',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(626,'custom_string2',NULL,'0','ticket_tab_1',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(627,'custom_text1',NULL,'0','ticket_tab_1',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(628,'deadline','Deadline','0','ticket_tab_1',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(629,'elapsed','Elapsed','0','ticket_tab_1',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(630,'est_hours','Estimated Hours','0','ticket_tab_1',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(631,'otime','Open Time','0','ticket_tab_1',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(632,'priority','Priority','0','ticket_tab_1',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(633,'project_id','Project','0','ticket_tab_1',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(634,'start_date','Start Date','0','ticket_tab_1',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(635,'status','Status','0','ticket_tab_1',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(636,'system_id','System','0','ticket_tab_1',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(637,'tested','Testing','0','ticket_tab_1',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(638,'type_id','Type','0','ticket_tab_1',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(639,'user_id','Owner','0','ticket_tab_1',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(640,'wkd_hours','Hours Worked','0','ticket_tab_1',NULL,'18','label','10','1','0');

-- TICKET_TAB_2
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(641,'approved','Approval','1','ticket_tab_2',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(642,'bin_id','Bin','1','ticket_tab_2',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(643,'creator_id','Creator','0','ticket_tab_2',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(644,'ctime','Close Time','0','ticket_tab_2',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(645,'custom_boolean1',NULL,'0','ticket_tab_2',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(646,'custom_boolean2',NULL,'0','ticket_tab_2',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(647,'custom_date1','Date 1','0','ticket_tab_2',NULL,'52','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(648,'custom_date2','Date 2','0','ticket_tab_2',NULL,'50','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(649,'custom_menu1',NULL,'0','ticket_tab_2',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(650,'custom_menu2',NULL,'0','ticket_tab_2',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(651, 'custom_multi1', NULL, 0, 'ticket_tab_2', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(652, 'custom_multi2', NULL, 0, 'ticket_tab_2', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(653,'custom_number1',NULL,'0','ticket_tab_2',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(654,'custom_number2',NULL,'0','ticket_tab_2',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(655,'custom_string1',NULL,'0','ticket_tab_2',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(656,'custom_string2',NULL,'0','ticket_tab_2',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(657,'custom_text1',NULL,'0','ticket_tab_2',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(658,'deadline','Deadline','0','ticket_tab_2',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(659,'elapsed','Elapsed','0','ticket_tab_2',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(660,'est_hours','Estimated Hours','0','ticket_tab_2',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(661,'otime','Open Time','0','ticket_tab_2',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(662,'priority','Priority','0','ticket_tab_2',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(663,'project_id','Project','0','ticket_tab_2',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(664,'start_date','Start Date','0','ticket_tab_2',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(665,'status','Status','0','ticket_tab_2',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(666,'system_id','System','1','ticket_tab_2',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(667,'tested','Testing','1','ticket_tab_2',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(668,'type_id','Type','1','ticket_tab_2',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(669,'user_id','Owner','0','ticket_tab_2',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(670,'wkd_hours','Hours Worked','0','ticket_tab_2',NULL,'18','label','10','1','0');

-- TICKET_TAB_3
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(671,'approved','Approval','0','ticket_tab_3',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(672,'bin_id','Bin','0','ticket_tab_3',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(673,'creator_id','Creator','0','ticket_tab_3',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(674,'ctime','Close Time','0','ticket_tab_3',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(675,'custom_boolean1',NULL,'1','ticket_tab_3',NULL,'100','checkbox','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(676,'custom_boolean2',NULL,'1','ticket_tab_3',NULL,'100','checkbox','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(677,'custom_date1','Date 1','1','ticket_tab_3',NULL,'52','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(678,'custom_date2','Date 2','1','ticket_tab_3',NULL,'50','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(679,'custom_menu1',NULL,'1','ticket_tab_3',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(680,'custom_menu2',NULL,'1','ticket_tab_3',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(681, 'custom_multi1', NULL, 0, 'ticket_tab_3', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(682, 'custom_multi2', NULL, 0, 'ticket_tab_3', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(683,'custom_number1',NULL,'1','ticket_tab_3',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(684,'custom_number2',NULL,'1','ticket_tab_3',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(685,'custom_string1',NULL,'1','ticket_tab_3',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(686,'custom_string2',NULL,'1','ticket_tab_3',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(687,'custom_text1',NULL,'0','ticket_tab_3',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(688,'deadline','Deadline','0','ticket_tab_3',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(689,'elapsed','Elapsed','0','ticket_tab_3',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(690,'est_hours','Estimated Hours','0','ticket_tab_3',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(691,'otime','Open Time','0','ticket_tab_3',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(692,'priority','Priority','0','ticket_tab_3',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(693,'project_id','Project','0','ticket_tab_3',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(694,'start_date','Start Date','0','ticket_tab_3',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(695,'status','Status','0','ticket_tab_3',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(696,'system_id','System','0','ticket_tab_3',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(697,'tested','Testing','0','ticket_tab_3',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(698,'type_id','Type','0','ticket_tab_3',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(699,'user_id','Owner','0','ticket_tab_3',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(700,'wkd_hours','Hours Worked','0','ticket_tab_3',NULL,'18','label','10','1','0');

-- TICKET_TAB_4
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(701,'approved','Approval','0','ticket_tab_4',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(702,'bin_id','Bin','0','ticket_tab_4',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(703,'creator_id','Creator','0','ticket_tab_4',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(704,'ctime','Close Time','0','ticket_tab_4',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(705,'custom_boolean1',NULL,'0','ticket_tab_4',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(706,'custom_boolean2',NULL,'0','ticket_tab_4',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(707,'custom_date1','Date 1','0','ticket_tab_4',NULL,'52','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(708,'custom_date2','Date 2','0','ticket_tab_4',NULL,'50','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(709,'custom_menu1',NULL,'0','ticket_tab_4',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(710,'custom_menu2',NULL,'0','ticket_tab_4',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(711, 'custom_multi1', NULL, 0, 'ticket_tab_4', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(712, 'custom_multi2', NULL, 0, 'ticket_tab_4', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(713,'custom_number1',NULL,'0','ticket_tab_4',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(714,'custom_number2',NULL,'0','ticket_tab_4',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(715,'custom_string1',NULL,'0','ticket_tab_4',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(716,'custom_string2',NULL,'0','ticket_tab_4',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(717,'custom_text1',NULL,'0','ticket_tab_4',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(718,'deadline','Deadline','0','ticket_tab_4',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(719,'elapsed','Elapsed','0','ticket_tab_4',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(720,'est_hours','Estimated Hours','0','ticket_tab_4',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(721,'otime','Open Time','0','ticket_tab_4',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(722,'priority','Priority','0','ticket_tab_4',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(723,'project_id','Project','0','ticket_tab_4',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(724,'start_date','Start Date','0','ticket_tab_4',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(725,'status','Status','0','ticket_tab_4',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(726,'system_id','System','0','ticket_tab_4',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(727,'tested','Testing','0','ticket_tab_4',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(728,'type_id','Type','0','ticket_tab_4',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(729,'user_id','Owner','0','ticket_tab_4',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(730,'wkd_hours','Hours Worked','0','ticket_tab_4',NULL,'18','label','10','1','0');

-- TICKET_TAB_5
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(731,'approved','Approval','0','ticket_tab_5',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(732,'bin_id','Bin','0','ticket_tab_5',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(733,'creator_id','Creator','0','ticket_tab_5',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(734,'ctime','Close Time','0','ticket_tab_5',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(735,'custom_boolean1',NULL,'0','ticket_tab_5',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(736,'custom_boolean2',NULL,'0','ticket_tab_5',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(737,'custom_date1','Date 1','0','ticket_tab_5',NULL,'52','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(738,'custom_date2','Date 2','0','ticket_tab_5',NULL,'50','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(739,'custom_menu1',NULL,'0','ticket_tab_5',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(740,'custom_menu2',NULL,'0','ticket_tab_5',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(741, 'custom_multi1', NULL, 0, 'ticket_tab_5', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(742, 'custom_multi2', NULL, 0, 'ticket_tab_5', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(743,'custom_number1',NULL,'0','ticket_tab_5',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(744,'custom_number2',NULL,'0','ticket_tab_5',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(745,'custom_string1',NULL,'0','ticket_tab_5',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(746,'custom_string2',NULL,'0','ticket_tab_5',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(747,'custom_text1',NULL,'0','ticket_tab_5',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(748,'deadline','Deadline','0','ticket_tab_5',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(749,'elapsed','Elapsed','0','ticket_tab_5',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(750,'est_hours','Estimated Hours','0','ticket_tab_5',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(751,'otime','Open Time','0','ticket_tab_5',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(752,'priority','Priority','0','ticket_tab_5',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(753,'project_id','Project','0','ticket_tab_5',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(754,'start_date','Start Date','0','ticket_tab_5',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(755,'status','Status','0','ticket_tab_5',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(756,'system_id','System','0','ticket_tab_5',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(757,'tested','Testing','0','ticket_tab_5',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(758,'type_id','Type','0','ticket_tab_5',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(759,'user_id','Owner','0','ticket_tab_5',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(760,'wkd_hours','Hours Worked','0','ticket_tab_5',NULL,'18','label','10','1','0');

-- TICKET_TAB_6
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(761,'approved','Approval','0','ticket_tab_6',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(762,'bin_id','Bin','0','ticket_tab_6',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(763,'creator_id','Creator','0','ticket_tab_6',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(764,'ctime','Close Time','0','ticket_tab_6',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(765,'custom_boolean1',NULL,'0','ticket_tab_6',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(766,'custom_boolean2',NULL,'0','ticket_tab_6',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(767,'custom_date1','Date 1','0','ticket_tab_6',NULL,'52','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(768,'custom_date2','Date 2','0','ticket_tab_6',NULL,'50','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(769,'custom_menu1',NULL,'0','ticket_tab_6',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(770,'custom_menu2',NULL,'0','ticket_tab_6',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(771, 'custom_multi1', NULL, 0, 'ticket_tab_6', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(772, 'custom_multi2', NULL, 0, 'ticket_tab_6', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(773,'custom_number1',NULL,'0','ticket_tab_6',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(774,'custom_number2',NULL,'0','ticket_tab_6',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(775,'custom_string1',NULL,'0','ticket_tab_6',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(776,'custom_string2',NULL,'0','ticket_tab_6',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(777,'custom_text1',NULL,'0','ticket_tab_6',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(778,'deadline','Deadline','0','ticket_tab_6',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(779,'elapsed','Elapsed','0','ticket_tab_6',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(780,'est_hours','Estimated Hours','0','ticket_tab_6',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(781,'otime','Open Time','0','ticket_tab_6',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(782,'priority','Priority','0','ticket_tab_6',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(783,'project_id','Project','0','ticket_tab_6',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(784,'start_date','Start Date','0','ticket_tab_6',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(785,'status','Status','0','ticket_tab_6',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(786,'system_id','System','0','ticket_tab_6',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(787,'tested','Testing','0','ticket_tab_6',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(788,'type_id','Type','0','ticket_tab_6',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(789,'user_id','Owner','0','ticket_tab_6',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(790,'wkd_hours','Hours Worked','0','ticket_tab_6',NULL,'18','label','10','1','0');

-- TICKET_TAB_7
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(791,'approved','Approval','0','ticket_tab_7',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(792,'bin_id','Bin','0','ticket_tab_7',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(793,'creator_id','Creator','0','ticket_tab_7',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(794,'ctime','Close Time','0','ticket_tab_7',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(795,'custom_boolean1',NULL,'0','ticket_tab_7',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(796,'custom_boolean2',NULL,'0','ticket_tab_7',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(797,'custom_date1','Date 1','0','ticket_tab_7',NULL,'52','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(798,'custom_date2','Date 2','0','ticket_tab_7',NULL,'50','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(799,'custom_menu1',NULL,'0','ticket_tab_7',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(800,'custom_menu2',NULL,'0','ticket_tab_7',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(801, 'custom_multi1', NULL, 0, 'ticket_tab_7', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(802, 'custom_multi2', NULL, 0, 'ticket_tab_7', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(803,'custom_number1',NULL,'0','ticket_tab_7',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(804,'custom_number2',NULL,'0','ticket_tab_7',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(805,'custom_string1',NULL,'0','ticket_tab_7',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(806,'custom_string2',NULL,'0','ticket_tab_7',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(807,'custom_text1',NULL,'0','ticket_tab_7',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(808,'deadline','Deadline','0','ticket_tab_7',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(809,'elapsed','Elapsed','0','ticket_tab_7',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(810,'est_hours','Estimated Hours','0','ticket_tab_7',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(811,'otime','Open Time','0','ticket_tab_7',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(812,'priority','Priority','0','ticket_tab_7',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(813,'project_id','Project','0','ticket_tab_7',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(814,'start_date','Start Date','0','ticket_tab_7',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(815,'status','Status','0','ticket_tab_7',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(816,'system_id','System','0','ticket_tab_7',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(817,'tested','Testing','0','ticket_tab_7',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(818,'type_id','Type','0','ticket_tab_7',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(819,'user_id','Owner','0','ticket_tab_7',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(820,'wkd_hours','Hours Worked','0','ticket_tab_7',NULL,'18','label','10','1','0');

-- TICKET_TAB_8
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(821,'approved','Approval','0','ticket_tab_8',NULL,'30','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(822,'bin_id','Bin','0','ticket_tab_8',NULL,'22','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(823,'creator_id','Creator','0','ticket_tab_8',NULL,'56','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(824,'ctime','Close Time','0','ticket_tab_8',NULL,'20','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(825,'custom_boolean1',NULL,'0','ticket_tab_8',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(826,'custom_boolean2',NULL,'0','ticket_tab_8',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(827,'custom_date1','Date 1','0','ticket_tab_8',NULL,'52','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(828,'custom_date2','Date 2','0','ticket_tab_8',NULL,'50','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(829,'custom_menu1',NULL,'0','ticket_tab_8',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(830,'custom_menu2',NULL,'0','ticket_tab_8',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(831, 'custom_multi1', NULL, 0, 'ticket_tab_8', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(832, 'custom_multi2', NULL, 0, 'ticket_tab_8', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(833,'custom_number1',NULL,'0','ticket_tab_8',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(834,'custom_number2',NULL,'0','ticket_tab_8',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(835,'custom_string1',NULL,'0','ticket_tab_8',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(836,'custom_string2',NULL,'0','ticket_tab_8',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(837,'custom_text1',NULL,'0','ticket_tab_8',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(838,'deadline','Deadline','0','ticket_tab_8',NULL,'12','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(839,'elapsed','Elapsed','0','ticket_tab_8',NULL,'14','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(840,'est_hours','Estimated Hours','0','ticket_tab_8',NULL,'16','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(841,'otime','Open Time','0','ticket_tab_8',NULL,'8','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(842,'priority','Priority','0','ticket_tab_8',NULL,'2','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(843,'project_id','Project','0','ticket_tab_8',NULL,'32','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(844,'start_date','Start Date','0','ticket_tab_8',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(845,'status','Status','0','ticket_tab_8',NULL,'4','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(846,'system_id','System','0','ticket_tab_8',NULL,'26','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(847,'tested','Testing','0','ticket_tab_8',NULL,'28','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(848,'type_id','Type','0','ticket_tab_8',NULL,'24','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(849,'user_id','Owner','0','ticket_tab_8',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(850,'wkd_hours','Hours Worked','0','ticket_tab_8',NULL,'18','label','10','1','0');

-- TICKET_VIEW_TOP
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(851,'approved','Approval','0','ticket_view_top',NULL,'15','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(852,'bin_id','Bin','0','ticket_view_top',NULL,'11','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(853,'ctime','Close Time','0','ticket_view_top',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(854,'custom_boolean1',NULL,'0','ticket_view_top',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(855,'custom_boolean2',NULL,'0','ticket_view_top',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(856,'custom_date1','Date 1','0','ticket_view_top',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(857,'custom_date2','Date 2','0','ticket_view_top',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(858,'custom_menu1',NULL,'0','ticket_view_top',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(859,'custom_menu2',NULL,'0','ticket_view_top',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(860,'custom_number1',NULL,'0','ticket_view_top',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(861,'custom_number2',NULL,'0','ticket_view_top',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(862,'custom_string1',NULL,'0','ticket_view_top',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(863,'custom_string2',NULL,'0','ticket_view_top',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(864,'custom_text1',NULL,'0','ticket_view_top',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(865,'deadline','Deadline','1','ticket_view_top',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(866,'elapsed','Elapsed','0','ticket_view_top',NULL,'7','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(867,'est_hours','Estimated Hours','1','ticket_view_top',NULL,'8','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(868,'otime','Open Time','1','ticket_view_top',NULL,'4','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(869,'priority','Priority','1','ticket_view_top',NULL,'1','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(870,'project_id','Project','0','ticket_view_top',NULL,'16','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(871,'start_date','Start Date','1','ticket_view_top',NULL,'5','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(872,'status','Status','1','ticket_view_top',NULL,'2','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(873,'system_id','System','0','ticket_view_top',NULL,'13','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(874,'tested','Testing','0','ticket_view_top',NULL,'14','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(875,'type_id','Type','0','ticket_view_top',NULL,'12','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(876,'user_id','Owner','1','ticket_view_top',NULL,'3','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(877,'wkd_hours','Hours Worked','1','ticket_view_top',NULL,'9','label','10','1','0');

-- new setting for auto-login from system account
INSERT INTO xoops_zentrack_settings (setting_id, name, value, description) VALUES (111, 'use_system_auth', 'off', 'If on, this setting will check for an apache login (.htaccess) or windows system authentication and attempt an auto-login');

-- new color settings for ui improvements
INSERT INTO xoops_zentrack_settings (setting_id, name, value, description) VALUES (112, 'color_bar_darker', '#D3D3D3', 'A contrast area for bars');
INSERT INTO xoops_zentrack_settings (setting_id, name, value, description) VALUES (113, 'color_bar_darkest', '#CCCCCC', 'A higher contrast offset for bars');
INSERT INTO xoops_zentrack_settings (setting_id, name, value, description) VALUES (114, 'color_bar_border', '#999999', 'Outline for the bar areas');

UPDATE xoops_zentrack_settings SET value = '#000000' WHERE name = 'color_bar_text' AND value='#006666'; 

-- new setting to control number of items stored in history list
INSERT INTO xoops_zentrack_settings (setting_id, name, value, description) VALUES (115, 'recently_viewed_max', '5', 'Max items in recently viewed list');

-- setting to turn on/off attachments
INSERT INTO xoops_zentrack_settings (setting_id, name, value, description) VALUES (116, 'allow_upload', 'on', 'If off, attachments will be disabled');

-- settings for hot key help windows and hints
INSERT INTO xoops_zentrack_settings (setting_id, name, value, description) VALUES (117, 'hotkeys_alternate_hints', 0, 'If hot key help (when alt is held down) boxes overlap because they are too long, set this to On');
INSERT INTO xoops_zentrack_settings (setting_id, name, value, description) VALUES (118, 'hotkeys_hint_delay', 1200, 'Delay before showing hotkey hint boxes(0 = off)');
INSERT INTO xoops_zentrack_settings (setting_id, name, value, description) VALUES (119, 'hotkeys_help_delay', 8000, 'Delay before showing hotkey help window (0 = off)');
INSERT INTO xoops_zentrack_settings (setting_id, name, value, description) VALUES (120, 'worked_hours_decimal', 2, 'Number of decimal places to show for hours worked/estimated');

-- new table for field maps
CREATE TABLE xoops_zentrack_view_map (
  view_map_id INT(12) NOT NULL auto_increment,
  vm_name VARCHAR(25) NOT NULL,
  vm_val  VARCHAR(50) default '',
  vm_type VARCHAR(12) NOT NULL,
  vm_order INT(4) default 0,
  which_view VARCHAR(50) NOT NULL,
  PRIMARY KEY (view_map_id)
);

CREATE INDEX view_map_idx ON xoops_zentrack_view_map(which_view,vm_order);


-- new data for the field map extra table

-- PROJECT_CLOSE
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(1, 'project_close', 'access_level', 'level_user', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(2, 'project_close', 'has_behaviors', '1', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(3, 'project_close', 'sections', '1', 'hidden', 0);

-- PROJECT_CREATE
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(4, 'project_create', 'access_level', 'level_create_proj', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(5, 'project_create', 'has_behaviors', '1', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(6, 'project_create', 'sections', '1', 'hidden', 0);

-- PROJECT_EDIT
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(7, 'project_edit', 'access_level', 'level_edit', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(8, 'project_edit', 'admin_view', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(9, 'project_edit', 'has_behaviors', '1', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(10, 'project_edit', 'sections', '1', 'hidden', 0);

-- PROJECT_LIST
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(11, 'project_list', 'access_level', 'level_view', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(12, 'project_list', 'show_totals', '0', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(13, 'project_list', 'view_only', '1', 'label', 0);

-- PROJECT_LIST_FILTERS
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(14, 'project_list_filters', 'access_level', 'level_view', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(15, 'project_list_filters', 'any_option', '1', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(16, 'project_list_filters', 'multiple', '1', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(17, 'project_list_filters', 'view_only', '0', 'label', 0);

-- PROJECT_TAB_1
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(18, 'project_tab_1', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(19, 'project_tab_1', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(20, 'project_tab_1', 'label', 'Tasks', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(21, 'project_tab_1', 'postload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(22, 'project_tab_1', 'preload', 'tasks', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(23, 'project_tab_1', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(24, 'project_tab_1', 'view_only', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(25, 'project_tab_1', 'visible', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(26, 'project_tab_1', 'width', '50', 'text', 0);

-- PROJECT_TAB_2
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(27, 'project_tab_2', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(28, 'project_tab_2', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(29, 'project_tab_2', 'label', 'Details', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(30, 'project_tab_2', 'postload', 'details,log', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(31, 'project_tab_2', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(32, 'project_tab_2', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(33, 'project_tab_2', 'view_only', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(34, 'project_tab_2', 'visible', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(35, 'project_tab_2', 'width', '50', 'text', 0);

-- PROJECT_TAB_3
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(36, 'project_tab_3', 'access_level', 'level_edit', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(37, 'project_tab_3', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(38, 'project_tab_3', 'label', 'Props', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(39, 'project_tab_3', 'postload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(40, 'project_tab_3', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(41, 'project_tab_3', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(42, 'project_tab_3', 'view_only', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(43, 'project_tab_3', 'visible', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(44, 'project_tab_3', 'width', '50', 'text', 0);

-- PROJECT_TAB_4
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(45, 'project_tab_4', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(46, 'project_tab_4', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(47, 'project_tab_4', 'label', 'Contacts', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(48, 'project_tab_4', 'postload', 'contacts', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(49, 'project_tab_4', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(50, 'project_tab_4', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(51, 'project_tab_4', 'view_only', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(52, 'project_tab_4', 'visible', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(53, 'project_tab_4', 'width', '50', 'text', 0);

-- PROJECT_TAB_5
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(54, 'project_tab_5', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(55, 'project_tab_5', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(56, 'project_tab_5', 'label', 'Notify', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(57, 'project_tab_5', 'postload', 'notify', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(58, 'project_tab_5', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(59, 'project_tab_5', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(60, 'project_tab_5', 'view_only', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(61, 'project_tab_5', 'visible', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(62, 'project_tab_5', 'width', '50', 'text', 0);

-- PROJECT_TAB_6
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(63, 'project_tab_6', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(64, 'project_tab_6', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(65, 'project_tab_6', 'label', 'Attachments', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(66, 'project_tab_6', 'postload', 'attachments', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(67, 'project_tab_6', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(68, 'project_tab_6', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(69, 'project_tab_6', 'view_only', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(70, 'project_tab_6', 'visible', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(71, 'project_tab_6', 'width', '50', 'text', 0);

-- PROJECT_TAB_7
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(72, 'project_tab_7', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(73, 'project_tab_7', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(74, 'project_tab_7', 'label', 'Related', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(75, 'project_tab_7', 'postload', 'related', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(76, 'project_tab_7', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(77, 'project_tab_7', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(78, 'project_tab_7', 'view_only', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(79, 'project_tab_7', 'visible', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(80, 'project_tab_7', 'width', '50', 'text', 0);

-- PROJECT_TAB_8
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(81, 'project_tab_8', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(82, 'project_tab_8', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(83, 'project_tab_8', 'label', 'Other', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(84, 'project_tab_8', 'postload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(85, 'project_tab_8', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(86, 'project_tab_8', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(87, 'project_tab_8', 'view_only', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(88, 'project_tab_8', 'visible', '0', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(89, 'project_tab_8', 'width', '50', 'text', 0);

-- PROJECT_TASKS
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(90, 'project_tasks', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(91, 'project_tasks', 'sections', '0', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(92, 'project_tasks', 'show_totals', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(93, 'project_tasks', 'view_only', '1', 'label', 0);

-- PROJECT_VIEW_TOP
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(94, 'project_view_top', 'access_level', 'level_view', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(95, 'project_view_top', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(96, 'project_view_top', 'move_actions_up', '0', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(97, 'project_view_top', 'postload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(98, 'project_view_top', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(99, 'project_view_top', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(100, 'project_view_top', 'show_summary_inline', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(101, 'project_view_top', 'view_only', '1', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(102, 'project_view_top', 'visible', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(103, 'project_view_top', 'width', '50', 'text', 0);

-- SEARCH_FORM
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(104, 'search_form', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(105, 'search_form', 'admin_view', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(106, 'search_form', 'any_option', '1', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(107, 'search_form', 'has_behaviors', '1', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(108, 'search_form', 'multiple', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(109, 'search_form', 'sections', '0', 'hidden', 0);

-- SEARCH_LIST
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(110, 'search_list', 'sections', '0', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(111, 'search_list', 'show_totals', '0', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(112, 'search_list', 'view_only', '1', 'label', 0);

-- TICKET_CLOSE
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(113, 'ticket_close', 'access_level', 'level_user', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(114, 'ticket_close', 'has_behaviors', '1', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(115, 'ticket_close', 'sections', '1', 'hidden', 0);

-- TICKET_CREATE
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(116, 'ticket_create', 'access_level', 'level_create', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(117, 'ticket_create', 'has_behaviors', '1', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(118, 'ticket_create', 'sections', '1', 'hidden', 0);

-- TICKET_EDIT
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(119, 'ticket_edit', 'access_level', 'level_edit', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(120, 'ticket_edit', 'admin_view', '1', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(121, 'ticket_edit', 'has_behaviors', '1', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(122, 'ticket_edit', 'sections', '1', 'hidden', 0);

-- TICKET_LIST
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(123, 'ticket_list', 'access_level', 'level_view', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(124, 'ticket_list', 'show_totals', '0', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(125, 'ticket_list', 'view_only', '1', 'label', 0);

-- TICKET_LIST_FILTERS
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(126, 'ticket_list_filters', 'access_level', 'level_view', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(127, 'ticket_list_filters', 'any_option', '1', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(128, 'ticket_list_filters', 'multiple', '1', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(129, 'ticket_list_filters', 'view_only', '0', 'label', 0);

-- TICKET_TAB_1
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(130, 'ticket_tab_1', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(131, 'ticket_tab_1', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(132, 'ticket_tab_1', 'label', 'Details', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(133, 'ticket_tab_1', 'postload', 'details,log', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(134, 'ticket_tab_1', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(135, 'ticket_tab_1', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(136, 'ticket_tab_1', 'view_only', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(137, 'ticket_tab_1', 'visible', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(138, 'ticket_tab_1', 'width', '50', 'text', 0);

-- TICKET_TAB_2
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(139, 'ticket_tab_2', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(140, 'ticket_tab_2', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(141, 'ticket_tab_2', 'label', 'Props', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(142, 'ticket_tab_2', 'postload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(143, 'ticket_tab_2', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(144, 'ticket_tab_2', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(145, 'ticket_tab_2', 'view_only', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(146, 'ticket_tab_2', 'visible', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(147, 'ticket_tab_2', 'width', '50', 'text', 0);

-- TICKET_TAB_3
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(148, 'ticket_tab_3', 'access_level', 'level_edit', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(149, 'ticket_tab_3', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(150, 'ticket_tab_3', 'label', 'Edit', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(151, 'ticket_tab_3', 'postload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(152, 'ticket_tab_3', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(153, 'ticket_tab_3', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(154, 'ticket_tab_3', 'view_only', '0', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(155, 'ticket_tab_3', 'visible', '0', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(156, 'ticket_tab_3', 'width', '50', 'text', 0);

-- TICKET_TAB_4
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(157, 'ticket_tab_4', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(158, 'ticket_tab_4', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(159, 'ticket_tab_4', 'label', 'Contacts', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(160, 'ticket_tab_4', 'postload', 'contacts', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(161, 'ticket_tab_4', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(162, 'ticket_tab_4', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(163, 'ticket_tab_4', 'view_only', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(164, 'ticket_tab_4', 'visible', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(165, 'ticket_tab_4', 'width', '50', 'text', 0);

-- TICKET_TAB_5
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(166, 'ticket_tab_5', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(167, 'ticket_tab_5', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(168, 'ticket_tab_5', 'label', 'Notify', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(169, 'ticket_tab_5', 'postload', 'notify', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(170, 'ticket_tab_5', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(171, 'ticket_tab_5', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(172, 'ticket_tab_5', 'view_only', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(173, 'ticket_tab_5', 'visible', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(174, 'ticket_tab_5', 'width', '50', 'text', 0);

-- TICKET_TAB_6
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(175, 'ticket_tab_6', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(176, 'ticket_tab_6', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(177, 'ticket_tab_6', 'label', 'Attachments', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(178, 'ticket_tab_6', 'postload', 'attachments', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(179, 'ticket_tab_6', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(180, 'ticket_tab_6', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(181, 'ticket_tab_6', 'view_only', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(182, 'ticket_tab_6', 'visible', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(183, 'ticket_tab_6', 'width', '50', 'text', 0);

-- TICKET_TAB_7
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(184, 'ticket_tab_7', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(185, 'ticket_tab_7', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(186, 'ticket_tab_7', 'label', 'Related', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(187, 'ticket_tab_7', 'postload', 'related', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(188, 'ticket_tab_7', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(189, 'ticket_tab_7', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(190, 'ticket_tab_7', 'view_only', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(191, 'ticket_tab_7', 'visible', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(192, 'ticket_tab_7', 'width', '50', 'text', 0);

-- TICKET_TAB_8
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(193, 'ticket_tab_8', 'access_level', 'level_view', 'access', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(194, 'ticket_tab_8', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(195, 'ticket_tab_8', 'label', 'Other', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(196, 'ticket_tab_8', 'postload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(197, 'ticket_tab_8', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(198, 'ticket_tab_8', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(199, 'ticket_tab_8', 'view_only', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(200, 'ticket_tab_8', 'visible', '0', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(201, 'ticket_tab_8', 'width', '50', 'text', 0);

-- TICKET_VIEW_TOP
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(202, 'ticket_view_top', 'access_level', 'level_view', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(203, 'ticket_view_top', 'columns', '10', 'text', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(204, 'ticket_view_top', 'move_actions_up', '0', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(205, 'ticket_view_top', 'postload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(206, 'ticket_view_top', 'preload', '', 'load', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(207, 'ticket_view_top', 'sections', '1', 'hidden', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(208, 'ticket_view_top', 'show_summary_inline', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(209, 'ticket_view_top', 'view_only', '1', 'label', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(210, 'ticket_view_top', 'visible', '1', 'checkbox', 0);
INSERT INTO xoops_zentrack_view_map (view_map_id, which_view, vm_name, vm_val, vm_type, vm_order) VALUES(211, 'ticket_view_top', 'width', '50', 'text', 0);

CREATE TABLE xoops_zentrack_varfield_multi (
  multi_id int(12) NOT NULL auto_increment,
  ticket_id int(12) NOT NULL default '0',
  field_name varchar(25) NOT NULL default '',
  field_value varchar(255) default NULL,
  PRIMARY KEY  (multi_id)
);

CREATE INDEX vf_multi_idx ON xoops_zentrack_varfield_multi(ticket_id);


-- Modify the version number
UPDATE xoops_zentrack_settings SET value='2.6 Final' WHERE setting_id=74;

-- PROJECT_CLOSE
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(878,'approved','Approval','0','project_close',NULL,'13','checkbox','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(879,'bin_id','Bin','0','project_close',NULL,'7','menu','50','1','1');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(880,'comments','Comments','1','project_close',NULL,'31','text','60','10','1');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(881,'creator_id','Creator','0','project_close',NULL,'11','label','50','1','1');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(882,'ctime','Close Time','0','project_close',NULL,'3','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(883,'custom_boolean1',NULL,'0','project_close',NULL,'26','checkbox','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(884,'custom_boolean2',NULL,'0','project_close',NULL,'27','checkbox','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(885,'custom_menu1',NULL,'0','project_close',NULL,'28','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(886,'custom_menu2',NULL,'0','project_close',NULL,'29','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(887,'custom_number1',NULL,'0','project_close','0','24','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(888,'custom_number2',NULL,'0','project_close','0','25','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(889,'custom_string1',NULL,'0','project_close',NULL,'21','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(890,'custom_string2',NULL,'0','project_close',NULL,'22','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(891,'custom_text1',NULL,'0','project_close',NULL,'23','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(892,'deadline','Deadline','0','project_close','+1 month','18','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(893,'description','Details','0','project_close',NULL,'20','text','60','10','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(894,'est_hours','Estimated Hours','0','project_close',NULL,'16','text','6','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(895,'hours','Hours','1','project_close',NULL,'30','text','6','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(896,'id','ID','0','project_close',NULL,'1','label','8','1','1');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(897,'otime','Open Time','0','project_close',NULL,'15','label','20','1','1');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(898,'priority','Priority','0','project_close',NULL,'6','menu','50','1','1');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(899,'project_id','Project','0','project_close',NULL,'4','searchbox','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(900,'relations','Related','0','project_close',NULL,'14','searchbox','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(901,'start_date','Start Date','0','project_close','+1 day','17','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(902,'status','Status','0','project_close',NULL,'2','menu','50','1','1');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(903,'system_id','System','0','project_close',NULL,'9','menu','50','1','1');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(904,'tested','Testing','0','project_close',NULL,'12','checkbox','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(905,'title','Summary','0','project_close',NULL,'5','text','50','1','1');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(906,'type_id','Type','0','project_close',NULL,'8','menu','50','1','1');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(907,'user_id','Owner','0','project_close',NULL,'10','searchbox','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(908,'wkd_hours','Hours Worked','0','project_close','0','19','text','6','1','0');

-- PROJECT_VIEW_TOP
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(909, 'approved','Approval','0','project_view_top',NULL,'15','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(910, 'bin_id','Bin','0','project_view_top',NULL,'11','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(911, 'ctime','Close Time','0','project_view_top',NULL,'10','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(912, 'custom_boolean1',NULL,'0','project_view_top',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(913, 'custom_boolean2',NULL,'0','project_view_top',NULL,'100','label','1','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(914, 'custom_date1','Date 1','0','project_view_top',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(915, 'custom_date2','Date 2','0','project_view_top',NULL,'31','date','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(916, 'custom_menu1',NULL,'0','project_view_top',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(917, 'custom_menu2',NULL,'0','project_view_top',NULL,'100','menu','100','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(918, 'custom_multi1', NULL, 0, 'project_view_top', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(919, 'custom_multi2', NULL, 0, 'project_view_top', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(920, 'custom_number1',NULL,'0','project_view_top',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(921, 'custom_number2',NULL,'0','project_view_top',NULL,'100','text','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(922, 'custom_string1',NULL,'0','project_view_top',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(923, 'custom_string2',NULL,'0','project_view_top',NULL,'100','text','200','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(924, 'custom_text1',NULL,'0','project_view_top',NULL,'100','text','50','4','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(925, 'deadline','Deadline','1','project_view_top',NULL,'6','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(926, 'elapsed','Elapsed','0','project_view_top',NULL,'7','section','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(927, 'est_hours','Estimated Hours','1','project_view_top',NULL,'8','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(928, 'otime','Open Time','1','project_view_top',NULL,'4','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(929, 'priority','Priority','1','project_view_top',NULL,'1','label','50','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(930, 'project_id','Project','0','project_view_top',NULL,'16','label','30','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(931, 'start_date','Start Date','1','project_view_top',NULL,'5','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(932, 'status','Status','1','project_view_top',NULL,'2','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(933, 'system_id','System','0','project_view_top',NULL,'13','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(934, 'tested','Testing','0','project_view_top',NULL,'14','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(935, 'type_id','Type','0','project_view_top',NULL,'12','label','10','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(936, 'user_id','Owner','1','project_view_top',NULL,'3','label','20','1','0');
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(937, 'wkd_hours','Hours Worked','1','project_view_top',NULL,'9','label','10','1','0');

-- TICKET_VIEW_TOP
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(938, 'custom_multi1', NULL, 0, 'ticket_view_top', NULL, 100, 'label', 50, 8, 0);
INSERT INTO xoops_zentrack_field_map (field_map_id,field_name,field_label,is_visible,which_view,default_val,sort_order,field_type,num_cols,num_rows,is_required) VALUES(939, 'custom_multi2', NULL, 0, 'ticket_view_top', NULL, 100, 'label', 50, 8, 0);
