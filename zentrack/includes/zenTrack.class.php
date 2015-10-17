<?php /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */
if( !ZT_DEFINED ) { die("Illegal Access"); }

/* 
**  zenTrack Class
**
**  Author: Kato "phpzen"
**  Description: Ticketing system functions
**  Version: See CVS Repository for version information
**  Created: 02/22/21
**  Email:  postmaster@phpzen.net
**  URL: http://www.phpzen.net
**
**  This is the main class containing all of the functionality for use
**  with the zentrack system.  This class extends zen (basic text formatting
**  and page utilities), zenDate (date manipulations and calculations) and 
**  db.class (database access and retrieval)
*/

include_once("$libDir/zen.class.php");
include_once("$libDir/ZenSessionManager.class.php");
include_once("$libDir/ZenHistoryManager.class.php");
include_once("$libDir/ZenFieldMap.class.php");

class zenTrack extends zen {

  /*
  **  RETRIEVAL 
  */

  /**
   * Return access priviledges for user
   *
   * @param int $user_id
   * @param int $flag 1 returns db rows, 0 returns array("bin_id" => level)
   * @return mixed array
   */
  function get_access( $user_id, $flag = 0, $withnull = false ) {
    if( $flag ) {
      $query = "SELECT * FROM ".$this->table_access
        ." WHERE user_id = ".$this->checkNum($user_id);
      if( !$withnull ) { $query .= " AND lvl is not null"; }
      $this->addDebug("get_access()Query",$query,3);
      return $this->db_queryIndexed($query);
    }
    
    if( $user_id == ZenSessionManager::getSession('login_id') ) {
      $vals = $this->_session->find('login_user_access');
    }
    else {
      $vals = $this->_session->getDataCache('user_access', $user_id);
    }
    if( !$vals ) {
      $query = "SELECT * FROM ".$this->table_access
        ." WHERE user_id = ".$this->checkNum($user_id);
      if( !$withnull ) { $query .= " AND lvl is not null"; }
      $this->addDebug("get_access()Query",$query,3);
      $vars = $this->db_queryIndexed($query);
      $vals = array();
      if( is_array($vars) ) {
        foreach($vars as $v) {
          $vals["{$v['bin_id']}"] = $v['lvl'];
        }
      }
      if( $user_id == ZenSessionManager::getSession('login_id') ) {
        $this->_session->store('login_user_access', $vals);
      }
      else {
        $this->_session->storeDataCache('user_access', $user_id, $vals);
      }
    }
    return $vals;
  }

  function get_attachment($access_id) {
    // retrieves all properties for a given attachment
    // this is by the attachment_id and not the ticket or log ID
    // and creates a file location to the actual 
    // attachment which is stored as ["location"]

    $query = "SELECT * FROM ".$this->table_attachments
      ." WHERE attachment_id = ".$this->checkNum($access_id);
    $vars = $this->db_quickIndexed($query);
    if( is_array($vars) ) {
      $vars["location"] = $this->attachmentsDir."/".$vars["name"];
    }
    return($vars);
  }

  function get_attachments($id, $flag = 0, $indexed = 0) {
    // retrieves all attachements for a given ticket_id
    // indexed by log entry they are associated with
    // if $flag = 1, retrieves by log_id instead of ticket_id
    // if $indexed = 1, then retrieves in a complex array
    // indexed by ticket_id and log_id as follows:
    // $vals["ticket1"]["log1"] = array(datarow)
    // otherwise, returns in a simple, non-indexed array

    $field = ($flag)? "log_id" : "ticket_id";
    if( is_array($id) ) {
      $where = " $field IN(";
      for($i=0; $i<count($id); $i++) {
        if( $i>0 ) { $where .= ","; }
        $where .= $this->checkNum($id[$i]);
      }
      $where .= ")";
    }
    else {
      $where = " $field = ".$this->checkNum($id);
    }
    $query = "SELECT * FROM ".$this->table_attachments
      ." WHERE $where ORDER BY name";
    $vars = $this->db_queryIndexed($query);
    if( $indexed ) {
      for( $i=0; $i<count($vars); $i++ ) {
        $n = $vars[$i]["log_id"];
        $v = $vars[$i]["ticket_id"];
        $vals["$v"]["$n"][] = $vars[$i];
      }
    } else {
      $vals = $vars;
    }
    return($vals);
  }   

  function get_log( $lid ) {
    // returns a specific logs data
    $lid = $this->checkNum($lid);
    $query = "SELECT * FROM ".$this->table_logs." WHERE lid = $lid";
    $res = $this->db_quick($query);
    $c = $res? count($res) : 0;
    $this->addDebug("ZenTrack::get_log", "[$c]$query", 3);
    return $res;
  }

  function get_logs( $id, $sort = 'created DESC', $limit = '' ) {
    // retrieve log entries for the given ticket id
    // $limit specifies the max number to return      
    $id = $this->checkNum($id);
    $query = "SELECT * FROM ".$this->table_logs." WHERE ticket_id = $id";
    if( $sort )
      $query .= " ORDER BY $sort";
    if( $limit ) {
      $res = $this->db_getlimitedIndex($query, $limit);
    }
    else {
      $res = $this->db_queryIndexed($query);
    }
    $c = $res? count($res) : 0;
    $this->addDebug("ZenTrack::get_logs", "[$c|".($limit? "limit=$limit" : "no limit")."]$query", 3);
    return( $res );
  }

  function get_project( $pid, $reload = false ) {
    // retrieves all properties from database for given
    // project.  Also returns the following:
    //    children -  an array of tickets that belong to this project 
    //    est_hours - is the estimated time for all tickets associated with 
    //                this project
    //    wkd_hours - is the total hours worked on all tickets for this project
    //    percent_hours - is the percentage completion based on est_ and wkd_
    // if $archive_flag = 1, then will look in archived tickets instead of 
    // active tickets table
    
    // check the cached data
    $t = $reload? false : $this->_session->getDataCache('tickets',$pid);
    if( $t ) { return $t; }

    $table = $this->table_tickets;
    $pid = $this->checkNum($pid);
    $query = "SELECT * FROM $table WHERE id = $pid";
    $vars = $this->db_quickIndexed($query);
    if( is_array($vars) && count($vars) ) {
      $vars["children"] = $this->getProjectChildren($pid);
      $vars['total_children'] = count($vars['children']);
    }
    
    // store in data cache
    $this->_session->storeDataCache('tickets',$pid,$vars);
    
    return($vars);
  }

  function get_projects( $params, $sort = 'priority, otime desc' ) {
    // retrieves a list of projects
    // see get_tickets() for a list of valid params
    // (with the exception of 'type_id' which is set to
    // the id for projects)
    // note that this does not return an accurate result
    // for est_hours and wkd_hours.  Use getProjectHours() 
    // to determine these values
    // if $archive_flag = 1, then retrieves from archive table

    $params["type_id"] = $this->projectTypeID();
    return( $this->get_tickets($params, $sort) );
  }

  function get_ticket( $id, $reload = 0 ) {
    // retrieves the properties for a 
    // specific ticket by id
    // use get_project() instead for projects
    // to retreive accurate est_hours and wkd_hours relative
    // to a project and all it's children
    // $archive_flag retrieves tickets from archive db instead
    // of the ticket db
    
    // check the cached data
    $t = $reload? false : $this->_session->getDataCache('tickets',$id);
    if( $t ) { return $t; }
    
    // load from database
    $id = $this->checkNum($id);
    $table = ($archive_flag)? 
      $this->table_tickets_archived : $this->table_tickets;
    $query = "SELECT * FROM $table WHERE id = $id";
    $vals = $this->db_quickIndexed($query);
    $this->addDebug("get_ticket","result: ".(is_array($vals)?"success":"failed")
                    ."/".$query,3);
                    
    // add to the cache
    $this->_session->storeDataCache('tickets',$id,$vals);
    
    return( $vals );
  }
  
  function getPriorityStyle($priority) {
     // checks settings for priority styles and return the
     // appropriate cell style
     
     if (!$this->getSetting("color_priority_low")) {
        return ("cell");
     } else {
        return ("priority$priority");
     }
  }

  /**
   * returns a count of entries concerning this ticket
   * 
   * indexes returned are attachments, logs, tasks, notify, related
   *
   * @param integer $id the id of the ticket
   * @return array indexed array of integers
   */
  function get_ticket_stats( $id ) {
    // if $id is an array, we probably have the ticket, so
    // just use that
    if( is_array($id) ) {
      $t = $id;
      $id = $t["id"];
    }
    else {
      $t = $this->get_ticket($id);
    }
    $id = $this->checkNum($id);
    $vals = array();

    // get attachments
    $query = "SELECT count(*) FROM ".$this->table_attachments
      ." WHERE ticket_id = $id";
    $vals["attachments"] = $this->db_get($query);

    // get log entries
    $query = "SELECT count(*) FROM ".$this->table_logs." WHERE ticket_id = $id";
    $vals["log"] = $this->db_get($query);

    // get related
    $vals["related"] = strlen($t["relations"])? count(explode(",",$t["relations"])) : 0;
    $this->addDebug("get_ticket_stats","returning counts: ".implode(",",$vals),3);

    // get notify
    $query = "SELECT count(*) FROM ".$this->table_notify_list
      ." WHERE ticket_id = $id";
    $vals["notify"] = $this->db_get($query);

    //get contacts
    $query = "SELECT count(*) FROM " . $this->table_related_contacts . " WHERE ticket_id = $id";
    $vals["contacts"] = $this->db_get($query);

    return $vals;
  }

  /**
   * retrieves a list of tickets
   * 
   * $params can contain:
   *     bins  - string/array of bins to retrieve for
   *     users - string/array of users to retrieve for
   *     id    - an array of specific ticket ids to retrieve
   * the default columns returned can be overriden by using $columns to 
   * specify what should be returned from this function.  Note that the 
   * sort must correspond to the $columns values for SQL compatibility
   * @param array $params see description
   * @param string $sort [optional] comma separated list for ORDER BY clause
   * @param string $columns [optional] comma separated list of columns to select 
   */
  function get_tickets( $params = '', $sort = 'priority desc, otime desc', 
                        $columns = '', $pageNumber = null ) {
    // sorting by priority is a special case... we don't want to sort
    // by the priority_id, we want the sort order, so we will include
    // the priority table and alter the processing slightly to get the
    // desired effect
    $tf_pri = preg_match("/priority/", $sort);
    $this->addDebug('get_tickets', "incoming sort is: $sort",3);

    // parse fields and deal with special values such as custom fields, which
    // mean that we need to include the custom table
    foreach($params as $k=>$v) {
      if( strpos($k, 'custom_') === 0 ) {
        // if we have custom fields in the search criteria, we must include the table
        $tf_vf = true;
        break;
      }
    }
    
    // if we are using the priority table and the priority appears in the where
    // clause, then the priority fields are ambiguous, so we will deal with
    // this case by providing a special name for the priority field.
    if( $tf_pri && array_key_exists('priority', $params) ) {
      $params['t.priority'] = $params['priority'];
      unset($params['priority']);
    }
    
    // if we have custom fields in the sort criteria, we must include the table
    if( !$tf_vf ) { $tf_vf = strpos($sort, 'custom_') === 0; }

    //added for paging feature
    if( !strlen($pageNumber) ) {
      $pageNumber = array_key_exists('pageNumber', $_GET)? 
                  $this->checkNum($_GET['pageNumber']) : 0;
    }
    
    $tables = $this->table_tickets." as t";
    if( $tf_pri ) {
      $tblpri = $this->table_priorities;
      $tables .= ", $tblpri as p";
      $sort = str_replace("priority", "ppri", $sort);
    }
    
    if( $tf_vf ) {
      $tables .= ", ".$this->table_varfield." as vf";
    }
    
    if( $columns && !is_array($columns) ) {
      $columns = explode(',',$columns);
    }

    if( !is_array($columns) ) {
      $columns = $tf_pri? 
         array('id', 'title', 't.priority as priority', 'status',
               'description', 'otime', 'ctime', 'bin_id', 'type_id',
               'user_id', 'system_id', 'creator_id', 'tested', 'approved',
               'relations','project_id','est_hours','deadline','start_date',
               'wkd_hours','p.priority as ppri') : array("*");
    }
    else if( $tf_pri ) {
      if( !in_array("p.priority as ppri", $columns) ) {
        $columns[] = "p.priority as ppri"; 
      }
    }

    if( is_array($params) ) {
      $where = $this->simpleWhere($params);
    }
    if( $tf_pri ) {
      $where = " WHERE t.priority = p.pid ".($where? " AND $where" : "");      
    }
    else {
      $where = $where? "WHERE $where" : '';
    }
    if( $tf_vf ) {
      $where .= $where? " AND t.id = vf.ticket_id " : " WHERE t.id = fv.ticket_id ";
    }
      
    $query = "SELECT ".join(",",$columns)." FROM $tables $where";

    if( $sort )
      $query .= " ORDER BY $sort ";
    
    // check for an unlimited query and don't bother with number of rows
    if( $pageNumber == -1 ) {
      $vals = $this->db_queryIndexed($query);
      $this->addDebug('get_tickets', 'unlimited query['.count($vals).']: '.$query, 3);
      return $vals;
    }
    
    // check and record the number of rows
    $w = preg_replace('/^ *WHERE/', '', $where);
    $this->total_records = $this->db_getrowcount($tables, $w);
    $numtoshow = $this->getSetting('paging_max_rows');
    $start = $pageNumber * $numtoshow;
    if( $start + $numtoshow > $this->total_records ) {
      $numtoshow = $this->total_records - $start; 
    }
    $vals = $this->db_getlimitedIndex($query,$numtoshow,$start);
    $this->addDebug("get_tickets","count(vals)=".count($vals).",numtoshow=".$numtoshow.",start=".$start.",total_records=".$this->total_records.",query=".$query,3);    
    return $vals;
    //return( $this->db_queryIndexed($query) );
  }

  /**
   * retrieves the count of tickets
   *
   * $params can contain:
   *     bins  - string/array of bins to retrieve for
   *     users - string/array of users to retrieve for
   *     id    - an array of specific ticket ids to retrieve
   * the default columns returned can be overriden by using $columns to
   * specify what should be returned from this function.  Note that the
   * sort must correspond to the $columns values for SQL compatibility
   * @param array $params see description
   */
  function count_tickets( $params = '',
                          $archive_flag = 0 ) {
    $tables = $this->table_tickets." t";

    if( is_array($params) ) {
      $where = $this->simpleWhere($params);
    }

    $v = $this->db_getrowcount($tables, $where);
    $this->addDebug("count_tickets","records = ".$v." where = ".$query,3);
    return $v;
  }

  function get_user( $user_id ) {
    // returns a specific user
    // by the user id
    return $this->getUser($user_id);
  }

  function get_user_by_login( $login ) {
    // returns a user's information by 
    // the login account
    $query = "SELECT * FROM ".$this->table_users
      ." WHERE login = ".$this->checkSlashes($login);
    return( $this->db_quickIndexed($query) );
  }
  
  function listTitles($table, $ids) {
    $selectFields = $this->getDataTypeFields( $table );
    $idField = $this->getTableId($table);
    $query = "SELECT $selectFields FROM $table WHERE $idField IN($ids)";
    $vals = $this->db_queryIndexed($query);
    $titles = array();
    if( $vals ) {
      foreach($vals as $v) {
        $id = $v[ $idField ];
        $label = $zen->getDataTypeLabel($table, $vals);
        $titles["$id"] = $label;
      }
    }
    return $titles;
  }

  /**
   * returns a list of users matching the given name
   *
   * @param string $first first name
   * @param string $last last name
   * @param string $initials users initials
   * @return array of user_ids matching
   */
  function get_users_by_name( $first = '', $last = '', $initials = '' ) {
    $query = "SELECT user_id FROM ".$this->table_users." WHERE user_id > 0";
    if( $first ) {
      $query .= " AND fname = ".$this->checkSlashes($first);
    }
    if( $last ) {
      $query .= " AND lname = ".$this->checkSlashes($last);
    }
    if( $initials ) {
      $query .= " AND initials = ".$this->checkSlashes($last);
    }
    return( $this->db_list($query) );
  }

  /**
   * returns a list of users matching the given email address
   *
   * @param string $email the address of users to match
   * @return array of user_ids matching
   */
  function get_users_by_email( $email ) {
    // this is a $this->db_method, even though it doesn't look like one
    $query = "SELECT user_id FROM ".$this->table_users
      ." WHERE email = ".$this->checkSlashes($email);
    return( $this->db_list($query) );
  }

  /**
   * Grabs all users matching the priviledges given for the bins designated.  If
   * a list of bins is provided, then users are returned who can access any of
   * the bins listed.  To enforce users who match all of the bins, you must use
   * checkAccess() against the user/bin combinations.
   *
   * @param array $bins only return users with access to the bins listed
   * @param string $level only return users with at least $level access
   * @param integer $active 1-active members, 0-active and inactive members
   * @return array indexed, containing all fields from each row matched
   */
  function get_users( $bins = '', $level = 'level_view', $active = 1 ) {
    // get our level
    $lvl = $level? $this->getSetting($level) : 0;
    
    $binlist = $bins? join(',', $this->checkNum($bins)) : false;

    // get a list from the access table of invalid bins
    // and map them to user_ids
    $outs = array();  //ones to skip
    $query  = "SELECT user_id,bin_id FROM ".$this->table_access;
    $query .= " WHERE lvl IS NOT NULL AND lvl < $lvl ";
    if( $binlist ) { $query .= " AND bin_id IN($binlist)"; }
    $vals = $this->db_query($query);
    for($i=0; $i<count($vals); $i++) {
      list($k,$v) = $vals[$i];
      if( array_key_exists($k, $outs) ) {
        $outs[$k][] = $v;
      }
      else {
        $outs[$k] = array($v);
      }
    }

    // select all users who appear to have some sort of access to one of the bins
    $query  = "SELECT u.*, a.bin_id ";
    $query .= " FROM {$this->table_users} u LEFT JOIN {$this->table_access} a";
    $query .= " ON (u.user_id = a.user_id)";
    $query .= " WHERE access_level >= $lvl";
    if( $binlist ) {
      $query .= " OR (a.bin_id IN($binlist) AND a.lvl >= $lvl)";
    }
    else {
      $query .= " OR (a.bin_id IS NOT NULL AND a.lvl >= $lvl)";
    }
    if( $active ) { $query .= " AND active = 1"; }
    $query .= " ORDER BY lname,fname";
    $vals = $this->db_queryIndexed($query);
    
    // create the users array, filter out items from our outs list
    $users = array();
    $usermap = array();
    $count = 0;
    for($i=0; $i<count($vals); $i++) {
      $user = $vals[$i];
      $id = $user['user_id'];
      $bin = $user['bin_id'];
      if( $bin && array_key_exists($id, $outs) && in_array($bin, $outs[$id]) ) {
        // skip users for bins which are explicitly disallowed
        continue;
      }
      if( array_key_exists($id, $usermap) ) {
        // add our bin to the list of bins for this user
        $index = $usermap[$id];
        if( array_key_exists($index, $users) && !in_array($bin, $users[$index]['bins']) ) {
          $users[$index]['bins'][] = $bin;
        }
      }
      else {
        // create the user, store the location of the user in our temp map
        // create the special bins array to store valid bins
        $user['bins'] = array($bin);
        $users[$count++] = $user;
        $usermap[$id] = $count;
      }
    }
    
    // debug
    $this->addDebug("get_users","results: ".count($vals)."/$query",3);
    
    // return
    return $users;  
  }

  /*
   * NOTIFY LIST FUNCTIONS
   */

  function get_notify_recipients( $ticket_id ) {
    // Get an array of email addresses.
    // Will need two queries here as some versions of mysql
    // doesn't support JOINS and/or UNIONS as needed for this.

    $ticket_id = $this->checkNum($ticket_id);

    // query for registered users
    $query  = "SELECT u.email FROM ".$this->table_users." u, ";
    $query .= $this->table_notify_list." nl WHERE ";
    $query .= "u.user_id = nl.user_id AND nl.ticket_id = '";
    $query .= $ticket_id."' ";

    // query for non-registered users
    $query2  = "SELECT email FROM ".$this->table_notify_list." WHERE ";
    $query2 .= "user_id IS NULL AND ticket_id = '".$ticket_id."' ";    
   
    // get the lists of recipients and merge them
    $list = $this->mergeArrays($this->db_list($query),$this->db_list($query2));
    // print a debug message
    $this->addDebug("get_notify_recipients","Found ".count($list)
                    ." recipients for ticket $ticket_id",3);
    return $list;
  }

  function get_notify_list( $ticket_id ) {
    $ticket_id = $this->checkNum($ticket_id);
    $query  = "SELECT * FROM ".$this->table_notify_list." WHERE ";
    $query .= "ticket_id = '".$ticket_id."' ";
    $this->addDebug("get_notify_list",$query,3);
    return $this->db_queryIndexed($query);
  }

  function set_notify_list( $ticket_id, $list ) {
    // Do a $this->drop_notify_list($ticket_id)
    // first and then loop through the $list doing INSERTS.
    // note that this list must contain indexed arrays representing
    // each entry to be added
    $ticket_id = $this->checkNum($ticket_id);
    $this->drop_notify_list($ticket_id); 

    // perform database inserts, and return ids
    $insert_ids = array();
    // save what we insert to avoid duplicates
    $done = array();
    foreach($list as $l) {
      if( ($l["user_id"] && in_array($l["user_id"],$done))
          || (!$l["user_id"] && in_array($l["email"],$done)) ) {
        $this->addDebug("set_notify_list","skipped "
                        .($l["user_id"]? "user {$l['user_id']}" : "email {$l['email']}")
                        .": duplicate");
      }
      else {
        $new_id = $this->add_to_notify_list($ticket_id,$l);
        if( $new_id ) {
          $insert_ids[] = $new_id;
          $done[] = $l["user_id"]? $l["user_id"] : $l["email"];
        }
      }
    }
    $this->addDebug("set_notify_list",count($insert_ids)
                    ." inserts for ticket $ticket_id",3);
    return $insert_ids;
  }

  /**
   * add a new entry to the notify list
   *
   * @param integer $ticket_id the id of the ticket
   * @param array $params indexed array of "column"=>"value"
   * @return id if success, "duplicate" if failed on dup entry, false otherwise
   */
  function add_to_notify_list( $ticket_id, $params ) {
    // check for existing entry (avoid dups)
    $ticket_id = $this->checkNum($ticket_id);
    $list = $this->get_notify_list($ticket_id);
    if( is_array($list) ) {
      foreach($list as $l) {
        if( $params["user_id"] && $params["user_id"] == $l["user_id"] ) {
          $this->addDebug("add_to_notify_list",
                          "Skipping {$params['user_id']}/{$params['email']}, duplicate",2);
          return "duplicate";
        }
        else if( !$params["user_id"] && $l["email"] 
                 && $l["email"] == $params["email"] ) {
          $this->addDebug("add_to_notify_list",
                          "Skipping {$params['user_id']}/{$params['email']}, duplicate",2);
          return "duplicate";
        }
      }
    }
    // make sure we don't add the egate user
    if( $params["user_id"] ) {
      $usr = $this->get_user($params["user_id"]);
      if( $usr["login"] == "egate" || $usr["initials"] == "egate" ) {
        $this->addDebug("add_to_notify_list","Ignoring egate account",3);
        return false;
      }
    }

    // make sure we have a valid entry
    if( (!isset($params["user_id"])||!trim($params["user_id"]))
        &&
        (!isset($params["email"])||!trim($params["email"])) ) {
      $this->addDebug("add_to_nofiy_list","Entry was blank",2);
      return false;
    }
    
    // appends a new entry to the existing notify list
    $params["ticket_id"] = $ticket_id;
    $id = $this->db_insert($this->table_notify_list,$params);
    if( $id ) {
      $msg = ($params["user_id"])?
        "user {$params['user_id']} added to ticket $ticket_id"
        : "email address {$params['email']} added to ticket $ticket_id"; 
      $this->addDebug("add_to_notify_list",$msg,2);
      return( $id );
    }
  }

  function delete_from_notify_list( $notify_id ) {
    // removes a single entry from the notify list table
    $notify_id = $this->checkNum($notify_id);
    $query = "DELETE FROM ".$this->table_notify_list
      ." WHERE notify_id = $notify_id";
    $this->addDebug("delete_from_notify_list",$query,3);
    return $this->db_result($query);
  }

  /**
   * deletes entries from notify list based on user_id
   *
   * @param integer user_id
   * @param integer ticket_id optional, restricts matches to this ticket
   * @return integer query results
   */
  function drop_notify_by_user( $user_id, $ticket_id = 0 ) {
    $user_id = $this->checkNum($user_id);
    $query = "DELETE FROM {$this->table_notify_list} WHERE user_id = $user_id";
    if( $ticket_id )
      $query .= " AND ticket_id = $ticket_id";
    $this->addDebug('drop_notify_by_user',$query,3);
    return $this->db_result($query);
  }

  /**
   * deletes entries from notify list based on email address
   *
   * this checks both the user table and the notify table for matching
   * email addresses
   *
   * @param string email address
   * @param integer ticket_id optional, restricts matches to this ticket
   * @return boolean true if matched, false if not
   */
  function drop_notify_by_email( $email, $ticket_id = 0 ) {
    // delete entries in the notify list table
    $email = $this->checkSlashes($email);
    $query = "DELETE FROM {$this->table_notify_list} WHERE email = $email";
    if( $ticket_id )
    $query .= " AND ticket_id = $ticket_id";
    $this->addDebug('drop_notify_by_email', $query, 3);
    $res = $this->db_result($query);
    // get a list of users matching from users table
    // and delete those from notify too
    $query = "SELECT user_id FROM {$this->table_users} WHERE email = $email";
    $this->addDebug('drop_notify_by_email', $query, 3);
    $ids = $this->db_list($query);
    if( is_array($ids) && count($ids) ) {
      $query = "DELETE FROM {$this->table_notify_list} WHERE user_id in(".
      join(",",$ids).")";
      if( $ticket_id )
      $query .= " AND ticket_id = $ticket_id";
      $this->addDebug('drop_notify_by_email', $query, 3);
      $res2 = $this->db_result($query);
    }
    return($res || $res2);
  }

  function drop_notify_list( $ticket_id ) {
    // Do a DELETE FROM ZENTRACK_NOTIFY_LIST WHERE ticket_id = $ticket_id
    $ticket_id = $this->checkNum($ticket_id);
    $q  = "DELETE FROM {$this->table_notify_list} WHERE ticket_id = '";
    $q .= "$ticket_id' ";
    $this->addDebug("drop_notify_list",
                    "notify list dropped for ticket $ticket_id",2);
    $this->db_result($q);
  }

  /**
   * update notify list based on changes
   *
   * given an old ticket and a new ticket
   * this function attempts to update the notify
   * list by removing old owners/testers/managers
   * and adding new ones
   * 
   * @param array $old is the old ticket's properties
   * @param array $new is the new ticket's properties
   */
  function update_notify_list($old, $new) {
    $id = $old["id"];
    if( strlen($new["user_id"]) && $new["user_id"] != 'NULL' 
    && $this->settingOn("default_notify_owner") ) {
      // see if they changed
      if( $old["user_id"] != $new["user_id"] ) {
        // drop the old user
        if( $old["user_id"] ) {
          $this->drop_notify_by_user($old["user_id"],$id);
        }
        // add the new user
        if( $new["user_id"] ) {
          $p = array("user_id"=>$new["user_id"]);
          $this->add_to_notify_list($id,$p);
        }
      }
    }
    // shorten up some settings for brevity
    $dnm = $this->settingOn("default_notify_manager");
    $dnt = $this->settingOn("default_notify_tester");
    if( isset($new["bin_id"]) && ($dnm || $dnt) ) {
      // check if bin has changed
      if( $old["bin_id"] != $new["bin_id"] ) {
        $tester_id = $this->getRoleID("tester");
        $mgr_id = $this->getRoleID("manager");
        // drop the managers and testers from old bin
        if( $old["bin_id"] ) {
          $vars = array();
          $roles = $this->fetch_bin_roles($old["bin_id"]);
          if( is_array($roles) ) {
            foreach($roles as $r) {
              if( $r["notes"] == $mgr_id && $dnm ) { 
                $vars[] = $r["user_id"];
              }
              else if( $r["notes"] == $tester_id && $dnt ) {
                $vars[] = $r["user_id"];
              }
            }
          }
          // remove the completed list
          foreach($vars as $v) {
            $this->drop_notify_by_user($v,$id);
          }
        }
        // add managers and testers for new bin
        if( $new["bin_id"] ) {
          $roles = $this->fetch_bin_roles($new["bin_id"]);
          if( is_array($roles) ) {
            foreach($roles as $r) {
              if( ($r["notes"] == $tester_id && $dnt) ||
              ($r["notes"] == $mgr_id && $dnm) )
              $this->add_to_notify_list($id,
              array("user_id"=>$r["user_id"]));
            }
          }
        }
      }
    }
  }

  /**
   * BEHAVIORS
   */

  /**
   * Returns a single behavior by id
   *
   * @param integer $behavior_id
   * @return array
   */
  function getBehavior( $behavior_id ) {
    $behavior_id = $this->checkNum($behavior_id);
    $vals = $this->getBehaviorList(0, array($behavior_id));
    return $vals["{$behavior_id}"];
  }

  /**
   * Returns a list of behaviors mapped by the behavior_id with the detail fields for each.  The list
   * will be sorted by the sort_order from the behavior table.
   *
   * @param array $ids is a list of behavior ids to retrieve, if ommitted, all behaviors are listed
   * @param integer $active 1=active only, 0=all
   * @return array containing behavior_id -> array( data values... )
   */
  function getBehaviorList( $active = 1, $ids = null ) {
    // construct sql statement to retrieve behaviors
    $query = "SELECT * FROM ".$this->table_behavior;
    if( $ids ) {
      $query .= " WHERE behavior_id IN(";
      for($i=0; $i<count($ids); $i++) {
        if( $i > 0 ) { $query .= ","; }
        $query .= $this->checkNum($ids[$i]);
      }
      $query .= ")";
    }
    if( $active ) {
      $query .= $ids? " AND " : " WHERE ";
      $query .= " is_enabled = 1 ";
    }
    $query .= " ORDER BY sort_order, behavior_name";
    $this->addDebug("getBehaviorListQuery:",$query,3);
    $vals = $this->db_queryIndexed($query);

    // create a map of behaviors indexed by the behavior_id
    $map = array();

    if ( is_array($vals) ) {
      foreach( $vals as $v ) {
        $k = $v['behavior_id'];
        $v['fields'] = array();
        $map["{$k}"] = $v;
      }

      // collect the fields for our list of behaviors
      // we will always use the ids from our map for
      // data integrity
      $genIds = array_keys($map);
      $query = "SELECT * FROM ".$this->table_behavior_detail;
      $query .= " WHERE behavior_id IN(".join(',', $genIds).")";
      $query .= " ORDER BY sort_order, field_name";
      $this->addDebug("getBehaviorListQueryForDetails:",$query,3);
      $fieldVals = $this->db_queryIndexed($query);
      if ( is_array($fieldVals) ) {
        foreach($fieldVals as $f) {
          $b = $f['behavior_id'];
          $map["{$b}"]['fields'][] = $f;
        }
      }
    }
    $this->addDebug("getBehaviorList",count($map)." behaviors mapped", 3);
    return $map;
  }

  /**
   * Add a new behavior to the database
   *
   * @param array $props contains the database fields for this behavior
   * @param array $details is mapped field_name -> array( db fields ) and holds all detail entries for this behavior
   * @return integer the id of the newly created behavior or null on failure
   */
  function addBehavior( $props, $details ) { 
    $id = $this->db_insert( $this->table_behavior, $props );
    if( $id ) {
      $this->updateBehaviorDetails( $id, $details );
      $this->addDebug("addBehavior", "Added new behavior with id '".$id."'", 2);
    }
    else {
      $this->addDebug("addBehavior", "Failed to add new behavior!", 3);
    }
    return $id;
  }

  /**
   * Remove a behavior and all of its detail entries from the database
   *
   * @param integer $behavior_id the behavior to remove
   * @return integer representing the query result
   */
  function removeBehavior( $behavior_id ) { 
    $behavior_id = $this->checkNum($behavior_id);
    $this->db_delete($this->table_behavior_detail, "behavior_id", $behavior_id);
    return $this->db_delete( $this->table_behavior, "behavior_id", $behavior_id );
  }

  /**
   * Update the properties for a behavior.
   *
   * @param integer $behavior_id the behavior to update
   * @param array $props the new properties for this behavior
   */
  function updateBehavior( $behavior_id, $props ) {
    $behavior_id = $this->checkNum($behavior_id);
    return $this->db_update( $this->table_behavior, "behavior_id", $behavior_id, $props );
  }

  /**
   * Update the detail entries for a behavior.  This is accomplished by deleting all current entries and
   * adding the updated values to the table.
   *
   * @param integer $behavior_id the behavior to update.
   * @param array $fields mapped field_name -> array(data fields)
   */
  function updateBehaviorDetails( $behavior_id, $fields ) { 
    $behavior_id = $this->checkNum($behavior_id);
    $this->db_delete($this->table_behavior_detail, "behavior_id", $behavior_id);
    foreach($fields as $f) {
      // make sure we add in the behavior id to each row
      $f['behavior_id'] = $behavior_id;
      if( !$f['sort_order'] ) { $f['sort_order'] = 0; }
      list($ck,$cv) = $this->makeInsertVals($f);
      $this->db_result("INSERT INTO ".$this->table_behavior_detail." ($ck) VALUES($cv)");
    }
  }


  /**
   * Return an array with all the non-custom fields that can be used in behaviors
   *
   * @return array mapped translated_field_label -> field_name sorted by key
   */
  function getStdBehaviorFieldsArray() {
    $field_list=array(
               tr("Title") => "title",
               tr("Priority") => "priority",
               tr("Status") => "status",
               tr("Description") => "description",
               tr("Open Time") => "otime",
               tr("Close Time") => "ctime",
               tr("Bin") => "bin_id",
               tr("Type") => "type_id",
               tr("Owner") => "user_id",
               tr("System") => "system_id",
               tr("Created by") => "creator_id",
               tr("Tested") => "tested",
               tr("Approved") => "approved",
               tr("Project") => "project_id",
               tr("Estimated Hours") => "est_hours",
               tr("Deadline") => "deadline",
               tr("Start Date") => "start_date");
    ksort($field_list);
    return($field_list);
  }


  /**
   * Return an array with the fields that can be used in behaviors
   *
   * @return array mapped translated_field_label -> field_name sorted by key
   */
  function getBehaviorDestinationFieldsArray() {
    $field_list=$this->getStdBehaviorFieldsArray();
    $custom=$this->getCustomFields(1);
    foreach($custom as $k => $v) {
      $field_list["{$v}"]=$k;
    }
    ksort($field_list);
    return($field_list);
  }

  /**
   * Return an array with the comparison operators that can be used in behaviors
   *
   * @return array mapped translated_operator_name -> operator_name sorted by key
   */
  function getBehaviorOperators() {
    return array(
                "eq"   =>   tr("Equals"),
                "ne"   =>   tr("Not equal"),
                "co"   =>   tr("Contains"),
                "nc"   =>   tr("Does not contain"),
                "sw"   =>   tr("Starts with"),
                "ew"   =>   tr("Ends with"),
                "gt"   =>   tr("Greater than"),
                "lt"   =>   tr("Less than"),
                "ge"   =>   tr("Greater than or equal"),
                "le"   =>   tr("Less than or equal"),
                "js"   =>   tr("Evaluate")                
                    );
    //natsort($beh_opers);
    //return($beh_opers);
  }



  /*
   *  VARIABLE FIELDS
   */


  /**
   * Get variable field properties from the index table.  These fields will be returned sorted
   * and with all information needed to determine where fields are active and how to display them.
   */
  function getVarfieldIndex() { 
    return $this->getCustomFields(1);
  }


  /**
   * Update the properties for variable fields in the index table.
   *
   * @param array $fields is mapped (String)field_name -> array( (String)prop -> (mixed)value )
   * @return integer count of fields updated
   */
  function updateVarfieldIndex( $fields ) { 
    $count = 0;
    foreach( $fields as $name=>$props ) {
      $set = $this->makeInsertVals($props, 1);
      if( $this->db_update($this->table_varfield_idx, "field_name", $name, $props) ) 
        { $count++; }
    }
    return $count;
  }


  /**
   * Removes an entry from the variable field index table.  Use this method with great care.  This
   * is not used to disable fields, and should only be used for removing fields which do not exist
   * in the database.
   *
   * @param string $field_name the variable field which no longer exists in the database
   */
  function removeVarfieldIndex( $field_name ) { 
    $field_name = $this->checkAlpha($field_name);
    return $this->db_delete( $this->table_varfield_idx, "field_name", $field_name );
  }


  /**
   * Adds a new entry to the variable field index table
   *
   * @param array $props mapped (String)field -> (mixed)value
   */
  function addVarfieldIndex( $props ) { 
    // we don't use the $this->db_insert() method here because it requires
    // a sequence/auto_increment field, which isn't used in this table
    list($cols,$vals) = $this->makeInsertVals($props);
    $query = "INSERT INTO ".$this->table_varfield_idx." ($cols) VALUES($vals)";
    return $this->db_result($query);
  }

  /**
   * Get variable field values for a given ticket
   *
   * @param integer $ticket_id
   * @return array containing variable field entries for this ticket
   */
  function getVarfieldVals( $ticket_id ) { 
    $ticket_id = $this->checkNum($ticket_id);
    $query = "SELECT * FROM ".$this->table_varfield." WHERE ticket_id = $ticket_id";
    $res =  $this->db_quickIndexed($query);
    $fm = new ZenFieldMap($this);
    
    // we initialize all of the multifields, even if they do not contain a value
    $multi_fields = $fm->listMultiFields();
    foreach($multi_fields as $v) {
      $res[$v] = array();
    }

    // now we will collect the multi field values in one bulk operation
    $query = "SELECT field_name, field_value FROM {$this->table_varfield_multi} WHERE ticket_id = $ticket_id";
    $vals = $this->db_query($query);
    
    // then we run through the ones from the db and add them to the results
    if( $vals ) {
      foreach($vals as $val) {
        list($n, $v) = $val;
        if( !array_key_exists($n, $res) ) {
          // create an error if, for some reason, the db entries don't match our
          // list of possible fields
          $this->addDebug('zenTrack::getVarfieldVals', "Invalid multifield key: $n", 1);
          continue;
        }
        $res[$n][] = $v;
      }
    }
    return ($res);
  }
  
  /**
   * Collect variable field information for several tickets
   *
   * @param array $ids contains ticket ids
   * @param array $columns contains (string)column_name, if only some columns are desired
   * @return array containg ticket_id => array( fields... )
   */
   function getVarfieldsForTickets( $ids, $columns = false ) {
     $ids = $this->cleanInput("int", $ids);
     $skip_id = $columns && !in_array('ticket_id',$columns);
     if( $columns ) {
       $cols = !$skip_id? '' : 'ticket_id';
       $mcols = array();
       $fm = new ZenFieldMap($this);
       $multi_fields = $fm->listMultiFields();
       foreach($columns as $c) {
         if ( strpos($c,'custom_multi')===false ) {
           if( $cols ) { $cols .= ','; }
           $cols .= $c;
         } else {
           if ( in_array($c,$multi_fields) ) {
             $mcols[]=$c;
           }
         }
       }
     }
     else { $cols = "*"; }
     $query = "SELECT $cols FROM ".$this->table_varfield." WHERE ticket_id in (".join(",",$ids).")";
     $vals = $this->db_queryIndexed($query);
     $vars = array();
     for($i=0; $i < count($vals); $i++) {
       $k = $vals[$i]['ticket_id'];
       foreach ($mcols as $mc) {
         $query = "SELECT field_value FROM ".$this->table_varfield_multi." WHERE ticket_id = $k AND field_name='".$mc."'";
         $vals[$i][$mc] = $this->db_list($query);
       }
       if( $skip_id ) { unset($vals[$i]['ticket_id']); }
       $vars["$k"] = $vals[$i];
     }
     return $vars;
   }


  /**
   * Update the entries in the variable field table for a given ticket
   *
   * @param integer $ticket_id
   * @param array $field_values mapped (String)field_name -> (String)value
   * @param integer $user_id user who edited
   * @param integer $bin_id bin where edit occured (prevents sql query for ticket)
   * @param integer $mode if set to any value, don't log but use log_buffer
   */
  function updateVarfieldVals( $ticket_id, $field_values, $user_id = null, $bin_id = null, $mode = null ) { 
    $ticket_id = $this->checkNum($ticket_id);
    $user_id = $this->checkNum($user_id);
    $a = $this->getSetting('varfield_tab_name');
    if ($mode) {
      $log_entry="";
    } else {
      $log_entry = $a? "Updated ".ucfirst(strtolower($a))." fields" : "Updated Custom Fields";
    }
    $oldVals = $this->getVarfieldVals($ticket_id);
    $field_values_std = array();
    $field_values_multi = array();
    foreach($field_values as $key=>$val) {
      $v1=$oldVals["$key"];
      $v2=$val;
      $fm = new ZenFieldMap($this);
      $label = $fm->getLabel("ticket_edit",$key);
      if( strpos($key, 'date') > 0 ) {
        if ( is_null($oldVals["$key"]) || $oldVals["$key"] == 0 ) {
          $v1 = 'NULL';
        } else { 
          $v1 = $this->showDateTime($oldVals["$key"]);
        }
        if ( is_null($val) || $val == 0 ) {
          $v2 = 'NULL';
        } else { 
          $v2 = $this->showDateTime($val);
        }
      }
      else if( strpos($key, 'number') > 0 ) {
        if( is_null($oldVals["$key"]) ) {
          $v1 = 0;
        } else {
          $v1 = $oldVals["$key"];
        }
        if( is_null($val) ) {
          $v2 = 0;
        } else {
          $v2 = $val;
        }
      } else if ( ZenFieldMap::isMultiField($key) ) {
        if ( !is_array($oldVals[$key]) || count($oldVals[$key])==0 ) {
          $v1 = 'NULL';
        } else {
          $v1 = implode($this->multisep, $oldVals[$key]);
        }
        if ( !is_array($val) || count($val)==0 ) {
          $v2 = 'NULL';
        } else {
          $v2 = implode($this->multisep, $val);
        }
      }
      // find out if value was updated, check strlen so that 0 != '', and so forth
      if( $v1 != $v2 && ($v1 || strlen($v1) == strlen($v2)) ) { $log_entry .= "\n - {$label} changed from [$v1] to [$v2]"; }
      
      //split the multi fields appart so that we can call the db_update function for all the other fields:
      if ( strpos($key, 'custom_multi') === false ) {
        $field_values_std[$key] = $val;
      } else {
        $field_values_multi[$key] = $val;
      }
    }
    $res = $this->db_update( $this->table_varfield, "ticket_id", $ticket_id, $field_values_std );
    if ($res && count($field_values_multi) ) {
      foreach($field_values_multi as $key=>$val) {
        $query = "DELETE FROM ".$this->table_varfield_multi." WHERE ticket_id = ".$ticket_id." AND field_name = '".$key."'";
        $res_del = $this->db_result($query);
        $this->addDebug("updateVarfieldVals - db_result", "[$res_del]".$query, 3);
        if( $val && !is_array($val) ) { $val = explode($this->multisep, $val); }
        if( is_array($val) ) {
          foreach ($val as $element) {
            $multi_entry = array('ticket_id' => $ticket_id,
                                 'field_name' => $key,
                                 'field_value' => $element);
            $res_ins = $this->db_insert($this->table_varfield_multi,$multi_entry);
          }
        }
      }
    }
    if( $res && $this->settingOn('log_edit') ) {
      // add a log entry
      if ($mode) {
        $this->log_buffer.=$log_entry;
      } else {
        $this->add_log( $ticket_id, array('user_id'   => $user_id,
                                          'bin_id'    => $bin_id,
                                          'action'    => 'EDIT',
                                          'entry'     => $log_entry) );
      }
    }
    $this->_session->clearDataCache('tickets',$ticket_id);
    return $res;
  }


  /**
   * Update standard and variable fields for a ticket, and log only once
   *
   * @param integer $id Ticket ID
   * @param integer $login_id user who is updating the ticket
   * @param integer $bin_id Ticket's current bin (I can get it from the ticket too...)
   * @param array $params (only for standard fields) mapped field_name -> value
   * @param array $varfield_params (only for custom fields) mapped field_name -> value
   * @param string $action The action name to be logged (default EDIT)
   * @param string $edit_reason reason why the ticket is being edited (user entry)
   */
  function update_all_ticket_fields($id, $login_id, $bin_id, $params,
                                    $varfield_params, $action="EDIT", $log_init="", $edit_reason="") {
    $this->log_buffer=$log_init."\n\n";
    $errs = array();
    // update the ticket info
    $res = $this->edit_ticket($id,$login_id,$params,$edit_reason, 1);
    // check for errors
    if( !$res ) {
      $errs[] = tr("System Error").": ".tr("Ticket could not be edited.")." ".$zen->db_error;
    }
    else if( count($varfield_params) ) {
      $res = $this->updateVarfieldVals($id, $varfield_params, $login_id, $bin_id, 1);
      if( !$res ) {
        $errs[] = tr("? updated, but variable fields could not be saved", array(tr($x)));
        $this->log_buffer.=tr("Variable fields could not be saved");
        $this->add_log( $id, array('user_id'   => $login_id,
                                   'action'    => $action,
                                   'entry'     => $this->log_buffer,
                                   'bin_id'    => $bin_id) );
      }
    }
    if(!$errs) {    
      $this->add_log( $id, array('user_id'   => $login_id,
                                 'action'    => $action,
                                 'entry'     => $this->log_buffer,
                                 'bin_id'    => $bin_id) );
    }
    return $errs;
  }



  /**
   * DATA GROUP FUNCTIONS
   */
   
  /**
   * Return info about data groups, including the field values and the
   * generated labels for each field.
   *
   * @param array $group_ids if provided, only these groups are retrieved, otherwise all groups
   */
  function generateDataGroupInfo( $group_ids = null ) {
    // this will store all of the group information which is to be
    // returned to the caller
    $groups = array();
    
    // this will store relationships between tables and the groups
    // which reference each table
    $tables = array();
    
    // collect a list of groups and map them
    // into useful arrays
    $query = "SELECT * FROM ".$this->table_group;
    if( $group_ids ) {
      $query .= " WHERE group_id IN(";
      for($i=0; $i<count($group_ids); $i++) {
        if( $i > 0 ) { $query .= ","; }
        $query .= $this->checkNum($group_ids[$i]);
      }
      $query .= ") ";
    }
    $vals = $this->db_queryIndexed($query);
    $this->addDebug("generateDataGroupInfo", $query, 3);

    // if there are no groups, then skip this process
    if( !$vals || !count($vals) ) {
      $this->addDebug("generateDataGroupInfo", "There appear to be no data groups, skipping", 2);
      return $groups;
    }
    foreach($vals as $v) {
      $k = $v['group_id'];
      $t = $v['table_name'];
      $v['fields'] = array();
      $groups["$k"] = $v;
      if( $v['eval_type'] == 'Matches' ) {
        if( $v['include_none'] ) {
          // make the select menu optional by including a -none- option
          $groups["$k"]['fields'][] = array('field_value'=>null, 'label'=>'-none-');
        }
        // get values from database
        if( $t ) {
          // if this is a custom group, there will be no
          // table reference, so we will custom generate the
          // labels
          if( !$tables["$t"] ) { $tables["$t"] = array(); }
          $tables["$t"][] = $k;
        } 
        else {
          $query = "SELECT field_value FROM ".$this->table_group_detail
             ." WHERE group_id = {$k} ORDER BY sort_order, field_value";
          $this->addDebug('generateDataGroupInfo', "custom: {$query}", 3);
          $vars = $this->db_queryIndexed($query);
          if( is_array($vars) ) {
            foreach($vars as $v) {
              $g = $v['field_value'];
              $groups["$k"]['fields'][]=array('field_value'=>$g, 'label'=>$g);
            }
          }
        }
      }
    }
    
    // select all of the fields from the detail table, join to the appropriate
    // data table for sorting and collecting labels
    foreach($tables as $table=>$grps) {
      // figure out which fields represent the id and sorting params
      // for the current data type table
      $id_field = $this->getDataTypeId($table);
      $sort_field = $this->getDataTypeSort($table);
      $fields = $this->getDataTypeFields($table);

      // now we will select all entries for groups which match this data
      // type table and generate labels for them, note that we sort
      // first on the sort_order from this table and then by the normal
      // sorting specified in the data type table
      $query = "SELECT {$fields}, field_value, group_id FROM {$table}, "
        .$this->table_group_detail." WHERE group_id IN(".join(',',$grps).") "
        ." AND field_value = {$id_field} ORDER BY sort_order,{$sort_field}";
      $this->addDebug('generateDataGroupInfo', "{$table}: {$query}", 3);
      $vals = $this->db_queryIndexed($query);
      if( is_array($vals) ) {
        foreach($vals as $v) {
          // iterate over our values obtained from detail table
          // and generate entries (with labels) in the groups array
          $g = $v['group_id'];
          $l = $this->getDataTypeLabel($table,$v);
          $groups["$g"]['fields'][] = array('field_value'=>$v['field_value'], 'label'=>$l);          
        }
      }
    }
    return $groups;
  }
  
  /**
   * Returns a set of data for behaviors and groups. The format as follows:
   * <pre>
   *   array(
   *       [set_id] => array( matches, values ),
   *       [1] => array( matches, values )
   *       ....
   *   );
   * </pre>
   *
   * <p>Where the <i>setid</i> is the name of the set of matches/values
   * <p>the <i>matches</i> array contains match fields in the format:
   * <br><code>array( 'field_name', 'operator', 'column_number')</code>
   * <p>And the <i>values</i> array contains the group values to be used.
   *
   * @param array $behavior array containing the behavior's properties
   * @param array $group array containing the group properties
   * @param array $validBins bins that the current user can access
   * @param array $mode create, edit, or view (for bin/user/ticket access)
   */
   function getBehaviorFileSet( $behavior, $group, $validBins ) {
     // generate file contents
     $fn = $this->libDir."/user_data/{$group['name_of_file']}";
     $vals = array();
     if( !@file_exists($fn) ) {
        $this->addDebug('getBehaviorFileSet',"Invalid filename: $fn",1);
        return $vals;
     }
     $contents = file($fn);
     
     // determine which column contains the value so that we don't have
     // to do this during each iteration.  We will also buffer the possible
     // values for each column now, so that we can check them while iterating
     // the values (without mutliple db calls)
     $possibleValues = array();
     $valueColumnIndex = null;
     foreach($behavior['fields'] as $f) {
       if( $f['field_name'] == 'value_column' ) {
          $valueColumnIndex = $f['field_value']-1;
          $fn = $behavior['field_name'];
       }
       else {
          $fn = $f['field_name'];
       }
       $possibleValues[$fn] = $this->getValsForTicketField( $fn, $validBins );
     }
     
     // blow up and burn in fiery death
     if( !strlen($valueColumnIndex) ) {
       $this->addDebug('getBehaviorFileSet', 
          "Value column index not specified for behavior "
          ."'{$behavior['behavior_name']}'", 1);
       return $vals;
     }
     
     // get the index for columns to be read
     $rowCount=0;
     foreach($contents as $lineOfData) {
       $dataRow = explode("\t",trim($lineOfData));
       $key = $this->_genMatchesKey($behavior, $group, $dataRow);
       
       if( !array_key_exists($key, $vals) ) {
         // this is a new set, so generate everything we need
         // start by initializing the array
         $vals[$key] = array( 'matches'=>array(), 'values'=>array() );
  
         // generate the matches needed for this set
         foreach($behavior['fields'] as $field) {
           $i = $field['field_value']-1;
           $n = $field['field_name'];
           if( $i >= count($dataRow) ) {
             $this->addDebug('getBehaviorFileSet',"Column requested by '$n' does not exist",1);
             continue;
           }
           if( $field['field_name'] != 'value_column' ) {
             $v = $dataRow[$i];
             if( strlen($v) ) {
               // attempt to retrieve the valid id and label for this field based
               // on the value provided here.
               $w = $this->_getValFromSet($possibleValues, $field['field_name'], $v);
               if( !strlen($w) ) {
                  $this->addDebug('getBehaviorFileSet', "The requested match value "
                    ." ($v) appears to be invalid", 2);
               }
               else {
                  $v = $w[0];
               }
             }
             $vals[$key]['matches'][] = array('field_name'     => $n, 
                  'field_operator' => 'eq',
                  'field_value'    => $v);
           }
         }
       }
       
       // add the value to our data set
       $d = $dataRow[$valueColumnIndex];
       if( !strlen($d) ) {
         $this->addDebug('getBehaviorFileSet', "$key: file missing value column at line $rowCount", 1);
       }
       else {
         $v = $this->_getValFromSet($possibleValues, $behavior['field_name'], $d);
         $vals[$key]['values'][] = $v? array('field_value'=>$v[0],'label'=>$v[1]) : $d;
         $this->addDebug('getBehaviorFileSet', "$key: adding value '".($v? $v[0].'->'.$v[1]: $d)."'", 3);
       }
     }
     
     return $vals;
   }
   
  /**
   * Extract value from an indexed array of id/label pairs.
   *
   * @param array $vals the set containing rows of id/label pairs
   * @param int $key the associative array to look in
   * @param mixed $value an id OR a label (can search either way)
   * @return mixed array containing (id, label) or null (if not found)
   */
   function _getValFromSet( $vals, $key, $value ) {
     if( !strlen($value) ) {
       $this->addDebug('_getValFromSet', "$vals, $key, $value: value empty, nothing to fetch", 2);
       return null; 
     }
     if( !array_key_exists("$key", $vals) || !strlen($vals["$key"]) ) {
       $this->addDebug('_getValFromSet', "$vals, $key, $value: '$key' not a valid key(data type)", 3);
       return null;
     }
     if( preg_match('/^[0-9]+$/', $value) ) {
       // this is an id
       if( !array_key_exists("$value", $vals["$key"]) ) {
         $this->addDebug('_getValFromSet', "id \$vals['{$key}']['{$value}'] not found, probably invalid", 1);
          return null; 
       }
       else {
         return array($value, $vals[$key]["$value"]);
       }
     }
     else {
       // this is a label
       foreach($vals["$key"] as $k=>$v) {
         if( strtolower($v) == strtolower($value) ) {
            return array($k,$v); 
         }
       }
       $this->addDebug('_getValFromSet', "id \$vals['{$key}']['{$value}'] not found, probably invalid", 1);
       return null;
     }
   }
   
  /**
   * Create a unique identifier for a data set used by behaviors
   *
   * @param array $behavior
   * @param array $group
   */
   function _genMatchesKey( $behavior, $group, $dataRow ) {
      $key = 'B'.$behavior['behavior_id'];
      $key .= 'G'.$behavior['group_id'];
      for($i=0; $i<count($behavior['fields']); $i++) {
        if( $behavior['fields'][$i]['field_name'] != 'value_column' ) {
          $k = $behavior['fields'][$i]['field_value']-1;
          $key .= ":$i-".$dataRow[ $k ];
        }
      }
      return $key;
   }
   
  /**
   * Return the information of the data group specified by $group_id
   *
   * @param integer $group_id
   * @return mixed array containin data or false if not found
   */
   function getDataGroup($group_id) {
      return $this->get_data_group($group_id); 
   }
   
  function get_data_group( $group_id ) {
    $group_id = $this->checkNum($group_id);
    $query = "SELECT * FROM ".$this->table_group
      ." WHERE group_id = ".$group_id;
    $vals = $this->db_quickIndexed($query);
    if( !is_array($vals) || !count($vals) ) { return false; }
    if( $vals['eval_type'] == 'File' ) { $vals['details'] = array(); }
    else {
      $vals['details'] = $this->get_data_group_details($group_id);      
    }
    return $vals;
  }
  
  /**
   * Return a data group's id using the name (which must be unique)
   *
   * @param string $name name of group to retrieve
   * @return mixed array or null if not found
   */
  function getDataGroupId( $name ) {
    $query = "SELECT group_id FROM ".$this->table_group
      ." WHERE group_name = ".$this->checkSlashes( $name );
    return $this->db_get($query);
  }
                                                                                                          
  /**
   * Return the information of the data group detail specified by $group_id
   *
   * @param mixed $group_id (integer)group_id
   * @return array with information about the data group detail
   */
  function get_data_group_details( $group_id ) {
    $group_id = $this->checkNum($group_id);
    $query = "SELECT * FROM ".$this->table_group_detail
      ." WHERE group_id = $group_id"
      ." ORDER BY sort_order";
    return( $this->db_queryIndexed($query) );
  }

  /**
   * Return the labels for each detail in a data group, mapped by the id
   *
   * @param string $table the data table, available from the data group info
   * @param array $details the results of get_data_group_details()
   */
  function getDataGroupLabels( $table, $details ) {
    $table = strtoupper($this->checkAlphaNum($table));
    $idfield = $this->getDataTypeId($table);
    $sortfield = $this->getDataTypeSort($table);
    if( !is_array($details) || !count($details) ) {
      $this->addDebug("getDataGroupLabels", "Empty detail list, returning empty set", 2);
      return array();
    }
    $ids = array();
    if( is_array($details) && count($details) ) {
      foreach($details as $d) {
        $ids[] = $d['field_value'];
      }
    }
    $query = "SELECT * FROM {$table} WHERE {$idfield} IN( ".join(",",$ids).")";
    $query .= " ORDER BY {$sortfield}";
    $vals = $this->db_queryIndexed($query);
    $retvals = array();
    if( is_array($vals) && count($vals) ) {
      foreach($vals as $val) {
        $k = $val[ $idfield ];
        $retvals[$k] = $this->getDataTypeLabel($table,$val);
      }
    }
    return $retvals;
  }

  /**
   * returns information about available data groups
   *
   * if flag is set, retrieves a full
   * indexed array, otherwise, just
   * a list of names, indexed by group_id,
   *
   * @param int $flag 1=return full info, 0=return group_ids and names
   * @return array of data groups
   */
  function getDataGroups($flag = 0) {
    if( !$flag ) {
      $query = "SELECT group_id, group_name FROM ".$this->table_group." ORDER BY group_name";
      $vars = $this->db_query($query);
      if (is_array($vars)) {
        foreach($vars as $v) {
          $vals["$v[0]"] = $v[1];
        }
      } else {
        $vals=array();
      }
      return($vals);
    } else {
      $query = "SELECT * FROM ".$this->table_group;
      $query .= " ORDER BY group_name";
      return( $this->db_queryIndexed($query) );
    }
  }

  /**
   * Return a count of entries for each data group
   */
  function getDataGroupCounts() {
    $query = "SELECT group_id, count(*) FROM ".$this->table_group_detail
      ." GROUP BY group_id";
    return $this->db_listIndexed($query);
  }

  /**
   * Create a new group with the provided information
   *
   * @param string $name name of the group
   * @param string $table the table this group applies to
   * @param array $vals the values as they would be passed to {@link ZenTrack::updateDataGroupDetails()}
   * @param string $evalType 'Javascript' or 'Matches'
   * @param string $evalText javascript text for evals
   * @return integer
   */
  function addDataGroup( $name, $table, $descript, $evalType, $evalText, 
                         $name_of_file, $include_none, $vals = null ) { 
    // create the group first
    $id = $this->db_insert( $this->table_group, 
                            array("table_name"=>$table, 
                                  "group_name"=>$name, 
                                  "descript"=>$descript,
                                  "eval_type"=>$evalType,
                                  "eval_text"=>$evalText,
                                  "name_of_file"=>$name_of_file,
                                  'include_none'=>$include_none));
    if( $id && $vals ) {
      $this->_insertGroupDetails($id, $vals);
    }
    return $id;
  }

  /**
   * Get an array with the tables that are available for data groups
   *
   * @return array
   */
  function getDataGroupTablesArray() {
    return array("Bins"           =>  $this->table_bins,
                 "Priorities"     =>  $this->table_priorities,
                 "Systems"        =>  $this->table_systems,
                 "Tasks"          =>  $this->table_tasks,
                 "Types"          =>  $this->table_types,
                 "Users"          =>  $this->table_users,
                 "Custom"         =>  "");
  }

  
  /**
   * Update an existing data group.  To update the detail values, use {@link ZenTrack::updateDataGroupDetails()}.
   *
   * @param integer $group_id the id of the data group to be updated
   * @param string $name the updated name of the group
   * @param string $table the updated table for the group
   * @param string $evalType 'Javascript' or 'Matches'
   * @param string $evalText javascript text for evals
   */
  function updateDataGroup( $group_id, $name, $table, $evalType, $evalText, 
                            $descript, $name_of_file, $include_none ) {     
    $group = $this->get_data_group($group_id);
    if( $group['table_name'] != $table ) {
      $this->db_delete($table_group_detail, "group_id", $group_id);
    }
    return $this->db_update($this->table_group, "group_id", $group_id, 
			    array("group_name"=>$name,
                                  "table_name"=>$table,
                                  "descript"=>$descript,
                                  "eval_type"=>$evalType,
                                  "eval_text"=>$evalText,
                                  "name_of_file"=>$name_of_file,
                                  'include_none'=>$include_none) );
  }

  /**
   * Update the detail values for a given group.  This deletes any existing entries and replaces them
   * with the values passed here
   *
   * @param integer $group_id the group to update
   * @param array $vals the new detail table values
   */
  function updateDataGroupDetails( $group_id, $vals ) { 
    $group_id = $this->checkNum($group_id);
    $this->db_delete($this->table_group_detail, "group_id", $group_id);
    return $this->_insertGroupDetails($group_id, $vals);
  }

  /**
   * Delete an existing data group and all associated details
   *
   * @param integer $group_id
   */
  function removeDataGroup( $group_id ) { 
    $group_id = $this->checkNum($group_id);
    $this->db_delete($this->table_group_detail, "group_id", $group_id);
    return $this->db_delete($this->table_group, "group_id", $group_id);
  }

  /**
   * Inserts group details into the database
   */
  function _insertGroupDetails( $group_id, $vals ) {
    $group_id = $this->checkNum($group_id);
    $c = 0;
    foreach($vals as $v) {
      // make sure we add in the group id to each row
      $v['group_id'] = $group_id;
      list($ck,$cv) = $this->makeInsertVals($v);
      $query = "INSERT INTO ".$this->table_group_detail." ($ck) VALUES($cv)";
      $this->addDebug("_insertGroupDetails", $query, 3);
      if( $this->db_result($query) ) { $c++; }
    }
    return $c;
  }


  /**
   * How many references to the given data group exist in the database
   *
   * @param integer $group_id The id of the group being queried
   * @return integer
   */
  function queryReferencesToDataGroup( $group_id ) {
    $qty=0;
    $query = "SELECT count(*) FROM ".$this->table_varfield_idx
           . " where field_value='$group_id'"
           . " and field_name like 'custom_menu%'";
    $qty = $this->db_get($query);
    $query = "SELECT count(*) FROM ".$this->table_behavior
           . " where group_id=$group_id";
    $qty += $this->db_get($query);
    return ( $qty );
  }

  /**
   * Disables all references of the given data group
   *
   * @param integer $group_id The id of the group being deleted
   */
  function disableReferencesToDataGroup( $group_id ) {
    $query = "UPDATE ".$this->table_varfield_idx
           . " set use_for_project=0, use_for_ticket=0, field_value=NULL"
           . " where field_value='$group_id'"
           . " and field_name like 'custom_menu%'";
    $res = $this->db_result($query);
    $this->addDebug('disableReferencesToDataGroup', 
        "Disable variable fields [$res]{$query}", $res? 3 : 1); 
    $query = "UPDATE ".$this->table_behavior
           . " set is_enabled=0, group_id=0"
           . " where group_id=$group_id";
    $res = $this->db_result($query);
    $this->addDebug('disableReferencesToDataGroup', 
      "Disable behaviors [$res]{$query}", $res? 3 : 1);
  }

  /**
   * Changes all references of the old data group to a new data group
   *
   * @param integer $old_group_id The id of the group being deleted
   * @param integer $new_data_group The id of the group that is replacing it
   */
  function moveReferencesToDataGroup( $old_group_id, $new_data_group ) {
    $query = "UPDATE ".$this->table_varfield_idx
           . " set field_value = '$new_data_group'"
           . " where field_value = '$old_group_id'"
           . " and field_name like 'custom_menu%'";
    $res = $this->db_result($query);
    $this->addDebug('moveReferencesToDataGroup', 
        "Move variable fields [$res]{$query}", $res? 3 : 1);     
    $query = "UPDATE ".$this->table_behavior
           . " set group_id = $new_data_group"
           . " where group_id = $old_group_id";
    $res = $this->db_result($query);
    $this->addDebug('moveReferencesToDataGroup', 
        "Move behaviors [$res]{$query}", $res? 3 : 1);     
  }




  /*
   *  SEARCH FUNCTIONS 
   */


  function search_logs( $params, $offset = 0, $archive_flag = 0 ) {
    // search through log entries for given text
    // params is an indexed array with two elements:
    //   $params[key][0] = LIKE, =, >, <, >=, etc..
    //   $params[key][1] = '%value', '%value%', lower('value'), etc
    // see db.class complexWhere() for more details concerning
    // the params array
    // this function requires the values to be provided with single
    // quotes and escape chars in place, they will not be added!
    // if archive_flag = 1, then searches ticket archives as well
    // if archive_flag = 2, then searches archives only

    //added for paging feature
    $pageNumber = array_key_exists('pageNumber', $_GET)? 
                $this->checkNum($_GET['pageNumber']) : 0;
    
    $columns = array(
                     "lid",     "ticket_id", 
                     "user_id",  "action",
                     "entry",   "bin_id", "created"
                     );

    $where = $this->build_search_clause($params, "AND");
    if( $archive_flag ) {
      $tables = ($archive_flag == 2)? 
        $this->table_logs_archived : 
        $this->table_logs_archived.", ".$this->table_logs;
    }
    else {
      $tables = $this->table_logs;
    }

    $query = "SELECT ".join(",",$columns)
      ." FROM $tables WHERE $where ORDER BY created DESC";
    $this->addDebug("search_logsQuery",$query,2);

    //paging feature
    $numtoshow = $this->getSetting('paging_max_rows');
    $start = $pageNumber * $numtoshow;
    $this->total_records = $this->db_getrowcount($tables, $where);
    return($this->db_getlimitedIndex($query,$numtoshow,$start));
    //    return(  $this->db_queryIndexed($query) );
  }

  function search_tickets( $params, $andor = 'AND', 
                           $archive_flag = 0, $order_by = 'status DESC, priority DESC',
                           $limit = false ) {
    // search through tickets for given text
    // acceptable params are:
    // params is an indexed array with two elements:
    //   $params[key][0] = LIKE, =, >, <, >=, etc..
    //   $params[key][1] = '%value', '%value%', lower('value'), etc
    // see db.class->build_search_clause() for details concerning
    // the params array
    // if archive_flag = 1, then searches ticket archives as well
    // if archive_flag = 2, then searches archives only

    //added for paging feature
    $pageNumber = array_key_exists('pageNumber', $_GET)? 
                $this->checkNum($_GET['pageNumber']) : 0;
    
    $where = $this->build_search_clause($params, $andor);
    
    if( $archive_flag ) {
      $tables = ($archive_flag == 2)? 
        $this->table_tickets_archived : 
        $this->table_tickets_archived.", ".$this->table_tickets;
    }
    else {
      $tables = $this->table_tickets;
    }

    $tbl = $this->table_tickets;
    $select = "$tbl.*";
    $tf_pri = preg_match("/priority/", $order_by);

    $tbl_var = $this->table_varfield;
    $tables .= ",{$tbl_var}";
    $select .= ", $tbl_var.*";
    $where = $where?
      "$tbl_var.ticket_id = $tbl.id AND ($where)"
      : "$tbl_var.ticket_id = $tbl.id";

    if( $tf_pri ) {
      $tblpri = $this->table_priorities;
      $tables .= ", ".$tblpri;
      $order_by = preg_replace("/priority/", "$tblpri.priority", $order_by);
      
      $where = ($where)? "$tbl.priority = $tblpri.pid AND ($where)": "$tbl.priority = $tblpri.pid";
    }

    $query = "SELECT $select "
      ." FROM $tables "
      ." WHERE $where"
      ." ORDER BY $order_by";
    $this->addDebug("search_ticketsQuery:",$query,3);
    // return(  $this->db_queryIndexed($query) );      
    //paging feature
    $numtoshow = $limit > 0? $limit : $this->getSetting('paging_max_rows');
    $start = $pageNumber * $numtoshow;
    $this->total_records = $this->db_getrowcount($tables, $where);
    if( $limit < 0 ) {
      return $this->db_queryIndexed($query);
    }
    else {
      return($this->db_getlimitedIndex($query,$numtoshow,$start));
    }
  }

  function _hasCustomFields($params) {
    foreach( $params as $key=>$val ) {
      if( $val[0] == 'AND' || $val[0] == 'OR' ) {
        if( $this->_hasCustomFields($val[1]) ) {
          return true;
        }
      }
      if( !(strpos($val[0], 'custom_') === false) ) {
        return true;
      }
    }
    return false;
  }

  function search_users( $params, $andor = "AND", $order_by = 'lname,fname' ) {
    // search for users and return a detailed list
    // of users who match the criteria given
    // see db.class->build_search_clause() for details about
    // constructing a $params array

    $table = $this->table_users;
    $where = $this->build_search_clause($params,$andor);
    $query = "SELECT * FROM $table WHERE $where"
      ." ORDER BY $order_by";
    $this->addDebug("search_users()Query",$query,2);
    return( $this->db_queryIndexed($query) );
  }


  /*
   *  PROJECT ADMINISTRATION 
   */


  function add_project( $params ) {
    // create a new project with the given params
    // (abstracted from add_ticket() to allow
    // for custom functionality)
    // all dates are to be sent as unix timestamps

    $params["type_id"] = $this->projectTypeID();
    unset($params["est_hours"]);
    unset($params["wkd_hours"]);
    return( $this->add_ticket($params) );
  }

  function delete_project( $pid, $archive_flag = 0 ) {
    // drop project, all associated tickets
    // all log entries of those tickets, and
    // all their data from the db
    // if $archive_flag = 1, then deletes from the
    // archive table
    $pid = $this->checkNum($pid);
    $children = $this->getProjectChildren($pid, array('id'), $archive_flag);
    for($i=0; $i<count($children); $i++) {
      $ids[] = $children["id"];
    }
    //drop the tickets under this project      
    $this->delete_ticket($ids, $archive_flag); 
    $this->delete_log($pid, NULL, $archive_flag);
    $table = ($archive_flag)? $this->table_tickets_archived : $this->table_tickets;
    $query = "DELETE FROM $table WHERE id = $pid";
    $this->_session->clearDataCache('tickets',$id);
    return( $this->db_result($query) );
  }

  function close_project( $pid, $params = '', $override = 0 ) {
    // sets the status of a project to 'CLOSED' assuming
    // that the project doesn't require testing and approval
    // and that all children are closed (otherwise will skip)
    // if $override is passed, then this method will
    // close a project, even if testing or approval are
    // required, or there are open children.
    // $params is an array passed on to the log function
    //   (user_id, comments)
    $pid = $this->checkNum($pid);
    if( $override || $this->check_status($pid, 'READY') ) {
      $children = $this->getProjectChildren($pid, array('id'));
      for( $i=0; $i<count($children); $i++ ) {
        $this->close_ticket($children[$i]);    
      }
      $this->_session->clearDataCache('tickets',$id);
      return( $this->change_status($pid, 'CLOSED', $params) );    
    }
    return false;
  }


  /*
   *  TICKET ACTIONS 
   */


  function accept_ticket( $id, $user_id, $comments = '', $bin_id = '' ) {
    // changes the tickets user_id to reflect
    // a new owner for the ticket
    // logs this in the db if settings["log_accept"] = "On";
    // the bin_id is used for logging, if it is available, this just
    // saves a db query
    $id = $this->checkNum($id);
    if( $bin_id ) { $bin_id = $this->checkNum($bin_id); }
    $user_id = $this->checkNum($user_id);

    // if we passed the ticket
    // rather than the id then use it
    if( is_array($id) ) {
      $ticket = $id;
      $id = $ticket["id"];
    }

    $params = array( "user_id" => $user_id );
    $res = $this->update_ticket($id,$params);
    if( $res && $this->settingOn("log_accept") ) {
      $logParams = array(
                         "action"   =>  'ACCEPTED',
                         "user_id"   =>  $user_id,
                         "ticket_id" =>  $id
                         );
      if( !$bin_id ) {
        if( !is_array($ticket) ) {
          $ticket = $this->get_ticket($ticket);
        }
        $bin_id = $t["bin_id"];
      }
      $logParams["bin_id"] = $bin_id;
      if( $comments )
        $logParams["entry"] = $this->ffv($comments);   
      $res = $this->add_log($id, $logParams);
    }
    if( $res && $this->settingOn("email_accept") ) {
      $recipients = $this->get_notify_recipients($id);
      if( is_array($recipients) && count($recipients) ) {
        $subject = $this->ptrans("ticket #?: accepted by ?",array($id,$this->formatName($user_id)));
        $emailParams["Accepted by"] = $this->formatName($user_id);
        if( $comments )
          $emailParams["body"] = $this->ffv($comments);
        $emailParams["tid"] = $id;
        $message = $this->formatEmailMessage($emailParams);
        $this->sendEmail($recipients,$subject,$message,$user_id);
      }
    }
    return( $res );
  }

  function approve_ticket( $id, $user_id, $comments = '' ) {
    // changes the approval status to 2 for the ticket
    // if the ticket is ready for closure, then this function
    // will also close out the ticket
    $id = $this->checkNum($id);
    $user_id = $this->checkNum($user_id);

    // if we have the ticket array, use this instead
    if( is_array($id) ) {
      $t = $id;
      $id = $t["id"];
    }
    else {
      $t = $this->get_ticket($id);
    }
    $params = array("approved"=>2);
    $res = $this->update_ticket($id,$params);
    if( $res && $this->settingOn("log_approve") ) {
      $logParams = array(
                         "action"   =>  'APPROVED',
                         "user_id"   =>  $user_id,
                         "ticket_id" =>  $id
                         );
      $logParams["bin_id"] = $t["bin_id"];
      if( $comments )
        $logParams["entry"] = $this->ffv($comments);
      $this->add_log($id, $logParams);    
    }     
    if( $t["tested"] != 1 ) {
      $res = $this->close_ticket($id);
    }
    else if( $this->settingOn("email_pending") ) {
      $recipients = $this->get_notify_recipients($id);
      // make sure testers get notification      
      $vals = $this->fetch_bin_role_emails($t['bin_id'], $this->getRoleId("tester"));
      $this->checkIncludedRecipients($recipients,$vals);
      // create email
      if( is_array($recipients) && count($recipients) ) {
        $bin = $t["bin_id"];
        $subject = $this->ptrans("Ticket #?: closed",array($id));
        $emailParams["Close Time"] = $this->showDateTime($this->currTime);
        if( $comments )
          $emailParams["body"] = $this->ffv($comments);
        $emailParams["tid"] = $t;
        $message = $this->formatEmailMessage($emailParams);
        $this->sendEmail($recipients,$subject,$message,$user_id);
      }
    }
    return( $res );
  }

  function assign_ticket( $id, $recipient, $user_id = 0, $comments = '' ) {
    // set the user_id for the ticket to another person
    // the recipient recieves the ticket, the user_id is for the 
    // sender
    $id = $this->checkNum($id);
    $recipient = $this->checkNum($recipient);
    if( $user_id ) { $user_id = $this->checkNum($user_id); }

    $params = array( "user_id" => $recipient );
    if( is_array($id) ) {
      $ticket = $id;
      $id = $ticket["id"];
    }
    else {
      $ticket = $this->get_ticket($id);
    }
    $res = $this->update_ticket($ticket, $params);
    if( $res ) {
      // move the ticket somewhere that the user
      // will be able to access it, if required
      $userBins = $this->getUsersBins($recipient,"level_user");
      if( is_array($userBins)&&!in_array($ticket["bin_id"],$userBins) ) {
        $user = $this->get_user($recipient);
        if( $user["homebin"] ) {
          $this->update_ticket($id,array("bin_id"=>$user["homebin"]));
        }
        else {
          $this->update_ticket($id,array("bin_id"=>$userBins[0]));
        }
      }
    }
    $name = $this->formatName($recipient,1);
    if( $res && $this->settingOn("log_assign") ) {
      $logParams = array(
                         "action"   =>  'ASSIGNED',
                         "user_id"   =>  $user_id
                         );
      $logParams["bin_id"] = $ticket["bin_id"];
      $logParams["entry"] = "Assigned to $name";
      if( $comments )
        $logParams["entry"] .= "\n\n".$comments;
      $this->add_log($id, $logParams);                
    }
    if( $res && $this->settingOn("email_assign") ) {
      $user = $this->get_user($recipient);
      $recipients = $this->get_notify_recipients($id);
      // make sure the assignee gets a notification
      $this->checkIncludedRecipients($recipients,$user["email"]);
      // create email
      if( is_array($recipients) && count($recipients) ) {
//        if( !$name )
//          $name = $this->formatName($recipient,1);
        $subject = $this->ptrans("Ticket #?: assigned to ?",array($id,$name));
        $emailParams["Assigned by"] = $this->formatName($user_id);
        $emailParams["Assigned to"] = $name;
        if( $comments )
          $emailParams["body"] = $this->ffv($comments);
        $emailParams["tid"] = $id;
        $message = $this->formatEmailMessage($emailParams);
        $this->sendEmail($recipients,$subject,$message,$user_id);
      }
    }
    return( $res );
  }   

  function attach_to_ticket( $id, $user_id, $params, $log_id = 0 ) {
    // creates an attachment to the given ticket and logs
    // the event if needed
    // the params array contains:
    //     name         - name of the file to display
    //     filename     - name of file on system
    //     filetype     - mime type (i.e. image/gif)
    //     description  - [optional] comments about the file for display
    extract($params);
    $id = $this->checkNum($id);
    $user_id = $this->checkNum($user_id);
    $res = $this->add_attachment($name, $filename, $filetype, $id, 
                                 $log_id, $description);
    if( $res && $this->settingOn("log_attachment") ) {
      $logParams = array(
                         "user_id"   => $user_id,
                         "action"   => "ATTACHMENT"
                         );
      $logParams["entry"] = "$name--$filetype";
      if( $description )
        $logParams["entry"] .= "--".$description;   
      if( $log_id )
        $logParams["entry"] .= "\nattached to log $log_id";
      if( !$this->add_log( $id, $logParams ) ) {
        $this->addDebug('attach_to_ticket', "couldn't log attachment!", 1);
      }
    }
    return $res;
  }

/*
  function close_ticket( $id, $user_id = '', $hours = '', $comments = '' ) {
    // closes the ticket (sets the status to CLOSED)
    // if there is testing or approval yet required, then
    // simply sets status to pending.
    // however, if both of these are completed, then 
    // closes out the ticket
    $id = $this->checkNum($id);
    if( $user_id ) { $user_id = $this->checkNum($user_id); }
    
    // get ticket info
    if( is_array($id) ) {
      $t = $id;
      $id = $t["id"];
    }
    else {
      $t = $this->get_ticket($id);
    }
    if( $this->check_status($t,"READY") ) {
      // if ticket is ready to close, then close it
      $params = array(
		      "status"  =>  'CLOSED',
		      "ctime"   =>  $this->currTime
		      );
      if( strlen($user_id) ) {
	     $params["user_id"] = $user_id;
      }
      $res = $this->update_ticket($id, $params);
      if( $this->settingOn("log_close") ) {
	// create a log entry
	$logParams = array(
			   "action"   =>  'CLOSED',
			   "ticket_id" =>  $id 
			   );
	// get the params
	if( $user_id ) {
	  $logParams["user_id"] = $user_id;
	}
	$logParams["bin_id"] = $t["bin_id"];
	if( $hours )
	  $logParams["hours"] = $hours;
	if( $comments )
	  $logParams["entry"] = $comments;
	// send the log
	$this->add_log($id, $logParams);    
      }
      if( $this->settingOn("email_closed") ) {
	     // send email
	     $recipients = $this->get_notify_recipients($id);
        // make sure the manager gets a notification
        $vals = $this->fetch_bin_role_emails($t['bin_id'],$this->getRoleId('manager'));
        $this->checkIncludedRecipients($recipients,$vals);
        // create email
	     if( is_array($recipients) && count($recipients) ) {
	       $bin = $t["bin_id"];
	       $subject = $this->ptrans("Ticket #?: closed",array($id));
	       $emailParams["Close Time"] = $this->showDateTime($this->currTime);
	       if( $comments )
	         $emailParams["body"] = $comments;
	       $emailParams["tid"] = $t;
	       $message = $this->formatEmailMessage($emailParams);
	       $this->sendEmail($recipients,$subject,$message,$user_id);       
	     }
      } 
    } else if( ($t["tested"] == 1 || $t["approved"] == 1) 
	       && $t["status"] == "OPEN" ) {
      // update status to pending
      $params = array(
		      "status"  =>  'PENDING',
		      "user_id"  =>  'NULL'
		      );
      $res = $this->update_ticket($id, $params);
      if( $this->settingOn("log_pending") ) {
	     // make a log entry
	     $logParams = array(
			   "action"   =>  'PENDING',
			   "ticket_id" =>  $id,
			   "entry"    =>  $entry
			   );
	     if( $user_id ) {
	       $logParams["user_id"] = $user_id;
	     }
	     $logParams["bin_id"] = $t["bin_id"];      
	     if( $hours )
	       $logParams["hours"] = $hours;
	     if( $comments )
	       $logParams["entry"] = $comments;
	     $this->add_log($id, $logParams);    
      }  
      if( $this->settingOn("email_pending") ) {
  	     // send an email
	     $recipients = $this->get_notify_recipients($id);
        // make sure the testers/managers gets a notification
        if( $t['tested'] == 1 ) {
          $vals = $this->fetch_bin_role_emails($t['bin_id'], $this->getRoleId('tester'));
        }
        if( $t['tested'] != 1 || !is_array($vals) ) {
          $vals = $this->fetch_bin_role_emails($t['bin_id'], $this->getRoleId('manager'));
        }        
        $this->checkIncludedRecipients($recipients, $vals);
        // create email
	     if( is_array($recipients) && count($recipients) ) {
	       $bin = $t["bin_id"];
	       $subject = $this->ptrans("Ticket #?: closed",array($id));
	       $emailParams["Close Time"] = $this->showDateTime($this->currTime);
	       if( $comments )
	         $emailParams["body"] = $this->ffv($comments);
	       $emailParams["tid"] = $id;
	       $message = $this->formatEmailMessage($emailParams);
	       $this->sendEmail($recipients,$subject,$message,$user_id);
	     } 
      } 
    }
    return($res);
  }
*/


    /**
     * closes the ticket (sets the status to CLOSED)
     * if there is testing or approval yet required, then
     * simply sets status to pending.
     * however, if both of these are completed, then
     * closes out the ticket
     *
     * @param int $id Ticket's ID (can also be the an array with the whole information of the ticket (indexed by field names)
     * @param int $user_id ID of the user who is closing the ticket
     * @param float $hours Amount of time to be added to the ticket's worked hours
     * @param string $comments Comments to add in the tickets log.
     **/
  function close_ticket( $id, $user_id = 0, $hours = '', $comments = '' ) {
    $id = $this->checkNum($id);
    if( $user_id ) { $user_id = $this->checkNum($user_id); }

    // get ticket info
    if( is_array($id) ) {
      $t = $id;
      $id = $t["id"];
    }
    else {
      $t = $this->get_ticket($id);
    }
    if( $this->check_status($t,"READY") ) {
      // if ticket is ready to close, then close it
      $params = array(
            "status"  =>  'CLOSED'
            );
      if( ! $t["ctime"] ) {
        $params["ctime"]=$this->currTime;
      }
      if( !$this->settingOn("retain_owner_closed") ) {
        $params["user_id"] = NULL;
      }
      $res = $this->update_ticket($id, $params);
      if( $this->settingOn("log_close") ) {
        // create a log entry
        $logParams = array(
            "action"   =>  'CLOSED',
            "ticket_id" =>  $id
            );
        // get the params
        if( $user_id ) {
          $logParams["user_id"] = $user_id;
        }
        $logParams["bin_id"] = $t["bin_id"];
        if( $hours )
          $logParams["hours"] = $hours;
        if( $comments )
          $logParams["entry"] = $comments;
        // send the log
        $this->add_log($id, $logParams);
      }
      if( $this->settingOn("email_closed") ) {
        // send email
        $recipients = $this->get_notify_recipients($id);
        // make sure the manager gets a notification
        $vals = $this->fetch_bin_role_emails($t['bin_id'],$this->getRoleId('manager'));
        $this->checkIncludedRecipients($recipients,$vals);
        // create email
        if( is_array($recipients) && count($recipients) ) {
          $bin = $t["bin_id"];
          $subject = $this->ptrans("Ticket #?: closed",array($id));
          $emailParams["Close Time"] = $this->showDateTime($this->currTime);
          if( $comments )
            $emailParams["body"] = $comments;
          $emailParams["tid"] = $t;
          $message = $this->formatEmailMessage($emailParams);
          $this->sendEmail($recipients,$subject,$message,$user_id);
        }
      }
    } else if( ($t["tested"] == 1 || $t["approved"] == 1)
              && $t["status"] == "OPEN" ) {
      // update status to pending
      $params["status"]='PENDING';
      if( !$this->settingOn("retain_owner_pending") ) {
        $params["user_id"] = NULL;
      }
      if( !$t["ctime"]  && $this->settingOn("ctime_on_pending") ) {
        $params["ctime"]=$this->currTime;
      }
      $res = $this->update_ticket($id, $params);
      if( $this->settingOn("log_pending") ) {
        // make a log entry
        $logParams = array(
             "action"   =>  'PENDING',
             "ticket_id" =>  $id,
             "entry"    =>  $entry
             );
        if( $user_id ) {
          $logParams["user_id"] = $user_id;
        }
        $logParams["bin_id"] = $t["bin_id"];
        if( $hours )
          $logParams["hours"] = $hours;
        if( $comments )
          $logParams["entry"] = $comments;
        $this->add_log($id, $logParams);
      }
      if( $this->settingOn("email_pending") ) {
        // send an email
        $recipients = $this->get_notify_recipients($id);
        // make sure the testers/managers gets a notification
        if( $t['tested'] == 1 ) {
          $vals = $this->fetch_bin_role_emails($t['bin_id'], $this->getRoleId('tester'));
        }
        if( $t['tested'] != 1 || !is_array($vals) ) {
          $vals = $this->fetch_bin_role_emails($t['bin_id'], $this->getRoleId('manager'));
        }
        $this->checkIncludedRecipients($recipients, $vals);
        // create email
        if( is_array($recipients) && count($recipients) ) {
          $bin = $t["bin_id"];
          $subject = $this->ptrans("Ticket #?: closed",array($id));
          $emailParams["Close Time"] = $this->showDateTime($this->currTime);
          if( $comments )
            $emailParams["body"] = $this->ffv($comments);
          $emailParams["tid"] = $id;
          $message = $this->formatEmailMessage($emailParams);
          $this->sendEmail($recipients,$subject,$message,$user_id);
        }
      }
    }
    return($res);
  }


  
  function log_ticket( $id, $user_id, $action = 'LOG', $hours = '', $comments = '' ) {
    // create an entry in the ticket log to track hours
    // or work done

    $id = $this->checkNum($id);
    $user_id = $this->checkNum($user_id);

    $logParams["user_id"] = $user_id;
    if( $action )
      $logParams["action"] = $action;
    if( $hours )
      $logParams["hours"] = $hours;
    if( $comments )
      $logParams["entry"] = $comments;
    $res = $this->add_log($id, $logParams);
    if( $res && $this->settingOn("email_log") ) {
      $recipients = $this->get_notify_recipients($id);
      if( is_array($recipients) && count($recipients) ) {
        $eParams = array(
                         "Sent" => $this->showDateTime(),
                         "By"   => $this->formatName($user_id)
                         );
        if( $hours )
          $eParams["hours"] = $hours;
        if( $comments )
          $eParams["body"] = $comments;  
        $eParams["tid"] = $id;
        $message = $this->formatEmailMessage($eParams);
        $subject = $this->ptrans("Ticket #?: Log added by ?", array($id,$this->formatName($user_id,2)));
        $this->sendEmail($recipients,$subject,$message,$user_id);
      }
    }
    return $res;
  }

  function move_ticket( $id, $newBin, $user_id = 0, $comments = '' ) {
    // moves the ticket to a new bin location
    // if comments field is set to 'skip_log' then
    // no log will be generated (assumed to have 
    // been done before calling this)
    $id = $this->checkNum($id);
    $newBin = $this->checkNum($newBin);
    if( $user_id ) { $user_id = $this->checkNum($user_id); }

    $t = $this->get_ticket($id);      
    $params["bin_id"] = $newBin;
    if( !$this->settingOn("retain_owner_move") ) {
      $params["user_id"] = NULL;
    } else {
      $currentOwner=$this->checkNum($t['user_id']);
      if ( ! $this->checkAccess($currentOwner,$newBin,'level_user') ) {
        $params["user_id"] = NULL;
      }
    }
    $res = $this->update_ticket($id, $params);
    if( $res && $this->settingOn("log_move") ) {
      $logParams["action"] = "MOVED";
      $logParams["bin_id"] = $t["bin_id"];
      $logParams["entry"] = "MOVED TO ".$this->bins["$newBin"];
      $logParams["ticket_id"] = $id;
      if( $user_id )
        $logParams["user_id"] = $user_id;
      if( $comments )
        $logParams["entry"] .= "\n\n".$comments;
      $this->add_log($id,$logParams);
    }
    if( $res && $this->settingOn("email_arrival") ) {
      $recipients = $this->get_notify_recipients($id);
      // make sure the manager gets a notification
      $vals = $this->fetch_bin_role_emails($t['bin_id'], $this->getRoleId('manager'));
      $this->checkIncludedRecipients($recipients,$vals);
      // create email
      if( is_array($recipients) && count($recipients) ) {
        $eParams = array(
                         "From" => $this->bins["$t[bin_id]"], 
                         "Sent" => $this->showDateTime(),
                         "By"   => $this->formatName($user_id)
                         );
        if( $comments )
          $eParams["body"] = $comments;
        $eParams["tid"] = $t;
        $message = $this->formatEmailMessage($eParams);
        $subject = $this->ptrans("Ticket #?: moved to ?",array($id,$this->getBinName($newBin)));
        $this->sendEmail($recipients,$subject,$message,$user_id);
      }
    }
    return($res);
  }

  function reject_ticket( $id, $user_id, $comments = '' ) {
    $id = $this->checkNum($id);
    $user_id = $this->checkNum($user_id);
    $sender = $this->getTicketSender($id);
    $sender_id = ($sender && array_key_exists('user_id',$sender))? $sender['user_id'] : false;
    $t = $this->get_ticket($id);
    if( $sender && array_key_exists('bin_id',$sender) ) {
      $res = $this->move_ticket( $id, $sender["bin_id"] );
    }
    if( $sender_id ) {
      $res = $this->assign_ticket($id, $sender_id);
    }
    if( $res && $this->settingOn("log_reject") ) {
      $logParams["action"] = "REJECTED";
      $logParams["bin_id"] = $t["bin_id"];
      $logParams["user_id"] = $user_id;
      $logParams["ticket_id"] = $t["id"];
      if( $comments || $sender_id ) {
        $logParams['entry'] = '';
        if( $sender_id ) {
          $logParams['entry'] .= tr("Returned to ?", array($this->formatName($sender_id)));
          if( $comments ) { $logParams['entry'] .= "\n"; }
        }
        if( $comments ) {
          $logParams["entry"] .= $comments;
        }
      }
      $this->add_log($id,$logParams);
    }
    if( $res && $this->settingOn("email_reject") ) {
      $recipients = $this->get_notify_recipients($id);
      // make sure the sender gets an email
      if( is_array($sender) && isset($sender["user_id"]) ) {
        $user = $this->get_user($sender["user_id"]);
        $this->checkIncludedRecipients($recipients,$user['email']);
      }
      if( is_array($recipients) && count($recipients) ) { 
        // add the sender if not on notify list
        if( $sender && $sender["user_id"] ) {
          $usr = $this->get_user($sender["user_id"]);
          $dup = false;
          foreach($recipients as $r) {
            if( $usr["email"] = $r ) {
              $dup = true;
              break;
            }
          }
          if( !$dup ) {
            $recipients[] = $usr["email"];
          }
        }
        $subject = $this->ptrans("Ticket #?: rejected",array($id));
        $eParams = array(
        "From" => $this->bins["$t[bin_id]"], 
        "Time" => $this->showDateTime(),
        "By"   => $this->formatName($user_id)           
        );
        if( $comments )
        $eParams["body"] = $comments;
        $eParams["tid"] = $id;  
        $message = $this->formatEmailMessage($eParams);
        $this->sendEmail($recipients,$subject,$message,$user_id);
      }
    } 
    $this->_session->clearDataCache('tickets',$id);
    return($res);
  }

  function relate_ticket( $id, $relations, $user_id = 0, $comments = '' ) {
    // takes either a comma delimited string
    // or an array of ticket ids
    // checks to insure they exist before performing
    // relations
    // 
    // THIS FUNCTION IS VERY INEFFICIENT AND NEEDS TO BE REVISED
    // IT'S A HORRIBLE HACK FIX NOW, AND PROBABLY REQUIRES
    // THE CREATION OF A NEW DB TABLE AND SOME EDITS
    // TO THIS FUNCTION (possibly the addition of an addRelation()
    // and dropRelation() method to encompass non-global updates)
    $id = $this->checkNum($id);
    if( $user_id ) { $user_id = $this->checkNum($user_id); }

    $t = $this->get_ticket($id);      
    if( !is_array($relations) ) {
      $relations = trim($relations);
      $relations = split(" *, *", $relations);
    }
    $relations = $this->checkRelations($relations,$id);

    $rel = (is_array($relations))? join(",",$relations) : "";
    $res = $this->update_ticket($id, array("relations"=>$rel));
    if( is_array($relations) ) {      
      //
      // 
      // 
      // 
      // need to add some methodology here to update the tickets
      // which this one is related to to reflect that relation as
      // well, and to remove relations from tickets which used to
      // be related to this one which aren't anymore
      // 
      // see the comments at the top of this method for more gripes
      // about this bug
      // 
      // 
      // 
    }

    if( $res && $this->settingOn("log_relate") && $user_id ) {
      $logParams["action"] = "RELATED";
      $logParams["bin_id"] = $t["bin_id"];
      $logParams["user_id"] = $user_id;
      $logParams["ticket_id"] = $t["ticket_id"];
      $logParams["entry"] = join(",",$relations);
      if( $comments )
        $logParams["entry"] .= "\n\n".$comments;
      $this->add_log($id,$logParams);
    }
    return( $res );
  }

  function reopen_ticket( $id, $user_id = 0, $comments = '' ) {
    // opens a ticket that has been closed
    // this can be used to reopen tickets
    // closed in error, or to make modifications
    // to a closed ticket
    $id = $this->checkNum($id);
    if( $user_id && $user_id != 'NULL' ) {
      $user_id = $this->checkNum($user_id);
    }

    $t = $this->get_ticket($id);      
    $params = array(
                    "ctime"    =>   'NULL',
                    "user_id"   =>   $user_id,
                    "status"   =>   'OPEN',
                    "bin_id"    =>   $t["bin_id"],
                    "tested"   =>   ($t["tested"]>0)? 1 : 0,
                    "approved" =>   ($t["approved"]>0)? 1 : 0
                    );
    $res = $this->update_ticket($id, $params);
    if( $res ) {
      $logParams["action"] = "REOPENED";
      $logParams["bin_id"] = $t["bin_id"];
      $logParams["user_id"] = $user_id;
      $logParams["ticket_id"] = $t["ticket_id"];   
      $logParams["entry"] = "Ticket #$id: opened in ".$this->bins["$bin_id"];
      if( $comments )
      $logParams["entry"] .= "\n\n".$comments;
      $this->add_log($id,$logParams);
    }
    if( $res && ($this->settingOn("email_created") 
          || $this->settingOn("email_arrival") )  ) {
      $recipients = $this->get_notify_recipients($id);
      if( $t['user_id'] ) {
        $user = $this->get_user($t["user_id"]);
        if( is_array($user) && $user["email"] ) {
          $this->checkIncludedRecipients($recipients,$user['email']);
        }
      }
      if( is_array($recipients) && count($recipients) ) {
        $subject = $this->ptrans("Ticket #?: reopened",array($id));
        $eParams = array(
                        "message" => $this->ptrans("Ticket ? has been reopened.",array($id)) . '',
                        "From"    => $this->bins["$t[bin_id]"], 
                        "Time"    => $this->showDateTime(),
                        "By"      => $this->formatName($user_id)        
                        );
        if( $comments )
        $eParams["body"] = $comments;
        $eParams["tid"] = $id;
        $message = $this->formatEmailMessage($eParams);
        $this->sendEmail($recipients,$subject,$message,$user_id);
      }
    }
    return( $res );
  }

  function test_ticket( $id, $user_id, $hours = '', $comments = '' ) {
    // updates the testing parameter to reflect
    // a status of 'testing completed' for the ticket
    $id = $this->checkNum($id);
    $user_id = $this->checkNum($user_id);

    $t = $this->get_ticket($id);
    $res = $this->update_ticket($id, array("tested"=>2));
    if( $res && $this->settingOn("log_test") ) {
      $logParams["action"] = "TESTED";
      $logParams["bin_id"] = $t["bin_id"];
      $logParams["user_id"] = $user_id;
      $logParams["ticket_id"] = $t["ticket_id"];   
      if( $comments )
        $logParams["entry"] = $comments;
      $this->add_log($id,$logParams);  
    }
    if( $t["approved"] != 1 ) {
      // go ahead and close the ticket
      // since it doesn't need to be
      // approved       
      $this->close_ticket($id);
    }         
    else if( $this->settingOn("email_pending") ) {
      $bin = $t["bin_id"];
      $recipients = $this->get_notify_recipients($id);
      // make sure the testers/managers gets a notification
      $vals = $this->fetch_bin_role_emails($t['bin_id'], $this->getRoleId('manager'));
      $this->checkIncludedRecipients($recipients,$vals);
      // create email
      if( is_array($recipients) ) {
        $subject = $this->ptrans("Ticket #?: closed",array($id));
        $emailParams["Close Time"] = $this->showDateTime($this->currTime);
        if( $comments )
          $emailParams["body"] = $this->ffv($comments);
        $emailParams["tid"] = $id;
        $message = $this->formatEmailMessage($emailParams);
        $this->sendEmail($recipients,$subject,$message,$user_id);
      }       
    }
    return( $res );
  }

  function yank_ticket( $id, $user_id, $comments = '' ) {
    // takes a ticket from it's current location and status 
    // (whatever those might be) and 
    // assigns it to the user specified
    $id = $this->checkNum($id);
    $user_id = $this->checkNum($user_id);

    $t = $this->get_ticket($id);
    $bin_id = $t["bin_id"];
    if( is_array($t) ) {
      if( $this->settingOn("log_yank") ) {
        $lParams = array(
                         "action"   =>   "YANKED",
                         "user_id"   =>   $user_id,
                         "bin_id"    =>   $bin_id
                         );
        if( $comments )
          $lParams["entry"] = $comments;
        $this->add_log($id,$lParams);
      }
      if( $this->settingOn("email_assign") ) {
        $recipients = $this->get_notify_recipients($id);
	if( $t["user_id"] ) {
	  $user = $this->get_user($t["user_id"]);
	  if( $user['email'] ) {
	    $this->checkIncludedRecipients($recipients,$user['email']);
	  }
	}
        $name = $this->formatName($user_id);
        if( is_array($recipients) && count($recipients) ) {
          $subject = $this->ptrans("Ticket #?: yanked by ?",array($id,$name));
          $emailParams["Assigned To"] = $name;
          $emailParams["body"] = $subject;
          $emailParams["tid"] = $id;
          $message = $this->formatEmailMessage($emailParams);
          $this->sendEmail($recipients,$subject,$message,$user_id);
        }
      }
      if( $t["status"] == 'CLOSED' ) {
        $tested = ($t["tested"] == 2)? 1:0;
        $approved = ($t["approved"] == 2)? 1:0;
        $this->reopen_ticket($id, 0, $tested, $approved, $comments);
      }
      $this->assign_ticket($id,$user_id);
      return( 1 );
      $this->_session->clearDataCache('tickets',$id);
    }
  }

  /*
   *  TICKETS ADMINISTRATION
   */

  /*
   * create a new ticket
   *
   * @param integer $id returns the created ticket ID
   * @param array $params (only for standard fields) mapped field_name -> value
   * @param array $varfield_params (only for custom fields) mapped field_name -> value
   * @param string $action The action name to be logged (default EDIT)
   * @param string $log_init is extra notes to add at the beginning of the create log
   * @return integer returns the new ticket's id, if creation succeeded
   */
  function add_new_ticket(&$id, $params, $varfield_params, $action="CREATE", $log_init="") {
    $login_id=$params["creator_id"];
    $bin_id=$params["bin_id"];
    $this->log_buffer=$log_init."\n\n";
    $errs = array();
    // create the ticket
    $id = $this->add_ticket( $params, "", 1 );

    // check for errors
    if( !$id ) {
      $errs[] = tr("System Error").": ".tr("Ticket could not be created.")." ".$zen->db_error;
    }
    else if( count($varfield_params) ) {
      $res = $this->updateVarfieldVals($id, $varfield_params, $login_id, $bin_id, 1);
      if( !$res ) {
        $errs[] = tr("? created, but variable fields could not be saved", array(tr($x)));
        $this->log_buffer.=tr("Variable fields could not be saved");
        $this->add_log( $id, array('user_id'   => $login_id,
                                   'action'    => $action,
                                   'entry'     => $this->log_buffer,
                                   'bin_id'    => $bin_id) );
      }
    }
    if(!$errs) {
      $this->add_log( $id, array('user_id'   => $login_id,
                                 'action'    => $action,
                                 'entry'     => $this->log_buffer,
                                 'bin_id'    => $bin_id) );
    }
    return $errs;
  }


  /*
   * create a new ticket (does not handle varfields, so it should not be called directly, but via add_new_ticket)
   *
   * @param array $params is an indexed array("database_column"=>value), the values will be quoted and checked
   * @param string $log_notes is extra notes to add to create log
   * @param integer $mode if not null, don't log but use log_buffer
   * @return integer returns the new ticket's id, if creation succeeded
   */
  function add_ticket( $params, $log_notes = '', $mode=null ) {
    // Do otime rounding here to avoid confusion in the logs when the edit roundes to date_fmt_time:
    $params['otime']=$this->dateParse($this->showDateTime($params['otime']));
    // perform the ticket insert
    $id = $this->db_insert($this->table_tickets,$params);
    if( $id ) {
      // create an entry in the varfield table
      $query = "INSERT INTO ".$this->table_varfield." (ticket_id) VALUES($id)";
      if( !$this->db_result($query) ) {
        $this->addDebug('add_ticket', 'varfield query failed: $query', 1);
      }

      // create the notify list for this ticket
      $notify_list = array();

      // the bin owners
      if( $this->settingOn("default_notify_owner") ) {
        $vars = $this->fetch_bin_roles($params["bin_id"],"manager");
        if( is_array($vars) && count($vars) ) {
          foreach($vars as $v) {
            $notify_list[]["user_id"] = $v["user_id"];
          }
        }
      }

      // the bin testers
      if( $this->settingOn("default_notify_tester") ) {
        $vars = $this->fetch_bin_roles($params["bin_id"],"tester");
        if( is_array($vars) && count($vars) ) {
          foreach($vars as $v) {
            $notify_list[]["user_id"] = $v["user_id"];
          }
        }
      }
      // the ticket creator
      if( $this->settingOn("default_notify_creator") ) {
        $notify_list[]["user_id"] = $params["creator_id"];
      }
      // the ticket owner
      if( $this->settingOn("default_notify_owner") && $params["user_id"] ) {
        $notify_list[]["user_id"] = $params["user_id"];
      }
      // create the list
      $this->set_notify_list($id,$notify_list);

      // create a log entry
      $lParams = array(
                       "action"   =>   "CREATED",
                       "user_id"   =>   $params["creator_id"],
                       "bin_id"    =>   $params["bin_id"]
                       );
      if( $log_notes || $params['user_id'] ) {
        $lParams['entry'] = '';
        if( $params['user_id'] ) {
          $lParams['entry'] = tr("Assigned to [?-?]",array($params["user_id"],$this->formatName($params["user_id"])));
          if( $log_notes ) { $lParams['entry'] .= "\n"; }
        }
        if( $log_notes ) {
          $lParams["entry"] .= $log_notes;
        }
      }
      if ( $mode ) {
        $this->log_buffer.=$lParams["entry"];
      } else {
        $this->add_log($id,$lParams);
      }
      if( $this->settingOn("email_created") ) {
        // send email
        $bin = $t["bin_id"];
        // set the recipient list
        $recipients = $this->get_notify_recipients($id);
        if( $params["user_id"] ) {
          $user = $this->get_user($params["user_id"]);
          if( $user["email"] ) {
            $this->checkIncludedRecipients($recipients,$params['user_id']);
          }
        }
        if( is_array($recipients) && count($recipients) ) {
          $recipient = array_unique($recipients);
          $subject = $this->ptrans("Ticket #?: created",array($id));
          $emailParams["Open Time"] = $this->showDateTime($this->currTime);
          if( $comments )
            $emailParams["body"] = $this->ffv($comments);
          $emailParams["tid"] = $id;
          $message = $this->formatEmailMessage($emailParams);
          $this->sendEmail($recipients,$subject,
                           $message,$params["creator_id"]);
        }
      }
    }
    return $id;
  }

   
  function delete_ticket( $id, $archive_flag = 0 ) {
    // drop a ticket, its log entries, and 
    // all associated data from the db
    // $id can be an array
    $this->delete_log($id, $archive_flag);
    $table = ($flag)? 
      $this->table_tickets_archived : $this->table_tickets;
    if( is_array($id) ) {
      $where = ' id IN(';
      for($i=0; $i<count($id); $i++) {
        if( $i > 0 ) { $where .= ','; }
        $where .= $this->checkNum($id[$i]);
      }
      $where .= ')';
    }
    else {
      $where = " id = ".$this->checkNum($id);
    }
    $query = "DELETE FROM $table WHERE $where";
    $this->addDebug("delete_ticket",$query,2);
    $this->_session->clearDataCache('tickets',$id);
    return( $this->db_result($query) );
  }

  /**
   * updates the properties of a ticket
   *
   * @param integer $id is the id of the ticket
   * @param array $params is an indexed array "column_name"=>value. These values will be quoted and formatted for sql use
   * @return integer result value
   */
  function update_ticket( $id, $params ) {
    if( is_array($id) ) {
      $t = $id;
      $id = $t["id"];
    }
    else {
      $t = $this->get_ticket($id);
    }
    $id = $this->checkNum($id);
    $this->_session->clearDataCache('tickets',$id);
    foreach($params as $k=>$v) {
      if( !strlen($v) ) {
        switch($k) {
        case "otime":
        case "tested":
        case "approved":
        case "priority":
          $params["$k"] = 0;
          break;
        case "est_hours":
        case "wkd_hours":
          $params["$k"] = 0.00;
          break;
        case "status":
          $params["$k"] = "OPEN";
          break;
        case "project_id":
          $v = is_array($v)? join(",",$v) : $v;
          $test = explode(',',$params["$k"]);
          if( in_array($id, $test) ) {
            $this->addDebug('update_ticket', "Project id references this ticket!", 1);
          }
          else {
            $params["$k"] = $v;
          }
          break;
        case "ctime":
        default:
          $params["$k"] = "NULL";
        }
      }
    }
    $set = $this->makeInsertVals($params,1);
    $query = "UPDATE ".$this->table_tickets." SET $set WHERE id = $id";
    $this->update_notify_list($t,$params);
    $this->addDebug("update_ticket",$query,3);
    $this->_session->clearDataCache('tickets',$id);
    return $this->db_result($query);
  }

  /**
   * Update the entries in the standard fields for a given ticket
   *
   * @param integer $id
   * @param integer $user_id user who edited
   * @param array $params mapped field_name -> value
   * @param string $reason reason why the ticket is being edited (user entry)
   * @param integer $mode if not null, don't log but use log_buffer
   */
  function edit_ticket( $id, $user_id, $params, $reason="", $mode=null ) {
    if( is_array($id) ) {
      $t = $id;
      $tid = $t['id'];
    }
    else {
      $t = $this->get_ticket($id);
      $tid = $id;
    }
    $id = $this->checkNum($id);
    $res = $this->update_ticket($id, $params);
//    Zen::printArray($params, 'edit_ticket');//debug
    if( $res && $this->settingOn('log_edit') ) {
      if ( $mode ) {
        $log_entry = "";
      } else {
        $log_entry = "Ticket edited:\n\n";
      }
      foreach($params as $key=>$val) {
        // check each field to see if it was updated
        if( $t["$key"] != $val ) {
          $v1 = strlen($t["$key"]) > 50? substr($t["$key"], 0, 50)."..." : $t["$key"];
          $v2 = strlen($val) > 50? substr($val, 0, 50)."..." : $val;
          switch ("$key") {
            case "bin_id":     $d1 = $this->getBinName($v1);
                               $d2 = $this->getBinName($v2);
                               break;
            case "system_id":  $d1 = $this->getSystemName($v1);
                               $d2 = $this->getSystemName($v2);
                               break;
            case "type_id":    $d1 = $this->getTypeName($v1);
                               $d2 = $this->getTypeName($v2);
                               break;
            case "priority":   $d1 = $this->getPriorityName($v1);
                               $d2 = $this->getPriorityName($v2);
                               break;
            case "user_id":
            case "creator_id": $d1 = $this->formatName($v1);
                               $d2 = $this->formatName($v2);
                               break;
            case "otime":
            case "ctime":
            case "deadline":
            case "start_date": $v1= $v1? $this->showDateTime($v1) : '';
                               $v2= $v2? $this->showDateTime($v2) : '';
            default:           $d1 = "";
                               $d2 = "";
                               if (strpos($key,"custom_date")===0) {
                                 $v1= $v1? $this->showDateTime($v1) : '';
                                 $v2= $v2? $this->showDateTime($v2) : '';
                               }
                               break;
          }
          if (strlen($d1)>0) $d1=": ".$d1;
          if (strlen($d2)>0) $d2=": ".$d2;
          $fm = new ZenFieldMap($this);
          $label = $fm->getLabel("ticket_edit",$key);
          $log_entry .= " - {$label} changed from [$v1$d1] to [$v2$d2]\n";
        }
      }
      if(strlen($reason)) {
        $log_entry.= "\nReason:\n";
        $log_entry.= $reason;
      }
      if ($mode) {
        $this->log_buffer.=$log_entry;
      } else {
        $this->add_log( $tid, array('user_id'   => $user_id,
                                    'action'    => 'EDIT',
                                    'entry'     => $log_entry,
                                    'bin_id'    => $t['bin_id']) );
      }
    }
    return $res;
  }
   
  /*
   *  LOG AND TIME FUNCTIONS 
   */


  function add_log( $id, $params ) {
    // add a new log entry for ticket
    // with $id
    // params can include any of the 
    // following indexes:
    //    user_id
    //    bin_id
    //    action (the action logged)
    //    entry (the log entry)
    //    ticket_id
    $id = $this->checkNum($id);

    // set up the parameters for the insert statement
    $table = $this->table_logs;
    $params["ticket_id"] = $id;
    $params["created"] = $this->currTime;
    if( !$params["action"] )
      $params["action"] = "LOG";
    if( !$params["user_id"] )
      $params["user_id"] = 0;//$this->getSetting("bot_name");
    if( !$params["bin_id"] ) {
      $ticket = $this->get_ticket($id);
      $params["bin_id"] = $ticket["bin_id"];
    }
    // add hours to the ticket's total
    if( $params["hours"] ) {
      if( !$ticket )
        $ticket = $this->get_ticket($id);
      $wkd = $params["hours"] + $ticket["wkd_hours"];
      $query = "UPDATE ".$this->table_tickets
        ." set wkd_hours = $wkd WHERE id = $id";
      $this->db_result($query);
    }
    return( $this->db_insert($table, $params) );      
  }

  function delete_log( $id, $flag = 0, $archive_flag = 0 ) {
    // delete log entries for ticket with
    // $id, if $flag = 1, then deletes only
    // the entry with log_id of $id (i.e. by the
    // log id instead of ticket id)
    // id can be a string or an array

    $column = ($flag)? "lid" : "ticket_id";
    if( is_array($id) ) {
      $where = " $column IN(";
      for($i=0; $i<count($id); $i++) {
        if( $i > 0 ) { $where .= ','; }
        $where .= $this->checkNum($id);
      }
      $where .= ")";
    }
    else {
      $where = " $column = ".$this->checkNum($id);
    }
    $table = ($archive_flag)? 
      $this->table_logs_archived :
      $this->table_logs;
    if( !$archive_flag ) {
      $attachments = $this->get_attachments($id, $flag);
      if( is_array($attachments) ) {
        foreach($attachments as $a) {
          $att[] = $a["attachment_id"];
        }
        $this->delete_attachment($att);
      }  
    }
    $query = "DELETE FROM $table WHERE $where";
    return( $this->db_result($query) );
  }

  function add_attachment( $name, $filename, $filetype, 
                           $ticket_id, $log_id = 0, $description = '' ) {
    // adds an attachment to the db for tracking
    // does not add the actual file, just it's associations
    // with logs and tickets, log_id is optional, the ticket_id is not
    // filetype represents the complete mime type as will be used
    // to supply the file back to the user when requested

    $log_id = $this->checkNum($log_id);
    if( !$ticket_id ) {
      $log = $this->get_log($log_id);
      $ticket_id = $log["ticket_id"];
    }
    $ticket_id = $this->checkNum($ticket_id);
    $params = array(
                    "log_id"       => $log_id,
                    "ticket_id"    => $ticket_id,
                    "name"        => $name,
                    "filename"    => $filename,
                    "filetype"    => $filetype
                    );
    if( $description )
      $params["description"] = $description;
    $table = $this->table_attachments;
    return( $this->db_insert($table,$params) );
  }

  function delete_attachment( $access_id ) { 
    // deletes attachments by attachment_id
    // can be an array
    $c = 0;
    if( !is_array($access_id) )
      $access_id = array($access_id);
    $ids = array();
    for( $i=0; $i<count($access_id); $i++ ) {
      $aid = $this->checkNum($access_id[$i]);
      $att = $this->get_attachment($aid);
      if( !$att || !count($att) ) {
        $this->addDebug('delete_attachment', "Attachment not found: "+$access_id);
        continue;
      }
      $ids[] = $aid;
      $file = $this->libDir."/attachments/{$att['filename']}";
      unlink($file);
      $c++;
    }
    if( count($ids) ) {
      $query = "DELETE FROM ".$this->table_attachments
        ." WHERE attachment_id IN(".join(",",$ids).")";
      if( $this->db_result($query) ) { return $c; }
    }
    return false;
  }

  function delete_all_attachments( $ids ) {
    // deletes all attachments by their log_id
    // $id can be an array

    if( !is_array($ids) )
      $ids = array($ids);
    $access_id = array();
    foreach($ids as $id) {
      $id = $this->checkNum($id);
      $att = $this->get_attachments($id, $flag);
      for( $i=0; $i<count($att); $i++ ) {
        $access_id[] = $att["attachment_id"];
      }
    }
    return( $this->deleteAttachment($access_id) );
  }


  /*
   *  USER ADMINISTRATION
   */

  function check_user_login( $login ) {
    // check for duplicate login names
    $query = "SELECT user_id FROM ".$this->table_users." WHERE login = '$login'";
    return $this->db_get($query);
  }

  function check_user_id( $user_id ) {
    // check to make sure a user_id appears
    // in the database
    $user_id = $this->checkNum($user_id);
    $query = "SELECT count(*) FROM ".$this->table_users
      ." WHERE user_id = $user_id";
    return( $this->db_get($query) > 0 );
  }

  function add_user( $params ) {
    // creates a new user entry in the db
    // if $params["access"] is an array
    // then it will also run add_access()
    // with this array once the user has
    // been created
    // if ["passphrase"] is given, it should
    // be the unencrypted value.. if blank,
    // ["passphrase"] will be set automatically
    // to the users last name until that user
    // logs into the system and changes it

    if( isset($params["access"]) ) {
      $access = $params["access"];
      unset($params["access"]);
    }
    $params["passphrase"] = ($params["passphrase"])?
      $this->encval($params["passphrase"]) : $this->encval($params["lname"]);
    $table = $this->table_users;
    $id = $this->db_insert($table, $params);
    if( $id ) {
      if( is_array($access_level) )
        $this->add_access($id, $access_level);
      return($id);
    }
  }

  function delete_user( $user_id ) {
    // deletes a user from the db by the
    // user's id.  also deletes all access
    // and prefs entries for this user
    // $user_id can be an array
    
    $this->_userChanged($user_id);
    
    if( is_array($user_id) ) {
      $where = " user_id IN(";
      for($i=0; $i<count($user_id); $i++) {
        if( $i > 0 ) { $where .= ","; }
        $where .= $this->checkNum($user_id[$i]);
      }
      $where .= ')';
    }
    else {
      $where = " user_id = ".$this->checkNum($user_id);
    }
    $query = "DELETE FROM ".$this->table_users." WHERE $where";
    $this->addDebug("delete_user()Query",$query,2);
    $this->delete_access($user_id);
    return( $this->db_result($query) );
  }

  function update_user( $user_id, $params ) {
    // updates user settings by user_id
    // do not encrypt the passphrase, this is done
    // automatically
    
    $this->_userChanged($user_id);

    $user_id = $this->checkNum($user_id);
    if( $user["login"] == "egate" ) {
      // don't allow password entry for the egate account
      $params["passphrase"] = 'NULL';
    }
    else if( $params["passphrase"] ) {
      // encrypt the password
      $params["passphrase"] = $this->encval($params["passphrase"]);
    }
    if ($params["homebin"] == 'all') {
      // put the value as -1 for all bin
      $params["homebin"] = -1;
    }
    foreach($params as $k=>$v) {
      if( !strlen($v) ) {
        if( $k == "active" )
        $params["$k"] = 1;
        else
        $params["$k"] = "NULL";
      }
    }
    $set = $this->makeInsertVals($params,1);
    $query = "UPDATE ".$this->table_users." SET $set WHERE user_id = $user_id";
    $this->addDebug("update_user()Query",$query,2);
    return( $this->db_result($query) );
  }

  /**
   * Add new access params for a given user.  This method does not check for
   * duplicates or remove old entries.  Use {@link ZenTrack::update_access} if
   * you need this logic.
   *
   * @param int $user_id
   * @param array $params is an associative array of "bin_id" => array("lvl", "notes/roles")
   * @return int number of successfully added rows, which can be compared to count($params)
   */
  function add_access( $user_id, $params ) {
    // adds new access parameters for the 
    // given user, ignores ones that 
    // currently exist for that user
    // $params is an indexed array containing:
    //   "bin_id" => level (integer)
    $user_id = $this->checkNum($user_id);

    $i = 0;
    foreach($params as $k=>$v) {
      if( !strlen($v[0]) ) { $v[0] = 'NULL'; }
      if( !strlen($v[1]) ) { $v[1] = 'NULL'; }
      $arr = array( "user_id" => $user_id,
                    "bin_id"  => $k,
                    "lvl"     => $v[0],
                    "notes"   => $v[1] );
      if( $this->db_insert($this->table_access,$arr) ) {
        $i++;
      }
    }

    return $i;
  }

  /**
   * Replaces users existing access priviledges with the new values provided
   *
   * @param int $user_id
   * @param array $params array matching spec for {@link zenTrack::addAccess()}
   * @return int db_result
   */
  function update_access( $user_id, $params ) {
    $user_id = $this->checkNum($user_id);
    $this->delete_access( $user_id );
    return( $this->add_access($user_id, $params) );
  }

  /**
   * Delete's user's access priviledges from db
   *
   * @param int $id the id to delete priviledges for (id type is based on flag)
   * @param int $flag null=>user_id, 1=>bin_id, 2=>access_id
   * @return int db_result
   */
  function delete_access( $id, $flag = '' ) {
    if( $flag == 1 ) { $field = "bin_id"; }
    else if( $flag == 2 ) { $field = "access_id"; }
    else { $field = "user_id"; }
    
    // clear data cache
    if( $field == 'user_id' ) {
      // clear all uses from cache who have been altered
      $vals = is_array($id)? $id : array($id);
      foreach($vals as $uid) {
        $this->_accessChanged($uid);
      }
    }
    else {
      // if we are deleting by bin or access id, then we will just clear the
      // entire cache, since it will not be worth the effort to track which ones
      // are deleted.
      $this->_accessChanged();
    }
    if( is_array($id) ) {
      $where = " $field IN(".join(',',Zen::checkNum($id)).")";
    }
    else {
      $where = " $field = ".$this->checkNum($id);      
    }
    $query = "DELETE FROM ".$this->table_access." WHERE $where";
    $this->addDebug("delete_access()Query",$query,2);
    return( $this->db_result($query) );
  }

  /**
   * Returns preferences for a user
   *
   * @param int $user_id the user to retrieve
   * @param string $pref if provided, only the value of this preference is returned, otherwise an array is returned
   * @return mixed a (string)value if $pref is specified, otherwise an array of all prefs for user
   */
  function get_prefs( $user_id, $pref = '' ) {
    // try to retrieve from session
    $prefSet = $this->_session->getDataType('prefs');
    if( isset($prefSet) && isset($prefSet["U$user_id"]) ) { 
      if( $pref ) {
        return array_key_exists($pref, $prefSet["U$user_id"])?
          $prefSet["U$user_id"][$pref] : null;
      }
      else { return $prefSet["U$user_id"]; } 
    }
    if( !isset($prefSet) ) { $prefSet = array(); }
    
    // retrieve from database
    $user_id = $this->checkNum($user_id);
    $query = "SELECT prefname,prefval FROM ".$this->table_preferences
      ." WHERE user_id = $user_id";
    $vals = $this->db_listIndexed($query);
    
    // store in session
    $prefSet["U$user_id"] = $vals;
    $this->_session->storeDataType("prefs",$prefSet);
    
    if( $pref ) {
      return array_key_exists($pref, $vals)?
        $vals[$pref] : null;
    }
    else { return $vals; } 
  }
  
  /**
   * Update (or add) a single preference in the database
   *
   * @param int $user_id
   * @param string $pref (can only contain [a-zA-Z_ -])
   * @param string $value the value to be inserted, null or "" should work fine
   */
  function update_pref( $user_id, $pref, $value ) {
    $old_value = $this->get_prefs($user_id, $pref);
    if( "$old_value" == "$value" ) {
      $this->addDebug('update_pref', "Value has not changed for '$pref', not updated", 2);
    }
    
    // delete old pref
    $user_id = $this->checkNum($user_id);
    $pref = $this->checkAlphaNum($pref, '_ -');
    $query = "DELETE FROM ".$this->table_preferences." WHERE user_id = $user_id "
      ." AND prefname = '$pref'";
    $res = $this->db_result($query);
    
    // add new pref
    $vals = array(
      'user_id'  => $user_id,
      'prefname' => $pref,
      'prefval'  => $value
    );
    list($cols,$vals) = $this->makeInsertVals($vals);
    $query = "INSERT INTO ".$this->table_preferences
      ." ($cols) VALUES($vals)";
    $res = $this->db_result($query);
    $this->_session->clearDataType('prefs');
    $this->addDebug('update_pref', "[$res]".$query, 3);
    return $res;
  }

  function update_prefs( $user_id, $params, $prefname = '' ) {
    $user_id = $this->checkNum($user_id);
    $this->delete_prefs($user_id, $prefname);
    $this->_session->clearDataType('prefs');
    return $this->add_prefs($user_id,$params);
  }

  function add_prefs( $user_id, $params ) {
    // adds prefs for a user_id
    $user_id = $this->checkNum($user_id);
    $i = 0;
    foreach($params as $p) {
      $vars = array("user_id"=>$user_id);
      foreach($p as $k=>$v) {
        $vars["prefname"] = $this->checkAlphaNum($k,'_ -');
        $vars["prefval"] = strlen($v)? $v : "NULL";
      }
      list($cols,$vals) = $this->makeInsertVals($vars);
      $query = "INSERT INTO ".$this->table_preferences
      ." ($cols) values($vals)";
      $res = $this->db_result($query);
      if( $res ) {
        $i++;
      }
      $this->addDebug("add_prefs","$res/$query",3);
    }
    $this->_session->clearDataType('prefs');    
    return( $i );
  }

  function delete_prefs( $user_id, $prefname = '' ) {
    // deletes prefs entries by user_id
    // user_id can be an array      
    $user_id = $this->checkNum($user_id);
    $prefname = $this->checkAlphaNum($prefname, '_ -');
    $query = "DELETE FROM ".$this->table_preferences." WHERE user_id = $user_id";
    if( $prefname ) {
      $query .= " AND prefname = '$prefname'";
    }
    $res = $this->db_result($query);
    $this->addDebug("delete_prefs","$res/$query",3);
    $this->_session->clearDataType('prefs');
    return( $res );
  }

  function reset_password( $user_id ) {
    // resets the users passphrase to the default value
    // for a user.  This will probably be the users last name
    // note that the password cannot be changed
    // for the egate account (to prevent users logging in as
    // egate
    $user_id = $this->checkNum($user_id);
    $user = $this->get_user($user_id);
    $params["passphrase"] = $user["lname"];
    return $this->update_user($user_id, $params);
  }


  /*
   *  SYSTEM ADMINISTRATION
   */


  function add_bin( $params ) {
    // add a new bin to the bins table
    $this->_binChanged();
    return( $this->db_insert( $this->table_bins, $params ) );
  }

  function add_priority( $params ) {
    // add a new priorty
    $this->_session->clearDataType('priorities');    
    return( $this->db_insert( $this->table_priorities, $params ) );
  }

  function add_setting( $params ) {
    // add a new setting into the db
    $this->_session->clearDataType('settings');
    $this->_settings = false;
    return( $this->db_insert($this->table_settings, $params) );
  }

  function add_system( $params ) {
    // add a new system to the db
    $this->_session->clearDataType('systems');
    return( $this->db_insert( $this->table_systems, $params ) );      
  }

  function add_task( $params ) {
    // add a new task to the system
    $this->_session->clearDataType('tasks');
    return( $this->db_insert( $this->table_tasks, $params) );
  }

  function add_type( $params ) {
    // add a new ticket type
    $this->_session->clearDataType('types');
    return( $this->db_insert($this->table_types, $params) );
  }

  function update_custom_field_idx( $field_name, $params ) {
    // update properties for a given custom_field definition (key= field_name)
    $field_name = $this->checkAlphaNum($field_name);
    $set = $this->makeInsertVals($params,1);
    $query = "UPDATE ".$this->table_varfield_idx." SET $set WHERE field_name = '$field_name'";
    $this->addDebug("update_custom_field_idx()Query",$query,2);
    $this->_session->clearCustomFields();
    return( $this->db_result($query) );
  }

  function update_bin( $bid, $params ) {
    // update properties for a given bid (bin id)
    $bid = $this->checkNum($bid);
    $set = $this->makeInsertVals($params,1);
    $query = "UPDATE ".$this->table_bins." SET $set WHERE bid = $bid";
    $this->addDebug("update_bin()Query",$query,3);
    $this->_binChanged();
    return( $this->db_result($query) );
  }

  function update_priority( $pid, $params ) {
    // update properties for a given priority
    $pid = $this->checkNum($pid);
    $set = $this->makeInsertVals($params,1);
    $query = "UPDATE ".$this->table_priorities." SET $set WHERE pid = $pid";
    $this->addDebug("update_priority()Query",$query,3);
    $this->_session->clearDataType('priorities');
    return( $this->db_result($query) );
  }

  function update_setting( $setting_id, $params ) {
    // update a setting based on it's setting_id
    $setting_id = $this->checkNum($setting_id);
    $set = $this->makeInsertVals($params,1);
    $query = "UPDATE ".$this->table_settings." SET $set WHERE setting_id = $setting_id";
    $res = $this->db_result($query);
    $this->addDebug("update_setting()Query","[$res]$query",3);
    $this->_session->clearDataType('settings');
    $this->_settings = $this->getSettings();
    $this->_accessChanged(); // might be changing a level_ setting.. no way to tell
    return( $res );
  }

  function update_system( $sid, $params ) {
    // update settings for a given 
    // sid (system_id)
    $sid = $this->checkNum($sid);
    $set = $this->makeInsertVals($params,1);
    $query = "UPDATE ".$this->table_systems." SET $set WHERE sid = $sid";
    $this->addDebug("update_system()Query",$query,3);
    $this->_session->clearDataType('systems');
    return( $this->db_result($query) );      
  }

  function update_task( $task_id, $params ) {
    // update a ticket task by task_id
    $task_id = $this->checkNum($task_id);
    $set = $this->makeInsertVals($params,1);
    $query = "UPDATE ".$this->table_tasks." SET $set WHERE task_id = $task_id";
    $this->addDebug("update_task()Query",$query,3);
    $this->_session->clearDataType('tasks');
    return( $this->db_result($query) );            
  }

  function update_type( $type_id, $params ) {
    // update a ticket type by the type_id
    $type_id = $this->checkNum($type_id);
    $set = $this->makeInsertVals($params,1);
    $query = "UPDATE ".$this->table_types." SET $set WHERE type_id = $type_id";
    $this->addDebug("update_type()Query",$query,3);
    $this->_session->clearDataType('types');
    return( $this->db_result($query) );
  }


  /*
   *  ACCESS UTILITIES
   */


  function login_user( $username, $passphrase, $from_cookie = false ) {
    // perform a login check for username and passphrase
    // returns the user's user_id
    $username = $this->checkAlphaNum($username);
    $pass = $from_cookie? $this->checkSlashes($passphrase) : $this->checkSlashes($this->encval($passphrase));
    $query = "select user_id from ".$this->table_users
      ." where login = '$username' and passphrase = $pass and active > 0";
    $user_id = $this->db_get($query);
    $this->addDebug("zentrack.class:login_user($user_id)",$query,2);
    if( $user_id ) { $this->getUser($user_id); };
    return($user_id);
  }

  function check_bin_access( $user_id, $bin_id, $level = 1 ) {
    // check the user's access priviledges for the given bin_id
    // based on the users user_id. and $level (returns true
    // if equal to or greater than this)
    $user_id = $this->checkNum($user_id);
    $bin_id = $this->checkNum($bin_id);
    $access =  $this->getAccess( $user_id );
    return( ($access["$bin_id"] >= $level) );
  }

  /*
   *  TOOLS 
   */   

  /**
   * insures that members are included in a recipient list
   *
   * @param array $recipients the list to be added to
   * @param array $vals an array of email addresses, or a single email address to check
   * @return array complete list
   */
  function checkIncludedRecipients( &$recipients, $vals ) {
    if( !is_array($recipients) && $vals ) {
      $recipients = (is_array($vals))? $vals : array($vals);
    }
    else if( is_array($vals) ) {
      foreach($vals as $v) {
        if( !in_array($v,$recipients) ) {
          $recipients[] = $v;
        }
      }
    }
    else if( $vals ) {
      if( !in_array($vals,$recipients) ) {
        $recipients[] = $vals;
      }
    }
  }

  function check_status( $id, $code = 'OPEN' ) {
    // checks to see if a ticket is ready for the 
    // given action, the $code codes are:
    //    OPEN    - is open?
    //    PEND    - is pending?
    //    TEST    - ready for testing?
    //    APPR    - ready for approval?
    //    READY   - ready for closing?
    //    CLOSED  - is closed?
    // returns 1 if $code can be met
    $c = strtoupper(substr($code,0,2));
    if( is_array($id) ) {
      $ticket = $id;
    } else {
      $ticket = $this->get_ticket($id);
    }    
    if( $c == 'OP' ) {
      return( $ticket["status"] == 'OPEN' );
    } else if( $c == 'PE' ) {
      return( $ticket["status"] == 'PENDING' );
    } else if( $c == 'TE' ) {
      return( $ticket["status"] == 'PENDING' && ($ticket["tested"] == 1) );
    } else if( $c == 'AP' ) {
      return( $ticket["status"] == 'PENDING' && $ticket["tested"] != 1 );
    } else if( $c == 'RE' ) {
      return( ($ticket["status"] == 'PENDING' && $ticket["tested"] != 1 
               && $ticket["approved"] != 1)
              ||
              ($ticket["status"] == 'OPEN' && $ticket["tested"] == 0 
               && $ticket["approved"] == 0));
    } else if( $c == 'CL' ) {
      return( $ticket["status"] == 'CLOSED' );
    }
  }   

  function get_bin_roles( $bin_id, $role = '') {
    // Pending further testing, this function simply acts as a pass-through to
    // fetch_bin_roles()
    $bin_id = $this->checkNum($bin_id);
    $result = $this->fetch_bin_roles($bin_id, $role);    
    return ($result);
  }

  function fetch_bin_role_emails( $bin_id, $role = '' ) {
    $bin_id = $this->checkNum($bin_id);
    $vars = array();
    $vals = $this->fetch_bin_roles($bin_id, $role, 'email');
    if( is_array($vals) ) {
      foreach($vals as $v) {
	$user = $this->get_user($v["user_id"]);
	$vars[] = $user["email"];
      }
    }
    return $vars;
  }
  
  function fetch_bin_roles( $bin_id, $role = '' ) {
    // fetches members of bin with a particular
    // role.  If $role is given, fetches only
    // members listed as fulfilling that particular
    // role. Returns the user_id and their role in an
    // indexed array
    $bin_id = $this->checkNum($bin_id);

    // check the role id
    if( preg_match("@[^0-9]@", $role) ) {
      $role = $this->getRoleID($role);
    }
    // set up the query parameters
    $where = " bin_id = $bin_id";
    if( $role ) {
      $where .= " AND notes = '$role' ";
    }
    else {
      $where .= " AND notes IS NOT NULL ";
    }
    // set the fields to retrieve
    $fields = ($role)? " user_id " : " user_id, notes ";
    
    // run the query
    $query = "SELECT $fields FROM ".$this->table_access
      ." WHERE $where";
    $vals = $this->db_queryIndexed($query);
    $this->addDebug("fetch_bin_roles","result: ".count($vals)
                    .", query: $query",3);
    return( $vals );
  }

  function fetch_user_roles( $user_id, $bin_id = '' ) {
    // fetches a specific user's roles in zenTrack
    // if bin_id is given, returns only roles for that specific bin
    // returns the bin_id and role in an indexed array
    $user_id = $this->checkNum($user_id);
    if( $bin_id ) { $bin_id = $this->checkNum($bin_id); }

    $where = ($bin_id)? " user_id = $user_id AND bin_id = $bin_id " : 
      " user_id = $user_id ";
    $query = "SELECT bin_id, notes FROM "
      .$this->table_access." WHERE $where"
      ." AND (notes IS NOT NULL) ";
    $vals = $this->db_queryIndexed($query);
    // remove inactive bins
    $bins = $this->getBins();
    for($i=0; $i<count($vals); $i++) {
      $n = $vals[$i]['bin_id'];
      if( !isset($bins["$n"]) ) { unset($vals[$i]); }
    }
    $this->addDebug("fetch_user_roles","result: ".count($vals)
                    .", query: $query",3);
    return( $vals );
  }

  function format_name( $user_id, $flag = '' ) {
    // alias for formatName()      
    return($this->formatName($user_id, $flag));
  }

  function formatName( $user_id, $flag = '' ) {
    // if the user properties are available, pass those here
    // otherwise pass the user id, and he/she will be retrieved
    // from the db (user properties can be passed as an array in
    // place of $id)
    // if $flag = 2, then returns "initials"
    // if $flag = 1, then returns "lname, fname"
    // if !$flag, then returns "fname lname"

    if( is_array($user_id) )
      $user = $user_id;
    else
      $user = $this->get_user($user_id);

    if( !is_array($user) )
      return( "n/a" );
    if( $flag == 2 )
      return( $user["initials"] );
    else if( $flag == 1 )
      return( $user["lname"].", ".$user["fname"] );
    else
      return( $user["fname"]." ".$user["lname"] );
  }

  function percentWorked( $etc = 0, $wkd = 0 ) {
    // determines the percent completion for this
    // project
    if( $etc > 0 ) {
      return( round($wkd/$etc*100,1) );
    }
  }   

  function formatEmailMessage( $params ) {
    // takes a list of input parameters and makes
    // a formatted message to be sent, including links 
    // and information about the ticket referenced
    // special params:
    //     message - printed at the top of the email with
    //               line breaks afterwards
    //     body    - printed with extra line breaks
    //     tid     - retrieves the ticket by this id and 
    //               includes it in the email body
    //     log     - retrieves log entries for this ticket
    //               by the id given by log, limited by the
    //               system setting email_max_logs
    //     link    - displays a link to the ticket
    //               (this is done with the tid property too,
    //                use this one instead of tid to display
    //                the link only)
    // all others are printed as is, with html stripped

    if( $params["message"] ) {
      // insure the message gets printed first
      $message = $params["message"]."\n\n";
      unset($params["message"]);
    }

    // loop through the parameters and print them
    foreach( $params as $k=>$v ) {
      if( $k == 'body' ) {
        // include the body of the message
        $message .= "\n\n$v\n\n";
      } else if( $k == 'link' ) {
        $message .= $this->getSetting("url_view_ticket")."?id=$v";       
      } else if( $k == 'tid' ) {
        // print a summary of the ticket
        $message .= "\n\n--- ".strtoupper($this->trans("Ticket Summary"))." ---\n\n";
        if( !is_array($ticket) ) {
          // if we passed the ticket
          // then use it
          if( is_array($v) ) {
            $ticket = $v;
            $v = $ticket["id"];
          }
          // otherwise, retrieve it by the id
          else {
            $ticket = $this->get_ticket($v);
          }
        }
        $ticket['varfields'] = $this->getVarfieldVals($v);
        $url = $this->getSetting("url_view_ticket")."?id=$v";
        $n = $ticket["bin_id"];
        $u = $ticket["user_id"];
        $s = $ticket["system_id"];
        if( $ticket["user_id"] ) {
          $name = $this->formatName($ticket["user_id"]);
        } else {
          $name = "n/a";
        }

        if( $ticket["creator_id"] ) {
          $crname = $this->formatName($ticket["creator_id"]);
        } else {
          $crname = "n/a";
        }
        
        $des = preg_replace("#&quot;#",'"',
                            preg_replace("#&amp;#","&",$ticket["description"]));
        $des = preg_replace("@<br( /)?>@", "", $des);

        // Create message template
        $msg = new zenTemplate($this->templateDir."/email/ticket_summary.template");
        
        // Set variables for message
        unset($vars);
        $vars["title"] = $ticket["title"];
        $vars["id"] = $ticket["id"];
        $vars["type"] = $this->getTypeName($ticket["type_id"]);
        $vars["priority"] = $this->priorities[$ticket["priority"]];
        $vars["status"] = $ticket["status"];
        $vars["deadline"] = $this->showDate($ticket["deadline"]);
        $vars["bin"] = $this->bins[$n];
        $vars["creator"] = $crname;
        $vars["owner"] = $name;
        $vars["url"] = $url;
        $vars["desc"] = $des;
        
        // Process the template
        $msg->values($vars);
        
        $message .= $msg->process();
      } else if( $k == "log" ) {
        // print the log for the ticket
        if( $this->getSetting("email_max_logs") )
          $lim = $this->getSetting("email_max_logs");
        $logs = $this->get_logs($v, 'created DESC', $lim);
        $message .= "\n\n";
        if( is_array($logs) ) {
          $att = $this->get_attachments($v,null,1);
          $message .= "\n".strtoupper($this->trans("Log History"))."\n------------------\n";
          $sep = "--";
          foreach( $logs as $l ) {
             // Create log entry template
             $logentry = new zenTemplate($this->templateDir."/email/ticket_log.template");
             
             // Set the variables for the log entry
             unset ($vars);
             $vars["date"] = $this->showDateTime($l["created"],'M');
             $vars["action"] = $sep.str_pad($l["action"],8,"-",STR_PAD_LEFT);
             $vars["user_initials"] = $sep.str_pad($this->formatName($l["user_id"],2),
                                      6,"-",STR_PAD_LEFT);
             $vars["hours"] = (strlen($l["hours"]))? 
                              $sep.str_pad($l["hours"],4,"-",STR_PAD_LEFT)." hrs":"";
             
             //
             // the log and attachments
             if( $l["entry"] ) {
                $log["entry"] = "\n".stripslashes($l["entry"])."\n";
                $log["entry"] = preg_replace("#&amp;#", "&", $log["entry"]);
                $log["entry"] = preg_replace("#&quot;#", '"', $log["entry"]);
                $l["entry"] = preg_replace("@<br( /)?>@", "", $log["entry"]);
                $vars["log"] = $l["entry"];
             }
             
             // Process the template and add it to the message.
             $logentry->values($vars);
             $message .= $logentry->process();
             
             // Add attachments to the message.
             if( $att["$id"]["$lid"] ) {
                $message .= "\n".strtoupper($this->trans("Attachments") . '').":\n";
                foreach( $att["$id"]["$lid"] as $a ) {
                   $message .= "$a[name] ($a[description])\n";
                   $message .= "\t".$this->attachmentUrl."?file=$a[filename]\n";
                }
             }
          }
          if( $v > 0 && count($logs) == $v ) {
            $message .= "\n".$this->trans("There are more log entries.")
              .$this->trans("Please log in to view the entire ticket.")."\n";
            if( !$params["tid"] && !$params["link"] ) {
              $message .= $this->getSetting("url_view_ticket")."?id=$v";
            }
          }
        } else {
          $message .= $this->trans("No logs found")."\n";
        }
        $message .= "\n";          
      } else {
	// just print whatever is indexed, since it didn't
	// match any special settings
	$v = strip_tags($v);
	$message .= "$k:\t$v\n";
      }
    }

    return($message);
  }

  function sendEmail( $recipients, $subject, $message, 
                      $sender = '', $cc = '' ) {
    // send email updates to $recipients
    // $recipients and $sender are the user_id of the sender and recipient
    // alternately, $recipients can contain valid email addresses rather 
    // than a user_id value (to send to non-zentrack users)
    // $recipients, $sender, and $cc can all be an array
    // if email is successful, no result is returned, otherwise error string returned
    
    // grab the egate account
    $egate_email = "";
    $egate_user = $this->get_user_by_login("egate");
    if( is_array($egate_user) ) {
      $egate_email = $egate_user["email"];
    }
    
    // add the obligatory email stuff
    $subject = "[".$this->getSetting("bot_name")."] ".$subject;
    
    // figure out who sent it
    $message = (get_magic_quotes_gpc())? stripslashes($message) : $message;
    $message = preg_replace(
                            array("#&amp;#", "#&lt;#", "#&gt;#", "#&quot;#"),
                            array("&", "<",">",'"'), $message);
    if( !$sender ) {
      $sender_address = $this->getSetting("admin_email");
    } else {
      if( eregi("^[0-9]+$", $sender) ) {
        $s = $this->get_user($sender);
        $sender_address = $s["email"];
      } else {
        $sender_address = $sender;
      }
    }
    
    // figure out who it is being set to
    if( !is_array($recipients) )
    $recipients = array($recipients);
    foreach($recipients as $r) {      
      if( strlen($r) ) {
        if( $recipient_address )
        $recipient_address .= ", ";
        if( eregi("^[0-9]+$", $r) ) {
          $s = $this->get_user($r);
          if( $s["email"] && $s["email"] != $egate_email ) {
            $recipient_address .= $s["email"];
          }
        } else {
          if( $r != $egate_email )
          $recipient_address .= $r;
        }
      }
    }
    
    if( strlen($recipient_address) ) {
      // create headers and CC fields
      $headers .= "From: $sender_address\n";
      if( $cc ) {
        if( !is_array($cc) )
        $cc = array($cc);
        foreach($cc as $c) {
          if( $cc_address )
          $cc_address .= ", ";
          if( eregi("^[0-9]+$", $c) ) {
            $s = $this->get_user($c);
            $cc_address .= $s["email"];
          } else {
            $cc_address .= $c;
          }
        }
        $headers .= "cc: $cc_address\n";
      }
      

      if( $this->settingOn("email_interface_enabled") ) {
        // set reply address to egate user        
        $s = $egate_user;
        if( !is_array($s) ) {
          $this->addDebug("sendEmail", "Egate login not found!",1);
          $message = (get_magic_quotes_gpc())? $message : addslashes($message);
        }
        else {
          $sender = $s["email"];
          $headers .= "Reply-To: $sender\n";
          
          // load the header and footer
          $hd_tmp = new zenTemplate($this->templateDir."/email/heading.template");
          $ft_tmp = new zenTemplate($this->templateDir."/email/footer.template");
          // try to find the id
          if( preg_match("/ticket #?([0-9]+)/i",$subject,$mt) ) {
            $id = $mt[1];
          }
          else {
            $id = "nnnn";
          }
          $ft_tmp->values(array("id"=>$id));
          // finalize and send the message
          $message = (get_magic_quotes_gpc())? $message : addslashes($message);
          $message = $hd_tmp->process().$message.$ft_tmp->process();
        }
      }
      else {
        $message = (get_magic_quotes_gpc())? $message : addslashes($message);
      }
      $subject = (get_magic_quotes_gpc())? $subject : addslashes($subject);
      if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
        $headers = str_replace("\n", "\r\n", $headers);
      }
      $this->addDebug("sendEmail","$recipient_address::$subject::$headers",3);
      if( !mail( $recipient_address, $subject, $message, $headers ) ) {
        return "System error: send failed";
      }
    } else {
      $str = "recipient_address was blank... "
            ."this could be that the email was sent to a user "
            ."who doesn't have an email address";
      $this->addDebug("sendEmail",$str,1);
      return $str;
    }
  }
  
  function getTicketCount( $status = '', $bin_id = '' ) {
    // counts the number of tickets matching
    // bin_id and status (if provided) and returns
    // the total

    if( $status ) { $status = $this->checkAlphaNum($status); }
    if( $bin_id ) { $bin_id = $this->checkNum($bin_id); }

    // figure out the where clause
    if( $bin_id && $status ) {
      $where = " WHERE bin_id = $bin_id AND status = '$status' ";
    } else if( $bin_id ) {
      $where = " WHERE bin_id = $bin_id ";
    } else if( $status ) {
      $where = " WHERE status = '$status' ";
    }
    // prepare and execute the select
    $query = "SELECT COUNT(id) FROM ".$this->table_tickets." $where";
    return( $this->db_get($query) );
  }


  /*
   *  DATE TRANSLATION UTILITIES
   */

  function showLongDate($utime = '') {
    // displays a long date format
    if( !$utime )
      $utime = time();
    return strftime($this->date_fmt_long,$utime);
  }

  function showDate( $utime = '') {
    // displays a short date and time
    if( !$utime )
      $utime = time();
    return strftime($this->date_fmt_short,$utime);
  }

  function showDateTime( $utime = '' ) {
    // displays a short date with time
    if( !$utime )
      $utime = time();
    return strftime($this->date_and_time,$utime);
  }

  function showTime( $utime = '' ) {
    if( !$utime )
      $utime = time();
    return strftime($this->time_fmt,$utime);
  }

  function showTimeElapsed($start,$end,$round=1,$units=1) {
    // shows the elapsed time rounded to $round decimals
    // and the units abbreviated to $substr length
    // if $units is 0, shows whole name
    // if $units is null, skips unit name
    // if $units is > 0, abbreviate units
    $num = round($this->dateDiff($end,$start,$this->elapsed_unit),$round);
    $abr = "";
    if( $units > 0 ) {
      $abr = " "
        .substr(preg_replace("@[aeiou]@", "", $this->elapsed_unit),0,2)
        ."s.";
    } else if( strlen($units) ) {
      $abr = " ".$this->elapsed_unit;
    }
    return "$num$abr";    
  }


  /*
   *  SYSTEM UTILS 
   */

  function getDataTypeFields( $table ) {
    switch( strtoupper($table) ) {
    case "ZENTRACK_BINS":
    case "BINS":
      return "bid,name";
    case "ZENTRACK_PRIORITIES":
    case "PRIORITIES":
      return "pid,name";
    case "ZENTRACK_SYSTEMS":
    case "SYSTEMS":
      return "sid,name";
    case "ZENTRACK_TASKS":
    case "TASKS":
      return "task_id,name";
    case "ZENTRACK_TYPES":
    case "TYPES":
      return "type_id,name";
    case "ZENTRACK_USERS":
    case "USERS":
      return "user_id,lname,fname,initials";
    case "ZENTRACK_FIELD_MAP":
    case "FIELD_MAP":
      return "field_name,field_label";
    }
    return null;
  }

  function getDataTypeLabel( $table, $vals ) {
    // be careful using this, it's still limited
    // $vals is a data row from the data type table
    // this returns a formatted string representing the
    // name of this row: i.e. for users, last_name, first_name
    // and for bins, the name field
    switch( strtoupper($table) ) {
    case "ZENTRACK_TICKETS":
    case "TICKETS":
    case "ZENTRACK_COMPANY":
    case "COMPANY":
      return $vals['title'];
    case "ZENTRACK_BINS":
    case "BINS":
    case "ZENTRACK_PRIORITIES":
    case "PRIORITIES":
    case "ZENTRACK_SYSTEMS":
    case "SYSTEMS":
    case "ZENTRACK_TASKS":
    case "TASKS":
    case "ZENTRACK_TYPES":
    case "TYPES":
      return $vals['name'];
    case "ZENTRACK_EMPLOYEE":
    case "EMPLOYEE":
    case "ZENTRACK_USERS":
    case "USERS":
      return $this->formatName($vals);
    case "ZENTRACK_FIELD_MAP":
    case "FIELD_MAP":
      return $vals['field_label'];
    }
    return null;
  }

  function getDataTypeSort( $table ) {
    // be careful using this, it's still limited
    switch( strtoupper($table) ) {
    case "ZENTRACK_BINS":
    case "BINS":
    case "ZENTRACK_PRIORITIES":
    case "PRIORITIES":
    case "ZENTRACK_SYSTEMS":
    case "SYSTEMS":
    case "ZENTRACK_TASKS":
    case "TASKS":
    case "ZENTRACK_TYPES":
    case "TYPES":
      return "priority, name";
    case "ZENTRACK_USERS":
    case "USERS":
      return "lname, fname";
    case "ZENTRACK_FIELD_MAP":
    case "FIELD_MAP":
      return "sort_order, field_name";
    }
    return null;
  }

  function getDataTypeId( $table ) {
    // be careful using this, it's still limited
    return ZenTrack::getTableId($table);
  }
  
  function getTableId( $table ) {
    $table = preg_replace('/^ZENTRACK_/', '', strtoupper($table));
    switch( $table ) {
      case 'ACCESS':
        return 'access_id';
      case 'AGREEMENT':
        return 'agree_id';
      case 'AGREEMENT_ITEM':
        return 'item_id';
      case "ATTACHMENTS":
        return 'attachment_id';
      case 'BEHAVIOR':
        return 'behavior_id';
      case "BINS":
        return 'bid';
      case 'COMPANY':
        return 'company_id';
      case 'EMPLOYEE':
        return 'person_id';
      case 'GROUP':
        return 'group_id';
      case 'LOGS':
        return 'lid';
      case 'NOTIFY_LIST':
        return 'notify_id';
      case 'PRIORITIES':
        return 'pid';
      case 'RELATED_CONTACTS':
        return 'clist_id';
      case 'REPORTS':
        return 'report_id';
      case 'REPORTS_TEMP':
        return 'report_id';
      case 'SETTINGS':
        return 'setting_id';
      case 'SYSTEMS':
        return 'sid';
      case 'TASKS':
        return 'task_id';
      case 'TICKETS':
        return 'id';
      case 'TYPES':
        return 'type_id';
      case 'USERS':
        return 'user_id';
      case "FIELD_MAP":
        return 'field_map_id';
      default:
        return '';
    }
  }
  
  /**
   * Using a field from ZENTRACK_TICKETS only, this will return
   * the appropriate table of the data type.  If the field provided
   * is not a data type id, then null will be returned.
   *
   * Note that this method can also handle the special cases for user_id
   * and for ticket_id.  It uses the validBins array and collects a list of
   * valid users and tickets (or projects) for the items in question.
   */
  function getValsForTicketField( $dataTypeId, $validBins ) {
    $vals = array();
    switch( strtolower($dataTypeId) ) {
      case "priority":
        $vals = $this->priorities;
        break;
      case "bin_id":
        $vals = $this->bins;
        break;
      case "type_id":
        $vals = $this->types;
        break;
      case "system_id":
        $vals = $this->systems;
        break;
      case "creator_id":
      case "user_id":
        if( !$validBins ) { return null; }
        $users = $this->get_users( $validBins, "level_user" );
        $vals = array();
        for($i=0; $i<count($users); $i++) {
          $u = $users[$i];
          $vals["{$u['user_id']}"] = $this->formatName($u,1);
        }
        break;
      case "ticket_id":
      case "id":
        if( !$validBins ) { return null; }
        $tickets = $this->get_tickets(
          array('bin_id'=>$validBins, 'status'=>array('OPEN','PENDING')), 'title', 'id, title', -1
        );
        for($i=0; $i<count($tickets); $i++) {
          $t = $tickets[$i];
          $vals["{$t['id']}"] = $t['title'];
        }
        break;
      case "project_id":
        $tickets = $this->get_tickets(
          array('type_id'=>$this->projectTypeIds(), 'status'=>array('OPEN','PENDING'), 'bin_id'=>$validBins),
          'title', 'id, title', -1 );
        for($i=0; $i<count($tickets); $i++) {
          $t = $tickets[$i];
          $vals["{$t['id']}"] = $t['title'];
        }
        break;
      default:
        return null;
    }
    $this->addDebug('getValsForTicketField()', "dataTypeId=$dataTypeId, $mode=$mode, "
      .count($validBins)." bins, ".count($vals)." results",3);
    return $vals;
  }

  function get_report_id( $n ) {
    // this function needs help
    // don't use it for anything except reports
    // needs to be fixed up
    // and made dynamic... right now
    // it's just a quick hack to prevent 
    // a horrible fix later
    $n = strtolower($n);
    $n = preg_replace("@s$@", "", $n);
    $n = preg_replace("@^zentrack_?@", "", $n);
    $names = array( "project"    => "id",
                    "ticket"     => "id",
                    "system"     => "sid",
                    "type"       => "type_id",
                    "user"       => "user_id",
                    "bin"        => "bid",
                    "setting"    => "setting_id",
                    "log"        => "lid",
                    "attachment" => "attachment_id");
    return $names["$n"];
  }

  /**
   * Retrieves all properties from the USERS table for the user_id specified
   *
   * @param int $user_id
   * @return array
   */
  function getUser( $user_id ) {
    $user_id = $this->checkNum($user_id);
    if( $user_id == ZenSessionManager::getSession('login_id') ) {
      // logged in user is stored in the session, not in
      // the temporary cache
      $user = $this->_session->find("login_user");
    }
    else {
      // all other users are only stored for the life of the page
      $user = $this->_session->getDataCache('users', $user_id);
    }
    if( $user ) {
      $this->addDebug('ZenTrack::getUser', "User $user_id retrieved from cache", 3);
      return $user; 
    }
    
    $query = "SELECT * FROM ".$this->table_users." WHERE user_id = $user_id";
    $user = $this->db_quickIndexed($query);
    $this->addDebug('ZenTrack::getUser', "Retrieved user $user_id from db [$user]: $query", 3);
    
    if( $user_id == ZenSessionManager::getSession('login_id') ) {
      $this->_session->store("login_user", $user);
    }
    else {
      $this->_session->storeDataCache('users', $user_id, $user);
    }
    return $user;
  }

  function getAccess( $user_id ) {
    return $this->get_access($user_id);
  }

  /**
   * Determine which bins a user has the required access level for.
   *
   * Retrieves the list of bins and compares those to the user's default
   * access level and specific access priviledges.
   *
   * The access is done such that the default level is overridden if a bin
   * is specified in the access priviledges.
   *
   * For example, if a user has a default level of 1, and has the following:
   * <pre><code>
   *   accounting - 2
   *   engineering - 0
   * </code></pre>
   *
   * Then this user has level 1 access to all bins except engineering, and has level 2
   * access to the accounting bin.
   *
   * The results of this lookup are cached, so multiple calls will not result
   * in multiple db lookups.
   *
   * @param int $user_id the user to look up
   * @param string $level any level_* name from the configuration settings
   * @return array 
   */
  function getUsersBins( $user_id, $level = "level_view" ) {
    $user_id = $this->checkNum($user_id);
    
    // retrieve the access level
    $lvl = $this->getSetting($level);
    
    // we will check out temporary cache to see if this algorithm has
    // already been run and stored there, to save cpu cycles
    $key = "$user_id-$lvl";
    $vals = $this->_session->getDataCache('userbins', $key);
    if( $vals ) {
      return $vals;
    }
    
    // retrieve information from the session if possible
    $rights = $this->getAccess($user_id, $level);
    $user = $this->getUser($user_id);
    $default = $user['access_level'];
    $bins = $this->getBins();
    
    if( !$rights ) {
      // there are no overriding entries, so everything hinges on the default value
      if( $default >= $lvl ) {
        $vals = array_keys( $bins );
      }
      else {
        $vals = array();
      }
    }
    else if( $default < $lvl ) {
      // if the user's default level is < the level requested, we have a pretty
      // simple operation, because the user can only see bins with a specific
      // access right assigned to them
      $vals = array();
      foreach($rights as $b=>$l) {
        if( $l >= $lvl ) {
          $vals[] = $b;
        }
      }
    }
    else {
      // if the user has a default level >= to the level requested, then we
      // will go through the list of current bins and assign values,
      // comparing the list of bins to our user's access priviledges
      // and add/remove bins as needed
      foreach($bins as $b=>$v) {
        if( isset($rights["$b"]) && $rights["$b"] < $lvl ) {
          // an access right specifically denies this action
          continue; 
        }
        else if( $default >= $lvl ) {
          // otherwise, the user has sufficient access
          $vals[] = $b;
        }
      }
    }
    
    $this->_session->storeDataCache('userbins', $key, $vals);
    return $vals;
  }
  
  function _userChanged( $user_id = false ) {
    if( $user_id && $user_id == ZenSessionManager::getSession('login_id') ) {
      $this->_session->clear('login_user');
      $this->_accessChanged($user_id);
    }
    else if( $user_id ) {
      $this->_session->clearDataCache('users', $user_id);
      $this->_accessChanged($user_id);
    }
    else {
      $this->_session->clearDataCache('users');
      $this->_session->clear('login_user');
      $this->_accessChanged();
    }
  }
  
  function _accessChanged( $user_id = false ) {
    if( $user_id && $user_id == ZenSessionManager::getSession('login_id') ) {
      $this->_session->clear('login_user_access');
    }
    else if( $user_id ) {
      $this->_session->clearDataCache('user_access');
    }
    else {
      $this->_session->clearDataCache('user_access');
      $this->_session->clear('login_user_access');
    }
  }
  
  function _binChanged() {
    $this->_session->clearDataType('bins');
    $this->_accessChanged();
  }
  
  function checkCreator( $user_id, $ticket_id ) {
    // checks to see if the $user is the creator the ticket
    // they have special priviledges
    $user_id = $this->checkNum($user_id);
    $ticket_id = $this->checkNum($ticket_id);
    if( !$this->settingOn("allow_cview") )
      return false;
    $ticket = $this->get_ticket($ticket_id);
    return( $user_id == $ticket["creator_id"] );
  }

  function checkAccess( $user_id, $bin_id, $action = 'level_view' ) {
    // takes the user_id, the bin_id and the action in
    // question, and determines whether the logged in
    // user can perform it

    $user_id = $this->checkNum($user_id);
    $bin_id = $this->checkNum($bin_id);

    // get a list of actions
    $actions = $this->getActions();
    // make sure our action is in the list
    if( isset($actions["$action"]) ) {
      $level = $actions["$action"]["level"];
    }
    else {
      // return the default level
      $level = (preg_match("@^level_@", $action) && $this->getSetting("$action") )? 
        $this->getSetting("$action") : $this->getSetting("level_view");
    }
    // find out what access our user has
    $access = $this->getAccess($user_id);

    // store results
    $bool = null;

    // if they have a bin specific access check that
    if( strlen($access["$bin_id"]) ) {
      $bool = $access["$bin_id"] >= $level;
    } 
    // otherwise just check against their default access
    else {
      $user = $this->getUser($user_id);
      $bool = $user["access_level"] >= $level;
    }
    
    // debugging
    $this->addDebug('checkAccess', 
                    "user_id={$user_id}, bin_id={$bin_id}, "
                    ."action={$action}: ".($bool? 'true' : 'false'),
                    3);
    return $bool;
  }

  function actionApplicable( $id, $action, $user_id = '', $noaccess = 0 ) {
    // check to see if an action is applicable to
    // the current ticket, based on it's status, the
    // logged in users access, and the actions requirements
    // if an array is sent in place of the ticket id, it will
    // be used as the tickets parameters (saving a db lookup)
    // $noaccess can be used to override the access requirements
    // for the action (in the case of email interface)

    // clean up input, don't do the id here, it is done below
    $action = $this->checkAlphaNum($action);
    $action = strtolower($action);
    if( $user_id ) { $user_id = $this->checkNum($user_id); }

    // get a list of actions
    $actions = $this->getActions();
    
    //if( $action == 'approve' ) { print "doing approve<br>\n"; }//debug

    // look at the settings to make sure
    // this action is on
    //todo: when we move to action sets
    // this should check the enabled field
    // for the action instead
    $n = "allow_$action";
    if( $this->hasSetting("$n") && !$this->settingOn("$n") ) {
      $this->addDebug('actionApplicable', "Setting '$n' is off: disqualified",3);
      return false;
    }

    //if( $action == 'approve' ) { print "passed has setting<br>\n"; }//debug
    
    // get the action's properties
    $c = $actions["$action"];
    
    //if( $action == 'approve' ) { Zen::printArray($c,'ACTION ARRAY'); }//debug    
    
    // return an error if this fails
    if( !$c ) {
      $this->addDebug('actionApplicable', "[{$action}]Action does not exist!",1);
      return false;
    }
    // check for an access override
    if( $noaccess )
      $c["access"] = 0;

    // get the ticket's properties
    if( is_array($id) ) {
      // if it's already an array, we must
      // have passed the whole thing instead of
      // the array, so don't fetch it
      $ticket = $id;  
      $id = $ticket["id"];
      $bin_id = $ticket["bin_id"];
    } else { 
      // query for properties
      $ticket = $this->get_ticket($id);
      $bin_id = $ticket["bin_id"];
    }
    // clean up the id here so that we don't muck arrays
    $id = $this->checkNum($id);

    //if( $action == 'approve' ) { print "id=$id, bin_id=$bin_id, ticket=$ticket<br>\n"; }//debug

    // check to see if we meet ownership requirements
    if( $c["owner"] == 2 ) {
      // here we must not be the owner
      if( $ticket["user_id"] == $user_id ) {
        $this->addDebug('actionApplicable', "[{$action}]Cannot be owner: disqualified", 3);
        return false;
      }
    } else if( $c["owner"] == 3 ) {
      // here there must be no owner
      if( $ticket["user_id"] ) {
        $this->addDebug('actionApplicable', "[{$action}]Ticket cannot be owned: disqualified", 3);
        return false;
      }
    } else if( $c["owner"] == 4 ) {
      // here it must be owned and we must not be
      // the owner
      if( !$ticket["user_id"] || $ticket["user_id"] == $user_id ) {
        $this->addDebug('actionApplicable', "[{$action}]Ticket must be owned and cannot be the owner: disqualified", 3);
        return false;
      }
    } else if( $c["owner"] == 5 ) {
      // here we must be the owner, or it is unowned
      if( $ticket["user_id"] && $ticket["user_id"] != $user_id ) {
        $this->addDebug('actionApplicable', "[{$action}]Must be owner or unowned: disqualified", 3);
        return false;
      }
    } else if( $c["owner"] > 0 ) {
      // here we must be the owner (or there is an override)
      // see if we can override this
      // if so, we need to find out if we are a super
      if( $c["override"] ) {
        $user = $this->get_user($user_id);
        $access = $this->getAccess($user_id);
      }
      // if we aren't the owner, check special conditions
      // then return false if not met
      if( $ticket["user_id"] != $user_id ) {
        if( !$c["override"] 
            || ( strlen($access["$bin_id"]) 
                 && $access["$bin_id"] < $this->getSetting("level_super") )
            || ( !strlen($access["$bin_id"]) 
                 && $user["access_level"] < $this->getSetting("level_super") )
                 ) {
          $this->addDebug('actionApplicable', "[{$action}]must be owner or meet override", 3);                   
          return false;
        }
      }
    }
    // check to see if there is an access requirement
    if( $c["access"] > 0 ) {
      if( !$this->checkAccess($user_id, $bin_id, $action) )  {
        $this->addDebug('actionApplicable', "[{$action}]Check access failed: disqualified", 3);
        return false;
      }
    }
    // check to see if there is a status requirement
    if( is_array($c["status"]) ) {
      if( !in_array($ticket["status"],$c["status"]) ) {
        $this->addDebug('actionApplicable', "[{$action}]Status '{$ticket['status']}' not in (".join(',',$c['status'])."): disqualified", 3);
        return false;
      }
    }
    // special conditions if it's an approval
    if( $action == "approve" 
      && ($ticket["tested"] == 1 || $ticket["approved"] != 1) ) {
      $this->addDebug('actionApplicable', "[{$action}]Not flagged for approval: disqualified", 3);
      return false;  // it needs testing first
    }
    else if( $action == "reject" && !$this->getTicketSender($id) ) {
      $this->addDebug('actionApplicable', "[{$action}]No one to reject to: disqualified", 3);
      return false;  // there's no one to reject to
    }
    else if( $action == "test" && $ticket["tested"] != 1 ) {
      $this->addDebug('actionApplicable', "[{$action}]Not flagged for testing: disqualified", 3);
      return false;  // ticket doesn't require testing
    }
    // all checks passed, return true
    $this->addDebug('actionApplicable', "[{$action}] qualified", 3);
    return true;
  }

  function listValidActions( $ticket_id, $user_id ) {
    // returns a complete list of actions which are valid for the given ticket
    // the entire ticket can be passed as an array in $ticket_id
    // to save an extra database lookup
    $actions = $this->getActions();
    $valid = array();
    foreach($actions as $k=>$v) {
      if( $this->actionApplicable($ticket_id,$k,$user_id) ) {
        $valid["$k"] = $v;
      }
    }
    return $valid;
  }

  /**
   ** returns a list of valid activities for logs
   **
   ** @return array of activities (strings)
   */
  function getActivities() {
    return $this->getTasks();
  }

  function getActions() {
    // actions array contains the following params
    //   "level"   - required access level to perform action 
    //   "owner"   - must be owner of ticket
    //                0 - false
    //                1 - true
    //                2 - must NOT be owner
    //                3 - must not be owned by anyone
    //                4 - must be owned, and must not be owner
    //                5 - must be owner, or not owned by anyone
    //   "access"   - must meet checkAccess
    //   "status"   - ticket status
    //   "override" - supervisor override?     
    // this array is sorted by key
    if( !$this->actions ) {
      $actions = array();
      $actions['contacts'] = array(
                                 "owner"    => 0, 
                                 "access"   => 0, 
                                 "status"   => null,
                                 "override" => 0,
                                 "egate"    => 0,
                                 "img"      => null,
                                 "label"    => null,
                                 "button"   => null,
                                 "key"      => null,
                                 "level"    => $this->getSetting("level_view")
                                 );                                  
      $actions["accept"] = array( 
                                 "owner"    => 3, 
                                 "access"   => 1, 
                                 "status"   => array('OPEN'),
                                 "override" => 0,
                                 "egate"    => 1,
                                 "img"      => 'arrow_green_down.png',
                                 "label"    => tr('Accept'),
                                 "button"   => 1,
                                 "key"      => 'A',
                                 "level"    => $this->getSetting("level_accept")
                                 );
      $actions["approve"] = array( 
                                  "owner"    => 0, 
                                  "access"   => 1, 
                                  "status"   => array('PENDING'),
                                  "override" => 0,
                                  "egate"    => 1,
                                  "img"      => 'flag_green.png',
                                  "label"    => tr('Approve'),
                                  "button"   => 1,
                                  "key"      => 'V',
                                  "level"    => $this->getSetting("level_approve")
                                  );
      $actions["assign"] = array(
                                 "owner"    => 5,
                                 "access"   => 1,
                                 "status"   => array('OPEN'),
                                 "override" => 0,
                                 "egate"    => 1,
                                 "img"      => 'two_people.png',
                                 "label"    => tr('Assign'),
                                 "button"   => 1,
                                 "key"      => 'S',
                                 "level"    => $this->getSetting("level_assign")
                                 );
      $actions["close"] = array(
                                "owner"    => 1,
                                "access"   => 1,
                                "status"   => array('OPEN'),
                                "override" => 1,
                                "egate"    => 1,
                                "img"      => 'box_gold.png',
                                "label"    => tr('Close'),
                                "button"   => 1,
                                "key"      => 'C',
                                "level"    => $this->getSetting("level_user")
                                );
      $actions["create"] = array(
                                 "owner"    => 0,
                                 "access"   => 1,
                                 "status"   => null,
                                 "override" => 0,
                                 "egate"    => 1,
                                 "img"      => "",
                                 "label"    => tr('Create'),
                                 "button"   => 0,
                                 "key"      => null,
                                 "level"    => $this->getSetting("level_create")
                                 );
      $actions["delete"] = array(
                               "owner"    => 0,
                               "access"   => 1,
                               "status"   => null,
                               "override" => 0,
                               "egate"    => 0,
                               "img"      => "trash.png",
                               "label"    => tr("Delete"),
                               "button"   => 0,
                               "key"      => null,
                               "level"    => $this->getSetting('level_settings')
                               );
      $actions["edit"] = array(
                               "owner"    => 0,
                               "access"   => 1,
                               "status"   => array('OPEN','PENDING'),
                               "override" => 0,
                               "egate"    => 0,
                               "img"      => "pin_blue.png",
                               "label"    => tr('Edit'),
                               "button"   => 1,
                               "key"      => 'D',
                               "level"    => $this->getSetting("level_edit")
                               );
      $actions["email"] = array(
                                "owner"    => 0,
                                "access"   => 1,
                                "status"   => null,
                                "override" => 0,
                                "egate"    => 1,
                                "img"      => "mail.png",
                                "label"    => tr('Email'),
                                "button"   => 1,
                                "key"      => 'E',
                                "level"    => $this->getSetting("level_view")
                                );
      $actions["estimate"] = array(
                                   "owner"    => 1,
                                   "access"   => 1,
                                   "status"   => array('OPEN'),
                                   "override" => 1,
                                   "egate"    => 1,
                                   "img"      => "clock.png",
                                   "label"    => tr('Estimate'),
                                   "button"   => 0,
                                   "key"      => null,
                                   "level"    => $this->getSetting("level_user")
                                   );
      $actions["log"] = array(
                              "owner"    => 0,
                              "access"   => 1,
                              "status"   => array('OPEN','PENDING'),
                              "override" => 1,
                              "egate"    => 1,
                              "img"      => "book_blue.png",
                              "label"    => tr('Log'),
                              "button"   => 1,
                              "key"      => 'L',
                              "level"    => $this->getSetting("level_user")
                              );
      $actions["move"] = array(
                               "owner"    => 1,
                               "access"   => 1,
                               "status"   => array('OPEN','PENDING'),
                               "override" => 1,
                               "egate"    => 1,
                               "img"      => "arrow_blue_right.png",
                               "label"    => tr('Move'),
                               "button"   => 1,
                               "key"      => 'M',
                               "level"    => $this->getSetting("level_move")
                               );
      // add an entry to notify list
      // used exclusively by egate system
      // use 'notify' for all permissions
      $actions["notify_add"] = array(
                                     "owner"    => 0,
                                     "access"   => 1,
                                     "status"   => array('OPEN','PENDING'),
                                     "override" => 0,
                                     "egate"    => 1,
                                     "img"      => "",
                                     "label"    => tr('Add to Notify'),
                                     "button"   => 0,
                                     "key"      => null,
                                     "level"    => $this->getSetting("level_view")
                                     );
      // drop an entry from the notify list
      // used exclusively by the egate system
      // use 'notify' for all permissions
      $actions["notify_drop"] = array(
                                      "owner"    => 0,
                                      "access"   => 1,
                                      "status"   => array('OPEN','PENDING'),
                                      "override" => 0,
                                      "egate"    => 1,
                                      "img"      => "",
                                      "label"    => tr('Drop From Notify'),
                                      "button"   => 0,
                                      "key"      => null,
                                      "level"    => $this->getSetting("level_view")
                                      );
      // used to modify the list of recipients in
      // ticket's notify list
      $actions["notify"] = array(
                                 "owner"    => 1,
                                 "access"   => 1,
                                 "status"   => array('OPEN','PENDING'),
                                 "override" => 1,
                                 "egate"    => 0,
                                 "img"      => "",
                                 "label"    => tr('Notify List'),
                                 "button"   => 0,
                                 "key"      => null,
                                 "level"    => $this->getSetting("level_user")
                                 );
      $actions["print"] = array(
                                "owner"    => 0,
                                "access"   => 1,
                                "status"   => null,
                                "override" => 0,
                                "egate"    => 0,
                                "img"      => "printer.png",
                                "label"    => tr('Print'),
                                "button"   => 1,
                                "key"      => 'P',
                                "level"    => $this->getSetting("level_view")
                                );
      $actions["yank"] = array(
                               "owner"    => 4,
                               "access"   => 1,
                               "status"   => null,
                               "override" => 0,
                               "egate"    => 0,
                               "img"      => "arrow_blue_up.png",
                               "label"    => tr('Pull'),
                               "button"   => 1,
                               "key"      => 'U',
                               "level"    => $this->getSetting("level_yank")
                               );
      $actions["reject"] = array(
                                 "owner"    => 1,
                                 "access"   => 1,
                                 "status"   => array('OPEN','PENDING'),
                                 "override" => 0,
                                 "egate"    => 1,
                                 "img"      => "flag_red.png",
                                 "label"    => tr('Reject'),
                                 "button"   => 1,
                                 "key"      => 'R',
                                 "level"    => $this->getSetting("level_user")
                                 );
      $actions["relate"] = array(
                                 "owner"    => 0,
                                 "access"   => 1,
                                 "status"   => null,
                                 "override" => 0,
                                 "egate"    => 0,
                                 "img"      => "tree.png",
                                 "label"    => tr('Relate'),
                                 "button"   => 1,
                                 "key"      => 'X',
                                 "level"    => $this->getSetting("level_user")
                                 );
      $actions["reopen"] = array(
                                 "owner"    => 0,
                                 "access"   => 1,
                                 "status"   => array('PENDING','CLOSED'),
                                 "override" => 0,
                                 "egate"    => 0,
                                 "img"      => "arrow_blue_left.png",
                                 "label"    => tr('Reopen'),
                                 "button"   => 1,
                                 "key"      => 'O',
                                 "level"    => $this->getSetting("level_user")
                                 );
      $actions["test"] = array(
                               "owner"    => 0,
                               "access"   => 1,
                               "status"   => array('PENDING'),
                               "override" => 1,
                               "egate"    => 1,
                               "img"      => "flag_blue.png",
                               "label"    => tr('Test'),
                               "button"   => 1,
                               "key"      => 'T',
                               "level"    => $this->getSetting("level_test")
                               );
      $actions["upload"] = array(
                                 "owner"    => 1,
                                 "access"   => 1,
                                 "status"   => null,
                                 "override" => 1,
                                 "egate"    => 0,
                                 "img"      => "arrow_blue_up.png",
                                 "label"    => tr('Upload'),
                                 "button"   => 0,
                                 "key"      => '',
                                 "level"    => $this->getSetting("level_user")
                                 );
      $actions["view"] = array(
                               "owner"    => 0,
                               "access"   => 1,
                               "status"   => null,
                               "override" => 0,
                               "egate"    => 1,
                               "img"      => "magnify.png",
                               "label"    => tr('View'),
                               "button"   => 0,
                               "key"      => '',
                               "level"    => $this->getSetting("level_view")
                               );
      $actions["varfield_edit"] = array(
                                        "owner"    => 1,
                                        "access"   => 1, 
                                        "status"   => array('OPEN','PENDING'),
                                        "override" => 1,
                                        "egate"    => 0,
                                        "img"      => "pn_blue.png",
                                        "label"    => tr('Edit'),
                                        "button"   => 0,
                                        "key"      => '',
                                        "level"    => $this->getSetting("level_edit_varfields")
                                        );
      $this->actions = $actions;
    }
    return $this->actions;
  }   

  function getBinName($id) {
    // returns the name of a bin
    // from the given bin id
    $bins = $this->getBins(0,0);
    return( isset($bins["$id"])? $bins["$id"] : "" );
  }
  
  function getSystemName($id) {
    // returns the name of a system
    // from the given system id
    $systems = $this->getSystems(0,0);
    return( isset($systems["$id"])? $systems["$id"] : "" );
  }
  
  function getPriorityName($id) {
    // returns the name of a priority
    // from the given priority id
    $priorities = $this->getPriorities(0,0);
    return( isset($priorities["$id"])? $priorities["$id"] : "" );
  }
  
  /**
   * Returns a single custom field definition
   */
   function getCustomField( $field_name ) {
     // this lookup is cached, so it is not expensive
     $vals = $this->getCustomFields(2);
     return $vals["$field_name"];
   }

  /**
   * returns information about custom fields definition
   *
   * Returns an array with information about custom fields definition
   * ordered by sort_order and field_label
   * 
   * The filterUse variable is used to filter for fields which apply only
   * to tickets or projects, and the filterShow variable is used to filter
   * for fields which only appear in certain areas (such as the search screen).
   *
   * @param int $indexedMode if set, returns the field_label indexed by field_name, otherwise all data is returned
   * @param string $filterUse "P"roject, "T"icket or blank
   * @param string $filterShow "S"earch, "L"ist, "C"ustom, "D"etail, "N"ew Ticket Screen, or blank
   * @return array of custom fields
   */
  function getCustomFields($indexedMode = 1, $filterUse = "", $filterShow = "") {
    // try to retrieve from memory first
    $vars = $this->_session->getCustomFields();
    if( !is_array($vars) ) {
      $query = "SELECT * FROM ".$this->table_varfield_idx." ORDER BY sort_order, field_label";
      $this->addDebug("getCustomFields", "Generating variable fields: ".$query, 3);
      
      // all columns from db, indexed by field name
      $vars = $this->db_queryIndexed($query);
      
      // store session vals
      $this->_session->storeCustomFields($vars);
    }
    
    // if this is the default set, we are done
    if( !$indexedMode && !strlen($filterUse) && !strlen($filterShow) ) {
      return $vars;
    }

    // try to retrieve the subset from the global cache
    $key = "$indexedMode:$filterUse:$filterShow";
    $vals = $this->_session->getDataCache('customset',$key);
    if( $vals ) { return $vals; }
    
    // now retrieve the specific values desired and return
    $vals = array();
    $use = $filterUse? strtoupper(substr($filterUse,0,1)) : '';
    $show = $filterShow? strtoupper(substr($filterShow,0,1)) : '';
    for($i=0; $i<count($vars); $i++) {
      $v = $vars[$i];
      // we filter based on whether this custom field is used
      // in tickets or projects
      if( $use == 'P' && $v['use_for_project'] < 1 ) { continue; }
      if( $use == 'T' && $v['use_for_ticket'] < 1 ) { continue; }
      if( $show == 'S' && $v['show_in_search'] < 1 ) { continue; }
      if( $show == 'L' && $v['show_in_list'] < 1 ) { continue; }
      if( $show == 'C' && $v['show_in_custom'] < 1 ) { continue; }
      if( $show == 'D' && $v['show_in_detail'] < 1 ) { continue; }
      if( $show == 'N' && $v['show_in_new'] < 1 ) { continue; }
      
      // create the appropriate array values
      if ( $indexedMode == 1 ) {
        // indexed key=>label pairs
        $vals["{$v['field_name']}"] = $v['field_label'];
      }
      else if( $indexedMode == 2 ) {
        $vals["{$v['field_name']}"] = $v;
      }
      else {
        $vals[] = $v;
      }
    }
    
    // store our set in globals for the time
    // this is particularly useful when calling rows one at a time
    $this->_session->storeDataCache('customset',$key,$vals);
    
    return( $vals );
  }

  /**
   * returns information about available bins
   *
   * if flag is set, retrieves a full
   * indexed array, otherwise, just
   * a list of names, indexed by bid,
   * ordered by priority and alphebetized 
   * set $active to zero to retrieve 
   * the bins which are disabled as well
   * the main reason for this method is that we will be updating
   * the structure of the settings before long to become more rigid.
   *
   * @param int $flag 1=return full info, 0=returns array( "bin_id" => "name" )
   * @param int $active 1=only active bins, 0=all bins
   * @return array of bins
   */
  function getBins($flag = 0,$active = 1) {
    if( !$flag ) {
      // try loading from session
      $vals = $this->_session->getDataType('bins');
      if( $vals ) { return $vals; }
      
      // query database if needed
      $query = "SELECT bid, name FROM ".$this->table_bins;
      if( $active )
        $query .= " WHERE active = $active";
      $vars = $this->db_query($query." ORDER BY priority DESC, name");
      foreach($vars as $v) {
        $vals["$v[0]"] = $v[1];
      }
      
      // store in session before we finish
      $this->_session->storeDataType('bins',$vals);
      return($vals);
    } else {
      // never store or retrieve complete info from session
      $query = "SELECT * FROM ".$this->table_bins;
      if( $active )
        $query .= " WHERE active = $active";
      $query .= " ORDER BY priority DESC, name";
      return( $this->db_queryIndexed($query) );
    }
  }
  
  /**
   * returns whether a zen->getSetting("field") is an On/Off type
   *
   * the main reason for this method is that we will be updating
   * the structure of the settings before long to become more rigid.
   *
   * @param string $field the name of field in settings
   * @return boolen yes or no
   */
  function isOnOffSetting( $field ) {
    $v = $this->getSetting($field);
    return ($v == "on" || $v == "off");
  }

  /**
   * returns whether this field is a date format
   *
   * the main reason for this method is that we will be updating
   * the structure of the settings before long to become more rigid.
   *
   * @param string $field the name of field in settings
   * @return boolen yes or no
   */
  function isDateFormatSetting( $field ) {
    return ($field == "default_start_date" || $field == "default_deadline");
  }

  /**
   * returns default values for fields set in configuration settings
   *
   * @param string $field name of setting to check
   * @return string value to insert into form
   */
  function getDefaultValue( $field ) {
    if( $this->isDateFormatSetting($field) ) {
      // make a date
      $val = $this->getSetting($field)?
        strtotime($this->getSetting($field)) : "";
    }
    else if( $this->isOnOffSetting($field) ) {
      // tell whether its checked
      $val = $this->settingOn($field)? " checked " : "";
    } else {
      // there isn't one, so return the actual value
      $val = $this->getSetting($field);
    }
    return $val;
  }

  function checkRelations( $relations, $id = '' ) {
    // takes either an array or comma delimited
    // string.  insures that the tickets to be 
    // related actually exist and returns only
    // the ids that are in db

    if( !is_array($relations) ) {
      $join = 1;
      $relations = ereg_replace("[^0-9,]", "", $relations);
      $relations = explode(",",$relations);
    }
    foreach($relations as $r) {
      if( !$id || ($id && $r != $id) ) {
        if( $this->get_ticket($r) ) {
          $vals[] = $r;
        }
      }
    }
    if( $join ) {
      return( join(",",$vals) );
    } else {
      return( $vals );
    }
  }

  function getRoleName($id) {
    // returns the name
    // for a given role id
    $roles = $this->getRoles();
    return $roles["$id"]["name"];
  }

  function getRoleID($name) {
    // returns the id for
    // a given role name
    $roles = $this->getRoles();
    foreach($roles as $k=>$v) {
      if( strtolower($v["name"]) == strtolower($name) )
        return $k;
    }
    $this->addDebug("getRoleID","role '$name' wasn't found!", 1);
  }

  function getRoles($active = 1) {
    // planning for the future
    // we will probably want to add these
    // to the database
    // to make them customizeable and
    // available for triggers and flowpaths
    return array(
                 "1"=>array("role_id"=>1,"name"=>"Manager"),
                 "2"=>array("role_id"=>2,"name"=>"Tester")
                 );
  }

  function getTasks($flag = 0,$active = 1) {
    // if flag is set, retrieves an
    // indexed array, otherwise, just
    // a list of names ordered by priority
    // and alphebetized      

    if( !$flag ) {
      // try loading from session
      $vals = $this->_session->getDataType('tasks');
      if( $vals ) { return $vals; }

      $query = "SELECT task_id, name, priority FROM ".$this->table_tasks;
      if( $active )
        $query .= " WHERE active = $active";
      $vars = $this->db_query($query." ORDER BY priority DESC, name");
      if( is_array($vars) ) {
        foreach($vars as $v) {
          $vals["$v[0]"] = $v[1];
        }
      }
      
      // place in session before we finish
      $this->_session->storeDataType('tasks',$vals);
      
      return $vals;
    } else {
      $where = ($active)? " WHERE active = $active" : "";
      $query = "SELECT * FROM ".$this->table_tasks." $where ORDER BY priority DESC, name";
      return( $this->db_queryIndexed($query) );
    }
  }

  function getSystems($flag = 0,$active = 1) {
    // if flag is set, retrieves an
    // array, ordered by priority and
    // alphebatized, otherwise, just
    // an array of names indexed by id

    if( !$flag ) {
      // try loading from session
      $vals = $this->_session->getDataType('systems');
      if( $vals ) { return $vals; }

      $query = "SELECT sid, name FROM ".$this->table_systems;
      if( $active )
        $query .= " WHERE active = $active ORDER BY priority DESC, name";
      $vars = $this->db_query($query);
      if( is_array($vars) ) {
        foreach($vars as $v) {
          $vals["$v[0]"] = $v[1];
        }
      }
      
      // store in session
      $this->_session->storeDataType('systems',$vals);
      
      return($vals);
    } else {
      $where = ($active)? " WHERE active = $active" : "";
      $query = "SELECT * FROM ".$this->table_systems." $where ORDER BY priority DESC, name";
      return( $this->db_queryIndexed($query) );
    }            
  }

  function getPriorities( $flag = 0, $active = 1 ) {
    // if flag is set, retrieves all
    // details in an unordered list
    // otherwise, retrieves an indexed
    // list sorted by priority

    if( !$flag ) {
      // try loading from session
      $vals = $this->_session->getDataType('priorities');
      if( $vals ) { return $vals; }
      
      $query = "SELECT pid,priority,name FROM ".$this->table_priorities;
      if( $active )
        $query .= " WHERE active = $active";
      $vars = $this->db_query($query." ORDER BY priority DESC, name");
      for($i=0; $i<count($vars); $i++) {
        $p = $vars[$i][0];
        $vals["$p"] = $vars[$i][2];
      }
      
      // store in session
      $this->_session->storeDataType('priorities',$vals);
      
      return($vals);
    } else {
      $where = ($active)? " WHERE active = $active" : "";
      $query = "SELECT * FROM ".$this->table_priorities." $where ORDER BY priority DESC, name";
      return( $this->db_queryIndexed($query) );
    }            
  }

  function statusHighlight( $priority ) {
    // prints out status with proper <span>
    // tags to highlight critical status items

    if( $priority <= $this->getSetting("level_hot") ) {
      $pri = "hot";
    } else if( $priority <= $this->getSetting("level_highlight") ) {
      $pri = "highlight";
    } else {
      $pri = "";
    }
    return $pri;
  }
  
  /**
   * Returns the value of a configuration setting
   *
   * @param string key the name of the setting to return
   * @param string value could be null
   */
  function getSetting( $key ) {
    $settings = $this->getSettings();
    if( is_array($settings) && array_key_exists("$key", $settings) ) {
      return $settings["$key"];
    }
    else {
      $this->addDebug('getSetting', "Setting not found for ".$key, 2);
      return null;
    }
  }
  
  function getSettings($flag = 0) {
    // pulls the variables from the settings table
    // into an indexed array.
    // if flag is set, then it retrieves all
    // data for the settings into an array
    // otherwise, just sets a string equal to the value
    
    // attempt to retrieve from the session if possible
    if( !$flag ) {
      if( $this->_settings ) { return $this->_settings; }
      $settings = $this->_session->getDataType('settings');
      if( $settings ) { 
        $this->_settings = $settings;
        return $settings;
      }
    }
    
    // load from the database
    global $rootUrl;
    $fields = ($flag)? "*" : "name, value";
    if( $flag )
      $order = " ORDER BY name";
    else
      $order = "";
    $query = "SELECT $fields FROM ".$this->table_settings." $order";
    $vars = $this->db_queryIndexed($query);
    foreach($vars as $v) {
      if( isset($rootUrl) && $rootUrl != "" ) {
        if( preg_match("@^url_@",$v["name"]) ) {
          if(preg_match("@/$@", $rootUrl) && preg_match("@^/@", $v["value"]) ) {
            preg_replace("@/$@", $rootUrl) . $v["value"];
          } else if( !preg_match("@/$@", $rootUrl) 
                     && !preg_match("@^/@", $v["value"]) ) {
            $v["value"] = $rootUrl ."/".$v["value"];    
          } else {
            $v["value"] = $rootUrl . $v["value"];
          }
        }
      }
      $vals["{$v['name']}"] = ($flag)? $v : $v["value"];
    }
    
    $this->addDebug('getSettings', "Retrieved ".count($vals)." settings from database", 3);
    
    // store vals in session
    if( !$flag ) {
      $vals["font_size_small"] = $vals["font_size"] - 2;
      $vals["font_size_large"] = $vals["font_size"] + 4;
      $vals["color_title_txt"] = $vals["color_title_text"];
      $this->_session->storeDataType('settings',$vals);
      $this->_settings = $vals;
    }
    return($vals);
  }
  
  function settingOn( $setting_name ) {
    return $this->getSetting($setting_name) == "on";
  }
  
  function hasSetting( $setting_name ) {
    return strlen($this->getSetting($setting_name));
  }

  function getTypeName($id) {
    // retrieves the name of the type
    // with the given id
    $types = $this->getTypes();
    return( array_key_exists("$id", $types)? $types["$id"] : "" );
  }

  function getTypes($flag = 0, $active = 1) {
    // if flag is not set, retrieves an
    // indexed array, otherwise, just
    // a list of names ordered by priority
    // and alphebetized
    if( !$flag ) {
      // try loading from session
      $vals = $this->_session->getDataType('types');
      if( $vals ) { return $vals; }
      
      $query = "SELECT type_id,name FROM ".$this->table_types;
      if( $active )
        $query .= " WHERE active = $active ORDER BY priority DESC, name";
      $vars = $this->db_query($query);
      if( is_array($vars) ) {
        foreach($vars as $v) {
          $vals["$v[0]"] = $v[1];
        }
      }
      
      // store in session
      $this->_session->storeDataType('types',$vals);
      return($vals);
    } else {
      $where = ($active)? " WHERE active = $active" : "";
      $query = "SELECT * FROM ".$this->table_types." $where ORDER BY priority DESC, name";
      return( $this->db_queryIndexed($query) );
    }
  }

  function getProjectChildren( $pid, $columns = '', $archive_flag = 0, $sort = "status desc, priority desc, otime desc" ) {
    // returns array of tickets for the project by its pid ($pid)
    // this is seperated from the get_tickets() for abstraction
    // (i.e. future expansion compatability)
    // the returned values of getProjectChildren() will always be
    // unsorted if using $columns (sorry!)

    $pid = $this->checkNum($pid);
    $params = array("project_id"=>$pid);
    $vars = $this->get_tickets($params, $sort, $columns, -1);
    $this->addDebug('getProjectChildren', "pid=$pid, columns=$columns, sort=$sort, results=".count($vars), 3);
    return( $vars );
  }

  function getTicketHours( $id ) {
    // returns a total count of the number of hours associated with this ticket
    // if you just want the estimated and actual worked, and none of the sub-tickets
    // then just use get_ticket and look at those columns directly

    $id = $this->checkNum($id);
    $ticket = $this->get_ticket($id);
    $est_hours = $ticket["est_hours"];
    $ext_hours = $ticket['wkd_hours'];
    $wkd_hours = $ext_hours>$est_hours? $est_hours : $ext_hours;

    // get the children for this project
    if( $this->inProjectTypeIDs($ticket['type_id']) ) {
      $columns = array("id","est_hours","wkd_hours","type_id");
      $children = $this->getProjectChildren($id,$columns,$archive_flag);
      if( is_array($children) ) {
        for( $i=0; $i<count($children); $i++ ) {
          list($e,$w,$x) = $this->getTicketHours($children[$i]["id"]);
          $est_hours += $e;
          $wkd_hours += $w;
          $ext_hours += $x;
        }
      }
    }
    $this->addDebug("getTicketHours","Retrieving hours for $id, with ".count($children)
                    ." children: $est_hours, $wkd_hours, $ext_hours",3);
    return( array($est_hours,$wkd_hours,$ext_hours) );   
  }

  function getProjectHours( $pid, $archive_flag = 0 ) {
    // alias to getTicketHours
    // just to keep things sane, for now
    $pid = $this->checkNum($pid);
    return $this->getTicketHours($pid);
  }   

  function getTicketSender( $id ) {
    $id = $this->checkNum($id);
    $query = "SELECT user_id,bin_id FROM "
      .$this->table_logs
      ." WHERE ticket_id = $id"
      ." AND (action = 'MOVED' OR action = 'ASSIGNED' OR action = 'CREATED')"
      ." ORDER BY created DESC";
    $vars = $this->db_quickIndexed($query);      
    if( count($vars) ) {
      $this->addDebug("getTicketSender",join(",",$vars)."/".$query,3);
    } else {
      $this->addDebug("getTicketSender","couldn't find sender/".$query,2);
    }
    return $vars;
  }

  function projectTypeID() {
    // returns the type id associated with projects
    // this function prevents multiple calls for this
    // id by storing it the first time it is called
    // if $val is provided, returns true/false whether
    // $val is a project type id
    if( !strlen($this->projectTypeID) ) {
      $this->projectTypeID = null;
      foreach( $this->getTypes() as $k=>$b ) {
	if( preg_match("@project@i",$b) ) {
	  $this->projectTypeID = $k;
	  break;
	}
      }
    }
    return $this->projectTypeID;
  }

  function projectTypeIDs() {
    // returns the type id associated with projects
    // this function prevents multiple calls for this
    // id by storing it the first time it is called
    // if $val is provided, returns true/false whether
    // $val is a project type id
    if( !is_array($this->projectTypeIDs) ) {
      $this->projectTypeIDs = array();
      foreach( $this->types as $k=>$b ) {
        if( preg_match("@project@i",$b) ) {
          $this->projectTypeIDs[] = $k;
        }
      }
    }
    return $this->projectTypeIDs;
  }

  function notProjectTypeIds() {
    $vars = array();
    foreach( $this->getTypes() as $k=>$v ) {
      if( !preg_match("@project@i",$v) ) {
        $vars[] = $k;
      }
    }
    return $vars;
  }

  function inProjectTypeIDs($type_id) {
    if( is_array($type_id) ) {
      // handle arrays by checking each value seperately
      foreach($type_id as $t) {
        if( !$this->inProjectTypeIDs($t) ) {
          return false;
        }
      }
      return true;
    }
    // determines whether the id provided
    // is a valid project id
    // and returns true or false
    return( in_array($type_id,$this->projectTypeIDs()) );
  }

  function noteTypeIDs( ) {
    // returns the bin id associated with note
    // types for use with the auto-close function
    if( !is_array($this->noteTypeID) ) {
      $this->noteTypeID = array();
      foreach( $this->types as $k=>$b ) {
        if( preg_match("@note@i",$b) ) {
          $this->noteTypeID[] = $k;
        }
      }
    }
    return $this->noteTypeID;
  }

  /*
   *  INVOKE 
   */


  function zenTrack( $file, $language = '' ) {
    // $file is the configuration file
    // containing all of the settings for
    // zenTrack to use during operation
    // $user is the logged in userid for this
    // user.  If given, then the user will be retrieved
    // and saved for use in other methods (to
    // prevent multiple queries)
    // if $language is given, it will override the value
    // from the configVars file
    
    include("$file");

    $this->zen();
    $this->_session = new ZenSessionManager($this);
    $this->DB( $this->database_host, $this->database_login, 
               $this->database_password, $this->database_instance);

    $this->bins        = $this->getBins();
    $this->systems     = $this->getSystems();
    //$this->strings     = $this->getStrings($this->language);
    $this->getSettings();
    $this->_settings = false;

    $this->types       = $this->getTypes();
    $this->priorities  = $this->getPriorities();
    $this->tasks       = $this->getTasks();
    $this->custom_fields = $this->getCustomFields(1);

    // set the date formatting
    $this->date_fmt_long  = $this->getSetting("date_fmt_long");
    $this->date_fmt_short = $this->getSetting("date_fmt_short");
    $this->time_fmt       = $this->getSetting("date_fmt_time");
    $this->elapsed_unit   = $this->getSetting("time_elapsed_unit");
    $this->date_and_time  = $this->date_fmt_short." ".$this->time_fmt;
    $this->euroEnabled    = $this->settingOn("use_euro_date");

    // set language params
    $this->language       = ($language)? $language : $this->getSetting("language_default");

    // cache length
    $this->cache_time = $this->getSetting("sql_cache_time");

  }


  /*
   *  REPORTING FUNCTIONS
   */     

  /**
   * retrieves a list of report templates, bin_id and user_id are
   * both optional, and can be arrays.
   */
  function getReportTemplates( $bin_id = '', $user_id = '' ) {
    if( $bin_id ) { $bin_id = $this->checkNum($bin_id); }
    if( $user_id ) { $user_id = $this->checkNum($user_id); }
    $query = "SELECT DISTINCT i.report_id,r.report_name FROM "
      .$this->table_reports_index
      ." i,".$this->table_reports." r WHERE i.report_id = r.report_id AND ("
      ."((i.bid IS NULL OR i.bid = '') "
      ." AND (i.user_id IS NULL or i.user_id = ''))";
    if( $bin_id ) {
      $query .= (is_array($bin_id))? 
        " OR i.bid IN(".join(",",$bin_id).")" : " OR i.bid = $bin_id";
    }
    if( $user_id ) {
      $query .= (is_array($user_id))? 
        " OR i.user_id IN(".join(",",$user_id).")" : " OR i.user_id = $user_id";
    }
    $query .= ") ORDER BY r.report_name";
    $this->addDebug("getReportTemplates",$query,3);
    return $this->db_queryIndexed($query);
  }

  /**
   * saves a report format
   * from the temporary templates
   * to the permanent database
   * $bins is optional list of bins who can view report
   * $users is optional list of users who can view report
   */
  function saveReport( $name, $temp_id, $bins = '', $users = '' ) {
    $temp_id = $this->checkNum($temp_id);
    // get the params
    $params = $this->getTempReport($temp_id);
    if( !is_array($params) || !count($params) )
      return false;
    // get rid of extra tempid info
    unset($params["created"]);
    unset($params["report_id"]);
    $params["report_name"] = $name;
    $res = $this->db_insert($this->table_reports,$params);
    // add indexes to bins
    $t = $this->table_reports_index;
    if( $res && is_array($bins) ) {
      foreach($bins as $v) {
        $this->db_result("INSERT INTO $t (report_id,bid) VALUES($res,$v)");
      }
    }
    // add indexes to users
    if( $res && is_array($users) ) {
      foreach($users as $v) {
        $this->db_result("INSERT INTO $t (report_id,user_id) VALUES($res,$v)");
      }       
    }
    // return results
    return $res;
  }

  /**
   * drops a report template from the permanent database
   */
  function deleteReport( $rid ) {
    $rid = $this->checkNum($rid);
    $query = "DELETE FROM ".$this->table_reports." WHERE report_id = $rid";
    return $this->db_result($query);
  }

  /**
   * adds a report format to the
   * temporary database
   */
  function addTempReport( $params ) {
    $params["created"] = $this->dateSQL();
    $this->cleanTempReports($this->cleanTempReports);
    return $this->db_insert($this->table_reports_temp,$params);
  }

  /**
   * removes old temporary reports from 
   * the database
   */
  function cleanTempReports( $days ) {
    $date = $this->dateSQL(strtotime("-$days days"));
    $query = "DELETE FROM ".$this->table_reports_temp." WHERE created < '$date'";
    $this->addDebug("cleanTempReports",$query,3);
    return $this->db_result($query);
  }

  /**
   * retrieves all properties for a temporary
   * report by the id
   */
  function getTempReport( $rid ) {
    $rid = $this->checkNum($rid);
    $query = "SELECT * FROM ".$this->table_reports_temp." WHERE report_id = $rid";
    return $this->db_quickIndexed($query);
  }

  /**
   * retrieves all properties for a permanent
   * report by the id
   */
  function getReportParams( $rid ) {
    $rid = $this->checkNum($rid);
    $query = "SELECT * FROM ".$this->table_reports." WHERE report_id = $rid";
    return $this->db_quickIndexed($query);
  }

  function reportActivity($params) {
    // returns a set of data to be graphed on the report
    // will be a count of entries matching given criteria
    // $params is a complex array (see db.class->complexWhere)     
    // any field from ZENTRACK_LOGS table may be used in the params
    // clause.. if not given, matches all activity between start and end
    // you will need to provide a date range or it will probably be a massive and
    // hardly useful report
    list($tables,$where) = $this->reportLogQuery($params);
    $query = "SELECT count(*) FROM $tables $where ORDER BY created";
    $val = $this->db_get($query);
    if( !strlen($val) )
      $val = 0;
    $this->addDebug("reportActivity","result: $val/params:"
                    .count($params)."/$query",3);
    return $val;
  }

  function reportTickets($params) {
    // returns a set of data to be graphed on a report
    // the return will be a count of tickets matching criteria
    // $params is a complex array (see db.class->complexWhere)   
    // any field from ZENTRACK_TICKETS may be used in $params
    // note that it is probably important to include some sort
    // of date range on either the otime or ctime or use 
    // ctime >= $start and otime <= $end... otherwise
    // this could be a massive report
    list($tables,$where) = $this->reportTicketQuery($params);
    $query = "SELECT count(*) FROM $tables $where";
    $val = $this->db_get($query);
    if( !strlen($val) )
      $val = 0;
    $this->addDebug("reportTickets","result: $val/params:"
                    .count($params)."/$query",3);
    return $val;
  }

  function reportElapsed($params) {
    // returns a set of data to be graphed on a report
    // the return will be a sum of hours for the given criteria
    // $params is a complex array (see db.class->complexWhere)   
    // any field from ZENTRACK_TICKETS may be used in $params
    // you will need to provide a date range or it will probably 
    // be an unwieldy report
    $tte = 0;
    list($tables,$where) = $this->reportTicketQuery($params);
    $query = "SELECT otime,ctime FROM $tables $where";
    $vals = $this->db_queryIndexed($query);
    for($i=0; $i<count($vals); $i++) {
      $v = $vals[$i];
      if( $v["ctime"] < 1 ) {
        $v["ctime"] = $this->currTime;
      }
      $diff = $this->dateDiff($v["ctime"],$v["otime"],$this->elapsed_unit);
      $tte += $diff;
    }
    $this->addDebug("reportElapsed","result: $tte/params:".count($params)."/$query",3);
    return round($tte,1);
  }

  function reportHours($params) {
    // returns a set of data to be graphed on a report
    // the return will be a sum of hours for the given criteria
    // $params is a complex array (see db.class->complexWhere)   
    // any field from ZENTRACK_LOGS may be used in $params
    // you will probably need a date range, or it will be an
    // unwieldy report
    list($tables,$where) = $this->reportLogQuery($params);
    $query = "SELECT sum(hours) FROM $tables $where";
    $val = $this->db_get($query);
    if( !strlen($val) )
      $val = "0.00";
    $this->addDebug("reportHours","result: $val/params:"
                    .count($params)."/$query",3);
    return $val;
  }

  function reportEstimated($params) {
    // returns a set of data to be graphed on a report
    // the return will be a sum of hours for the given criteria
    // $params is a complex array (see db.class->complexWhere)   
    // any field from ZENTRACK_TICKETS may be used in $params
    // you will probably need a date range, or it will be an
    // unwieldy report
    list($tables,$where) = $this->reportTicketQuery($params);
    $query = "SELECT sum(est_hours) FROM $tables $where";
    $val = $this->db_get($query);
    if( !strlen($val) )
      $val = "0.00";
    $this->addDebug("reportEstimated","result: $val/params:"
                    .count($params)."/$query",3);
    return $val;
  }

  function reportLogQuery($params) {
    // internal use only!!
    // returns array(tables,where_clause) for
    // use by log table report functions
    $where = "WHERE ";
    $ttr = false;      // ticket table required
    $ticket_table_id = $this->get_report_id("ticket");
    $system_table_id = $this->get_report_id("system");
    $type_table_id = $this->get_report_id("type");
    $bin_table_id = $this->get_report_id("bin");
    if( $params["system_id"] ) {
      $ttr = true;
      $params["system_id"][0] = "t.system_id";
    }
    if( $params["type_id"] ) {
      $ttr = true;
      $params["type_id"][0] = "t.type_id";
    }
    $tables = $this->table_logs." l";
    if( $ttr ) {
      $where .= " t.id = l.ticket_id AND ";
      $tables .= ", ".$this->table_tickets." t";
    }
    $where .= $this->complexWhere($params,"AND");
    return array($tables,$where);
  }

  function reportTicketQuery($params) {
    // internal use only!!
    // returns array(tables,where_clause) for
    // use by ticket table report functions
    $where = "WHERE ";
    $tables = $this->table_tickets." l";
    $where .= $this->complexWhere($params,"AND");
    $where = preg_replace("@l\.ticket_id@","l.id",$where);
    return array($tables,$where);
  }

  //#####################################################
  //##  CONTACTS
  //#####################################################
  function search_Contacts( $params, $andor, $order_by, $tables) {
    //search a contact
    $where = $this->build_search_clause($params, $andor);
    
    $query = "SELECT * "
      ." FROM $tables WHERE $where"
      ." ORDER BY $order_by";
    $this->addDebug("search_Contacts","query:".$query,2);
    return(  $this->db_queryIndexed($query) );      
  } 
  
  function add_contact( $params,$tabel) {
    //insert a contact
    $id = $this->db_insert($tabel,$params);
    return $id;
  }
  
/*   function get_open_tickets($id,$type,$orderby='otime DESC') {
    // get open tickets of a contact
    
    $ids2 = array(); //arry for person ids
    $tickets = array();//array where the tickets will be stored
    $check = array();
    
    if ($type=="2"){
      $query = "SELECT ticket_id FROM " . $this->table_related_contacts . " WHERE cp_id = '".$id."' AND type ='2'";
      $this->addDebug("get_open_tickets_engine",$query,3);
      $ids = $this->db_queryIndexed($query);
    }
    
    if ($type=="1") { 
      //********get persons ids that are releated with this company
        $query = "SELECT person_id FROM " . $this->table_employee . " WHERE company_id = '".$id."'";
      $this->addDebug("get_open_tickets_engine",$query,3);
      $idemp = $this->db_queryIndexed($query);
      
      if ($idemp) {
     	foreach($idemp as $a) {
          $query = "SELECT ticket_id FROM " . $this->table_related_contacts . " WHERE cp_id = '".$a['person_id']."' AND type ='2'";
          $this->addDebug("get_open_tickets_engine",$query,3);
          $buffer = $this->db_queryIndexed($query); 
          if(!empty($buffer)) $ids2 = array_merge($buffer,$ids2);
        }
      }
      
      //get releated tickets ids
      $query = "SELECT ticket_id FROM " . $this->table_related_contacts . " WHERE cp_id = '".$id."' AND type ='1' ";
      $this->addDebug("get_open_tickets_engine",$query,3);
      $ids1 = $this->db_queryIndexed($query);
      
      $ids = array_merge($ids2,$ids1);//make 1 array of 2 arrays
    }
 	
    if ($ids) rsort ($ids);//sort the ids
    
     //get tickets of the ids
    if($ids) {
      foreach($ids as $a) {
        if (!in_array($a,$check)) {  
          $query = "SELECT * FROM " . $this->table_tickets . " WHERE id ='".$a['ticket_id']."' AND status = 'OPEN'";
          $this->addDebug("get_open_tickets_engine",$query,3);
          $buffer = $this->db_quickIndexed($query); 
          if(!empty($buffer)) $tickets[] = $buffer;//ignore empty returns
          $check[] = $a; //set for duble check 
        }
      }
    }
    
    return($tickets);
  } */
  
  /**
   * Returns a list of tickets associated with a given company
   *
   * @param int $company_id an id from the zentrack_company.company_id field
   * @param string $order_by see includes/sorting.php
   */
  function getTicketsByCompany($company_id, $sort) {
    // collect a list of tickets belonging to any contact within the current company
    // (or simply belonging to the company itself)
    $id = $this->checkNum($company_id);
    $query = "SELECT ticket_id FROM " . $this->table_related_contacts . " c, " . $this->table_employee . " e"
        ." WHERE (cp_id = '$id' AND c.type='1')"
        ." OR (c.type='2' AND c.cp_id = e.person_id AND e.company_id = '$id')";
    $ids = array_unique($this->db_list($query));
    $this->addDebug("getTicketsByCompany","[".count($ids)."]".$query,3);
    // skip query if there are no ids to retrieve
    if( !count($ids) ) { return array(); }
    // using our list of ids, call the get_tickets method normally 
    return $this->get_tickets( array('id'=>$ids), $sort );
  }
   
  /**
   * Returns a list of tickets associated with a given contact
   *
   * @param int $company_id an id from the zentrack_employee.person_id field
   * @param string $sort see includes/sorting.php
   */
  function getTicketsByPerson($person_id, $sort) {
    // collect a list of tickets matching the current contact
    $id = $this->checkNum($person_id);
    $query = "SELECT ticket_id FROM " . $this->table_related_contacts . " WHERE cp_id = '".$id."' AND type ='2'";
    $ids = array_unique($this->db_list($query));
    $this->addDebug("getTicketsByEmployee","[".count($ids)."]".$query,3);
    // skip query if there are no ids to retrieve
    if( !count($ids) ) { return array(); }
    // using our list of ids, call the get_tickets method normally 
    return $this->get_tickets( array('id'=>$ids), $sort );
  }

  function get_contact_all() {
    // get all companys for the droplists
    $query = "SELECT company_id,title,office,email FROM " . $this->table_company . " ORDER BY title asc";
    $this->addDebug("get_contact_all",$query,3);
    return( $this->db_queryIndexed($query) );
  }  
  
  function get_contact($id,$t,$c) {
    //get a single contact
    $query = "SELECT * FROM $t WHERE $c = $id";
    $vals = $this->db_quickIndexed($query);
    $this->addDebug("get_contact","[".count($vals)."]".$query,3);
    return( $vals );
  }
  
  function update_contact( $id, $params,$table,$c ) {
    //save changes    
    $set = $this->makeInsertVals($params,1);
    $query = "UPDATE $table SET $set WHERE $c = $id";
    $this->addDebug("update_contact",$query,3);
    return( $this->db_result($query) );
  }
  
  function delete_contact( $id,$table,$c) {
    //delete contact
    $where = " $c = $id";
    $query = "DELETE FROM $table WHERE $where";
    $this->addDebug("delete_contact",$query,2);
    return( $this->db_result($query) );
  }
  
  function get_contacts( $params,$tabel ,$sort = '', $columns = '') {
    //get contacts
    $columns =  array("*");
    
    if(is_array($params) && count($params)){
      foreach($params as $a) {
        if(!isset($where)) {
          $where = "WHERE lower(".$a[0].")".$a[1].$this->checkSlashes($a[2]);
        } else {
          $where.= " AND lower(".$a[0].")".$a[1].$this->checkSlashes($a[2]);
        }  
      }
    }
    $query = "SELECT ".join(",",$columns)." FROM $tabel $where";
    if( $sort )
      $query .= " ORDER BY $sort";
    $vals = $this->db_queryIndexed($query);
    $this->addDebug("get_contacts","[".count($vals)."]".$query,3);
    return( $vals );
  }
  
  
  //#####################################################
  //create link for the search 
  //#####################################################
  function create_link($SCRIPT_NAME,$TODO,$i,$search_text,$search_fields,$search_params){
    $urlp1 = $SCRIPT_NAME."?TODO=".$TODO;  
    $urlp2 = "&orderby=" .$i;
    $urlp3 = "&search_text=" .$search_text;
    if (strip_tags($search_fields["title"]) == "title"){
      $urlp4 = "&search_fields[title]=".strip_tags($search_fields["title"]);
    }
    if (strip_tags($search_fields["description"]) == "description"){
      $urlp5 = "&search_fields[description]=".strip_tags($search_fields["description"]);
    }
    $a = "";
    foreach($search_params as $k=>$v){
      $a = $a."&search_params[$k]=".strip_tags($v);
    }
    $url = $urlp1. $urlp2. $urlp3. $urlp4. $urlp5. $a; 
    return ($url);
  }
  
  // added to the url string for the navigation links.
  // This is specially important to have dynamic links,
  // so if you want to add extra options to the queries,
  // the class is going to add it to the navigation links
  // dynamically.
  //paging feature
  function build_geturl()
   {
    list($fullfile, $voided) = explode("?", $_SERVER['REQUEST_URI']);
    $cgi = $_SERVER['REQUEST_METHOD'] == 'GET' ? $_GET : $_POST;

    if( !$fullfile ) { $fullfile = $_SERVER['SCRIPT_NAME']; }
    
    foreach($cgi as $key=>$value) {
      if( $key != 'username' && $key != 'passphrase' ) {
        if( is_array($value) ) {
          foreach($value as $k=>$v) {
            if( is_array($v) ) {
              foreach($v as $k2=>$v2) {
                $query_string .= "&{$key}%5B{$k}%5D%5B{$k2}%5D={$v2}";
              }
            }
            else {
              $query_string .= "&{$key}%5B{$k}%5D={$v}";
            }
          }
        }
        else if( $key != 'pageNumber' ) {
          $query_string .= "&$key=$value";
        }
      }
    }
    return array($query_string,$fullfile);
   }

  //fucntion for adding the paging feature
  // This function creates an array of all the links for the
  // navigation bar. This is useful since it is completely
  // independent from the layout or design of the page.
  // The function returns the array of navigation links to the
  // caller php script, so it can build the layout with the
  // navigation links content available.
  //
  // $option parameter (default to "all") :
  //  . "all"   - return every navigation link
  //  . "pages" - return only the page numbering links
  //  . "sides" - return only the 'Next' and / or 'Previous' links
  //
  // $show_blank parameter (default to "off") :
  //  . "off" - don't show the "Next" or "Previous" when it is not needed
  //  . "on"  - show the "Next" or "Previous" strings as plain text when it is not needed
  function get_links($option = "all", $show_blank = "off", $total_rows = null) {
     $hk = $GLOBALS['zt_hotkeys'];
     $numtoshow = $this->getSetting("paging_max_rows");
     list($extra_vars, $file) = $this->build_geturl();
     $pageNumber = array_key_exists('pageNumber', $_GET)? 
                 $this->checkNum($_GET['pageNumber']) : 0;
     
     $array = array();
     if( !$total_rows && !$this->total_records ) { return $array; }
     else if( !$total_rows ) { $total_rows = $this->total_records; }
       
     $activePages = 10;
     $number_of_pages = ceil($total_rows/ $numtoshow);
     $subscript = 0;
     $backnos = intval($activePages/2);
     $prev = $hk->ll('Prev');
     $next = $hk->ll('Next');

     if( $number_of_pages > $activePages ) {
       // we have more pages than we will display at once
       if( $pageNumber - $backnos > 0 ) {
         // only calculate if we have passed the first half of the visible
         // entries, otherwise just use zero for the starting point
         $current = $pageNumber - $backnos; 
       }
       else { $current = 0; }
       if( $current + $activePages >= $number_of_pages ) {
         // if we are near the end, then back up the starting point to keep
         // our visible entries consistent
         $current = $number_of_pages - $activePages;
       }
       $maxrow = $current + $activePages;
     }
     else {
       // we will just display all of the pages
       $maxrow = $number_of_pages;
       $current = 0;
     }
     $this->addDebug('get_links', "Total pages: ".$number_of_pages,3);
     $this->addDebug('get_links', "Back Nos: ".$backnos,3);
     $this->addDebug('get_links', "Max Row: ".$maxrow,3);
     $this->addDebug('get_links', "Current: ".$current,3);
     $this->addDebug('get_links', "Row: ".$pageNumber,3);
     if( $number_of_pages == 1 ) { return array(); }
     if ( ($option == "all") || ($option == "sides") ) {
       if($pageNumber != 0) {
         $array[] = '<A title="'.$hk->tt('Prev').'" id="pagingPrevLink" HREF="' . $file 
          . '?pageNumber=' . ($pageNumber - 1) . $extra_vars . '">'.$prev.'</A>';
       }
       elseif ($pageNumber == 0 && $show_blank == "on") {
         $array[] = $prev;
       }
     }
     for ($current ; $current < $maxrow; $current++) {
       if ($option == "all" || $option == "pages") {
         if($pageNumber == $current) {
           $array[] = ($current > 0 ? ($current + 1) : 1);
         }
         else {
           $array[] = '<A HREF="' . $file . '?pageNumber=' . $current . $extra_vars . '">' . ($current + 1) . '</A>';
         }
       }
     }
     if ( ($option == "all" || $option == "sides") && $pageNumber != ($maxrow - 1) ) {
       $array[] = '<A title="'.$hk->tt('Next').'" id="pagingNextLink" HREF="' . $file . '?pageNumber=' . ($pageNumber + 1) . $extra_vars . '">' . $next . '</A>';
     }
     else if (($option == "all" || $option == "sides") && $pageNumber == $maxrow-1 && $show_blank == 'on') {
       $array[] = $next;
     }
     return $array;
  }
  
  /**
   * Retrieves the history of recently viewed items
   * @return ZenHistory
   */
  function &getHistoryManager() {
    if( !$this->_history ) {
      $this->_history = new ZenHistoryManager($this);
    }
    return $this->_history;
  }
  
  /** 
   * Returns an instance of the session manager
   *
   * @return ZenSessionManager
   */
   function &getSessionManager() { return $this->_session; }
  
  /*
  **  VARIABLES TO CONFIGURE (in config file)
  */

//////////////////////////////////////////////////////////////////////////////
//
  /**
   * returns list of Xoops Users
   *
   * if flag is set, retrieves a full list of users
   * otherwise, just users from Xoops not already in ZentrackXoops
   *
   * @param int $flag 1=returns list non-ZT users, 0=returns all Xoops users )
   * @return array of Xoops Users
   */
//
//
//////////////////////////////////////////////////////////////////////////////
    function getXoopsUsers($flag = 0) {
    if( $flag ) {
      
      // query database


//// This gets around pre MySQL v4.1 sub-query issues
      $query = "SELECT xu.uid, xu.uname, xu.email FROM ".$this->table_xoops_users ." xu ";
      $query .= " left join $this->table_users zu on xu.email = zu.email";
      $query .= " where zu.email IS NULL";

		$vars = $this->db_query($query);

      return( $this->db_queryIndexed($query) );
      
    } else {
      $query = "SELECT xu.uid, xu.uname, xu.email FROM ".$this->table_xoops_users ." xu ";
      $query .= " ORDER BY xu.email ASC";
      return( $this->db_queryIndexed($query) );
    }
  }
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////

  
  
  // usage vars
  var $user;
  var $access;
  var $ticket;
  var $id;
  var $date_format_long;
  var $date_format_short;

  // settings vars
  var $_settings;

  var $bins;
  var $priorities;
  var $systems;
  var $tasks;
  var $types;
  var $noteTypeID;
  var $custom_fields;
  var $language;
  var $strings;
  var $words;
  var $lastUsersBins;
  var $lastUsersID;


  // db vars   

  var $table_access;
  var $table_attachments;
  var $actions;
  var $table_bins;
  var $table_field_map;
  var $table_logs;   
  var $table_logs_archived;
  var $table_preferences;
  var $table_priorities;
  var $table_reports;
  var $table_reports_index;
  var $table_reports_temp;
  var $table_settings;
  var $table_systems;
  var $table_tasks;
  var $table_tickets;
  var $table_tickets_archived;
  var $table_types;
  var $table_users;
  var $table_notify_list;
  var $table_behavior;
  var $table_behavior_detail;
  var $table_group;
  var $table_group_detail;
  var $table_varfield;
  var $table_varfield_idx;

  
     
  var $table_agreement;
  var $table_agreement_item;
  var $table_company;
  var $table_employee;
  var $table_related_contacts;
  var $table_view_map;
  
  var $table_xoops_users;

  
  var $cleanTempReports;
  var $reportImageWidth;
  var $reportImageHeight;

  var $database_type;
  var $database_instance;
  var $database_login;
  var $database_password;
  var $database_host;

  // directory vars
  var $libDir;
  var $listDir;
  var $templateDir;
  var $attachmentsDir;

  // paging feature
   var $total_records;
  
  // others

  var $elapsed_unit;
  var $projectTypeID; 
  var $projectTypeIDs;
  var $demo_mode;
  
  // bug reports
  var $bugFrom;
  var $bugTo;
  
  // manages session and globals cache data, instance of ZenSessionManager
  var $_session;
  
  // manages history of viewed items
  var $_history;
  
  // multi_field seperator (for display use)
  var $multisep;

  // to be used in ticket update functions
  var $log_buffer;
}

?>
